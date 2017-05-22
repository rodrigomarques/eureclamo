<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Hash;
class RespostaManifestacaoController extends ConfigController
{
    public function login($ano, $idmanifestacao, Request $request){
        $data = array();
        
        if($request->isMethod("POST")){
            try{
                $usuarioPDao = new \App\Repository\UsuarioPrestadorDao(new \App\UsuarioPrestador);
                $usuario = $request->input("usuario");
                $password = ($request->input("password"));
                $credential = [
                'USUARIO_login' => $usuario, 'password' => ($password)
                ];
                if(Auth::attempt($credential, true)){
                    $user = Auth::user();
                    if($user->USUARIO_status == 1){
                        //Verificar se ele pode ver esta manifestacao
                        $usuario = $usuarioPDao->buscarId($user->USUARIO_id);
                        \Illuminate\Support\Facades\Session::put('prestador', $usuario);
                        return redirect()->intended('manifestacao/17/5/respostaprestador.html');
                        
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Uusário sem acesso</div>";
                    }
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Uusário inválido</div>";
                }
            }catch (\Exception $ex) {
                //echo $ex->getMessage();
                $data["resp"] = "<div class='alert alert-danger'></div>";
            }
        }
        
        return view('admin.sistema.respostamanifestacao.login', $data);
    }
    
    public function respostaprestador($ano, $idmanifestacao, Request $request){
        $data = array();
        $manifestacao = new \App\Manifestacao();
        $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
        $manif = $manifDao->buscarId($idmanifestacao, $ano);
        
        $data["m"] = $manif;
        return view('admin.sistema.respostamanifestacao.respostaprestador', $data);
    }
}
