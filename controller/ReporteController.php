<?php
error_reporting(0);
//error_reporting(E_ALL);
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require_once "../vendor/autoload.php";
require '../model/Reporte.class.php';
function getRangeDate($date_ini, $date_end, $format) {
    $dt_ini = DateTime::createFromFormat($format, $date_ini);
    $dt_end = DateTime::createFromFormat($format, $date_end);
    $period = new DatePeriod(
        $dt_ini,
        new DateInterval('P1D'),
        $dt_end
    );
    $range = [];
    foreach ($period as $date) {
        $range[] = $date->format($format);
    }
    $range[] = $date_end;
    return $range;
}
function generarEncabezadosArchivo($fecha_desde,$fecha_hasta){
    //echo "ENTRO A LA FUNCION generarEncabezadosArchivo"."<br>";
    $ranges = getRangeDate($fecha_desde, $fecha_hasta, 'Y-m-d');
    $encabezado = ["Linea", "Operador"];
    $rangos_fechas = array();
    foreach($ranges as $range){
        array_push($encabezado,$range);
        array_push($rangos_fechas,$range);
    }
    array_push($encabezado,"Consumo Total Datos");
    foreach($ranges as $range){
        array_push($encabezado,$range);
    }
    array_push($encabezado,"Consumo Total Voz");
    //echo "ENCABEZADO = ".var_dump($encabezado)."<br>";
    //echo "fechas_datos = ".var_dump($rangos_fechas)."<br>";
    $respuesta = array($encabezado,$rangos_fechas);
    return $respuesta;
}
function consultarLineasConsumosRangoFechas($fecha_desde,$fecha_hasta){
    //echo "ENTRO A LA FUNCION consultarLineasConsumosRangoFechas"."<br>";
    $query = "SELECT DISTINCT(numero_linea) FROM total_consumos_lineas WHERE fecha_consumo BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'";
    //echo "query = ".$query."<br>";
    $reporte = new Reporte();
    $resultado = $reporte->consultar($query);
    return $resultado;
}
function consultarConsumosFechaPorLinea($numero,$fecha){
    $consumo_datos = 0.0;
    $consumo_voz = 0.0;
    //echo "ENTRO A LA FUNCION consultarConsumosFechaPorLinea"."<br>";
    $query = "SELECT total_consumo_datos,total_consumo_voz FROM total_consumos_lineas WHERE numero_linea = '".$numero."' AND fecha_consumo = '".$fecha."' ";
    //echo "query = ".$query."<br>";
    $reporte = new Reporte();
    $resultado = $reporte->consultar_campos($query);
    $num_rows = $resultado == true ? $reporte->contar_filas($query) : 0;
    if($num_rows > 0){
        $consumo_datos = $resultado['total_consumo_datos'];
        $consumo_voz = $resultado['total_consumo_voz'];
    }
    $respuesta = array($consumo_datos,$consumo_voz);
    return $respuesta;
}
function consultarConsumoTotalPeriodoLinea($campo,$numero,$desde,$hasta){
    //echo "ENTRO A LA FUNCION consultarConsumoTotalPeriodo"."<br>";
    $consumo_total = 0;
    $query = "SELECT SUM(".$campo.") AS consumo_total FROM total_consumos_lineas WHERE numero_linea = '".$numero."' AND fecha_consumo BETWEEN '".$desde."' AND '".$hasta."' ";
    //echo "query = ".$query."<br>";
    $reporte = new Reporte();
    $resultado = $reporte->consultar_campos($query);
    $num_rows = $resultado == true ? $reporte->contar_filas($query) : 0;
    if($num_rows > 0){
        $consumo_total = $resultado['consumo_total'];
    }
    //echo "consumo_total = ".$consumo_total."<br>";
    return $consumo_total;
}
function escribirConsumosDocumento($resultadoLineas,$Consumos,$rangos_fechas,$fecha_desde,$fecha_hasta){
    //echo "ENTRO A LA FUNCION escribirConsumosDocumento"."<br>";
    $sin_consumo = 0.0;
    $numeroDeFila = 2;
    $cantidad_fechas = count($rangos_fechas);
    $desplazamiento_datos = 3;
    $desplazamiento_voz = 3 + $cantidad_fechas + 1;
    $columna_total_datos = 3 + $cantidad_fechas;
    $columna_total_voz = $desplazamiento_voz + $cantidad_fechas;
    while($row = mysqli_fetch_array($resultadoLineas)){
        $numero = $row['numero_linea'];
        $operador = consultar_operador($numero);
        //echo "numero = ".$numero."<br>";
        //echo "operador = ".$operador."<br>";
        $Consumos->setCellValueByColumnAndRow(1, $numeroDeFila, $numero);
        $Consumos->setCellValueByColumnAndRow(2, $numeroDeFila, $operador);
        foreach($rangos_fechas as $fecha_buscada){
            $resultado_consumos = consultarConsumosFechaPorLinea($numero,$fecha_buscada);
            $consumo_datos = $resultado_consumos[0];
            $consumo_voz = $resultado_consumos[1];
            //echo "fecha_buscada = ".$fecha_buscada."<br>";
            //echo "consumo_datos = ".$consumo_datos."<br>";
            //echo "consumo_voz = ".$consumo_voz."<br>";
            $columna_consumo_datos = obtenerPosicionColumna($rangos_fechas,$fecha_buscada,$desplazamiento_datos);
            $Consumos->setCellValueByColumnAndRow($columna_consumo_datos, $numeroDeFila, $consumo_datos);
            $columna_consumo_voz = obtenerPosicionColumna($rangos_fechas,$fecha_buscada,$desplazamiento_voz);
            $Consumos->setCellValueByColumnAndRow($columna_consumo_voz, $numeroDeFila, $consumo_voz);
        }
        $campo = 'total_consumo_datos';
        $total_consumo_datos = consultarConsumoTotalPeriodoLinea($campo,$numero,$fecha_desde,$fecha_hasta);
        $Consumos->setCellValueByColumnAndRow($columna_total_datos, $numeroDeFila, $total_consumo_datos);
        $campo = 'total_consumo_voz';
        $total_consumo_voz = consultarConsumoTotalPeriodoLinea($campo,$numero,$fecha_desde,$fecha_hasta);
        $Consumos->setCellValueByColumnAndRow($columna_total_voz, $numeroDeFila, $total_consumo_voz);
        $numeroDeFila++;
    }
    return $Consumos;
}
function obtenerPosicionColumna($rango_fechas,$fecha_buscada,$desplazamiento){
    //echo "ENTRO A LA FUNCION obtenerPosicionColumna"."<br>";
    $columna = array_search($fecha_buscada,$rango_fechas);
    //echo "POSICION EN EL ARRAY = ".$columna."<br>";
    $columna = $columna + $desplazamiento;
    //echo "POSICION CON DESPLAZAMIENTO = ".$columna."<br>";
    return $columna;
}
function consultar_operador($numero){
    $operador = "";
    $query = "SELECT id_operador FROM lineas_registradas WHERE numero_linea = '".$numero."'";
    $reporte = new Reporte();
    $resultado = $reporte->consultar_campos($query);
    $num_rows = $resultado == true ? $reporte->contar_filas($query) : 0;
    if($num_rows > 0){
        $id_operador = $resultado['id_operador'];
        $operador = $id_operador == 1 ? "TIGO":"CLARO";
    }
    //echo "operador = ".$operador."<br>";
    return $operador;
}

?>