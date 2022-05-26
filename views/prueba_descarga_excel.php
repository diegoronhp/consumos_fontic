<?php
require_once "../vendor/autoload.php";

# Nuestra base de datos
require_once "../model/bd/dbconect.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

# Obtener base de datos
//$con = ConexionBD();

$documento = new Spreadsheet();
$documento
    ->getProperties()
    ->setCreator("Nestor Tapia")
    ->setLastModifiedBy('BaulPHP')
    ->setTitle('Archivo generado desde MySQL')
    ->setSubject('Excel de prueba')
    ->setDescription('Productos y proveedores exportados desde MySQL')
    ->setKeywords('PHPSpreadsheet')
    ->setCategory('Categoría Excel');

$hojaDeProductos = $documento->getActiveSheet();
$hojaDeProductos->setTitle("Productos");

$ranges = getRangeDate('2022-05-12', '2022-05-29', 'Y-m-d');

# Encabezado de los productos
$encabezado = ["Linea", "Operador"];
foreach($ranges as $range){
    array_push($encabezado,$range);
}




# Encabezado de los productos
//$encabezado = ["num_linea", "estado", "operador"];
# El último argumento es por defecto A1
$hojaDeProductos->fromArray($encabezado, null, 'A1');


/*
$query = "SELECT * FROM lineas_registradas LIMIT 10";
$resultado = mysqli_query($con,$query);
*/

/*
# Comenzamos en la fila 2
$numeroDeFila = 2;
while($row = mysqli_fetch_array($resultado)){
    # Obtener registros de MySQL
    $numero = $row['numero_linea'];
    $estado = $row['estado'];
    $operador = $row['id_operador'];
    # Escribir registros en el documento
    $hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $numero);
    $hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $estado);
    $hojaDeProductos->setCellValueByColumnAndRow(3, $numeroDeFila, $operador);
    $numeroDeFila++;
}*/

/*
# Comenzamos en la fila 2
$numeroDeFila = 2;
while ($producto = $sentencia->fetchObject()) {
# Obtener registros de MySQL
    $codigo = $producto->codigo;
    $productos = $producto->producto;
    $precio_compra = $producto->precio_compra;
    $precio_venta = $producto->precio_venta;
    $existencia = $producto->existencia;
# Escribir registros en el documento
    $hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $codigo);
    $hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $productos);
    $hojaDeProductos->setCellValueByColumnAndRow(3, $numeroDeFila, $precio_compra);
    $hojaDeProductos->setCellValueByColumnAndRow(4, $numeroDeFila, $precio_venta);
    $hojaDeProductos->setCellValueByColumnAndRow(5, $numeroDeFila, $existencia);
    $numeroDeFila++;
}*/

/*# Ahora creamos la hoja "proveedores"
$hojaDeProveedores = $documento->createSheet();
$hojaDeProveedores->setTitle("Proveedores");

# Declaramos el encabezado
$encabezado = ["Nombres", "Dirección Email ", "Empresa", "Pais residencia"];
$hojaDeProveedores->fromArray($encabezado, null, 'A1');
# Obtener los proveedores de MySQL
$consulta = "select * from tbl_proveedores";
$sentencia = $con->prepare($consulta, [
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();*/

/*# Comenzamos en la 2
$numeroDeFila = 2;
while ($proveedores = $sentencia->fetchObject()) {
# Obtener los datos de la base de datos
    $nombres = $proveedores->nombres;
    $correo = $proveedores->correo;
    $empresa = $proveedores->empresa;
    $pais = $proveedores->pais;

# Escribir en el documento
    $hojaDeProveedores->setCellValueByColumnAndRow(1, $numeroDeFila, $nombres);
    $hojaDeProveedores->setCellValueByColumnAndRow(2, $numeroDeFila, $correo);
    $hojaDeProveedores->setCellValueByColumnAndRow(3, $numeroDeFila, $empresa);
    $hojaDeProveedores->setCellValueByColumnAndRow(4, $numeroDeFila, $pais);
    $numeroDeFila++;
}*/
# Crear un "escritor"
//$fileName="Reporte_consumos_periodo.xls";
$writer = new Xlsx($documento);
set_time_limit(0);
ob_start();
ob_get_clean();

# Le pasamos la ruta de guardado
//$writer->save('../importados_claro/Exportado_lineas_operador.xlsx');
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');

//$writer->save('php://output');
//$encoded_csv = mb_convert_encoding($fputcsv, 'UTF-16LE', 'UTF-8');

//header("content-type:application/csv;charset=UTF-8");
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte_consumos_periodo.xlsx"); //aca cambio la cabecera
//header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
ob_end_clean();
$writer->save('php://output');



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




?>