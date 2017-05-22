<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conclusao extends Model
{
    protected $table = "conclusao";
    public $timestamps = false;
    protected $fillable = ['CONCLUSAO_id','CONCLUSAO_parecer','CONCLUSAO_respReclamante',
                'CONCLUSAO_dataHora','MANIFESTACAO_MANIF_id','MANIFESTACAO_MANIF_ano'];
    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
   
}
