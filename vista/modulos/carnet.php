<?php
require "../../vendor/autoload.php";
require "../../modelo/usuarioModelo.php";

use Dompdf\Dompdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

if (isset($_GET["user"])){
    $objUsuario = UsuarioModelo::mdlCargarUsuario($_GET["user"]);
    if ($objUsuario["codigo"] == "200"){
        $nombre = $objUsuario["Usuario"]["nombres"]." ".$objUsuario["Usuario"]["apellidos"];
        $documento = $objUsuario["Usuario"]["documento"];
        $urlFoto = $objUsuario["Usuario"]["url_foto"];
        $email = $objUsuario["Usuario"]["email"];
        $telefono = $objUsuario["Usuario"]["telefono"];
        $id = $objUsuario["Usuario"]["idusuario"];

        $writer = new PngWriter();

        // Create QR code
        $qrCode = new QrCode(
            data: $nombre.",".$email.",".$id.",".$email.",".$telefono,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 180,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        // Create generic logo
        // $logo = new Logo(
        //     path: __DIR__.'/qr.png',
        //     resizeToWidth: 50,
        //     punchoutBackground: true
        // );

        // Create generic label
        $label = new Label(
            text: 'Label',
            textColor: new Color(255, 0, 0)
        );

        $result = $writer->write($qrCode);

        // Directly output the QR code
        header('Content-Type: '.$result->getMimeType());

        // Save it to a file
        $result->saveToFile(__DIR__.'/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        // $dataUri = $result->getDataUri();

    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet</title>
    <style>
        /* Estilos para el carnet */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .carnet {
            width: 300px;
            height: 500px;
            border: 1px solid #ccc;
            padding: 15px;
            /* margin: 0px auto; */
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        
        .carnet .foto {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            float: left;
            margin-right: 20px;
        }
        
        .carnet .datos {
            float: left;
            width: calc(100% - 120px);
        }
        
        .carnet .datos h3 {
            margin-top: 40px;
        }
        
        .carnet .datos p {
            margin-bottom: 10px;
        }

        .mc-panel{
            margin-top: 150px;
        }

        .mc-qr{
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="carnet">
        <img class="foto" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/adsoqr/<?php echo $urlFoto;?>" alt="Foto del titular">
        <div class="datos">
            <h3><?php echo $nombre;?></h3>
            <hr>
        </div>
        
        <div class="mc-panel">
            <p>Documento: <?php echo $documento;?></p>
            <p>Teléfono: <?php echo $telefono;?></p>
            <p>Email: <?php echo $email;?></p>
        </div>

        <div class="mc-qr">
            <img class="" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/adsoqr/vista/modulos/qrcode.png" alt="Foto del titular">
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
$dompdf->setPaper(array(0,0,300,468),'portrait');

$html = ob_get_clean();

$dompdf->loadHtml($html);

// Representar el HTML como PDF 
$dompdf->render();

// Enviar el PDF generado al navegador 
$dompdf->stream('archivo.pdf',array("Attachment" => false));




// https://www.youtube.com/watch?v=PvI3nbffuqk&ab_channel=Develoteca-OscarUh
// composer require stymiee/php-simple-encryption  