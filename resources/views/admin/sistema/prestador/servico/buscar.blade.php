@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::servico::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Serviço</h3>
    <div class="row">
        <div class="form-group col-xs-4">
            Nome do serviço *
            <input type="text" name="nome" id="nome"  class="form-control">
        </div>
        <div class="form-group col-xs-4">
            Grupo *
            <input type="text" name="grupo" id="grupo"  class="form-control">
        </div>
        <div class="form-group col-xs-4">
        Empresa
            <select name='empresa' id="empresa" class="form-control" >
                <option value=''></option>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                <option value='{{ $e->EMPRESA_id }}'>{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
            </select>
     </div>
    </div>
    
        <input type="submit" value="Buscar Serviço" class="btn btn-primary">
    
</form>
</div>

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
                    <th>EMPRESA</th>
                    <th>STATUS</th>
                    <th>PRESTADORES</th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach($listaS as $s)
                <tr>
                    <td>{{ $s->SERVICO_nome }}</td>
                    <td>{{ $s->SERVICO_descricao }}</td>
                    <td>{{ $s->SERVICO_grupo }}</td>
                    <td>@if($s->SERVICO_status == 1) Ativo @else Cancelado @endif</td>
                    <td>{{ $s->EMPRESA_nome }}</td>
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
                    <td>
                        <a href="{{ route('admin::prestador::servico::detalhes', [ 'id' =>  $s->SERVICO_id ]) }}" class="btn btn-warning">
                            <span class="fa fa-edit"></span>
                        </a>
                    </td>
                    <td>
                    @if($s->SERVICO_status == 1) 
                    <a href="{{ route('admin::prestador::servico::alterar', [ 'id' =>  $s->SERVICO_id ]) }}" class="btn btn-danger"
                       onclick="return confirm('Deseja desativar este serviço?')">
                        <span class="fa fa-remove"></span>
                    </a>
                    @else 
                    <a href="{{ route('admin::prestador::servico::alterar', [ 'id' =>  $s->SERVICO_id ]) }}" class="btn btn-success"
                       >
                        <span class="fa fa-check-square-o"></span>
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