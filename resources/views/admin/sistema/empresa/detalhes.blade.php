@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        $("#cnpj").inputmask("99.999.999/9999-99");
    });
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::detalhes', ['id' => $empresa->EMPRESA_id])}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Detalhes Empresa</h3>
    <div class="row">
    <div class="form-group col-xs-12">
        Razão Social *
        <input type="text" name="razao" value="{{ $empresa->EMPRESA_nomeCompleto}}" id="razao" required class="form-control">
    </div>
    
    <div class="form-group col-xs-5">
        Nome fantasia *
        <input type="text" name="fantasia" value="{{ $empresa->EMPRESA_nome}}" id="fantasia" required class="form-control">
    </div>
    
    <div class="form-group col-xs-5">
        CNPJ *
        <input type="text" name="cnpj" id="cnpj" required class="form-control" value="{{ $empresa->EMPRESA_cnpj}}">
    </div>
    <div class="form-group col-xs-2">
        SIGLA *
        <input type="text" name="sigla" id="sigla" maxlength="3" required value="{{ $empresa->EMPRESA_sigla}}" class="form-control">
    </div>
    </div>
        <input type="hidden" name="idempresa" value="{{ $empresa->EMPRESA_id }}" >
        <input type="submit" value="Editar Empresa" class="btn btn-primary">
    
</form>
</div>

@endsection