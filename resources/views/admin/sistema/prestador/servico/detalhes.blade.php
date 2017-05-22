@extends('admin.layout')

@section('conteudo')
<script type="text/javascript">
    $(function(){

    });
</script>

<div class="col-xs-12">
    <h3 class="page-header" id="titulo">Detalhes Serviço</h3>
    <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
          <div class="box-body">
              <div class="row">
              <div class="col-xs-6 linha">
                <b>Nome: <br></b>
                {{ $servico->SERVICO_nome }}
              </div>
              <div class="col-xs-6 linha">
                <b>Grupo: <br></b>
                {{ $servico->SERVICO_grupo }}
              </div>
              </div>
              <div class="row">
                <div class="col-xs-6 linha">
                <b>Status: <br></b>
                @if($servico->SERVICO_status == 1) Ativo @else Cancelado @endif
              </div>
                <div class="col-xs-6 linha">
                <b>Empresa: <br></b>
                <?php 
                    $emp = App\Empresa::find($servico->SERVICO_EMPRESA_id);
                    if(count($emp)):
                        echo $emp->EMPRESA_nome;
                    endif;
                ?>
              </div>    
              </div>
              <div class="row">
              <div class="col-xs-12 linha">
                <b>Descrição: <br></b>
                {{ $servico->SERVICO_descricao }}
              </div>
              </div>
          </div>
      </div>
    </div>
    </div>
</div>
@endsection