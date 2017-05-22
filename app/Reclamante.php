<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reclamante extends Model
{
    protected $table = "reclamante";
    protected $primaryKey = "RECLAMANTE_id";
    public $timestamps = false;
    protected $fillable = ['RECLAMANTE_id', 'RECLAMANTE_nome', 'RECLAMENTE_telefone','RECLAMENTE_celular',
                        'RECLAMENTE_email'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    
}
