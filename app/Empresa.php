<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresa";
    protected $primaryKey = "EMPRESA_id";
    public $timestamps = false;
    protected $fillable = ['EMPRESA_id', 'EMPRESA_nome', 'EMPRESA_nomeCompleto', 'EMPRESA_cnpj', 
        'EMPRESA_sigla'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    public function produtoEmpresa()
    {
        return $this->belongsToMany('App\ProdutoEmpresa','produtoempresa', 
                'PRODUTO_EMP_idEmpresa', 'PRODUTO_EMP_idProduto');
    }
    
}
