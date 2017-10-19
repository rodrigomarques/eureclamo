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
        
        
        <?php if($m->MANIF_status == 1): ?>
            <a href="#dvanexo" class="btn btn-primary anexo">Anexar Arquivos</a>
            <!--<a href="{{ route('admin::manifestacao::mensagens', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" class="btn btn-success">Mensagens</a>-->
            <a href="{{ route('admin::manifestacao::passo3', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" 
               class="btn btn-default">Notificar Prestadores</a>
        <?php else: ?>
            <!--<a href="{{ route('admin::manifestacao::mensagens', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" class="btn btn-success">Mensagens</a>-->
        <?php endif; ?>
        <div id="dvanexo" style="display: none;">
            <form method="post" action="{{ route('admin::manifestacao::anexos', 
                        ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    Anexo (Limite 300KB):
                    <input type="file" name="anexo" class="form-control">
                </div>
                <input type="submit" value="Adicionar Anexo" class="btn btn-primary">
            </form>
        </div>
        
        
      <div class="box box-primary">
          <div class="box-body">
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Código da manifestação: <br></b>
                {{ $m->MANIF_EMPRESA_idEmpresa }}{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_Cadastro)->format('Ymd') }}{{ $m->MANIF_id }}
              </div>
              <div class="col-xs-4 linha">
                <b>Nível: <br></b>
                {{ $m->MANIF_nivel }}
              </div>
              <div class="col-xs-4 linha">
                  <b>Canal: <br></b>
                {{ $m->CANAL_nome }}
              </div>
              </div>
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Nome Reclamante: <br></b>
                {{ $m->RECLAMANTE_nome }}
              </div>
                  <div class="col-xs-4 linha">
                <b>E-mail: <br></b>
                {{ $m->RECLAMANTE_email }}
              </div>
              <div class="col-xs-4 linha">
                <b>Celular: <br></b>
                {{ $m->RECLAMANTE_celular }}
              </div>
              </div>
              <div class="row">
              <div class="col-xs-4 linha">
                  <b>Telefone: <br></b>
                {{ $m->RECLAMANTE_telefone }}
              </div>
              <div class="col-xs-4 linha">
                  <b>Código do reclamante: <br></b>
                  {{ $m->MANIF_codReclamanteEmp }}
                   
              </div>
              <div class="col-xs-4 linha">
                  <b>Número do Protocolo Canal: <br></b>
                  {{ $m->MANIF_nrProtocoloCanal }}
                    
              </div>
              </div>
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Empresa: <br></b>
                {{ $m->EMPRESA_nomeCompleto }}
              </div>
              <div class="col-xs-4 linha">
                <b>Produto: <br></b>
                {{ $m->PRODUTO_nome }}
              </div>
              <div class="col-xs-4 linha">
                <b>Tipo: <br></b>
                {{ $m->TIPOMANIF_nome }}
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 linha">
                <b>Resumo: <br></b>
                {{ $m->MANIF_resumo }}
              </div>
          </div>
          <div class="row">
              <div class="col-xs-3 linha">
                <b>Entrada no canal: <br></b>
                @if($m->MANIF_dataHora_EntCanal != NULL)
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_EntCanal)->format('d/m/Y H:i') }}
                @endif
              </div>
              <div class="col-xs-3 linha">
                <b>Data da ocorrência: <br></b>
                @if($m->MANIF_dataHora_Ocorrencia != NULL)
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_Ocorrencia)->format('d/m/Y H:i') }}
                @endif
              </div>
              <div class="col-xs-3 linha">
                <b>Entrada na gestão: <br></b>
                @if($m->MANIF_dataHora_EntGestao != NULL)
                {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_EntGestao)->format('d/m/Y H:i') }}
                @endif
              </div>
              <div class="col-xs-3 linha">
                <b>Prazo de Resposta (Horas): <br></b>
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
                  
                     @foreach($msgUsuario as $mm)
                     <div class="row">
              <div class="col-xs-12 linha">
                    <table class="table table-bordered">
                        <tr>
                            <th>PRESTADOR</th>
                            <th>SERVIÇO</th>
                            <th>DATA</th>
                            <th>MENSAGEM</th>
                        </tr>
                     <tr>
                         <td>{{ $mm->PRESTADOR_nome}}</td>
                         <td>{{ $mm->PRESTADOR_nome}}</td>
                         <td>{{ $mm->MSG_USUARIO_dataHoraMsg}}</td>
                         <td>{{ $mm->MSG_USUARIO_mensagem }}</td>
                     </tr>
                     </table>
                 </div>
                 </div>
                     @endforeach
                    
              @endif
              
              <?php if($m->MANIF_status != 1): ?>
                <div class="row">
                  <div class="col-xs-12 linha">
                      <div class="alert alert-info">
                          MANIFESTAÇÃO CONCLUIDA
                      </div>
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
                                    ?>
                                    <form method="post" action="{{ route('admin::manifestacao::anexosexcluir', 
                                      ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="idanexo" value="{{ $an->ANEXO_MANIF_idAnexo }}">
                                        <input type="submit" value="X" class="btn btn-danger">
                                    </form>
                                    <?php
                                    echo "</div>";
                                  }else{
                                      echo "<div class='col-xs-4'>";
                                      ?><a href="{{ asset("anexos/" . $an->ANEXO_MANIF_nomeArq) }}" class="btn btn-default" target="_blank">
                                          Download
                                      </a>
                                        <form method="post" action="{{ route('admin::manifestacao::anexosexcluir', 
                                          ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano ]) }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="idanexo" value="{{ $an->ANEXO_MANIF_idAnexo }}">
                                            <input type="submit" value="X" class="btn btn-danger">
                                        </form>
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
        
    </div>
    </div>
</div>
@endsection