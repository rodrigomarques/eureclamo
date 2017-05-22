<?php

namespace App\Repository;

use App\UsuarioEmpresa;

class UsuarioEmpresaDao {
    /**
     *
     * @var \App\UsuarioEmpresa
     */
    private $model;
    
    public function __construct(UsuarioEmpresa $ue) {
        $this->model = $ue;
    }
    
    public function buscar($nome = "", $login = "", $email = ""){
        $result = $this->model
                ->join('usuario', 'usuarioempresa.USUARIO_EMP_idUsuario', '=', 'usuario.USUARIO_id')
                ->join('empresa', 'empresa.EMPRESA_id', '=', 'usuarioempresa.USUARIO_EMP_idEmpresa')
                ->join('perfil', 'perfil.PERFIL_id', '=', 'usuario.USUARIO_PERFIL_id')
                        
                        ;
        if($nome != "")
            $result->Where('USUARIO_nome', 'like', "%".$nome . "%");
        
        if($login != "")
            $result->Where('USUARIO_login', 'like', "%".$login . "%");
        
        if($email != "")
            $result->Where('USUARIO_email', 'like', "%".$email . "%");
                        
            $result->orderBy("USUARIO_nome");
            //echo $result->toSql();
            
        return $result->select('*')
                ->distinct()->paginate(40);
    }
    
    public function total($nome = "", $login = "", $email = ""){
        $result = $this->model
                ->join('usuario', 'usuarioempresa.USUARIO_EMP_idUsuario', '=', 'usuario.USUARIO_id')
                ->join('empresa', 'empresa.EMPRESA_id', '=', 'usuarioempresa.USUARIO_EMP_idEmpresa')
                ->join('perfil', 'perfil.PERFIL_id', '=', 'usuarioempresa.USUARIO_PERFIL_id')        
                        ;
        if($nome != "")
            $result->Where('USUARIO_nome', 'like', "%".$nome . "%");
        
        if($login != "")
            $result->Where('USUARIO_login', 'like',"%". $login . "%");
        
        if($email != "")
            $result->Where('USUARIO_email', 'like', "%".$email . "%");
                        
            $result->orderBy("USUARIO_nome");
                        
                        
        return $result->select('USUARIO_id')->get()->count();
    }
    
    public function buscarEmailPorIdEmpresa($idempresa, $nivel){
        $sql = "select USUARIO_email, EMPRESA_id, USUARIO_nivel from empresa e inner join usuarioempresa ue 
            on e.EMPRESA_id = ue.USUARIO_EMP_idEmpresa 
        inner join usuario u on u.USUARIO_id = ue.USUARIO_EMP_id 
        where EMPRESA_id = " . $idempresa . " and USUARIO_nivel <= " . $nivel;
        
        $result = $this->model
                ->join('usuario', 'usuarioempresa.USUARIO_EMP_idUsuario', '=', 'usuario.USUARIO_id')
                ->join('empresa', 'empresa.EMPRESA_id', '=', 'usuarioempresa.USUARIO_EMP_idEmpresa')
                
                        
                        ;
            $result->Where('EMPRESA_id', '=', $idempresa);
            $result->Where('USUARIO_nivel', '<=', $nivel);
        
            $result->orderBy("USUARIO_email");
                        
        return $result->select('USUARIO_nome','USUARIO_email','USUARIO_login',
            'USUARIO_nivel')
                ->distinct()->get();
        
    }

}
