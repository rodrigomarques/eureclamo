<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = "perfil";
    protected $primaryKey = "PERFIL_id";
    public $timestamps = false;
    protected $fillable = ['PERFIL_id', 'PERFIL_nome'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
