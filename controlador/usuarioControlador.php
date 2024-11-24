<?php

include_once "../modelo/usuarioModelo.php";

class UsuarioControlador{
    public $idUsuario; 

    public function ctrListarUsuarios(){
        $objRespuesta = UsuarioModelo::mdlListarUsuarios();
        echo json_encode($objRespuesta);
    }

    public function ctrCargarUsuario(){
        $objRespuesta = UsuarioModelo::mdlCargarUsuario($this->idUsuario);
        echo json_encode($objRespuesta);
    }
}

if (isset($_POST["listarUsuarios"]) == "ok"){
    $objUsuarios = new UsuarioControlador();
    $objUsuarios->ctrListarUsuarios();
}


