@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        
    })
</script>
<div class="col-xs-6">
    <form method="post" action="{{ route('admin::canais::detalhestipo', ['id' => $t->TIPOMANIF_id ])}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Tipo de Manifestação</h3>
    <div class="form-group">
        Descrição do tipo *
        <input type="text" name="tipo" id="tipo" value="{{ $t->TIPOMANIF_nome }}" required class="form-control">
    </div>
    
    <input type="hidden" name="idtipo" id="idtipo" value="{{ $t->TIPOMANIF_id }}">
    <input type="submit" value="Editar Manifestação" class="btn btn-primary">
</form>
</div>

@endsection