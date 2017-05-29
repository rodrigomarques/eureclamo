<?php

namespace App\Repository;

use App\ProdutoEmpresa;

class ProdutoEmpresaDao {
    /**
     *
     * @var \App\ProdutoEmpresa
     */
    private $model;
    
    public function __construct(ProdutoEmpresa $pe) {
        $this->model = $pe;
    }
    
    public function buscarId($idEmpresa = ""){
        $result = $this->model
                ->join('produto', 'produto.PRODUTO_id', '=', 'produtoempresa.PRODUTO_EMP_idProduto')
                        ;
        if($idEmpresa != "")
            $result->Where("PRODUTO_EMP_idEmpresa", "=", $idEmpresa);
                        
            $result->orderBy("PRODUTO_nome");
                        
        return $result->select('PRODUTO_nome', 'PRODUTO_descricao', 'PRODUTO_id', 'PRODUTO_grupo',
                'PRODUTO_EMP_idEmpresa')
                ->distinct()->get();
    }
    
    public function buscar($nome = "", $grupo = "", $idEmpresa = "", $status = 1){
        $result = $this->model
                ->rightJoin('produto', 'produto.PRODUTO_id', '=', 'produtoempresa.PRODUTO_EMP_idProduto')
                        ;
        if($idEmpresa != "")
            $result->Where("PRODUTO_EMP_idEmpresa", "=", $idEmpresa);
        
        if($nome != "")
            $result->Where("PRODUTO_nome", "like","%". $nome . "%");
        
        if($grupo != "")
            $result->Where("PRODUTO_grupo", "like", "%".$grupo . "%");
        
        if($status != "")
            $result->Where("PRODUTO_status", "=", $status);
            $result->orderBy("PRODUTO_nome");
                        
        return $result->select('PRODUTO_nome', 'PRODUTO_descricao', 'PRODUTO_id', 'PRODUTO_grupo', 
                'PRODUTO_status', 'PRODUTO_dataCadastro', 'PRODUTO_dataCancel')
                ->distinct()->get();
    }
    

}
