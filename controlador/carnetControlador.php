<?php

require "../vendor/autoload.php";



use Dompdf\Dompdf;

class CarnetControlador
{
    public $id;
    public $nombres;
    public $email;
    public $urlFoto;
    public $telefono;

    public function ctrCrearCarnet()
    {
        // referencia al espacio de nombres Dompdf 
        // instanciar y utilizar la clase dompdf 
        $mensaje = array("codigo" => "200", "mensaje" => "ok");
        try {
            $dompdf = new Dompdf();


            $options = $dompdf->getOptions();
            $options->set(array('isRemoteEnabled' => true));
            $dompdf->setOptions($options);

            // (Opcional) Configure el tamaño y la orientación del papel 
            $dompdf->setPaper('A4', 'landscape');

            $ruta = "http://" . $_SERVER['HTTP_HOST'] . "/adsoqr/archivos/1052391445/foto.png";

            $dompdf->loadHtml('<img src="' . $ruta . '" style="width: 200px;">');


            // Representar el HTML como PDF 
            $dompdf->render();

            // Enviar el PDF generado al navegador 
            $dompdf->stream('archivo.pdf', array("Attachment" => false));
        } catch (Exception $e) {
            $mensaje = array("codigo" => "401", "mensaje" => $e->getMessage());
        }

        echo json_encode($mensaje);
    }


    public function ctrCrearQr() {}
}


if (isset($_POST["crearCarnet"]) == "ok") {
    $objCarnet = new CarnetControlador();
    $objCarnet->ctrCrearCarnet();
}
