<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manifestacao extends Model
{
    protected $table = "manifestacao";
    protected $primaryKey = "MANIF_id";
    public $timestamps = false;
    protected $fillable = ['MANIF_id', 'MANIF_ano','MANIF_TIPO_CANAL_idTipo','MANIF_TIPO_CANAL_idCanal',
                'MANIF_EMPRESA_idEmpresa','MANIF_PRODUTO_idProduto','MANIF_RECLAMANTE_idReclamante',
                'MANIF_LOCALIDADE_id','MANIF_codReclamanteEmp','MANIF_resumo','MANIF_completa',
                'MANIF_dataHora_EntCanal','MANIF_dataHora_Ocorrencia','MANIF_dataHora_EntGestao',
                'MANIF_dataHora_Cadastro','MANIF_endereco','MANIF_referencia','MANIF_status',
                'MANIF_prazoResposta','MANIF_nivel'];

    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
