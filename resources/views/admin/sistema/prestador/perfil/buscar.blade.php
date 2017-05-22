@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::perfil::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Perfil Prestador</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição perfil
            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $desc or '' }}">
        </div>
        <div class="form-group col-xs-6">
            Prestador *
            <select name="prestador" class="form-control" id="prestador">
                <option value=""></option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $p)
                    <option value="{{ $p->PRESTADOR_id }}">{{ $p->PRESTADOR_nome }}</option>
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
                    <th>PRESTADOR</th>
                </tr>
                @foreach($listaP as $e)
                <tr>
                    <td>{{ $e->PERFIL_PREST_nome }}</td>
                    <td>{{ $e->PRESTADOR_nome }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif
@endsection