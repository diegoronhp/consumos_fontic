<?php 
error_reporting(E_ALL);

require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');
require '../controller/ConsumoController.php';


if((isset($_POST["nombre_archivo"]))&&(isset($_POST["tipo_insercion"]))){

	//echo "ANTES DE LA INTERRUPCION"."<br>";
	sleep(5);
	//echo "DESPUES DE LA INTERRUPCION"."<br>";

    //echo "DETECTO EL EVENTO POST DEL FORMULARIO EN EL QUE SE IMPORTA EL ARCHIVO DE CONSUMO"."<br>";
    $nombre_archivo = $_POST["nombre_archivo"];
    $tipo_insercion = $_POST["tipo_insercion"];
    //echo "nombre_archivo_2 = ".$nombre_archivo_2."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    $arr = explode("\\",$nombre_archivo);
    $nombre_archivo = $arr[count($arr)-1];
    //echo "solo_nombre = ".$nombre_archivo."<br>";
    $extension = ".csv";
    $tipo_archivo = 0; //ARCHIVO PLATAFORMA
    $pos = strpos($nombre_archivo,$extension);

    if($pos === false){
    	//echo "EL ARCHIVO **NO** CUMPLE CON LA EXTENSION REQUERIDA"."<br>";
    	$mensaje = "El archivo (".$nombre_archivo.") no tiene extension .csv, por favor realice la importacion con un archivo valido";
    }else{
    	//echo "EL ARCHIVO **SI** CUMPLE CON LA EXTENSION REQUERIDA"."<br>";
    	$tabla_bd = "archivos_tigo";
        $targetPath = 'importados_tigo/';

        //SI EL CONTENIDO DEL ARCHIVO VA A SER INSERTADO POR PRIMERA VEZ
        if($tipo_insercion == 0){
        	//echo "EL ARCHIVO VA A SER INSERTADO POR PRIMERA VEZ"."<br>";
        	$existe = buscar_nombre_archivo_consumo($nombre_archivo,$tabla_bd);

        	if($existe == false){
        		//echo "EL ARCHIVO **NO** EXISTE EN LA BD, ENTONCES SE PUEDEN INSERTAR LOS REGISTROS NUEVOS"."<br>";
        		$insertado = insertar_nombre_archivo_consumo_tigo($nombre_archivo,$tipo_archivo,$tipo_insercion);

        		if($insertado){
                    //echo "ELNUEVO ARCHIVO **SI** FUE INSERTADO EN LA BD";
                    $mensaje = "El archivo (".$nombre_archivo.") ha sido importado con exito";
                    $ruta_archivo = $targetPath.$nombre_archivo;
                    //move_uploaded_file($_FILES['file']['tmp_name'], $ruta_archivo);
        		}else{
        			//echo "EL NUEVO ARCHIVO **NO** FUE INSERTADO EN LA BD";
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
        	$existe = buscar_nombre_archivo_consumo_rectificar($nombre_archivo,$tabla_bd,$tipo_archivo);
        	if($existe[0] == false){
                //echo "EL ARCHIVO **NO** EXISTE EN LA BD, POR LO TANTO NO HAN SIDO INSERTADOS REGISTROS PREVIAMENTE CON ESTE ARCHIVO, ENTONCES DEBO NOTIFICAR EL ERROR AL USUARIO"."<br>";
                $mensaje = "El archivo (".$nombre_archivo.") debe existir en la base de datos para poder rectificar los registros previamente cargados";
        	}else{
        		//echo "EL ARCHIVO **SI** EXISTE EN LA BD, POR LO TANTO PUEDO ELIMINAR LOS REGISTROS INSERTADOS PREVIAMENTE CON EL MISMO ARCHIVO"."<br>";
                $id_ini = $existe[1];
                $id_fin = $existe[2];
                //echo "LOS REGISTROS POR ELIMINAR EN LA TABLA DE CONSUMOS ESTAN EN EL RANGO desde = ".$id_ini." / hasta = ".$id_fin."<br>";
                /*EN ESTE PUNTO SE DEBE IMPLMENTAR UN METO EXCLUSIVO QUE PERMITA ELIMINAR LOS REGISTROS DEL RANGO EN LA RESPECTIVA TABLA DE LA BD*/
                $insertado = insertar_nombre_archivo_consumo_tigo($nombre_archivo,$tipo_archivo,$tipo_insercion);

                if($insertado){
                    //echo "EL ARCHIVO RECTIFICADO **SI** FUE INSERTADO EN LA BD";
                    $mensaje = "El archivo (".$nombre_archivo.") ha sido importado con exito para su rectificacion";
                    $ruta_archivo = $targetPath.$nombre_archivo;
                    //move_uploaded_file($_FILES['file']['tmp_name'], $ruta_archivo);
                }else{
                	//echo "EL ARCHIVO RECTIFICADO **NO** FUE INSERTADO EN LA BD";
                	$mensaje = "El archivo (".$nombre_archivo.") no pudo ser insertado en la base de datos, por favor intente de nuevo";
                }
        	}
        }
    }	


    $respuesta = array("mensaje"=>$mensaje);
    echo json_encode($respuesta);
}



?>