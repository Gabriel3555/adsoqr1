<?php
require "../../vendor/autoload.php";
require "../../modelo/productoModelo.php";

use Dompdf\Dompdf;

if (isset($_GET["producto"])){
    $objProducto = ProductoModelo::mdlCargarProducto($_GET["producto"]);

    if ($objProducto["codigo"] == "200"){
        $descripcion = $objProducto["Producto"]["descripcion"];
        $urlFoto = $objProducto["Producto"]["url_foto"];
        $precio = $objProducto["Producto"]["precio"];
        $stock = $objProducto["Producto"]["stock"];
        $id = $objProducto["Producto"]["idproducto"];

        $color = [6,6,6];

        //crea el codigo de barras 
        $barcode = (new Picqer\Barcode\Types\TypeCode128())->getBarcode($id."-".$precio);

        //Genera render que se comvierte en png con la informacion de el codigo de barras
        $render = new Picqer\Barcode\Renderers\PngRenderer();

        // Se modifica el color de el codigo de barras en formato rbg
        $render->setForegroundColor($color);

        //Guardar el codigo de barras en la carpeta activa
        file_put_contents('barcode.png', $render->render($barcode, $barcode->getWidth() * 1, 50));

    }
}  

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>codigo</title>
    <style>
        /* Estilos para el carnet */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .panel {
            width: 200px;
            height: 100px;
            text-align: center;
            align-items: center;
            border: 1px solid #000;
            padding: 15px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .mc-panel{
            margin-top: 0px;
            align-items: center;
        }

    </style>
</head>
<body>
    <div class="panel">

        <div>
            <!-- Imagen del producto -->
            <img src="" alt="imagenProducto">
        </div> 

        <div class="mc-qr">
            <img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/adsoqr1/vista/modulos/barcode.png" class="" alt="codigoBarras">
        </div>

        <div class="mc-panel">
            <p><?php echo $descripcion;?></p>
        </div>
    </div>
</body>
</html>



<?php

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

// (Opcional) Configure el tamaño y la orientación del papel 
// $dompdf->setPaper( 'A4' , 'landscape' );
$dompdf->setPaper(array(0,0,270,169),'portrait');

$html = ob_get_clean();

$dompdf->loadHtml($html);

// Representar el HTML como PDF 
$dompdf->render();

// Enviar el PDF generado al navegador 
$dompdf->stream('archivo.pdf',array("Attachment" => false));






















// composer require picqer/php-barcode-generator
// https://packagist.org/packages/picqer/php-barcode-generator 






















// composer require picqer/php-barcode-generator
// https://packagist.org/packages/picqer/php-barcode-generator