<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Hash;
class EmpresaController extends ConfigController
{
    public function cadastrar(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa($this->dbname);
        if($request->isMethod("POST")){
            try{
                $empresa = $dbempresa->whereEmpresa_nome($request->input("razao"))->first();
                if($empresa == null){
                    $razao = $request->input("razao");
                    $fantasia = $request->input("fantasia");
                    $cnpj = $request->input("cnpj");
                    $sigla = $request->input("sigla");

                    $nvempresa = new \App\Empresa($this->dbname);
                    $nvempresa->EMPRESA_nome = $fantasia;
                    $nvempresa->EMPRESA_nomeCompleto = $razao;
                    $nvempresa->EMPRESA_cnpj = $cnpj;
                    $nvempresa->EMPRESA_sigla = $sigla;
                    

                    if($nvempresa->save()){
                        $data["resp"] = "<div class='alert alert-success'>Empresa cadastrada com sucesso!</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Empresa não cadastrado!</div>";
                    }
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Empresa ja cadastrado!</div>";
                }
            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Empresa não cadastrado!</div>";
            }
        }
        //$lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        //$data["lista"] = $lista;
        return view('admin.sistema.empresa.cadastrar', $data);
    }
    
    public function buscar(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        $empresaDao = new \App\Repository\EmpresaDao($dbempresa);
        if($request->isMethod("POST")){
            try{
                
                $razao = $request->input("razao");
                $fantasia = $request->input("fantasia");
                $cnpj = $request->input("cnpj");
                $sigla = $request->input("sigla");
                
                $lista = $empresaDao->buscar($fantasia, $razao, $cnpj, $sigla);
                $data["lista"] = $lista;
            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Não pode buscar empresa!</div>";
            }
        }else{
            $lista = $empresaDao->buscar("", "", "", "");
                $data["lista"] = $lista;
        }
        
        return view('admin.sistema.empresa.buscar', $data);
    }
    
    public function detalhes($id, Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        try{
            $empresa = $dbempresa->whereEmpresa_id($id)->first();
            
            if($empresa == null){
                $data["resp"] = "<div class='alert alert-danger'>Empresa não encontrada!</div>";
                $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
                $data["lista"] = $lista;
                return view('admin.sistema.empresa.cadastrar', $data);
            }
            
            if($request->isMethod("POST")){
            
                    $razao = $request->input("razao");
                    $fantasia = $request->input("fantasia");
                    $cnpj = $request->input("cnpj");
                    $sigla = $request->input("sigla");
                    $idempresa = $request->input("idempresa");

                    $nvempresa = \App\Empresa::find($idempresa);
                    $nvempresa->EMPRESA_nome = $fantasia;
                    $nvempresa->EMPRESA_nomeCompleto = $razao;
                    $nvempresa->EMPRESA_cnpj = $cnpj;
                    $nvempresa->EMPRESA_sigla = $sigla;
                    

                    if($nvempresa->save()){
                        $data["resp"] = "<div class='alert alert-success'>Empresa editada com sucesso!</div>";
                        $empresa = $dbempresa->whereEmpresa_id($id)->first();
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Empresa não editada!</div>";
                    }
                }
                
        }  catch (\Exception $e){
                //echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Empresa não cadastrado!</div>";
        }
        $data["empresa"] = $empresa;
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.empresa.detalhes', $data);
    }
    
    public function cadastrarusuario(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        
        $dbperfil = new \App\Perfil();
        $listaP = $dbperfil->orderBy("PERFIL_nome")->get();
        
        try{
            if($request->isMethod("POST")){
                
                $dbusuarioEmp = new \App\UsuarioEmpresa();
                $dbusuario = new \App\Usuario();
                
                $usuarioempresa = $dbusuario->whereUsuario_login(
                        $request->input("login"))->first();
                if($usuarioempresa == null){
                    
                    $nome = $request->input("nome");
                    $email = $request->input("email");
                    $login = $request->input("login");
                    $senha = $request->input("senha");
                    $senha = Hash::make($senha);
                    $empresa = $request->input("empresa");
                    $perfil = $request->input("perfil");
                    $nivel = $request->input("nivel");
                    $tipo = "EMPRESA";
                    
                    $nvusuarioempresa = new \App\Usuario();
                    $nvusuarioempresa->USUARIO_nome = $nome;
                    $nvusuarioempresa->USUARIO_email = $email;
                    $nvusuarioempresa->USUARIO_login = $login;
                    $nvusuarioempresa->password = $senha;
                    $nvusuarioempresa->USUARIO_nivel = $nivel;
                    $nvusuarioempresa->USUARIO_tipo = $tipo;
                    $nvusuarioempresa->USUARIO_status = 1;
                    $nvusuarioempresa->USUARIO_PERFIL_id = $perfil;
                    
                    //$nvusuarioempresa->USUARIO_EMP_idPerfil = $perfil;
                    //$nvusuarioempresa->USUARIO_EMP_idEmpresa = $empresa;

                    if($nvusuarioempresa->save()){
                        $nvusuarioempresa2 = new \App\UsuarioEmpresa();
                        
                        $nvusuarioempresa2->USUARIO_EMP_idUsuario = $nvusuarioempresa->USUARIO_id;
                        //$nvusuarioempresa2->USUARIO_EMP_idPerfil = $perfil;
                        $nvusuarioempresa2->USUARIO_EMP_idEmpresa = $empresa;
                        
                        $nvusuarioempresa2->save();
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
        return view('admin.sistema.empresa.usuario.cadastrar', $data);
    }
    
    public function detalhesusuario($id, Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $dbperfil = new \App\Perfil();
        $listaP = $dbperfil->orderBy("PERFIL_nome")->get();
        
        try{
            
            $dbusuario = new \App\Usuario();
            $dbusuarioEmp = new \App\UsuarioEmpresa();
            $usuarioEmp = $dbusuarioEmp->whereUsuario_emp_idusuario($id)->first();
            $usuario = $dbusuario->whereUsuario_id($id)->first();
            
            if($usuario == null){
                $data["lista"] = $lista;
                return view('admin.sistema.empresa.usuario.cadastrar', $data);
            }
            //PAREI AQUIIIIIIIIIIII
            if($request->isMethod("POST")){
                
                $nome = $request->input("nome");
                $email = $request->input("email");
                $login = $request->input("login");
                $senha = $request->input("senha");

                $empresa = $request->input("empresa");
                $perfil = $request->input("perfil");
                $nivel = $request->input("nivel");


                $usuario->USUARIO_nome = $nome;
                $usuario->USUARIO_email = $email;
                $usuario->USUARIO_login = $login;
                if($senha != ""){
                    $senha = Hash::make($senha);
                    $usuario->password = $senha;
                }
                $usuario->USUARIO_nivel = $nivel;
                $usuario->USUARIO_PERFIL_id = $perfil;
                
                if($usuario->save()){
                    
                    $data["resp"] = "<div class='alert alert-success'>Usuário editado com sucesso!</div>";
                    $usuario = $dbusuario->whereUsuario_id($id)->first();
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Usuário não editado!</div>";
                }
            }
            $data["usuario"] = $usuario;
            $data["usuarioEmp"] = $usuarioEmp;
        } catch (Exception $ex) {
            $data["resp"] = "<div class='alert alert-danger'>Usuário não editado!</div>";
        }
        
        $data["lista"] = $lista;
        $data["listaP"] = $listaP;
        return view('admin.sistema.empresa.usuario.detalhes', $data);
    }
    
    public function cadastrarperfil(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa($this->dbname);
        if($request->isMethod("POST")){
            try{
                $dbperfil = new \App\PerfilEmpresa($this->dbname);
                $perfil = $dbperfil->wherePerfil_emp_nomeAndPerfil_emp_idempresa($request->input("descricao"), $request->input("empresa"))->first();
                if($perfil == null){
                    $descricao = $request->input("descricao");
                    $emp = $request->input("empresa");

                    $nvperfil = new \App\PerfilEmpresa($this->dbname);
                    $nvperfil->PERFIL_EMP_nome = $descricao;
                    $nvperfil->PERFIL_EMP_idEmpresa = $emp;

                    if($nvperfil->save()){
                        $data["resp"] = "<div class='alert alert-success'>Perfil da empresa cadastrado com sucesso!</div>";
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
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.empresa.perfil.cadastrar', $data);
    }
     
    public function detalhesempresaperfil($id, Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        try{
            $dbperfil = new \App\PerfilEmpresa();
                
            $perfil = $dbperfil->wherePerfil_emp_id($id)->first();
            if($perfil == null){
                $data["resp"] = "<div class='alert alert-warning'>Perfil não encontrado!</div>";
                return view('admin.sistema.empresa.perfil.buscar', $data);
            }
            
            if($request->isMethod("POST")){
            
                $descricao = $request->input("descricao");
                $emp = $request->input("empresa");
                $idperfil = $request->input("idperfil");
                
                $nvperfil = \App\PerfilEmpresa::find($idperfil);
                $nvperfil->PERFIL_EMP_nome = $descricao;
                $nvperfil->PERFIL_EMP_idEmpresa = $emp;

                if($nvperfil->save()){
                    $data["resp"] = "<div class='alert alert-success'>Perfil da empresa alterado com sucesso!</div>";
                    $perfil = $dbperfil->wherePerfil_emp_id($id)->first();
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Perfil não alterado!</div>";
                }
                
            }
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Perfil não alterado!</div>";
        }
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        $data["perfil"] = $perfil;
        return view('admin.sistema.empresa.perfil.detalhes', $data);
    }
    
    public function cadastrarproduto(Request $request){
        date_default_timezone_set('America/Sao_Paulo');
        $data = array();
        $dbempresa = new \App\Empresa();
        $produto = new \App\Produto($this->dbname);
        
        if($request->isMethod("POST")){
           
            try{
                $empresa =  $request->input("empresas", array());
                $nome = $request->input("nome", "");
                $grupo = $request->input("grupo", "");
                $descricao = $request->input("descricao", "");
                
                $prod = $produto->whereProduto_nome($nome)->first();
                if($prod == null){
                    $produto->PRODUTO_nome = $nome;
                    $produto->PRODUTO_grupo = $grupo;
                    $produto->PRODUTO_descricao = $descricao;
                    $produto->PRODUTO_status = 1;
                    $produto->PRODUTO_dataCadastro = date('Y-m-d H:i:s');
                    $dbname = $this->dbname;
                    
                    \DB::connection($this->dbname)
                        ->
                        transaction(function() use($produto, $empresa, $dbname) {
                            $produto->save();
                            if(count($empresa) > 0){
                                foreach($empresa as $emp){
                                    $prodEmp = new \App\ProdutoEmpresa($dbname);
                                    //$prodEmp->produto()->associate($produto);
                                    //$prodEmp->empresa()->associate($emp);
                                    $prodEmp->PRODUTO_EMP_idEmpresa = $emp;
                                    $prodEmp->PRODUTO_EMP_idProduto = $produto->PRODUTO_id;
                                    $prodEmp->save();
                                }
                            }

                    });


                    $data["resp"] = "<div class='alert alert-success'>Produto cadastrado com sucesso!</div>";
                }else{
                    $data["resp"] = "<div class='alert alert-warning'>Produto já cadastrado!</div>";
                }
            }  catch (\Exception $e){
                echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Produto não cadastrado!</div>";
            }
            
        }
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        //$listaP = $produto->orderBy("PRODUTO_nome")->get();
        $data["lista"] = $lista;
        //$data["listaP"] = $listaP;
        return view('admin.sistema.empresa.produto.cadastrar', $data);
    }
    
    public function buscarproduto(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        $produtoemp = new \App\ProdutoEmpresa();
        $prodEmpDao = new \App\Repository\ProdutoEmpresaDao($produtoemp);
        if($request->isMethod("POST")){
           
            try{
                $empresa =  $request->input("empresa");
                $nome = $request->input("nome", "");
                $grupo = $request->input("grupo", "");
                
                $lista = $prodEmpDao->buscar($nome, $grupo, $empresa, "");
                $data["listaP"] = $lista;
                
            }  catch (\Exception $e){
                echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Produto não encontrado!</div>";
            }
            
        }else{
            $lista = $prodEmpDao->buscar("", "", "", "");
                $data["listaP"] = $lista;
        }
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        return view('admin.sistema.empresa.produto.buscar', $data);
    }
    
    public function excluirproduto($id){
        date_default_timezone_set('America/Sao_Paulo');
        $data = array();
        try{
            $prod = \App\Produto::find($id);
            
            if($prod == null){
                $data["resp"] = "<div class='alert alert-warning'>Produto não encontrado!</div>";
                return view('admin.sistema.empresa.produto.buscar', $data);
            }
            
            if($prod->PRODUTO_status == 1)
                $prod->PRODUTO_status = 0;
            else
                $prod->PRODUTO_status = 1;
            
            $prod->PRODUTO_dataCancel = date('Y-m-d H:i:s');
            
            if($prod->save()){
                if($prod->PRODUTO_status == 1)
                $data["resp"] = "<div class='alert alert-success'>Produto ativado com sucesso!</div>";
                else
                $data["resp"] = "<div class='alert alert-success'>Produto cancelado  com sucesso!</div>";
            }else{
                $data["resp"] = "<div class='alert alert-danger'>Produto não editado!</div>";
            }
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Tipo da empresa não alterado!</div>";
        }
        $dbempresa = new \App\Empresa();
        $produtoemp = new \App\ProdutoEmpresa();
        $prodEmpDao = new \App\Repository\ProdutoEmpresaDao($produtoemp);
        
        $lista = $prodEmpDao->buscar("", "", "", "");
        $data["listaP"] = $lista;
                
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.empresa.produto.buscar', $data);
    }
    
    public function buscarempresaperfil(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa($this->dbname);
        if($request->isMethod("POST")){
            try{
                
                $descricao = $request->input("descricao", "");
                $empresa = $request->input("empresa", "");
                
                $perfilEmp = new \App\PerfilEmpresa($this->dbname);
                $perfilEDao = new \App\Repository\PerfilEmpresaDao($perfilEmp);

                $lista = $perfilEDao->buscar($descricao . "%", $empresa);
                $data["listaP"] = $lista;
                $data["desc"] = $descricao;
                $data["empresa"] = $empresa;
                    

            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Empresa não encontrada!</div>";
            }
            
        }
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.empresa.perfil.buscar', $data);
    }
    
    public function buscarperfil(Request $request){
        $id = $request->input("idempresa");
        
        $perfilEmpresa = new \App\PerfilEmpresa($this->dbname);
        $empresa = $perfilEmpresa->wherePerfil_emp_idempresa($id)->get();
        
        if(count($empresa) > 0){
            echo "Perfil: ";
            
            echo "<select required name='perfil' id='perfil' class='form-control'>";
            foreach ($empresa as $per){
                echo "<option value='" . $per->PERFIL_EMP_id. "'>".$per->PERFIL_EMP_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "Perfil: ";
            
            echo "<select required name='perfil' id='perfil' class='form-control'>";
                echo "<option value=''></option>";
            echo "</select>";
            
            echo "<div class='alert alert-warning'>Não existe perfil para esta empresa!</div>";
        }
    }
    
    public function buscarusuario(Request $request){
        $data = array();
        $usuarioEmpresa = new \App\UsuarioEmpresa();
                $usuarioEDao = new \App\Repository\UsuarioEmpresaDao($usuarioEmpresa);
        if($request->isMethod("POST")){
            try{
                
                $nome = $request->input("nome", "");
                $email = $request->input("email", "");
                $login = $request->input("login", "");

                $lista = $usuarioEDao->buscar($nome . "%", $login . "%", $email . "%");
                $data["listaP"] = $lista;
                $data["nome"] = $nome;
                $data["login"] = $login;
                $data["email"] = $email;
                    

            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Usuário não encontrada!</div>";
            }
            
        }else{
            $lista = $usuarioEDao->buscar( "%",  "%", "%");
            $data["listaP"] = $lista;
        }
        
        return view('admin.sistema.empresa.usuario.buscar', $data);
    }
    
    public function excluirusuario($id, Request $request){
        $data = array();
        try{
            $usuarioEmpresa = \App\Usuario::find($id);
            
            if($usuarioEmpresa == null){
                $data["resp"] = "<div class='alert alert-warning'>Usuario da empresa não encontrado!</div>";
                return view('admin.sistema.empresa.usuario.buscar', $data);
            }
            
            if($usuarioEmpresa->USUARIO_status == 1)
                $usuarioEmpresa->USUARIO_status = 0;
            else
                $usuarioEmpresa->USUARIO_status = 1;
            
            if($usuarioEmpresa->save()){
                if($usuarioEmpresa->USUARIO_status == 1)
                $data["resp"] = "<div class='alert alert-success'>Usuario empresa ativado com sucesso!</div>";
                else
                $data["resp"] = "<div class='alert alert-success'>Usuário empresa excluído com sucesso!</div>";
            }else{
                $data["resp"] = "<div class='alert alert-danger'>Usuário empresa não editado!</div>";
            }
            
             $usuarioEDao = new \App\Repository\UsuarioEmpresaDao(new \App\UsuarioEmpresa());
        
            $lista = $usuarioEDao->buscar( "%",  "%", "%");
            $data["listaP"] = $lista;
        
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Usuário empresa não alterado!</div>";
        }
        
        
        return view('admin.sistema.empresa.usuario.buscar', $data);
    }
    
}
