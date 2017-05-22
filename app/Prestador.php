<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    protected $table = "prestador";
    protected $primaryKey = "PRESTADOR_id";
    public $timestamps = false;
    protected $fillable = ['PRESTADOR_id', 'PRESTADOR_nome', 'PRESTADOR_nomeCompleto', 'PRESTADOR_cnpj'];

    
    public function __construct($dbname = "mysql") {
        //$this->connection = $dbname;
        $this->connection = Config::$dbname;
    }
    
    public function servicoPrestador()
    {
        return $this->belongsToMany('App\ServicoPrestador','servicoprestador', 
                'SERVICO_PREST_idServico', 'SERVICO_PREST_idPrestador');
    }
    
}
