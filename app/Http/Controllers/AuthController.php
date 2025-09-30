<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserCredential;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }



    public function login(Request $request)
    {
        $request->validate([
            'matricula' => 'required',
            'password' => 'nullable|string',
        ]);

        // Verifica se existe no SQL Server
        $user = User::where('CODFUN', $request->matricula)->first();

        if (!$user) {
            return back()->withErrors(['matricula' => 'Matrícula inválida']);
        }

        // Busca no MySQL as credenciais extras
        $cred = UserCredential::where('matricula', $request->matricula)->first();

        if ($cred && $cred->is_admin) {
            // Se for admin, senha obrigatória
            $request->validate([
                'password' => 'required|string',
            ]);

            if (!Hash::check($request->password, $cred->password)) {
                return back()->withErrors(['password' => 'Senha incorreta']);
            }
        }

        // Se não é admin, ou senha confere, faz login
        Auth::login($user);

        return redirect()->route('dashboard');
    }



    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
