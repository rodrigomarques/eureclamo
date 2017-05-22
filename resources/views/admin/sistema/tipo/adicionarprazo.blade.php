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
<form method="post"  action="{{ route('admin::prazo::adicionar')}}"  class="well">
    <h3 class="page-header">Prazo por Tipo de Manifestação</h3>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
    <div class="row">
        <div class="form-group col-xs-6">
            Empresa *
            <select name="empresa" class="form-control empresa" required id="empresa">
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
            <select name="canalm" id="canalM" class="form-control tela" required>
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
            Prazo por Tipo de Manifestação *
            <select name="tipom" id="tipom" class="form-control" required>
                <option value="">--Selecione</option>
                @if(isset($listaManif) && count($listaManif))
                    @foreach($listaManif as $m)
                    <option value="{{ $m->TIPOMANIF_id }}">{{ $m->TIPOMANIF_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
        <div class="form-group col-xs-6">
            Prazo(Horas) - Entrada no Canal *
            <input type="number" name="prazo" required class="form-control">
        </div>
    </div>
    <input type="submit" value="Cadastrar" class="btn btn-primary">
</form>
</div>

@endsection