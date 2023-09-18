<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(Request $request){

        $credenciais = $request->all(['email', 'password']);


        //autenticação (email e senha)
        $token = auth('api')->attempt($credenciais);

        if ($token) {
            return response()->json(['token' => $token]);
        }else{
            return response()->json(['erro' => 'Usuário ou senha inválido!'], 403);

            //erro 401 = Unauthorizad -> não autorizado
            //erro 403 = Forbidden -> proibido (login inválido)
        }


        return 'login';
    }

    public function logout(){
        return 'logout';
    }

    public function refresh(){
        return 'refresh';
    }

    public function me(){
        return response()->json(auth()->user());
    }
}
