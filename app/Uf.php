<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $table = "uf";
    protected $primaryKey = "UF_id";
    public $timestamps = false;
    protected $fillable = ['UF_id', 'UF_nome','UF_sigla',  'REGIAO_id'];

    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
