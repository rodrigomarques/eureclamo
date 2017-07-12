@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
       
    })
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::usuario::detalhes', ['id' => $usuario->USUARIO_id ])}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Detalhes do Usuário</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Nome *
            <input type="text" name="nome" id="nome"   class="form-control" 
                   value="{{ $usuario->USUARIO_nome}}" >
        </div>

        <div class="form-group col-xs-6">
            E-mail *
            <input type="email" name="email" id="email"   class="form-control"
                   value="{{ $usuario->USUARIO_email}}">
        </div>

        <div class="form-group col-xs-4">
            Login *
            <input type="text" name="login" id="login"   class="form-control"
                   value="{{ $usuario->USUARIO_login}}">
        </div>
        <div class="form-group col-xs-4">
            Senha *
            <input type="password" name="senha" id="senha"   class="form-control">
        </div>
        <div class="form-group col-xs-4">
            Nível *
            <select name="nivel" class="form-control"   id="nivel">
                <option value="1" @if($usuario->USUARIO_nivel == 1)selected @endif >1</option>
                <option value="2" @if($usuario->USUARIO_nivel == 2)selected @endif>2</option>
                <option value="3" @if($usuario->USUARIO_nivel == 3)selected @endif>3</option>
            </select>
        </div>
        <div class="form-group col-xs-6">
            Empresa *
            <select name="empresa" class="form-control" required  id="empresa">
                <option value="">---Selecione</option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->EMPRESA_id }}"
                             @if($usuarioEmp->USUARIO_EMP_idEmpresa == $e->EMPRESA_id)selected @endif>{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
        </div>
        <div class="form-group col-xs-6 telaperfil">
            Perfil *
            <select name="perfil" id="perfil" required  class="form-control">
                <option value="">---Selecione</option>
                @if(isset($listaP) && count($listaP) > 0)
                    @foreach($listaP as $p)
                        @if(
                        $p->PERFIL_nome == "admin" || 
                        $p->PERFIL_nome == "directorin" || 
                        $p->PERFIL_nome == "managerin" || 
                        $p->PERFIL_nome == "userin" )
                        <option  @if($usuario->USUARIO_PERFIL_id == $p->PERFIL_id)selected @endif value="{{ $p->PERFIL_id }}">{{ $p->PERFIL_nome }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>
        <input type="submit" value="Editar Usuário" class="btn btn-primary">
    
</form>
</div>
@endsection