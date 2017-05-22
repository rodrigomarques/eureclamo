<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensagemUsuario extends Model
{
    protected $table = "mensagemusuario";
    //protected $primaryKey = "MSG_USUARIO_id";
    public $timestamps = false;
    protected $fillable = ['MSG_USUARIO_id','MSG_MSG_ano','MSG_MSG_mensagem', 'MSG_MSG_dataHoraMsg',
            'MANIFESTACAO_id','MANIFESTACAO_MANIF_ano','SERVICOPRESTADOR_idServico', 
        'SERVICOPRESTADOR_idPrestador', 'MSG_USUARIO_idUsuario'];

    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
