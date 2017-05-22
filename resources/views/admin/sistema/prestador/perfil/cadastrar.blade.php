@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::perfil::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Perfil Prestador</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição perfil *
            <input type="text" name="descricao" id="descricao" required class="form-control">
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
        <input type="submit" value="Cadastrar Prestador" class="btn btn-primary">
    
</form>
</div>

@endsection