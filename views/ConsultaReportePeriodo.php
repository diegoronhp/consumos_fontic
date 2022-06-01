<?php
ob_start();
error_reporting(E_ALL);
//error_reporting(0);
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require '../model/bd/configs.php';
require_once "../vendor/autoload.php";
require '../controller/ReporteController.php';
if((isset($_POST["fecha_desde"]))&&(isset($_POST["fecha_hasta"]))){
    $fecha_desde = $_POST["fecha_desde"];
    $fecha_hasta = $_POST["fecha_hasta"];
    $dir_raiz = RAIZ;
    //echo "ANTES DE LA INTERRUPCION"."<br>";
    sleep(5);
    //echo "DESPUES DE LA INTERRUPCION"."<br>";
    $documento = new Spreadsheet();
    $documento->getProperties()->setCreator("Fontic")->setLastModifiedBy('Fontic')->setTitle('Reporte Consumos lineas Fontic')->setSubject('Reporte Consumos')->setDescription('Reporte Consumos lineas Fontic');
    $Consumos = $documento->getActiveSheet();
    $Consumos->setTitle("Consumos");
    $objeto = generarEncabezadosArchivo($fecha_desde,$fecha_hasta);
    $encabezado = $objeto[0];
    $rangos_fechas = $objeto[1];
    $resultado = consultarLineasConsumosRangoFechas($fecha_desde,$fecha_hasta);
    $writer = new Xlsx($documento);
    $Consumos->fromArray($encabezado, null, 'A1');
    $Consumos = escribirConsumosDocumento($resultado,$Consumos,$rangos_fechas,$fecha_desde,$fecha_hasta);
    //$ruta = "C:/wamp64/www/consumos_fontic/importados_claro";
    $ruta = $dir_raiz."importados_claro";
    $file = "Reporte_consumos_periodo.xlsx";
    $ruta_completa = $ruta."/".$file;
    //echo "ruta_completa = ".$ruta_completa."<br>";
    //file_put_contents($ruta.'/depuracion.txt', ob_get_contents());
    $writer->save($ruta_completa);
    $mensaje = "Ha sido generado el reporte de consumos para el rango de fechas comprendido entre (".$fecha_desde.") y (".$fecha_hasta.")";
    $respuesta = array("mensaje"=>$mensaje);
    echo json_encode($respuesta);

    /*porcion de codigo que permite la descraga del archivo de excel*/
    /*
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename=\"Reporte_consumos_periodo.xlsx\"');
    header('Cache-Control: max-age=0');
    ob_end_clean();
    $writer->save('php://output');
    */
}
?>