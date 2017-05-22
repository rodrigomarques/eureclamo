<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = "servico";
    protected $primaryKey = "SERVICO_id";
    public $timestamps = false;
    protected $fillable = ['SERVICO_id', 'SERVICO_nome', 'SERVICO_descricao', 'SERVICO_grupo'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    public function empresa()
    {
        return $this->belongsTo('App\Empresa','SERVICO_EMPRESA_id');
    }
    
}
