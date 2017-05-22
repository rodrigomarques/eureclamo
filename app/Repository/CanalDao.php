<?php

namespace App\Repository;

use App\Canal;

class CanalDao {
    /**
     *
     * @var \App\Canal
     */
    private $model;
    
    public function __construct(Canal $c) {
        $this->model = $c;
    }
    
    public function buscar($nome = "", $empresa = ""){
        $result = $this->model
                        ->join('empresa', 'canal.EMPRESA_id', '=', 'empresa.EMPRESA_id')
                        ->Where('CANAL_nome', 'like',"%". $nome. "%")
                        ;
        if($empresa != "")
            $result = $result->Where("canal.EMPRESA_id", "=", $empresa);
        
                        $result->orderBy("CANAL_nome");
                        
        return $result->select('CANAL_nome', 'CANAL_status', 'CANAL_id', 
                'canal.EMPRESA_id', 'EMPRESA_nome', 'EMPRESA_sigla')
                ->distinct()->paginate(40);
    }
    
    public function total($nome = ""){
        $result = $this->model
                        ->Where('CANAL_nome', 'like', "%".$nome."%")
                        ;
        return $result->select('CANAL_id')->get()->count();
    }

}
