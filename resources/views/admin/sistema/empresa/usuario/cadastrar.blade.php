@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        //$(".telaperfil").hide();
        /*$("#empresa").on('change', function(){
            var emp = $(this).val();
            if(emp != ""){
                $.get(
                    '{{ route("admin::empresa::buscarperfil")}}',
                    {
                        idempresa : emp
                    },
                    function(result){
                        $(".telaperfil").show();
                        $(".telaperfil").html(result);
                    }
                );
            }else{
                $(".telaperfil").hide();
            }
        });*/
    })
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::empresa::usuario::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Usuário</h3>
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
            Empresa *
            <select name="empresa" class="form-control" required id="empresa">
                <option value="">---Selecione</option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
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
                        <option value="{{ $p->PERFIL_id }}">{{ $p->PERFIL_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
        <input type="submit" value="Cadastrar Usuário" class="btn btn-primary">
    
</form>
</div>
@endsection