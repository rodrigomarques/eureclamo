@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::servico::cadastrar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Serviço</h3>
    <div class="row">
        <div class="form-group col-xs-6">
            Nome do serviço *
            <input type="text" name="nome" id="nome" required class="form-control">
        </div>
        <div class="form-group col-xs-6">
            Grupo *
            <input type="text" name="grupo" id="grupo" required class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-6">
            Descrição 
            <textarea name="descricao" id="descricao" class="form-control" rows="5"></textarea>
        </div>
        <div class="form-group col-xs-6">
        Empresa
            <select name='empresa' id="empresa" class="form-control" required>
                <option value=''></option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                <option value='{{ $e->EMPRESA_id }}'>{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
            </select>
     </div>
    </div>
    
        <input type="submit" value="Cadastrar Serviço" class="btn btn-primary">
    
</form>
</div>
<?php /*
@if(isset($listaS) && count($listaS) > 0)
<div class="col-xs-12">
    <div class="box">
        <div class="box-header with-border">
            <h4 class="box-title">Lista de Serviços</h4>
        </div>
        <div class="box-body">
            <table class="table table-condensed">
                <tr>
                    <th>SERVIÇO</th>
                    <th>DESCRIÇÃO</th>
                    <th>GRUPO</th>
                    <th>PRESTADORES</th>
                </tr>
                @foreach($listaS as $s)
                <tr>
                    <td>{{ $s->SERVICO_nome }}</td>
                    <td>{{ $s->SERVICO_descricao }}</td>
                    <td>{{ $s->SERVICO_grupo }}</td>
                    <td>
                        <?php 
                            $preDao = new App\Repository\PrestadorDao(new \App\Prestador());
                            $prestadores = $preDao->buscarPorIdServ($s->SERVICO_id);
                        ?>
                        @if(isset($prestadores) && count($prestadores))
                            @foreach($prestadores as $p)
                            {{ $p->PRESTADOR_nome}}<br>
                            @endforeach
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endif */ ?>
@endsection