@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    
</script>
<div class="col-xs-6">
    <form method="post" action="{{ route('admin::canais::cadastrar_canal')}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="page-header">Cadastrar Canal</h3>
    <div class="form-group">
        Descrição do canal *
        <input type="text" name="canal" id="canal" required class="form-control">
    </div>
    <div class="form-group">
        Empresa *
        <select name="empresa" class="form-control" id="empresa">
            @if(isset($lista) && count($lista) > 0)
                @foreach($lista as $e)
                    <option value="{{ $e->EMPRESA_id }}">{{ $e->EMPRESA_sigla }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <input type="submit" value="Cadastrar Canal" class="btn btn-primary">
</form>
</div>

@endsection