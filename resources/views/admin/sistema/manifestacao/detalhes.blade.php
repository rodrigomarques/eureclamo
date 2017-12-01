@extends('admin.layout')

@section('conteudo')
<script>
$(function(){
    $(".anexo").on('click', function(){
        $("#dvanexo").show();
        $("#dvconcluir").hide();
    });
    
    $(".concluir").on('click', function(){
        $("#dvconcluir").show();
        $("#dvanexo").hide();
    });
    
    function esconder(){
        $(".resposta").fadeOut(1000);
    }

    setTimeout(esconder, 4000);

    $(".btnresponder").on('click', function(){
        var idservico = $(this).attr('data-value');
        
        $(".lblresposta").show();
        $(".idservico").val(idservico);

    })
    
    $("#telaencerrar").hide();
    
    $(".btnencerrar").on('click', function(){
        $("#telaencerrar").show();
    })
    
})    
</script>
<style>
    .linha{
        margin-bottom: 20px;
    }
</style>
<div class="col-xs-12">
    <h3 class="page-header" id="titulo">Detalhes Manifestação</h3>
    <div class="row">
    <div class="col-xs-12">
        @if($m->MANIF_status != 3)
        
        <form method="post" action="{{ route('admin::manifestacao::concluirmanifestacao') }}" >
            <a href="#" class="btn btn-info btnencerrar">Encerrar Manifestação</a>
            <a href="{{ route('admin::manifestacao::passo3', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" 
                        class="btn btn-primary">Notificar Novos Prestadores</a>
            
            <div id="telaencerrar">
                <div class="form-group">
                    Parecer:
                    <textarea name="parecer" id="parecer" required class="form-control"></textarea>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" name="idmanif" value="{{ $m->MANIF_id }}" >
                <input type="hidden" name="anomanif" value="{{ $m->MANIF_ano }}" >
                <input type="submit" value="Encerrar Manifestação" class="btn btn-success">
            </div>
            
        </form>
        
        
       @endif
       
       <br>
       <br>
      <div class="box box-primary">
          <div class="box-body">
              <div class="row">
              <div class="col-xs-3 linha">
                <b>Empresa: <br></b>
                {{ $m->EMPRESA_nomeCompleto }}
              </div>
              <div class="col-xs-3 linha">
                <b>Tipo Manifestação: <br></b>
                {{ $m->TIPOMANIF_nome }}
              </div>
              <div class="col-xs-2 linha">
                <b>Nível: <br></b>
                {{ $m->MANIF_nivel }}
              </div>
              <div class="col-xs-2 linha">
                  <b>Canal: <br></b>
                {{ $m->CANAL_nome }}
              </div>
                  <div class="col-xs-2 linha">
                  <b>Código do Reclamante: <br></b>
                {{ $m->MANIF_codReclamanteEmp }}
              </div>
              </div>
              
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Nome Reclamante: <br></b>
                {{ $m->RECLAMANTE_nome }}
              </div>
                  <div class="col-xs-3 linha">
                <b>Produto: <br></b>
                {{ $m->PRODUTO_nome }}
              </div>
              <div class="col-xs-2 linha">
                <b>Código da Manifestação: <br></b>
                {{ $m->MANIF_EMPRESA_idEmpresa }}{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_Cadastro)->format('Ymd') }}{{ $m->MANIF_id }}
              </div>
              
              </div>
              <div class="row">
              <div class="col-xs-3 linha">
                <b>Data da Entrada no Canal: <br></b>
                @if($m->MANIF_dataHora_EntCanal != NULL)
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_EntCanal)->format('d/m/Y H:i') }}
                @endif
              </div>
              <div class="col-xs-3 linha">
                <b>Data da Gestão: <br></b>
                @if($m->MANIF_dataHora_EntGestao != NULL)
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_EntGestao)->format('d/m/Y H:i') }}
                @endif
              </div>
              </div>
              <div class="row">
              <div class="col-xs-3 linha">
                <b>Data da Ocorrencia: </b>
                @if($m->MANIF_dataHora_Ocorrencia != NULL)
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_Ocorrencia)->format('d/m/Y H:i') }}
                @endif
                <br>
                <b>Localidade: </b>
                {{ $m->LOCALIDADE_nome }}
              </div>
              <div class="col-xs-5 linha">
                <b>Endereço: <br></b>
                {{ $m->MANIF_endereco }}
              </div>
              <div class="col-xs-4 linha">
                <b>Referência: <br></b>
                {{ $m->MANIF_referencia }}
              </div>
              </div>
              <?php /*
              <div class="row">
              <div class="col-xs-12 linha">
                <b>Resumo: <br></b>
                {{ $m->MANIF_resumo }}
              </div>
          </div>
          <div class="row">
              <div class="col-xs-3 linha">
                <b>Entrada no canal: <br></b>
                {{ $m->MANIF_dataHora_EntCanal }}
              </div>
              <div class="col-xs-3 linha">
                <b>Data da ocorrência: <br></b>
                {{ $m->MANIF_dataHora_Ocorrencia }}
              </div>
              <div class="col-xs-3 linha">
                <b>Entrada na gestão: <br></b>
                {{ $m->MANIF_dataHora_EntGestao }}
              </div>
              <div class="col-xs-3 linha">
                <b>Prazo de Resposta: <br></b>
                {{ $m->MANIF_prazoResposta }}
              </div>
              </div>
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Endereço: <br></b>
                {{ $m->MANIF_endereco }}
              </div>
              <div class="col-xs-4 linha">
                <b>Referência: <br></b>
                {{ $m->MANIF_referencia }}
              </div>
              <div class="col-xs-4 linha">
                <b>Localidade: <br></b>
                {{ $m->LOCALIDADE_nome }}
              </div>
              </div>
               * */ ?>
              <div class="row">
              <div class="col-xs-12 linha">
                    <b>Completa: <br></b>
                    {{ $m->MANIF_completa }}
              </div>
                  
              </div>
              
              <?php
              $msgUsuarioDao = new App\Repository\MensagemUsuarioDao(new App\MensagemUsuario);
              $msgUsuario = $msgUsuarioDao->buscarPorManifestacao($m->MANIF_id, $m->MANIF_ano);
              ?>
              @if(count($msgUsuario) > 0)
                  <div class="row">
              <div class="col-xs-12 linha">
                    <table class="table table-bordered">
                        <tr>
                            <th>PRESTADOR</th>
                            <th>SERVIÇO</th>
                            <th>DATA</th>
                            <th>MENSAGEM</th>
                            <th></th>
                        </tr>
                     @foreach($msgUsuario as $mm)
                     
                     <tr>
                         <td>{{ $mm->PRESTADOR_nome}}</td>
                         <td>{{ $mm->SERVICO_nome}}</td>
                         <td>
                             @if($mm->MSG_USUARIO_dataHoraMsg != NULL)
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $mm->MSG_USUARIO_dataHoraMsg)->format('d/m/Y H:i') }}
                            @endif
                         </td>
                         <td>{{ $mm->MSG_USUARIO_mensagem }}</td>
                         <td>
                             @if($m->MANIF_status != 3)
                             <a href="#resposta" class="btnresponder btn btn-success" data-value="{{ $mm->SERVICO_id }}">
                                 <span class="fa fa-share"></span>
                             </a>
                             @endif
                         </td>
                     </tr>
                    
                     @endforeach
                     </table>
                  
                 </div>
                 </div>
              @endif
              
              <div class="row">
                  <div class="col-xs-12 linha lblresposta" style="display: none;">
              <form method="post" id="resposta" >
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                        Responder mensagem:
                        <textarea name="msgresposta" class="form-control" rows="3"></textarea>
                      </div>
                      <input type="hidden" name="idmanif" value="{{ $m->MANIF_id }}" >
                      <input type="hidden" name="anomanif" value="{{ $m->MANIF_ano }}" >
                      <input type="hidden" name="idprestador" value="{{ $mm->PRESTADOR_id }}" >
                      <input type="hidden" name="idservico" class="idservico" value="{{ $mm->SERVICO_id }}" >
                      <input type="submit" value="RESPONDER" class="btn btn-primary">
                  </form>
                  </div>
             </div>
              <?php if($m->MANIF_status != 1): ?>
                <div class="row">
                  <div class="col-xs-12 linha">
                      <div class="alert alert-info">
                          MANIFESTAÇÃO CONCLUIDA
                      </div>
                      <?php
                        $msgConclusao = \App\Conclusao::whereManifestacao_manif_idAndManifestacao_manif_ano($m->MANIF_id, $m->MANIF_ano)
                                    ->first();
                        if(isset($msgConclusao) && count($msgConclusao)):
                            echo $msgConclusao->CONCLUSAO_parecer;
                        endif;
                        ?>
                  </div>
                  </div>
                <?php endif;     ?>
              <div class="row">
                  <div class="col-xs-12 linha">
                      <?php
                      $anexo = \App\AnexoManifestacao::whereManif_idAndManif_ano($m->MANIF_id, $m->MANIF_ano)->get();
                      if(isset($anexo) && count($anexo) > 0):
                          foreach($anexo as $an):
                          if($an->ANEXO_MANIF_tipoArq == "jpg" || $an->ANEXO_MANIF_tipoArq == "jpeg" ||
                                  $an->ANEXO_MANIF_tipoArq == "png"){
                                    echo "<div class='col-xs-4'>";
                                    echo "<img src='data:image/" . $an->ANEXO_MANIF_tipoArq . ";base64," . $an->ANEXO_MANIF_arquivo."' class='img-responsive' style='height:100px !important;'>";
                                    echo "</div>";
                                  }else{
                                      echo "<div class='col-xs-4'>";
                                      ?><a href="{{ asset("anexos/" . $an->ANEXO_MANIF_nomeArq) }}" class="btn btn-default" target="_blank">
                                          Download
                                      </a>
                                          <?php
                                    echo "</div>";
                                  }
                          endforeach;
                      endif;
                      ?>
                  </div>
              </div>
          </div>
      </div>
        <?php /*
        <?php if($m->MANIF_status == 1): ?>
            <a href="#dvanexo" class="btn btn-primary anexo">Anexos</a>
            <!--<a href="{{ route('admin::manifestacao::mensagens', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" class="btn btn-success">Mensagens</a>-->
            <a href="#dvconcluir" class="btn btn-default concluir">Concluir</a>
        <?php else: ?>
            <!--<a href="{{ route('admin::manifestacao::mensagens', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" class="btn btn-success">Mensagens</a>-->
        <?php endif; ?>
        <div id="dvanexo" style="display: none;">
            <form method="post" action="{{ route('admin::manifestacao::anexos', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    Anexo:
                    <input type="file" name="anexo" class="form-control">
                </div>
                <input type="submit" value="Adicionar Anexo" class="btn btn-primary">
            </form>
        </div>
        
        <div id="dvconcluir" style="display: none;">
            <form method="post" action="{{ route('admin::manifestacao::concluir', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    Parecer:
                    <textarea name="parecer" id="parecer" class="form-control" required
                              rows="5"></textarea>
                </div>
                <div class="form-group">
                    Resposta Reclamante:
                    <textarea name="respreclamante" id="respreclamante" class="form-control" required
                              rows="5"></textarea>
                </div>
                <input type="submit" value="Concluir" class="btn btn-primary">
            </form>
        </div>
         * 
         */ ?>
    </div>
    </div>
</div>
@endsection