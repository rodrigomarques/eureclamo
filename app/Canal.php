<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $table = "canal";
    protected $primaryKey = "CANAL_id";
    public $timestamps = false;
    protected $fillable = ['CANAL_id', 'CANAL_nome', 'CANAL_status', 'EMPRESA_id'];

    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    
}
