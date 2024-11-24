<?php

include_once "../modelo/productoModelo.php";

class ProductoControlador{
    public $idProducto; 

    public function ctrListarProductos(){
        $objRespuesta = ProductoModelo::mdlListarProductos();
        echo json_encode($objRespuesta);
    }

    public function ctrCargarProducto(){
        $objRespuesta = ProductoModelo::mdlCargarProducto($this->idProducto);
        echo json_encode($objRespuesta);
    }
}

if (isset($_POST["listarProductos"]) == "ok"){
    $objProductos = new ProductoControlador();
    $objProductos->ctrListarProductos();
}