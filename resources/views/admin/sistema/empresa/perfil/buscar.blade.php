@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::perfil::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Perfil</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição perfil
            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $desc or '' }}">
        </div>
        <div class="form-group col-xs-6">
            Empresa
            <select name="empresa" class="form-control" id="empresa">
                <option value=""></option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option @if(isset($empresa) && $e->EMPRESA_id == $empresa) selected @endif value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
        </div>
    </div>
        <input type="submit" value="Buscar Perfil" class="btn btn-primary">
    
</form>
</div>
@if(isset($listaP) && count($listaP) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Perfil</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>PEFIL ACESSO</th>
                    <th>EMPRESA</th>
                    <th></th>
                </tr>
                @foreach($listaP as $e)
                <tr>
                    <td>{{ $e->PERFIL_EMP_nome }}</td>
                    <td>{{ $e->EMPRESA_nome }}</td>
                    <td>
                    <a href="{{ route('admin::empresa::perfil::detalhes', [ 'id' =>  $e->PERFIL_EMP_id ]) }}" class="btn btn-warning">
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