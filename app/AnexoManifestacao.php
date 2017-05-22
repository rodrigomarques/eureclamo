<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnexoManifestacao extends Model
{
    protected $table = "anexomanifestacao";
    protected $primaryKey = "ANEXO_MANIF_idAnexo";
    public $timestamps = false;
    protected $fillable = ['ANEXO_MANIF_idAnexo','ANEXO_MANIF_nomeArq','ANEXO_MANIF_tipoArq',
            'ANEXO_MANIF_arquivo','MANIF_id','MANIF_ano'];

    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
