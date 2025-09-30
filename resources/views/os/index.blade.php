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
<form method="GET" action="{{ route('dashboard') }}" id="form-busca" style="display: flex; align-items: center; gap: 10px;">
    
    {{-- Busca por ordem --}}
    <div class="input-field" style="margin: 0; width: 120px; position: relative;">
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
        <label for="ordem">Ordem</label>
    </div>

    {{-- Busca por placa --}}
    <div class="input-field" style="margin: 0; width: 120px; position: relative;">
        <input 
            type="text" 
            name="placa" 
            id="placa" 
            value="{{ request('placa') }}" 
            class="validate" 
            style="border-bottom: 2px solid #184693;"
        >
        <label for="placa">Placa</label>
    </div>

    {{-- Botão de buscar --}}
    <button type="submit" class="btn" style="background-color: #184693; color: #fff;">Buscar</button>
</form>

                    {{-- Título centralizado --}}
                    <div style="flex: 2; text-align: center;">
                        @if($isAdmin)
                        <h4 style="color: #184693; font-weight: bold; margin: 0;">
                            Atividades de Manutenção para Atribuição
                        </h4>

                        @else
                        <h4 style="color: #184693; font-weight: bold; margin: 0;">
                            Atividades de Manutenção Atribuídos
                        </h4>
                        @endif
                    </div>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Formulário para atribuição de serviços selecionados --}}
                <form action="{{ route('site.assignSelectedServices') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                    <table class="hightlight centered">
                        <thead>
                            <tr>
                                @if($isAdmin)
                                <th></th> <!-- Coluna para o checkbox -->
                                @endif
                                <th>Ordem</th>
                                <th>Placa</th>
                                <th>Criado</th>
                                <th>Previsão</th>
                                <th>Codigo</th>
                                <th>Item Revisional</th>
                                {{-- <th>Manutenção</th> --}}
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
                                    <td>{{ $ordem->Cod_Item }}</td>
                                    <td>{{ $ordem->Item_Revisional }}</td>
                                    {{-- <td>{{ $ordem->MANUTENCAO }}</td> --}}
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
                    </div>

                    {{-- Botão de atribuição fixo no canto superior direito --}}
@if($isAdmin)
<div id="atribuir-fixo" style="
    position: fixed;
    top: 80px;
    right: 10px;
    width: 250px;
    z-index: 9999;
">
    <div class="card">
        <div class="card-content">
            <h4 style="color: #184693; font-weight: bold; margin: 0; font-size: 1.5rem;">
                Atribuir Seleção
            </h4>


            <div class="input-field">
                <i class="material-icons prefix" style="color: #184693;">badge</i>
                <input type="text" name="matricula" id="matricula" class="validate" required>
                <label for="matricula">Matrícula do Funcionário</label>
            </div>
            <div class="center-align" style="margin-top: 20px;">
                <button type="submit" class="btn green btn-large" style="width: 100%; max-width: 250px;">
                    <i class="material-icons left">check_circle</i>
                    Atribuir Selecionados
                </button>
            </div>
        </div>
    </div>
</div>
@endif
                </form>

            </div>
        </div>
    </div>
</div>

@endsection