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
    <h3 class="page-header" id="titulo" style="cursor: pointer">Manifestação</h3>
    <form method="post" id="formulario" action="{{ route('admin::manifestacao::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
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
        <div class="form-group col-xs-4">
            <div class="dvlocalidade">
            Localidade:
            <select name="idlocalidade" id="idlocalidade" class="form-control">
                <option value=""></option>
                @if(count($listaL) > 0)
                    @foreach($listaL as $l)
                    <option value="{{ $l->LOCALIDADE_id}}">{{ $l->LOCALIDADE_nome  }}</option>
                    @endforeach
                @endif
            </select>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-xs-3">
            Data Ocorrência:
            <input type="text" name="dtentradaocorrencia" readonly style="cursor: pointer" class="form-control datepicker">
        </div>
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
            Código da Reclamação:
            <input type="text" name="codigo" class="form-control ">
        </div>
    </div>
    <input type="submit" value="Buscar Manifestação" class="btn btn-primary">
</form>
</div>
@if(isset($listaManif) && count($listaManif) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Manifestações</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>CANAL</th>
                    <th>TIPO</th>
                    <th>PRODUTO</th>
                    <th>CÓDIGO</th>
                    <th>ENTRADA</th>
                    <th>RESUMO</th>
                    <th>DETALHES</th>
                </tr>
                @foreach($listaManif as $m)
                <tr>
                    <td>{{ $m->CANAL_nome }}</td>
                    <td>{{ $m->TIPOMANIF_nome }}</td>
                    <td>{{ $m->PRODUTO_nome }}</td>
                    <td>{{ $m->MANIF_id }}</td>
                    <td>{{ $m->MANIF_dataHora_Cadastro }}</td>
                    <td>{{ $m->MANIF_resumo }}</td>
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