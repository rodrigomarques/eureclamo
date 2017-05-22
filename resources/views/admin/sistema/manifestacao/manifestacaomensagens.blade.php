@extends('admin.layout')

@section('conteudo')

<script type="text/javascript">
    $(function(){

    })
</script>
<div class="col-xs-12">
    <h3 class="page-header" id="titulo" style="cursor: pointer">Código da Manifestação</h3>
    <form method="post" id="formulario" action="{{ route('admin::manifestacao::manifestacaomensagem')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-xs-4">
            Código da Manifestação:
            <input type="text" name="codigomanif" class="form-control ">
        </div>
        <div class="form-group col-xs-4">
            Código do Reclamante:
            <input type="text" name="codigorec" class="form-control ">
        </div>
    </div>
    <input type="submit" value="Ver Mensagens" class="btn btn-primary">
</form>
</div>
@endsection