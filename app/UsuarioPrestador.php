<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPrestador extends Usuario
{
    protected $table = "usuarioprestador";
    public $timestamps = false;
    protected $fillable = ['USUARIO_PREST_idUsuario', 'USUARIO_PREST_idPrestador'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
