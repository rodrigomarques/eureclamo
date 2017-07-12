<?php

namespace App\Repository;

use App\TipoManifestacaoCanal;

class TipoManifestacaoCanalDao {
    /**
     *
     * @var \App\TipoManifestacaoCanal
     */
    private $model;
    
    public function __construct(TipoManifestacaoCanal $t) {
        $this->model = $t;
    }
    
    public function buscar($idtipo = 0, $idcanal = 0){
        $result = $this->model
                ->join('canal', 'canal.CANAL_id', '=', 'tipomanifcanal.TIPO_CANAL_idCanal')
                ->join('empresa', 'canal.EMPRESA_id', '=', 'empresa.EMPRESA_id')
                    ->join('tipomanifestacao', 'tipomanifestacao.TIPOMANIF_id', '=', 'tipomanifcanal.TIPO_CANAL_idTipo');
        
        if($idtipo != 0)
            $result = $result->Where('TIPO_CANAL_idTipo', '=', $idtipo);
        
        if($idcanal != 0)
            $result = $result->Where('TIPO_CANAL_idCanal', '=', $idcanal);
                        
        //$result->WhereNull('TIPO_CANAL_dataFimVersao');
        //echo $result->toSql();
        $result->orderBy('TIPO_CANAL_dataInicioVersao', 'desc');
        return $result->select('*')
                ->distinct()->paginate(40);
    }
    
    public function total($idtipo = 0, $idcanal = 0){
        $result = $this->model
                ->join('canal', 'canal.CANAL_id', '=', 'tipomanifcanal.TIPO_CANAL_idCanal')
                    ->join('tipomanifestacao', 'tipomanifestacao.TIPOMANIF_id', '=', 'tipomanifcanal.TIPO_CANAL_idTipo');
        
        if($idtipo != 0)
            $result = $result->Where('TIPO_CANAL_idTipo', '=', $idtipo);
        
        if($idcanal != 0)
            $result = $result->Where('TIPO_CANAL_idCanal', '=', $idcanal);                ;
            
        return $result->select('*')->get()->count();
    }
    
    public function buscarIdTIpoIdCanal($idtipo, $idcanal){
        $result = $this->model
                        ->Where('TIPO_CANAL_idTipo', '=', $idtipo)
                        ->Where('TIPO_CANAL_idCanal', '=', $idcanal)
                
                        ;
                        
                        
        return $result->select('*')->get();
    }
    
    public function buscarIdTIpoIdCanalUltimo($idtipo, $idcanal){
        $result = $this->model
                        ->Where('TIPO_CANAL_idTipo', '=', $idtipo)
                        ->Where('TIPO_CANAL_idCanal', '=', $idcanal)
                        ;
                        
       $result->WhereNull('TIPO_CANAL_dataFimVersao');        
       $result->orderBy('TIPO_CANAL_dataInicioVersao', 'desc');
        return $result->select('*')->first();
    }
    
}
