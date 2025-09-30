@extends('os.layout')
@section('title','Painel Administrador')

@section('conteudo')
<div class="row">
    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">


                    <h2>Criar Novo Administrador</h2>

                    @if(session('success'))
                        <div style="color: green;">{{ session('success') }}</div>
                    @endif

            <form method="POST" action="{{ route('admin.create') }}" enctype="multipart/form-data">
                @csrf

                        Matrícula:<br>
                        <input type="text" name="matricula" required><br><br>

                        Senha:<br>
                        <input type="password" name="password" required><br><br>

                        Nível do administrador:<br>
                        <label>
                            <input type="radio" name="admin_level" value="1" checked>
                            <span style="color: black">Administrador Nível 1</span>
                        </label>

                        <label>
                            <input type="radio" name="admin_level" value="2">
                            <span style="color: black">Administrador Nível 2</span>
                        </label>



                        <div class="center">
                            <button class="btn-large " type="submit">Criar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
