<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoManifestacao extends Model
{
    protected $table = "tipomanifestacao";
    protected $primaryKey = "TIPOMANIF_id";
    public $timestamps = false;
    protected $fillable = ['TIPOMANIF_id', 'TIPOMANIF_nome', 'TIPOMANIF_status'];

    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
