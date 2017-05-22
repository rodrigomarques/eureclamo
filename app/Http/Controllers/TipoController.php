<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
class TipoController extends ConfigController
{
    public function cadastrar(Request $request){
        $data = array();
        if($request->isMethod("POST")){
            try{
                $tipoMani = new \App\TipoManifestacao($this->dbname);
                $tipo = $tipoMani->whereTipomanif_nome($request->input("tipo"))->first();
                if($tipo == null){
                    $tipodesc = $request->input("tipo");

                    $nvtipo = new \App\TipoManifestacao($this->dbname);
                    $nvtipo->TIPOMANIF_nome = $tipodesc;
                    $nvtipo->TIPOMANIF_status = 1;

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
        
        return view('admin.sistema.tipo.cadastrar', $data);
    }
    
    public function buscar(Request $request){
        $data = array();
        $tipoM = new \App\TipoManifestacao($this->dbname);
                $tipoMDao = new \App\Repository\TipoManifestacaoDao($tipoM);
        if($request->isMethod("POST")){
            try{
             
                $descricao = $request->input("tipo");
                
                
                
                $lista = $tipoMDao->buscar($descricao . "%", "");
                $data["listaManif"] = $lista;
                
                
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-warning'>Busca não pode ser realizada!</div>";
            }
        }else{
            $lista = $tipoMDao->buscar("%", "");
                $data["listaManif"] = $lista;
        }
        
        return view('admin.sistema.tipo.buscar', $data);
    }
    
    public function detalhes($id, Request $request){
        $data = array();
        try{
            //$tipoM = new \App\TipoManifestacao($this->dbname);
            $tipoM = \App\TipoManifestacao::find($id);
            
            if($tipoM == null){
                $data["resp"] = "<div class='alert alert-warning'>Tipo da empresa não encontrado!</div>";
                return view('admin.sistema.tipo.buscar', $data);
            }
            
            if($request->isMethod("POST")){
            
                    $tipodesc = $request->input("tipo");

                    $tipoM->TIPOMANIF_nome = $tipodesc;

                    if($tipoM->save()){
                        $data["resp"] = "<div class='alert alert-success'>Tipo de Manifestação editado com sucesso!</div>";
                        $tipoM = \App\TipoManifestacao::find($id);
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação não editado!</div>";
                    }
            }
            
            $data["tipoM"] = $tipoM;
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Tipo da empresa não alterado!</div>";
        }
        
        
        return view('admin.sistema.tipo.detalhes', $data);
    }
    
    public function excluir($id){
        $data = array();
        try{
            //$tipoM = new \App\TipoManifestacao($this->dbname);
            $tipoM = \App\TipoManifestacao::find($id);
            
            if($tipoM == null){
                $data["resp"] = "<div class='alert alert-warning'>Tipo da empresa não encontrado!</div>";
                return view('admin.sistema.tipo.buscar', $data);
            }
            
            if($tipoM->TIPOMANIF_status == 1)
                $tipoM->TIPOMANIF_status = 0;
            else
                $tipoM->TIPOMANIF_status = 1;
            
            if($tipoM->save()){
                $data["resp"] = "<div class='alert alert-success'>Tipo de Manifestação editado com sucesso!</div>";
            }else{
                $data["resp"] = "<div class='alert alert-danger'>Tipo de Manifestação não editado!</div>";
            }
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Tipo da empresa não alterado!</div>";
        }
        
        
        return view('admin.sistema.tipo.buscar', $data);
    }
    
    public function adicionarprazo(Request $request){
        $data = array();
        $canal = new \App\Canal($this->dbname);
        $listaC = $canal->get();
        $data["listaCanal"] = $listaC;
        
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        $tipoM = new \App\TipoManifestacao($this->dbname);
        $listaM = $tipoM->get();
        $data["listaManif"] = $listaM;
        if($request->isMethod("POST")){
            $idcanal = $request->input("canalm");
            $idtipo = $request->input("tipom");
            $prazo = $request->input("prazo");
            
            $tipoManifCanal = new \App\TipoManifestacaoCanal();
            try{
                $tipoManifCanal->TIPO_CANAL_idTipo = $idtipo;
                $tipoManifCanal->TIPO_CANAL_idCanal = $idcanal;
                $tipoManifCanal->TIPO_CANAL_PrazoPadrao = $prazo;
                
                $tipoManiCanalDao = new \App\Repository\TipoManifestacaoCanalDao($tipoManifCanal);
                $tipo = $tipoManiCanalDao->buscarIdTIpoIdCanal($idtipo, $idcanal);
                
                if(count($tipo) == 0){
                    $tipoManifCanal->TIPO_CANAL_nrVersao = 1;
                    if($tipoManifCanal->save()){
                        $data["resp"] = "<div class='alert alert-success'>Prazo cadastrado com sucesso</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-danger'>Prazo não cadastrado</div>";
                    }
                }else{
                    /*$tipo[0]->TIPO_CANAL_PrazoPadrao = $prazo;
                    //dd($tipo[0]);
                    $dbname = $this->dbname;
                    
                    \DB::connection($this->dbname)
                        ->table('tipomanifcanal')
                        ->where('TIPO_CANAL_idTipo', $idtipo)
                        ->where('TIPO_CANAL_idCanal', $idcanal)
                        ->update(['TIPO_CANAL_PrazoPadrao' => $prazo]);
                    
                    $data["resp"] = "<div class='alert alert-success'>Prazo atualizado com sucesso</div>";
                }*/
                    $data["resp"] = "<div class='alert alert-warning'>Prazo já cadastrado</div>";
                }
                
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-danger'>Prazo não cadastrado</div>";
            }
        }
        return view('admin.sistema.tipo.adicionarprazo', $data);
    }
    
    public function buscarprazo(Request $request){
        $data = array();
        $canal = new \App\Canal($this->dbname);
        $listaC = $canal->get();
        $data["listaCanal"] = $listaC;
        
        $dbempresa = new \App\Empresa($this->dbname);
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $data["lista"] = $lista;
        
        $tipoM = new \App\TipoManifestacao($this->dbname);
        $tipoManifCanal = new \App\TipoManifestacaoCanal();
        $tipoManifDao = new \App\Repository\TipoManifestacaoCanalDao($tipoManifCanal);
        $listaM = $tipoM->get();
        $data["listaManif"] = $listaM;
        if($request->isMethod("POST")){
            $idcanal = $request->input("canalm");
            $idtipo = $request->input("tipom");
            try{
                $tipoManifCanal->TIPO_CANAL_idTipo = $idtipo;
                $tipoManifCanal->TIPO_CANAL_idCanal = $idcanal;
                
                $lista = $tipoManifDao->buscar($idtipo, $idcanal);
                
                //dd($lista);
                $data["listaP"] = $lista;
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-danger'>Prazo não cadastrado</div>";
            }
        }else{
            $lista = $tipoManifDao->buscar();
                
                //dd($lista);
                $data["listaP"] = $lista;
        }
        return view('admin.sistema.tipo.buscarprazo', $data);
    }
    
    public function detalhesprazo($idtipo, $idcanal, Request $request){
        $data = array();
        $tipoManifDao = new \App\Repository\TipoManifestacaoCanalDao(new \App\TipoManifestacaoCanal);
        $tipoManif = $tipoManifDao->buscar($idtipo, $idcanal)->first();
        
        if($request->isMethod("POST")){
            try{
            $prazo = $request->input("prazo");
            $versao = $tipoManif->TIPO_CANAL_nrVersao;
            
            $tipoManif->TIPO_CANAL_dataFimVersao = date('Y-m-d H:i:s');
            $dbname = $this->dbname;
                    
            $versao++;
            
            $tipoManifCanal = new \App\TipoManifestacaoCanal();
            
            $tipoManifCanal->TIPO_CANAL_idTipo = $idtipo;
            $tipoManifCanal->TIPO_CANAL_idCanal = $idcanal;
            $tipoManifCanal->TIPO_CANAL_PrazoPadrao = $prazo;
            $tipoManifCanal->TIPO_CANAL_nrVersao = $versao;
            
            $tipoManifCanal->TIPO_CANAL_PrazoPadrao = $prazo;
            
            \DB::connection(\App\Config::$dbname)
                        ->
                        transaction(function() use($idtipo, $idcanal, $tipoManif, $tipoManifCanal, $dbname) {
                            \DB::connection($dbname)
                                ->table('tipomanifcanal')
                                ->where('TIPO_CANAL_idTipo', $idtipo)
                                ->where('TIPO_CANAL_idCanal', $idcanal)
                                ->where('TIPO_CANAL_nrVersao', $tipoManif->TIPO_CANAL_nrVersao)
                                ->update(['TIPO_CANAL_dataFimVersao' => $tipoManif->TIPO_CANAL_dataFimVersao]);
                            
                            $tipoManifCanal->save();
                    });
            
                $data["resp"] = "<div class='alert alert-success'>Prazo modificado com sucesso!</div>";
                $tipoManif = $tipoManifDao->buscar($idtipo, $idcanal)->first();
            }  catch (\Exception $e){
                $data["resp"] = "<div class='alert alert-danger'>Prazo não modificado</div>";
            }
        }
        
        $data["tipo"] = $tipoManif;
        return view('admin.sistema.tipo.detalhesprazo', $data);
    }
}
