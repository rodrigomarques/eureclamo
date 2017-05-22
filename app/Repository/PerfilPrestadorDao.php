<?php

namespace App\Repository;

use App\PerfilPrestador;

class PerfilPrestadorDao {
    /**
     *
     * @var \App\PerfilPrestador
     */
    private $model;
    
    public function __construct(PerfilPrestador $pe) {
        $this->model = $pe;
    }
    
    public function buscar($nome = "", $id = ""){
        $result = $this->model
                ->join('prestador', 'prestador.PRESTADOR_id', '=', 'perfilprestador.PERFIL_PREST_idPrestador')
                        ->Where('PERFIL_PREST_nome', 'like', "%".$nome)
                        ;
        if($id != "")
            $result->Where(" PERFIL_PREST_idPrestador", "=", $id);
                        
            $result->orderBy("PERFIL_PREST_nome");
                        
        return $result->select('PERFIL_PREST_nome', 'PERFIL_PREST_idPrestador', 'PERFIL_PREST_id', 
                'PRESTADOR_nome')
                ->distinct()->paginate(40);
    }
    
    public function total($nome = "", $id = ""){
        $result = $this->model
                ->join('prestador', 'prestador.PRESTADOR_id', '=', 'perfilprestador.PERFIL_PREST_idPrestador')
                        ->Where('PERFIL_PREST_nome', 'like',"%". $nome)
                        ;
        if($id != "")
            $result->Where(" PERFIL_PREST_idPrestador", "=", $id);
                        
            $result->orderBy("PERFIL_PREST_nome");
                        
        return $result->select('PERFIL_PREST_idPrestador')->get()->count();
    }

}
