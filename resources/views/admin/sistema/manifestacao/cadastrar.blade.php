@extends('admin.layout')

@section('conteudo')
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ asset('plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script src="{{ asset('js/validar.js')}}"></script>
<script type="text/javascript">
    $(function(){
        function localidadeM(){
            $('#ufs').on('change', function(){
                    var ufs = $(this).val();
                    if(ufs != ""){
                        $.get(
                        '{{ route("admin::manifestacao::buscarlocalidade") }}',
                        {
                            iduf : ufs
                        },
                        function(result){
                            ///////////AQUIIIIIIIIIIIIIIIIIIIIII
                            $('.dvlocalidade').show();
                            $('.dvlocalidade').html(result);
                            
                            
                        }
                    );
                }else{
                    $('.dvlocalidade').hide();
                }
            });
        }
        
        function canalM(){
            $('#canalm').on('change', function(){
                    var canal = $(this).val();
                    console.log('Canal: ' + canal);
                    if(canal != ""){
                        $.get(
                        '{{ route("admin::manifestacao::buscartipomanifestacao") }}',
                        {
                            idcanal : canal
                        },
                        function(result){
                            $('.dvmanifestacao').show();
                            $('.dvmanifestacao').html(result);
                            tipoManif();
                        }
                    );
                }else{
                    $('.dvmanifestacao').hide();
                }
            });
        }
        
        function tipoManif(){
            $("#tipomanif").on('change', function(){
                var prazo = $("#tipomanif option:selected").attr("data-value");
                console.log("PRAZO: " + prazo);
                
                $("#prazoresposta").val(prazo);
            });
        }
        
        $('#regiao').on('change', function(){
                    var regiao = $(this).val();
                    if(regiao != ""){
                        $.get(
                        '{{ route("admin::manifestacao::buscaruf") }}',
                        {
                            idregiao : regiao
                        },
                        function(result){
                            $('.dvuf').show();
                            $('.dvuf').html(result);
                            $('.dvlocalidade').hide();
                            localidadeM();
                        }
                    );
                }else{
                    $('.dvuf').hide();
                    $('.dvlocalidade').hide();
                }
            });
        
        $(".nencontrado").hide();
        $(".encontrado").hide();
        $(".produtos").hide();
        $(".canais").hide();
        $(".dvmanifestacao").hide();
        $(".dvuf").hide();
        $(".dvlocalidade").hide();
        $(".horamask").inputmask("99:99");
        $("#telefone").inputmask("(99) 9999-9999");
        $("#celular").inputmask("(99) 9999-9999[9]");
        
        $(".naotememail").on('click', function(){ console.log("OK"); $(".nencontrado").show(); })
        
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',                
            language: 'pt-BR',
            endDate: new Date()
          });

        $("#empresa").on('change', function(){
            var emp = $(this).val();
            if(emp != ""){
                $.get(
                    '{{ route("admin::canais::buscarcanal")}}',
                    {
                        idempresa : emp
                    },
                    function(result){
                        $(".canais").show();
                        $(".canais").html(result);
                        $('.dvmanifestacao').html("");
                        $('.dvmanifestacao').hide();
                        canalM();
                    }
                );
        
                $.get(
                    '{{ route("admin::manifestacao::buscarprodutoempresa")}}',
                    {
                        idempresa : emp
                    },
                    function(result){
                        $(".produtos").show();
                        $(".produtos").html(result);
                    }
                );

            }else{
                $(".produtos").hide();
                $(".canais").hide();
            }
        });
        
        $("#email").on('blur', function(){
            var email = $(this).val();
            $.get(
                '{{ route("admin::manifestacao::buscarreclamante")}}',
                {
                    email : email
                },
                function(result){
                    if(result == "0"){
                        $(".nencontrado").show();
                        $(".encontrado").hide();
                        $(".tabela").html("");
                    }else{
                        /*var res = JSON.stringify(result)
                        console.log(res);*/
                        
                        $(".tabela").html("");
                        
                        var res = JSON.parse(result);
                        var table = "<tr>" + 
                                    "<th></th>"+
                                    "<th>NOME</th>"+
                                    "<th>TELEFONE</th>"+
                                    "<th>CELULAR</th>"+
                                    "</tr>";
                        for(var i = 0; i < res.length; i++){
                            var rec = res[i];
                            var selecionado = '';
                            table += "<tr>";
                            if(i == 0){ selecionado = 'checked'; }
                            table += "<td><input " + selecionado + " type='radio' name='reclamante' value='"+ rec["RECLAMANTE_id"]+"' id='rec_" + rec["RECLAMANTE_id"]+ "'>" + "</td>";
                            table += "<td>" + rec["RECLAMANTE_nome"] + "</td>";
                            table += "<td>" + rec["RECLAMANTE_telefone"] + "</td>";
                            table += "<td>" + rec["RECLAMANTE_celular"] + "</td>";
                            table += "</tr>";
                            $(".tabela").html(table);
                        }
                        
                        $(".nencontrado").hide();
                        $(".encontrado").show();
                    }
                }
            );
        });
		
		$("#formcadastro").on('submit', function(){
			var idlocalidade = $("#idlocalidade").val();
			var dtentradacanal = $("#dtentradacanal").val();
			var dtquebraCanal = dtentradacanal.split('/');
                        var dtNCanal = new Date(dtquebraCanal[2], dtquebraCanal[1] - 1, dtquebraCanal[0]);
                        
                        var hrentradacanal = $("#hrentradacanal").val();
			var prazoresposta = $("#prazoresposta").val();
			var tipomanif = $("#tipomanif").val();
			
			var dtentradagestao = $("#dtentradagestao").val();
			var hrentradagestao = $("#hrentradagestao").val();
                        
                        var dtentradaocorrencia = $("#dtentradaocorrencia").val();
                        var dtquebraOco = dtentradaocorrencia.split('/');
                        var dtNOcorrencia = new Date(dtquebraOco[2], dtquebraOco[1] - 1, dtquebraOco[0]);
                        
                        var dtAtual = new Date();
                        var dtquebra = dtentradaocorrencia.split('/');
                        var dtN = new Date(dtquebra[2], dtquebra[1] - 1, dtquebra[0]);

			//console.log(idlocalidade);
			if(idlocalidade == undefined || idlocalidade == 0){
				alert("Escolha uma localidade");
			}else if(dtentradacanal == "" || !checkData(dtentradacanal) || hrentradacanal == ""){
				alert("Preencha o campo data e hora de entrada no canal");
			}else if(dtentradagestao == "" || !checkData(dtentradagestao) || hrentradagestao == ""){
				alert("Preencha o campo data e hora de entrada no canal");
			}else if(prazoresposta == ""){
				alert("Preencha o prazo para a resposta da manifestação");
			}else if(tipomanif == undefined || tipomanif == 0){
				alert("Escolha um tipo para a manifestação");
                        }else if(dtentradaocorrencia == "" || !checkData(dtentradaocorrencia) || dtAtual < dtN){
				alert("Preencha o campo data e hora da ocorrência corretamente");
                        }else if(dtNOcorrencia > dtNCanal){
				alert("Preencha o campo data e hora da ocorrência corretamente");
			}else{
				return true;
			}
			return false;
		});
    })
</script>
<div class="col-xs-12">
    <h3 class="page-header">Cadastrar Manifestação</h3>
    <form method="post" action="{{ route('admin::manifestacao::cadastrar')}}" class="well" id="formcadastro">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="form-group col-xs-8" >
            E-mail Reclamante:
            <input type="email" id="email" name="email" class="form-control">
            <a href="#" class="btn btn-default naotememail">Não Possui</a>
        </div>
        <div class="form-group col-xs-4">
            Código Reclamante Empresa:
            <input type="text" name="codigo" class="form-control">
        </div>
    </div>
    <div class="row nencontrado">
        <div class="form-group col-xs-6">
            Nome:
            <input type="text" name="nome" id="nome" class="form-control">
        </div>
        <div class="form-group col-xs-3">
            Telefone:
            <input type="text" name="telefone" id="telefone" class="form-control">
        </div>
        <div class="form-group col-xs-3">
            Celular:
            <input type="text" name="celular" id="celular" class="form-control">
        </div>
    </div>
    <div class="row encontrado">
        <div class="form-group col-xs-12">
            <table class="table table-condensed tabela">
                <tr>
                    <th></th>
                    <th>NOME</th>
                    <th>TELEFONE</th>
                    <th>CELULAR</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-6">
            Empresa:
            <select name="empresa" id="empresa" required class="form-control">
                <option value=""></option>
                @if(count($lista) > 0)
                    @foreach($lista as $em)
                    <option value="{{ $em->EMPRESA_id}}">{{ $em->EMPRESA_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-xs-6">
            <div class="produtos">
            Produto:
            <select name="produto" class="form-control" required>
                <option value=""></option>
            </select>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="form-group col-xs-6">
            <div class="canais">
            Canal:
            <select name="canalM" class="form-control" required>
                <option value=""></option>
            </select>
            </div>
        </div>
        <div class="form-group col-xs-6">
            <div class="dvmanifestacao">
            Tipo de manifestação:
            <select name="tipomanifestacao" class="form-control" required>
                <option value=""></option>
            </select>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            Resumo:
            <textarea name="resumo" rows="4" class="form-control"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            Completa:
            <textarea name="completa" rows="8" class="form-control"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-3">
            Data Entrada Canal:
            <input type="text" name="dtentradacanal" class="form-control datepicker" required>
        </div>
        <div class="form-group col-xs-3">
            Hora Entrada no Canal:
            <input type="text" name="hrentradacanal" class="form-control horamask" required>
        </div>
        <div class="form-group col-xs-3">
            Data Ocorrência:
            <input type="text" name="dtentradaocorrencia" class="form-control datepicker">
        </div>
        <div class="form-group col-xs-3">
            Hora Ocorrência
            <input type="text" name="hrentradaocorrencia" class="form-control horamask">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-3">
            Data Entrada Gestão:
            <input type="text" name="dtentradagestao" class="form-control datepicker" required>
        </div>
        <div class="form-group col-xs-3">
            Hora Entrada na Gestão:
            <input type="text" name="hrentradagestao" class="form-control horamask" required>
        </div>
        <div class="form-group col-xs-3">
            Prazo de resposta:
            <input type="text" name="prazoresposta" id="prazoresposta" class="form-control" required>
        </div>
        <div class="form-group col-xs-3">
            Nível:
            <select name="nivel" class="form-control">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            Endereço:
            <input type="text" name="endereco" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-12">
            Referência:
            <input type="text" name="referencia" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-xs-4">
            Região:
            <select name="regiao" id="regiao" required class="form-control">
                <option value=""></option>
                @if(count($listaR) > 0)
                    @foreach($listaR as $r)
                    <option value="{{ $r->REGIAO_id}}">{{ $r->REGIAO_nome }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group col-xs-4">
            <div class="dvuf">
            UF:
            <select name="ufs" id="ufs" class="form-control" required>
                <option value=""></option>
            </select>
            </div>
        </div>
        
        <div class="form-group col-xs-4">
            <div class="dvlocalidade">
            Localidade:
            <select name="idlocalidade" id="idlocalidade" class="form-control" required>
                <option value=""></option>
            </select>
            </div>
        </div>
    </div>
    <input type="submit" value="Cadastrar Manifestação" class="btn btn-primary">
</form>
</div>
@endsection