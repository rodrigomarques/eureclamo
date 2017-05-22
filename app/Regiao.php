<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $table = "regiao";
    protected $primaryKey = "REGIAO_id";
    public $timestamps = false;
    protected $fillable = ['REGIAO_id', 'REGIAO_nome', 'REGIAO_sigla'];

    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
