<?php
//error_reporting(E_ALL);
error_reporting(0);

require '../model/bd/configs.php';
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');
require '../controller/ConsumoController.php';
require '../views/envio_correos.php';

$cant_archivos = 0;
$limite_archivos = 1;
$rectificando = false;
$dir_raiz = RAIZ;
$destino_archivo = "";
$mensaje_email = "";
$origen_nuevos = $dir_raiz.'importados_claro/';
$origen_rectif = $dir_raiz.'importados_claro_rectif/';
$lista_archivos = array();
$respuesta = array();
$total_nuevos = count(glob($origen_nuevos.'/{*.csv}',GLOB_BRACE));
$total_rectif = count(glob($origen_rectif.'/{*.csv}',GLOB_BRACE));

//echo "COMIENZA LA SELECCION DEL ARCHIVO POR PROCESAR"."<br>";
//echo "total_nuevos = ".$total_nuevos."<br>";
//echo "total_rectif = ".$total_rectif."<br>";

if(($total_nuevos > 0)&&($total_rectif == 0)){
    //echo "SE VA A PROCESAR UN ARCHIVO NUEVO"."<br>";
    $lista_archivos = ordenar_archivos_carpeta($origen_nuevos);
    $destino_archivo = $dir_raiz.'procesados_claro/';
    //echo "destino_archivo = ".$destino_archivo."<br>";
}

if(($total_nuevos == 0)&&($total_rectif > 0)){
    //echo "SE VA A PROCESAR UN ARCHIVO PARA RECTIFICAR"."<br>";
    $rectificando = true;
    $lista_archivos = ordenar_archivos_carpeta($origen_rectif);
    $destino_archivo = $dir_raiz.'procesados_claro_rectif/';
    //echo "destino_archivo = ".$destino_archivo."<br>";
}

//EN CASO DE QUE EN LAS DOS CARPETAS DE ARCHIVOS DE TIGO HAYAN ARCHIVOS, ENTONCES SE LE DA LA PRIORIDAD AL ARCHIVO NUEVO PARA SER PROCESADO
if(($total_nuevos > 0)&&($total_rectif > 0)){
    //echo "HAY ARCHIVOS EN LAS DOS CARPETAS PERO SE DA LA PRIORIDAD PARA PROCESAR EL ARCHIVO NUEVO"."<br>";
    $lista_archivos = ordenar_archivos_carpeta($origen_nuevos);
    $destino_archivo = $dir_raiz.'procesados_claro/';
    //echo "destino_archivo = ".$destino_archivo."<br>";
}


//echo "COMIENZA EL PROCESO DEL ARCHIVO SELECCIONADO"."<br>";
while($cant_archivos < $limite_archivos){
    $nombre_archivo = $lista_archivos[$cant_archivos];
    //echo "nombre_archivo = ".$nombre_archivo."<br>";

    if($rectificando){
        //echo "PROCESANDO ARCHIVO POR RECTIFICAR"."<br>";
        $tipo_insercion = 1;
        $id_inicial = "";
        $id_final = "";
        $mensaje_email = "<p>El archivo (".$nombre_archivo.") ha sido procesado y los resultados obtenidos son los siguientes: ";
        $respuesta = consultar_archivo_consumo_claro_rectificar($nombre_archivo);
        $existe = $respuesta[0];

        if($existe){
            $tipo_consumo = $respuesta[1];
            $id_inicial = $respuesta[2];
            $id_final = $respuesta[3];
            $id_archivo = $respuesta[4];
            //echo "EL ID DEL ARCHIVO DE TIGO DASHBOARD QUE VA A SER RECTIFICADO ES id_archivo = ".$id_archivo."<br>";
            //echo "LOS REGISTROS POR ELIMINAR ESTAN EN EL RANGO desde = ".$id_inicial." / hasta = ".$id_final."<br>";
            $mensaje_email .= eliminar_registros_por_rectificar_archivo_claro($id_inicial,$id_final,$tipo_consumo,$id_archivo);
            $mensaje_email .= insertar_registros_consumos_archivo_claro($origen_rectif,$nombre_archivo,$tipo_insercion);
            $mensaje_email .= "</p>";
            enviar_correo_usuario($mensaje_email);
            copy($origen_rectif.$nombre_archivo,$destino_archivo.$nombre_archivo);
            //modificar_extension_archivo($nombre_archivo,$origen_rectif);
            unlink($origen_rectif.$nombre_archivo);
        }
    }else{
        //echo "PROCESANDO ARCHIVO nuevo"."<br>";
        $tipo_insercion = 0;
        $mensaje_email = "<p>El archivo (".$nombre_archivo.") ha sido procesado y los resultados obtenidos son los siguientes: ";
        $mensaje_email .= insertar_registros_consumos_archivo_claro($origen_nuevos,$nombre_archivo,$tipo_insercion);
        $mensaje_email .= "</p>";
        enviar_correo_usuario($mensaje_email);
        copy($origen_nuevos.$nombre_archivo,$destino_archivo.$nombre_archivo);
        //modificar_extension_archivo($nombre_archivo,$origen_nuevos);
        unlink($origen_nuevos.$nombre_archivo);
    }
    $cant_archivos++;
}

?>