@extends('admin.layout')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript">
$(function(){
    $(".novo").on('click', function(){
        $("#formulario").hide();
        $("#formnovo").show();
    });
    $(".buscar").on('click', function(){
        $("#formulario").show();
        $("#formnovo").hide();
    });
    
    $("#telefone").inputmask("(99) 9999-9999");
    $("#celular").inputmask("(99) 9999-9999[9]");
})
</script>
<div class="col-xs-12">
    <h3 class="page-header" id="titulo">Reclamantes</h3>
    <form method="post" id="formulario" action="{{ route('admin::manifestacao::reclamante')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="opc" value="buscar">
    <div class="row">
        <div class="form-group col-xs-4" >
            Nome:
            <input type="text" name="nome" class="form-control" id="nome">
        </div>
        
    </div>
    <input type="submit" value="Buscar Reclamante" class="btn btn-primary">
    <a href="#" class="btn btn-info novo">Novo Reclamante</a>
    </form>
    
    <form method="post" id="formnovo" style="display: none;" action="{{ route('admin::manifestacao::reclamante')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="opc" value="cadastrar">
    <div class="row">
        <div class="form-group col-xs-6" >
            Nome:
            <input type="text" name="nome" class="form-control" id="nome" required>
        </div>
        <div class="form-group col-xs-6" >
            Telefone:
            <input type="text" name="telefone" class="form-control" id="telefone">
        </div>
        <div class="form-group col-xs-6" >
            Celular:
            <input type="text" name="celular" class="form-control" id="celular">
        </div>
        <div class="form-group col-xs-6" >
            E-mail:
            <input type="email" name="email" class="form-control" id="email">
        </div>
    </div>
    <input type="submit" value="Novo Reclamante" class="btn btn-primary">
    <a href="#" class="btn btn-info buscar ">Buscar Reclamante</a>
    </form>
</div>
@if(isset($listaRec) && count($listaRec) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Reclamantes</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>NOME</th>
                    <th>TELEFONE</th>
                    <th>CELULAR</th>
                    <th>E-MAIL</th>
                </tr>
                @foreach($listaRec as $r)
                <tr>
                    <td>{{ $r->RECLAMANTE_nome }}</td>
                    <td>{{ $r->RECLAMANTE_telefone }}</td>
                    <td>{{ $r->RECLAMANTE_celular }}</td>
                    <td>{{ $r->RECLAMANTE_email }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif
@endsection