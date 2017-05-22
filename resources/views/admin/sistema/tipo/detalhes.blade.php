@extends('admin.layout')

@section('conteudo')


<div class="col-xs-6">
<form method="post"    class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
    <h3 class="page-header">Tipo de Manifestação</h3>
    <div class="form-group">
        Tipo *
        <input type="text" name="tipo" id="tipo" required class="form-control" value="{{ $tipoM->TIPOMANIF_nome}}">
    </div>
    <input type="submit" value="Alterar Manifestação" class="btn btn-primary">
</form>
</div>


@endsection