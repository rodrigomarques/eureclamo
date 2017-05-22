<?php

namespace App\Repository;

use App\Servico;

class ServicoDao {
    /**
     *
     * @var \App\Servico
     */
    private $model;
    
    public function __construct(Servico $s) {
        $this->model = $s;
    }
    
    public function buscar($nome = "", $grupo = "", $idempresa = "", $status = ""){
        $result = $this->model
                ->leftJoin('empresa', 'empresa.EMPRESA_id', '=', 'servico.SERVICO_EMPRESA_id');
            
        if($nome != "")
            $result->Where('servico.SERVICO_nome', 'like', "%".$nome . "%");
        
        if($grupo != "")
            $result->Where('servico.SERVICO_grupo', 'like', "%".$grupo. "%");
        
        if($idempresa != "" && $idempresa != 0)
            $result->Where('servico.SERVICO_EMPRESA_id', '=', $idempresa);
        
        if($status != "" )
        $result->Where('servico.SERVICO_status', '=', $status);
                        
            $result->orderBy("SERVICO_nome");
                        
        return $result->select('*')
                ->distinct()->get();
    }
    
    public function buscarPorIdPrest($idprest = ""){
        $result = $this->model
                ->join('servicoprestador', 'servicoprestador.SERVICO_PREST_idServico', '=', 'servico.SERVICO_id')
                        ->Where('servicoprestador.SERVICO_PREST_idPrestador', '=', $idprest)
                        ;
                        
            $result->orderBy("SERVICO_nome");
                        
        return $result->select('*')
                ->distinct()->get();
    }
}
