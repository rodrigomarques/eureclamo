<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EU RECLAMO</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
       
        
    </style>
    
    

            <!-- jQuery 2.2.3 -->
            <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
            <!-- FastClick -->
            <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset('dist/js/app.min.js') }}"></script>
            <!-- Sparkline -->
            <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
            <!-- jvectormap -->
            <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
            <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
            <!-- SlimScroll 1.3.0 -->
            <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
            <!-- ChartJS 1.0.1 -->
            <script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
                <script src="{{ asset('js/jquery.maskMoney.min.js') }}"></script>
                <script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
            <script>
        $(function(){
            function esconder(){
                $(".resposta").fadeOut(1000);
            }
            
            setTimeout(esconder, 4000);
        })    
                </script>
</head>
<body>
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
<div class="container">
    <div class="row">
<div class="col-xs-12 well">
    <h3 class="page-header" id="titulo">Detalhes Manifestação</h3>
    <div class="row">
    <div class="col-xs-12">
        
        Prezados Senhores,<br>
        Sua empresa acaba de receber uma manifestação efetuada por um cliente junto aos nossos Canais de 
        Atendimento.<br>
        Observe o prazo indicado para sua resposta.
        
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
                {{ $m->MANIF_id }}
              </div>
              <div class="col-xs-3 linha">
                  <b>Serviço: <br></b>
                 ----------- BUSCAR AINDA -----------
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
                  <div class="col-xs-offset-3 col-xs-3 linha">
                      <div class="alert alert-danger">
                    <b>Prazo de resposta: <br></b>
                    <?php
                        $dtAtual = \Carbon\Carbon::now('America/Sao_Paulo');
                        $entradaCanal= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_EntCanal)->addHours($m->MANIF_prazoResposta);
                        $segundos = $dtAtual->diffInSeconds($entradaCanal); // 3
                        
                        $dias = floor($segundos / (60 * 60 * 24));
                        $dias_mod = $segundos % (60 * 60 * 24);
                        
                        $horas = floor($dias_mod / (60 * 60));
                        $horas_mod = $dias_mod % (60 * 60);
                        
                        $minutos = floor($horas_mod / 60);
                        $segundos_f = $horas_mod % 60;
                        
                        if($dtAtual > $entradaCanal){
                            $dtformat = "-" . $dias . " " . $horas . ":".$minutos.":".$segundos_f;
                        }else{
                            $dtformat = $dias . " " . $horas . ":".$minutos.":".$segundos_f;
                        }
                        
                        echo $dtformat;
                        ?>
                      </div>
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
                         <td>
                             @if($mm->MSG_USUARIO_dataHoraMsg != NULL)
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $mm->MSG_USUARIO_dataHoraMsg)->format('d/m/Y H:i') }}
                            @endif
                         </td>
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
        
        
    </div>
    </div>
</div>
</div>
</div>
</body>
</html>
