<?php
//error_reporting(E_ALL);
error_reporting(0);

require '../model/bd/configs.php';
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');
require '../controller/ConsumoController.php';
require '../views/envio_correos.php';

if((isset($_FILES["nombre_archivo"]))&&(isset($_POST["tipo_insercion"]))){
    //echo "DETECTO EL EVENTO POST DEL FORMULARIO EN EL QUE SE IMPORTA EL ARCHIVO DE CONSUMO"."<br>";
    $nombre_archivo = $_FILES["nombre_archivo"]["name"];
    $nombre_temporal = $_FILES["nombre_archivo"]["tmp_name"];
    $tipo_insercion = $_POST["tipo_insercion"];
    $dir_raiz = RAIZ;
    //$targetPath = 'C:/wamp64/www/consumos_fontic/importados_claro/';
    $targetPath = $dir_raiz."importados_claro/";
    //$targetPath_Rectif = 'C:/wamp64/www/consumos_fontic/importados_claro_rectif/';
    $targetPath_Rectif = $dir_raiz."importados_claro_rectif/";
    //$extension = ".csv";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "nombre_temporal = ".$nombre_temporal."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    //echo "dir_raiz = ".$dir_raiz."<br>";
    //echo "targetPath = ".$targetPath."<br>";
    //echo "targetPath_Rectif = ".$targetPath_Rectif."<br>";

    /*COMPROBACION DE LA EXTENSION DEL ARCHIVO IMPORTADO CON LA LIBRERIA*/
    $allowedFileType = ['application/vnd.ms-excel', 'text/csv', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (in_array($_FILES["nombre_archivo"]["type"], $allowedFileType)){
        //echo "EL ARCHIVO **SI** CUMPLE CON LA EXTENSION REQUERIDA"."<br>";

        //SI EL CONTENIDO DEL ARCHIVO VA A SER INSERTADO POR PRIMERA VEZ
        if($tipo_insercion == 0){
            //echo "EL ARCHIVO VA A SER INSERTADO POR PRIMERA VEZ"."<br>";
            $existe = buscar_nombre_archivo_consumo_claro($nombre_archivo);

            if($existe == false){
                //echo "EL ARCHIVO **NO** EXISTE EN LA BD, ENTONCES SE PUEDEN INSERTAR LOS REGISTROS NUEVOS"."<br>";
                $insertado = insertar_nombre_archivo_consumo_claro($nombre_archivo,$tipo_insercion);

                if($insertado){
                    //echo "EL NUEVO ARCHIVO **SI** FUE INSERTADO EN LA BD"."<br>";
                    $mensaje = "El archivo (".$nombre_archivo.") ha sido importado con exito y será procesado en los próximos minutos, después usted recibirá en su cuenta de correo el resultado del análisis del archivo importado";
                    $ruta_archivo = $targetPath.$nombre_archivo;
                    //echo "ruta_archivo = ".$ruta_archivo."<br>";
                    $mensaje_email = "<span>El archivo (".$nombre_archivo.") ha sido importado con &eacute;xito y ser&aacute; procesado en los pr&oacute;ximos minutos, despu&eacute;s usted recibir&aacute en su cuenta de correo el resultado del an&aacute;lisis del archivo importado</span>";
                    $movido = move_uploaded_file($nombre_temporal, $ruta_archivo);
                    //echo "EL ARCHIVO HA SIDO MOVIDO ?";
                    //echo $movido == true ? "TRUE"."<br>":"FALSE"."<br>";
                    enviar_correo_usuario($mensaje_email);
                }else{
                    //echo "EL NUEVO ARCHIVO **NO** FUE INSERTADO EN LA BD"."<br>";
                    $mensaje = "El archivo (".$nombre_archivo.") no pudo ser insertado en la base de datos, por favor intente de nuevo";
                }
            }else{
                //echo "EL ARCHIVO **SI** EXISTE EN LA BD Y POR LO TANTO YA FUERON INSERTADOS REGISTROS, ENTONCES DEBO NOTIFICAR EL ERROR AL USUARIO"."<br>";
                $mensaje = "El archivo (".$nombre_archivo.") ya existe en la base de datos, por favor realice la importacion de un archivo nuevo";
            }
        }

        //SI EL CONTENIDO DEL ARCHIVO VA A SER RECTIFICADO DESPUES DE HABER SIDO INERTADO PREVIAMENTE
        if($tipo_insercion == 1){
            //echo "EL ARCHIVO VA A SER RECTIFICADO DESPUES DE SU INSERCION PREVIA"."<br>";
            $existe = buscar_nombre_archivo_consumo_claro_rectificar($nombre_archivo);
            if($existe[0] == false){
                //echo "EL ARCHIVO **NO** EXISTE EN LA BD, POR LO TANTO NO HAN SIDO INSERTADOS REGISTROS PREVIAMENTE CON ESTE ARCHIVO, ENTONCES DEBO NOTIFICAR EL ERROR AL USUARIO"."<br>";
                $mensaje = "El archivo (".$nombre_archivo.") debe existir en la base de datos para poder rectificar los registros previamente cargados";
            }else{
                //echo "EL ARCHIVO **SI** EXISTE EN LA BD, POR LO TANTO PUEDO ELIMINAR LOS REGISTROS INSERTADOS PREVIAMENTE CON EL MISMO ARCHIVO"."<br>";
                $tipo_consumo = $existe[1];
                //echo "LOS REGISTROS POR ELIMINAR ESTAN EN LA TABLA DE CONSUMOS DE ";
                //echo $tipo_consumo == 0 ? "DATOS"."<br>":"VOZ"."<br>";
                $ruta_archivo = $targetPath_Rectif.$nombre_archivo;
                $movido = move_uploaded_file($nombre_temporal, $ruta_archivo);
                //echo "EL ARCHIVO HA SIDO MOVIDO ? ";
                //echo $movido == true ? "TRUE"."<br>":"FALSE"."<br>";
                $coincidentes = comprobar_tipo_consumo_archivo_por_rectificar($ruta_archivo,$tipo_consumo);

                if($coincidentes == true){
                    //echo "EL CONTENIDO DEL ARCHIVO POR RECTIFICAR ES COINCIDENTE CON EL ARCHIVO PREVIAMENTE IMPORTADO QUE VA A SER RECTIFICADO, DADO QUE AMBOS ARCHIVOS CONTIENEN CONSUMOS DE ";
                    //echo $tipo_consumo == 0 ? "DATOS"."<br>":"VOZ"."<br>";
                    $insertado = insertar_nombre_archivo_consumo_claro_rectificado($nombre_archivo,$tipo_insercion,$tipo_consumo);

                    if($insertado){
                        //echo "EL ARCHIVO RECTIFICADO **SI** FUE INSERTADO EN LA BD"."<br>";
                        $mensaje = "El archivo (".$nombre_archivo.") ha sido importado con exito para su rectificación y será procesado en los próximos minutos, después usted recibirá en su cuenta de correo el resultado del análisis del archivo importado";
                        $mensaje_email = "<span>El archivo (".$nombre_archivo.") ha sido importado con &eacute;xito para su rectificaci&oacute;n y ser&aacute; procesado en los pr&oacute;ximos minutos, despu&eacute;s usted recibir&aacute en su cuenta de correo el resultado del an&aacute;lisis del archivo importado</span>";
                        enviar_correo_usuario($mensaje_email);
                    }else{
                        //echo "EL ARCHIVO RECTIFICADO **NO** FUE INSERTADO EN LA BD"."<br>";
                        $mensaje = "El archivo (".$nombre_archivo.") no pudo ser insertado en la base de datos, por favor intente de nuevo";
                    }
                }else{
                    //echo "EL CONTENIDO DEL ARCHIVO RECTIFICADO **NO** CONTIENE REGISTROS DE CONSUMO DE ";
                    //echo $tipo_consumo == 0 ? "DATOS ":"VOZ ";
                    //echo " QUE SEAN COINCIDENTES CON LOS DE SU IMPORTACION PREVIA"."<br>";
                    $mensaje .= "El archivo (".$nombre_archivo.") debe almacenar en su contenido consumos de ";
                    $mensaje .= $tipo_consumo == 0 ? "datos":"voz";
                    $mensaje .= " para su rectificacion";
                    //modificar_extension_archivo($nombre_archivo,$targetPath_Rectif);
                    unlink($ruta_archivo);
                }
            }
        }
    }else{
        //echo "EL ARCHIVO **NO** CUMPLE CON LA EXTENSION REQUERIDA"."<br>";
        $mensaje = "El archivo (".$nombre_archivo.") no tiene extension .csv, por favor realice la importacion con un archivo valido";
    }

    $respuesta = array("mensaje"=>$mensaje);
    echo json_encode($respuesta);
}








?>