<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicoPrestador extends Model
{
    //protected $primaryKey = ['codcredenciado', 'codtipoespecializacao'];
    protected $table = "servicoprestador";
    public $timestamps = false;
    protected $fillable = ['SERVICO_PREST_idServico', 'SERVICO_PREST_idPrestador'];
    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    public function servico()
    {
        return $this->belongsTo('App\Servico', 'SERVICO_id');
    }
    
    public function prestador()
    {
        return $this->belongsTo('App\Prestador', 'PRESTADOR_id');
    }
    
}
