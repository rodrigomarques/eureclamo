<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
class CanalController extends ConfigController
{
    public function cadastrar(){
        //(Auth::check());retorna true se tiver logado
        $data = array();
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        /*
        $canal = new \App\Canal($this->dbname);
        $listaC = $canal->get();
        $data["listaCanal"] = $listaC;
        
        $tipoM = new \App\TipoManifestacao($this->dbname);
        $listaM = $tipoM->get();
        $data["listaManif"] = $listaM;
         * 
         */
        return view('admin.sistema.canal.cadastrar', $data);
    }
    
    public function detalhescanal($id, Request $request){
        $data = array();

        try{
            $canal = new \App\Canal();
            $canal = $canal->whereCanal_id($id)->first();
            if($canal == null){
                $data["resp"] = "<div class='alert alert-warning'>Canal não encontrado!</div>";
            }else{
				if($canal->CANAL_status == 1) $canal->CANAL_status = 0;
				else $canal->CANAL_status = 1;
				
				if($canal->save()){
                    if($canal->CANAL_status == 1)
                    $data["resp"] = "<div class='alert alert-success'>Canal ativado com sucesso!</div>";
                    else
                    $data["resp"] = "<div class='alert alert-success'>Canal cancelado  com sucesso!</div>";
                    
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Canal não alterado!</div>";
                }
			}
            /*
            if($request->isMethod("POST")){
                $desccanal = $request->input("canal");
                $emp = $request->input("empresa");
                $idcanal = $request->input("idcanal");
                $status = $request->input("status");
                 
                $nvcanal = \App\Canal::find($idcanal);
                $nvcanal->CANAL_nome = $desccanal;
                //PEGAR A EMPRESA DO CANAL
                $nvcanal->EMPRESA_id = $emp;
                $nvcanal->CANAL_status = $status;
                //$nvcanal->CANAL_id = $idcanal;
                
                if($nvcanal->save()){
                    $data["resp"] = "<div class='alert alert-success'>Canal alterado com sucesso!</div>";
                    $canal = $canal->whereCanal_id($id)->first();
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Canal não alterado!</div>";
                }*/
            
            
            //$data["c"] = $canal;
        }  catch (\Exception $e){
            //echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-warning'>Erro nos detalhes do canal!</div>";
        }
        $canal = new \App\Canal();
		$canalDao = new \App\Repository\CanalDao($canal);
		$lista = $canalDao->buscar("%");
		$data["listaCanal"] = $lista;
        
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.canal.buscar', $data);
    }
    
    public function detalhestipo($id, Request $request){
        $data = array();
        try{
            $tipoM = new \App\TipoManifestacao();
            $tipo = \App\TipoManifestacao::find($id);
            if($tipo == null){
                $data["resp"] = "<div class='alert alert-warning'>Tipo de manifestação não encontrada!</div>";
                return view('admin.sistema.canal.buscar', $data);
            }
            
            if($request->isMethod("POST")){
                //PAREI AQUIIIIIIIIIIIIIIIIIIIIIII
                $destipo = $request->input("tipo");
                $idtpo = $request->input("idtipo");
                 
                $nvtipo = \App\TipoManifestacao::find($idtpo);
                $nvtipo->TIPOMANIF_nome = $destipo;
                
                if($nvtipo->save()){
                    $data["resp"] = "<div class='alert alert-success'>Tipo de manifestação alterado com sucesso!</div>";
                    $tipo = $nvtipo->whereTipomanif_id($id)->first();
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Tipo de manifestação não alterado!</div>";
                }
            }
            
            $data["t"] = $tipo;
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-warning'>Erro nos detalhes do tipo de manifestação!</div>";
            return view('admin.sistema.canal.buscar', $data);
        }
        return view('admin.sistema.canal.detalhesmanifestacao', $data);
    }
    
    public function buscar(Request $request){
        $data = array();
        $canal = new \App\Canal($this->dbname);
                    $canalDao = new \App\Repository\CanalDao($canal);
        if($request->isMethod("POST")){
            try{
                
                $empresa = $request->input("empresa");
                $descricao = $request->input("descricao");
                
                //if($tipo == "canal"){
                    
                    
                    $lista = $canalDao->buscar($descricao . "%", $empresa);
                    $data["listaCanal"] = $lista;
                    
                /*}else{
                    $tipoM = new \App\TipoManifestacao($this->dbname);
                    $tipoMDao = new \App\Repository\TipoManifestacaoDao($tipoM);
                    
                    $lista = $tipoMDao->buscar($descricao . "%");
                    $data["listaManif"] = $lista;
                }*/
                
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-warning'>Busca não pode ser realizada!</div>";
            }
        }ELSE{
            $canal = new \App\Canal();
            $canalDao = new \App\Repository\CanalDao($canal);
            $lista = $canalDao->buscar("%");
            $data["listaCanal"] = $lista;
        }
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        return view('admin.sistema.canal.buscar', $data);
    }
    
    public function cadastrarCanal(Request $request){
        $data = array();

        if($request->isMethod("POST")){
            try{
                //$canal = new \App\Canal('local_mysql')::whereCanaldesc($request->input("canal"));
                $dbcanal = new \App\Canal($this->dbname);
                $canal = $dbcanal->whereCanal_nome($request->input("canal"))->first();
                if($canal == null){
                    $desccanal = $request->input("canal");
                    $emp = $request->input("empresa");

                    $nvcanal = new \App\Canal($this->dbname);
                    $nvcanal->CANAL_nome = $desccanal;
                    $nvcanal->CANAL_status = 1;
                    //PEGAR A EMPRESA DO CANAL
                    $nvcanal->EMPRESA_id = $emp;

                    if($nvcanal->save()){
                        $data["resp"] = "<div class='alert alert-success'>Canal cadastrado com sucesso!</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Canal não cadastrado!</div>";
                    }
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Canal ja cadastrado!</div>";
                }
            }  catch (\Exception $e){
                //echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Canal não cadastrado!</div>";
            }
        }
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        return view('admin.sistema.canal.cadastrar', $data);
    }
    
    public function cadastrarManifestacao(Request $request){
        $data = array();
        if($request->isMethod("POST")){
            try{
                $tipoMani = new \App\TipoManifestacao($this->dbname);
                $tipo = $tipoMani->whereTipomanif_nome($request->input("tipo"))->first();
                if($tipo == null){
                    $tipodesc = $request->input("tipo");

                    $nvtipo = new \App\TipoManifestacao($this->dbname);
                    $nvtipo->TIPOMANIF_nome = $tipodesc;

                    if($nvtipo->save()){
                        $data["resp"] = "<div class='alert alert-success'>Tipo de Manifestação cadastrado com sucesso!</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação não cadastrado!</div>";
                    }
                }else{
                    $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação ja cadastrado!</div>";
                }
            }  catch (\Exception $e){
                echo $e->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação não cadastrado!</div>";
            }
        }
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        $canal = new \App\Canal($this->dbname);
        $listaC = $canal->get();
        $data["listaCanal"] = $listaC;
        
        $tipoM = new \App\TipoManifestacao($this->dbname);
        $listaM = $tipoM->get();
        $data["listaManif"] = $listaM;
        return view('admin.sistema.canal.cadastrar', $data);
    }
    
    public function canalManifestacao(Request $request){
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        $canal = new \App\Canal($this->dbname);
        $listaC = $canal->get();
        $data["listaCanal"] = $listaC;
        
        $tipoM = new \App\TipoManifestacao($this->dbname);
        $listaM = $tipoM->get();
        $data["listaManif"] = $listaM;
        
        try{
            $canalManifestacao = new \App\CanalManifestacao();
            
            if($request->isMethod("POST")){

                $tipom = $request->input("tipom");
                $canalm = $request->input("canalm");
                $prazo = $request->input("prazo");
                
                if($tipom == "" || $canalm == "" || $prazo == ""){
                    $data["resp"] = "<div class='alert alert-info'>Preencha todos os campos!</div>";
                }else{
                    $manifCanal = $canalManifestacao->whereTipo_canal_idtipoAndTipo_canal_idcanal(
                            $request->input("tipom"), $request->input("canalm"))->first();
                    if($manifCanal == null){
                        $canalManifestacao->TIPO_CANAL_idCanal = $canalm;
                        $canalManifestacao->TIPO_CANAL_idTipo = $tipom;
                        $canalManifestacao->TIPO_CANAL_PrazoPadrao = $prazo;

                        if($canalManifestacao->save()){
                            $data["resp"] = "<div class='alert alert-success'>Tipo de Manifestação vinculada com sucesso!</div>";
                        }else{
                            $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação não vinculada!</div>";
                        }
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Esta manifestação ja foi vinculada a este canal!</div>";
                    }
                }
            }
        } catch (Exception $ex) {
            $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação não vinculada!</div>";
        }
        return view('admin.sistema.canal.cadastrar', $data);
    }
    
    public function buscarcanal(Request $request){
        $id = $request->input("idempresa");
        
        $canalD = new \App\Canal($this->dbname);
        $canal = $canalD->whereEmpresa_id($id)->get();
        
        /*
         * errooooooss
         */
        if(count($canal) > 0){
          
            echo "Canal: ";
            
            echo "<select name='canalm' id='canalm' required class='form-control'>";
            echo "<option value='0'></option>";
            foreach ($canal as $c){
                echo "<option value='" . $c->CANAL_id. "'>".$c->CANAL_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "<div class='alert alert-warning'>Não existe canal para esta empresa!</div>";
        }
    }
}
