<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidade extends Model
{
    protected $table = "localidade";
    protected $primaryKey = "LOCALIDADE_id";
    public $timestamps = false;
    protected $fillable = ['LOCALIDADE_id', 'LOCALIDADE_nome','UF_id'];

    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
