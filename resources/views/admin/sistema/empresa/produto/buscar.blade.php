@extends('admin.layout')

@section('conteudo')
<script>
$(function(){
    
})    
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::produto::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Produto</h3>
    <div class="row">
        <div class="form-group col-xs-4">
            Nome do produto *
            <input type="text" name="nome" id="nome" class="form-control">
        </div>
        <div class="form-group col-xs-4">
            Grupo *
            <input type="text" name="grupo" id="grupo" class="form-control">
        </div>
        <div class="form-group col-xs-4">
            Empresa
            <select name='empresa' id="empresa" class="form-control">
                <option value=''></option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                <option value='{{ $e->EMPRESA_id }}'>{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
            </select>
        
    </div>
    </div>
    <input type="submit" value="Buscar Produto" class="btn btn-primary">
    
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
                    <th>EMPRESAS</th>
                    <th>GRUPO</th>
                    <th>NOME PRODUTO</th>
                    <th>DESCRIÇÃO</th>
                    <th></th>
                </tr>
                @foreach($listaP as $p)
                <tr>
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
                    <td>{{ $p->PRODUTO_grupo }}</td>
                    <td>{{ $p->PRODUTO_nome }}</td>
                    <td>{{ $p->PRODUTO_descricao }}</td>
                    <td>
                        @if($p->PRODUTO_status == 1) 
                        <a href="{{ route('admin::empresa::produto::excluir', [ 'id' =>  $p->PRODUTO_id ]) }}" class="btn btn-danger"
                           onclick=" return confirm('Deseja excluir este produto?')">
                            <span class="fa fa-remove"></span>
                        </a>
                        @else 
                            <a href="{{ route('admin::empresa::produto::excluir', [ 'id' =>  $p->PRODUTO_id ]) }}" class="btn btn-success"
                               >
                                <span class="fa fa-check-square-o"></span>
                            </a>
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