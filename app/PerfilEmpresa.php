<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerfilEmpresa extends Model
{
    protected $table = "perfilempresa";
    protected $primaryKey = "PERFIL_EMP_id";
    public $timestamps = false;
    protected $fillable = ['PERFIL_EMP_id', 'PERFIL_EMP_nome', 'PERFIL_EMP_idEmpresa'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
