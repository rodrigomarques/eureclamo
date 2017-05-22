@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::perfil::detalhes',['id' =>  $perfil->PERFIL_EMP_id])}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Detalhes do Perfil</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição perfil *
            <input type="text" name="descricao" id="descricao" value="{{ $perfil->PERFIL_EMP_nome }}" required class="form-control">
        </div>
        <div class="form-group col-xs-6">
            Empresa *
            <select name="empresa" class="form-control" id="empresa">
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option  @if($perfil->PERFIL_EMP_idEmpresa == $e->EMPRESA_id) selected @endif value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
        </div>
    </div>
    <input type="hidden" name="idperfil" id="idperfil" value="{{ $perfil->PERFIL_EMP_id }}">
        <input type="submit" value="Editar Perfil" class="btn btn-primary">
    
</form>
</div>

@endsection