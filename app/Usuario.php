<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticateContract;

//http://laravel.artesaos.org/docs/5.1/authentication#authenticating-users
class Usuario extends Model implements AuthenticateContract
{
    protected $table = "usuario";
    protected $primaryKey = "USUARIO_id";
    public $timestamps = false;
    protected $fillable = ['USUARIO_id', 'USUARIO_nome', 'USUARIO_email', 'USUARIO_login',
                  'USUARIO_nivel','password', 'USUARIO_tipo', 'USUARIO_status', 'USUARIO_PERFIL_id'];
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    public function getAuthIdentifier() {
        return $this->getKey();
    }

    public function getAuthPassword() {
        //Qual o campo da minha tabela sera de senha
        //return $this->USUARIO_EMP_senha;
        return $this->password;

    }

    public function getRememberToken() {
        
    }

    public function getRememberTokenName() {
        
    }

    public function setRememberToken($value) {
        
    }

    
}
