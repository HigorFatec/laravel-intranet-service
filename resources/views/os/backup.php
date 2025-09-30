@extends('os.layout')
@section('title','Ordem de Serviço')
@section('conteudo')

<div class="row">
    <div class="col s12 m8 offset-m2">

        @if ($message = Session::get('success'))
        <div class="card green darken-1">
          <div class="card-content white-text">
            <span class="card-title">Serviço Atualizado</span>
            <p>O serviço foi atualizado com sucesso!</p>
          </div>
        </div>
        @endif

        @if ($message = Session::get('success2'))
        <div class="card green darken-1">
          <div class="card-content white-text">
            <span class="card-title">Serviço Atribuído</span>
            <p>O serviço foi atribuído com sucesso!</p>
          </div>
        </div>
        @endif

        <div class="card">
            <div class="card-content">

                <div class="row" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap;">
                    {{-- Campo de busca à esquerda --}}
                    <form method="GET" action="{{ route('dashboard') }}" id="form-busca" style="display: flex; align-items: center; gap: 10px; flex: 1; max-width: 150px;">
                        <div class="input-field" style="margin: 0; width: 100%; position: relative;">
                            <i 
                                class="material-icons prefix" 
                                style="color: #184693; cursor: pointer; position: absolute; left: 0; top: 50%; transform: translateY(-50%);"
                                onclick="document.getElementById('form-busca').submit();"
                            >search</i>
                            <input 
                                type="text" 
                                name="ordem" 
                                id="ordem" 
                                value="{{ request('ordem') }}" 
                                class="validate" 
                                style="padding-left: 40px; border-bottom: 2px solid #184693;"
                            >
                            <label for="ordem">Buscar</label>
                        </div>
                    </form>
                    {{-- Título centralizado --}}
                    <div style="flex: 2; text-align: center;">
                        <h4 style="color: #184693; font-weight: bold; margin: 0;">
                            <i class="material-icons left" style="font-size: 1.8rem;">assignment</i>
                            Serviços Atribuídos
                        </h4>
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Formulário para atribuição de serviços selecionados --}}
                <form action="{{ route('site.assignSelectedServices') }}" method="POST">
                    @csrf
                    <table border="1" cellpadding="8" cellspacing="0">
                        <thead>
                            <tr>
                                @if($isAdmin)
                                <th></th> <!-- Coluna para o checkbox -->
                                @endif
                                <th>Ordem</th>
                                <th>Placa</th>
                                <th>Criado</th>
                                <th>Previsão</th>
                                <th>Sequência</th>
                                <th>Codigo</th>
                                <th>Item Revisional</th>
                                <th>Manutenção</th>
                                <th>Visualizar</th>
                                @if($isAdmin)
                                    <th>Atribuir OS</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ordens as $ordem)
                                <tr>
                                    @if($isAdmin)
                                    <td>
                                        <label>
                                            <input type="checkbox" name="servicos[]" value="{{ $ordem->ORDEM }}|{{ $ordem->Cod_Item }}" />
                                            <span></span>
                                        </label>
                                    </td>
                                    @endif
                                    <td>{{ $ordem->ORDEM }}</td>
                                    <td>{{ $ordem->PLACA }}</td>
                                    <td>{{ $ordem->CRIADO }}</td>
                                    <td>{{ $ordem->PREVISAO }}</td>
                                    <td>{{ $ordem->SEQUENCIA }}</td>
                                    <td>{{ $ordem->Cod_Item }}</td>
                                    <td>{{ $ordem->Item_Revisional }}</td>
                                    <td>{{ $ordem->MANUTENCAO }}</td>
                                    <td>
                                        <a href="{{ route('site.details', ['codord' => $ordem->ORDEM, 'codire' => $ordem->Cod_Item]) }}" class="btn btn-primary blue">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                    </td>
                                    @if($isAdmin)
                                        <td>
                                            <a href="{{ route('site.assignOs', ['codord' => $ordem->ORDEM]) }}" class="btn btn-success green" title="Atribuir OS inteira">
                                                <i class="material-icons">person_add</i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($isAdmin)
                    <div class="row" style="margin-top: 30px;">
                        <div class="col s12 m6">
                            <div class="input-field">
                                <i class="material-icons prefix" style="color: #184693;">badge</i>
                                <input type="text" name="matricula" id="matricula" class="validate" required>
                                <label for="matricula">Matrícula do Funcionário</label>
                            </div>
                        </div>
                        <div class="col s12 m6 center-align" style="display: flex; align-items: center; justify-content: center;">
                            <button type="submit" class="btn green btn-large" style="width: 100%; max-width: 250px;">
                                <i class="material-icons left">check_circle</i>
                                Atribuir Selecionados
                            </button>
                        </div>
                    </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
</div>

@endsection