<?php

namespace App\Repository;

use App\MensagemUsuario;

class MensagemUsuarioDao {
    /**
     *
     * @var \App\MensagemUsuario
     */
    private $model;
    
    public function __construct(MensagemUsuario $ue) {
        $this->model = $ue;
    }
    
    public function buscarPorManifestacao($idmanifestacao = "", $ano = ""){
        //$result = \DB::connection(\App\Config::$dbname)->table("mensagemusuario")
        $result = $this->model
                ->join('manifestacao', function($join) {
                   $join->on('mensagemusuario.MANIFESTACAO_MANIF_ano', '=', 'manifestacao.MANIF_ano');
                   $join->on('mensagemusuario.MANIFESTACAO_id', '=', 'manifestacao.MANIF_id');
                })
                ->join('prestador', 'prestador.PRESTADOR_id', '=', 'mensagemusuario.SERVICOPRESTADOR_idPrestador')
                ->join('servico', 'servico.SERVICO_id', '=', 'mensagemusuario.SERVICOPRESTADOR_idServico')
                ->join('usuario', 'usuario.USUARIO_id', '=', 'mensagemusuario.MSG_USUARIO_idUsuario');
				
			$result->where("manifestacao.MANIF_id", "=", $idmanifestacao);
			$result->where("manifestacao.MANIF_ano", "=", $ano);

         //echo $result->toSql();   
        return $result->get();
    }
    
    public function buscarPorManifestacaoIdPrestador($idmanifestacao = "", $ano = "", $idprestador = ""){
        //$result = \DB::connection(\App\Config::$dbname)->table("mensagemusuario")
        $result = $this->model
                ->join('manifestacao', function($join) {
                   $join->on('mensagemusuario.MANIFESTACAO_MANIF_ano', '=', 'manifestacao.MANIF_ano');
                   $join->on('mensagemusuario.MANIFESTACAO_id', '=', 'manifestacao.MANIF_id');
                })
                ->join('prestador', 'prestador.PRESTADOR_id', '=', 'mensagemusuario.SERVICOPRESTADOR_idPrestador')
                ->join('servico', 'servico.SERVICO_id', '=', 'mensagemusuario.SERVICOPRESTADOR_idServico')
                ->join('usuario', 'usuario.USUARIO_id', '=', 'mensagemusuario.MSG_USUARIO_idUsuario');
				
        $result->where("manifestacao.MANIF_id", "=", $idmanifestacao);
        $result->where("manifestacao.MANIF_ano", "=", $ano);
        $result->where("mensagemusuario.SERVICOPRESTADOR_idPrestador", "=", $idprestador);

         //echo $result->toSql();   
        return $result->get();
    }
    
}
