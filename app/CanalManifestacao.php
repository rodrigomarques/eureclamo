<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanalManifestacao extends Model
{
    protected $table = "tipomanifcanal";
    public $timestamps = false;
    protected $fillable = ['TIPO_CANAL_idTipo', 'TIPO_CANAL_idCanal', 'TIPO_CANAL_PrazoPadrao'];
    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
   
}
