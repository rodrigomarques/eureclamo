<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
class RelatorioController extends ConfigController
{
    public function acompanhamento(Request $request){
        $data = array();
        date_default_timezone_set('America/Sao_Paulo');
        $tipoManifest = new \App\TipoManifestacao();
        $canal = new \App\Canal();
        $dbempresa = new \App\Empresa();
        $empresaDao = new \App\Repository\EmpresaDao($dbempresa);
        
        $manifestacao = new \App\Manifestacao();
        $manifestacaoDao = new \App\Repository\ManifestacaoDao($manifestacao);
        if($request->isMethod("POST")){
            try{
                
                $idcanal = $request->input("idcanal");
                $idtipo = $request->input("idtipo");
                $idempresa = $request->input("idempresa");
                $dtentradaocorrencia = $request->input("dtentradaocorrencia");
                $codigo = $request->input("codigo");
                $nivel = $request->input("nivel");
                $status = $request->input("status");
                
                if($status == "") $status = 1;
                
                if($dtentradaocorrencia != ""){
                    $entrada = \Carbon\Carbon::createFromFormat('d/m/Y', $dtentradaocorrencia);
                }else{
                    $entrada = "";
                }
                
                $lista = $manifestacaoDao->buscarRelatorio($idcanal, $idtipo, $idempresa, $entrada, 
                                        $nivel, $codigo, $status);
                $data["listaManif"] = $lista;
                
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-warning'>Consulta da manifestação não pode ser realizada!</div>";
            }
        }else{
            
        }
        $listaM = $tipoManifest->whereTipomanif_status(1)->get();
        $listaC = $canal->whereCanal_status(1)->get();
        $listaE = $empresaDao->buscar("", "", "", "");
        
        $data["listaE"] = $listaE;
        $data["listaM"] = $listaM;
        $data["listaC"] = $listaC;
        return view('admin.sistema.relatorio.acompanhamento', $data);
    }
    
    public function acompanhamentofechado(Request $request){
        $data = array();
        date_default_timezone_set('America/Sao_Paulo');
        $tipoManifest = new \App\TipoManifestacao();
        $canal = new \App\Canal();
        $dbempresa = new \App\Empresa();
        $empresaDao = new \App\Repository\EmpresaDao($dbempresa);
        
        $manifestacao = new \App\Manifestacao();
        $manifestacaoDao = new \App\Repository\ManifestacaoDao($manifestacao);
        if($request->isMethod("POST")){
            try{
                
                $idcanal = $request->input("idcanal");
                $idtipo = $request->input("idtipo");
                $idempresa = $request->input("idempresa");
                $dtentradaocorrencia = $request->input("dtentradaocorrencia");
                $codigo = $request->input("codigo");
                $nivel = $request->input("nivel");
                
                /*
                 * status 3 -- Manifestação encerrada
                 */
                if($dtentradaocorrencia != ""){
                    $entrada = \Carbon\Carbon::createFromFormat('d/m/Y', $dtentradaocorrencia);
                }else{
                    $entrada = "";
                }
                
                $lista = $manifestacaoDao->buscarRelatorio($idcanal, $idtipo, $idempresa, $entrada, 
                                        $nivel, $codigo, 3);
                $data["listaManif"] = $lista;
                
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-warning'>Consulta da manifestação não pode ser realizada!</div>";
            }
        }else{
            
        }
        $listaM = $tipoManifest->whereTipomanif_status(1)->get();
        $listaC = $canal->whereCanal_status(1)->get();
        $listaE = $empresaDao->buscar("", "", "", "");
        
        $data["listaE"] = $listaE;
        $data["listaM"] = $listaM;
        $data["listaC"] = $listaC;
        return view('admin.sistema.relatorio.acompanhamentofechado', $data);
    }
    
   
}
