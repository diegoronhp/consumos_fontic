<?php 
//error_reporting(E_ALL);
error_reporting(0);

require '../model/Consumo.class.php';
require_once('../vendor/php-excel-reader/excel_reader2.php');
require_once('../vendor/SpreadsheetReader.php');


function buscar_nombre_archivo_consumo($nombre_archivo,$tabla_bd){
    //echo "ENTRO AL METODO buscar_nombre_archivo_consumo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tabla_bd = ".$tabla_bd."<br>";
    $consumo = new Consumo();
    $existe = false;
    $query = "SELECT id_archivo_plataforma FROM ".$tabla_bd." WHERE nombre_archivo LIKE '".$nombre_archivo."%'";
    //echo "query = ".$query."<br>";
    $resultado = $consumo->consultar($query);
    $num_rows = $consumo->contar_filas($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $existe = true;
    }
    //echo "EXISTE ARCHIVO ".$nombre_archivo.": ";
    //echo $existe == true ? "TRUE"."<br>": "FALSE"."<br>";
    return $existe;
}


function insertar_nombre_archivo_consumo_tigo($nombre_archivo,$tipo_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO insertar_nombre_archivo_consumo_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_archivo = ".$tipo_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");
    $consumo = new Consumo();
    $insertado = false;
    $query = "INSERT INTO archivos_tigo(nombre_archivo,fecha_cargue,fecha_procesamiento,tipo_archivo,tipo_insercion) VALUES('".$nombre_archivo."','".$fecha_actual."',null,".$tipo_archivo.",".$tipo_insercion.")";
    //echo "query = ".$query."<br>";
    $resultado = $consumo->insertar($query);

    if($resultado){
        $insertado = true;
    }
    return $insertado;
}


function insertar_nombre_archivo_consumo_tigo_rectificado($nombre_archivo,$tipo_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO insertar_nombre_archivo_consumo_tigo_rectificado"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_archivo = ".$tipo_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");
    $consumo = new Consumo();
    $insertado = false;

    $query = "SELECT id_archivo_plataforma FROM archivos_tigo WHERE nombre_archivo LIKE '".$nombre_archivo."' and tipo_insercion = 1 ORDER BY fecha_cargue DESC LIMIT 1";
    //echo "CON ESTE QUERY CONSULTO EN LA TABLA archivos_tigo DE LA BD SI ESTE ARCHIVO HABIA SIDO RECTIFICADO PREVIAMENTE query = ".$query."<br>";
    $resultado = $consumo->consultar_campos($query);
    $num_rows = $consumo->contar_filas($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        //echo "ESTE ARCHIVO **SI** HABIA SIDO RECTIFICADO PREVIAMENTE, POR LO QUE NO ES NECESARIO INSERTAR UN NUEVO REGISTRO"."<br>";
        $insertado = true;
        $id_archivo_plataforma = $resultado['id_archivo_plataforma'];
        //echo "POR LO TANTO SERA ACTUALIZADO EL REGISTRO CON id_archivo_plataforma = ".$id_archivo_plataforma." EN LA TABLA archivos_tigo"."<br>";
    }else{
        //echo "ESTE ARCHIVO **NO** HA SIDO RECTIFICADO PREVIAMENTE, POR LO QUE PROCEDO A INSERTAR UN NUEVO REGISTRO EN LA TABLA DE LA BD archivos_tigo"."<br>";
        $query = "INSERT INTO archivos_tigo(nombre_archivo,fecha_cargue,fecha_procesamiento,tipo_archivo,tipo_insercion) VALUES('".$nombre_archivo."','".$fecha_actual."',null,".$tipo_archivo.",".$tipo_insercion.")";
        //echo "query = ".$query."<br>";
        $resultado = $consumo->insertar($query);

        if($resultado){
            $insertado = true;
        }
    }

    return $insertado;
}

function insertar_nombre_archivo_consumo_claro($nombre_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO insertar_nombre_archivo_consumo_claro"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");
    $consumo = new Consumo();
    $insertado = false;
    $query = "INSERT INTO archivos_claro(nombre_archivo,tipo_consumo,fecha_cargue,fecha_procesamiento,tipo_insercion) VALUES('".$nombre_archivo."',null,'".$fecha_actual."',null,".$tipo_insercion.")";
    //echo "query = ".$query."<br>";
    $resultado = $consumo->insertar($query);

    if($resultado){
        $insertado = true;
    }
    return $insertado;
}

function buscar_nombre_archivo_consumo_tigo_rectificar($nombre_archivo,$tipo_archivo){
    //echo "ENTRO AL METODO buscar_nombre_archivo_consumo_tigo_rectificar"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_archivo = ".$tipo_archivo."<br>";
    $consumo = new Consumo();
    $existe = false;
    $id_inicial_datos = "";
    $id_final_datos = "";
    $id_inicial_voz = "";
    $id_final_voz = "";
    $id_archivo = "";

    $query = "SELECT id_archivo_plataforma,id_inicial_voz, id_final_voz, id_inicial_datos, id_final_datos FROM archivos_tigo WHERE nombre_archivo LIKE '".$nombre_archivo."%' AND tipo_archivo = '".$tipo_archivo."' ORDER BY fecha_cargue DESC LIMIT 1";
    //echo "query = ".$query."<br>";
    $resultado = $consumo->consultar_campos($query);
    $num_rows = $consumo->contar_filas($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $existe = true;
        $id_inicial_datos = $resultado['id_inicial_datos'];
        $id_final_datos = $resultado['id_final_datos'];
        $id_inicial_voz = $resultado['id_inicial_voz'];
        $id_final_voz = $resultado['id_final_voz'];
        $id_archivo = $resultado['id_archivo_plataforma'];
    }
    //echo "EXISTE ARCHIVO ".$nombre_archivo.": ";
    //echo $existe == true ? "TRUE"."<br>": "FALSE"."<br>";
    //echo "id_inicial_datos = ".$id_inicial_datos."<br>";
    //echo "id_final_datos = ".$id_final_datos."<br>";
    //echo "id_inicial_voz = ".$id_inicial_voz."<br>";
    //echo "id_final_voz = ".$id_final_voz."<br>";
    $respuesta = array($existe,$id_inicial_datos,$id_final_datos,$id_inicial_voz,$id_final_voz,$id_archivo);
    return $respuesta;
}

function buscar_nombre_archivo_consumo_claro_rectificar($nombre_archivo,$tabla_bd){
    //echo "ENTRO AL METODO buscar_nombre_archivo_consumo_claro_rectificar"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tabla_bd = ".$tabla_bd."<br>";
    $consumo = new Consumo();
    $existe = false;
    $id_inicial = "";
    $id_final = "";

    $query = "SELECT id_inicial, id_final FROM ".$tabla_bd." WHERE nombre_archivo LIKE '".$nombre_archivo."%' ORDER BY fecha_cargue DESC LIMIT 1";
    //echo "query = ".$query."<br>";
    $resultado = $consumo->consultar_campos($query);
    //$num_rows = $consumo->contar_filas($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $existe = true;
        $id_inicial = $resultado['id_inicial'];
        $id_final = $resultado['id_final'];
    }
    //echo "EXISTE ARCHIVO ".$nombre_archivo.": ";
    //echo $existe == true ? "TRUE"."<br>": "FALSE"."<br>";
    //echo "id_inicial = ".$id_inicial."<br>";
    //echo "id_final = ".$id_final."<br>";
    $respuesta = array($existe,$id_inicial,$id_final);
    return $respuesta;
}


function consultar_datos_archivo_consumo_tigo($nombre_archivo,$tipo_insercion,$obj_consumo){
    //echo "ENTRO AL METODO consultar_datos_archivo_consumo_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    $id_archivo_plataforma = 0;
    $tipo_archivo = 0;
    //$tipo_insercion = 0;
    $existe = false;
    $query = "SELECT id_archivo_plataforma FROM archivos_tigo WHERE nombre_archivo like '".$nombre_archivo."%' AND tipo_archivo = '".$tipo_archivo."' AND tipo_insercion = '".$tipo_insercion."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $existe = true;
        $id_archivo_plataforma = $resultado['id_archivo_plataforma'];
    }
    //echo "EXISTE REGISTRO EN LA BD PARA EL ARCHIVO = ".$nombre_archivo.": ";
    //echo $existe == true ? "TRUE"."<br>": "FALSE"."<br>";
    //echo "id_archivo_plataforma = ".$id_archivo_plataforma."<br>";
    return $id_archivo_plataforma;
}


function validar_convertir_formato_fecha($cadena_fecha){
    //echo "ENTRO AL METODO validar_convertir_formato_fecha"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "cadena_fecha = ".$cadena_fecha."<br>";
    $fecha = "";
    $formato = "Y-m-d";
    $cadena = explode("/",$cadena_fecha);
    $valida = checkdate($cadena[1],$cadena[0],$cadena[2]);

    if($valida === true){
        $cadena = $cadena[2]."-".$cadena[1]."-".$cadena[0];
        //echo "cadena = ".$cadena."<br>";
        $fecha = date($cadena);
    }
    //echo "fecha_convertida = ".$fecha."<br>";
    $respuesta = array($valida,$fecha);
    return $respuesta;
}


function validar_numero_linea($numero,$obj_consumo){
    //echo "ENTRO AL METODO validar_numero_linea"."<br>";
    $cumple = false;
    $estado = "";
    $query = "SELECT estado FROM lineas_registradas WHERE numero_linea = '".$numero."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $estado = $resultado['estado'];
        $cumple = $estado == 1 ? true : false;
    }
    //echo "estado = ".$estado."<br>";
    return $cumple;
}



function comprobar_formato_numero_decimal($numero){
    //echo "ENTRO AL METODO comprobar_formato_numero_decimal"."<br>";
    //echo "RECIBO EL NUMERO: ".$numero."<br>";
    $convertido = 0.0;
    $pos = strpos($numero,",");
    //echo "El numero tiene coma (,)? "."<br>";
    //echo $pos == true ? "TRUE"."<br>":"FALSE"."<br>";

    if($pos === false){
        $pos = stripos($numero,"e");
        //echo "El numero tiene exp (E)? "."<br>";
        //echo $pos == true ? "TRUE"."<br>":"FALSE"."<br>";
        if($pos === false){
            $convertido = doubleval($numero);
        }else{
            $convertido = rtrim(number_format($numero,20),0);
            //echo "convertido (sin exponencial) = ".$convertido."<br>";
            $convertido = doubleval($convertido);
        }
    }else{
        $convertido = str_replace(",",".",$numero);
        //echo "convertido (sin coma) = ".$convertido."<br>";
        $pos = stripos($convertido,"e");
        //echo "El numero tiene exp (E)? "."<br>";
        //echo $pos == true ? "TRUE"."<br>":"FALSE"."<br>";

        if($pos === false){
            $convertido = doubleval($convertido);
        }else{
            $convertido = rtrim(number_format($convertido,20),0);
            //echo "convertido (sin exponencial) = ".$convertido."<br>";
            $convertido = doubleval($convertido);
        }
    }

    //echo "convertido = ".$convertido."<br>";
    return $convertido;
}


function convertir_consumo_voz_tigo($consumo){
    //echo "ENTRO AL METODO validar_convertir_consumo_voz_tigo"."<br>";
    //echo "RECIBO LAS VARIABLES: "."<br>";
    //echo "consumo = ".$consumo."<br>";
    $nvo_consumo = 0.0;
    $conversion = comprobar_formato_numero_decimal($consumo);
    //echo "conversion = ".$conversion."<br>";
    if($conversion > 0.0){
        $nvo_consumo = $conversion;
    }
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    return $nvo_consumo;
}


function convertir_consumo_datos_tigo($consumo){
    //echo "ENTRO AL METODO convertir_consumo_datos_tigo"."<br>";
    //echo "RECIBO LAS VARIABLES: "."<br>";
    //echo "consumo = ".$consumo."<br>";
    $nvo_consumo = 0.0;
    $factor = 1024;
    $conversion = intval($consumo);
    //echo "conversion = ".$conversion."<br>";

    if($conversion > 0){
        $nvo_consumo = doubleval($conversion / $factor);
    }
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    return $nvo_consumo;
}


function validar_consumo_datos_tigo($consumo_1,$consumo_2){
    //echo "ENTRO AL METODO validar_consumo_datos_tigo"."<br>";
    //echo "RECIBO LAS VARIABLES: "."<br>";
    //echo "consumo_1 = ".$consumo_1."<br>";
    //echo "consumo_2 = ".$consumo_2."<br>";

    $consumo_total = 0.0;
    if(($consumo_1 > 0.0)&&($consumo_2 == 0.0)){
        $consumo_total = $consumo_1;
    }
    if(($consumo_1 == 0.0)&&($consumo_2 > 0.0)){
        $consumo_total = $consumo_2;
    }
    if(($consumo_1 > 0.0)&&($consumo_2 > 0.0)){
        $consumo_total = $consumo_1 + $consumo_2;
        $consumo_total = doubleval($consumo_total);
    }
    if(($consumo_1 == 0.0)&&($consumo_2 == 0.0)){
        $consumo_total = 0.0;
    }
    //echo "consumo_total = ".$consumo_total."<br>";
    return $consumo_total;
}

function actualizar_consumo_datos($id,$nvo_consumo,$obj_consumo){
    //echo "ENTRO AL METODO actualizar_consumo_datos"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "id = ".$id."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    $actualizado = false;
    $query = "UPDATE consumos_datos SET cantidad_consumo = '".$nvo_consumo."' WHERE id_consumo = '".$id."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->actualizar($query);

    //if($resultado){
    //    $actualizado = true;
    //}

    //echo "ACTUALIZADO? ";
    //echo $actualizado == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $actualizado;
}

function insertar_consumo_datos($numero,$fecha,$nvo_consumo,$id_archivo,$obj_consumo){
    //echo "ENTRO AL METODO insertar_consumo_datos"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $insertado = false;
    $query = "INSERT INTO consumos_datos(cantidad_consumo,fecha_consumo,numero_linea,id_archivo_claro,id_archivo_tigo_dash) VALUES('".$nvo_consumo."','".$fecha."',".$numero.",0,'".$id_archivo."')";
    //echo "query = ".$query;

    $resultado = $obj_consumo->insertar($query);

    if($resultado){
        $insertado = true;
    }

    //echo "INSERTADO? ";
    //echo $insertado == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $insertado;
}

function actualizar_consumo_voz($id,$nvo_consumo,$obj_consumo){
    //echo "ENTRO AL METODO actualizar_consumo_voz"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "id = ".$id."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    $actualizado = false;
    $query = "UPDATE consumos_voz SET cantidad_consumo = '".$nvo_consumo."' WHERE id_consumo = '".$id."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->actualizar($query);

    //if($resultado){
    //    $actualizado = true;
    //}

    //echo "ACTUALIZADO? ";
    //echo $actualizado == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $actualizado;
}


function insertar_consumo_voz($numero,$fecha,$nvo_consumo,$id_archivo,$obj_consumo){
    //echo "ENTRO AL METODO insertar_consumo_voz"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $insertado = false;
    $query = "INSERT INTO consumos_voz(cantidad_consumo,fecha_consumo,numero_linea,id_archivo_tigo_dash) VALUES(".$nvo_consumo.",'".$fecha."','".$numero."','".$id_archivo."')";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->insertar($query);

    if($resultado){
        $insertado = true;
    }

    //echo "INSERTADO? ";
    //echo $insertado == true ? "TRUE"."<br>":"FALSE"."<br>";

    return $insertado;
}


function registrar_consumo_datos_linea_tigo($numero,$fecha,$consumo_datos,$id_archivo,$obj_consumo){
    //echo "ENTRO AL METODO registrar_consumo_datos_linea_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "consumo_datos = ".$consumo_datos."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $registrado_consumo = false;
    $query = "SELECT id_consumo, cantidad_consumo FROM consumos_datos WHERE numero_linea = '".$numero."' AND fecha_consumo = '".$fecha."' AND id_archivo_tigo_dash = '".$id_archivo."' ORDER BY id_consumo DESC LIMIT 1";
    //echo "CON ESTE QUERY COMPRUEBO SI HAY UN REGISTRO PREVIO DE CONSUMO DE DATOS DENTRO DE ESTE ARCHIVO PARA ESTA LINEA EN LA MISMA FECHA"."<br>";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        //echo "**SI** HAY UN REGISTRO PREVIO DE CONSUMO DE DATOS PARA ESTA LINEA EN ESTA FECHA EN EL CONTENIDO DE ESTE ARCHIVO, POR LO TANTO DEBO ACTUALIZAR ESE REGISTRO DE CONSUMO CON EL NUEVO CONSUMO CALCULADO"."<br>";
        $id_consumo = $resultado['id_consumo'];
        $old_consumo = $resultado['cantidad_consumo'];
        $nvo_consumo = doubleval($old_consumo + $consumo_datos);
        //echo "LOS DATOS DEL REGISTRO ENCONTRADO SON: "."<br>";
        //echo "id_consumo = ".$id_consumo."<br>";
        //echo "old_consumo = ".$old_consumo."<br>";
        //echo "LUEGO HAGO LA SUMATORIA DE LOS DOS CONSUMOS DE DATOS Y OBTENGO EL RESULTADO: "."";
        //echo "nvo_consumo = ".$nvo_consumo."<br>";
        $registrado_consumo = actualizar_consumo_datos($id_consumo,$nvo_consumo,$obj_consumo);
    }else{
        //echo "**NO** HAY UN REGISTRO PREVIO DE CONSUMO DE DATOS PARA ESTA LINEA EN ESTA FECHA EN EL CONTENIDO DE ESTE ARCHIVO, POR LO TANTO DEBO INSERTAR UN NUEVO REGISTRO DE CONSUMO"."<br>";
        $registrado_consumo = insertar_consumo_datos($numero,$fecha,$consumo_datos,$id_archivo,$obj_consumo);
    }

    registrar_consumo_total_datos($numero,$fecha,$consumo_datos,$obj_consumo);

    return $registrado_consumo;
}


function registrar_consumo_total_datos($numero,$fecha,$consumo_datos,$obj_consumo){
    //echo "ENTRO AL METODO registrar_consumo_total_datos"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "consumo_datos = ".$consumo_datos."<br>";
    //$registrado_total = false;
    $query = "SELECT id_total_consumos, total_consumo_datos FROM total_consumos_lineas WHERE numero_linea = '".$numero."' AND fecha_consumo = '".$fecha."'";
    //echo "CON ESTE QUERY COMPRUEBO SI HAY UN REGISTRO **TOTAL** DE CONSUMO DE DATOS PARA ESTA LINEA EN ESTA FECHA"."<br>";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        //echo "**SI** HAY UN REGISTRO PREVIO DE CONSUMO **TOTAL** DE DATOS PARA ESTA LINEA EN ESTA FECHA, POR LO TANTO DEBO ACTUALIZAR ESE REGISTRO DE CONSUMO CON EL NUEVO CONSUMO CALCULADO"."<br>";
        $id_consumo_total = $resultado['id_total_consumos'];
        $old_consumo_total = $resultado['total_consumo_datos'];
        $nvo_consumo_total = doubleval($old_consumo_total + $consumo_datos);
        //echo "LOS DATOS DEL REGISTRO ENCONTRADO SON: "."<br>";
        //echo "id_consumo = ".$id_consumo_total."<br>";
        //echo "old_consumo = ".$old_consumo_total."<br>";
        //echo "LUEGO HAGO LA SUMATORIA DE LOS DOS CONSUMOS DE DATOS Y OBTENGO EL RESULTADO: "."";
        //echo "nvo_consumo = ".$nvo_consumo_total."<br>";
        actualizar_consumo_total_datos($id_consumo_total,$nvo_consumo_total,$obj_consumo);
    }else{
        //echo "**NO** HAY UN REGISTRO PREVIO DE CONSUMO **TOTAL** DE DATOS PARA ESTA LINEA EN ESTA FECHA, POR LO TANTO DEBO INSERTAR UN NUEVO REGISTRO DE CONSUMO **TOTAL**"."<br>";
        insertar_consumo_total_datos($numero,$fecha,$consumo_datos,$obj_consumo);
    }
}


function insertar_consumo_total_datos($numero,$fecha,$nvo_consumo,$obj_consumo){
    //echo "ENTRO AL METODO insertar_consumo_total_datos"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    //$insertado = false;
    $query = "INSERT INTO total_consumos_lineas(total_consumo_datos,fecha_consumo,numero_linea) VALUES('".$nvo_consumo."','".$fecha."',".$numero.")";
    //echo "query = ".$query;

    $resultado = $obj_consumo->insertar($query);

    //if($resultado){
    //    $insertado = true;
    //}

    //echo "INSERTADO? ";
    //echo $insertado == true ? "TRUE"."<br>":"FALSE"."<br>";

    //return $insertado;
}


function actualizar_consumo_total_datos($id,$nvo_consumo,$obj_consumo){
    //echo "ENTRO AL METODO actualizar_consumo_total_datos"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "id = ".$id."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    //$actualizado = false;
    $query = "UPDATE total_consumos_lineas SET total_consumo_datos = '".$nvo_consumo."' WHERE id_total_consumos = '".$id."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->actualizar($query);

    //if($resultado){
    //    $actualizado = true;
    //}

    //echo "ACTUALIZADO? ";
    //echo $actualizado == true ? "TRUE"."<br>":"FALSE"."<br>";

    //return $actualizado;
}


function registrar_consumo_voz_linea_tigo($numero,$fecha,$consumo_voz,$id_archivo,$obj_consumo){
    //echo "ENTRO AL METODO registrar_consumo_voz_linea_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "consumo_voz = ".$consumo_voz."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $registrado_consumo = false;
    $query = "SELECT id_consumo, cantidad_consumo FROM consumos_voz WHERE numero_linea = '".$numero."' AND fecha_consumo = '".$fecha."' AND id_archivo_tigo_dash = '".$id_archivo."' ORDER BY id_consumo DESC LIMIT 1";
    //echo "CON ESTE QUERY COMPRUEBO SI HAY UN REGISTRO PREVIO DE CONSUMO DE VOZ DENTRO DE ESTE ARCHIVO PARA ESTA LINEA EN LA MISMA FECHA"."<br>";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        //echo "**SI** HAY UN REGISTRO PREVIO DE CONSUMO DE VOZ PARA ESTA LINEA EN ESTA FECHA EN EL CONTENIDO DE ESTE ARCHIVO, POR LO TANTO DEBO ACTUALIZAR ESE REGISTRO DE CONSUMO CON EL NUEVO CONSUMO CALCULADO"."<br>";
        $id_consumo = $resultado['id_consumo'];
        $old_consumo = $resultado['cantidad_consumo'];
        $nvo_consumo = doubleval($old_consumo + $consumo_voz);
        //echo "LOS DATOS DEL REGISTRO ENCONTRADO SON: "."<br>";
        //echo "id_consumo = ".$id_consumo."<br>";
        //echo "old_consumo = ".$old_consumo."<br>";
        //echo "LUEGO HAGO LA SUMATORIA DE LOS DOS CONSUMOS DE VOZ Y OBTENGO EL RESULTADO: "."";
        //echo "nvo_consumo = ".$nvo_consumo."<br>";
        $registrado_consumo = actualizar_consumo_voz($id_consumo,$nvo_consumo,$obj_consumo);
    }else{
        //echo "**NO** HAY UN REGISTRO PREVIO DE CONSUMO DE VOZ PARA ESTA LINEA EN ESTA FECHA EN EL CONTENIDO DE ESTE ARCHIVO, POR LO TANTO DEBO INSERTAR UN NUEVO REGISTRO DE CONSUMO"."<br>";
        $registrado_consumo = insertar_consumo_voz($numero,$fecha,$consumo_voz,$id_archivo,$obj_consumo);
    }

    registrar_consumo_total_voz($numero,$fecha,$consumo_voz,$obj_consumo);

    return $registrado_consumo;
}


function registrar_consumo_total_voz($numero,$fecha,$consumo_voz,$obj_consumo){
    //echo "ENTRO AL METODO registrar_consumo_total_voz"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "consumo_datos = ".$consumo_voz."<br>";
    //$registrado_total = false;
    $query = "SELECT id_total_consumos, total_consumo_voz FROM total_consumos_lineas WHERE numero_linea = '".$numero."' AND fecha_consumo = '".$fecha."'";
    //echo "CON ESTE QUERY COMPRUEBO SI HAY UN REGISTRO **TOTAL** DE CONSUMO DE VOZ PARA ESTA LINEA EN ESTA FECHA"."<br>";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        //echo "**SI** HAY UN REGISTRO PREVIO DE CONSUMO **TOTAL** DE VOZ PARA ESTA LINEA EN ESTA FECHA, POR LO TANTO DEBO ACTUALIZAR ESE REGISTRO DE CONSUMO CON EL NUEVO CONSUMO CALCULADO"."<br>";
        $id_consumo_total = $resultado['id_total_consumos'];
        $old_consumo_total = $resultado['total_consumo_voz'];
        $nvo_consumo_total = doubleval($old_consumo_total + $consumo_voz);
        //echo "LOS DATOS DEL REGISTRO ENCONTRADO SON: "."<br>";
        //echo "id_consumo = ".$id_consumo_total."<br>";
        //echo "old_consumo = ".$old_consumo_total."<br>";
        //echo "LUEGO HAGO LA SUMATORIA DE LOS DOS CONSUMOS DE VOZ Y OBTENGO EL RESULTADO: "."";
        //echo "nvo_consumo = ".$nvo_consumo_total."<br>";
        actualizar_consumo_total_voz($id_consumo_total,$nvo_consumo_total,$obj_consumo);
    }else{
        //echo "**NO** HAY UN REGISTRO PREVIO DE CONSUMO **TOTAL** DE VOZ PARA ESTA LINEA EN ESTA FECHA, POR LO TANTO DEBO INSERTAR UN NUEVO REGISTRO DE CONSUMO **TOTAL**"."<br>";
        insertar_consumo_total_voz($numero,$fecha,$consumo_voz,$obj_consumo);
    }

    //return $registrado_total;
}


function insertar_consumo_total_voz($numero,$fecha,$nvo_consumo,$obj_consumo){
    //echo "ENTRO AL METODO insertar_consumo_total_voz"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "numero = ".$numero."<br>";
    //echo "fecha = ".$fecha."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    //$insertado = false;
    $query = "INSERT INTO total_consumos_lineas(total_consumo_voz,fecha_consumo,numero_linea) VALUES('".$nvo_consumo."','".$fecha."',".$numero.")";
    //echo "query = ".$query;

    $resultado = $obj_consumo->insertar($query);

    //if($resultado){
    //    $insertado = true;
    //}

    //echo "INSERTADO? ";
    //echo $insertado == true ? "TRUE"."<br>":"FALSE"."<br>";

    //return $insertado;
}


function actualizar_consumo_total_voz($id,$nvo_consumo,$obj_consumo){
    //echo "ENTRO AL METODO actualizar_consumo_total_voz"."<br>";
    //echo "RECIBO LAS VARIABLES:"."<br>";
    //echo "id = ".$id."<br>";
    //echo "nvo_consumo = ".$nvo_consumo."<br>";
    //$actualizado = false;
    $query = "UPDATE total_consumos_lineas SET total_consumo_voz = '".$nvo_consumo."' WHERE id_total_consumos = '".$id."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->actualizar($query);

    //if($resultado){
    //    $actualizado = true;
    //}

    //echo "ACTUALIZADO? ";
    //echo $actualizado == true ? "TRUE"."<br>":"FALSE"."<br>";

    //return $actualizado;
}


function ordernar_rechazados($filas){
    $lim = count($filas);
    $cadena = "(";
    for($i=0;$i<$lim;$i++){
        $cadena .= $filas[$i];
        if($i == ($lim - 1)){
            $cadena .= ")";
        }else{
            $cadena .= ",";
        }
    }
    return $cadena;
}


function analizar_contenido_archivo_tigo_dash($ruta_archivo,$id_archivo,$tipo_insercion,$obj_consumo){
    //echo "ENTRO AL METODO analizar_contenido_archivo_tigo_dash"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "ruta_archivo = ".$ruta_archivo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $mensaje = "";
    $num_reg = 0;
    $cuenta_insertados_datos = 0;
    $cuenta_insertados_voz = 0;
    $cuenta_rechazados = 0;
    $rechazados = array();
    $conexion = $obj_consumo->get_conection();
    $Reader = new SpreadsheetReader($ruta_archivo);
    $sheetCount = count($Reader->sheets());

    //echo "COMIENZO A LEER EL CONTENIDO DEL ARCHIVO:"."<br>";
    for ($i = 0; $i < $sheetCount; $i++){
        //echo "ESTOY EN LA ITERACION = ".$i."<br>";
        $Reader->ChangeSheet($i);
        foreach ($Reader as $Row){
            $num_linea = "";
            $linea_valida = false;
            $fecha_consumo = "";
            $fecha_valida = false;
            $consumo_voz = 0.0;
            $consumo_datos = 0.0;

            if (isset($Row[15])) {
                $num_linea = mysqli_real_escape_string($conexion, $Row[15]);
                //echo "Registro = ".$num_reg." => num_linea = ".$num_linea."<br>";
            }

            if (isset($Row[41])) {
                $fecha_consumo = mysqli_real_escape_string($conexion, $Row[41]);
                //echo "Registro = ".$num_reg." => fecha_consumo = ".$fecha_consumo."<br>";
            }

            if($num_linea == "MSISDN_DD"){
                $num_reg++;
                continue;
            }

            if($num_reg == 1){
                $col_1 = mysqli_real_escape_string($conexion, $Row[15]);
                $col_2 = mysqli_real_escape_string($conexion, $Row[41]);
                $col_3 = mysqli_real_escape_string($conexion, $Row[79]);
                $col_4 = mysqli_real_escape_string($conexion, $Row[80]);
                $col_5 = mysqli_real_escape_string($conexion, $Row[80]);

                if(($col_1 == "")&&($col_2 == "")&&($col_3 == "")&&($col_4 == "")&&($col_5 == "")){
                    $mensaje = " El archivo importado se encuentra vacio";
                    break;
                }
            }

            //SE VALIDA LA CONSISTENCIA DE TODOS LOS DATOS INTEGRADOS EN EL REGISTRO
            if(($num_linea != "")||($fecha_consumo != "")){
                //echo "ENCONTRE UN REGISTRO COMPLETO EN LA FILA = ".$num_reg."<br>";
                $linea_valida = validar_numero_linea($num_linea,$obj_consumo);

                if($linea_valida == true){
                    //echo "LA LINEA ".$num_linea." SE ENCUENTRA **ACTIVA**, ENTONCES PROCEDO A VERIFICAR EL FORMATO DE LA FECHA PARA CONTINUAR"."<br>";
                    if (isset($Row[41])) {
                        $fecha_consumo = mysqli_real_escape_string($conexion, $Row[41]);
                        $respuesta = validar_convertir_formato_fecha($fecha_consumo);
                        $fecha_valida = $respuesta[0];
                        $fecha_consumo = $fecha_valida == true ? $respuesta[1] : $fecha_consumo;
                        //echo "Registro = ".$num_reg." => fecha_consumo = ".$fecha_consumo."<br>";
                    }

                    if($fecha_valida == true){
                        //echo "LA FECHA ".$fecha_consumo." **SI** TIENE EL FORMATO REQUERIDO, ENTONCES PROCEDO A CALCULAR LOS CONSUMOS DE DATOS Y VOZ PARA CONTINUAR"."<br>";
                        if ((isset($Row[83]))&&(isset($Row[84])))  {
                            $consumo_datos_1 = mysqli_real_escape_string($conexion, $Row[83]);
                            $consumo_datos_2 = mysqli_real_escape_string($conexion, $Row[84]);
                            $consumo_datos_1 = convertir_consumo_datos_tigo($consumo_datos_1);
                            $consumo_datos_2 = convertir_consumo_datos_tigo($consumo_datos_2);
                            $consumo_datos = validar_consumo_datos_tigo($consumo_datos_1,$consumo_datos_2);
                            //echo "Registro = ".$num_reg." => consumo_datos = ".$consumo_datos."<br>";
                        }

                        if (isset($Row[94])) {
                            $consumo_voz = mysqli_real_escape_string($conexion, $Row[94]);
                            $consumo_voz = convertir_consumo_voz_tigo($consumo_voz);
                            //echo "Registro = ".$num_reg." => consumo_voz = ".$consumo_voz."<br>";
                        }


                        //echo "SE INSERTA EN LA BD EL REGISTRO DE CONSUMO DE **DATOS**"."<br>";
                        $consumo_datos_registrado = registrar_consumo_datos_linea_tigo($num_linea,$fecha_consumo,$consumo_datos,$id_archivo,$obj_consumo);
                        if($consumo_datos_registrado){
                           $cuenta_insertados_datos++;
                           //echo "cuenta_insertados_datos = ".$cuenta_insertados_datos."<br>";
                        }


                        //echo "SE INSERTA EN LA BD EL REGISTRO DE CONSUMO DE **VOZ**"."<br>";
                        $consumo_voz_registrado = registrar_consumo_voz_linea_tigo($num_linea,$fecha_consumo,$consumo_voz,$id_archivo,$obj_consumo);
                        if($consumo_voz_registrado){
                           $cuenta_insertados_voz++;
                            //echo "cuenta_insertados_voz = ".$cuenta_insertados_voz."<br>";
                        }

                    }else{
                        //echo "LA FECHA ".$fecha_consumo." **NO** TIENE EL FORMATO REQUERIDO, ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS = ".$cuenta_rechazados."<br>";
                        $rhz = $num_reg + 1;
                        array_push($rechazados,$rhz);
                        $cuenta_rechazados++;
                    }

                }else{
                    //echo "LA LINEA ".$num_linea." NO EXISTE EN LA BD O SE ENCUENTRA **INACTIVA**, ENTONCES PROCEDO AGREGAR EL REGISTRO DENTRO DE LOS RECHAZADOS = ".$cuenta_rechazados."<br>";
                    $rhz = $num_reg + 1;
                    array_push($rechazados,$rhz);
                    $cuenta_rechazados++;
                }

            }else{
                break;
            }
            $num_reg++;
        }
        if($tipo_insercion == 0){
            $mensaje .= " Han sido analizados ".($num_reg - 1)." registros en el contenido del archivo.";
        }else{
            $mensaje .= " Han sido analizados ".($num_reg - 1)." registros en el contenido del archivo rectificado.";
        }

        if($cuenta_insertados_datos > 0){
            $mensaje .= " Han sido insertados ".$cuenta_insertados_datos." registros de consumo de datos.";
        }
        if($cuenta_insertados_voz > 0){
            $mensaje .= " Han sido insertados ".$cuenta_insertados_voz." registros de consumo de voz.";
        }
        if($cuenta_rechazados > 0){
            $cadena_rechazados = ordernar_rechazados($rechazados);
            $mensaje .= " Han sido rechazados ".$cuenta_rechazados." registros en las siguientes filas del archivo: ".$cadena_rechazados.".";
        }
    }
    if(($cuenta_insertados_datos > 0)||($cuenta_insertados_voz > 0)){
        //ACTUALIZAR EL REGISTRO EN LA BD CON LAS ESTADISTICAS OBTENIDAS DURANTE EL ANALISIS DEL ARCHIVO
        $num_reg = $num_reg - 1;
        actualizar_registro_archivo_dash_tigo($num_reg,$cuenta_rechazados,$cuenta_insertados_datos,$cuenta_insertados_voz,$id_archivo,$obj_consumo);
    }else{
        //ELIMINAR EL ARCHIVO DE LA BD Y DE LA CARPETA EN DONDE QUEDO ALMACENADO
        eliminar_registro_archivo_tigo_dash($id_archivo,$ruta_archivo,$obj_consumo);
    }

    return $mensaje;
}


function eliminar_registro_archivo_tigo_dash($id_archivo,$ruta,$obj_consumo){
    //echo "ENTRO AL METODO eliminar_registro_archivo_dash_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $eliminado = false;
    $eliminada_ruta = false;
    $query = "DELETE FROM archivos_tigo WHERE id_archivo_plataforma = '".$id_archivo."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->eliminar($query);

    if($resultado){
        $eliminado = true;
    }

    //echo "ELIMINADO ? ";
    //echo $eliminado == true ? "TRUE"."<br>":"FALSE"."<br>";

    $eliminada_ruta = unlink($ruta);
    //echo "ELIMINADA RUTA ? ";
    //echo $eliminada_ruta == true ? "TRUE"."<br>":"FALSE"."<br>";
}


function consultar_ids_consumos_id_archivo($id_archivo,$obj_consumo,$tabla_bd){
    //echo "ENTRO AL METODO consultar_ids_archivo_consumoz_voz"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $encontrado = false;
    $respuesta = array();
    $id_inicial = 0;
    $id_final = 0;
    $query = "SELECT id_consumo FROM ".$tabla_bd." WHERE id_archivo_tigo_dash = ".$id_archivo." ORDER BY id_consumo LIMIT 1";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $id_inicial = $resultado['id_consumo'];
    }

    $query = "SELECT id_consumo FROM ".$tabla_bd." WHERE id_archivo_tigo_dash = ".$id_archivo." ORDER BY id_consumo DESC LIMIT 1";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $obj_consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $id_final = $resultado['id_consumo'];
    }

    if(($id_inicial > 0)&&($id_final > 0)){
        $encontrado = true;
    }

    //echo "id_inicial = ".$id_inicial."<br>";
    //echo "id_final = ".$id_final."<br>";
    array_push($respuesta,$encontrado,$id_inicial,$id_final);
    return $respuesta;
}


function actualizar_registro_archivo_dash_tigo($cant_analizados,$cant_rechazados,$cant_insertados_datos,$cant_insertados_voz,$id_archivo,$obj_consumo){
    //echo "ENTRO AL METODO actualizar_registro_archivo_dash_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "cant_analizados = ".$cant_analizados."<br>";
    //echo "cant_rechazados = ".$cant_rechazados."<br>";
    //echo "cant_insertados_datos = ".$cant_insertados_datos."<br>";
    //echo "cant_insertados_voz = ".$cant_insertados_voz."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $actualizado = false;
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");
    $id_inicial_voz = 0;
    $id_final_voz = 0;
    $id_inicial_datos = 0;
    $id_final_datos = 0;
    $tabla_bd = "consumos_voz";
    $ids_consumos_voz = consultar_ids_consumos_id_archivo($id_archivo,$obj_consumo,$tabla_bd);

    if($ids_consumos_voz[0] == true){
        $id_inicial_voz = $ids_consumos_voz[1];
        $id_final_voz = $ids_consumos_voz[2];
        //echo "id_inicial_voz = ".$id_inicial_voz."<br>";
        //echo "id_final_voz = ".$id_final_voz."<br>";
    }

    $tabla_bd = "consumos_datos";
    $ids_consumos_datos = consultar_ids_consumos_id_archivo($id_archivo,$obj_consumo,$tabla_bd);

    if($ids_consumos_datos[0] == true){
        $id_inicial_datos = $ids_consumos_datos[1];
        $id_final_datos = $ids_consumos_datos[2];
        //echo "id_inicial_datos = ".$id_inicial_datos."<br>";
        //echo "id_final_datos = ".$id_final_datos."<br>";
    }

    $query = "UPDATE archivos_tigo SET fecha_procesamiento = '".$fecha_actual."', cant_insertados_voz = '".$cant_insertados_voz."', cant_insertados_datos = '".$cant_insertados_datos."', cant_analizados = '".$cant_analizados."', cant_rechazados = '".$cant_rechazados."', id_inicial_voz = '".$id_inicial_voz."', id_final_voz = '".$id_final_voz."', id_inicial_datos = '".$id_inicial_datos."', id_final_datos = '".$id_final_datos."' WHERE id_archivo_plataforma = '".$id_archivo."'";
    //echo "query = ".$query."<br>";
    $resultado = $obj_consumo->actualizar($query);

    if($resultado){
        $actualizado = true;
    }

    //echo "ACTUALIZADO ? ";
    //echo $actualizado == true ? "TRUE"."<br>":"FALSE"."<br>";

}


function insertar_registros_consumos_archivo($dir_destino,$nombre_archivo,$tipo_insercion){
    //echo "ENTRO AL METODO insertar_registros_consumos_archivo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES: "."<br>";
    //echo "dir_destino = ".$dir_destino."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tipo_insercion = ".$tipo_insercion."<br>";
    $mensaje = "";
    //$dir_destino = 'C:/wamp64/www/consumos_fontic/importados_tigo/';
    date_default_timezone_set("America/Bogota");
    $consumo = new Consumo();
    $id_archivo = consultar_datos_archivo_consumo_tigo($nombre_archivo,$tipo_insercion,$consumo);

    if($id_archivo > 0){
        $ruta_archivo = $dir_destino.$nombre_archivo;
        $mensaje = analizar_contenido_archivo_tigo_dash($ruta_archivo,$id_archivo,$tipo_insercion,$consumo);
    }

    return $mensaje;
}


function consultar_consumo_datos_tigo_por_eliminar($id_consumo,$id_archivo){
    //echo "ENTRO AL METODO consultar_consumo_datos_por_eliminar"."<br>";
    //echo "id_consumo = ".$id_consumo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $query = "SELECT cantidad_consumo, fecha_consumo,numero_linea FROM consumos_datos WHERE id_consumo = ".$id_consumo." AND id_archivo_tigo_dash = ".$id_archivo."";
    //echo "query = ".$query."<br>";
    $consumo = new Consumo();
    $respuesta = array();
    $cantidad_consumo = 0;
    $fecha_consumo = "";
    $numero_linea = "";
    $resultado = $consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $cantidad_consumo = $resultado['cantidad_consumo'];
        $fecha_consumo = $resultado['fecha_consumo'];
        $numero_linea = $resultado['numero_linea'];
    }

    //echo "cantidad_consumo = ".$cantidad_consumo."<br>";
    //echo "fecha_consumo = ".$fecha_consumo."<br>";
    //echo "numero_linea = ".$numero_linea."<br>";
    array_push($respuesta,$cantidad_consumo,$fecha_consumo,$numero_linea);
    return $respuesta;
}


function consultar_consumo_voz_tigo_por_eliminar($id_consumo,$id_archivo){
    //echo "ENTRO AL METODO consultar_consumo_voz_por_eliminar"."<br>";
    //echo "id_consumo = ".$id_consumo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $query = "SELECT cantidad_consumo,fecha_consumo,numero_linea FROM consumos_voz WHERE id_consumo = ".$id_consumo." AND id_archivo_tigo_dash = ".$id_archivo."";
    //echo "query = ".$query."<br>";
    $consumo = new Consumo();
    $respuesta = array();
    $cantidad_consumo = 0;
    $fecha_consumo = "";
    $numero_linea = "";
    $resultado = $consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if($num_rows > 0){
        $cantidad_consumo = $resultado['cantidad_consumo'];
        $fecha_consumo = $resultado['fecha_consumo'];
        $numero_linea = $resultado['numero_linea'];
    }

    //echo "cantidad_consumo = ".$cantidad_consumo."<br>";
    //echo "fecha_consumo = ".$fecha_consumo."<br>";
    //echo "numero_linea = ".$numero_linea."<br>";
    array_push($respuesta,$cantidad_consumo,$fecha_consumo,$numero_linea);
    return $respuesta;
}


function descontar_consumo_datos_tigo($eliminado,$cadena_datos){
    //echo "ENTRO AL METODO descontar_consumo_datos_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES = "."<br>";
    //echo "cantidad_consumo = ".$cadena_datos[0]."<br>";
    //echo "fecha_consumo = ".$cadena_datos[1]."<br>";
    //echo "numero_linea = ".$cadena_datos[2]."<br>";
    $descontado = false;
    $query = "SELECT id_total_consumos,total_consumo_datos FROM total_consumos_lineas WHERE fecha_consumo like '".$cadena_datos[1]."' AND numero_linea = '".$cadena_datos[2]."'";
    //echo "query = ".$query."<br>";
    $consumo = new Consumo();
    $resultado = $consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if(($num_rows == 1)&&($eliminado == true)){
        //echo "EL CONSUMO TOTAL DE DATOS EN ESTE REGISTRO PUEDE SER ACTUALIZADO"."<br>";
        $id_total = $resultado['id_total_consumos'];
        $total_consumo_datos = doubleval($resultado['total_consumo_datos']);
        $consumo_datos = doubleval($cadena_datos[0]);
        $nvo_consumo = doubleval($total_consumo_datos - $consumo_datos);
        //echo "AL CONSUMO TOTAL DE DATOS = ".$total_consumo_datos." LE DESCUENTO EL CONSUMO DE DATOS = ".$consumo_datos." Y OBTENGO EL NUEVO CONSUMO TOTAL DE DATOS = ".$nvo_consumo."<br>";
        $query = "UPDATE total_consumos_lineas SET total_consumo_datos = ".$nvo_consumo." WHERE id_total_consumos = ".$id_total."";
        //echo "query = ".$query."<br>";
        $resultado = $consumo->actualizar($query);

        if($resultado){
            $descontado = true;
        }

        //echo "DESCONTADO ? ";
        //echo $descontado == true ? "TRUE"."<br>":"FALSE"."<br>";
    }
    return $descontado;
}


function descontar_consumo_voz_tigo($eliminado,$cadena_datos){
    //echo "ENTRO AL METODO descontar_consumo_voz_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES = "."<br>";
    //echo "cantidad_consumo = ".$cadena_datos[0]."<br>";
    //echo "fecha_consumo = ".$cadena_datos[1]."<br>";
    //echo "numero_linea = ".$cadena_datos[2]."<br>";
    $descontado = false;
    $query = "SELECT id_total_consumos,total_consumo_voz FROM total_consumos_lineas WHERE fecha_consumo like '".$cadena_datos[1]."' AND numero_linea = '".$cadena_datos[2]."'";
    //echo "query = ".$query."<br>";
    $consumo = new Consumo();
    $resultado = $consumo->consultar_campos($query);
    $num_rows = $resultado == true ? $consumo->contar_filas($query) : 0;

    if(($num_rows == 1)&&($eliminado == true)){
        //echo "EL CONSUMO TOTAL DE VOZ EN ESTE REGISTRO PUEDE SER ACTUALIZADO"."<br>";
        $id_total = $resultado['id_total_consumos'];
        $total_consumo_voz = doubleval($resultado['total_consumo_voz']);
        $consumo_voz = doubleval($cadena_datos[0]);
        $nvo_consumo = doubleval($total_consumo_voz - $consumo_voz);
        //echo "AL CONSUMO TOTAL DE VOZ = ".$total_consumo_voz." LE DESCUENTO EL CONSUMO DE VOZ = ".$consumo_voz." Y OBTENGO EL NUEVO CONSUMO TOTAL DE VOZ = ".$nvo_consumo."<br>";
        $query = "UPDATE total_consumos_lineas SET total_consumo_voz = ".$nvo_consumo." WHERE id_total_consumos = ".$id_total."";
        //echo "query = ".$query."<br>";
        $resultado = $consumo->actualizar($query);

        if($resultado){
            $descontado = true;
        }

        //echo "DESCONTADO ? ";
        //echo $descontado == true ? "TRUE"."<br>":"FALSE"."<br>";
    }
    return $descontado;
}


function eliminar_consumo_datos_tigo($id_consumo,$id_archivo){
    //echo "ENTRO AL METODO eliminar_consumo_datos_tigo"."<br>";
    //echo "id_consumo = ".$id_consumo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $eliminado = false;
    $query = "DELETE FROM consumos_datos WHERE id_consumo = ".$id_consumo." AND id_archivo_tigo_dash = ".$id_archivo."";
    //echo "query = ".$query."<br>";
    $consumo = new Consumo();
    $resultado = $consumo->eliminar($query);

    if($resultado){
        $eliminado = true;
    }

    //echo "REGISTRO ELIMINADO ? "."<br>";
    //echo $eliminado == true ? "TRUE"."<br>":"FALSE"."<br>";
    return $eliminado;
}



function eliminar_consumo_voz_tigo($id_consumo,$id_archivo){
    //echo "ENTRO AL METODO eliminar_consumo_voz_tigo"."<br>";
    //echo "id_consumo = ".$id_consumo."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $eliminado = false;
    $query = "DELETE FROM consumos_voz WHERE id_consumo = ".$id_consumo." AND id_archivo_tigo_dash = ".$id_archivo."";
    //echo "query = ".$query."<br>";
    $consumo = new Consumo();
    $resultado = $consumo->eliminar($query);

    if($resultado){
        $eliminado = true;
    }

    //echo "REGISTRO ELIMINADO ? "."<br>";
    //echo $eliminado == true ? "TRUE"."<br>":"FALSE"."<br>";
    return $eliminado;
}


function eliminar_registros_por_rectificar_archivo_tigo($id_ini_datos,$id_fin_datos,$id_ini_voz,$id_fin_voz,$id_archivo){
    //echo "ENTRO AL METODO eliminar_registros_por_rectificar_archivo_tigo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES = "."<br>";
    //echo "id_ini_datos = ".$id_ini_datos."<br>";
    //echo "id_fin_datos = ".$id_fin_datos."<br>";
    //echo "id_ini_voz = ".$id_ini_voz."<br>";
    //echo "id_fin_voz = ".$id_fin_voz."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    $descontados_datos = 0;
    $descontados_voz = 0;

    for($i = $id_ini_datos; $i<= $id_fin_datos; $i++){
        $cadena_datos = consultar_consumo_datos_tigo_por_eliminar($i,$id_archivo);
        $eliminado = eliminar_consumo_datos_tigo($i,$id_archivo);
        $descontado = descontar_consumo_datos_tigo($eliminado,$cadena_datos);
        if($descontado){
            $descontados_datos++;
        }
    }

    for($j = $id_ini_voz; $j<= $id_fin_voz; $j++){
        $cadena_voz = consultar_consumo_voz_tigo_por_eliminar($j,$id_archivo);
        $eliminado = eliminar_consumo_voz_tigo($j,$id_archivo);
        $descontado = descontar_consumo_voz_tigo($eliminado,$cadena_voz);
        if($descontado){
            $descontados_voz++;
        }
    }

    $mensaje = "Han sido eliminados ".$descontados_datos." registros de consumos de datos. Han sido eliminados ".$descontados_voz." registros de consumos de voz. ";
    return $mensaje;
}


?>