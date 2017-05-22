<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoManifestacaoCanal extends Model
{
    protected $table = "tipomanifcanal";
    //protected $primaryKey = 'TIPO_CANAL_idTipo' 'TIPO_CANAL_idCanal';
    public $timestamps = false;
    protected $fillable = ['TIPO_CANAL_idTipo', 'TIPO_CANAL_idCanal', 'TIPO_CANAL_nrVersao', 
        'TIPO_CANAL_PrazoPadrao', 'TIPO_CANAL_dataInicioVersao', 'TIPO_CANAL_dataFimVersao'];

    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
