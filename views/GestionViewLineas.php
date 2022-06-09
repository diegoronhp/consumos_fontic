<?php
//error_reporting(E_ALL);
error_reporting(0);

require '../model/bd/configs.php';
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');
require '../controller/GestionController.php';
require '../views/envio_correos.php';

if((isset($_FILES["nombre_archivo"]))&&(isset($_POST["tipo_insercion"]))){
    //echo "DETECTO EL EVENTO POST DEL FORMULARIO EN EL QUE SE IMPORTA EL ARCHIVO DE GESTION DE LINEAS"."<br>";
    $nombre_archivo = $_FILES["nombre_archivo"]["name"];
    $nombre_temporal = $_FILES["nombre_archivo"]["tmp_name"];
    $tipo_insercion = $_POST["tipo_insercion"];
    $dir_raiz = RAIZ;
    $dir_lineas_nuevas = $dir_raiz.'importados_lineas_nuevas/';
    $dir_lineas_inactivas = $dir_raiz.'importados_lineas_inactivas/';
    $dir_lineas_reactivas = $dir_raiz.'importados_lineas_reactivas/';
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "nombre_temporal = ".$nombre_temporal."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    //echo "dir_raiz = ".$dir_raiz."<br>";
    //echo "dir_lineas_nuevas = ".$dir_lineas_nuevas."<br>";
    //echo "dir_lineas_inactivas = ".$dir_lineas_inactivas."<br>";
    //echo "ANTES DE LA INTERRUPCION"."<br>";
    //sleep(5);
    //echo "DESPUES DE LA INTERRUPCION"."<br>";

    $allowedFileType = ['application/vnd.ms-excel', 'text/csv', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (in_array($_FILES["nombre_archivo"]["type"], $allowedFileType)){
        //echo "EL ARCHIVO **SI** CUMPLE CON LA EXTENSION REQUERIDA"."<br>";
        //echo "EL ARCHIVO VA A SER INSERTADO POR PRIMERA VEZ? "."<br>";
        $existe = buscar_nombre_archivo_gestion($nombre_archivo);

        if($existe == false){
            //echo "EL ARCHIVO **NO** EXISTE EN LA BD, ENTONCES SE PUEDEN INSERTAR LOS REGISTROS NUEVOS"."<br>";
            $insertado = insertar_nombre_archivo_gestion_lineas($nombre_archivo,$tipo_insercion);

            if($insertado){
                //echo "EL NUEVO ARCHIVO **SI** FUE INSERTADO EN LA BD"."<br>";
                $mensaje = "El archivo (".$nombre_archivo.") ha sido importado con exito. Las estadisticas de la importacion de este archivo son las siguientes: ";

                //SE VAN A AGREGAR NUEVAS LINEAS CON EL ARCHIVO IMPORTADO
                if($tipo_insercion == 0){
                    $ruta_archivo = $dir_lineas_nuevas.$nombre_archivo;
                    $movido = move_uploaded_file($nombre_temporal, $ruta_archivo);
                    //echo "EL ARCHIVO HA SIDO MOVIDO AL DIRECTORIO DE LINEAS NUEVAS ? ";
                    //echo $movido == true ? "TRUE"."<br>":"FALSE"."<br>";
                    $respuestas = gestionar_lineas_registradas($dir_lineas_nuevas,$nombre_archivo,$tipo_insercion);
                    $mensaje_notificacion = $mensaje.$respuestas[1];
                    $mensaje .= $respuestas[0];
                    enviar_correo_usuario($mensaje_notificacion);
                }

                //SE VAN A DESACTIVAR LINEAS EXISTENTES CON EL ARCHIVO IMPORTADO
                if($tipo_insercion == 1){
                    $ruta_archivo = $dir_lineas_inactivas.$nombre_archivo;
                    $movido = move_uploaded_file($nombre_temporal, $ruta_archivo);
                    //echo "EL ARCHIVO HA SIDO MOVIDO AL DIRECTORIO DE LINEAS INACTIVAS ? ";
                    //echo $movido == true ? "TRUE"."<br>":"FALSE"."<br>";
                    $respuestas = gestionar_lineas_registradas($dir_lineas_inactivas,$nombre_archivo,$tipo_insercion);
                    $mensaje_notificacion = $mensaje.$respuestas[1];
                    $mensaje .= $respuestas[0];
                    enviar_correo_usuario($mensaje_notificacion);
                }

                //SE VAN A REACTIVAR LINEAS EXISTENTES CON EL ARCHIVO IMPORTADO
                if($tipo_insercion == 2){
                    $ruta_archivo = $dir_lineas_reactivas.$nombre_archivo;
                    $movido = move_uploaded_file($nombre_temporal, $ruta_archivo);
                    //echo "EL ARCHIVO HA SIDO MOVIDO AL DIRECTORIO DE LINEAS REACTIVAS ? ";
                    //echo $movido == true ? "TRUE"."<br>":"FALSE"."<br>";
                    $respuestas = gestionar_lineas_registradas($dir_lineas_reactivas,$nombre_archivo,$tipo_insercion);
                    $mensaje_notificacion = $mensaje.$respuestas[1];
                    $mensaje .= $respuestas[0];
                    enviar_correo_usuario($mensaje_notificacion);
                }

            }else{
                //echo "EL NUEVO ARCHIVO **NO** FUE INSERTADO EN LA BD";
                $mensaje = "El archivo (".$nombre_archivo.") no pudo ser insertado en la base de datos, por favor intente de nuevo";
            }
        }else{
            //echo "EL ARCHIVO **SI** EXISTE EN LA BD Y POR LO TANTO YA FUERON GESTIONADOS SUS REGISTROS, ENTONCES DEBO NOTIFICAR EL ERROR AL USUARIO"."<br>";
            $mensaje = "El archivo (".$nombre_archivo.") ya existe en la base de datos, por favor realice la importacion de un archivo nuevo";
        }


    }else{
        //echo "EL ARCHIVO **NO** CUMPLE CON LA EXTENSION REQUERIDA"."<br>";
        $mensaje = "El archivo (".$nombre_archivo.") no tiene extension .csv, por favor realice la importacion con un archivo valido";
    }

    $respuesta = array("mensaje"=>$mensaje);
    echo json_encode($respuesta);
}


?>