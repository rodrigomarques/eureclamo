<?php

namespace App\Repository;

use App\Prestador;

class PrestadorDao {
    /**
     *
     * @var \App\Prestador
     */
    private $model;
    
    public function __construct(Prestador $e) {
        $this->model = $e;
    }
    
    public function buscarPorIdServ($idserv = ""){
        $result = $this->model
                ->join('servicoprestador', 'servicoprestador.SERVICO_PREST_idPrestador', '=', 'prestador.PRESTADOR_id')
                        ->Where('servicoprestador.SERVICO_PREST_idServico', '=', $idserv)
                        ;
                        
            $result->orderBy("PRESTADOR_nome");
                        
        return $result->select('*')
                ->distinct()->get();
    }
    
    public function buscar($nome = "", $cnpj = ""){
        $result = $this->model;
        
        if($nome != "")
            $result = $result->Where('PRESTADOR_nome', 'like', "%".$nome."%");
        
        if($cnpj != "")
            $result = $result->Where('PRESTADOR_cnpj', '=', $cnpj);
        
                        ;
            $result->orderBy("PRESTADOR_nome");
                        
            
           //echo  $result->toSql();
        return $result->select('*')
                ->distinct()->get();
    }
    
}
