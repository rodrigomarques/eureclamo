<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoEmpresa extends Model
{
    //protected $primaryKey = ['codcredenciado', 'codtipoespecializacao'];
    protected $table = "produtoempresa";
    public $timestamps = false;
    protected $fillable = ['PRODUTO_EMP_idEmpresa', 'PRODUTO_EMP_idProduto'];
    
    function __construct($dbname = "mysql") {
        $this->connection = Config::$dbname;
    }
    
    public function produto()
    {
        return $this->belongsTo('App\Produto', 'PRODUTO_id');
    }
    
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'EMPRESA_id');
    }
    
}
