@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
       
    })
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::usuario::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Usuário Prestador</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Nome *
            <input type="text" name="nome" id="nome" required class="form-control">
        </div>

        <div class="form-group col-xs-6">
            E-mail *
            <input type="email" name="email" id="email" required class="form-control">
        </div>

        <div class="form-group col-xs-4">
            Login *
            <input type="text" name="login" id="login" required class="form-control">
        </div>
        <div class="form-group col-xs-4">
            Senha *
            <input type="password" name="senha" id="senha" required class="form-control">
        </div>
        <div class="form-group col-xs-4">
            Nível *
            <select name="nivel" class="form-control" required id="nivel">
                <option value="">---Selecione</option>
                <option value="1">1 - Manifestações Gravissimas</option>
                <option value="2">2 - Manifestações Graves / Gravissimas</option>
                <option value="3">3 - Todas Manifestações </option>
            </select>
        </div>
        <div class="form-group col-xs-6">
            Prestador *
            <select name="prestador" class="form-control" required id="prestador">
                <option value="">---Selecione</option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->PRESTADOR_id }}">{{ $e->PRESTADOR_nome }}</option>
                @endforeach
            @endif
        </select>
        </div>
       <div class="form-group col-xs-6 telaperfil">
            Perfil *
            <select name="perfil" id="perfil" required class="form-control">
                <option value="">---Selecione</option>
                @if(isset($listaP) && count($listaP) > 0)
                    @foreach($listaP as $p)
                        @if(
                        $p->PERFIL_nome == "directorout" || 
                        $p->PERFIL_nome == "managerout" || 
                        $p->PERFIL_nome == "userout" )
                        <option value="{{ $p->PERFIL_id }}">{{ $p->PERFIL_nome }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>
        <input type="submit" value="Cadastrar Usuário" class="btn btn-primary">
    
</form>
</div>
@endsection