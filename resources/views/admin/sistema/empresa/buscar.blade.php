@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        $("#cnpj").inputmask("99.999.999/9999-99");
    });
</script>

<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Empresa</h3>
    <div class="row">
    <div class="form-group col-xs-12">
        Razão Social *
        <input type="text" name="razao" id="razao"  class="form-control">
    </div>
    
    <div class="form-group col-xs-5">
        Nome fantasia *
        <input type="text" name="fantasia" id="fantasia"  class="form-control">
    </div>
    
    <div class="form-group col-xs-5">
        CNPJ *
        <input type="text" name="cnpj" id="cnpj"  class="form-control">
    </div>
    <div class="form-group col-xs-2">
        SIGLA *
        <input type="text" name="sigla" id="sigla" maxlength="4"  class="form-control">
    </div>
    </div>
        <input type="submit" value="Buscar Empresa" class="btn btn-primary">
    
</form>
</div>

<div class="col-xs-12">
@if(isset($lista) && count($lista) > 0)
<div class="box">
        
        <div class="box-body">
<table class="table table-condensed">
        <tr>
            <th>RAZÃO SOCIAL</th>
            <th>NOME FANTASIA</th>
            <th>SIGLA</th>
            <th>CNPJ</th>
            <th></th>
        </tr>
        @foreach($lista as $e)
        <tr>
            <td>{{ $e->EMPRESA_nomeCompleto }}</td>
            <td>{{ $e->EMPRESA_nome }}</td>
            <td>{{ $e->EMPRESA_sigla }}</td>
            <td>{{ $e->EMPRESA_cnpj }}</td>
            <td>
                <a href="{{ route('admin::empresa::detalhes', [ 'id' =>  $e->EMPRESA_id ]) }}" class="btn btn-warning">
                        <span class="fa fa-edit"></span>
                    </a>
            </td>
        </tr>
        @endforeach
    </table>
        </div>
</div>
@endif
</div>
@endsection