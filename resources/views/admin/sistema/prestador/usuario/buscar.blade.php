@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        $(".telaperfil").hide();
        
    })
</script>
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::usuario::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Usuário</h3>
    <div class="row">
        <div class="form-group col-xs-4">
            Nome *
            <input type="text" name="nome" id="nome"  class="form-control">
        </div>

        <div class="form-group col-xs-4">
            E-mail *
            <input type="email" name="email" id="email"  class="form-control">
        </div>

        <div class="form-group col-xs-4">
            Login *
            <input type="text" name="login" id="login"  class="form-control">
        </div>
    </div>
        <input type="submit" value="Buscar Usuário" class="btn btn-primary">
    
</form>
</div>
@if(isset($listaP) && count($listaP) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Usuario</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>NOME</th>
                    <th>LOGIN</th>
                    <th>E-MAIL</th>
                    <th>NIVEL</th>
                    <th>PERFIL</th>
                    <th>PRESTADOR</th>
                    <th></th>
                </tr>
                @foreach($listaP as $ue)
                <tr>
                    <td>{{ $ue->USUARIO_nome }}</td>
                    <td>{{ $ue->USUARIO_login }}</td>
                    <td>{{ $ue->USUARIO_email }}</td>
                    <td>{{ $ue->USUARIO_nivel }}</td>
                    <td>{{ $ue->PERFIL_nome }}</td>
                    <td>{{ $ue->PRESTADOR_nome }}</td>
                    <td>
                        @if($ue->USUARIO_status == 1) 
                        <a href="{{ route('admin::prestador::usuario::excluir', [ 'id' =>  $ue->USUARIO_id ]) }}" class="btn btn-danger"
                           onclick=" return confirm('Deseja desativar este usuario?')">
                            <span class="fa fa-remove"></span>
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