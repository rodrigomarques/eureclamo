@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        $("#cnpj").inputmask("99.999.999/9999-99");
    });
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Prestador</h3>
    <div class="row">
    <div class="form-group col-xs-6">
        Nome  *
        <input type="text" name="nome" id="nome" required class="form-control">
    </div>
    <div class="form-group col-xs-6">
        CNPJ *
        <input type="text" name="cnpj" id="cnpj" required class="form-control">
    </div>
    <div class="form-group col-xs-6">
        Nome Completo*
        <input type="text" name="nomecompleto" id="nomecompleto" required class="form-control">
    </div>
    @if(isset($listaS) && count($listaS) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Serviços</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th></th>
                    <th>SERVIÇO</th>
                    <th>DESCRIÇÃO</th>
                    <th>GRUPO</th>
                </tr>
                @foreach($listaS as $s)
                <tr>
                    <td>
                        <label>
                        <input type="checkbox" name="servicos[]" id='servicos' value='{{ $s->SERVICO_id }}'>
                        </label>
                    </td>
                    <td>{{ $s->SERVICO_nome }}</td>
                    <td>{{ $s->SERVICO_descricao }}</td>
                    <td>{{ $s->SERVICO_grupo }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif
    </div>
        <input type="submit" value="Cadastrar Prestador" class="btn btn-primary">
    
</form>
</div>

@endsection