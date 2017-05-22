@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){
        
    })
</script>
<div class="col-xs-6">
    <form method="post" action="{{ route('admin::canais::detalhescanal', ['id' => $c->CANAL_id ])}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Canal</h3>
    <div class="form-group">
        Descrição do canal *
        <input type="text" name="canal" id="canal" value="{{ $c->CANAL_nome }}" required class="form-control" readonly>
    </div>
    <div class="form-group">
        Empresa * 
        <select name="empresa" class="form-control" id="empresa" readonly>
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option @if($c->EMPRESA_id == $e->EMPRESA_id) selected @endif value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="form-group">
        Status * 
        <select name="status" class="form-control" id="status">
            <option @if($c->CANAL_status == 1) selected @endif value="1">Ativo</option>
            <option @if($c->CANAL_status == 0) selected @endif value="0">Cancelado</option>
        </select>
    </div>
    <input type="hidden" name="idcanal" id="idcanal" value="{{ $c->CANAL_id }}">
    <input type="submit" value="Editar Canal" class="btn btn-primary">
</form>
</div>

@endsection