<?php
include_once "conexion.php";

class UsuarioModelo{

    public static function mdlListarUsuarios(){
        $mensaje = array();
        try {
            $objRespuesta = Conexion::conectar()->prepare("SELECT * FROM usuario");
            $objRespuesta->execute();
            $listaUsuarios = $objRespuesta->fetchAll();
            $mensaje = array("codigo"=>"200","listaUsuarios"=>$listaUsuarios);
            $objRespuesta = null;
        } catch (Exception $e) {
            $mensaje = array("codigo"=>"401","mensaje"=>$e->getMessage());
        }
        return $mensaje;
    }

    public static function mdlCargarUsuario($idUsuario){
        $mensaje = array();
        try {
            $objRespuesta = Conexion::conectar()->prepare("SELECT * FROM usuario WHERE idusuario=:idusuario");
            $objRespuesta->bindParam(":idusuario",$idUsuario);
            $objRespuesta->execute();
            $Usuario = $objRespuesta->fetch();
            $mensaje = array("codigo"=>"200","Usuario"=>$Usuario);
            $objRespuesta = null;
        } catch (Exception $e) {
            $mensaje = array("codigo"=>"401","mensaje"=>$e->getMessage());
        }
        return $mensaje;
    }

}