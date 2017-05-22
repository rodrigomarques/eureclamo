<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilPrestador extends Model
{
    protected $table = "perfilprestador";
    protected $primaryKey = "PERFIL_PREST_id";
    public $timestamps = false;
    protected $fillable = ['PERFIL_PREST_id', 'PERFIL_PREST_nome', 'PERFIL_EMP_idPrestador'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
