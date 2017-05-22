@extends('admin.layout')

@section('conteudo')
<script>
$(function(){
    
})    
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::produto::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Cadastrar Produto</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Nome do produto *
            <input type="text" name="nome" id="nome" required class="form-control">
        </div>
        <div class="form-group col-xs-6">
            Grupo *
            <input type="text" name="grupo" id="grupo" required class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição 
            <textarea name="descricao" id="descricao" class="form-control" rows="5"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            Empresas 
        </div>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                <div class="col-xs-4">
                <div class="checkbox">
                    <label>
                    <input type="checkbox" name="empresas[]" id='empresas' value='{{ $e->EMPRESA_id }}'>{{ $e->EMPRESA_sigla }}
                    </label>
                </div>
                </div>
                @endforeach
            @endif
        
    </div>
        <input type="submit" value="Cadastrar Produto" class="btn btn-primary">
    
</form>
</div>
@if(isset($listaP) && count($listaP) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Produtos</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>NOME PRODUTO</th>
                    <th>DESCRIÇÃO</th>
                    <th>EMPRESAS</th>
                </tr>
                @foreach($listaP as $p)
                <tr>
                    <td>{{ $p->PRODUTO_nome }}</td>
                    <td>{{ $p->PRODUTO_descricao }}</td>
                    <td>
                        <?php 
                            $empDao = new App\Repository\EmpresaDao(new \App\Empresa(\App\Config::$dbname));
                            $empresas = $empDao->buscarPorIdProd($p->PRODUTO_id);
                        ?>
                        @if(isset($empresas) && count($empresas))
                            @foreach($empresas as $ep)
                            {{ $ep->EMPRESA_nome}}<br>
                            @endforeach
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif
@endsection