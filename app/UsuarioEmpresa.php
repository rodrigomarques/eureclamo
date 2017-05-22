<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioEmpresa extends Usuario
{
    protected $table = "usuarioempresa";
    //protected $primaryKey = "USUARIO_EMP_id";
    public $timestamps = false;
    protected $fillable = ['USUARIO_EMP_idUsuario','USUARIO_EMP_idEmpresa'];
    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
}
