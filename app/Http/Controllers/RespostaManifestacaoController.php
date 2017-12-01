<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Hash;
class RespostaManifestacaoController extends ConfigController
{
    /*
     * Bloquear o prestador a ver a manifestacao apenas dele
     */
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
                    //maria -- 123
                    if($user->USUARIO_status == 1){
                        //Verificar se ele pode ver esta manifestacao
                        $usuario = $usuarioPDao->buscarId($user->USUARIO_id);
                        if($usuario == null){
                            $data["resp"] = "<div class='alert alert-danger'>Uusário sem acesso</div>";
                        }else{
                            
                            \Illuminate\Support\Facades\Session::put('prestador', $usuario);
                            //return redirect()->intended('manifestacao/17/5/respostaprestador.html');
                            return redirect()->intended('manifestacao/'.$ano.'/'.$idmanifestacao.'/respostaprestador.html');
                        }
                        
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
        $prest = \Illuminate\Support\Facades\Session::get('prestador');
        $idusuario = ($prest->USUARIO_id);
        
        $idprestador = $prest->USUARIO_PREST_idPrestador;
        $manifestacao = new \App\Manifestacao();
        $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
        $manif = $manifDao->buscarId($idmanifestacao, $ano);
        $data["idprestador"] = $idprestador;
        if($manif == null){
            return redirect()->intended('manifestacao/'.$ano.'/'.$idmanifestacao.'/prestador.html');
        }
        
        if($request->isMethod("POST")){
            
            $msgresposta = $request->input("msgresposta");
            $idmanif = $request->input("idmanif");
            $anomanif = $request->input("anomanif");
            $idservico = $request->input("idservico");
            
            $mensagemUsuario = new \App\MensagemUsuario();
            $mensagemUsuario->MSG_USUARIO_ano = date('Y');
            $mensagemUsuario->MSG_USUARIO_mensagem = $msgresposta;
            $mensagemUsuario->MSG_USUARIO_dataHoraMsg = date('Y-m-d H:i:s');
            $mensagemUsuario->MANIFESTACAO_id = $idmanif;
            $mensagemUsuario->MANIFESTACAO_MANIF_ano = $anomanif;
            $mensagemUsuario->SERVICOPRESTADOR_idServico = $idservico;
            $mensagemUsuario->SERVICOPRESTADOR_idPrestador = $idprestador;
            $mensagemUsuario->MSG_USUARIO_idUsuario = $idusuario;
              
            try{
                if($mensagemUsuario->save())
                    $data["resp"] = "<div class='alert alert-success'>Mensagem adicionada com sucesso!</div>";
                else
                    $data["resp"] = "<div class='alert alert-danger'>Mensagem não adicionada!</div>";
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-danger'>Mensagem não pode ser adicionada!</div>";
            }
            
            
        }
        $data["m"] = $manif;
        return view('admin.sistema.respostamanifestacao.respostaprestador', $data);
    }
    
    public function vertodas(Request $request){
        $data = array();
        $prest = \Illuminate\Support\Facades\Session::get('prestador');
        $idusuario = ($prest->USUARIO_id);
        
        $idprestador = $prest->USUARIO_PREST_idPrestador;
        $manifestacao = new \App\Manifestacao();
        $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
        
        return view('admin.sistema.respostamanifestacao.vertodas', $data);
    }
}
