<?php

namespace App\Repository;

use App\Empresa;

class EmpresaDao {
    /**
     *
     * @var \App\Empresa
     */
    private $model;
    
    public function __construct(Empresa $e) {
        $this->model = $e;
    }
    
    public function buscarPorIdProd($idproduto = ""){
        $result = $this->model
                ->join('produtoempresa', 'produtoempresa.PRODUTO_EMP_idEmpresa', '=', 'empresa.EMPRESA_id')
                        ->Where('produtoempresa.PRODUTO_EMP_idProduto', '=', $idproduto)
                        ;
                        
            $result->orderBy("EMPRESA_nome");
                        
        return $result->select('*')
                ->distinct()->get();
    }
    
    public function buscar($nome = "", $nomeCompleto = "", $cnpj = "", $sigla = ""){
        $result = $this->model;
                //->join('produtoempresa', 'produtoempresa.PRODUTO_EMP_idEmpresa', '=', 'empresa.EMPRESA_id')
        if($nome != "")
            $result = $result->Where('EMPRESA_nome', 'like', "%".$nome."%");
        
        if($nomeCompleto != "")
            $result = $result->Where('EMPRESA_nomeCompleto', 'like', "%".$nomeCompleto."%");
        
        if($cnpj != "")
            $result = $result->Where('EMPRESA_cnpj', '=', $cnpj);
        
        if($sigla != "")
            $result = $result->Where('EMPRESA_sigla', '=', $sigla);
                        ;
            $result->orderBy("EMPRESA_nome");
                        
            
           //echo  $result->toSql();
        return $result->select('*')
                ->distinct()->get();
    }
    
}
