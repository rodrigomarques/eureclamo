<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnexoMensagem extends Model
{
    protected $table = "anexomensagem";
    protected $primaryKey = "ANEXO_MSG_id";
    public $timestamps = false;
    protected $fillable = ['ANEXO_MSG_id', 'ANEXO_MSG_nomeArq', 'ANEXO_MSG_tipoArq', 'ANEXO_MSG_arquivo', 
        'MSG_USUARIO_id', 'MSG_USUARIO_ano'];

    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
