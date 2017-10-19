<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
class ManifestacaoController extends ConfigController
{
    public function cadastrar(Request $request){
        $data = array();
        $dbempresa = new \App\Empresa();
        $dbregiao = new \App\Regiao();
        if($request->isMethod("POST")){
            try{
                
                $dbmanif = new \App\Manifestacao();
                $manif = $dbmanif->whereManif_tipo_canal_idtipoAndManif_tipo_canal_idcanalAndManif_codreclamanteemp(
                        $request->input("tipomanif"), $request->input("canalm"), $request->input("codigo"))->first();
                if($manif == null){
                
                $email= $request->input("email");
                $nome= $request->input("nome");
                $telefone= $request->input("telefone");
                $celular= $request->input("celular");
                $empresa= $request->input("empresa");
                $produto= $request->input("produto");
                $codigo= $request->input("codigo");
                $resumo= $request->input("resumo");
                $completa= $request->input("completa");
                $dtentradacanal= $request->input("dtentradacanal");
                $hrentradacanal= $request->input("hrentradacanal");
                $dtentradaocorrencia= $request->input("dtentradaocorrencia");
                $hrentradaocorrencia= $request->input("hrentradaocorrencia");
                $dtentradagestao= $request->input("dtentradagestao");
                $hrentradagestao= $request->input("hrentradagestao");
                $prazoresposta= $request->input("prazoresposta");
                $nivel= $request->input("nivel");
                $endereco= $request->input("endereco");
                $referencia= $request->input("referencia");
                $idcanal= $request->input("canalm");
                $idtipomanif= $request->input("tipomanif");
                $idreclamante= $request->input("reclamante");
                $idlocalidade = $request->input("idlocalidade");
                $nprotocolocanal = $request->input("nprotocolocanal");
                
                $tipoManifCanalDao = new \App\Repository\TipoManifestacaoCanalDao(new \App\TipoManifestacaoCanal);
                $tipoManifCanal = $tipoManifCanalDao->buscarIdTIpoIdCanalUltimo($idtipomanif, $idcanal);
				
                try{
                        if($dtentradacanal != "") $entradacanal = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $dtentradacanal." ".$hrentradacanal);
                        else $entradacanal = null;
                }catch(\Exception $e){ $entradacanal = null; }

                try{
                if($dtentradaocorrencia != "") $entradaocorrencia = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $dtentradaocorrencia. " " .$hrentradaocorrencia);
                else $entradaocorrencia = null;
                }catch(\Exception $e){ $entradaocorrencia = null; }

                try{
                if($dtentradagestao != "") $entradagestao = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $dtentradagestao." ".$hrentradagestao);
                else $entradagestao = null;
                }catch(\Exception $e){ $entradagestao = null; }
                
				if($idtipomanif == null || $idtipomanif == ""){
					$data["resp"] = "<div class='alert alert-warning'>O Tipo de manifestação é obrigatório!</div>";
                                }else if($tipoManifCanal == null){
                                    $data["resp"] = "<div class='alert alert-warning'>O Tipo de manifestação e canal não encontrados!</div>";
				}else{
					
					$manifestacao = new \App\Manifestacao();
					$manifestacao->MANIF_ano = date('Y');
					$manifestacao->MANIF_TIPO_CANAL_idTipo = $idtipomanif;
					$manifestacao->MANIF_TIPO_CANAL_idCanal = $idcanal;
					$manifestacao->MANIF_EMPRESA_idEmpresa = $empresa;
					$manifestacao->MANIF_PRODUTO_idProduto = $produto;
					$manifestacao->MANIF_TIPO_CANAL_nrVersao = $tipoManifCanal->TIPO_CANAL_nrVersao;
					//Verificar se o Reclamante ja esta cadastro, senao cadastrar um novo
					$manifestacao->MANIF_RECLAMANTE_idReclamante = 0000;
					//$manifestacao->MANIF_LOCALIDADE_id = 0000000003;
					$manifestacao->MANIF_LOCALIDADE_id = $idlocalidade;
					$manifestacao->MANIF_codReclamanteEmp = $codigo;
					$manifestacao->MANIF_resumo = $resumo;
					$manifestacao->MANIF_completa = $completa;
					$manifestacao->MANIF_dataHora_EntCanal = $entradacanal ;
					$manifestacao->MANIF_dataHora_Ocorrencia = $entradaocorrencia;
					$manifestacao->MANIF_dataHora_EntGestao = $entradagestao;
					$manifestacao->MANIF_dataHora_Cadastro = date('Y-m-d H:i');
					$manifestacao->MANIF_endereco = $endereco;
					$manifestacao->MANIF_referencia = $referencia;
					$manifestacao->MANIF_prazoResposta = $prazoresposta;
					$manifestacao->MANIF_nivel = $nivel;
					$manifestacao->MANIF_RECLAMANTE_idReclamante = 0;
					$manifestacao->MANIF_nrProtocoloCanal = $nprotocolocanal;
					/*
						1 - Aberta
						0 - Cancelada
						2 - Concluida
						3 - Aguardando Informações
						entradacanal
					*/
					$manifestacao->MANIF_status = 1;
					$manifestacao->MANIF_ano = date('y');
					
					$reclamante = new \App\Reclamante();
					
					if($idreclamante != null){
						$manifestacao->MANIF_RECLAMANTE_idReclamante = $idreclamante;
					}else{
						$reclamante->RECLAMANTE_nome = $nome;
						$reclamante->RECLAMANTE_telefone = $telefone;
						$reclamante->RECLAMANTE_celular = $celular;
						$reclamante->RECLAMANTE_email = $email;
					}
					
					$dbname = \App\Config::$dbname;
					\DB::connection(\App\Config::$dbname)
							->
							transaction(function() use($manifestacao, $reclamante, $dbname) {
								if($manifestacao->MANIF_RECLAMANTE_idReclamante == 0){
									$reclamante->save();
									$manifestacao->MANIF_RECLAMANTE_idReclamante = $reclamante->RECLAMANTE_id;
								}
								
								$manifestacao->save();
								/*$usuarioEmpresaDao = new \App\Repository\UsuarioEmpresaDao(new \App\UsuarioEmpresa);
								$lista = $usuarioEmpresaDao->buscarEmailPorIdEmpresa($manifestacao->MANIF_EMPRESA_idEmpresa, 
										$manifestacao->MANIF_nivel);
								if(count($lista) > 0):
									foreach($lista as $l){
										$email = new \App\Email();
										$email->EMAIL_ano = date('Y');
										$email->EMAIL_tipo = 'Nova Manifestacao';
										$email->EMAIL_status = 0;
										$email->EMAIL_destinatario = $l->USUARIO_email;
										
										$email->save();
									}
								endif;*/
								//REDIRECIONAR PARA OUTRA TELA
								/*
								 * Depois de cadastrar a Manifestação deve abrir uma nova tela
	com os serviços (checkbox) ao escolher o serviço devem aparecer os  os prestadores (checkbox) deste serviço
								 */

						});
						$data["resp"] = "<div class='alert alert-success'>Manifestação cadastrada com sucesso!</div>";
						return redirect()->intended('admin/manifestacao/'.$manifestacao->MANIF_ano."/" .$manifestacao->MANIF_id.'/cadastrar-passo2.html');
					}
				}else{
					$data["resp"] = "<div class='alert alert-warning'>Manifestação ja existente!</div>";
				}
            } catch (\Exception $ex) {
				echo $ex->getMessage();
                $data["resp"] = "<div class='alert alert-danger'>Manifestação não pode ser realizada!</div>";
            }
        }
        $lista = $dbempresa->orderBy("EMPRESA_nome")->get();
        $listaR = $dbregiao->orderBy("REGIAO_nome")->get();
        $data["lista"] = $lista;
        $data["listaR"] = $listaR;
        return view('admin.sistema.manifestacao.cadastrar', $data);
    }
    
    public function passo2($ano, $idmanifestacao, Request $request){
        $data = array();
        $manifestacao = new \App\Manifestacao();
        $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
        $manif = $manifDao->buscarId($idmanifestacao, $ano);
        if($manif == null){
            $tipoManifest = new \App\TipoManifestacao();
            $canal = new \App\Canal();
            $localidade = new \App\Localidade();
            
            $listaM = $tipoManifest->get();
            $listaC = $canal->get();
            $listaL = $localidade->get();

            $data["listaM"] = $listaM;
            $data["listaC"] = $listaC;
            $data["listaL"] = $listaL;

            return view('admin.sistema.manifestacao.buscar', $data);
        }
        
        $data["m"] = $manif;
        $data["idmanifestacao"] = $idmanifestacao;
        $data["ano"] = $ano;
		
        return view('admin.sistema.manifestacao.passo2', $data);
    }
    
    public function passo3($ano, $idmanifestacao, Request $request){
        $data = array();
        
        $servicos = new \App\Servico();
        $listaServ = \App\Servico::whereServico_status(1)->orderBy("SERVICO_nome")->get();
        
        if($request->isMethod("POST")){
            try{
                $manifDao = new \App\Repository\ManifestacaoDao(new \App\Manifestacao);
                $idservico = $request->input("servicos");
                $idprestador = $request->input("idprestador");
                $msguser = 
                    \App\MensagemUsuario::whereManifestacao_idAndManifestacao_manif_anoAndServicoprestador_idservicoAndServicoprestador_idprestador($idmanifestacao, $ano, $idservico, $idprestador)->get();
                if(count($msguser) == 0 ){
                    
                    //$serv1 = \App\Servico::whereServico_id($idservico)->first();
                    
                    $mensagemusuario = new \App\MensagemUsuario();
                    $mensagemusuario->MSG_USUARIO_ano = date('Y');
                    $mensagemusuario->MSG_USUARIO_mensagem = $request->input("msginicio");
                    $mensagemusuario->MSG_USUARIO_dataHoraMsg = date('Y-m-d H:i:s');
                    $mensagemusuario->MANIFESTACAO_id = $idmanifestacao;
                    $mensagemusuario->MANIFESTACAO_MANIF_ano = $ano;
                    $mensagemusuario->SERVICOPRESTADOR_idServico = $idservico;
                    $mensagemusuario->SERVICOPRESTADOR_idPrestador = $idprestador;
                    $mensagemusuario->MSG_USUARIO_idUsuario = Auth::user()->USUARIO_id;
                    //enviar email para o usuario prestador
                    $mensagemusuario->save();
                    $data["resp"] = "<div class='alert alert-success'>Prestador Notificado com Sucesso.</div>";
                    
                    $usuarioPrestadorDao = new \App\Repository\UsuarioPrestadorDao(new \App\UsuarioPrestador);
                    $listaP = $usuarioPrestadorDao->buscarEmailPorIdPrestador($idprestador);
                    
                    $m = $manifDao->buscarId($idmanifestacao, $ano);
                
                    if(count($listaP) > 0):
                        foreach ($listaP as $p):
                        //echo "Email: " . $p["USUARIO_email"];
                        if($p["USUARIO_email"] != ""){
                            
                            $dtAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                            $entradaCanal= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_EntCanal)->addHours($m->MANIF_prazoResposta);
                            $segundos = $dtAtual->diffInSeconds($entradaCanal); // 3
                            
                            $dias = floor($segundos / (60 * 60 * 24));
                            $dias_mod = $segundos % (60 * 60 * 24);

                            $horas = floor($dias_mod / (60 * 60));
                            $horas_mod = $dias_mod % (60 * 60);

                            $minutos = floor($horas_mod / 60);
                            $segundos_f = $horas_mod % 60;
                            $dtformat = "";
                            
                            if($dtAtual > $entradaCanal){
                                $dtformat = "-" . $dias . " " . $horas . ":".$minutos.":".$segundos_f;
                            }else{
                                $dtformat = $dias . " " . $horas . ":".$minutos.":".$segundos_f;
                            }
                            
                            $dtformat = $entradaCanal->format("dd/MM/yyyy HH:ii:ss");
                        
                            
                            
						//echo $p["USUARIO_email"];
                            try{
                                $headers = "MIME-Version: 1.1\r\n";
                                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                                $headers .= "From: contato.eureclamo@gmail.com\r\n"; // remetente
                                $headers .= "Return-Path: contato.eureclamo@gmail.com\r\n"; // return-path
                                //$envio = mail("marques.coti@gmail.com", "EU RECLAMO::Manifestação", ""
                                $envio = mail($p["USUARIO_email"], "EU RECLAMO::Manifestação", ""
                                        . "Prezados Senhores, ".
                        " <br><br>

    Foi recebida uma ".$m->TIPOMANIF_nome." pela ".$m->EMPRESA_nome."  cujo serviço foi prestado por sua empresa.<br><br>

    Esta ".$m->TIPOMANIF_nome." deve ser respondida por sua empresa até " .$dtformat. ".<br><br>

    Para ver e responder a reclamação acesse o link abaixo:<br><br>

    http://nequals.com.br/eureclamo/admin/public/manifestacao/".$ano."/".$idmanifestacao."/prestador.html
    <br><br>
    Não responda este e-mail. Respostas através do e-mail serão desconsideradas. 
    <br><br>
    Atenciosamente<br>
   ".$m->EMPRESA_nome." <br>
    Gestão de Fornecedores", $headers);
                            } catch (Exception $ex) {

                            }
                        }
                        endforeach;
                    endif;
                    
                }else{
                    //$data["resp"] = "<div class='alert alert-info'>Manifestação ja cadastrada!</div>";    
                    $data["resp"] = "<div class='alert alert-info'>Prestador ja cadastrado!</div>";    
                }
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-info'>Manifestação não adicionado!</div>";
            }
        }
        $msgUsuarioDao = new \App\Repository\MensagemUsuarioDao(new \App\MensagemUsuario);
        $data["idmanifestacao"] = $idmanifestacao;
        $data["ano"] = $ano;
        $data["listaServ"] = $listaServ;
		
	
        $listaMsg = $msgUsuarioDao->buscarPorManifestacao($idmanifestacao, $ano);
        $data["listaMsg"] = $listaMsg;
        
        return view('admin.sistema.manifestacao.passo3', $data);
    }
    
     
    
    public function buscar(Request $request){
        date_default_timezone_set('America/Sao_Paulo');
        $data = array();
        $tipoManifest = new \App\TipoManifestacao();
        $canal = new \App\Canal();
        $localidade = new \App\Localidade();
        $manifestacao = new \App\Manifestacao();
                $manifestacaoDao = new \App\Repository\ManifestacaoDao($manifestacao);
        $data["horario"] = "Consulta realizada em " . date('d/m/Y H:i:s');
        if($request->isMethod("POST")){
            try{
                
                $idcanal = $request->input("idcanal");
                $idtipo = $request->input("idtipo");
                $idlocalidade = $request->input("idlocalidade");
                $dtentradaocorrencia = $request->input("dtentradaocorrencia");
                $codigo = $request->input("codigo");
                $nivel = $request->input("nivel");
                
                if($dtentradaocorrencia != ""){
                    $entrada = \Carbon\Carbon::createFromFormat('d/m/Y', $dtentradaocorrencia);
                }else{
                    $entrada = "";
                }
                
                $lista = $manifestacaoDao->buscar($idcanal, $idtipo, $idlocalidade, 
                        $entrada, $nivel, $codigo);
                $data["tipoManif"] = $tipoManifest->whereTipomanif_id($idtipo)->first();
                $data["listaManif"] = $lista;
                
            } catch (Exception $ex) {
                $data["resp"] = "<div class='alert alert-warning'>Consulta da manifestação não pode ser realizada!</div>";
            }
        }else{
            $lista = $manifestacaoDao->buscar("", "", "", "", "", "");
            $data["listaManif"] = $lista;
        }
        
        $listaM = $tipoManifest->whereTipomanif_status(1)->get();
        $listaC = $canal->whereCanal_status(1)->get();
        $listaL = $localidade->get();
        
        $data["listaM"] = $listaM;
        $data["listaC"] = $listaC;
        $data["listaL"] = $listaL;
        
        return view('admin.sistema.manifestacao.buscar', $data);
    }
    
    public function buscarreclamante(Request $request){
        $email = $request->input("email");
        $reclamante = new \App\Reclamante();
        
        if($email == ""){
            echo "0";
            
        }else{
            $rec = $reclamante->whereReclamante_email($email)->get();

            if(!isset($rec) || count($rec) == 0){
                echo "0";
            }else{
                echo $rec;
            }
        }
        
    }
    
    public function buscartipomanifestacao(Request $request){
        $id = $request->input("idcanal");
        $tipoManifest = new \App\TipoManifestacao();
        $tipoDao = new \App\Repository\TipoManifestacaoDao($tipoManifest);
        
        $tipos = $tipoDao->buscarIdCanal($id);
        if(count($tipos) > 0){
            echo "Tipos: ";
            
            echo "<select name='tipomanif' id='tipomanif' required class='form-control'>";
            echo "<option data-value='0' value='0'></option>";
            foreach ($tipos as $t){
                echo "<option data-value='".$t->TIPO_CANAL_PrazoPadrao."' value='" . $t->TIPOMANIF_id. "'>".$t->TIPOMANIF_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "<div class='alert alert-warning'>Não existe tipo de manifestação para este canal!</div>";
        }
    }
     
    public function buscarprodutoempresa(Request $request){
        $id = $request->input("idempresa");
        $prodEmpresa = new \App\ProdutoEmpresa();
        $prodEmpresaDao = new \App\Repository\ProdutoEmpresaDao($prodEmpresa);
        $produtos = $prodEmpresaDao->buscarId($id);
        
        if(count($produtos) > 0){
            echo "Produtos: ";
            
            echo "<select name='produto' id='produto' required class='form-control'>";
            echo "<option value='0'></option>";
            foreach ($produtos as $p){
                echo "<option value='" . $p->PRODUTO_id. "'>".$p->PRODUTO_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "<div class='alert alert-warning'>Não existe produtos para esta empresa!</div>";
        }
    }
    
    public function buscaruf(Request $request){
        $id = $request->input("idregiao");
        $uf = new \App\Uf();
        
        $lista = $uf->whereRegiao_id($id)->get();
        
        if(count($lista) > 0){
            echo "UF: ";
            
            echo "<select name='ufs' id='ufs' required class='form-control'>";
            echo "<option value='0'></option>";
            foreach ($lista as $u){
                echo "<option value='" . $u->UF_id. "'>".$u->UF_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "<div class='alert alert-warning'>Não existe ufs para esta região!</div>";
        }
    }
    
    public function buscarlocalidade(Request $request){
        $id = $request->input("iduf");
        $localidade = new \App\Localidade();
        
        $lista = $localidade->whereUf_id($id)->get();
        
        if(count($lista) > 0){
            echo "Localidade: ";
            
            echo "<select name='idlocalidade' id='idlocalidade' required class='form-control'>";
            echo "<option value='0'></option>";
            foreach ($lista as $l){
                echo "<option value='" . $l->LOCALIDADE_id. "'>".$l->LOCALIDADE_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "<div class='alert alert-warning'>Não existe localidade para este UF!</div>";
        }
    }
 
    public function detalhes($ano, $id, Request $request){
        $data = array();
        $manifestacao = new \App\Manifestacao();
        $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
        $manif = $manifDao->buscarId($id, $ano);
        $idusuariologado = \Auth::user()->USUARIO_id;
        if($manif == null){
            $tipoManifest = new \App\TipoManifestacao();
            $canal = new \App\Canal();
            $localidade = new \App\Localidade();
            
            $listaM = $tipoManifest->get();
            $listaC = $canal->get();
            $listaL = $localidade->get();

            $data["listaM"] = $listaM;
            $data["listaC"] = $listaC;
            $data["listaL"] = $listaL;

            return view('admin.sistema.manifestacao.buscar', $data);
        }
        
        if($request->isMethod("POST")){
            
            $msgresposta = $request->input("msgresposta");
            $idmanif = $request->input("idmanif");
            $anomanif = $request->input("anomanif");
            $idprestador = $request->input("idprestador");
            $idservico = $request->input("idservico");
            
            $mensagemUsuario = new \App\MensagemUsuario();
            $mensagemUsuario->MSG_USUARIO_ano = date('Y');
            $mensagemUsuario->MSG_USUARIO_mensagem = $msgresposta;
            $mensagemUsuario->MSG_USUARIO_dataHoraMsg = date('Y-m-d H:i:s');
            $mensagemUsuario->MANIFESTACAO_id = $idmanif;
            $mensagemUsuario->MANIFESTACAO_MANIF_ano = $anomanif;
            $mensagemUsuario->SERVICOPRESTADOR_idServico = $idservico;
            $mensagemUsuario->SERVICOPRESTADOR_idPrestador = $idprestador;
            $mensagemUsuario->MSG_USUARIO_idUsuario = $idusuariologado;
              
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
        return view('admin.sistema.manifestacao.detalhes', $data);
    }
    
    public function anexosexcluir($id, $ano, Request $request){
        $data = array();
        try{
            //excluir o anexo
            $idanexo = $request->input("idanexo");
            
            $anexomanif = new \App\AnexoManifestacao();
            $anexo = \App\AnexoManifestacao::find($idanexo);
            @unlink(public_path('anexos') . "/" . $anexo->ANEXO_MANIF_nomeArq);
            
            $anexo->delete();
            $msg = "Anexo excluído com sucesso!";
            $data["resp"] = "<div class='alert alert-success'>" . $msg . "</div>";
        }  catch (\Exception $e){
            //echo $e->getMessage();
            $msg = "Anexo não pode ser adicionado!";
            $data["resp"] = "<div class='alert alert-danger'>" . $msg . "</div>";
        }
        try{
            $manifestacao = new \App\Manifestacao();
            $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
            $manif = $manifDao->buscarId($id, $ano);
            if($manif == null){
                $tipoManifest = new \App\TipoManifestacao();
                $canal = new \App\Canal();
                $localidade = new \App\Localidade();

                $listaM = $tipoManifest->get();
                $listaC = $canal->get();
                $listaL = $localidade->get();

                $data["listaM"] = $listaM;
                $data["listaC"] = $listaC;
                $data["listaL"] = $listaL;

                return view('admin.sistema.manifestacao.buscar', $data);
            }

            $data["m"] = $manif;
        }catch(\Exception $e){
            
        }
        return view('admin.sistema.manifestacao.passo2', $data);
    }
    
    public function anexos($id, $ano, Request $request){
        $data = array();
        try{
            if ($request->hasFile('anexo')) {
                $file = $request->file('anexo');
                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $msg = "";

                //if($size > (1024 * 1024 * 1)){
                if($size > (1024 * 300)){
                    $msg = "Tamanho máximo de 300kb.<br>";
                }

                if($ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "pdf" && $ext != "doc"){
                    $msg = "Arquivo possui um formato inválido.";
                }
                
                if($msg == ""){
                    $fileName = 'manif_'.$id.date('YmdHis').rand(111,999).'.'.$ext; // renameing image
                    $anexoManif = new \App\AnexoManifestacao();
                    
                    $anexoManif->ANEXO_MANIF_nomeArq = $fileName;
                    $anexoManif->ANEXO_MANIF_tipoArq = $ext;
                    $anexoManif->ANEXO_MANIF_arquivo = base64_encode(file_get_contents($file->getRealPath()));
                    $anexoManif->MANIF_id = $id;
                    $anexoManif->MANIF_ano = $ano;
                    
                    if($anexoManif->save()){
                        $file->move("anexos", $fileName);
                        $msg = "Anexo adicionado com sucesso!";
                        $data["resp"] = "<div class='alert alert-success'>" . $msg . "</div>";
                    }else{
                        $msg = "Anexo não pode ser adicionado!";
                        $data["resp"] = "<div class='alert alert-info'>" . $msg . "</div>";
                    }
                }else{
                    $data["resp"] = "<div class='alert alert-info'>" . $msg . "</div>";
                }
            }
        }  catch (\Exception $e){
            //echo $e->getMessage();
            $msg = "Anexo não pode ser adicionado!";
            $data["resp"] = "<div class='alert alert-danger'>" . $msg . "</div>";
        }
        try{
            $manifestacao = new \App\Manifestacao();
            $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
            $manif = $manifDao->buscarId($id, $ano);
            if($manif == null){
                $tipoManifest = new \App\TipoManifestacao();
                $canal = new \App\Canal();
                $localidade = new \App\Localidade();

                $listaM = $tipoManifest->get();
                $listaC = $canal->get();
                $listaL = $localidade->get();

                $data["listaM"] = $listaM;
                $data["listaC"] = $listaC;
                $data["listaL"] = $listaL;

                return view('admin.sistema.manifestacao.buscar', $data);
            }

            $data["m"] = $manif;
        }catch(\Exception $e){
            
        }
        return view('admin.sistema.manifestacao.passo2', $data);
    }
    
    public function reclamantes(Request $request){
        $data = array();
        try{
            if($request->isMethod("POST")){
                $opc = $request->input("opc");
                
                if($opc == "cadastrar"){
                    $nome = $request->input("nome");
                    $telefone = $request->input("telefone");
                    $celular = $request->input("celular");
                    $email = $request->input("email");

                    $rec = new \App\Reclamante();
                    $rec->RECLAMANTE_nome = $nome;
                    $rec->RECLAMANTE_email = $email;
                    $rec->RECLAMANTE_telefone = $telefone;
                    $rec->RECLAMANTE_celular = $celular;

                    if($rec->save()){
                        $data["resp"] = "<div class='alert alert-success'>Reclamante cadastrado com sucesso.</div>";
                    }else{
                        $data["resp"] = "<div class='alert alert-info'>Reclamante não cadastrado.</div>";
                    }
                }else{
                    $nome = $request->input("nome");
                    $data["listaRec"] = \App\Reclamante::where("RECLAMANTE_nome", "like", $nome . "%")->orderBy('RECLAMANTE_nome', 'asc')->get();
                }

            }else{
                $data["listaRec"] = \App\Reclamante::orderBy('RECLAMANTE_nome', 'asc')->get();
            }
        }  catch (\Exception $e){
            $data["resp"] = "<div class='alert alert-danger'>Reclamante não cadastrado.</div>";
        }
        return view('admin.sistema.manifestacao.reclamantes', $data);
    }
    
    public function concluir($id, $ano, Request $request){
        $data = array();
        try{
            if($request->isMethod("POST")){
                
                $parecer = $request->input("parecer");
                $respreclamante = $request->input("respreclamante");
                
                $conc = \App\Conclusao::whereManifestacao_manif_idAndManifestacao_manif_ano($id, $ano)->first();
                if($conc == null){
                    $conclusao = new \App\Conclusao();
                    
                    $conclusao->CONCLUSAO_parecer = $parecer;
                    $conclusao->CONCLUSAO_respReclamante = $respreclamante;
                    $conclusao->CONCLUSAO_dataHora = date('Y-m-d H:i:s');
                    $conclusao->MANIFESTACAO_MANIF_id = $id;
                    $conclusao->MANIFESTACAO_MANIF_ano = $ano;
                    
                    $manifestacao = \App\Manifestacao::whereManif_idAndManif_ano($id, $ano)->first();
                    
                    $dbname = \App\Config::$dbname;
                    \DB::connection(\App\Config::$dbname)
                        ->
                        transaction(function() use($manifestacao, $conclusao, $dbname) {
                            $manifestacao->MANIF_status = 0;
                            $manifestacao->save();
                            $conclusao->save();

                    });
                    $data["resp"] = "<div class='alert alert-success'>Manifestação concluída com sucesso.</div>";
                    
                }else{
                    $data["resp"] = "<div class='alert alert-info'>Manifestação ja concluída.</div>";
                }
            }
        }  catch (\Exception $e){
            echo $e->getMessage();
            $data["resp"] = "<div class='alert alert-danger'>Manifestação não pode ser concluída.</div>";
        }
        
        try{
            $manifestacao = new \App\Manifestacao();
            $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
            $manif = $manifDao->buscarId($id);
            if($manif == null){
                $tipoManifest = new \App\TipoManifestacao();
                $canal = new \App\Canal();
                $localidade = new \App\Localidade();

                $listaM = $tipoManifest->get();
                $listaC = $canal->get();
                $listaL = $localidade->get();

                $data["listaM"] = $listaM;
                $data["listaC"] = $listaC;
                $data["listaL"] = $listaL;

                return view('admin.sistema.manifestacao.buscar', $data);
            }

            $data["m"] = $manif;
        }catch(\Exception $e){
            
        }
        return view('admin.sistema.manifestacao.detalhes', $data);
    }
    
    public function mensagens($id, $ano, Request $request){
        $data = array();
        $manifestacao = new \App\Manifestacao();
        $servico= new \App\Servico();
        $manifDao = new \App\Repository\ManifestacaoDao($manifestacao);
        $manif = $manifDao->buscarId($id);
        
        if($request->isMethod("POST")){
            
            try{
            $msg = $request->input("msg");
            $idservico = $request->input("servico");
            $idprestador = $request->input("idprestador");
            
            $mensagemUsuario = new \App\MensagemUsuario();
            $mensagemUsuario->MSG_USUARIO_ano = date('Y');
            $mensagemUsuario->MSG_USUARIO_mensagem = $msg;
            $mensagemUsuario->MSG_USUARIO_dataHoraMsg = date('Y-m-d H:i:s');
            $mensagemUsuario->MANIFESTACAO_id = $id;
            $mensagemUsuario->MANIFESTACAO_MANIF_ano = $ano;
            $mensagemUsuario->SERVICOPRESTADOR_idServico = $idservico;
            $mensagemUsuario->SERVICOPRESTADOR_idPrestador = $idprestador;
            $mensagemUsuario->MSG_USUARIO_idUsuario = \Auth::user()->USUARIO_id;
            
            $valido = true;
            $msg = "";
            
            $arquivo1 = "";
            $file1 = null;
            $ext1 = "";
            
            $arquivo2 = "";
            $file2 = null;
            $ext2 = "";
            
            $arquivo3 = "";
            $file3 = null;
            $ext3 = "";
            
            $arquivo4 = "";
            $file4 = null;
            $ext4 = "";
            
            $arquivo5 = "";
            $file5 = null;
            $ext5 = "";
            
            //Arquivo 1
            if ($request->hasFile('arquivo1')) {
                $file1 = $request->file('arquivo1');
                $ext1 = $file1->getClientOriginalExtension();
                $size = $file1->getSize();

                if($size > (1024 * 1024 * 2)){
                    $msg = "Tamanho máximo de 2mb.<br>";
                    throw  new \Exception($msg);
                }

                if($ext1 != "jpg" && $ext1 != "jpeg" && $ext1 != "png" && $ext1 != "pdf" && $ext1 != "doc"){
                    $msg = "Arquivo possui um formato inválido.";
                    throw  new \Exception($msg);
                }
                $arquivo1 = 'anexo_'.$id.date('YmdHis').rand(111,999).'.'.$ext1; // renameing image

                    //$anexoManif->ANEXO_MANIF_nomeArq = $fileName;
                    //$anexoManif->ANEXO_MANIF_tipoArq = $ext;
                    //$anexoManif->ANEXO_MANIF_arquivo = base64_encode(file_get_contents($file->getRealPath()));
                    //$anexoManif->MANIF_id = $id;
                    //$anexoManif->MANIF_ano = $ano;


                        //$file->move("anexos", $fileName);
            }

            if ($request->hasFile('arquivo2')) {
                $file2 = $request->file('arquivo2');
                $ext2 = $file2->getClientOriginalExtension();
                $size = $file2->getSize();

                if($size > (1024 * 1024 * 2)){
                    $msg = "Tamanho máximo de 2mb.<br>";
                    throw  new \Exception($msg);
                }

                if($ext2 != "jpg" && $ext2 != "jpeg" && $ext2 != "png" && $ext2 != "pdf" && $ext2 != "doc"){
                    $msg = "Arquivo possui um formato inválido.";
                    throw  new \Exception($msg);
                }
                $arquivo2 = 'anexo_2'.$id.date('YmdHis').rand(111,999).'.'.$ext2; // renameing image
            }
            
            if ($request->hasFile('arquivo3')) {
                $file3 = $request->file('arquivo3');
                $ext3 = $file3->getClientOriginalExtension();
                $size = $file3->getSize();

                if($size > (1024 * 1024 * 2)){
                    $msg = "Tamanho do arquivo 3 deve ter máximo de 2mb.<br>";
                    throw  new \Exception($msg);
                }

                if($ext3 != "jpg" && $ext3 != "jpeg" && $ext3 != "png" && $ext3 != "pdf" && $ext3 != "doc"){
                    $msg = "Arquivo 3 possui um formato inválido.";
                    throw  new \Exception($msg);
                }
                $arquivo3 = 'anexo_3'.$id.date('YmdHis').rand(111,999).'.'.$ext3; // renameing image
            }
            
            if ($request->hasFile('arquivo4')) {
                $file4 = $request->file('arquivo4');
                $ext4 = $file4->getClientOriginalExtension();
                $size = $file4->getSize();

                if($size > (1024 * 1024 * 2)){
                    $msg = "Tamanho do arquivo 4 deve ter máximo de 2mb.<br>";
                    throw  new \Exception($msg);
                }

                if($ext4 != "jpg" && $ext4 != "jpeg" && $ext4 != "png" && $ext4 != "pdf" && $ext4 != "doc"){
                    $msg = "Arquivo 5 possui um formato inválido.";
                    throw  new \Exception($msg);
                }
                $arquivo4 = 'anexo_4'.$id.date('YmdHis').rand(111,999).'.'.$ext4; // renameing image
            }
            
            if ($request->hasFile('arquivo5')) {
                $file5 = $request->file('arquivo5');
                $ext5 = $file5->getClientOriginalExtension();
                $size = $file5->getSize();

                if($size > (1024 * 1024 * 2)){
                    $msg = "Tamanho do arquivo 5 deve ter máximo de 2mb.<br>";
                    throw  new \Exception($msg);
                }

                if($ext5 != "jpg" && $ext5 != "jpeg" && $ext5 != "png" && $ext5 != "pdf" && $ext5 != "doc"){
                    $msg = "Arquivo 5 possui um formato inválido.";
                    throw  new \Exception($msg);
                }
                $arquivo5 = 'anexo_5'.$id.date('YmdHis').rand(111,999).'.'.$ext5; // renameing image
            }
            
            $dbname = \App\Config::$dbname;
            \DB::connection(\App\Config::$dbname)
                ->
                transaction(function() use($mensagemUsuario, $dbname, 
                    $arquivo1,$file1,$ext1, 
                    $arquivo2,$file2,$ext2,  
                    $arquivo3,$file3,$ext3,
                    $arquivo4,$file4,$ext4,
                    $arquivo5,$file5,$ext5) {
                    
                    $mensagemUsuario->save();
                    if($arquivo1 != ""){
                        $anexoMsg1 = new \App\AnexoMensagem();
                        $anexoMsg1->ANEXO_MSG_nomeArq = $arquivo1;
                        $anexoMsg1->ANEXO_MSG_tipoArq = $ext1;
                        $anexoMsg1->ANEXO_MSG_arquivo = base64_encode(file_get_contents($file1->getRealPath()));;
                        $anexoMsg1->MSG_USUARIO_id = $mensagemUsuario->MSG_USUARIO_id;
                        $anexoMsg1->MSG_USUARIO_ano = $mensagemUsuario->MSG_USUARIO_ano;
                        $file1->move("anexos", $arquivo1);
                        $anexoMsg1->save();
                    }
                    
                    if($arquivo2 != ""){
                        $anexoMsg2 = new \App\AnexoMensagem();
                        $anexoMsg2->ANEXO_MSG_nomeArq = $arquivo2;
                        $anexoMsg2->ANEXO_MSG_tipoArq = $ext2;
                        $anexoMsg2->ANEXO_MSG_arquivo = base64_encode(file_get_contents($file2->getRealPath()));;
                        $anexoMsg2->MSG_USUARIO_id = $mensagemUsuario->MSG_USUARIO_id;
                        $anexoMsg2->MSG_USUARIO_ano = $mensagemUsuario->MSG_USUARIO_ano;
                        $file2->move("anexos", $arquivo2);
                        $anexoMsg2->save();
                    }
                    
                    if($arquivo3 != ""){
                        $anexoMsg3 = new \App\AnexoMensagem();
                        $anexoMsg3->ANEXO_MSG_nomeArq = $arquivo3;
                        $anexoMsg3->ANEXO_MSG_tipoArq = $ext3;
                        $anexoMsg3->ANEXO_MSG_arquivo = base64_encode(file_get_contents($file3->getRealPath()));;
                        $anexoMsg3->MSG_USUARIO_id = $mensagemUsuario->MSG_USUARIO_id;
                        $anexoMsg3->MSG_USUARIO_ano = $mensagemUsuario->MSG_USUARIO_ano;
                        $file3->move("anexos", $arquivo3);
                        $anexoMsg3->save();
                    }
                    
                    if($arquivo4 != ""){
                        $anexoMsg4 = new \App\AnexoMensagem();
                        $anexoMsg4->ANEXO_MSG_nomeArq = $arquivo4;
                        $anexoMsg4->ANEXO_MSG_tipoArq = $ext4;
                        $anexoMsg4->ANEXO_MSG_arquivo = base64_encode(file_get_contents($file4->getRealPath()));;
                        $anexoMsg4->MSG_USUARIO_id = $mensagemUsuario->MSG_USUARIO_id;
                        $anexoMsg4->MSG_USUARIO_ano = $mensagemUsuario->MSG_USUARIO_ano;
                        $file4->move("anexos", $arquivo4);
                        $anexoMsg4->save();
                    }
                    
                    if($arquivo5 != ""){
                        $anexoMsg5 = new \App\AnexoMensagem();
                        $anexoMsg5->ANEXO_MSG_nomeArq = $arquivo5;
                        $anexoMsg5->ANEXO_MSG_tipoArq = $ext5;
                        $anexoMsg5->ANEXO_MSG_arquivo = base64_encode(file_get_contents($file5->getRealPath()));;
                        $anexoMsg5->MSG_USUARIO_id = $mensagemUsuario->MSG_USUARIO_id;
                        $anexoMsg5->MSG_USUARIO_ano = $mensagemUsuario->MSG_USUARIO_ano;
                        $file5->move("anexos", $arquivo5);
                        $anexoMsg5->save();
                    }
                    
                    $usuarioPrestadorDao = new \App\Repository\UsuarioPrestadorDao(new \App\UsuarioPrestador);
                    $lista = $usuarioPrestadorDao->buscarEmailPorIdEmpresa($mensagemUsuario->SERVICOPRESTADOR_idPrestador, 
                            3);
                    if(count($lista) > 0):
                        foreach($lista as $l){
                            $email = new \App\Email();
                            $email->EMAIL_ano = date('Y');
                            $email->EMAIL_tipo = 'Nova Mensagem';
                            $email->EMAIL_status = 0;
                            $email->EMAIL_destinatario = $l->USUARIO_email;

                            $email->save();
                        }
                    endif;
            });
            
            $data["resp"] = "<div class='alert alert-success'>Mensagem cadastrada com sucesso!</div>";
            
            }  catch (\Exception $e){
                $data["resp"] = "<div class='alert alert-info'>" . $e->getMessage() . "</div>";
            }
            
            
        }
        
        try{
            //$mensagemUsuarios = \App\MensagemUsuario::whereManifestacao_idAndManifestacao_manif_ano($id, $ano)
            //        ->orderBy('MSG_USUARIO_dataHoraMsg', 'desc')->get();
            //$data["listaMsg"] = $mensagemUsuarios;
        } catch (Exception $ex) {

        }
        
        $data["m"] = $manif;
        $listaS = $servico->orderBy("SERVICO_nome")->get();
        $data["listaS"] = $listaS;
        return view('admin.sistema.manifestacao.mensagens', $data);
    }
    
    public function buscarprestador(Request $request){
        $id = $request->input("idservico");
        $prestador = new \App\Prestador();
        $prestadorDao = new \App\Repository\PrestadorDao($prestador);
        $prestadores = $prestadorDao->buscarPorIdServ($id);
        
        if(count($prestadores) > 0){
            echo "Prestadores: ";
            
            echo "<select name='idprestador' id='idprestador' required class='form-control'>";
            echo "<option value='0'></option>";
            foreach ($prestadores as $p){
                echo "<option value='" . $p->PRESTADOR_id. "'>".$p->PRESTADOR_nome."</option>";
            }
            echo "</select>";
            
        }else{
            echo "<div class='alert alert-warning'>Não existe prestadores para esta serviço!</div>";
        }
    }
    
    public function manifestacaomensagem(Request $request){
        $data = array();
        if($request->isMethod("POST")){
            $codigomanif = $request->input("codigomanif", "");
            $codigorec = $request->input("codigorec", "");
            
            $manifestacao = new \App\Manifestacao();
            $manifestacaoDao = new \App\Repository\ManifestacaoDao($manifestacao);
            
            if($codigomanif == "" && $codigorec == ""){
                $data["resp"] = "<div class='alert alert-info'>Preencha algum dos campos para ver as mensagens.</div>";
            }else{
                $man = $manifestacaoDao->buscarCodigos($codigomanif, $codigorec);
                if($man == null || count($man) == 0){
                    $data["resp"] = "<div class='alert alert-info'>Nenhuma manifestação foi encontrada com estes códigos.</div>";
                }else{
                    return redirect()->route('admin::manifestacao::detalhes', ['id' => $man->MANIF_id ]);
                }
            }
            
        }
        return view('admin.sistema.manifestacao.manifestacaomensagens', $data);
    }
    
    public function teste(){
        $email = "marques.coti@gmail.com";
        \Mail::send('email', 
        array('seguradora' => 'Perfeito'), 
        function($message) use($email){
            $message->from("contato.eureclamo@gmail.com");
            $message->to($email);
            $message->subject("Recuperação de Senha");
        });

        
        echo "OK";
    }
}
