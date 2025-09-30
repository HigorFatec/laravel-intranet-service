@extends('os.layout')
@section('title','Detalhes da Ordem de Serviço')
@section('conteudo')


<div class="row">

@if($isAdmin)
<div class="col s12 m8 offset-m2">
    <div class="card">
        <div class="card-content">
            <span class="card-title center"><b>Atribuir Serviço da Ordem #{{ $ordem->ORDEM }}</b></span>
            <p class='center'><b>{{ $ordem->Item_Revisional }}</b></p>
            <p class='center'>Atenção <b class="red-text center">Administrador</b>, atribua o Serviço da Ordem a um funcionário inserindo o número da matricula.</p>

            <form method="POST" action="{{ route('os.assign', ['codord' => $ordem->ORDEM, 'codire' => $ordem->Cod_Item]) }}">
                @csrf

                <div class="input-field">
                    <input type="text" name="matricula" id="matricula" required>
                    <label for="matricula">Digite a Matrícula do Funcionário</label>
                </div>

                <div class="center">
                    <button type="submit" class="btn blue btn-large">Atribuir Serviço</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endif
<div class="col s12 m8 offset-m2">
    <div class="card">
        <div class="card-content">
            <span class="card-title center"><b>Situação da Ordem de Serviço</b></span>
            <div style="margin: 30px 0;">
                <p><b>Status:</b> {{ $ordem->status }}</p>

                <div class="progress">
                    <div class="determinate {{ $ordem->progress_color }}" style="width: {{ $ordem->progress }}%"></div>
                </div>
            </div>

        </div>
    </div>
</div>

    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">
                <span class="card-title center"><b>Detalhes da Ordem de Serviço</b></span>
                <p><b>Ordem:</b> {{ $ordem->ORDEM }}</p>
                <p><b>Filial:</b> {{ $ordem->FILIAL }}</p>
                <p><b>Matrícula:</b> {{ $ordem->MATRICULA }}</p>
                <p><b>Placa:</b> {{ $ordem->PLACA }}</p>
                <p><b>Criado:</b> {{ $ordem->CRIADO }}</p>
                <p><b>Previsão:</b> {{ $ordem->PREVISAO }}</p>
                <p><b>Autorizado:</b> {{ $ordem->AUTORIZADO }}</p>
                <p><b>Cód. Item:</b> {{ $ordem->Cod_Item }}</p>
                <p><b>Sequência:</b> {{ $ordem->SEQUENCIA }}</p>
                <p><b>Item Revisional:</b> {{ $ordem->Item_Revisional }}</p>
                <p><b>Manutenção:</b> {{ $ordem->MANUTENCAO }}</p>
                <p><b>Criado por:</b> {{ $ordem->Criado_por }}</p><br>


                <div class="center">
                    @if($ordem->status == 'Pendente')
                        <form method="POST" action="{{ route('os.start', ['codord' => $ordem->ORDEM, 'codire' => $ordem->Cod_Item]) }}" style="display:inline">
                            @csrf
                            <button class="btn-large green">Iniciar Serviço</button>
                        </form>
                    @endif
                    @if($ordem->status != 'Finalizada' && $ordem->status != 'Pendente' && $ordem->status != 'Em Pausa')
                            <form method="POST" action="{{ route('os.finish', ['codord' => $ordem->ORDEM, 'codire' => $ordem->Cod_Item]) }}" style="display:inline">
                                @csrf
                                <button class="btn-large red">Finalizar Serviço</button>
                            </form>
                    @endif
                    
                </div>

            </div>
        </div>
    </div>
    @if($ordem->status != 'Finalizada')

    @if($assignment && $assignment->start_time && !$assignment->end_time)

    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">
                    <div class='center'>


                    
                    @if($assignment && $assignment->pauses->whereNull('end_time')->count())

                        @foreach($assignment->pauses->whereNull('end_time') as $pause)
                            <form method="POST" action="{{ route('os.resume', ['codord' => $ordem->ORDEM, 'codire' => $ordem->Cod_Item]) }}" style="display:inline">
                                @csrf
                                <button class="btn-large blue">Finalizar Pausa</button>
                            </form>
                        @endforeach
                    @else
                        <form method="POST" action="{{ route('os.pause', ['codord' => $ordem->ORDEM, 'codire' => $ordem->Cod_Item]) }}" style="display:inline">
                        @csrf
                        <div class="input-field" style="width:200px; display:inline-block; margin-right:10px;">
                            <input type="text" name="reason_code" id="reason_code" required>
                            <label for="reason_code">Código do Motivo</label>
                        </div>

                        <button class="btn-large orange" type="submit">Iniciar Pausa</button>
                    </form>
                    @endif
</div>

                    <!-- Lista de motivos fixos -->
                    <div style="margin-top:10px; text-align:left;">
                        <p><b>Motivos de Pausa:</b></p>
                        <ul class="collection">
                            <li class="collection-item">01 - Almoço</li>
                            <li class="collection-item">02 - Falta de peça</li>
                            <li class="collection-item">03 - Manutenção de máquina</li>
                            <li class="collection-item">04 - Espera técnica</li>
                            <li class="collection-item">05 - Outro motivo</li>
                        </ul>
                    </div>




                





            </div>
        </div>
    </div>
    @endif
    @endif

@endsection