<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = "produto";
    protected $primaryKey = "PRODUTO_id";
    public $timestamps = false;
    protected $fillable = ['PRODUTO_id', 'PRODUTO_nome', 'PRODUTO_descricao', 'PRODUTO_grupo'];

    
    public function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }

    public function produtoEmpresa()
    {
        return $this->belongsToMany('App\ProdutoEmpresa','produtoempresa', 
                'PRODUTO_EMP_idProduto', 'PRODUTO_EMP_idEmpresa');
    }
}
