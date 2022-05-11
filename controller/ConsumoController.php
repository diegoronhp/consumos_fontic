<?php 
error_reporting(E_ALL);

//include('../model/bd/dbconect.php');
require '../model/Consumo.class.php';


function buscar_nombre_archivo_consumo($nombre_archivo,$tabla_bd){
    //echo "ENTRO AL METODO buscar_nombre_archivo_consumo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tabla_bd = ".$tabla_bd."<br>";
    $consumo = new Consumo();
    $existe = false;
    $query = "SELECT * FROM ".$tabla_bd." WHERE nombre_archivo LIKE '".$nombre_archivo."%'";
    //echo "query = ".$query."<br>";
    $resultado = $consumo->consultar($query);
    //$num_rows = $consumo->contar_filas($query);
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

function buscar_nombre_archivo_consumo_tigo_rectificar($nombre_archivo,$tabla_bd,$tipo_archivo){
    //echo "ENTRO AL METODO buscar_nombre_archivo_consumo_tigo_rectificar"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tabla_bd = ".$tabla_bd."<br>";
    //echo "tipo_archivo = ".$tipo_archivo."<br>";
    $consumo = new Consumo();
    $existe = false;
    $id_inicial = "";
    $id_final = "";

    $query = "SELECT * FROM ".$tabla_bd." WHERE nombre_archivo LIKE '".$nombre_archivo."%' AND tipo_archivo = '".$tipo_archivo."' ORDER BY fecha_cargue DESC LIMIT 1";
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

function buscar_nombre_archivo_consumo_claro_rectificar($nombre_archivo,$tabla_bd){
    //echo "ENTRO AL METODO buscar_nombre_archivo_consumo_claro_rectificar"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES:"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "tabla_bd = ".$tabla_bd."<br>";
    $consumo = new Consumo();
    $existe = false;
    $id_inicial = "";
    $id_final = "";

    $query = "SELECT * FROM ".$tabla_bd." WHERE nombre_archivo LIKE '".$nombre_archivo."%' ORDER BY fecha_cargue DESC LIMIT 1";
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


?>