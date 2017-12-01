@extends('admin.layout')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',                
            language: 'pt-BR'
          });
          
          $("#titulo").on('click', function(){ $("#formulario").toggle(); })
    })
</script>
<div class="col-xs-12">
    <h3 class="page-header" id="titulo" style="cursor: pointer">Relatório de Acompanhamento (Manifestação em aberto)</h3>
    <form method="post" id="formulario" action="{{ route('admin::relatorio::acompanhamento')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-xs-4">
            Tipo de manifestação:
            <select name="idtipo" id="idtipo" class="form-control">
                <option value=""></option>
                @if(count($listaM) > 0)
                    @foreach($listaM as $tm)
                    <option value="{{ $tm->TIPOMANIF_id}}">{{ $tm->TIPOMANIF_nome  }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-xs-4" >
            Canal:
            <select name="idcanal" id="idcanal" class="form-control">
                <option value=""></option>
                @if(count($listaC) > 0)
                    @foreach($listaC as $c)
                    <option value="{{ $c->CANAL_id }}">{{ $c->CANAL_nome  }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-xs-4" >
            Empresa:
            <select name="idempresa" id="idempresa" class="form-control">
                <option value=""></option>
                @if(count($listaE) > 0)
                    @foreach($listaE as $e)
                    <option value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_nome  }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
    </div>
    
    <div class="row">
        <div class="form-group col-xs-3">
            Nível:
            <select name="nivel" class="form-control">
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
        <div class="form-group col-xs-3">
            Data Ocorrência:
            <input type="text" name="dtentradaocorrencia" readonly style="cursor: pointer" class="form-control datepicker">
        </div>
        <div class="form-group col-xs-3">
            Código da Reclamação:
            <input type="text" name="codigo" class="form-control ">
        </div>
        <div class="form-group col-xs-3">
            Status:
            <select name="status" class="form-control">
                <option value=""></option>
                <option value="1">Aberto</option>
                <option value="2">Concluído</option>
            </select>
        </div>
    </div>
    <input type="submit" value="Buscar Manifestação" class="btn btn-primary">
</form>
</div>
@if(isset($listaManif) && count($listaManif) > 0)
<div class="col-xs-12">
    {{ $horario or '' }}
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Manifestações @if(isset($tipoManif)) - {{ $tipoManif->TIPOMANIF_nome }} @endif </h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>EXPIRA EM</th>
                    <th>EMPRESA</th>
                    <th>NR. RECLAMAÇÃO</th>
                    <th>CLIENTE</th>
                    <th>NR. CLIENTE</th>
                    <th>DETALHES</th>
                </tr>
                @foreach($listaManif as $m)
                <tr>
                    <td>
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
                        </td>
                    
                    <td>{{ $m->EMPRESA_nome }}</td>
                    <td>{{ $m->MANIF_ano }}{{ $m->MANIF_id}}</td>
                    <td>{{ $m->RECLAMANTE_nome }}</td>
                    <td>{{ $m->MANIF_EMPRESA_idEmpresa }}{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $m->MANIF_dataHora_Cadastro)->format('Ymd') }}{{ $m->MANIF_id }}</td>
                    <td>
                        <a href="{{ route('admin::manifestacao::detalhes', ['ano' => $m->MANIF_ano, 'id' => $m->MANIF_id ])}}" class="btn btn-info">
                            <span class="fa fa-edit"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif
@endsection