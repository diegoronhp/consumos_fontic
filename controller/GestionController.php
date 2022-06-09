<?php
//error_reporting(E_ALL);
error_reporting(0);

require '../model/Gestion.class.php';
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');


function buscar_nombre_archivo_gestion($nombre_archivo){
    //echo "ENTRO AL METODO buscar_nombre_archivo_gestion"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    $gestion = new Gestion();
    $existe = false;
    $query = "SELECT id_archivo_gestion FROM archivos_gestion WHERE nombre_archivo LIKE '".$nombre_archivo."%'";
    //echo "query = ".$query."<br>";
    $resultado = $gestion->consultar($query);
    $num_rows = $resultado == true ? $gestion->contar_filas($query) : 0;

    if($num_rows > 0){
        $existe = true;
    }
    //echo "EXISTE ARCHIVO ".$nombre_archivo.": ";
    //echo $existe == true ? "TRUE"."<br>": "FALSE"."<br>";
    return $existe;
}

function insertar_nombre_archivo_gestion_lineas($nombre_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO insertar_nombre_archivo_gestion_lineas"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");
    $gestion = new Gestion();
    $insertado = false;
    $query = "INSERT INTO archivos_gestion(nombre_archivo,fecha_cargue,fecha_procesamiento,tipo_insercion) VALUES('".$nombre_archivo."','".$fecha_actual."',null,".$tipo_insercion.")";
    //echo "query = ".$query."<br>";
    $resultado = $gestion->insertar($query);
    if($resultado){
        $insertado = true;
    }
    return $insertado;
}

function consultar_datos_archivo_gestion($nombre_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO consultar_datos_archivo_gestion"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    $existe = false;
    $id_archivo_gestion = 0;
    $gestion = new Gestion();
    $query = "SELECT id_archivo_gestion FROM archivos_gestion WHERE nombre_archivo LIKE '".$nombre_archivo."%' AND tipo_insercion = '".$tipo_insercion."'";
    //echo "query = ".$query."<br>";
    $resultado = $gestion->consultar_campos($query);
    $num_rows = $resultado == true ? $gestion->contar_filas($query) : 0;

    if($num_rows > 0){
        $existe = true;
        $id_archivo_gestion = $resultado['id_archivo_gestion'];
    }
    //echo "EXISTE REGISTRO EN LA BD PARA EL ARCHIVO = ".$nombre_archivo.": ";
    //echo $existe == true ? "TRUE"."<br>": "FALSE"."<br>";
    //echo "id_archivo_gestion = ".$id_archivo_gestion."<br>";

    return $id_archivo_gestion;
}

function gestionar_lineas_registradas($dir_destino,$nombre_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO gestionar_lineas_registradas"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "dir_destino = ".$dir_destino."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    $mensajes = "";
    $id_archivo = consultar_datos_archivo_gestion($nombre_archivo,$tipo_insercion);

    if($id_archivo > 0){
        $ruta_archivo = $dir_destino.$nombre_archivo;
        $mensajes = analizar_contenido_archivo_gestion($ruta_archivo,$id_archivo,$tipo_insercion);
    }
    return $mensajes;
}


function validar_numero_linea($numero){
    //echo "ENTRO AL METODO validar_numero_linea"."<br>";
    $cumple = false;
    $estado = "";
    $query = "SELECT estado FROM lineas_registradas WHERE numero_linea = '".$numero."'";
    //echo "query = ".$query."<br>";
    $gestion = new Gestion();
    $resultado = $gestion->consultar_campos($query);
    $num_rows = $resultado == true ? $gestion->contar_filas($query) : 0;

    if($num_rows > 0){
        $estado = $resultado['estado'];
        $cumple = $estado == 1 ? true : false;
    }
    //echo "estado = ".$estado."<br>";
    return $cumple;
}


function consultar_id_operador($operador){
    //echo "ENTRO AL METODO consultar_id_operador"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "operador = ".$operador."<br>";
    $id_operador = 0;
    $query = "SELECT id_operador FROM operadores WHERE nombre_operador LIKE '%".$operador."%'";
    //echo "query = ".$query."<br>";
    $gestion = new Gestion();
    $resultado = $gestion->consultar_campos($query);
    $num_rows = $resultado == true ? $gestion->contar_filas($query) : 0;

    if($num_rows > 0){
        $id_operador = $resultado['id_operador'];
    }
    //echo "id_operador = ".$id_operador."<br>";
    return $id_operador;
}



function agregar_nueva_linea($numero_linea,$operador){
    //echo "ENTRO AL METODO agregar_nueva_linea"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "numero_linea = ".$numero_linea."<br>";
    //echo "operador = ".$operador."<br>";
    $insertada = false;
    $gestion = new Gestion();
    $id_operador = consultar_id_operador($operador);
    $estado = 1;
    if($id_operador > 0){
        $query = "INSERT INTO lineas_registradas(numero_linea,estado,id_operador) VALUES(".$numero_linea.",".$estado.",".$id_operador.")";
        //echo "query = ".$query."<br>";
        $resultado = $gestion->insertar($query);

        if($resultado){
            $insertada = true;
        }
    }

    //echo "INSERTADA ? ";
    //echo $insertada == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $insertada;
}


function desactivar_linea_existente($numero_linea,$operador){
    //echo "ENTRO AL METODO desactivar_linea_existente"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "numero_linea = ".$numero_linea."<br>";
    //echo "operador = ".$operador."<br>";
    $desactivada = false;
    $gestion = new Gestion();
    $nvo_estado = 0;
    $id_operador = consultar_id_operador($operador);

    if($id_operador > 0){
        $query = "UPDATE lineas_registradas SET estado = ".$nvo_estado." WHERE numero_linea = ".$numero_linea." AND id_operador = ".$id_operador."";
        //echo "query = ".$query."<br>";
        $resultado = $gestion->actualizar($query);

        if($resultado){
            $desactivada = true;
        }
    }

    //echo "DESACTIVADA ? ";
    //echo $desactivada == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $desactivada;
}


function reactivar_linea_existente($numero_linea,$operador){
    //echo "ENTRO AL METODO reactivar_linea_existente"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "numero_linea = ".$numero_linea."<br>";
    //echo "operador = ".$operador."<br>";
    $reactivada = false;
    $gestion = new Gestion();
    $nvo_estado = 1;
    $id_operador = consultar_id_operador($operador);

    if($id_operador > 0){
        $query = "UPDATE lineas_registradas SET estado = ".$nvo_estado." WHERE numero_linea = ".$numero_linea." AND id_operador = ".$id_operador."";
        //echo "query = ".$query."<br>";
        $resultado = $gestion->actualizar($query);

        if($resultado){
            $reactivada = true;
        }
    }

    //echo "REACTIVADA ? ";
    //echo $reactivada == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $reactivada;
}


function ordernar_lineas($lineas){
    $lim = count($lineas);
    $cadena = "(";
    for($i=0;$i<$lim;$i++){
        $cadena .= $lineas[$i];
        if($i == ($lim - 1)){
            $cadena .= ")";
        }else{
            $cadena .= " - ";
        }
    }
    return $cadena;
}


function actualizar_registro_archivo_gestion($id_archivo,$analizados,$insertados,$desactivados,$reactivados,$rechazados){
    //echo "ENTRO AL METODO actualizar_registro_archivo_gestion"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    //echo "analizados = ".$analizados."<br>";
    //echo "insertados = ".$insertados."<br>";
    //echo "desactivados = ".$desactivados."<br>";
    //echo "reactivados = ".$reactivados."<br>";
    //echo "rechazados = ".$rechazados."<br>";
    $actualizado = false;
    $gestion = new Gestion();
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");

    $query = "UPDATE archivos_gestion SET fecha_procesamiento = '".$fecha_actual."', cantidad_analizados = ".$analizados.", cantidad_insertados = ".$insertados.", cantidad_desactivados = ".$desactivados.", cantidad_reactivados = ".$reactivados.", cantidad_rechazados = ".$rechazados." WHERE id_archivo_gestion = ".$id_archivo."";
    //echo "query = ".$query."<br>";
    $resultado = $gestion->actualizar($query);

    if($resultado){
        $actualizado = true;
    }

    //echo "ACTUALIZADO ? ";
    //echo $actualizado == true ? "TRUE"."<br>":"FALSE"."<br>";
}


function eliminar_registro_archivo_gestion($id_archivo,$ruta_archivo){
    //echo "ENTRO AL METODO eliminar_registro_archivo_gestion"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    //echo "ruta_archivo = ".$ruta_archivo."<br>";
    $eliminado = false;
    $eliminada_ruta = false;
    $gestion = new Gestion();
    $query = "DELETE FROM archivos_gestion WHERE id_archivo_gestion = '".$id_archivo."'";
    //echo "query = ".$query."<br>";
    $resultado = $gestion->eliminar($query);

    if($resultado){
        $eliminado = true;
    }

    //echo "ELIMINADO ? ";
    //echo $eliminado == true ? "TRUE"."<br>":"FALSE"."<br>";

    $ruta_eliminada = unlink($ruta_archivo);
    //echo "ELIMINADA RUTA ? ";
    //echo $eliminada_ruta == true ? "TRUE"."<br>":"FALSE"."<br>";
}


function analizar_contenido_archivo_gestion($ruta_archivo,$id_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO analizar_contenido_archivo_gestion"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "ruta_archivo = ".$ruta_archivo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    $mensaje = "";
    $mensaje_notificacion = "";
    $num_reg = 0;
    $cant_insertados = 0;
    $cant_desactivados = 0;
    $cant_reactivados = 0;
    $cant_rechazados = 0;
    $insertados = array();
    $desactivados = array();
    $reactivados = array();
    $rechazados = array();
    $gestion = new Gestion();
    $conexion = $gestion->get_conection();
    $Reader = new SpreadsheetReader($ruta_archivo);
    $sheetCount = count($Reader->sheets());

    //echo "COMIENZO A LEER EL CONTENIDO DEL ARCHIVO:"."<br>";
    for ($i = 0; $i < $sheetCount; $i++){
        //echo "ESTOY EN LA ITERACION = ".$i."<br>";
        $Reader->ChangeSheet($i);
        foreach ($Reader as $Row){
            $num_linea = "";
            $operador = "";

            if (isset($Row[0])) {
                $num_linea = mysqli_real_escape_string($conexion, $Row[0]);
                //echo "Registro = ".$num_reg." => num_linea = ".$num_linea."<br>";
            }

            if (isset($Row[1])) {
                $operador = mysqli_real_escape_string($conexion, $Row[1]);
                //echo "Registro = ".$num_reg." => num_linea = ".$operador."<br>";
            }

            if($num_reg == 1){
                $col_1 = mysqli_real_escape_string($conexion, $Row[0]);
                if($col_1 == ""){
                    $mensaje = " El archivo importado se encuentra vacio";
                    break;
                }
            }

            if(($num_linea == "numero_linea")||($operador == "operador")){
                $num_reg++;
                continue;
            }

            if(($num_linea != "")||($operador != "")){
                //echo "ENCONTRE UN REGISTRO COMPLETO EN LA FILA = ".$num_reg."<br>";

                //CON EL ARCHIVO IMPORTADO SE VAN A AGREGAR LINEAS NUEVAS
                if($tipo_insercion == 0){
                    //echo "SE PROCEDE A AGREGAR LA LINEA = ".$num_linea." DEL OPERADOR = ".$operador." EN LA BD"."<br>";
                    $insertada = agregar_nueva_linea($num_linea,$operador);
                    if($insertada){
                        //echo "HA SIDO AGREGADA LA LINEA = ".$num_linea."<br>";
                        array_push($insertados,$num_linea);
                        $cant_insertados++;
                        //echo "cant_insertados = ".$cant_insertados."<br>";
                    }else{
                        //echo "HA SIDO RECHAZADA LA LINEA = ".$num_linea." ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS"."<br>";
                        array_push($rechazados,$num_linea);
                        $cant_rechazados++;
                        //echo "cant_rechazados = ".$cant_rechazados."<br>";
                    }
                }

                //CON EL ARCHIVO IMPORTADO SE VAN A DESACTIVAR LINEAS EXISTENTES
                if($tipo_insercion == 1){
                    $linea_valida = validar_numero_linea($num_linea);
                    if($linea_valida == true){
                        //echo "LA LINEA ".$num_linea." SE ENCUENTRA **ACTIVA**, ENTONCES PROCEDO A DESACTIVARLA"."<br>";
                        $desactivada = desactivar_linea_existente($num_linea,$operador);
                        if($desactivada){
                            //echo "HA SIDO DESACTIVADA LA LINEA = ".$num_linea."<br>";
                            array_push($desactivados,$num_linea);
                            $cant_desactivados++;
                            //echo "cant_desactivados = ".$cant_desactivados."<br>";
                        }else{
                            //echo "HA SIDO RECHAZADA LA LINEA = ".$num_linea." ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS"."<br>";
                            array_push($rechazados,$num_linea);
                            $cant_rechazados++;
                            //echo "cant_rechazados = ".$cant_rechazados."<br>";
                        }
                    }else{
                        //echo "LA LINEA ".$num_linea." NO EXISTE EN LA BD O SE ENCUENTRA **INACTIVA**, ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS"."<br>";
                        array_push($rechazados,$num_linea);
                        $cant_rechazados++;
                        //echo "cant_rechazados = ".$cant_rechazados."<br>";
                    }
                }

                //CON EL ARCHIVO IMPORTADO SE VAN A REACTIVAR LINEAS EXISTENTES
                if($tipo_insercion == 2){
                    $linea_valida = validar_numero_linea($num_linea);
                    if($linea_valida == false){
                        //echo "LA LINEA ".$num_linea." SE ENCUENTRA **INACTIVA**, ENTONCES PROCEDO A REACTIVARLA"."<br>";
                        $reactivada = reactivar_linea_existente($num_linea,$operador);
                        if($reactivada){
                            //echo "HA SIDO REACTIVADA LA LINEA = ".$num_linea."<br>";
                            array_push($reactivados,$num_linea);
                            $cant_reactivados++;
                            //echo "cant_reactivados = ".$cant_reactivados."<br>";
                        }else{
                            //echo "HA SIDO RECHAZADA LA LINEA = ".$num_linea." ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS"."<br>";
                            array_push($rechazados,$num_linea);
                            $cant_rechazados++;
                            //echo "cant_rechazados = ".$cant_rechazados."<br>";
                        }
                    }else{
                        //echo "LA LINEA ".$num_linea." NO EXISTE EN LA BD O SE ENCUENTRA **ACTIVA**, ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS"."<br>";
                        array_push($rechazados,$num_linea);
                        $cant_rechazados++;
                        //echo "cant_rechazados = ".$cant_rechazados."<br>";
                    }
                }
            }else{
                break;
            }
            $num_reg++;
        }

        $mensaje .= " Han sido analizados ".($num_reg - 1)." registros en el contenido del archivo.";
        $mensaje_notificacion .= $mensaje;

        if($cant_insertados > 0){
            $mensaje .= " Han sido insertados ".$cant_insertados." registros de nuevas lineas.";
            $mensaje_notificacion .= " Han sido insertados ".$cant_insertados." registros de nuevas lineas. Los numeros de las lineas son los siguientes: "."<br>";
            $mensaje_notificacion .= ordernar_lineas($insertados);
        }

        if($cant_desactivados > 0){
            $mensaje .= " Han sido desactivados ".$cant_desactivados." registros de lineas existentes.";
            $mensaje_notificacion .= " Han sido desactivados ".$cant_desactivados." registros de lineas existentes. Los numeros de las lineas son los siguientes: "."<br>";
            $mensaje_notificacion .= ordernar_lineas($desactivados)."<br>";
        }

        if($cant_reactivados > 0){
            $mensaje .= " Han sido reactivados ".$cant_reactivados." registros de lineas existentes.";
            $mensaje_notificacion .= " Han sido reactivados ".$cant_reactivados." registros de lineas existentes. Los numeros de las lineas son los siguientes: "."<br>";
            $mensaje_notificacion .= ordernar_lineas($desactivados)."<br>";
        }

        if($cant_rechazados){
            $mensaje .= " Han sido rechazados ".$cant_rechazados." registros para su gestion. Por favor asegurese que estos datos en el archivo sean consistentes para importarlos de nuevo.";
            $mensaje_notificacion .= " Han sido rechazados ".$cant_rechazados." registros para su gestion. Por favor asegurese que estos datos en el archivo sean consistentes para importarlos de nuevo. Los numeros de las lineas son los siguientes: ";
            $mensaje_notificacion .= ordernar_lineas($rechazados)."<br>";
        }

        $mensaje .= " Todos los numeros de linea que fueron gestionados estan relacionados en el correo de notificacion";

    }

    if(($cant_insertados > 0)||($cant_desactivados > 0)||($cant_reactivados > 0)){
        //ACTUALIZAR EL REGISTRO EN LA BD CON LAS ESTADISTICAS OBTENIDAS DURANTE EL ANALISIS DEL ARCHIVO
        $num_reg = $num_reg - 1;
        actualizar_registro_archivo_gestion($id_archivo,$num_reg,$cant_insertados,$cant_desactivados,$cant_reactivados,$cant_rechazados);
    }else{
        //ELIMINAR EL ARCHIVO DE LA BD Y DE LA CARPETA EN DONDE QUEDO ALMACENADO
        eliminar_registro_archivo_gestion($id_archivo,$ruta_archivo);
    }

    $respuestas = array($mensaje,$mensaje_notificacion);
    return $respuestas;
}


?>