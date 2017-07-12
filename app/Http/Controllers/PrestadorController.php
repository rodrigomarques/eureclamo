<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Hash;
class PrestadorController extends ConfigController
{
    public function cadastrar(Request $request){
        $data = array();
        $dbprestador = new \App\Prestador($this->dbname);
        $dbempresa = new \App\Empresa($this->dbname);
        $servico = new \App\Servico();
        
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        if($request->isMethod("POST")){
            try{
                $prestador = $dbprestador->wherePrestador_nome($request->input("nome"))->first();
                if($prestador == null){
                    $nome = $request->input("nome");
                    $cnpj = $request->input("cnpj");
                    $nomecompleto = $request->input("nomecompleto");
                    
                    $servivcos =  $request->input("servicos", array());

                    $nvprestador = new \App\Prestador();
                    $nvprestador->PRESTADOR_nome = $nome;
                    $nvprestador->PRESTADOR_nomeCompleto = $nomecompleto;
                    $nvprestador->PRESTADOR_cnpj = $cnpj;
                    
                    $dbname = $this->dbname;
                    \DB::connection($this->dbname)
                        ->
                        transaction(function() use($nvprestador, $servivcos, $dbname) {
                            $nvprestador->save();
                            if(count($servivcos) > 0){
                                foreach($servivcos as $sver){
                                    $servPrest = new \App\ServicoPrestador($dbname);
                                    $servPrest->SERVICO_PREST_idServico = $sver;
                                    $servPrest->SERVICO_PREST_idPrestador = $nvprestador->PRESTADOR_id;
                                    $servPrest->save();
                                }
                            }

                    });
                    
                    $data["resp"] = "<div class='alert alert-success'>Prestador cadastrado com sucesso!</div>";
                    
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Prestador ja cadastrado!</div>";
                }
            }  catch (\Exception $e){
                echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Prestador não cadastrado!</div>";
            }
        }
        
        $listaS = $servico->whereServico_status(1)->orderBy("SERVICO_nome")->get();
        $data["listaS"] = $listaS;
        
        return view('admin.sistema.prestador.cadastrar', $data);
    }
    
    public function buscar(Request $request){
        $data = array();
        $dbprestador = new \App\Prestador($this->dbname);
        $prestDao = new \App\Repository\PrestadorDao($dbprestador);
        if($request->isMethod("POST")){
            try{
                
                    $nome = $request->input("nome");
                    $cnpj = $request->input("cnpj");
                    
                    $lista = $prestDao->buscar($nome, $cnpj);
                    $data["lista"] = $lista;
                    
            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Prestador não encontrado!</div>";
            }
        }else{
            $lista = $prestDao->buscar("", "");
            $data["lista"] = $lista;
        }
        
        return view('admin.sistema.prestador.buscar', $data);
    }
    public function cadastrarperfil(Request $request){
        $data = array();
        $dbprestador = new \App\Prestador();
        if($request->isMethod("POST")){
            try{
                $dbperfil = new \App\PerfilPrestador();
                $perfil = $dbperfil->wherePerfil_prest_nomeAndPerfil_prest_idprestador($request->input("descricao"), $request->input("prestador"))->first();
                if($perfil == null){
                    $descricao = $request->input("descricao");
                    $prest = $request->input("prestador");
                        
                    $nvperfil = new \App\PerfilPrestador();
                    $nvperfil->PERFIL_PREST_nome = $descricao;
                    $nvperfil->PERFIL_PREST_idPrestador = $prest;

                    if($nvperfil->save()){
                        $data["resp"] = "<div class='alert alert-success'>Perfil do prestador cadastrado com sucesso!</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Perfil não cadastrado!</div>";
                    }
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Perfil ja cadastrado!</div>";
                }
            }  catch (\Exception $e){
                echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Perfil não cadastrado!</div>";
            }
        }
        $lista = $dbprestador->orderBy("PRESTADOR_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.prestador.perfil.cadastrar', $data);
    }
    
    public function buscarprestadorperfil(Request $request){
        $data = array();
        $dbprestador = new \App\Prestador();
        if($request->isMethod("POST")){
            try{
                
                $descricao = $request->input("descricao", "");
                $prestador = $request->input("prestador", "");
                
                $perfilPre = new \App\PerfilPrestador();
                $perfilPDao = new \App\Repository\PerfilPrestadorDao($perfilPre);

                $lista = $perfilPDao->buscar($descricao . "%", $prestador);
                $data["listaP"] = $lista;
                $data["desc"] = $descricao;
                $data["prestador"] = $prestador;
                    

            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Empresa não encontrada!</div>";
            }
            
        }
        $lista = $dbprestador->orderBy("PRESTADOR_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.prestador.perfil.buscar', $data);
    }
    
    public function cadastrarservico(Request $request){
        $data = array();
        //$dbprestador = new \App\Prestador();
        $servico = new \App\Servico();
        
        $dbempresa = new \App\Empresa();
        
        if($request->isMethod("POST")){
            try{
                //$prestadores = $request->input("prestadores", array());
                $prestadores = array();
                $nome = $request->input("nome", "");
                $grupo = $request->input("grupo", "");
                $descricao = $request->input("descricao", "");
                $empresa = $request->input("empresa", 0);
                
                $serv = $servico->whereServico_nome($nome)->first();
                
                if($serv == null){
                    //$emp = \App\Empresa::find($empresa);
                    $servico->SERVICO_nome = $nome;
                    $servico->SERVICO_grupo = $grupo;
                    $servico->SERVICO_descricao = $descricao;
                    $servico->SERVICO_status = 1;
                    $servico->SERVICO_EMPRESA_id = $empresa;
                    //$servico->empresa()->associate($emp);
                    
                    $dbname = \App\Config::$dbname;
                    
                    \DB::connection($dbname)
                        ->
                        transaction(function() use($servico, $prestadores, $dbname) {
                            $servico->save();
                            /*if(count($prestadores) > 0){
                                foreach($prestadores as $pre){
                                    $servPrest = new \App\ServicoPrestador();
                                    
                                    $servPrest->SERVICO_PREST_idPrestador = $pre;
                                    $servPrest->SERVICO_PREST_idServico = $servico->SERVICO_id;
                                    $servPrest->save();
                                }
                            }*/

                    });


                    $data["resp"] = "<div class='alert alert-success'>Serviço cadastrado com sucesso!</div>";
                }else{
                    $data["resp"] = "<div class='alert alert-warning'>Serviço já cadastrado!</div>";
                }
            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Serviço não cadastrado!</div>";
            }
            
        }
        //$listaS = $servico->orderBy("SERVICO_nome")->get();
        //$data["listaS"] = $listaS;
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.prestador.servico.cadastrar', $data);
    }
    
    //////
    
    public function buscarservico(Request $request){
        $data = array();
        $servico = new \App\Servico();
        
        $dbempresa = new \App\Empresa();
        $servicoDao = new \App\Repository\ServicoDao($servico);
        if($request->isMethod("POST")){
            try{
                
                $nome = $request->input("nome", "");
                $grupo = $request->input("grupo", "");
                $empresa = $request->input("empresa", 0);
                
            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Serviço não encontrado!</div>";
            }
            
        }else{
            $data["listaS"]  = $servicoDao->buscar("", "", "");
        }
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.prestador.servico.buscar', $data);
    }
    
    
    public function cadastrarusuario(Request $request){
        $data = array();
        $dbprest = new \App\Prestador();
        $lista = $dbprest->orderBy("PRESTADOR_nome")->get();
        
        $dbperfil = new \App\Perfil();
        $listaP = $dbperfil->orderBy("PERFIL_nome")->get();
        try{
            if($request->isMethod("POST")){
                
                $dbusuarioPrest = new \App\UsuarioPrestador();
                $dbusuario = new \App\Usuario();
                
                $usuarioprestador = $dbusuario->whereUsuario_login(
                        $request->input("login"))->first();
                if($usuarioprestador == null){
                    
                    $nome = $request->input("nome");
                    $email = $request->input("email");
                    $login = $request->input("login");
                    $senha = $request->input("senha");
                    $senha = Hash::make($senha);
                    $prestador = $request->input("prestador");
                    $perfil = $request->input("perfil");
                    $nivel = $request->input("nivel");
                    $tipo = "PRESTADOR";
                    
                    $nvusuarioprestador = new \App\Usuario();
                    $nvusuarioprestador->USUARIO_nome = $nome;
                    $nvusuarioprestador->USUARIO_email = $email;
                    $nvusuarioprestador->USUARIO_login = $login;
                    $nvusuarioprestador->password = $senha;
                    $nvusuarioprestador->USUARIO_nivel = $nivel;
                    $nvusuarioprestador->USUARIO_tipo = $tipo;
                    $nvusuarioprestador->USUARIO_PERFIL_id = $perfil;
                    $nvusuarioprestador->USUARIO_status = 1;

                    if($nvusuarioprestador->save()){
                        $nvusuarioprestador2 = new \App\UsuarioPrestador();
                        $nvusuarioprestador2->USUARIO_PREST_idPrestador = $prestador;
                        $nvusuarioprestador2->USUARIO_PREST_idUsuario = $nvusuarioprestador->USUARIO_id;
                        
                        $nvusuarioprestador2->save();
                                
                        $data["resp"] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Usuário não cadastrado!</div>";
                    }
                    
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Usuario ja cadastrado!</div>";
                }
            }
        } catch (Exception $ex) {
            $data["resp"] = "<div class='alert alert-danger'>Usuário não cadastrado!</div>";
        }
        
        $data["lista"] = $lista;
        $data["listaP"] = $listaP;
        return view('admin.sistema.prestador.usuario.cadastrar', $data);
    }
    
    public function buscarperfil(Request $request){
        $id = $request->input("idprest");
        
        $perfilPrestador = new \App\PerfilPrestador();
        $prestador = $perfilPrestador->wherePerfil_prest_idprestador($id)->get();
        
        if(count($prestador) > 0){
            echo "Perfil: ";
            
            echo "<select required name='perfil' id='perfil' class='form-control'>";
            foreach ($prestador as $per){
                echo "<option value='" . $per->PERFIL_PREST_id. "'>".$per->PERFIL_PREST_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "Perfil: ";
            
            echo "<select required name='perfil' id='perfil' class='form-control'>";
                echo "<option value=''></option>";
            echo "</select>";
            
            echo "<div class='alert alert-warning'>Não existe perfil para este prestador!</div>";
        }
    }
    
    public function buscarusuario(Request $request){
        $data = array();
        $usuarioPrestador = new \App\UsuarioPrestador();
        $usuarioPDao = new \App\Repository\UsuarioPrestadorDao($usuarioPrestador);
        if($request->isMethod("POST")){
            try{
                
                $nome = $request->input("nome", "");
                $email = $request->input("email", "");
                $login = $request->input("login", "");

                $lista = $usuarioPDao->buscar($nome . "%", $login . "%", $email . "%");
                $data["listaP"] = $lista;
                $data["nome"] = $nome;
                $data["login"] = $login;
                $data["email"] = $email;
                    

            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Usuário não encontrada!</div>";
            }
            
        }else{
            $lista = $usuarioPDao->buscar("%", "%", "%");
            $data["listaP"] = $lista;
        }
        
        return view('admin.sistema.prestador.usuario.buscar', $data);
    }
    
    public function alterarservico($id, Request $request){
        $data = array();
        try{
            $servico = new \App\Servico();
        
            $dbempresa = new \App\Empresa();
            $servicoDao = new \App\Repository\ServicoDao($servico);
            
            $serv = \App\Servico::find($id);
            
            if($serv == null){
                $data["resp"] = "<div class='alert alert-warning'>Serviço não encontrado!</div>";
                $data["listaS"]  = $servicoDao->buscar("", "", "");
                $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
                $data["lista"] = $lista;
                return view('admin.sistema.prestador.servico.buscar', $data);
            }
            
            if($serv->SERVICO_status == 1)
                $serv->SERVICO_status = 0;
            else
                $serv->SERVICO_status = 1;
            
            if($serv->save()){
                if($serv->SERVICO_status == 1)
                $data["resp"] = "<div class='alert alert-success'>Prestador ativado  com sucesso!</div>";
                else
                $data["resp"] = "<div class='alert alert-success'>Prestador cancelado com sucesso!</div>";
            }else{
                $data["resp"] = "<div class='alert alert-danger'>Prestador não editado!</div>";
            }
        }  catch (\Exception $e){
            //echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Prestador não alterado!</div>";
        }
        
        $data["listaS"]  = $servicoDao->buscar("", "", "");
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.prestador.servico.buscar', $data);
    }
    
    public function detalhesservico($id){
        $data = array();
        
        $servico = new \App\Servico();
        $servicoDao = new \App\Repository\ServicoDao($servico);
        $serv = \App\Servico::find($id);
        
        $data["servico"] = $serv;
            
        return view('admin.sistema.prestador.servico.detalhes', $data);
    }
    
    public function excluirusuario($id, Request $request){
        $data = array();
        try{
            $usuarioEmpresa = \App\Usuario::find($id);
            
            if($usuarioEmpresa == null){
                $data["resp"] = "<div class='alert alert-warning'>Usuario do prestador não encontrado!</div>";
                return view('admin.sistema.prestador.usuario.buscar', $data);
            }
            
            if($usuarioEmpresa->USUARIO_status == 1)
                $usuarioEmpresa->USUARIO_status = 0;
            else
                $usuarioEmpresa->USUARIO_status = 1;
            
            if($usuarioEmpresa->save()){
                if($usuarioEmpresa->USUARIO_status == 1)
                $data["resp"] = "<div class='alert alert-success'>Usuario do prestador ativado com sucesso!</div>";
                else
                $data["resp"] = "<div class='alert alert-success'>Usuário do prestador excluído com sucesso!</div>";
            }else{
                $data["resp"] = "<div class='alert alert-danger'>Usuário prestador não editado!</div>";
            }
            
            $usuarioPrestador = new \App\UsuarioPrestador();
            $usuarioPDao = new \App\Repository\UsuarioPrestadorDao($usuarioPrestador);

            $lista = $usuarioPDao->buscar("%", "%", "%");
            $data["listaP"] = $lista;
        }  catch (\Exceptionus $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Usuário prestador não alterado!</div>";
        }
        
        
        return view('admin.sistema.prestador.usuario.buscar', $data);
    }
    
}
