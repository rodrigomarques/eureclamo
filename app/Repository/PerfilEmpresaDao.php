<?php

namespace App\Repository;

use App\PerfilEmpresa;

class PerfilEmpresaDao {
    /**
     *
     * @var \App\PerfilEmpresa
     */
    private $model;
    
    public function __construct(PerfilEmpresa $pe) {
        $this->model = $pe;
    }
    
    public function buscar($nome = "", $id = ""){
        $result = $this->model
                ->join('empresa', 'empresa.EMPRESA_id', '=', 'perfilempresa.PERFIL_EMP_idEmpresa')
                        ->Where('PERFIL_EMP_nome', 'like',"%". $nome . "%")
                        ;
        if($id != "")
            $result->Where("PERFIL_EMP_idEmpresa", "=", $id);
                        
            $result->orderBy("PERFIL_EMP_nome");
                        
        return $result->select('PERFIL_EMP_nome', 'PERFIL_EMP_idEmpresa', 'PERFIL_EMP_id', 'EMPRESA_nome')
                ->distinct()->paginate(40);
    }
    
    public function total($nome = "", $id = ""){
        $result = $this->model
                        ->Where('PERFIL_EMP_nome', 'like',"%". $nome . "%")
                        ;
        if($id != "")
            $result->Where("PERFIL_EMP_idEmpresa", "=", $id);
                        
            $result->orderBy("PERFIL_EMP_nome");
                        
        return $result->select('PERFIL_EMP_idEmpresa')->get()->count();
    }

}
