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
<form method="post"  action="{{ route('admin::prazo::detalhes', ['idtipo' => $tipo->TIPO_CANAL_idTipo, 
                        'idcanal' => $tipo->TIPO_CANAL_idCanal ]) }}"  class="well">
    <h3 class="page-header">Prazo por Tipo de Manifestação</h3>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
    <div class="row">
        <div class="form-group col-xs-6">
            Canal: <br>
            {{ $tipo->CANAL_nome }}
        </div>
        <div class="form-group col-xs-6">
            Tipo de Manifestação: <br>
            {{ $tipo->TIPOMANIF_nome }}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-6">
            Prazo(Horas) - Entrada no Canal *
            <input type="number" name="prazo" required class="form-control" value="{{ $tipo->TIPO_CANAL_PrazoPadrao }}">
        </div>
    </div>
    <input type="submit" value="Cadastrar" class="btn btn-primary">
</form>
</div>

@endsection