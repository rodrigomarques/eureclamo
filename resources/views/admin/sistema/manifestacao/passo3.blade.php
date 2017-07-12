@extends('admin.layout')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $('#servicos').on('change', function(){
            console.log("Teste");
            var servicos = $(this).val();
            $.get(
            '{{ route("admin::manifestacao::buscarprestador") }}',
            {
                idservico : servicos
            },
            function(result){
                ///////////AQUIIIIIIIIIIIIIIIIIIIIII
                console.log(result);
                $('.dvprestador').html(result);
            }
        );
        });
    })
</script>
<div class="col-xs-12">
    <h3 class="page-header">Cadastrar Manifestação - Notificar Prestadores</h3>
    <form method="post" action="{{ route('admin::manifestacao::passo3', ['id' => $idmanifestacao, 'ano' => $ano])}}" class="well">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-xs-6" >
            Serviços:
            <select name="servicos" id="servicos" required class="form-control">
                <option value=""></option>
                @if(count($listaServ) > 0)
                    @foreach($listaServ as $s)
                    <option value="{{ $s->SERVICO_id}}">{{ $s->SERVICO_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-xs-6 dvprestador" >
            Prestador:
            <select name="prestador" id="prestador" required class="form-control">
                <option value=""></option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            Mensagem de Início:
            <textarea name="msginicio" rows="4" class="form-control"></textarea>
        </div>
    </div>
    
    <input type="submit" value="Notificar/Enviar E-mail" class="btn btn-primary">
    <a href="{{ route('admin::manifestacao::detalhes', ['id' => $idmanifestacao, 'ano' => $ano])}}" class="btn btn-primary">Finalizar</a>
</form>
</div>
@if(isset($listaMsg) && count($listaMsg))
<div class="col-xs-12">
   <table class="table table-bordered">
       <tr>
           <th>PRESTADOR</th>
           <th>SERVIÇO</th>
           <th>DATA</th>
           <th>MENSAGEM</th>
       </tr>
    @foreach($listaMsg as $m)
    <tr>
        <td>{{ $m->PRESTADOR_nome}}</td>
        <td>{{ $m->PRESTADOR_nome}}</td>
        <td>{{ $m->MSG_USUARIO_dataHoraMsg}}</td>
        <td>{{ $m->MSG_USUARIO_mensagem }}</td>
    </tr>
    @endforeach
   </table>
</div>
@endif;
@endsection