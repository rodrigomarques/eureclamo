@extends('admin.layout')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<script type="text/javascript">
    $(function(){
        
        $('#servico').on('change', function(){
                var servico = $(this).val();
                if(servico != ""){
                    $.get(
                    '{{ route("admin::manifestacao::buscarprestador") }}',
                    {
                        idservico : servico
                    },
                    function(result){
                        $('.dvprestador').show();
                        $('.dvprestador').html(result);
                    }
                );
            }else{
                $('.dvprestador').hide();
            }
        });
        
    })
</script>
<div class="col-xs-12">
    <div class="box box-primary">
          <div class="box-body">
              <h4 class="page-header">Manifestação</h4>
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Código da manifestação: <br></b>
                {{ $m->MANIF_codReclamanteEmp }}
              </div>
              <div class="col-xs-4 linha">
                <b>Nível: <br></b>
                {{ $m->MANIF_nivel }}
              </div>
              <div class="col-xs-4 linha">
                  <b>Canal: <br></b>
                {{ $m->CANAL_nome }}
              </div>
              </div>
              <div class="row">
              <div class="col-xs-4 linha">
                <b>Empresa: <br></b>
                {{ $m->EMPRESA_nomeCompleto }}
              </div>
              <div class="col-xs-4 linha">
                <b>Produto: <br></b>
                {{ $m->PRODUTO_nome }}
              </div>
              <div class="col-xs-4 linha">
                <b>Tipo: <br></b>
                {{ $m->TIPOMANIF_nome }}
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12 linha">
                <b>Resumo: <br></b>
                {{ $m->MANIF_resumo }}
              </div>
          </div>
              <div class="row">
              <div class="col-xs-3 linha">
                <b>Entrada no canal: <br></b>
                {{ $m->MANIF_dataHora_EntCanal }}
              </div>
              <div class="col-xs-3 linha">
                <b>Data da ocorrência: <br></b>
                {{ $m->MANIF_dataHora_Ocorrencia }}
              </div>
              <div class="col-xs-3 linha">
                <b>Entrada na gestão: <br></b>
                {{ $m->MANIF_dataHora_EntGestao }}
              </div>
              
              </div>
              <div class="row">
              <div class="col-xs-12 linha">
                    <b>Manifestação: <br></b>
                    {{ $m->MANIF_completa }}
              </div>
                  
              </div>
          </div>
    </div>
    <form method="post" action="{{ route('admin::manifestacao::mensagens', ['id' => $m->MANIF_id, 'ano' => $m->MANIF_ano])}}" enctype="multipart/form-data" class="well">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <div class="row">
            <div class="form-group col-xs-12">
                Mensagem: 
                <textarea name="msg" id="msg" class="form-control" rows="5"></textarea>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-xs-6">
                Serviço:
                @if(count($listaS) > 0)
                <select name="servico" id="servico" required class="form-control">
                    <option value=""></option>
                    @foreach($listaS as $s)
                    <option value="{{ $s->SERVICO_id}}">
                        {{ $s->SERVICO_nome }}
                    </option>
                    @endforeach
                </select>
                @endif
            </div>
            <div class="form-group col-xs-6">
                <div class="dvprestador"></div>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-xs-4">
                Arquivo:
                <input type="file" name="arquivo1" id="arquivo1" class="form-control">
            </div>
            <div class="form-group col-xs-4">
                Arquivo:
                <input type="file" name="arquivo2" id="arquivo2" class="form-control">
            </div>
            <div class="form-group col-xs-4">
                Arquivo:
                <input type="file" name="arquivo3" id="arquivo3" class="form-control">
            </div>
            <div class="form-group col-xs-4">
                Arquivo:
                <input type="file" name="arquivo4" id="arquivo4" class="form-control">
            </div>
            <div class="form-group col-xs-4">
                Arquivo:
                <input type="file" name="arquivo5" id="arquivo5" class="form-control">
            </div>
        </div>
        <input type="submit" value="Cadastrar Mensagem" class="btn btn-primary">
    </form>
</div>
@endsection