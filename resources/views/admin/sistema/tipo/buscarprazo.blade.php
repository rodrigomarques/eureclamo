@extends('admin.layout')

@section('conteudo')

<script type="text/javascript">
    $(function(){
        $(".telacanal").hide();
        $(".empresa").on('change', function(){
            var emp = $(this).val();
            if(emp != ""){
                $.get(
                    '{{ route("admin::canais::buscarcanal")}}',
                    {
                        idempresa : emp
                    },
                    function(result){
                        $(".telacanal").show();
                        $(".telacanal").html(result);
                    }
                );
            }else{
                $(".telacanal").hide();
            }
        });
    })
</script>

<div class="col-xs-12">
<form method="post"  action="{{ route('admin::prazo::buscar')}}"  class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
    <div class="row">
        <div class="form-group col-xs-6">
            Empresa *
            <select name="empresa" class="form-control empresa"  id="empresa">
                <option value="">---Selecione</option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
        </div>
        <div class="form-group col-xs-6 telacanal">
            Canal *
            <select name="canalm" id="canalM" class="form-control tela" >
                <option value="">--Selecione</option>
                @if(isset($listaCanal) && count($listaCanal))
                    @foreach($listaCanal as $c)
                    <option value="{{ $c->CANAL_id }}">{{ $c->CANAL_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-6">
            Tipo de Manifestação *
            <select name="tipom" id="tipom" class="form-control" >
                <option value="">--Selecione</option>
                @if(isset($listaManif) && count($listaManif))
                    @foreach($listaManif as $m)
                    <option value="{{ $m->TIPOMANIF_id }}">{{ $m->TIPOMANIF_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
    </div>
    <input type="submit" value="Buscar" class="btn btn-primary">
</form>
</div>
@if(isset($listaP) && count($listaP) > 0)
<div class="col-xs-12">
    <div class="box">
        
        <div class="box-body">
<table class="table table-bordered">
    <tr>
        <th>CANAL</th>
        <th>TIPO DE MANIFESTAÇÃO</th>
        <th>PRAZO</th>
		<th>DATA INÍCIO</th>
		<th>DATA FIM</th>
        <th></th>
    </tr>
    @foreach($listaP as $p)
    <tr>
        <td>{{ $p->CANAL_nome }}</td>
        <td>{{ $p->TIPOMANIF_nome }}</td>
        <td>{{ $p->TIPO_CANAL_PrazoPadrao }}</td>
		<td>@if($p->TIPO_CANAL_dataInicioVersao  != null && $p->TIPO_CANAL_dataInicioVersao != '0000-00-00 00:00:00') {{ @\Carbon\Carbon::parse($p->TIPO_CANAL_dataInicioVersao)->format("d/m/Y H:i:s")}} @endif</td>
		<td>@if($p->TIPO_CANAL_dataFimVersao  != null) {{ @\Carbon\Carbon::parse($p->TIPO_CANAL_dataFimVersao)->format("d/m/Y H:i:s")}} @endif</td>
        <td>
            <a href="{{ route('admin::prazo::detalhes', ['idtipo' => $p->TIPO_CANAL_idTipo, 
                        'idcanal' => $p->TIPO_CANAL_idCanal ]) }}" class="btn btn-warning">
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