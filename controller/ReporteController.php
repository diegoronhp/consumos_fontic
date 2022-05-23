<?php

//error_reporting(E_ALL);
error_reporting(0);

require '../model/Reporte.class.php';
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');
//require '../controller/configs.php'; //Archivo con configuraciones.
//require '../views/View.php'; //Archivo con configuraciones.

function obtener_registros_consumos_periodo($fecha_desde,$fecha_hasta){

}



function consulta_reporte_consumos_periodo($desde,$hasta){
    //echo "ENTRE AL METODO consulta_reporte_consumos_periodo"."<br>";
    //echo "RECIBO LAS VARIABLES: "."<br>";
    //echo "DESDE = ".$desde."<br>";
    //echo "HASTA = ".$hasta."<br>";
    // Header para crear archivo EXCEL
    //header("Content-Type: application/vnd.ms-excel");
    //header("Expires: 0");
    //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("content-disposition: attachment;filename=Reporte_consumos:periodo.xls"); //aca cambio la cabecera

    //echo "LLEGUE AL DESTINO..";
    //carga la plantilla
    //set_time_limit(0);
    //ob_start();
    //include $config->get('contenido') . 'plantilla_reporte_consumos.php';
    //$pagina = ob_get_clean();
    //$Vista = new View();
    //$resultado = $Vista->view_page($pagina);
    //return $resultado;
}

?>