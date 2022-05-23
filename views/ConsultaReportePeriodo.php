<?php
error_reporting(E_ALL);
//error_reporting(0);

require_once "../composer/vendor/autoload.php";
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');
require '../controller/ReporteController.php';
require '../views/View.php'; //Archivo con configuraciones.
//echo "DESPUES DE LLAMAR A views"."<br>";

//echo "ENTRE A LA PAGINA";
if((isset($_POST["fecha_desde"]))&&(isset($_POST["fecha_hasta"]))){
    //echo "ANTES DE LA INTERRUPCION"."<br>";
    //sleep(5);
    //echo "DESPUES DE LA INTERRUPCION"."<br>";
    //$headers = "";

    // Header para crear archivo EXCEL
    //header("Content-Type: application/vnd.ms-excel");
    //header("Expires: 0");
    //header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("content-disposition: attachment;filename=Reporte_consumos_periodo.xls"); //aca cambio la cabecera
    //$headers .= 'header("Content-Type: application/vnd.ms-excel");';
    //$headers .= 'header("Expires: 0");';
    //$headers .= 'header("Cache-Control: must-revalidate, post-check=0, pre-check=0");';
    //$headers .= 'header("content-disposition: attachment;filename=Reporte_consumos:periodo.xls");';

    $fecha_desde = $_POST["fecha_desde"];
    $fecha_hasta = $_POST["fecha_hasta"];
    //consulta_reporte_consumos_periodo($fecha_desde,$fecha_hasta);
    //echo "fecha_desde = ".$fecha_desde."<br>";
    //echo "fecha_hasta = ".$fecha_hasta."<br>";

    /*ORDENADO*/
    //echo "ANTES DE IMPORTAR configs.php"."<br>";
    include 'C:/wamp64/www/consumos_fontic/controller/configs.php'; //Archivo con configuraciones.
    //echo "DESPUES DE IMPORTAR configs.php"."<br>";
    set_time_limit(0);

    //echo "ANTES DE LLAMAR EL METODO od_start()"."<br>";
    ob_start();
    //echo "DESPUES DE LLAMAR EL METODO od_start()"."<br>";

    //echo "ANTES DE LLAMAR la plantilla"."<br>";
    //include '../views/content/plantilla_reporte_consumos.php';
    include $config->get('contenido') . 'plantilla_reporte_consumos.php';
    //echo "DESPUES DE LLAMAR la plantilla Y ANTES DE LLAMAR A views"."<br>";

    //echo "ANTES DE LLAMAR EL METODO ob_get_clean()"."<br>";
    $pagina = ob_get_clean();
    //echo "DESPUES DE LLAMAR EL METODO ob_get_clean()"."<br>";

    //echo "ANTES DE INSTANCIAR EL OBJETO VIEW"."<br>";
    $Vista = new View();
    $Vista->view_page($pagina);
    //echo "DESPUES DE INSTANCIAR Y LLAMAR EL OBJETO VIEW"."<br>";

    //$mensaje = "DETECTO EL EVENTO POST DEL FORMULARIO EN EL QUE SE GENERA EL REPORTE DE CONSUMO CON EL RANGO: fecha_desde = (".$fecha_desde.") / fecha_hasta = (".$fecha_hasta.")";
    //$respuesta = array("mensaje"=>$mensaje);
    //echo $respuesta;
    //echo "ANTES DE headers"."<br>";
    //echo "<script>".$headers."</script>";
    //echo "DESPUES DE headers"."<br>";
    //echo "<script>alert('ANTES DE EJECUTAR LA PAGINA ARMADA')</script>";
    //echo "<script>window.open(".$Vista->view_page($pagina).",'_blank')</script>";
    //echo json_encode($respuesta);
}

?>