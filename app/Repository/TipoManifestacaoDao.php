<?php

namespace App\Repository;

use App\TipoManifestacao;

class TipoManifestacaoDao {
    /**
     *
     * @var \App\TipoManifestacao
     */
    private $model;
    
    public function __construct(TipoManifestacao $t) {
        $this->model = $t;
    }
    
    public function buscar($nome = "", $status = 1){
        $result = $this->model
                        ->Where('TIPOMANIF_nome', 'like',"%". $nome);
        if($status != "")
            $result->Where('TIPOMANIF_status', '=', $status)
                        ;
                        $result->orderBy("TIPOMANIF_nome");
                        
        return $result->select('TIPOMANIF_nome', 'TIPOMANIF_id', 'TIPOMANIF_status')
                ->distinct()->paginate(40);
    }
    
    public function total($nome = ""){
        $result = $this->model
                        ->Where('TIPOMANIF_nome', 'like',"%". $nome)
                        ;
        return $result->select('TIPOMANIF_id')->get()->count();
    }
    
    public function buscarIdCanal($idCanal = ""){
        $result = $this->model
                        ->join('tipomanifcanal', 'tipomanifcanal.TIPO_CANAL_idTipo', '=', 'tipomanifestacao.TIPOMANIF_id')
                        ->Where('TIPO_CANAL_idCanal', '=', $idCanal)
                        ;
                        $result->orderBy("TIPOMANIF_nome");
                        
        return $result->select('TIPOMANIF_nome', 'TIPOMANIF_id', 'TIPO_CANAL_PrazoPadrao')
                ->distinct()->get();
    }
    
}
