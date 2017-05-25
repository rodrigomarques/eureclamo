@extends('admin.layout')

@section('conteudo')
<div class="col-xs-6">
    <form method="post" action="{{ route('admin::canais::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Canal</h3>
    <div class="form-group">
        Descrição
        <input type="text" name="descricao" id="descricao" class="form-control">
    </div>
    <div class="form-group">
        Empresa *
        <select name="empresa" class="form-control" id="empresa">
            <option value=""></option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <input type="submit" value="Buscar" class="btn btn-primary">
</form>
</div>
@if(isset($listaCanal) && count($listaCanal))
<div class="col-xs-12">
<div class="box">
        
        <div class="box-body">
    
        <table class="table table-condensed">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>NOME EMPRESA</th>
                <th>SIGLA</th>
                <th>STATUS</th>
                <th></th>
            </tr>
            @foreach($listaCanal as $c)
            <tr>
                <td>{{ $c->CANAL_id }}</td>
                <td>{{ $c->CANAL_nome }}</td>
                <td>{{ $c->EMPRESA_nome }}</td>
                <td>{{ $c->EMPRESA_sigla }}</td>
                <td>@if($c->CANAL_status == 1) Ativo @else Cancelado @endif</td>
				<td>
                    @if($c->CANAL_status == 1) 
                    <a href="{{ route('admin::canais::detalhescanal', [ 'id' =>  $c->CANAL_id ]) }}" class="btn btn-danger"
                       onclick="return confirm('Deseja desativar este canal?')">
                        <span class="fa fa-remove"></span>
                    </a>
                    @else 
                    <a href="{{ route('admin::canais::detalhescanal', [ 'id' =>  $c->CANAL_id ]) }}" class="btn btn-success"
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
@if(isset($listaManif) && count($listaManif))
    <div class="col-xs-12">
        <div class="box">
        
        <div class="box-body">
        <table class="table table-condensed">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th></th>
            </tr>
            @foreach($listaManif as $m)
            <tr>
                <td>{{ $m->TIPOMANIF_id }}</td>
                <td>{{ $m->TIPOMANIF_nome }}</td>
                <td>
                    <a href="{{ route('admin::canais::detalhestipo', [ 'id' =>  $m->TIPOMANIF_id ]) }}" class="btn btn-warning">
                        <span class="fa fa-edit"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
        </div>
    </div>
@endif
@endsection