@extends('admin.layout')

@section('conteudo')
<div class="col-xs-12">
    <form method="post" action="{{ route('admin::prestador::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Prestador</h3>
    <div class="row">
    <div class="form-group col-xs-6">
        Nome  *
        <input type="text" name="nome" id="nome"  class="form-control">
    </div>
    <div class="form-group col-xs-6">
        CNPJ *
        <input type="text" name="cnpj" id="cnpj"  class="form-control">
    </div>
    </div>
        <input type="submit" value="Buscar Prestador" class="btn btn-primary">
    
</form>
</div>

<div class="col-xs-12">
@if(isset($lista) && count($lista) > 0)
<div class="box">
        
        <div class="box-body">
<table class="table table-condensed">
        <tr>
            <th>NOME</th>
            <th>CNPJ</th>
            <th>NOME COMPLETO</th>
            <th>SERVIÇOS</th>
        </tr>
        @foreach($lista as $p)
        <tr>
            <td>{{ $p->PRESTADOR_nome }}</td>
            <td>{{ $p->PRESTADOR_cnpj }}</td>
            <td>{{ $p->PRESTADOR_nomeCompleto }}</td>
            <td>
                <?php 
                    $servDao = new App\Repository\ServicoDao(new \App\Servico());
                    $servicos = $servDao->buscarPorIdPrest($p->PRESTADOR_id);
                ?>
                @if(isset($servicos) && count($servicos))
                    @foreach($servicos as $s)
                    {{ $s->SERVICO_nome}}<br>
                    @endforeach
                @endif
            </td>
        </tr>
        @endforeach
    </table>
        </div>
</div>
@endif
</div>
@endsection