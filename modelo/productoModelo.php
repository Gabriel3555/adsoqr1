<?php
include_once "conexion.php";

class ProductoModelo{

    public static function mdlListarProductos(){
        $mensaje = array();
        try {
            $objRespuesta = Conexion::conectar()->prepare("SELECT * FROM producto");
            $objRespuesta->execute();
            $listaProductos = $objRespuesta->fetchAll();
            $mensaje = array("codigo"=>"200","listaProductos"=>$listaProductos);
            $objRespuesta = null;
        } catch (Exception $e) {
            $mensaje = array("codigo"=>"401","mensaje"=>$e->getMessage());
        }
        return $mensaje;
    }

    public static function mdlCargarProducto($idProducto){
        $mensaje = array();
        try {
            $objRespuesta = Conexion::conectar()->prepare("SELECT * FROM producto WHERE idproducto=:idproducto");
            $objRespuesta->bindParam(":idproducto",$idProducto);
            $objRespuesta->execute();
            $Producto = $objRespuesta->fetch();
            $mensaje = array("codigo"=>"200","Producto"=>$Producto);
            $objRespuesta = null;
        } catch (Exception $e) {
            $mensaje = array("codigo"=>"401","mensaje"=>$e->getMessage());
        }
        return $mensaje;
    }

}