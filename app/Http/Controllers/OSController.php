<?php

namespace App\Http\Controllers;

use App\Models\OS;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OSAssignment;
use App\Models\UserCredential;
use App\Models\OSPause;


class OSController extends Controller
{
    /**
     * Display a listing of the resource.
     */



public function index()
{
    $codfun = Auth::user()->CODFUN;
    $ordemBusca = request('ordem') ?: null;
    $placaBusca = request('placa') ?: null;


    $credencial = UserCredential::where('matricula', $codfun)->first();
    $isAdmin = $credencial && $credencial->is_admin;

    if ($isAdmin) {
        $ordensQuery = OS::getByMatriculaQuery($codfun)
            ->orderBy('O.DATREF', 'desc');

        if ($ordemBusca || $placaBusca) {
            $ordensQuery->where(function ($query) use ($ordemBusca, $placaBusca) {
                if ($ordemBusca) {
                    $query->where('O.CODORD', $ordemBusca);
                }
                if ($placaBusca) {
                    $query->orWhere('O.CODVEI', $placaBusca);
                }
            });
        }


        $ordens = $ordensQuery->get();

        $assignments = OSAssignment::on('mysql')
            ->whereIn('os_id', $ordens->pluck('ORDEM'))
            ->get();

        return view('os.index', compact('ordens', 'assignments', 'isAdmin'));
    } else {
        $assignments = OSAssignment::on('mysql')
            ->where('matricula', $codfun)
            ->whereNull('finish_time')
            ->get();

        $ordensQuery = OS::getByMatriculaQuery($codfun);

        if ($assignments->isNotEmpty()) {
            $ordensQuery->where(function ($query) use ($assignments) {
                foreach ($assignments as $assignment) {
                    $query->orWhere(function ($sub) use ($assignment) {
                        $sub->where('O.CODORD', $assignment->os_id)
                            ->where('IOS.CODIRE', $assignment->codire); // 🟨 Adicionando filtro de codire
                    });
                }
            });
        } else {
            $ordensQuery->whereRaw('1 = 0');
        }

        if ($ordemBusca || $placaBusca) {
            $ordensQuery->where(function ($query) use ($ordemBusca, $placaBusca) {
                if ($ordemBusca) {
                    $query->where('O.CODORD', $ordemBusca);
                }
                if ($placaBusca) {
                    $query->orWhere('O.CODVEI', $placaBusca);
                }
            });
        }

        $ordens = $ordensQuery
            ->orderBy('O.DATREF', 'desc')
            ->get();

        return view('os.index', compact('ordens', 'isAdmin'));
    }
}


    // Método para atribuir serviços selecionados
    public function assignSelectedServices(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string',
            'servicos' => 'required|array|min:1',
        ]);

        $matricula = $request->input('matricula');
        $servicos = $request->input('servicos', []);

        foreach ($servicos as $servico) {
            [$os_id, $codire] = explode('|', $servico);
            OSAssignment::create(
                [
                    'os_id' => $os_id,
                    'codire' => $codire,
                    'matricula' => $matricula,
                ]
            );
        }

        return redirect()->route('dashboard')->with('success2', 'Serviços atribuídos com sucesso!');
    }

    /**
     * Show the form for creating a new resource.
     */


    public function details($codord, $codire)
    {
        $ordem = OS::getByOrdemSequencia($codord, $codire)->first();

        $funcionarios = Funcionario::all();

        // Pega o status APENAS pra essa OS
        $assignment = \App\Models\OSAssignment::with('pauses')
            ->where('matricula', Auth::user()->CODFUN)
            ->where('os_id', $ordem->ORDEM)
            ->where('codire', $ordem->Cod_Item) // 🟨 Adicionando filtro de codire
            ->first();


        if ($assignment) {
            if ($assignment->finish_time) {
                $ordem->status = 'Finalizada';
                $ordem->progress = 100;
                $ordem->progress_color = 'green';
            } elseif ($assignment->pause_time && !$assignment->resume_time) {
                $ordem->status = 'Em Pausa';
                $ordem->progress = 50;
                $ordem->progress_color = 'orange';
            } elseif ($assignment->resume_time) {
                $ordem->status = 'Em Execução';
                $ordem->progress = 75;
                $ordem->progress_color = 'blue';
            } elseif ($assignment->start_time) {
                $ordem->status = 'Iniciada';
                $ordem->progress = 25;
                $ordem->progress_color = 'blue';
            } else {
                $ordem->status = 'Pendente';
                $ordem->progress = 0;
                $ordem->progress_color = 'grey';
            }
        } else {
            $ordem->status = 'Pendente';
            $ordem->progress = 0;
            $ordem->progress_color = 'grey';
        }


        return view('os.details', compact('ordem', 'funcionarios','assignment'));
    }



    public function assign(Request $request, $codord, $codire)
    {
        // Validação básica
        $request->validate([
            'matricula' => 'required|string',
        ]);

        // Cria o registro de atribuição
        OSAssignment::create([
            'matricula' => $request->matricula,
            'os_id' => $codord,  // ou use seu ID real da O.S.
            'codire' => $codire, // 👈 Armazena o codire!

        ]);

        return redirect()->route('dashboard')->with('success2', 'Ordem de Serviço atribuída com sucesso!');
    }




    public function updateStatus(Request $request, $codord, $codire)
{
    $request->validate(['action' => 'required|string']);

    $assignment = OSAssignment::where('os_id', $codord)->first();
    if (!$assignment) {
        return back()->with('error', 'OS não atribuída ainda.');
    }

    switch ($request->action) {
        case 'start':
            $assignment->start_time = now();
            break;
        case 'pause':
            $assignment->pause_time = now();
            break;
        case 'resume':
            $assignment->resume_time = now();
            break;
        case 'finish':
            $assignment->finish_time = now();
            break;
    }

    $assignment->save();

    return redirect()->route('dashboard')->with('success', 'Status atualizado: ' . $request->action);
}



public function start($codord, $codire)
{
    $codfun = Auth::user()->CODFUN;

    OSAssignment::where('matricula', $codfun)
        ->where('os_id', $codord)
        ->where('codire', $codire) // 🟨 Adicionando filtro de codire
        ->update(['start_time' => now()]);

    return redirect()->route('dashboard')->with('success', 'Ordem de Serviço iniciada.');
}

public function pause(Request $request, $codord, $codire)
{

        $codfun = Auth::user()->CODFUN;

    $request->validate([
        'reason_code' => 'required',
    ]);

    // Recupera ou cria o assignment
    $assignment = OSAssignment::where('os_id', $codord)
        ->where('matricula', Auth::user()->CODFUN)
        ->where('codire', $codire) // 🟨 Adicionando filtro de codire
        ->firstOrFail();

    // Próximo número de pausa
    $pauseNumber = OSPause::where('assignment_id', $assignment->id)->count() + 1;

    OSPause::create([
        'assignment_id' => $assignment->id,
        'pause_number' => $pauseNumber,
        'reason_code' => $request->reason_code,
        'start_time' => now(),
    ]);

    
    OSAssignment::where('matricula', $codfun)
        ->where('os_id', $codord)
        ->where('codire', $codire) // 🟨 Adicionando filtro de codire
        ->update(['pause_time' => now()]);

    OSAssignment::where('matricula', $codfun)
        ->where('os_id', $codord)
        ->where('codire', $codire) // 🟨 Adicionando filtro de codire
        ->update(['resume_time' => null]);

    return redirect()->route('dashboard')->with('success', 'Pausa iniciada!');
}

public function resume($codord, $codire)
{
    $codfun = Auth::user()->CODFUN;

    OSAssignment::where('matricula', $codfun)
        ->where('os_id', $codord)
        ->where('codire', $codire) // 🟨 Adicionando filtro de codire
        ->update(['resume_time' => now()]);

    // Buscar a última pausa aberta (sem end_time) para este usuário, OS e sequência
    $pause = \App\Models\OSPause::where('assignment_id', function ($query) use ($codfun, $codord, $codire) {
            $query->select('id')
                ->from('os_assignments')
                ->where('matricula', $codfun)
                ->where('os_id', $codord)
                ->where('codire', $codire)
                ->limit(1);
        })
        ->whereNull('end_time')
        ->orderBy('start_time', 'desc')
        ->first();

    if ($pause) {
        $pause->end_time = now();
        $pause->save();
        return redirect()->route('dashboard')->with('success', 'Pausa finalizada com sucesso!');
    }



    return back()->with('error', 'Nenhuma pausa ativa encontrada para finalizar.');
}

public function finish($codord, $codire)
{
    $codfun = Auth::user()->CODFUN;

    OSAssignment::where('matricula', $codfun)
        ->where('os_id', $codord)
        ->where('codire', $codire) // 🟨 Adicionando filtro de codire
        ->update(['finish_time' => now()]);

    return redirect()->route('dashboard')->with('success', 'Ordem de Serviço finalizada.');
}




public function showAssignOsForm($codord) {
    $mecanicos = Funcionario::all();
    // dd($mecanicos);
    return view('os.assign_os', compact('codord', 'mecanicos'));
}

public function assignOsToMechanic(Request $request, $codord) {
    $mecanicoId = $request->input('mecanico_id');
    // Busque todos os serviços da OS
    $servicos = OS::getByApenasOrdem($codord)->get();
    foreach ($servicos as $servico) {
        // Crie o assignment para cada serviço
        OSAssignment::updateOrCreate(
            [
                'os_id' => $servico->ORDEM,
                'codire' => $servico->Cod_Item,
            ],
            [
                'matricula' => $mecanicoId,
            ]
        );
    }
    return redirect()->route('dashboard')->with('success2', 'Ordem de serviço atribuída com sucesso!');
}




}
