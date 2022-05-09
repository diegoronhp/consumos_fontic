<style>
    body  {
        background: rgb(181,177,162);
        background: linear-gradient(90deg, rgba(181,177,162,1) 0%, rgba(255,255,255,1) 50%, rgba(214,213,209,1) 100%);
    }
    .card{
        background-color: #fffefe38;
    }

    .resaltado{
        font-weight: bold;
        font-size: 20px;
    }

</style>


<?php

error_reporting(0);

include('model/bd/dbconect.php');
include('views/content/pruebita.php');
require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');



if (isset($_POST["import"])) {
    $nombre_archivo = '';
    $archivo_valido = '';
    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        $nombre_archivo = $_FILES['file']['name'];
        $existe = buscar_nombre_archivo_valores($con,$nombre_archivo);
        if($existe === true){
            //echo "EL ARCHIVO ".$nombre_archivo." **SI** EXISTE EN LA BD"."<br>";
            $archivo_valido = false;
        }else{
            //echo "EL ARCHIVO ".$nombre_archivo." **NO** EXISTE EN LA BD"."<br>";
            insertar_nombre_archivo_valores($con,$nombre_archivo);
            $targetPath = 'subidas_valores/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
            actualizar_valores_canales($con,$nombre_archivo);
            $archivo_valido = true;
        }
    }else{
        $archivo_valido = false;
    }
}


function actualizar_valores_canales($con,$nombre_archivo){
    //echo "ENTRO AL METODO actualizar_valores_canales"."<br>";
    $contador_actualizados = 0;
    $contador_analizados = 0;
    $datos_valores_sedes = array();
    $result = array();
    //$dir = "C:/wamp64/www/resarcimientos/importados_valores";
    $dir_destino = "C:/wamp64/www/resarcimientos/subidas_valores";
    date_default_timezone_set("America/Bogota");
    $targetPath = $dir_destino."/".$nombre_archivo;
    $respuesta = consultar_datos_archivo_valores($con,$nombre_archivo);
    $correo_destino = $respuesta[0];
    $id_archivo = $respuesta[1];
    $usuario = $respuesta[2];

    //echo "correo_destino = ".$correo_destino."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";
    //echo "targetPath = ".$targetPath."<br>";

    $Reader = new SpreadsheetReader($targetPath);
    $sheetCount = count($Reader->sheets());

    for ($i = 0; $i < $sheetCount; $i++){
        //echo "ESTOY EN LA ITERACION = ".$i."<br>";
        $Reader->ChangeSheet($i);

        foreach ($Reader as $Row){
            $alias_sede = "";
            //echo "ESTOY EN LA ITERACION = ".$contador_analizados."<br>";
            if (isset($Row[1])) {
                $alias_sede = mysqli_real_escape_string($con, $Row[1]);
                //echo "alias_sede = ".$alias_sede."<br>";
            }

            $existe_sede = verificar_alias_sede($con,$alias_sede);

            if($existe_sede == true){
                //echo "LA SEDE alias_sede ".$alias_sede." **SI** EXISTE EN LA BD"."<br>";
                $valor_canal = "";
                if (isset($Row[2])) {
                    $valor_canal = mysqli_real_escape_string($con, $Row[2]);
                    $valor_canal = intval($valor_canal);
                    //echo "valor_canal = ".$valor_canal."<br>";
                }
                actualizar_valor_sede($con,$alias_sede,$valor_canal);
                $dato_valor_sede = $alias_sede." = ".$valor_canal;
                array_push($datos_valores_sedes,$dato_valor_sede);
                $contador_actualizados++;
            }else{
                //echo "LA SEDE alias_sede ".$alias_sede." **NO** EXISTE EN LA BD"."<br>";
            }
            $contador_analizados++;
        }
    }
    $contador_analizados = $contador_analizados - 1;
    //echo "contador_actualizados = ".$contador_actualizados."<br>";
    //echo "contador_analizados = ".$contador_analizados."<br>";
    actualizar_datos_archivo_valores($con,$nombre_archivo,$id_archivo,$contador_actualizados,$contador_analizados);
    array_push($result,$nombre_archivo);
    array_push($result,$contador_actualizados);
    array_push($result,$contador_analizados);
    array_push($result,$correo_destino);
    array_push($result,$datos_valores_sedes);
    //echo "ENVIO LOS SIGUIENTES DATOS EN EL ARRAY = "."<br>";
    //echo "nombre_archivo = ".$result[0]."<br>";
    //echo "contador_actualizados = ".$result[1]."<br>";
    //echo "contador_analizados = ".$result[2]."<br>";
    //echo "correo_destino = ".$result[3]."<br>";
    //echo "datos_valores_sedes = ".var_dump($result[4])."<br>";
    enviar_correo_usuario_valores($result);
    //copy($targetPath,$dir_destino."/".$nombre_archivo);
    //modificar_extension_archivo($nombre_archivo,$dir);
}

function modificar_extension_archivo($nombre_archivo,$ubicacion){
    //echo "ENTRO AL METODO modificar_extension_archivo"."<br>";
    //echo "RECIBO LAS SIGUIENTES VARIABLES"."<br>";
    //echo "nombre_archivo = ".$nombre_archivo."<br>";
    //echo "ubicacion = ".$ubicacion."<br>";
    $nombre_modificado = str_replace ( "xlsx", "txt", $nombre_archivo);
    $ubicacion_inicial = $ubicacion."/".$nombre_archivo;
    $ubicacion_final = $ubicacion."/".$nombre_modificado;
    //echo "DESPUES DE MODIFICAR LAS UBICACIONES DEL ARCHIVO"."<br>";
    //echo "nombre_modificado = ".$nombre_modificado."<br>";
    //echo "ubicacion_inicial = ".$ubicacion_inicial."<br>";
    //echo "ubicacion_final = ".$ubicacion_final."<br>";
    rename($ubicacion_inicial,$ubicacion_final);
}


function actualizar_datos_archivo_valores($con,$nombre_archivo,$id_archivo,$contador_actualizados,$contador_analizados){
    //echo "ENTRO AL METODO actualizar_datos_archivo_valores"."<br>";
    $formato = "Y-m-d H:i:s";
    $actualizados = intval($contador_actualizados);
    $analizados = intval($contador_analizados);
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date($formato);
    //echo "actualizados = ".$actualizados."<br>";
    //echo "analizados = ".$analizados."<br>";
    $query = "UPDATE archivos_importados_valores SET cant_actualizados = '".$actualizados."', cant_analizados = '".$analizados."',fecha_procesamiento = '".$fecha_actual."', estado_procesamiento = 1 WHERE nombre_archivo_valores LIKE '".$nombre_archivo."%' AND id_archivo_valores = '".$id_archivo."'";
    mysqli_query($con, $query);
    //echo "QUERY DE ACTUALIZACION = ".$query."<br>";
}

function actualizar_valor_sede($con,$sede,$valor){
    //echo "ENTRO AL METODO actualizar_valor_sede"."<br>";
    $query = "UPDATE sedes SET valor_serv_canal = '".$valor."' WHERE alias_sede LIKE '".$sede."'";
    //echo "query = ".$query."<br>";
    mysqli_query($con, $query);
}


function verificar_alias_sede($con,$alias_sede_cnl){
    //echo "ENTRO AL METODO verificar_alias_sede"."<br>";
    $existe = false;
    $query = "SELECT * FROM sedes WHERE alias_sede LIKE '".$alias_sede_cnl."%'";
    //echo "query = ".$query."<br>";
    $resultados = mysqli_query($con, $query);
    $num_rows = mysqli_num_rows($resultados);
    if($num_rows > 0){
        $existe = true;
    }
    return $existe;
}


function buscar_nombre_archivo_valores($con,$nombre_archivo){
    //echo "ENTRO AL METODO buscar_nombre_archivo_valores"."<br>";
    $encontrado = false;
    $query = "SELECT * FROM archivos_importados_valores WHERE nombre_archivo_valores = '".$nombre_archivo."'";
    //echo "query = ".$query."<br>";
    $resultado = mysqli_query($con, $query);
    $num_rows = mysqli_num_rows($resultado);
    if($num_rows > 0){
        $encontrado = true;
    }
    return $encontrado;
}


function insertar_nombre_archivo_valores($con,$nombre_archivo){
    //echo "ENTRO AL METODO insertar_nombre_archivo_valores"."<br>";
    date_default_timezone_set("America/Bogota");
    $fecha_actual = date("Y-m-d H:i:s");
    $usuario = $_SESSION["usuario"];
    //echo "usuario = ".$usuario."<br>";
    $correo_destino = consultar_correo_usuario_valores($con,$usuario);
    $query = "INSERT INTO archivos_importados_valores(nombre_archivo_valores,usuario,fecha_cargue,fecha_procesamiento,correo_destino) VALUES('".$nombre_archivo."','".$usuario."','".$fecha_actual."',null,'".$correo_destino."')";
    //echo "query = ".$query."<br>";
    $resultados = mysqli_query($con, $query);
}

function consultar_correo_usuario_valores($con,$usuario){
    $email = '';
    $query = "SELECT emailUser FROM users WHERE loginUsers = '".$usuario."'";
    $resultado = mysqli_query($con, $query);
    $num_rows = mysqli_num_rows($resultado);

    if($num_rows > 0){
        $respuesta = mysqli_fetch_array($resultado);
        $email = $respuesta['emailUser'];
    }
    return $email;
}


function consultar_datos_archivo_valores($con,$nombre_archivo){
    //echo "ENTRO AL METODO consultar_datos_archivo_valores"."<br>";
    $email = '';
    $id_archivo = '';
    $usuario = '';
    $query = "SELECT id_archivo_valores,correo_destino,usuario FROM archivos_importados_valores WHERE nombre_archivo_valores LIKE '".$nombre_archivo."%' AND estado_procesamiento = 0 ORDER BY fecha_cargue DESC LIMIT 1";
    //echo "query = ".$query."<br>";
    $resultado = mysqli_query($con, $query);
    $num_rows = mysqli_num_rows($resultado);
    //echo "num_rows = ".$num_rows."<br>";
    if($num_rows > 0){
        $respuesta = mysqli_fetch_array($resultado);
        $id_archivo = $respuesta['id_archivo_valores'];
        $email = $respuesta['correo_destino'];
        $usuario = $respuesta['usuario'];
    }
    //echo "email = ".$email."<br>";
    //echo "id_archivo = ".$id_archivo."<br>";

    $respuesta = array($email,$id_archivo,$usuario);
    return $respuesta;
}


?>
<!doctype html>
<html lang="es"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel=”shortcut icon”  href=”/favicon1.ico”/>
    <title> Cargar Reporte Local</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/sticky-footer-navbar.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.css"/>
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


</head>


<!-- otra seccion de carga-->


<!-- fin otra seccion de carga-->

<body>



<section id="main">
    <!-- Begin page content -->

    <article class="module width_full">
        <center><b>
                <div class="p-2 sunny-morning-gradient text-black">REPORTE VALORES CANALES</div>
            </b></center>
        <hr>


        <!-- Contenido -->


        <div class="col-20 col-md-7">

            <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">

            <div>
                    <div class="module_content">
                        <center>

                            <div class="input-group my-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="file">Cargar</span>
                                </div>
                                <div class="custom-file">

                                    <label class="custom-file-label" for="inputGroupFile01"></label>
                                    <input type="file" class="custom-file-input" name="file" id="file" accept=".xls,.xlsx">

                                </div>
                            </div>
                        </center>
                        <br>
                        <br>
                        <br>

                        <div>
                            <img id="demo" style="width: 40%" src="views/default/images/valor_canal.png" >
                        </div>

                        <br/>
                        <button type="submit" id="submit" name="import"
                                style="width: 120px;font-size: 0.9rem;line-height: 1.3;letter-spacing: 0.009em;font-weight: 500;"
                                class="btn light-green darken-4 btn-submit">IMPORTAR ARCHIVO VALORES
                        </button>

                        <br>
                    </div>

                </div>
            </form>




            <div class="resaltado"><?php

                if ($archivo_valido === true) {
                    echo "En los próximos minutos recibirá un mensaje de notificacion en su correo electrónico con el resultado estadístico del archivo importado";
                    echo '<script
                        type="text/javascript">
                        $(document).ready(function(){

                              swal({
                                position: "top-end",
                                type: "success",
                                title: "EL ARCHIVO HA SIDO IMPORTADO Y SUS REGISTROS HAN SIDO ACTUALIZADOS",
                                showConfirmButton: false,
                                timer: 1500
                              })
                                });
                    </script>';
                    //PRUEBA VISTAS
                    //header("Location: ../resarcimientos/index.php?contr=Biometrico&act=importar");
                    //FIN PRUEBA VISTAS

                }
                if($archivo_valido === false) {
                   echo "El archivo que intenta importar es inválido o ya fue cargado previamente. Por favor vuelva a intentarlo con un archivo permitido o con un nombre diferente";
                   echo '
                    <script type="text/javascript">

                        $(document).ready(function(){

                              swal({
                                position: "top-end",
                                type: "warning",
                                title: "EL ARCHIVO NO ES VALIDO",
                                showConfirmButton: false,
                                timer: 1500
                              })
                                });

                        </script>';

                }
            ?></div>
        </div>
        <!-- Fin row -->



        <!-- Fin container -->

        <script src="assets/jquery-1.12.4-jquery.min.js"></script>

        <!-- Bootstrap core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script src="dist/js/bootstrap.min.js"></script>
    </article>
</body>
</html>


