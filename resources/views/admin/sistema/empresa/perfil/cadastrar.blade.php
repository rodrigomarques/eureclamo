@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::perfil::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Perfil</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição perfil *
            <input type="text" name="descricao" id="descricao" required class="form-control">
        </div>
        <div class="form-group col-xs-6">
            Empresa *
            <select name="empresa" class="form-control" id="empresa">
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
        </div>
    </div>
        <input type="submit" value="Cadastrar Perfil" class="btn btn-primary">
    
</form>
</div>

@endsection