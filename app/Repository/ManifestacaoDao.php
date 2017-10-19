<?php

namespace App\Repository;

use App\Manifestacao;

class ManifestacaoDao {
    /**
     *
     * @var \App\Manifestacao
     */
    private $model;
    
    public function __construct(Manifestacao $e) {
        $this->model = $e;
    }
    
    public function buscar($idcanal = "", $idtipo = "", $idlocalidade = "", 
            $dtocorrencia = "", $nivel = "", $codigo = ""){
        $result = $this->model
                ->leftJoin('canal', 'manifestacao.MANIF_TIPO_CANAL_idCanal', '=', 'canal.CANAL_id')
                ->leftJoin('tipomanifestacao', 'manifestacao.MANIF_TIPO_CANAL_idTipo', '=', 'tipomanifestacao.TIPOMANIF_id')
                ->leftJoin('produto', 'produto.PRODUTO_id', '=', 'manifestacao.MANIF_PRODUTO_idProduto')
                ->leftJoin('localidade', 'localidade.LOCALIDADE_id', '=', 'manifestacao.MANIF_LOCALIDADE_id')
                ->leftJoin('empresa', 'empresa.EMPRESA_id', '=', 'manifestacao.MANIF_EMPRESA_idEmpresa')
                ->leftJoin('reclamante', 'reclamante.RECLAMANTE_id', '=', 'manifestacao.MANIF_RECLAMANTE_idReclamante')
                        ;
        
        if($idcanal != ""){
            $result->Where('MANIF_TIPO_CANAL_idCanal', '=', $idcanal);
        }
        
        if($idtipo != ""){
            $result->Where('MANIF_TIPO_CANAL_idTipo', '=', $idtipo);
        }
        
        if($idlocalidade != ""){
            $result->Where('MANIF_LOCALIDADE_id', '=', $idlocalidade);
        }
        
        if($nivel != ""){
            $result->Where('MANIF_nivel', '=', $nivel);
        }
        
        if($codigo != ""){
            $result->Where('MANIF_codReclamanteEmp', '=', $nivel);
        }
        
        if($dtocorrencia != ""){
            $result->Where('MANIF_dataHora_Cadastro', '>=', $dtocorrencia);
        }
        
                        
            //$result->orderBy("MANIF_dataHora_Cadastro", "desc");
            $result->orderBy("MANIF_dataHora_EntCanal", "asc");
            $result->limit(50)            ;
        return $result->select('*')
                ->distinct()->get();
    }
    
    public function buscarId($id, $ano = 17){
        $result = $this->model
                ->leftJoin('empresa', 'manifestacao.MANIF_EMPRESA_idEmpresa', '=', 'empresa.EMPRESA_id')
                ->leftJoin('canal', 'manifestacao.MANIF_TIPO_CANAL_idCanal', '=', 'canal.CANAL_id')
                ->leftJoin('tipomanifestacao', 'manifestacao.MANIF_TIPO_CANAL_idTipo', '=', 'tipomanifestacao.TIPOMANIF_id')
                ->leftJoin('produto', 'produto.PRODUTO_id', '=', 'manifestacao.MANIF_PRODUTO_idProduto')
                ->leftJoin('localidade', 'localidade.LOCALIDADE_id', '=', 'manifestacao.MANIF_LOCALIDADE_id')
                ->leftJoin('reclamante', 'reclamante.RECLAMANTE_id', '=', 'manifestacao.MANIF_RECLAMANTE_idReclamante')
                        ;
        
        $result->Where('MANIF_id', '=', $id);
        $result->Where('MANIF_ano', '=', $ano);
        
                        
        return $result->select('*')
                ->first();
    }
    
     public function buscarCodigos($codigomanif = "", $codigorec = ""){
        $result = $this->model
                ->leftJoin('empresa', 'manifestacao.MANIF_EMPRESA_idEmpresa', '=', 'empresa.EMPRESA_id')
                ->leftJoin('canal', 'manifestacao.MANIF_TIPO_CANAL_idCanal', '=', 'canal.CANAL_id')
                ->leftJoin('tipomanifestacao', 'manifestacao.MANIF_TIPO_CANAL_idTipo', '=', 'tipomanifestacao.TIPOMANIF_id')
                ->leftJoin('produto', 'produto.PRODUTO_id', '=', 'manifestacao.MANIF_PRODUTO_idProduto')
                ->leftJoin('localidade', 'localidade.LOCALIDADE_id', '=', 'manifestacao.MANIF_LOCALIDADE_id')
                        ;
        if($codigomanif != ""){
            
            $result->Where(\DB::connection(\App\Config::$dbname)->raw("CONCAT(MANIF_id, MANIF_ano)"), '=', $codigomanif);
        }
        
        if($codigorec != ""){
            $result->Where('MANIF_codReclamanteEmp', '=', $codigorec);
        }
        
        
        return $result->select('*')
                ->first();
    }
    
}
