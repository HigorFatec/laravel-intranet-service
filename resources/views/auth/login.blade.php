@extends('os.layout')
@section('title','Ordem de Serviço')
@section('conteudo')


<div class="row login-container">
    <div class="col s12 m6 offset-m3">
        {{-- Alertas --}}
        @if ($message = Session::get('success'))
        <div class="alerta card">
            <span class="card-title">Logout</span>
            <p>{{ $message }}</p>
        </div>
        @endif

        @if($mensagem = Session::get('erro'))
        <div class="erro">
            <strong>Erro:</strong> {{ $mensagem }}
        </div>
        @endif

        {{-- Formulário --}}
        <div class="card card-login">
            <div class="card-content">
                <span class="card-title card-title-login">Login</span>

                @if($errors->any())
                    <div class="erro">
                        @foreach($errors->all() as $error)
                            • {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <label for="matricula">Matrícula</label>
                    <input type="text" name="matricula" id="matricula" required>

                    <label for="password">Senha (somente para administradores)</label>
                    <input type="password" name="password" id="password">

                    <button type="submit" class="btn-cadastrar">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection