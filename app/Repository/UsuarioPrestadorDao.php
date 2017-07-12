<?php

namespace App\Repository;

use App\UsuarioPrestador;

class UsuarioPrestadorDao {
    /**
     *
     * @var \App\UsuarioPrestador
     */
    private $model;
    
    public function __construct(UsuarioPrestador $up) {
        $this->model = $up;
    }
    
    public function buscar($nome = "", $login = "", $email = "", $status = 1){
        $result = $this->model
                ->join('usuario', 'usuario.USUARIO_id', '=', 'usuarioprestador.USUARIO_PREST_idUsuario')
                ->join('prestador', 'prestador.PRESTADOR_id', '=', 'usuarioprestador.USUARIO_PREST_idPrestador')
                ->join('perfil', 'perfil.PERFIL_id', '=', 'usuario.USUARIO_PERFIL_id')
                        ;
        if($nome != "")
            $result->Where('USUARIO_nome', 'like', "%". $nome . "%");
        
        if($login != "")
            $result->Where('USUARIO_login', 'like',"%". $login . "%");
        
        if($email != "")
            $result->Where('USUARIO_email', 'like',"%". $email . "%");
        
        if($status != "")
            $result->Where('USUARIO_status', '=', $status);
        
            $result->orderBy("USUARIO_nome");
                        //echo $result->toSql();
        return $result->select('*')
                ->distinct()->paginate(40);
    }
    
    public function total($nome = "", $login = "", $email = ""){
        $result = $this->model
                ->join('usuario', 'usuario.USUARIO_id', '=', 'usuarioprestador.USUARIO_PREST_idUsuario')
                ->join('prestador', 'prestador.PRESTADOR_id', '=', 'usuarioprestador.USUARIO_PREST_idPrestador')
                ->join('perfil', 'perfil.PERFIL_id', '=', 'usuario.USUARIO_PERFIL_id')
                        
                        ;
        if($nome != "")
            $result->Where('USUARIO_nome', 'like', "%".$nome . "%");
        
        if($login != "")
            $result->Where('USUARIO_login', 'like',"%". $login . "%");
        
        if($email != "")
            $result->Where('USUARIO_email', 'like',"%". $email . "%");
                        
            $result->orderBy("USUARIO_nome");
                
                        
        return $result->select('USUARIO_PREST_id')->get()->count();
    }
    
    public function buscarEmailPorIdEmpresa($idprestador, $nivel){
        /*$sql = "select USUARIO_email, USUARIO_PREST_idPrestador, USUARIO_nivel from usuarioprestador up 
                inner join usuario u on u.USUARIO_id = up.USUARIO_PREST_id 
        where EMPRESA_id = " . $idempresa . " and USUARIO_nivel <= " . $nivel;*/
        
        $result = $this->model
                ->join('usuario', 'usuarioprestador.USUARIO_PREST_id', '=', 'usuario.USUARIO_id')
                
                        ;
            $result->Where('USUARIO_PREST_idPrestador', '=', $idprestador);
            $result->Where('USUARIO_nivel', '<=', $nivel);
        
            $result->orderBy("USUARIO_email");
                        
        return $result->select('USUARIO_nome','USUARIO_email','USUARIO_login',
            'USUARIO_nivel')
                ->distinct()->get();
        
    }
    
    public function buscarEmailPorIdPrestador($idprestador, $nivel = 0){
        
        $result = $this->model
                ->join('usuario', 'usuarioprestador.USUARIO_PREST_idUsuario', '=', 'usuario.USUARIO_id')
                
                        ;
            $result->Where('USUARIO_PREST_idPrestador', '=', $idprestador);
            if($nivel != 0)
                $result->Where('USUARIO_nivel', '<=', $nivel);
        
            $result->orderBy("USUARIO_email");
                        
        return $result->select('USUARIO_nome','USUARIO_email','USUARIO_login',
            'USUARIO_nivel')
                ->distinct()->get();
        
    }
    
    public function buscarId($id){
        
        $result = $this->model
                ->join('usuario', 'usuarioprestador.USUARIO_PREST_idUsuario', '=', 'usuario.USUARIO_id')
                ->join('perfil', 'usuario.USUARIO_PERFIL_id', '=', 'perfil.PERFIL_id')
                
                        ;
            /*$result->Where('USUARIO_login', '=', $login);
                $result->Where('password', '=', $senha);
                $result->Where('USUARIO_status', '=', 1);*/
            $result->Where('USUARIO_id', '=', $id)
        
            ;
            //            echo $result->toSql();
        return $result->select('*')->first();
        
    }
}
