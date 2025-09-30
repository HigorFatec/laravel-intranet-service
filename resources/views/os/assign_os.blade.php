@extends('os.layout')
@section('title','Atribuir Ordem de Serviço')
@section('conteudo')

<div class="row">

<div class="col s12 m8 offset-m2">
    <div class="card">
        <div class="card-content">

    <span class="card-title center"><b>Atribuir Ordem de Serviço #{{ $codord }}</b></span>
    <p class='center'>Atenção <b class="red-text center">Administrador</b>, atribua a Ordem de Serviço <b>Inteira</b> a um funcionário inserindo o número da matricula.</p>

    <p class='center'><b>Obs: Esse processo é irreversivel, portanto não será possível reverter a atribuição.</b></p>

    <form action="{{ route('site.assignOs.submit', ['codord' => $codord]) }}" method="POST">
        @csrf
        <div class="input-field">
                <div class="input-field">
                    <label for="mecanico_id">Digite a Matrícula do Funcionário</label>
                    <input type="text" name="mecanico_id" id="mecanico_id" required>
                </div>
        </div>
        <div class="center">
            <button type="submit" class="btn red darken-1 btn-large">Atribuir OS</button>
        </div>
    </form>

        </div>
    </div>
</div>
</div>


@endsection