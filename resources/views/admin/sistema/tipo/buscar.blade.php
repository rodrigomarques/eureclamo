@extends('admin.layout')

@section('conteudo')
<div class="col-xs-6">
    <form method="post" action="{{ route('admin::tipo::buscar')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Buscar Tipo Manifestação</h3>
    <div class="form-group">
        Tipo
        <input type="text" name="tipo" id="tipo" class="form-control">
    </div>
    
    <input type="submit" value="Buscar" class="btn btn-primary">
</form>
</div>
@if(isset($listaManif) && count($listaManif))
<div class="col-xs-12">
<div class="box">
        
        <div class="box-body">
    
        <table class="table table-condensed">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>STATUS</th>
                <th></th>
            </tr>
            @foreach($listaManif as $m)
            <tr>
                <td>{{ $m->TIPOMANIF_id }}</td>
                <td>{{ $m->TIPOMANIF_nome }}</td>
                <td>@if($m->TIPOMANIF_status == 1) Ativo @else Cancelado @endif</td>
                <?php /*<td>
                    <a href="{{ route('admin::tipo::detalhes', [ 'id' =>  $m->TIPOMANIF_id ]) }}" class="btn btn-warning">
                        <span class="fa fa-edit"></span>
                    </a>
                </td> */ ?>
                <td>
                    @if($m->TIPOMANIF_status == 1) 
                    <a href="{{ route('admin::tipo::excluir', [ 'id' =>  $m->TIPOMANIF_id ]) }}" class="btn btn-danger"
                       onclick="return confirm('Deseja desativar este tipo da empresa?')">
                        <span class="fa fa-remove"></span>
                    </a>
                    @else 
                    <a href="{{ route('admin::tipo::excluir', [ 'id' =>  $m->TIPOMANIF_id ]) }}" class="btn btn-success"
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