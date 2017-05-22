@extends('admin.layout')

@section('conteudo')


<div class="col-xs-6">
<form method="post"  action="{{ route('admin::tipo::cadastrar')}}"  class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
    <h3 class="page-header">Cadastrar Tipo Manifestação</h3>
    <div class="form-group">
        Tipo *
        <input type="text" name="tipo" id="tipo" required class="form-control">
    </div>
    <input type="submit" value="Cadastrar Manifestação" class="btn btn-primary">
</form>
</div>


@endsection