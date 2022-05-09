<style>
    body {
        background: rgb(181, 177, 162);
        background: linear-gradient(90deg, rgba(181, 177, 162, 1) 0%, rgba(255, 255, 255, 1) 50%, rgba(214, 213, 209, 1) 100%);
    }

    .card {
        background-color: #fffefe38;
    }

</style>


<?php
error_reporting(0); //se supone con esto deshabilito error reporting para esta
//error_reporting(E_ALL);

require_once 'libs/validador.php';
require 'model/IM.class.php';
require 'model/Divipol.class.php';
require 'model/Consulta.class.php';
require 'views/content/pruebita.php';

class ConsultaController
{

    function __construct()
    {
        //Creamos una instancia de nuestro mini motor de plantillas
        $this->view = new View();
        //$this->divipol = new Divipol();
    }


    function index($estado = '', $tipo = '')
    { //alias SIN TRAMITAR
        require 'configs.php'; //Archivo con configuraciones.
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $consulta = new IM();
        $query_nuevo = "";
        $cant_sin_tramitar = '';


        //echo "ANTES DE HACER CUALQUIER COSA CON EL QUERY EN LA VARIABLES DE SESION EL QUERY ESTA ASI = ".$_SESSION['query_resultante']."<br>";
        if (isset($_GET["tipo"]))
            switch ($_GET["tipo"]) {
                case "sin_tramite":

                    $tipo = "SIN TRAMITAR"; //sin tramitar


                    //if ($_SESSION['control_boton'] == 0) {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "query_resultante (sesion) = ".$_SESSION['query_resultante']."<br>";
                        //$cadena = "\"" . $_SESSION['query_resultante'] . "\"";
                        //$consulta->insertpruebasdato($cadena);
                        //echo 'Acabo de insertar en la bd este query = '.$cadena."<br>";
                        //echo "PRESIONE BOTON SIN TRAMITAR"."<br>";
                        $result = $consulta->consultapruebasdato();
                        $result = mysqli_fetch_array($result);
                        $query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (insertado) = ".$query_bd."<br>";
                        $condicion = " AND disponibilidades.estado_tramite = '{$tipo}'";
                        $query_nuevo = $query_bd . $condicion;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //} else {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "PRESIONE BOTON SIN TRAMITAR"."<br>";
                        //$result = $consulta->consultapruebasdato();
                        //$result = mysqli_fetch_array($result);
                        //$query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (consultado) = ".$query_bd."<br>";
                        //$condicion = " AND disponibilidades.estado_tramite = '{$tipo}'";
                        //$query_nuevo = $query_bd . $condicion;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //}








                    $array_equipo = $_SESSION['deptos_seleccionados'];

                    $cadena_equipo = implode(",", $array_equipo);
                    //    echo "El equipo separaro por ',' es el siguiente: " .$cadena_equipo;

                    $cadena_equipo2 = implode($array_equipo);
                    //      echo "<br><br>El equipo sin parámetro string es el siguiente: " .$cadena_equipo2;


                    $_SESSION['deptos_seleccionados'] = $cadena_equipo;
                    //     echo 'mis deptos son:'.$_SESSION['deptos_seleccionados'];


                    $cadena_equipo = $_POST['deptos_seleccionados'];
                    if ($cadena_equipo == "" or substr($cadena_equipo, 0, 1) == " ") {
                    } else {
                        $_SESSION['deptos_seleccionados'] = $cadena_equipo;
                    }
                    //    echo "<p>MISDATOSSSSS unicos: ".$_SESSION['deptos_seleccionados']."</p>";


                    break;

                case "tramitado":
                    $tipo = "TRAMITADO"; //tramitados

                    //if ($_SESSION['control_boton'] == 0) {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "query_resultante (sesion) = ".$_SESSION['query_resultante']."<br>";
                        //$cadena = "\"" . $_SESSION['query_resultante'] . "\"";
                        //$consulta->insertpruebasdato($cadena);
                        //echo 'Acabo de insertar en la bd este query = '.$cadena."<br>";
                        //echo "PRESIONE BOTON TRAMITADO"."<br>";
                        $result = $consulta->consultapruebasdato();
                        $result = mysqli_fetch_array($result);
                        $query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (insertado) = ".$query_bd."<br>";

                        if (in_array('32', $_SESSION['roles'])) {
                            // echo "VERIFICO ESTE ROL";
                            $condicion = " AND disponibilidades.estado_tramite = '{$tipo}' AND disponibilidades.estado_tramite_rnec = 'SIN TRAMITAR'";
                        } else {
                            $condicion = " AND disponibilidades.estado_tramite = '{$tipo}'";
                        }

                        $query_nuevo = $query_bd . $condicion;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //} else {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "PRESIONE BOTON TRAMITADO"."<br>";
                        //$result = $consulta->consultapruebasdato();
                        //$result = mysqli_fetch_array($result);
                        //$query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (consultado) = ".$query_bd."<br>";


                        //if (in_array('32', $_SESSION['roles'])) {
                            // echo "VERIFICO ESTE ROL";
                            //$condicion = " AND disponibilidades.estado_tramite = '{$tipo}' AND disponibilidades.estado_tramite_rnec = 'SIN TRAMITAR'";
                        //} else {
                            //$condicion = " AND disponibilidades.estado_tramite = '{$tipo}'";
                        //}
                        //echo "recibo este query desde la bd (consultado) = ".$query_bd."<br>";

                        //$query_nuevo = $query_bd . $condicion;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //}


                    break;

                case "pendientes":
                    $tipo = "PENDIENTES"; //pendiente

                    $inner_viejo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl";
                    $inner_nuevo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl INNER JOIN fallas_proveedor AS tipificaciones ON disponibilidades.id_disp_cnl = tipificaciones.id_disp_cnl ";

                    //if ($_SESSION['control_boton'] == 0) {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "query_resultante (sesion) = ".$_SESSION['query_resultante']."<br>";
                        //$cadena = "\"" . $_SESSION['query_resultante'] . "\"";
                        //$consulta->insertpruebasdato($cadena);
                        //echo 'Acabo de insertar en la bd este query = '.$cadena."<br>";
                        //echo "PRESIONE BOTON PENDIENTE"."<br>";
                        $result = $consulta->consultapruebasdato();
                        $result = mysqli_fetch_array($result);
                        $query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (insertado) = ".$query_bd."<br>";
                        //echo "inner_viejo = ".$inner_viejo."<br>";
                        //echo "inner_nuevo = ".$inner_nuevo."<br>";
                        //$query_bd = str_replace($inner_viejo,$inner_nuevo,$query_bd);
                        $query_bd = substr_replace($query_bd, $inner_nuevo, 0, 156);
                        //echo "obtengo este query despues de modificar los inner = ".$query_bd."<br>";
                        $condicion = " AND disponibilidades.estado_tramite = 'PENDIENTES' AND tipificaciones.estado_registro = 3 GROUP BY tipificaciones.id_disp_cnl";
                        $query_bd .= $condicion;
                        $query_nuevo = $query_bd;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //echo "obtengo este query despues de agregar la condicion = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //} else {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "PRESIONE BOTON PENDIENTE"."<br>";
                        //$result = $consulta->consultapruebasdato();
                        //$result = mysqli_fetch_array($result);
                        //$query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (consultado) = ".$query_bd."<br>";
                        //echo "inner_viejo = ".$inner_viejo."<br>";
                        //echo "inner_nuevo = ".$inner_nuevo."<br>";
                        //$query_bd = str_replace($inner_viejo,$inner_nuevo,$query_bd);
                        //$query_bd = substr_replace($query_bd, $inner_nuevo, 0, 156);
                        //echo "obtengo este query despues de modificar los inner = ".$query_bd."<br>";
                        //$condicion = " AND disponibilidades.estado_tramite = 'PENDIENTES' AND tipificaciones.estado_registro = 3 GROUP BY tipificaciones.id_disp_cnl";
                        //$query_bd .= $condicion;
                        //$query_nuevo = $query_bd;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //echo "obtengo este query despues de agregar la condicion = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //}

                    break;

                case "aprobados":
                    $tipo = "APROBADOS"; //aprobados

                    $inner_viejo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl";
                    $inner_nuevo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl INNER JOIN fallas_proveedor AS tipificaciones ON disponibilidades.id_disp_cnl = tipificaciones.id_disp_cnl ";

                    //if ($_SESSION['control_boton'] == 0) {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "query_resultante (sesion) = ".$_SESSION['query_resultante']."<br>";
                        //$cadena = "\"" . $_SESSION['query_resultante'] . "\"";
                        //$consulta->insertpruebasdato($cadena);
                        //echo 'Acabo de insertar en la bd este query = '.$cadena."<br>";
                        //echo "PRESIONE BOTON APROBADOS"."<br>";
                        $result = $consulta->consultapruebasdato();
                        $result = mysqli_fetch_array($result);
                        $query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (insertado) = ".$query_bd."<br>";
                        //echo "inner_viejo = ".$inner_viejo."<br>";
                        //echo "inner_nuevo = ".$inner_nuevo."<br>";
                        //$query_bd = str_replace($inner_viejo,$inner_nuevo,$query_bd);
                        $query_bd = substr_replace($query_bd, $inner_nuevo, 0, 156);
                        //echo "obtengo este query despues de modificar los inner = ".$query_bd."<br>";
                        $condicion = " AND disponibilidades.estado_tramite = 'APROBADOS' AND tipificaciones.estado_registro = 4 GROUP BY tipificaciones.id_disp_cnl";
                        $query_bd .= $condicion;
                        $query_nuevo = $query_bd;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //echo "obtengo este query despues de agregar la condicion = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //} else {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "PRESIONE BOTON APROBADOS"."<br>";
                        //$result = $consulta->consultapruebasdato();
                        //$result = mysqli_fetch_array($result);
                        //$query_bd = $result['cadenacompleta'];
                        //echo "recibo este query desde la bd (consultado) = ".$query_bd."<br>";
                        //echo "inner_viejo = ".$inner_viejo."<br>";
                        //echo "inner_nuevo = ".$inner_nuevo."<br>";
                        //$query_bd = str_replace($inner_viejo,$inner_nuevo,$query_bd);
                        //$query_bd = substr_replace($query_bd, $inner_nuevo, 0, 156);
                        //echo "obtengo este query despues de modificar los inner = ".$query_bd."<br>";
                        //$condicion = " AND disponibilidades.estado_tramite = 'APROBADOS' AND tipificaciones.estado_registro = 4 GROUP BY tipificaciones.id_disp_cnl";
                        //$query_bd .= $condicion;
                        //$query_nuevo = $query_bd;
                        //echo "agrego la condicion al query = ".$query_nuevo."<br>";
                        //echo "obtengo este query despues de agregar la condicion = ".$query_nuevo."<br>";
                        //$_SESSION['control_boton'] = 1;
                    //}

                    break;

                case "canales_caidos":
                    $tipo = "CAIDOS";

                    $query_nuevo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl WHERE disponibilidades.estado_canal LIKE 'DOWN'";

                    if ($_SESSION['control_boton'] == 0) {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        //echo "query_resultante (sesion) = ".$_SESSION['query_resultante']."<br>";
                        //$cadena = "\"" . $_SESSION['query_resultante'] . "\"";
                        //$consulta->insertpruebasdato($cadena);
                        $query_nuevo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl WHERE disponibilidades.estado_canal LIKE 'DOWN'";
                        //echo "obtengo este query despues de agregar la condicion = ".$query_nuevo."<br>";
                        $_SESSION['control_boton'] = 1;
                    } else {
                        //echo "control_boton = ".$_SESSION['control_boton']."<br>";
                        $query_nuevo = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl WHERE disponibilidades.estado_canal LIKE 'DOWN'";
                        //echo "obtengo este query despues de agregar la condicion = ".$query_nuevo."<br>";
                        $_SESSION['control_boton'] = 1;
                    }

                    break;

                case "registros_cargados":
                    $tipo = "CARGADOS";
                    $result = $consulta->consultapruebasdato();
                    $result = mysqli_fetch_array($result);
                    $fecha_desde = $result['fecha_desde'];
                    $fecha_hasta = $result['fecha_hasta'];
                    $hora_desde = $result['hora_desde'];
                    $hora_hasta = $result['hora_hasta'];

                    $fecha_desde = $consulta->obtener_solo_fecha($fecha_desde);
                    $fecha_desde = $consulta->construir_fecha_hora($fecha_desde,$hora_desde);
                    $fecha_hasta = $consulta->obtener_solo_fecha($fecha_hasta);
                    $fecha_hasta = $consulta->construir_fecha_hora($fecha_hasta,$hora_hasta);

                    $query_nuevo = "SELECT fal.id_falla_cnl as id_falla, fal.depart_nombre_cnl as departamento, fal.alias_sede_cnl as sede, fal.fec_ini_falla_cnl as fecha_caida, fal.fec_fin_falla_cnl as fecha_subida, fal.durac_falla_cnl as duracion, dsp.estado_tramite as estado_tigo, dsp.estado_tramite_rnec as estado_rnec  FROM fallas_canales AS fal LEFT JOIN disponibilidad_canales AS dsp ON fal.id_falla_cnl = dsp.id_falla_cnl WHERE fal.fec_ini_falla_cnl BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."' ORDER BY fecha_caida DESC";

                    if ($_SESSION['control_boton'] == 0) {
                        $_SESSION['control_boton'] = 1;
                    }else{
                        $_SESSION['control_boton'] = 1;
                    }

                    break;

                default :
                    break;
            }

        else if (isset($_GET["estado"]))
            $estado = 'Cerrado';
        else
            $tipo = "Monitoreo_IM";

        //echo "query_nuevo (se envia al modelo) = ".$query_nuevo."<br>";
        $im = new IM();
        $divipol = new Divipol();
        $this->consultar();
        $datos_im = $im->show_registros($estado, $tipo, $query_nuevo);
        $numrows = mysqli_num_rows($datos_im);
        // var_dump($numrows);
        $formato = 'Y-m-d H:i:s';
        $fecha_hoy = date_format(date_create(null,timezone_open("America/Bogota")),$formato);

        $data_set = "[";
        if ($numrows > 0) {
            while ($row = mysqli_fetch_array($datos_im)) {

                $apag_contr = $im->get_id_apag_contr_sede($row['id_falla_cnl']);
                $apag_contr = mysqli_fetch_array($apag_contr);
                $apag_contr = $apag_contr['apag_contr'];
                $apag = $apag_contr == 1 ? "SI" : "NO";
                $num_ticket = $im->get_ticket($row['id_falla_cnl']);
                $responsables = $im->get_responsables($row['id_falla_cnl']);
                $observaciones = $im->get_observaciones($row['id_falla_cnl']);
                $conciliado = $im->get_conciliado($row['id_falla_cnl']);
                //   $departamento = mysqli_fetch_array($divipol->get_departamento_by_id($row['depart_nombre_cnl']));   ojo habilitar
                //     $municipio = mysqli_fetch_array($divipol->get_municipio($row['alias_sede_cnl']));                  ojo habilitar
                $data_set .= "[";
                //     $data_set .= "'".$row['reg_ticket_num']."',";
                //$data_set .= "'".$row['reg_tipo_alerta']."',";
                //     $tipo_resgistraduria = @mysqli_fetch_array($im->get_tipo_registraduria($row['reg_tipo_sede']));  // ojo habilitar
                //$data_set .= "'" . $row['id_falla_cnl'] . "',";
                //$data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                //$data_set .= "'" . $row['alias_sede_cnl'] . "',";
                //$data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                //$data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                //$data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                //$data_set .= "'" . $apag . "',";
                //$data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                //$data_set .= "'" . $num_ticket . "',";
                //$data_set .= "'" . $responsables . "',";
                // $data_set .= "'{$bandera}',";
                // $data_set .= "'".$departamento['depart_nombre_cnl']."',";                       // ojo habilitar

//prueba1 


//permisos de edicion en botones de tramites   rol 14 permite a todos ver y editar vista  15 solo tigo y admin
                if ($_GET["tipo"] == 'sin_tramite') {
                    $data_set .= "'" . $row['id_falla_cnl'] . "',";
                    $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                    $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                    //$data_set .= "'" . $apag . "',";
                    $data_set .= "'" . $row['fec_caida_previa']."',";//fecha caida previa canal
                    $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                    $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                    $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                    $data_set .= "'" . $num_ticket . "',";
                    $data_set .= "'" . $responsables . "',";
                    $data_set .= "'<textarea>" . $observaciones . "</textarea>',";
                    $data_set .= "'<span>" . $conciliado . "</span>',";
                    $data_set .= in_array('15', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=editar&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                    $data_set .= "],";

                }

                if (in_array('15', $_SESSION['roles'])) {
                    if ($_GET["tipo"] == 'tramitado') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        //$data_set .= "'" . $apag . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                        $data_set .= "'" . $num_ticket . "',";
                        $data_set .= "'" . $responsables . "',";
                        $data_set .= in_array('14', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=tramitado&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                        $data_set .= "],";
                    }
                }

                if (in_array('32', $_SESSION['roles'])) { //sin tramitar para rol de RNEC
                    if ($_GET["tipo"] == 'tramitado') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        //$data_set .= "'" . $apag . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                        $data_set .= "'" . $num_ticket . "',";
                        $data_set .= "'" . $responsables . "',";
                        $data_set .= in_array('32', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=sin_tramitar_rnec&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                        $data_set .= "],";
                    }
                }

                if (in_array('32', $_SESSION['roles'])) {
                    if ($_GET["tipo"] == 'pendientes') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        //$data_set .= "'" . $apag . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                        $data_set .= "'" . $num_ticket . "',";
                        $data_set .= "'" . $responsables . "',";
                        $data_set .= in_array('32', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=pendientes_rnec&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                        $data_set .= "],";
                    }
                }

                if (in_array('15', $_SESSION['roles'])) {
                    if ($_GET["tipo"] == 'pendientes') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        //$data_set .= "'" . $apag . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                        $data_set .= "'" . $num_ticket . "',";
                        $data_set .= "'" . $responsables . "',";
                        //AQUI VAN LOS NUEVOS CAMPOS DE OBSERVAIONES Y EL BOTON PARA CONCILIAR EL REGISTRO
                        $data_set .= "'<textarea>" . $observaciones . "</textarea>',";
                        $data_set .= "'<span>" . $conciliado . "</span>',";
                        $data_set .= in_array('15', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=pendiente&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                        $data_set .= "],";
                    }
                }

                if (in_array('15', $_SESSION['roles'])) {
                    if ($_GET["tipo"] == 'aprobados') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        //$data_set .= "'" . $apag . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                        $data_set .= "'" . $num_ticket . "',";
                        $data_set .= "'" . $responsables . "',";
                        $data_set .= in_array('15', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=aprobado&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                        $data_set .= "],";
                    }
                }

                if (in_array('32', $_SESSION['roles'])) {
                    if ($_GET["tipo"] == 'aprobados') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        //$data_set .= "'" . $apag . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fec_fin_falla_cnl'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['durac_disp_glob'] . "',"; //duracion falla del canal
                        $data_set .= "'" . $num_ticket . "',";
                        $data_set .= "'" . $responsables . "',";
                        $data_set .= in_array('32', $_SESSION['roles']) ? "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=aprobado&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'" : "'Sin permiso'";
                        $data_set .= "],";
                    }
                }


                if ((in_array('32', $_SESSION['roles'])) || (in_array('15', $_SESSION['roles']))) {


                    if ($_GET["tipo"] == 'canales_caidos') {
                        $data_set .= "'" . $row['id_falla_cnl'] . "',";
                        $data_set .= "'" . $row['depart_nombre_cnl'] . "',";
                        $data_set .= "'" . $row['alias_sede_cnl'] . "',";
                        $data_set .= "'" .$row['fec_caida_previa']."',";//fecha caida previa canal
                        $data_set .= "'" . $row['fec_ini_falla_cnl'] . "',"; //fecha caida canal
                        if($row['fec_caida_previa'] != null){
                            $diferencia_fechas = $im->calcular_diferencia_fechas($row['fec_caida_previa'], $fecha_hoy);
                        }else{
                            $diferencia_fechas = $im->calcular_diferencia_fechas($row['fec_ini_falla_cnl'], $fecha_hoy);
                        }
                        $data_set .= "'" . $diferencia_fechas[0] . "',"; //fecha caida canal
                        //$data_set .= in_array('15',$_SESSION['roles'])?"'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=canales_caidos&id=".$row['id_falla_cnl']."\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'":"'Sin permiso'";
                        $data_set .= "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=canales_caidos&id=" . $row['id_falla_cnl'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'";
                        $data_set .= "],";
                    }

                    if ($_GET["tipo"] == 'registros_cargados') {
                        $data_set .= "'" . $row['id_falla'] . "',";
                        $data_set .= "'" . $row['departamento'] . "',";
                        $data_set .= "'" . $row['sede'] . "',";
                        $data_set .= "'" . $row['fecha_caida'] . "',"; //fecha caida canal
                        $data_set .= "'" . $row['fecha_subida'] . "',"; //fecha subida canal
                        $data_set .= "'" . $row['duracion'] . "',"; //duracion falla del canal
                        $est_tigo = $row['estado_tigo'];
                        $est_rnec = $row['estado_rnec'];
                        if($row['fecha_subida'] == null){
                            $estado_tigo = "CANAL CAIDO";
                            $estado_rnec = "CANAL CAIDO";
                        }else if($est_tigo == null){
                            $estado_tigo = "NO APLICA";
                            $estado_rnec = "NO APLICA";
                        }else{
                            $estado_tigo = $est_tigo;
                            $estado_rnec = $est_rnec;
                        }
                        $data_set .= "'" . $estado_tigo . "',";
                        $data_set .= "'" . $estado_rnec . "',";
                        $data_set .= "'<a class=\"icn_edit_article\" href=\"index.php?contr=Consulta&act=registros_cargados&id=" . $row['id_falla'] . "\"><img src=\"views/default/images/img/icn_edit_article.png\"/></a>'";
                        $data_set .= "],";
                    }
                }


//finprueba1                


                //var_dump($row['reg_responsabilidad']);   
            }
            $data_set .= "],";
            $data_set = str_replace("],],", "]],", $data_set);
            //var_dump($data_set);   
        }

//MUESTRA EXCEL SIN TRAMITAR TIGO
        if (in_array('15', $_SESSION['roles'])) {
            if ($_GET["tipo"] == 'sin_tramite') {
                $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {
                                'data':" . $data_set .
                    "'columns': [
                                   

                                    {'title': 'Departamento'},
                                    {'title': 'Municipio'},
                                    {'title': 'Estado'},
                                    {'title': 'Apagado Controlado'},
                                    {'title': 'Editar'}
                                ],

                //prueba color 
                'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[3] == 'SI' )
                                    {
                                        $('td', row).eq(3).css('background-color', '#4285f4');
                                    }
                                    else if ( data[3] == 'NO')
                                    {
                                        $('td', row).eq(3).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Caida Previa', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Up', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm', 'sWidth': '1%', 'sClass':'center'},
                            {'title': '# de Ticket', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Responsables', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Observaciones', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Conciliar', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}

                        ],

                                \"language\": {
                                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                                    },
                                'dom': 'Bfrtip',
                               'buttons': [                                    
                                    {
                                        text: 'REPORTE DIAS HORARIO EN FALLA',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');
                                            
                                            $.ajax({
                                                type: 'POST',
    
                                                url: 'index.php?contr=Consulta&act=consulta_reporte_dias_horario',
                                          
                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {  
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_dias_horario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);                
                                                }
                                            });
                                            
                                        }
                                    },
                                    {
                                        text: 'REPORTE VALORES DE CANALES',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_valores_canales',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_valores_canales&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE REGISTROS SIN TRAMITAR',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_registros_sin_tramitar',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_registros_sin_tramitar&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE TIPIFICADOS POR USUARIO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_cantidad_tipificados_usuario',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_cantidad_tipificados_usuario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    }
                                ]
                            } ).addClass(\"compact\");
                        } );";
            }
        }

        //COMIENZA CANALES CAIDOS
        if ($_GET["tipo"] == 'canales_caidos') {
            $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {
                                'data':" . $data_set .
                "'columns': [


                    {'title': 'Departamento'},
                    {'title': 'Municipio'},
                    {'title': 'Estado'},
                    {'title': 'Apagado Controlado'},
                    {'title': 'Editar'}
                ],

//prueba color
'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[5] == 'SI' )
                                    {
                                        $('td', row).eq(5).css('background-color', '#4285f4');
                                    }
                                    else if ( data[5] == 'NO')
                                    {
                                        $('td', row).eq(5).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    $('td', row).eq(3).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Caida Previa', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm ', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}
                        ],

                \"language\": {
                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                    },
                'dom': 'Bfrtip',
               'buttons': [
                    {
                        text: 'REPORTE CANALES CAIDOS',
                        action: function ( e, dt, node, config ) {
                            //dt.ajax.reload();
                            //alert('En construcción');

                            $.ajax({
                                type: 'POST',

                                url: 'index.php?contr=Consulta&act=consulta_reporte_canales_caidos',

                                error: function () {
                                    alert('error petición ajax');
                                },
                                async: false,
                                success: function () {
                                    window.open('index.php?contr=Consulta&act=consulta_reporte_canales_caidos&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                ]
                            } ).addClass(\"compact\");
                        } );";
        }
        //FINALIZA CANALES CAIDOS


        //COMIENZA REGISTROS CARGADOS
        if ($_GET["tipo"] == 'registros_cargados') {
            $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {
                                'data':" . $data_set .
                "'columns': [


                    {'title': 'Departamento'},
                    {'title': 'Municipio'},
                    {'title': 'Estado'},
                    {'title': 'Apagado Controlado'},
                    {'title': 'Editar'}
                ],

//prueba color
'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[5] == 'SI' )
                                    {
                                        $('td', row).eq(5).css('background-color', '#4285f4');
                                    }
                                    else if ( data[5] == 'NO')
                                    {
                                        $('td', row).eq(5).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    $('td', row).eq(3).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Up', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Estado TIGO', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Estado RNEC', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}
                        ],

                \"language\": {
                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                    },
                'dom': 'Bfrtip',
               'buttons': [
                    {
                        text: 'REPORTE REGISTROS CARGADOS',
                        action: function ( e, dt, node, config ) {
                            //dt.ajax.reload();
                            //alert('En construcción');

                            $.ajax({
                                type: 'POST',

                                url: 'index.php?contr=Consulta&act=consulta_reporte_registros_cargados',

                                error: function () {
                                    alert('error petición ajax');
                                },
                                async: false,
                                success: function () {
                                    window.open('index.php?contr=Consulta&act=consulta_reporte_registros_cargados&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                ]
                            } ).addClass(\"compact\");
                        } );";
        }
        //FINALIZA REGISTROS CARGADOS

//fin MUESTRA EXCEL SIN TRAMITAR TIGO
        //START TRAMITADO TIGO y sin tramitar rnec
        if (in_array('15', $_SESSION['roles']) || in_array('32', $_SESSION['roles'])) {
            if ($_GET["tipo"] == 'tramitado') {
                $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {                                
                                'data':" . $data_set .
                    "'columns': [

                                    {'title': 'Departamento'},
                                    {'title': 'Municipio'},
                                    {'title': 'Estado'},
                                    {'title': 'Apagado Controlado'},
                                    {'title': 'Editar'}
                                ],  
                //prueba color 
                'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[3] == 'SI' )
                                    {
                                        $('td', row).eq(3).css('background-color', '#4285f4');
                                    }
                                    else if ( data[3] == 'NO')
                                    {
                                        $('td', row).eq(3).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Caida Previa', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Up', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm', 'sWidth': '1%', 'sClass':'center'},
                            {'title': '# de Ticket', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Responsables', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}
                        ],

                                \"language\": {
                                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                                    },
                                'dom': 'Bfrtip',
                               'buttons': [                                    
                                    {
                                        text: 'REPORTE DIAS HORARIO EN FALLA',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_dias_horario',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_dias_horario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FALLAS TIPIFICADAS',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');
                                            
                                            $.ajax({
                                                type: 'POST',
    
                                                url: 'index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas',
                                          
                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {  
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);                
                                                }
                                            });
                                            
                                        }
                                    },
                                    {
                                        text: 'REPORTE REGISTROS PENDIENTES',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE PARCIAL DEL PERIODO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_periodo',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_periodo&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FINAL DEL PERIODO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_aprobado',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_aprobado&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    }
                                ]
                            } ).addClass(\"compact\");   
                        } );";
            }
        }
        //fin TRAMITADO TIGO y sin tramitar rol RNEC


        //START pendientes tigo
        if (in_array('15', $_SESSION['roles'])) {
            if ($_GET["tipo"] == 'pendientes') {
                $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {
                                'data':" . $data_set .
                    "'columns': [


                                    {'title': 'Departamento'},
                                    {'title': 'Municipio'},
                                    {'title': 'Estado'},
                                    {'title': 'Apagado Controlado'},
                                    {'title': 'Editar'}
                                ],
                //prueba color
                'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[3] == 'SI' )
                                    {
                                        $('td', row).eq(3).css('background-color', '#4285f4');
                                    }
                                    else if ( data[3] == 'NO')
                                    {
                                        $('td', row).eq(3).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    //$('td', row).eq(3).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Caida Previa', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Up', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm', 'sWidth': '1%', 'sClass':'center'},
                            {'title': '# de Ticket', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Responsables', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Observaciones', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Conciliar', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}
                        ],

                                \"language\": {
                                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                                    },
                                'dom': 'Bfrtip',
                               'buttons': [
                                    {
                                        text: 'REPORTE DIAS HORARIO EN FALLA',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_dias_horario',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_dias_horario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FALLAS TIPIFICADAS',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE REGISTROS PENDIENTES',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE REGISTROS SIN TRAMITAR',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_registros_sin_tramitar',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_registros_sin_tramitar&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE TIPIFICADOS POR USUARIO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_cantidad_tipificados_usuario',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_cantidad_tipificados_usuario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    }
                                ]
                            } ).addClass(\"compact\");
                        } );";
            }
        }
        //fin pendientes tigo




        //START pendientes rnec
        if (in_array('32', $_SESSION['roles'])) {
            if ($_GET["tipo"] == 'pendientes') {
                $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {                                
                                'data':" . $data_set .
                    "'columns': [
                                   
                                  
                                    {'title': 'Departamento'},
                                    {'title': 'Municipio'},
                                    {'title': 'Estado'},
                                    {'title': 'Apagado Controlado'},
                                    {'title': 'Editar'}
                                ],  
                //prueba color 
                'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[3] == 'SI' )
                                    {
                                        $('td', row).eq(3).css('background-color', '#4285f4');
                                    }
                                    else if ( data[3] == 'NO')
                                    {
                                        $('td', row).eq(3).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    //$('td', row).eq(3).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Caida Previa', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Up', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm', 'sWidth': '1%', 'sClass':'center'},
                            {'title': '# de Ticket', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Responsables', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}
                        ],

                                \"language\": {
                                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                                    },
                                'dom': 'Bfrtip',
                               'buttons': [                                    
                                    {
                                        text: 'REPORTE DIAS HORARIO EN FALLA',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_dias_horario',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_dias_horario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FALLAS TIPIFICADAS',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE REGISTROS PENDIENTES',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE PARCIAL DEL PERIODO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_periodo',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_periodo&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FINAL DEL PERIODO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_aprobado',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_aprobado&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    }

                                ]
                            } ).addClass(\"compact\");   
                        } );";
            }
        }
        //fin pendientes tigo rnec

        //START aprobados tigo rnec 
        if (in_array('15', $_SESSION['roles']) || in_array('32', $_SESSION['roles'])) {
            if ($_GET["tipo"] == 'aprobados') {
                $script_insert = "$(document).ready(function() {
                            $('#example').dataTable( {                                
                                'data':" . $data_set .
                    "'columns': [
                                   
                                  
                                    {'title': 'Departamento'},
                                    {'title': 'Municipio'},
                                    {'title': 'Estado'},
                                    {'title': 'Apagado Controlado'},
                                    {'title': 'Editar'}
                                ],  
                //prueba color 
                'createdRow': function( row, data, dataIndex ) {
                                  //  alert(data[3]);
                                    if ( data[5] == 'UP' )
                                    {
                                        $('td', row).eq(5).css('background-color', '81c784');
                                    }
                                    else if ( data[5] == 'DOWN')
                                    {
                                        $('td', row).eq(5).css('background-color', '#e53935');
                                    }
                                    if ( data[3] == 'SI' )
                                    {
                                        $('td', row).eq(3).css('background-color', '#4285f4');
                                    }
                                    else if ( data[3] == 'NO')
                                    {
                                        $('td', row).eq(3).css('background-color', '#fb3');
                                    }
                                    $('td', row).eq(2).css('background-color', '#fff6f6');
                                    //$('td', row).eq(3).css('background-color', '#fff6f6');
                                    $('td', row).eq(4).css('background-color', '#f5fff6');
                                },
//fin prueba color
                'scrollY': 550,
                'scrollX': true,
                'paging': false,
                'bJQueryUI': true,
                'bAutoWidth': false,
                'aoColumns' : [

                            {'title': 'ID Falla', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Departamento', 'sWidth': '2%', 'sClass':'center'},
                            {'title': 'Sede', 'sWidth': '7%', 'sClass':'center'},
                            {'title': 'Fecha Caida Previa', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Down', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Fecha Canal Up', 'sWidth': '6%', 'sClass':'center'},
                            {'title': 'Duracion falla hh:mm', 'sWidth': '1%', 'sClass':'center'},
                            {'title': '# de Ticket', 'sWidth': '3%', 'sClass':'center'},
                            {'title': 'Responsables', 'sWidth': '1%', 'sClass':'center'},
                            {'title': 'Revisar', 'sWidth': '1%', 'sClass':'center'}
                        ],

                                \"language\": {
                                    \"url\": \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json\"
                                    },
                                'dom': 'Bfrtip',

                                 'buttons': [
                                    {
                                        text: 'REPORTE DIAS HORARIO EN FALLA',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_dias_horario',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_dias_horario&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FALLAS TIPIFICADAS',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_fallas_tipificadas&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE REGISTROS PENDIENTES',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_pendiente&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE PARCIAL DEL PERIODO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_periodo',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_periodo&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    },
                                    {
                                        text: 'REPORTE FINAL DEL PERIODO',
                                        action: function ( e, dt, node, config ) {
                                            //dt.ajax.reload();
                                            //alert('En construcción');

                                            $.ajax({
                                                type: 'POST',

                                                url: 'index.php?contr=Consulta&act=consulta_reporte_final_periodo_aprobado',

                                                error: function () {
                                                    alert('error petición ajax');
                                                },
                                                async: false,
                                                success: function () {
                                                    window.open('index.php?contr=Consulta&act=consulta_reporte_final_periodo_aprobado&tipo=" . $tipo . "','_blank');
                                                    //alert(data);
                                                    //var target = $('body').find('div#target');
                                                    //target.children('div.control-group').remove();
                                                    //target.append(data);
                                                }
                                            });

                                        }
                                    }
                                ]
                            } ).addClass(\"compact\");   
                        } );";
            }
        }
        //fin aprobados tigo rnec


        $ruta = $this->view->path('default/page2.php');
        //carga la plantilla 
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Consultar Registro ' . $estado, $pagina);
        $contenido = $this->view->load_page($config->get('contenido') . 'tabla.php');
        //$pagina = $this->view->load_content();

        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        //cargar el Script para generar la trabla
        $pagina = $this->view->replace_content('/\<!--script-->/ms', $script_insert, $pagina);
        $this->view->view_page($pagina);

    }

    function listar($estado, $tipo)
    {
        $this->index($estado, $tipo);
    }



    function registros_cargados($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_basico($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_basico($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_basico($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Consultar registro cargado', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if($numrows > 0){
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            //$dt= $im_regitro['durac_disp_glob'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            //$notas = $this->get_notas_aprobadas($id);
            //$notas_rnec = $this->get_notas_rnec($id);
            $fallas = $consulta_class->get_fallas();
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if($fechas!="")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if($notas!="")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if($im_regitro['reg_ticket_proveedor']!="")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if($im_regitro["reg_estado"]=='Cerrado')
                include $config->get('contenido').'im_cerrado.php';
            else
                include $config->get('contenido').'im_registros_cargados.php';
            $im_registros_cargados = ob_get_clean();
            //realiza el parseado
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_registros_cargados, $pagina);
            //var_dump($im_regitro);
        }else{//si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms' ,'<h1>No existen resultados aca zona aprobado</h1>' , $pagina);
        }
        //ob_start();
        //$im_editar_aprobado = ob_get_clean();
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_registros_cargados, $pagina);
        $contenido = $this->view->load_page('views/content/im_canales_caidos.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function nuevaConsulta()
    {


        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/nueva_consulta.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function admonusers(){
        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();

        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_usuario.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }

    function buscar_usuario(){
        $consulta_class = new IM();
        $correo = $_POST['cons_user'];

        //echo "ESTOY BUSCANDO EL USUARIO CON EL CORREO = ".$correo."<br>";
        $respuesta = $consulta_class->consultar_user($correo);
        $user_encontrado = $respuesta[0];
        $datos_user = $respuesta[1];
        $user_match = "";
        $user_find = "";
        $user_sesion = $_SESSION["usuario"];
        if($user_encontrado == true){
            $user_find = $datos_user['loginUsers'];
        }

        //echo "USUARIO EN SESION = ".$user_sesion."<br>";
        //echo "USUARIO CONSULTADO = ".$user_find."<br>";

        if($user_sesion == $user_find){
            //echo "USUARIOS **SI** COINCIDEN";
            $user_match = true;
        }else{
            //echo "USUARIOS **NO** COINCIDEN";
            $user_match = false;
        }
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();

        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_usuario.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);

    }


    function guardar_usuario(){
        $consulta_class = new IM();
        $id_user = $_POST['id_user'];
        $email_user = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $resultado = $consulta_class->actualizar_user($id_user,$email_user,$username,$password);
        enviar_cambio_usuario($email_user,$username);
        $actualizadoUser = true;

        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_usuario.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function nuevo_usuario(){
        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/nuevo_usuario.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function agregar_usuario(){
        $consulta_class = new IM();
        $email = strtolower($_POST['email']);
        $username = strtolower($_POST['username']);
        $password = $_POST['password'];
        $perfil = $_POST['perfil'];
        enviar_nuevo_usuario($email,$username,$perfil);
        $resultado = $consulta_class->agregar_nuevo_usuario($email,$username,$password);
        $agregado_user = true;

        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/nuevo_usuario.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }



    function admonsedes()
    {
        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_sede.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function buscar_sedes(){
        $consulta_class = new IM();
        $criterio = $_POST['cons_sede'];

        //echo "ESTOY BUSCANDO LA SEDE CON EL CRITERIO = ".$criterio."<br>";
        $respuesta = $consulta_class->consultar_sedes($criterio);
        $encontradas = $respuesta[0];
        $coincidentes = $respuesta[1];

        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_sede.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function seleccionar_sede(){
        $seleccionada = $_GET['id'];
        $consulta_class = new IM();
        $divipol = new Divipol();

        $ap_false = "";
        $ap_true = "";
        $respuesta = $consulta_class->buscar_sede($seleccionada);
        $alias = $respuesta['alias_sede'];
        $apagado = $respuesta['apag_contr'];
        if($apagado == 0){
            $ap_false = "selected";
        }else{
            $ap_true = "selected";
        }
        $valor = $respuesta['valor_serv_canal'];
        $depto = $consulta_class->buscar_departamento($respuesta['id_depart']);
        $departamentos = $divipol->list_departamento();

        echo "<form id='editar_sede' class='form-horizontal' action='index.php?contr=Consulta&act=guardar_sede' method='post'>";
        echo "<center><br/><legend>Editar sede</legend><center>";
        echo "<div class='form-group'>";
        echo "<input id='id_sede' name='id_sede' type='hidden' value='".$seleccionada."'>";
        echo "<br><label class='control-label col-sm-6' for='alias_sede'>Nombre de la sede</label>";
        echo "<div class='col-sm-6'><input class='form-control' id='alias_sede' name='alias_sede' type='text' value='".$alias."' disabled required></div>";
        echo "<br><label class='control-label col-sm-4' for='valor_canal'>Valor del canal</label>";
        echo "<div class='col-sm-4'><input class='form-control' id='valor_canal' name='valor_canal' type='number' min='0' value='".$valor."' disabled></div>";
        echo "<br><label class='control-label col-sm-4' for='apag_contr'>Apagado controlado</label>";
        echo "<select class='form-control col-sm-2' id='apag_contr' name='apag_contr' disabled>";
        echo "<option value='0' ".$ap_false.">NO</option>";
        echo "<option value='1' ".$ap_true.">SI</option>";
        echo "</select>";
        echo "<br><label class='control-label col-sm-4' for='depto_asoc'>Departamento</label>";
        echo "<select class='form-control col-sm-3' id='depto_asoc' name='depto_asoc' disabled>";
        echo "<option value='{$respuesta['id_depart']}' selected>{$depto}</option>";
        while($row=mysqli_fetch_array($departamentos)){
            echo "<option value='{$row['departamento_id']}'>{$row['departamento_nombre']}</option>";
        }
        echo "</select>";
        echo "<br><button id='actualizar_sede' class='btn btn-danger' style='display:none;'>Guardar sede</button>";
        echo "</div>";
        echo "</form>";
    }


    function guardar_sede(){
        $consulta_class = new IM();
        $id_sede = $_POST['id_sede'];
        $al_sede = $_POST['alias_sede'];
        $vr_canal = $_POST['valor_canal'];
        $ap_contr = $_POST['apag_contr'];
        $id_depto = $_POST['depto_asoc'];
        $depto_asoc = $consulta_class->buscar_departamento($id_depto);
        $resultado = $consulta_class->actualizar_sede($al_sede,$vr_canal,$ap_contr,$id_depto,$id_sede);
        enviar_cambio_sede($al_sede,$ap_contr,$depto_asoc);
        $actualizado = true;
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_sede.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }

    function nueva_sede(){
        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/nueva_sede.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function agregar_sede(){
        $consulta_class = new IM();
        $nombre_sede = strtoupper($_POST['nombre_sede']);
        $valor_canal = $_POST['valor_canal'];
        $apag_contr = $_POST['apag_contr'];
        $id_depto = $_POST['depto_asoc'];
        $depto_asoc = $consulta_class->buscar_departamento($id_depto);
        enviar_nueva_sede($nombre_sede,$valor_canal,$apag_contr,$depto_asoc);
        $resultado = $consulta_class->agregar_nueva_sede($nombre_sede,$valor_canal,$apag_contr,$id_depto);
        $agregado = true;

        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/nueva_sede.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function editar_valores(){
        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        /*            foreach($departamentos  as $depart){
                    echo var_dump($depart)."<br>";
                }*/


        //require 'controller/ConsultaController.php';

        //      $control_botones = 1000;
        //     echo "en la pagina de consulta el control queda en = ".$control_botones."<br>";

        /*            while($row=mysqli_fetch_array($departamentos)){
                    echo $row['departamento_id']." - ".$row['departamento_nombre']."<br>";
                }*/
        $fallas = $consulta_class->get_fallas();
        $ruta = $this->view->path('default/page.php');
        $pagina = $this->view->load_page($ruta);

        /*            $path = "views/default/js/script_datepicker.js";
                $load_script = $this->view->load_script($path);
                $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/


        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/consulta.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/criterios_consulta.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $pagina = $this->view->load_template('Consulta Criterios ', $pagina);

        ob_start();
        include 'views/content/editar_valores.php';
        $contenido = ob_get_clean();

        // $login = $this->view->load_page('views/content/nueva_consulta.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }


    function actualizar_valores(){
        //echo "ENTRO AL METODO actualizar_valores"."<br>";
        //echo "RECIBO LAS VARIABLES"."<br>";
        $consulta_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();

        $valor_asignado = $_POST['valor_asignado'];
        $seleccionadas = $_POST['sedes_act'];


        $valores_act = true;

        $lista_val_sedes_act = $consulta_class->actualizar_valores($valor_asignado,$seleccionadas);
        enviar_nuevos_valores($lista_val_sedes_act);

    }

    function nuevo()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $im_class = new IM();
        $divipol = new Divipol();
        $departamentos = $divipol->list_departamento();
        $fallas = $im_class->get_fallas();
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla
        $pagina = $this->view->load_page($ruta);

        //Cargar script
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/select_dependientes.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/consulta_otrs.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js?t=" . time();
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS


        $path = "views/default/css/bootstrap.css"; //estoy habilitando esta parte de carga del boostrap
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Nuevo IM', $pagina);
        $nota_visibilidad = 'none';
        $proveedor_visibilidad = 'none';
        ob_start();
        include 'views/content/im_nuevo.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);

        $this->view->view_page($pagina);
    }


    function guardar()
    {
        @session_start();
        /********************************************************************************/
        /***************DESDE AQUI GUARDO LOS DATOS DEL REGISTRO TIPIFICADO**************/
        /********************************************************************************/
        $consulta_class = new IM();
        $id = $_GET['id'];
        $mth = $_GET['mth'];
        $resultado = $consulta_class->get_id_disp_canal($_GET['id']);
        $resultado = mysqli_fetch_array($resultado);
        $tipificado['id_disp_cnl'] = $resultado['id_disp_cnl'];
        $tipificado['horar_tipif'] = $_POST['horar_tipif'];
        $tipificado['horar_desde_tipif'] = $_POST['horar_desde_tipif'];
        $tipificado['horar_hasta_tipif'] = $_POST['horar_hasta_tipif'];
        $fechaDesde = $_POST['fecha_inicial_proveedor'] . " " . $_POST['desdeHor'] . ":" . $_POST['desdeMin'];
        $tipificado['fec_ini_falla_tpf'] = $this->obtener_fecha_completa($fechaDesde);
        $fechaHasta = $_POST['fecha_final_proveedor'] . " " . $_POST['hastaHor'] . ":" . $_POST['hastaMin'];
        $tipificado['fec_fin_falla_tpf'] = $this->obtener_fecha_completa($fechaHasta);
        $tipificado['id_tipo_falla'] = $_POST['tipo_falla'];
        $tipificado['durac_falla_tpf'] = $_POST['duracion'];
        $tipificado['numero_ticket'] = $_POST['numero_ticket'];
        $tipificado['observ_falla_tpf'] = $_POST['falla_observacion'];
        if($mth == 'editar'){
            $tipificado['estado_registro'] = 2; //EL 2 SIGNIFICA QUE EL REGISTRO TIPIFICADO HA SIDO TRAMITADO Y ENVIADO A CONCILIACION
        }
        if($mth == 'pendiente'){
            $tipificado['estado_registro'] = 3; //EL 2 SIGNIFICA QUE EL REGISTRO TIPIFICADO HA SIDO TRAMITADO Y ENVIADO A CONCILIACION
        }

        //echo "id_falla_cnl = ".$id."<br>";
        //echo "id_disp_cnl = ".$tipificado['id_disp_cnl']."<br>";
        //echo "fec_ini_falla_tpf = ".$tipificado['fec_ini_falla_tpf']."<br>";
        //echo "fec_fin_falla_tpf = ".$tipificado['fec_fin_falla_tpf']."<br>";
        //echo "id_tipo_falla = ".$tipificado['id_tipo_falla']."<br>";
        //echo "durac_falla_tpf = ".$tipificado['durac_falla_tpf']."<br>";
        //echo "numero_ticket = ".$tipificado['numero_ticket']."<br>";
        //echo "observ_falla_tpf = ".$tipificado['observ_falla_tpf']."<br>";
        $id_falla_prv = $consulta_class->set_tipificacion($tipificado);
        //$fec_ini_periodo = $this->obtener_fecha_completa($fechaDesde);
        //$fec_fin_periodo = $this->obtener_fecha_completa($fechaHasta);
        //$resultado = $consulta_class->get_id_apag_contr_sede($id);
        //$resultado = mysqli_fetch_array($resultado);
        //$apag_contr = $resultado['apag_contr'];
        //$id_sede = $resultado['id_sede'];
        //$id_falla = $tipificado['id_tipo_falla'];
        //$horario_aplicado = $consulta_class->get_horario_aplicado($id);
        //$horario_aplicado = mysqli_fetch_array($horario_aplicado);
        //$horario_aplicado = $horario_aplicado['horario_aplicado'];
        //echo "fec_ini_periodo = ".$fec_ini_periodo."<br>";
        //echo "fec_fin_periodo = ".$fec_fin_periodo."<br>";
        //echo "apag_contr = ".$apag_contr."<br>";
        //echo "id_sede = ".$id_sede."<br>";
        //echo "id_falla = ".$id_falla."<br>";
        //echo "horario_aplicado = ".$horario_aplicado."<br>";
        $consulta_class->set_tiempo_periodo($id_falla_prv);

        /********************************************************************************/
        /***************HASTA AQUI GUARDO LOS DATOS DEL REGISTRO TIPIFICADO**************/
        /********************************************************************************/

        /*        $im["ticket_num"] = @$_POST["ticket"];
        $im["ticket_id"] = @$_POST["ticket_id"];
        $im["tipo_sede"] = @$_POST["tipo_sede"];
        $im["tipo_alerta"] = @$_POST["tipo_enlace"];
        //$im["sede"] = @$_POST["sede"];
        $im["departamento_id"] = @$_POST["departamento_id"];
        $im["municipio_id"] = @$_POST["municipio_id"];
        $im["fecha_creacion"] = @$_POST["fecha_creado"]. " ". @$_POST["hora_creado"]. ":" . @$_POST["minuto_creado"];
        //var_dump(@$_POST["fecha_creado"]);
        $im["fecha_creacion"] = date_format(date_create($im["fecha_creacion"]), 'Y-m-d H:i:s');
    
        $im["fecha_cierre"] = (@$_POST["fecha_cierre"]!="")?date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d'):'';
        //$im["fecha_cierre"] = @$_POST["fecha_cierre"];
        $im["fecha_solucion"] = '';
        if(@$_POST["fecha_solucion"]!=''){
            $im["fecha_solucion"] = @$_POST["fecha_solucion"]. " ". @$_POST["hora_cierre_2"]. ":" . @$_POST["minuto_cierre_2"];
            $im["fecha_solucion"] = date_format(date_create($im["fecha_solucion"]), 'Y-m-d H:i:s');            
        }
    
        //$im["cola"] = @$_POST["cola"];
        $im["estado"] = @$_POST["estado"];
        $im["cliente"] = @$_POST["cliente"];
        $im["tipo"] = @$_POST["tipo"];
        $im["ticket_num_proveedor"] = @$_POST["ticket_proveedor"];
        $im["fecha_creacion_proveedor"] ='';
        $im["fecha_solucion_proveedor"] = '';
        if($im["ticket_num_proveedor"] !=''){
            if(@$_POST["fecha_proveedor"]!=''){
                $im["fecha_creacion_proveedor"] = @$_POST["fecha_proveedor"]. " ". @$_POST["hora_proveedor"]. ":" . @$_POST["minuto_proveedor"];
                $im["fecha_creacion_proveedor"] = date_format(date_create($im["fecha_creacion_proveedor"]), 'Y-m-d H:i:s');            
            }       
            if(@$_POST["fecha_proveedor_2"]!=''){
                $im["fecha_solucion_proveedor"] = @$_POST["fecha_proveedor_2"]. " ". @$_POST["hora_proveedor_2"]. ":" . @$_POST["minuto_proveedor_2"];
                $im["fecha_solucion_proveedor"] = date_format(date_create($im["fecha_solucion_proveedor"]), 'Y-m-d H:i:s');            
            }
        }  */

        //$im["observacion"] = preg_replace("/\r\n+|\r+|\n+|\t+/i", "⌂Ç", @$_POST["observacion"]);
        //$im["observacion"] = @$_POST["observacion"];

        //$im_class = new IM();
        //$im_class->new_registro($im, $_SESSION["id_user"]);
        //$id = mysqli_fetch_array($im_class->get_im_id($im["ticket_num"]));
        //$id = $id['reg_id'];

        //var_dump($_POST["ticket"]); //quitar esto
        /**
         * Se determina si hay nueva nota
         */

        /*        $nueva_nota = isset($_POST["nueva_nota_estado"])?$_POST["nueva_nota_estado"]:'';
        if($nueva_nota == '1'){
            $nota = array();
            $falla = $_POST['tipo_falla'];
            $observ = $_POST['nota_observacion'];
            //var_dump($observ);
            date_default_timezone_set("America/Bogota");
            $fecha_nota = date("Y-m-d H:i:s");
            if($_POST['nota_fecha_creado_nuevo']!=''){
                $fecha_nota = @$_POST["nota_fecha_creado_nuevo"]. " ". @$_POST["nota_hora_creado_nuevo"]. ":" . @$_POST["nota_minuto_creado_nuevo"];
                $fecha_nota = @date_format(date_create($fecha_nota), 'Y-m-d H:i:s');                
            }
            $nota['falla'] = $falla;
            $nota['ticket'] = $id;
            $nota['fecha'] = $fecha_nota;
            $nota['fecha_creado']= date("Y-m-d H:i:s");
            $nota['observacion'] = $observ;
            $nota['usuario'] = $_SESSION["id_user"];            
            $im_class->new_nota($nota);                        
        }*/

        /*DEFINO HACIA QUE VISTA SE DEBE DIRECCIONAR DEPENDIENDO DEL TIPO DE GUARDADO SE ESTA HACIENDO*/
        if ($mth == 'editar') {
            $this->editar($id);
        }
        if ($mth == 'pendiente') {
            $this->pendiente($id);
        }

        /*if(@$_POST["estado"]=='Cerrado')
            $this->listar(@$_POST["estado"], $tipo='');
        else
            $this->listar($estado='', @$_POST["tipo*/
    }

    function guardar_conciliar_tigo()
    {
        @session_start();
        /********************************************************************************/
        /***************DESDE AQUI GUARDO LOS REGISTROS QUE HAN SIDO CONCILIADOS DESDE SIN TRAMITAR.**************/
        /********************************************************************************/
        $consulta_class = new IM();
        $id = $_GET['id'];
        $mth = $_GET['mth'];
        $resultado = $consulta_class->get_id_disp_canal($_GET['id']);
        $resultado = mysqli_fetch_array($resultado);
        $tipificado['id_disp_cnl'] = $resultado['id_disp_cnl'];
        /*$fechaDesde = $_POST['fecha_inicial_proveedor']." ".$_POST['desdeHor'].":".$_POST['desdeMin'];
        $tipificado['fec_ini_falla_tpf'] = $this->obtener_fecha_completa($fechaDesde);
        $fechaHasta = $_POST['fecha_final_proveedor']." ".$_POST['hastaHor'].":".$_POST['hastaMin'];
        $tipificado['fec_fin_falla_tpf'] = $this->obtener_fecha_completa($fechaHasta);
        $tipificado['id_tipo_falla'] = $_POST['tipo_falla'];
        $tipificado['durac_falla_tpf'] = $_POST['duracion'];
        $tipificado['observ_falla_tpf'] = $_POST['falla_observacion'];
        $tipificado['estado_registro'] = 2; //EL 2 SIGNIFICA QUE EL REGISTRO TIPIFICADO HA SIDO TRAMITADO Y ENVIADO A CONCILIACION
        $consulta_class->set_tipificacion($tipificado);*/
        $id_fallas = $consulta_class->get_id_fallas_tipificadas($tipificado['id_disp_cnl']);
        $apag_contr = $consulta_class->get_id_apag_contr_sede($id);
        $apag_contr = mysqli_fetch_array($apag_contr);
        $id_sede = $apag_contr['id_sede'];
        $apag_contr = $apag_contr['apag_contr'];
        $cant_fallas = count($id_fallas);
        $responsables_tigo = 0;
        $responsables_otros = 0;

        for($i=0;$i<$cant_fallas;$i++){
            $resultado = $consulta_class->get_falla_tipificada_por_id($id_fallas[$i]);
            $resultado = mysqli_fetch_array($resultado);
            $id_tipo_falla = $resultado['id_tipo_falla'];
            $responsable = $consulta_class->get_responsable_falla($id_tipo_falla);
            $im_regitro['id_falla_prv'] = $id_fallas[$i];
            //echo "id_falla_prv = ".$im_regitro['id_falla_prv']."<br>";

            if(($responsable == "TIGO")||($responsable == "TIGO / RNEC")){
                $responsables_tigo++;
                //echo "EL RESPONSABLE DE ESTA FALLA ES = ".$responsable."<br>";
                $im_regitro['id_disp_cnl'] = $tipificado['id_disp_cnl'];
                $im_regitro['nota_observacion'] = "FALLA TIPIFICADA Y EVALUADA POR TIGO IDENTIFICADA CON ID = ".$id;
                $im_regitro['horar_eval'] = $resultado['horario_aplicado'];
                $im_regitro['horar_desde_eval'] = $resultado['hora_desde'];
                $im_regitro['horar_hasta_eval'] = $resultado['hora_hasta'];
                $im_regitro['aplica_resarc'] = "SI";
                if(($resultado['num_ticket'] != "")||($resultado['num_ticket'] != null)){
                    $im_regitro['falla_justif'] = "SI";
                }else{
                    $im_regitro['falla_justif'] = "NO";
                }

                //echo "id_disp_cnl = ".$im_regitro['id_disp_cnl']."<br>";
                //echo "nota_observacion = ".$im_regitro['nota_observacion']."<br>";
                //echo "horar_eval = ".$im_regitro['horar_eval']."<br>";
                //echo "horar_desde_eval = ".$im_regitro['horar_desde_eval']."<br>";
                //echo "horar_hasta_eval = ".$im_regitro['horar_hasta_eval']."<br>";
                //echo "aplica_resarc = ".$im_regitro['aplica_resarc']."<br>";
                //echo "falla_justif = ".$im_regitro['falla_justif']."<br>";
                $consulta_class->set_nota_conciliacion($im_regitro);
                $consulta_class->set_tiempo_resarcimiento($im_regitro,$tipificado['id_disp_cnl'],$apag_contr,$id_sede,$id);

                if(($responsables_otros == 0)&&($responsables_tigo > 0)){
                    //echo "EXISTE POR LO MENOS UNA FALLA TIPIFICADA PARA TIGO, POR LO TANTO ESTE REGISTRO QUEDA EN APROBADOS"."<br>";
                    $consulta_class->set_estado_falla_aprobada($im_regitro['id_falla_prv']);
                }
                if($responsables_otros > 0){
                    //echo "A PARTE DE LA FALLA DE TIGO EXISTEN MAS FALLAS CON OTROS RESPONSABLES, POR LO TANTO ESTE REGISTRO QUEDA EN TRAMITADOS"."<br>";
                    $consulta_class->set_estado_falla_tramitado($im_regitro['id_falla_prv']);
                }

            }else{
                $responsables_otros++;
                //echo "EL RESPONSABLE DE ESTA FALLA ES = ".$responsable."<br>";
                $consulta_class->set_estado_falla_tramitado($im_regitro['id_falla_prv']);
            }

        }
        //echo "responsables_tigo = ".$responsables_tigo."<br>";
        //echo "responsables_otros = ".$responsables_otros."<br>";

        if($responsables_tigo == $cant_fallas){
            //echo "LA FALLA ES CONCILIADA Y SE MUESTRE EN EL AREA DE REGISTROS APROBADOS"."<br>";
            $consulta_class->set_estado_aprobados($tipificado['id_disp_cnl']);
        }else{
            //echo "LA FALLA ES CONCILIADA Y SE MUESTRE EN EL AREA DE REGISTROS TRAMITADOS"."<br>";
            $consulta_class->set_estado_tramitados($tipificado['id_disp_cnl']);
        }

        if($mth == 'grid'){
            header("Location: ../resarcimientos/index.php?contr=Consulta&tipo=sin_tramite");
            //$this->editar($id);
        }else if($mth == 'pend'){
            header("Location: ../resarcimientos/index.php?contr=Consulta&tipo=pendientes");
        }
        else{
            header("Location: ../resarcimientos/index.php?contr=Consulta&act=index");
            $this->editar($id);
        }




    }


    function actualizar()
    {
        //session_start();
        $id = @$_POST["id"];
        /*$im["ticket_num"] = @$_POST["ticket"];
        $im["tipo_sede"] = @$_POST["tipo_sede"];
        $im["sede"] = @$_POST["sede"];  
        $im["fecha_creacion"] = "";
        if(@$_POST["fecha_creado"]!=""){
            $im["fecha_creacion"] = @$_POST["fecha_creado"]. " ". @$_POST["hora_creado"]. ":" . @$_POST["minuto_creado"];
            $im["fecha_creacion"] = date_format(date_create($im["fecha_creacion"]), 'Y-m-d H:i:s');             
        }   */

        /*LINEA ACTUAL*/
        $im["fecha_cierre"] = (@$_POST["fecha_cierre"] != "") ? date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d') : '';


        /*LINEA DE PRUEBA*/
        //$im["fecha_cierre"] = $_POST["fecha_cierre"]!="" ? date("Y-m-d",strtotime($_POST["fecha_cierre"])) : '';


        $im["fecha_solucion"] = '';
        if (@$_POST["fecha_solucion"] != '') {
            date_default_timezone_set("America/Bogota");
            $im["fecha_solucion"] = @$_POST["fecha_solucion"] . " " . @$_POST["hora_cierre_2"] . ":" . @$_POST["minuto_cierre_2"];

            /*LINEA ACTUAL*/
            $im["fecha_solucion"] = date_format(date_create($im["fecha_solucion"]), 'Y-m-d H:i:s');

            /*LINEA DE PRUEBA*/
            //$im["fecha_solucion"] = date_format($im["fecha_solucion"],'Y-m-d H:i:s');       
        }


        $im["cola"] = @$_POST["cola"];
        $im["estado"] = @$_POST["estado"];
        //$im["cliente"] = @$_POST["cliente"];
        //$im["tipo"] = @$_POST["tipo"];
        $im["falla"] = @$_POST["falla"];
        $im["ticket_num_proveedor"] = trim(@$_POST["ticket_proveedor"]);
        $im["fecha_creacion_proveedor"] = '';
        $im["fecha_solucion_proveedor"] = '';
        $im["ticket_num_proveedor"] = @$_POST["ticket_proveedor"];
        if ($im["ticket_num_proveedor"] != '') {
            //$im["ticket_num_proveedor"] = @$_POST["ticket_proveedor"];
            if (@$_POST["fecha_proveedor"] != '') {
                $im["fecha_creacion_proveedor"] = @$_POST["fecha_proveedor"] . " " . @$_POST["hora_proveedor"] . ":" . @$_POST["minuto_proveedor"];
                $im["fecha_creacion_proveedor"] = date_format(date_create($im["fecha_creacion_proveedor"]), 'Y-m-d H:i:s');
            }
            if (@$_POST["fecha_proveedor_2"] != '') {
                $im["fecha_solucion_proveedor"] = @$_POST["fecha_proveedor_2"] . " " . @$_POST["hora_proveedor_2"] . ":" . @$_POST["minuto_proveedor_2"];
                $im["fecha_solucion_proveedor"] = date_format(date_create($im["fecha_solucion_proveedor"]), 'Y-m-d H:i:s');
            }

        }
        /*
        else{
           $im["ticket_num_proveedor"] = 0;
           $im["fecha_creacion_proveedor"] = '0001-01-01 00:00:00';
           $im["fecha_solucion_proveedor"] = NULL;
        }
*/


        //$im["responsabilidad"] = @$_POST["responsabilidad"];        
        //$im["observacion"] = preg_replace("/\r\n+|\r+|\n+|\t+/i", "⌂Ç", @$_POST["observacion"]);
        //$im["observacion"] = @$_POST["observacion"];
        $im_class = new IM();

        /**
         * Aqui se evalua si hay fechas adicionales en el registro IM
         *
         */
        $cambio_nueva_fecha = @$_POST["fecha_nueva_estado"];
        if ($cambio_nueva_fecha == 1) {
            $im["fecha_creacion_nuevo"] = @$_POST["fecha_creado_nuevo"] . " " . @$_POST["hora_creado_nuevo"] . ":" . @$_POST["minuto_creado_nuevo"];
            $im["fecha_creacion_nuevo"] = date_format(date_create($im["fecha_creacion_nuevo"]), 'Y-m-d H:i:s');
            $fecha = array('registro_id' => $id, 'fecha_creacion' => date("Y-m-d H:i:s"), 'fecha_actualizacion' => date("Y-m-d H:i:s"), 'fecha_apertura' => $im["fecha_creacion_nuevo"]);
            $im_class->new_fechas_registro($fecha);
        }

        /**
         * Se determina si hay se va actualizar una fecha
         */

        $fecha_id_valor = isset($_POST["fecha_id_valor"]) ? $_POST["fecha_id_valor"] : '';
        if ($fecha_id_valor != '') {
            /*var_dump(@$_POST["fecha_creacion_"]. " ". @$_POST["hora_creacion_"]. ":" . @$_POST["minuto_creacion_"]);
            $im["fecha_creacion_"] = @$_POST["fecha_creacion_"]. " ". @$_POST["hora_creacion_"]. ":" . @$_POST["minuto_creacion_"];
            $im["fecha_creacion_"] = date_format(date_create($im["fecha_creacion_"]), 'Y-m-d H:i:s');*/
            $im["fecha_solucion_"] = @$_POST["fecha_solucion_"] . " " . @$_POST["hora_solucion_"] . ":" . @$_POST["minuto_solucion_"];
            $im["fecha_solucion_"] = date_format(date_create($im["fecha_solucion_"]), 'Y-m-d H:i:s');
            $fecha = array('fecha_id' => $fecha_id_valor, 'registro_id' => $id, 'fecha_actualizacion' => date("Y-m-d H:i:s"), 'fecha_cierre' => $im["fecha_solucion_"]);
            $im_class->update_fechas_registro($fecha);
        }

        /**
         * Se determina si hay nueva nota
         */

        $nueva_nota = isset($_POST["nueva_nota_estado"]) ? $_POST["nueva_nota_estado"] : '';
        if ($nueva_nota == '1') {
            $nota = array();
            $falla = $_POST['tipo_falla'];
            $observ = $_POST['nota_observacion'];
            //var_dump($observ);
            date_default_timezone_set("America/Bogota");
            $fecha_nota = date("Y-m-d H:i:s");
            if ($_POST['nota_fecha_creado_nuevo'] != '') {
                $fecha_nota = @$_POST["nota_fecha_creado_nuevo"] . " " . @$_POST["nota_hora_creado_nuevo"] . ":" . @$_POST["nota_minuto_creado_nuevo"];
                $fecha_nota = date_format(date_create($fecha_nota), 'Y-m-d H:i:s');
            }
            $nota['falla'] = $falla;
            $nota['ticket'] = $id;
            $nota['fecha'] = $fecha_nota;
            $nota['fecha_creado'] = date("Y-m-d H:i:s");
            $nota['observacion'] = addslashes($observ);
            $nota['usuario'] = $_SESSION["id_user"];
            //var_dump($nota);
            $im_class->new_nota($nota);
        }
        /**
         * Se valida el estado del ticket y garantizar que la fecha de solucion tenga un valor
         */
        if (@$_POST["estado"] == 'Cerrado' && $im["fecha_solucion"] == '') {
            //$_SESSION['error']['estado'] = 1;
            //$_SESSION['error']['mensaje'] = 'Ha ocurido un error con la Fecha de solucion Verificar y Guardar nuevamente';
            //$this->editar($id);
            header("Location: index.php?contr=IM&act=editar&id={$id}");
            exit();
        } else {
            $im_class->update_registro($im, $id, $_SESSION["id_user"]);
            header("Location: index.php?contr=IM&act=editar&id={$id}");
            exit();
            //$this->editar($id);
        }

        /*if(@$_POST["estado"]=='Cerrado')
            $this->listar(@$_POST["estado"], $tipo='');
        else
            $this->listar($estado='', @$_POST["tipo"]);   */
    }

    function editar($id = '')
    {
        require 'configs.php'; //Archivo con configuraciones.        
        //session_start();
        //$_SESSION["usuario"] = $usuario;

        error_reporting(0);


        $consulta_class = new IM();
        $im_regitro = '';
        $im_reg_disponibilidad = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
                //echo "Entro por get_registro"."<br>";
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
                //$im_regitro = $consulta_class->get_registro_num($id);
                //echo "Entro por get_registro_num"."<br>";
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        //carga la plantilla 
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Conciliar Registro', $pagina);

        //Cargar script 


        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);


        if ($numrows > 0) {
            $im_regitro = mysqli_fetch_array($im_regitro);
            //$im_regitro['reg_observacion'] = str_replace("⌂Ç", "\n", $im_regitro['reg_observacion']);
            $id = $im_regitro['id_falla_cnl'];
            $divipol = new Divipol();
            //$depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            $notas = $this->get_notas($id);
            $variables_horario = $consulta_class->get_tipo_horario_consultado($_SESSION["id_user"]);
            $tipo_horario = $variables_horario[0];
            $hora_desde = $variables_horario[1];
            $hora_hasta = $variables_horario[2];
            $id_usuario = $_SESSION["id_user"];
            //$notas_replica = $this->get_notas_replica($id);
            //$fallas = $consulta_class->get_fallas();
            $fallas = $consulta_class->get_fallas_disponibles();
            $visibilidad = 'none';
            $formato = "d-m-Y";
            // $formato = "Y-d-m";
            if ($fechas != "")
                $visibilidad = 'block';

            //   $nota_visibilidad = 'none';
            if ($notas != "")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if ($im_regitro['reg_ticket_proveedor'] != "")
                $proveedor_visibilidad = 'block';


            //var_dump(mysql_fetch_array($depar_munic['departamento']));
            //var_dump($im_regitro['reg_municipio_id']);
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if ($im_regitro["reg_estado"] == 'Cerrado')
                include $config->get('contenido') . 'im_cerrado.php';
            else
                include $config->get('contenido') . 'im_editar.php';
            $im_editar = ob_get_clean();
            //realiza el parseado 
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_editar, $pagina);
            //var_dump($im_regitro);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados aca</h1>', $pagina);

        }

        $contenido = $this->view->load_page('views/content/im_editar.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }

//start function pendiente
    function pendiente($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Conciliar Registro Tramitado', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if ($numrows > 0) {
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            $id_disp_cnl = $im_regitro['id_disp_cnl'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            $notas = $this->get_notas_pendientes($id);
            $nota_general = $consulta_class->get_nota_general($id_disp_cnl);
            //$notas_pendientes = $this->get_notas_pendientes($id);
            //$notas_rnec= $this->get_notas_rnec($id);
            //$notas_editables= $this->get_notas_editables($id);
            //$fallas = $consulta_class->get_fallas();
            $fallas = $consulta_class->get_fallas_disponibles();
            $variables_horario = $consulta_class->get_tipo_horario_consultado($_SESSION["id_user"]);
            $tipo_horario = $variables_horario[0];
            $hora_desde = $variables_horario[1];
            $hora_hasta = $variables_horario[2];
            $id_usuario = $_SESSION["id_user"];
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if ($fechas != "")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if ($notas != "")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if ($im_regitro['reg_ticket_proveedor'] != "")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if ($im_regitro["reg_estado"] == 'Cerrado')
                include $config->get('contenido') . 'im_cerrado.php';
            else
                include $config->get('contenido') . 'im_pendiente.php';
            $im_editar_pendiente = ob_get_clean();
            //realiza el parseado 
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_editar_pendiente, $pagina);
            //var_dump($im_regitro);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados aca zona pendiente</h1>', $pagina);
        }
        $contenido = $this->view->load_page('views/content/im_pendiente.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }
    //end function pendiente
//empieza funcion edicion del registro sin_tramitar_rnec
    function sin_tramitar_rnec($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Revision Registro Tramitado', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if ($numrows > 0) {
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            //$dt= $im_regitro['durac_disp_glob'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            $notas_sin_tramitar_rnec = $this->get_notas_sin_tramitar_rnec($id);
            //$notas_rnec = $this->get_notas_rnec($id);
            $fallas = $consulta_class->get_fallas();
            $variables_horario = $consulta_class->get_tipo_horario_consultado($_SESSION["id_user"]);
            $tipo_horario = $variables_horario[0];
            $hora_desde = $variables_horario[1];
            $hora_hasta = $variables_horario[2];
            $id_usuario = $_SESSION["id_user"];
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if ($fechas != "")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if ($notas != "")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if ($im_regitro['reg_ticket_proveedor'] != "")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if ($im_regitro["reg_estado"] == 'Cerrado')
                include $config->get('contenido') . 'im_cerrado.php';
            else
                include $config->get('contenido') . 'im_sintramitar_rnec.php';
            $im_editar_tramitado = ob_get_clean();
            //realiza el parseado 
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_editar_tramitado, $pagina);
            //var_dump($im_regitro);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados aca sin tramitar</h1>', $pagina);
        }
        $contenido = $this->view->load_page('views/content/im_sintramitar_rnec.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }
    //finaliza la edicion del rtegistro tramitado
    //start function pendiente
    function pendientes_rnec($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Conciliar Registro Tramitado', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if ($numrows > 0) {
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            $id_disp_cnl = $im_regitro['id_disp_cnl'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            $notas_pendientes_rnec = $this->get_notas_pendientes_rnec($id);
            $nota_general = $consulta_class->get_nota_general($id_disp_cnl);
            //$notas_rnec= $this->get_notas_rnec($id);
            $fallas = $consulta_class->get_fallas();
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if ($fechas != "")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if ($notas != "")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if ($im_regitro['reg_ticket_proveedor'] != "")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if ($im_regitro["reg_estado"] == 'Cerrado')
                include $config->get('contenido') . 'im_cerrado.php';
            else
                include $config->get('contenido') . 'im_pendientes_rnec.php';
            $im_editar_pendiente = ob_get_clean();
            //realiza el parseado 
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_editar_pendiente, $pagina);
            //var_dump($im_regitro);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados aca zona pendiente rnec</h1>', $pagina);
        }
        $contenido = $this->view->load_page('views/content/im_pendientes_rnec.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }
    //end function pendiente


    //start function aprobados
    function aprobado($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Conciliar Registro Tramitado', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if ($numrows > 0) {
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            $id_disp_cnl = $im_regitro['id_disp_cnl'];
            //$dt= $im_regitro['durac_disp_glob'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            $notas = $this->get_notas_aprobadas($id);
            $nota_general = $consulta_class->get_nota_general($id_disp_cnl);
            //$notas_rnec = $this->get_notas_rnec($id);
            $fallas = $consulta_class->get_fallas();
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if ($fechas != "")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if ($notas != "")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if ($im_regitro['reg_ticket_proveedor'] != "")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if ($im_regitro["reg_estado"] == 'Cerrado')
                include $config->get('contenido') . 'im_cerrado.php';
            else
                include $config->get('contenido') . 'im_aprobado.php';
            $im_editar_aprobado = ob_get_clean();
            //realiza el parseado 
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_editar_aprobado, $pagina);
            //var_dump($im_regitro);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados aca zona aprobado</h1>', $pagina);
        }
        $contenido = $this->view->load_page('views/content/im_aprobado.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }
    //end function aprobado


    //start function aprobados
    function canales_caidos($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Consultar canal caido', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if($numrows > 0){
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            //$dt= $im_regitro['durac_disp_glob'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            //$notas = $this->get_notas_aprobadas($id);
            //$notas_rnec = $this->get_notas_rnec($id);
            $fallas = $consulta_class->get_fallas();
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if($fechas!="")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if($notas!="")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if($im_regitro['reg_ticket_proveedor']!="")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if($im_regitro["reg_estado"]=='Cerrado')
                include $config->get('contenido').'im_cerrado.php';
            else
                include $config->get('contenido').'im_canales_caidos.php';
            $im_canales_caidos = ob_get_clean();
            //realiza el parseado
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_canales_caidos, $pagina);
            //var_dump($im_regitro);
        }else{//si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms' ,'<h1>No existen resultados aca zona aprobado</h1>' , $pagina);
        }
        //ob_start();
        //$im_editar_aprobado = ob_get_clean();
        $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_canales_caidos, $pagina);
        $contenido = $this->view->load_page('views/content/im_canales_caidos.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }
    //end function aprobado


    //empieza funcion edicion del registro tramitado
    function tramitado($id = '')
    {
        require 'configs.php';
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        $numrows = mysqli_num_rows($im_regitro);
        $ruta = $this->view->path('default/page2.php');
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Conciliar Registro Tramitado', $pagina);

        $path = "views/default/js/agregar_fecha.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/agregar_nota.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $path = "views/default/js/select_dependientes_2.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);


        if ($numrows > 0) {
            $im_regitro = mysqli_fetch_array($im_regitro);
            $id = $im_regitro['id_falla_cnl'];
            $id_disp_cnl = $im_regitro['id_disp_cnl'];
            $divipol = new Divipol();
            $depar_munic = $divipol->departamento_municipio($im_regitro['reg_departamento_id'], $im_regitro['reg_municipio_id']);
            $tipo_sede = @mysqli_fetch_array($divipol->get_tipo_sede($im_regitro['reg_tipo_sede']));
            $tipo_enlace = $divipol->list_tipo_enlace();
            $fechas = $this->fecha_solucion($id);
            $notas_tramitadas = $this->get_notas_tramitadas($id);
            $nota_general = $consulta_class->get_nota_general($id_disp_cnl);
            //$notas_rnec = $this->get_notas_rnec($id);
            $fallas = $consulta_class->get_fallas();
            $visibilidad = 'none';
            $formato = "d-m-Y";
            if ($fechas != "")
                $visibilidad = 'block';
            $nota_visibilidad = 'none';
            if ($notas != "")
                $nota_visibilidad = 'block';
            $proveedor_visibilidad = 'none';
            if ($im_regitro['reg_ticket_proveedor'] != "")
                $proveedor_visibilidad = 'block';
            ob_start();
            // Se pregunta si el registro IM esta abierto o cerrado y cargar el formulariop correspondiente
            //carga html del listado de los modulos
            if ($im_regitro["reg_estado"] == 'Cerrado')
                include $config->get('contenido') . 'im_cerrado.php';
            else
                include $config->get('contenido') . 'im_tramitado.php';
            $im_editar_tramitado = ob_get_clean();
            //realiza el parseado 
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', $im_editar_tramitado, $pagina);
            //var_dump($im_regitro);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados aca</h1>', $pagina);
        }
        $contenido = $this->view->load_page('views/content/im_tramitado.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $this->view->view_page($pagina);
    }

    //finaliza la edicion del rtegistro tramitado para tigo

    function historial()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $im_class = new IM();
        $id = $_POST['id'];
        $im_regitro = $im_class->get_historial($id);
        //var_dump(mysqli_fetch_array($im_regitro));
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        $visibilidad = '';
        if (in_array('5', $_SESSION['roles']))
            $visibilidad = 'style="display:none;"';


        $numrows = mysqli_num_rows($im_regitro);
        if ($numrows > 0) {
            $contador = 1;
            //Cargar CSS 
            $path = "views/default/css/tabla.css";
            $load_css = $this->view->load_css($path);
            $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

            $pagina = $this->view->load_template('Historial IM', $pagina);

            ob_start();
            include 'views/content/im_historial.php';
            $contenido = ob_get_clean();

            //$contenido = $this->view->load_page('views/content/im_nuevo.php');
            $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        } else { //si no existen datos -> muestra mensaje de error
            $pagina = $this->view->replace_content('/\#CONTENIDO\#/ms', '<h1>No existen resultados</h1>', $pagina);
        }
        /*//Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script , $pagina);*/
        $this->view->view_page($pagina);
    }

    function reporte()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        //Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Generar reporte', $pagina);

        ob_start();
        include 'views/content/im_reporte.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $pagina = $this->view->replace_content('/\<!--ACTION-->/ms', 'generar_reporte', $pagina);

        $this->view->view_page($pagina);
    }



    function consulta_reporte_final_periodo_pendiente(){
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_registros_pendientes_periodo.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $im_abiertos = $im->get_registro_final_periodo_pendientes($tipo);
        $numrows = mysqli_num_rows($im_abiertos);
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_final_pendiente.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();

    }


    function consulta_reporte_final_periodo_aprobado(){
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_final_periodo.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $im_abiertos = $im->get_registro_final_periodo_aprobados($tipo);
        $numrows = mysqli_num_rows($im_abiertos);
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_final_aprobado.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();

    }

    function consulta_reporte_periodo()
    { //FUNCION QUE LLAMA EXCEL aprobado RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_parcial_periodo.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registro_periodo($tipo);
        $numrows = mysqli_num_rows($im_abiertos);
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_aprobado.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();
    }


    function generar_reporte()
    {
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        $fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        $fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        // $fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $fechasExactasTexto = isset($_POST["fechaExacta"]) ? 'Rango Estricto' : 'Rango Normal';
        $compatoTexto = isset($_POST["compacto"]) ? 'Combinadas' : 'Desagregadas';
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte IM del {$fecha_menor} al {$fecha_mayor} con {$fechasExactasTexto} y filas {$compatoTexto}.xls");

        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');        
        //$fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $diff_fecha = '';
        $periodo = '';
        $diff_fecha = date_diff(date_create(@$_POST["fecha_creado"]), date_create(@$_POST["fecha_cierre"]));
        $periodo = $diff_fecha->format('%a') + 1;
        $disponibilidadEsperada = $periodo * 24;
        $fueraServicio = 0;
        $minutosUne = 0;
        $observacionesUne = '';
        $disponibilidadEfectiva = 0;
        $resarsimiento = 0;

        $hora_menos = "00:00";
        $hora_mayor = "23:59";

        if ($_POST['hora_creado'] != '') {
            if ($_POST['minuto_creado'] != '') {
                $hora_menos = $_POST['hora_creado'] . ":" . $_POST['minuto_creado'];
            } else {
                $hora_menos = $_POST['hora_creado'] . ":00";
            }
        }
        if ($_POST['hora_cierre_2'] != '') {
            if ($_POST['minuto_cierre_2'] != '') {
                $hora_mayor = $_POST['hora_cierre_2'] . ":" . $_POST['minuto_cierre_2'];
            } else {
                $hora_mayor = $_POST['hora_cierre_2'] . ":59";
            }
        }
        $fecha_menor_aux = date_create(@$_POST["fecha_creado"] . ' ' . $hora_menos);
        $fecha_mayor_aux = date_create(@$_POST["fecha_cierre"] . ' ' . $hora_mayor);
        $fechasExactas = isset($_POST["fechaExacta"]) ? true : false;
        $compacto = isset($_POST["compacto"]) ? true : false;
        //var_dump($_POST['hora_creado']);
        //var_dump($fecha_menor_aux);
        //var_dump($fecha_mayor_aux);
        $im = new IM();
        //Esta parte era con el fin de traer todos los registros IM o solo los que cumplen con el criterio
        /*if(isset($_POST["todos_im"]))
            $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
        else
            $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
        */
        $datos_im_fechas = array();
        $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
        $i = 0;
        while ($row = mysqli_fetch_array($datos_im)) {
            $datos_im_fechas[$i] = array();
            $datos_im_fechas[$i]['datos'] = $row;
            $fecha = $im->get_fechas_registro($row['reg_id']);
            $datos_im_fechas[$i]['fechas'] = $fecha;
            $datos_im_fechas[$i]['user_name'] = $im->get_user_id_closed($row['reg_id']);
            $i++;
        }

        $numrows = mysqli_num_rows($datos_im);

        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        if (isset($_POST["resumenUne"]))
            include $config->get('contenido') . 'im_reporte_generar_test.php';
        else
            include $config->get('contenido') . 'im_reporte_generar.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->generar_reporte_2($datosInformeConsolidado);              
    }

    /**
     * gerera el reporte de los totales de ticket creados, cerrados, escalados...
     */
    function validar_fechas($fecha_creacion, $fecha2, $notas, $sla_id = 0, $fecha_festivos = array(0))
    {
        $fechas = array();
        $primera_nota = TRUE;
        $contador = 0;
        $contadorNotas = 0;
        $responsable = 'UNE-PROVEEDOR';
        $ultima_fecha_nota = '';
        $penultima_fecha_nota = '';
        $fecha1 = $fecha_creacion;
        $aux_minutos = 0;
        for ($i = 0; $i < count($notas); $i++) {
            $total_min = 0;
            $fecha_nota = date_create($notas[$i]["nota_fecha"]);
            if ($primera_nota) {
                //$responsable = $fechas[$notas[$i]['responsable']];
                $responsable = $notas[$i]['responsable'];
                $contadorNotas++;
                if ($fecha2 >= $fecha_nota && $fecha1 <= $fecha_nota) {
                    //$fecha_nota = date_create($notas[$i]["nota_fecha"]); 
                    $responsable = $notas[$i]['responsable'];
                    $dif_fecha = date_diff($fecha1, $fecha_nota);
                    $total_min = ($dif_fecha->format('%a') * 24 * 60) + ($dif_fecha->format('%h') * 60) + ($dif_fecha->format('%i'));
                    $fechas[$notas[$i]['responsable']] = $total_min;
                    $primera_nota = FALSE;
                    $penultima_fecha_nota = $fecha_nota;
                    $fecha1 = $fecha_nota;
                    $contador = $i;
                    $ultima_fecha_nota = $fecha_nota;
                }
            } else {
                $contadorNotas++;
                if ($fecha2 >= $fecha_nota && $fecha1 <= $fecha_nota) {
                    //$fecha_nota = date_create($notas[$i]["nota_fecha"]);  
                    $dif_fecha = date_diff($fecha1, $fecha_nota);
                    $total_min = ($dif_fecha->format('%a') * 24 * 60) + ($dif_fecha->format('%h') * 60) + ($dif_fecha->format('%i'));
                    if (isset($fechas[$notas[$i - 1]['responsable']])) {
                        $fechas[$notas[$i - 1]['responsable']] += $total_min;
                        $fechas[$notas[$i - 1]['responsable'] . '_falla'] = $notas[$contador]['descripcion'];
                    } else {
                        $fechas[$notas[$i - 1]['responsable']] = $total_min;
                        $fechas[$notas[$i - 1]['responsable'] . '_falla'] = $notas[$contador]['descripcion'];
                    }
                    $penultima_fecha_nota = $fecha1;
                    $fecha1 = $fecha_nota;
                    $contador = $i;
                    $responsable = $notas[$i]['responsable'];
                    $ultima_fecha_nota = $fecha_nota;
                }
            }
            $aux_minutos = $total_min;
        }
        //$fecha_nota = date_create($notas[$i]["nota_fecha"]);  
        //$responsable = '';
        //if(count($notas)>0){
        //$responsable = $notas[$contador]['responsable'];
        //}
        /**
         * Condicion para determinar si la fecha de la ultima nota es mayor a la fecha de solucion
         */
        if ($ultima_fecha_nota != '') {
            if ($fecha2 >= $ultima_fecha_nota) {
                $dif_fecha = date_diff($fecha1, $fecha2);
            }
            /*else{
                $dif_fecha = date_diff($penultima_fecha_nota, $fecha2);
                @$fechas[$responsable] -= $aux_minutos;
            }*/
            $total_min = ($dif_fecha->format('%a') * 24 * 60) + ($dif_fecha->format('%h') * 60) + ($dif_fecha->format('%i'));
        } else {
            if ($fecha1 < $fecha2) {
                $dif_fecha = date_diff($fecha1, $fecha2);
                $total_min = ($dif_fecha->format('%a') * 24 * 60) + ($dif_fecha->format('%h') * 60) + ($dif_fecha->format('%i'));
            } else {
                $total_min = 0;
            }
        }
        //$dif_fecha = date_diff($fecha1, $fecha2);
        /*$responsable = 'UNE-PROVEEDOR';
        if(count($notas)>0)
            $responsable = $notas[$contador]['responsable'];*/


        if (isset($fechas[$responsable])) {
            $fechas[$responsable] += $total_min;
            $fechas[$responsable . '_falla'] = $notas[$contador]['descripcion'];
        } else {
            $fechas[$responsable] = $total_min;
            $fechas[$responsable . '_falla'] = isset($notas[$contador]['descripcion']) ? $notas[$contador]['descripcion'] : 'Ticket cerrado sin notas o mal Gestionado';
            //$fechas[$responsable.'_falla'] = 'Ticket cerrado sin notas o mal Gestionado';
        }

        //Validacion para determinar si la ultima bandera es responsabilidad de OTROS en tal caso se resetea los responsables y todo el tiempo va a ese concepto
        if ($notas[$contadorNotas - 1]['responsable'] === 'OTROS') {
            $fechas = array();
            $dif_fecha = date_diff($fecha_creacion, $fecha2);
            $total_min = ($dif_fecha->format('%a') * 24 * 60) + ($dif_fecha->format('%h') * 60) + ($dif_fecha->format('%i'));
            $responsable = $notas[$contadorNotas - 1]['responsable'];
            $fechas[$responsable] = $total_min;
            $fechas[$responsable . '_falla'] = $notas[$contadorNotas - 1]['descripcion'];
        }
        //$fecha1 = $fecha_nota;
        //var_dump($notas[$i]['responsable']);
        //var_dump($total_min);
        //var_dump($fechas);
        return $fechas;
    }

    function reporte_totales()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        //Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Generar reporte', $pagina);

        ob_start();
        include 'views/content/im_reporte.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $pagina = $this->view->replace_content('/\<!--ACTION-->/ms', 'generar_reporte_totales', $pagina);

        $this->view->view_page($pagina);
    }

    function generar_reporte_totales()
    {
        // Header para crear archivo EXCEL
        /*header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte IM.xls");*/

        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        date_default_timezone_set("America/Bogota");
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');        
        //$fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $im = new IM();
        if (isset($_POST["fecha_creado"]))
            $desde = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        else
            $desde = date("Y-m-d");
        /*if(isset($_POST["fecha_cierre"]))
            $hasta = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');        
        else*/
        $hasta = date("Y-m-d");


        $otrs_abiertos = $im->get_otrs_abiertos($desde, $desde);
        $otrs_abiertos_viejos = $im->get_otrs_abiertos_viejos($desde);
        $otrs_cerrados_viejos = $im->get_otrs_cerrados_viejos($desde);

        $numrows = mysqli_num_rows($otrs_abiertos);
        $otrs_abiertos_viejos_numero = mysqli_num_rows($otrs_abiertos_viejos);
        $otrs_cerrados_viejos_numero = mysqli_num_rows($otrs_cerrados_viejos);

        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'im_reporte_generar_totales.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();                
    }

    /**
     * gerera el reporte del detalle de ticket creados, cerrados, escalados...
     */

    function reporte_detalle()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        //Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Generar reporte', $pagina);

        ob_start();
        include 'views/content/im_reporte.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $pagina = $this->view->replace_content('/\<!--ACTION-->/ms', 'generar_reporte_detalle', $pagina);

        $this->view->view_page($pagina);
    }

    function generar_reporte_detalle()
    {
        // Header para crear archivo EXCEL
        /*header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte IM.xls");*/

        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        date_default_timezone_set("America/Bogota");
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');        
        //$fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $im = new IM();
        if (isset($_POST["fecha_creado"]))
            $desde = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        else
            $desde = date("Y-m-d");
        /*if(isset($_POST["fecha_cierre"]))
            $hasta = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');        
        else*/
        $hasta = date("Y-m-d");


        $otrs_abiertos = $im->get_otrs_abiertos($desde, $desde);
        $otrs_abiertos_cerrados = $im->get_otrs_abiertos_cerrados($desde, $desde);
        $otrs_abiertos_viejos = $im->get_otrs_abiertos_viejos($desde);
        $otrs_cerrados_viejos = $im->get_otrs_cerrados_viejos($desde);

        $numrows = mysqli_num_rows($otrs_abiertos);
        $otrs_abiertos_viejos_numero = mysqli_num_rows($otrs_abiertos_viejos);
        $otrs_cerrados_viejos_numero = mysqli_num_rows($otrs_cerrados_viejos);

        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'im_reporte_generar_detalle.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();                
    }

    /**
     * genera el reporte de productividad de ticket creados, cerrados, escalados...
     */

    function reporte_productividad()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        //Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Generar reporte', $pagina);

        ob_start();
        include 'views/content/im_reporte.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $pagina = $this->view->replace_content('/\<!--ACTION-->/ms', 'reporte_productividad_generar', $pagina);

        $this->view->view_page($pagina);
    }

    function reporte_productividad_generar()
    {
        // Header para crear archivo EXCEL
        /*header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte IM.xls");*/

        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        date_default_timezone_set("America/Bogota");
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');        
        //$fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $im = new IM();
        if (isset($_POST["fecha_creado"])) {
            //$desde = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
            $desde = date_create(@$_POST["fecha_creado"]);
        } else {
            $desde = date("Y-m-d");
        }
        if (isset($_POST["fecha_cierre"])) {
            //$hasta = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
            $hasta = date_create(@$_POST["fecha_cierre"]);
        } else {
            $hasta = date("Y-m-d");
        }

        $aux_desde = strtotime(date_format($desde, 'Y-m-d'));
        $aux_hasta = strtotime(date_format($hasta, 'Y-m-d'));

        $fechas = array();
        while ($aux_desde <= $aux_hasta) {
            //for($aux_desde; $aux_desde>=$aux_hasta;$aux_desde=strtotime(date_add($desde, date_interval_create_from_date_string('1 days')))){          
            $aux_desde_2 = date_format($desde, 'Y-m-d');
            $aux_desde_3 = date_format(date_add($desde, date_interval_create_from_date_string('1 days')), 'Y-m-d');
            $aux_desde = strtotime(date_format($desde, 'Y-m-d'));
            $otrs_abiertos = $im->get_otrs_abiertos($aux_desde_2, $aux_desde_2);
            $otrs_abiertos_cerrados = $im->get_otrs_abiertos_cerrados($aux_desde_2, $aux_desde_2);
            $otrs_abiertos_viejos = $im->get_otrs_abiertos_viejos($aux_desde_2);
            $otrs_cerrados_viejos = $im->get_otrs_cerrados_viejos($aux_desde_2);
            $otrs_abiertos_viejos_fecha = $im->get_otrs_abiertos_viejos_fecha($aux_desde_2, $aux_desde_3);
            //var_dump($otrs_abiertos_viejos_fecha);
            $numrows = mysqli_num_rows($otrs_abiertos);
            $otrs_abiertos_viejos_numero = mysqli_num_rows($otrs_abiertos_viejos);
            $otrs_cerrados_viejos_numero = mysqli_num_rows($otrs_cerrados_viejos);

            $fechas[$aux_desde_2]['otrs_abiertos'] = $otrs_abiertos;
            $fechas[$aux_desde_2]['otrs_abiertos_cerrados'] = $otrs_abiertos_cerrados;
            $fechas[$aux_desde_2]['otrs_abiertos_viejos'] = $otrs_abiertos_viejos;
            $fechas[$aux_desde_2]['otrs_cerrados_viejos'] = $otrs_cerrados_viejos;
            $fechas[$aux_desde_2]['numrows'] = $numrows;
            $fechas[$aux_desde_2]['otrs_abiertos_viejos_numero'] = $otrs_abiertos_viejos_numero;
            $fechas[$aux_desde_2]['otrs_cerrados_viejos_numero'] = $otrs_cerrados_viejos_numero;
            $fechas[$aux_desde_2]['otrs_abiertos_viejos_fecha'] = $otrs_abiertos_viejos_fecha;
            $fechas[$aux_desde_2]['fecha+1'] = $aux_desde_3;
            //$aux_desde=strtotime(date_format(date_add($desde, date_interval_create_from_date_string('1 days')),'Y-m-d'));
        }
        //var_dump($fechas);


        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'im_reporte_productividad_generar.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();                 
    }

    function generar_reporte_otrs()
    {
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte IM.xls");

        require 'configs.php'; //Archivo con configuraciones.       
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        $fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $im = new IM();
        //Esta parte era con el fin de traer todos los registros IM o solo los que cumplen con el criterio
        /*if(isset($_POST["todos_im"]))
            $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
        else
            $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
        */
        $fallas = array(
            'g1' => 'UNE-Bloqueo de equipos',
            'g2' => 'UNE-Capacidad-saturación (intermitencia)',
            'g3' => 'UNE-Alimentación eléctrica (LAN)',
            'g4' => 'UNE-Daño de red Última Milla',
            'g5' => 'UNE-Falla equipo UM',
            'g6' => 'UNE-Falla red backbone (nodo principal)',
            'g7' => 'UNE-Falla masiva',
            'g8' => 'UNE-Traslado',
            'g9' => 'RNEC-Apagado de equipos',
            'g10' => 'RNEC-Daño de patchcord',
            'g11' => 'RNEC-Alimentación eléctrica',
            'g12' => 'RNEC-No contacto (registrador en vacaciones no hay registrador)',
            'g13' => 'RNEC-Intermitencia',
            'g14' => 'RNEC-Cambio de equipos registraduria',
            'g15' => 'OTROS-Alimentación eléctrica',
            'g16' => 'OTROS-Falla fortuita (inundación  siniestro quema de equipos robo)',
            'g17' => 'RNEC-Registrador o formador no contesta',
            'g18' => 'RNEC-Registrador o formador mantiene equipos apagados',
            'g19' => 'RNEC-No se encuentra personal en la sede',
            'g20' => 'RNEC-malas conexiones en LAN',
            'g21' => 'RNEC-Falla de equipos',
            'g22' => 'OTROS-Condiciones Climáticas',
            'g23' => 'OTROS-Canal en monitoreo'
        );
        $responsables = array(
            '0' => 'UNE',
            '1' => 'RNEC',
            '2' => 'OTROS'
        );
        $datos_im_fechas = array();
        $datos_im = $im->reporte_otrs($fecha_menor, $fecha_mayor);
        $i = 0;
        while ($row = mysqli_fetch_array($datos_im)) {
            $datos_im_fechas[$i] = array();
            $datos_im_fechas[$i]['datos'] = $row;
            $fecha = $im->get_fechas_registro($row['id']);
            $datos_im_fechas[$i]['fechas'] = $fecha;
            $i++;
        }

        $numrows = mysqli_num_rows($datos_im);

        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'im_reporte_generar_1.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();                
    }

    /**
     * gerera el reporte de ticket de los proveedores
     */

    function reporte_proveedor()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        //Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Generar reporte', $pagina);

        ob_start();
        include 'views/content/im_reporte.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $pagina = $this->view->replace_content('/\<!--ACTION-->/ms', 'generar_reporte_proveedor', $pagina);

        $this->view->view_page($pagina);
    }

    function generar_reporte_proveedor()
    {
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte IM Proveedor.xls");

        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        date_default_timezone_set("America/Bogota");
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');        
        //$fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $im = new IM();
        if (isset($_POST["fecha_creado"]))
            $desde = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        else
            $desde = date("Y-m-d");
        if (isset($_POST["fecha_cierre"]))
            $hasta = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        else
            $hasta = date("Y-m-d");


        $proveedores = $im->get_ticket_proveedor($desde, $hasta);

        $numrows = mysqli_num_rows($proveedores);

        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'im_reporte_generar_proveedor.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();                
    }

    function reporte_ticket_cerrado_area()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);

        //Cargar script 
        $path = "views/default/js/jquery-ui.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        $path = "views/default/js/script_datepicker.js";
        $load_script = $this->view->load_script($path);
        $pagina = $this->view->replace_content('/\<!--cargar_script-->/ms', $load_script, $pagina);

        //Cargar CSS 
        $path = "views/default/css/jquery-ui.css";
        $load_css = $this->view->load_css($path);
        $pagina = $this->view->replace_content('/\<!--cargar_css-->/ms', $load_css, $pagina);

        $pagina = $this->view->load_template('Generar reporte', $pagina);

        ob_start();
        include 'views/content/im_reporte.php';
        $contenido = ob_get_clean();

        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);
        $pagina = $this->view->replace_content('/\<!--ACTION-->/ms', 'otrs_generar_reporte_ticket_cerrado_area', $pagina);

        $this->view->view_page($pagina);
    }

    function otrs_generar_reporte_ticket_cerrado_area()
    {
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte de ticket cerrados x cola.xls");

        require 'LDAPController.php';
        //LDAPController::conectar();
        //$usuario = $_POST['usuariodominio'];
        $ldap = LDAPController::getInstance();

        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        date_default_timezone_set("America/Bogota");
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        //$fecha_menor = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');        
        //$fecha_mayor = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        $im = new IM();
        if (isset($_POST["fecha_creado"]))
            $desde = date_format(date_create(@$_POST["fecha_creado"]), 'Y-m-d');
        else
            $desde = date("Y-m-d");
        if (isset($_POST["fecha_cierre"]))
            $hasta = date_format(date_create(@$_POST["fecha_cierre"]), 'Y-m-d');
        else
            $hasta = date("Y-m-d");

        $lista_ticket_cerrados = $im->get_otrs_ticket_cerrados($desde, $hasta);

        /*$aux_desde = strtotime(date_format($desde, 'Y-m-d'));
        $aux_hasta = strtotime(date_format($hasta, 'Y-m-d'));
        
        $fechas = array();
        while($aux_desde<=$aux_hasta){
        //for($aux_desde; $aux_desde>=$aux_hasta;$aux_desde=strtotime(date_add($desde, date_interval_create_from_date_string('1 days')))){          
            $aux_desde_2 = date_format($desde, 'Y-m-d');
            $aux_desde_3 = date_format(date_add($desde, date_interval_create_from_date_string('1 days')),'Y-m-d');
            $aux_desde = strtotime(date_format($desde, 'Y-m-d'));
            
            $otrs_abiertos = $im->get_otrs_abiertos($aux_desde_2, $aux_desde_2);
            $otrs_abiertos_cerrados = $im->get_otrs_abiertos_cerrados($aux_desde_2, $aux_desde_2);
            $otrs_abiertos_viejos = $im->get_otrs_abiertos_viejos($aux_desde_2);
            $otrs_cerrados_viejos = $im->get_otrs_cerrados_viejos($aux_desde_2);
            $otrs_abiertos_viejos_fecha = $im->get_otrs_abiertos_viejos_fecha($aux_desde_2, $aux_desde_3);          
            $numrows = mysqli_num_rows($otrs_abiertos);
            $otrs_abiertos_viejos_numero = mysqli_num_rows($otrs_abiertos_viejos);
            $otrs_cerrados_viejos_numero = mysqli_num_rows($otrs_cerrados_viejos);
            
            $fechas[$aux_desde_2]['otrs_abiertos']=$otrs_abiertos;
            $fechas[$aux_desde_2]['otrs_abiertos_cerrados']=$otrs_abiertos_cerrados;
            $fechas[$aux_desde_2]['otrs_abiertos_viejos']=$otrs_abiertos_viejos;
            $fechas[$aux_desde_2]['otrs_cerrados_viejos']=$otrs_cerrados_viejos;
            $fechas[$aux_desde_2]['numrows']=$numrows;
            $fechas[$aux_desde_2]['otrs_abiertos_viejos_numero']=$otrs_abiertos_viejos_numero;
            $fechas[$aux_desde_2]['otrs_cerrados_viejos_numero']=$otrs_cerrados_viejos_numero;
            $fechas[$aux_desde_2]['otrs_abiertos_viejos_fecha']=$otrs_abiertos_viejos_fecha;
            $fechas[$aux_desde_2]['fecha+1']=$aux_desde_3;
            //$aux_desde=strtotime(date_format(date_add($desde, date_interval_create_from_date_string('1 days')),'Y-m-d'));
        }*/


        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'otrs_generar_reporte_ticket_cerrado_area.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();                 
    }


    function consulta_otrs()
    {
        $id = $_POST['id'];
        $im_class = new IM();
        $im_id = @mysqli_fetch_array($im_class->get_im_id($id));
        if ($im_id['reg_ticket_num'] == $id) {
            echo json_encode($im_id);
            //var_dump(mysqli_fetch_array($im_id));
        } else {
            $im_datos = $im_class->get_otrs_num($id);
            echo json_encode(@mysqli_fetch_array($im_datos, MYSQL_ASSOC));
            //var_dump(mysqli_fetch_array($im_datos));            
        }
    }


    function consulta_otrs_fecha_nota()
    {
        $id = $_POST['id'];
        $im_class = new IM();
        $im_datos = $im_class->get_otrs_last_nota($id);
        echo json_encode(@mysqli_fetch_array($im_datos, MYSQL_ASSOC));
        //var_dump(mysqli_fetch_array($im_datos));
    }

    function cargar()
    {
        //session_start();
        //$_SESSION["usuario"] = $usuario;
        $ruta = $this->view->path('default/page1.php');
        //Cargar la plantilla 
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Cargar registros IM desde archivo', $pagina);
        ob_start();
        include 'views/content/im_cargar.php';
        $contenido = ob_get_clean();
        //$contenido = $this->view->load_page('views/content/im_nuevo.php');
        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $contenido, $pagina);

        $this->view->view_page($pagina);
    }

    function cargar_registros()
    {
        @session_start();
        $archivo = $_FILES["archivo"]['name'];
        // guardamos el archivo a la carpeta files
        $destino = $_FILES['archivo']['tmp_name'];
        $destino = str_replace('\\', '\\\\', $destino);
        $im = new IM();
        $cargar = $im->cargar_registros($destino);
        //$actualizar = "LOAD DATA LOCAL INFILE '" . $destino . "' INTO TABLE registro FIELDS TERMINATED BY ';' ENCLOSED BY '\"' ESCAPED BY '\\\' LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES";
        //** Guarda datos
        $error_db = false;
        //$actualiza = $conexion->actualiza($actualizar);
        // Valida si operaci�n en base de datos concluy� con �xito
        if ($cargar != false) {
            $this->listar();
            $subtitulo = "FINALIZAR";
            $subtitulo_img = "ok.png";
        } else {
            $subtitulo = "ERROR";
            $subtitulo_img = "error.png";
            $advertencia = "Se ha presentado un error y no se pudo crear el usuario.<br>Por favor intente nuevamente.";
            $error_db = true;
        }
    }

    function fecha_solucion($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];

        $im_class = new IM();
        $campos = '';
        $im_datos = mysqli_fetch_array($im_class->get_im_id($id));
        if ($im_datos['reg_fecha_solucion'] != '1000-01-01 00:00:00') {
            /*$im_datos['fechas'] = array();
            $im_datos['fehcas'] = $im_class->get_fechas_registro($id);*/
            $fechas = $im_class->get_fechas_registro($id);
            $i = 0;
            while ($row = @mysqli_fetch_array($fechas)) {
                if ($row['fecha_cierre'] == '1000-01-01 00:00:00') {
                    $campos .= $this->fecha_solucion_html('FECHA DE CREACIÓN', 'creacion', '', $row['fecha_apertura'], 'disabled', 1);
                    $campos .= $this->fecha_solucion_html('FECHA SOLUCIÓN', 'solucion', '', '', '', 2);
                    $campos .= "<input type='hidden' name='fecha_id_valor' id='fecha_id_valor' value='{$row['fecha_id']}' />";
                } else {
                    $campos .= $this->fecha_solucion_html('FECHA DE CREACIÓN', 'creacion', $i, $row['fecha_apertura'], 'disabled', 1);
                    $campos .= $this->fecha_solucion_html('FECHA SOLUCIÓN', 'solucion', $i, $row['fecha_cierre'], 'disabled', 2);
                }
                $i++;
            }
        }
        return $campos;
    }

    function fecha_solucion_html($titulo, $nombre, $indice, $row, $propiedad, $numero)
    {
        $campos = "<div class='control-group fecha'>";
        $campos .= "<label class='control-label fecha{$numero}' for='fecha_{$nombre}_{$indice}'>{$titulo}</label>";
        $campos .= "<div class='controls'>";
        $fecha = ($row != '' && $row != "0000-00-00") ? date("d/m/Y", strtotime($row)) : '';
        $campos .= "<input type='text' class='span4 fechas' name='fecha_{$nombre}_{$indice}' id='fecha_{$nombre}_{$indice}' value='{$fecha}' readonly>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "<label class='control-label' for='hora_{$nombre}_{$indice}'>Hora</label>";
        $campos .= "<div class='controls'>";
        $campos .= "<select class='span6 lista horas' name='hora_{$nombre}_{$indice}' {$propiedad}>";
        $hora = ($row != '') ? date("H", strtotime($row)) : '';
        for ($i = 0; $i < 24; $i++) {
            if ($hora == $i) {
                if ($i < 10) {
                    $campos .= "<option value='0{$i}' Selected>0{$i}</option>";
                } else {
                    $campos .= "<option value='{$i}' Selected>{$i}</option>";
                }
            } else {
                if ($i < 10) {
                    $campos .= "<option value='0{$i}'>0{$i}</option>";
                } else {
                    $campos .= "<option value='{$i}'>{$i}</option>";
                }
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "<label class='control-label' id='separador'>:</label>";
        $campos .= "<label class='control-label' for='minuto_{$nombre}_{$indice}'>Minutos</label>";
        $campos .= "<div class='controls minuto'>";
        $minutos = ($row != '') ? date("i", strtotime($row)) : '';
        $campos .= "<input type='text' class='span4 minutos' name='minuto_{$nombre}_{$indice}' value='{$minutos}' {$propiedad}>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /control-group -->";

        return $campos;
    }

//prueba get_notas rechazo rnec
    function get_notas_rnec($pos,$id_falla_prv,$id_disp_cnl)
    {
        //if($id == 0)
        //    $id = $_POST['id'];
        $im_class = new IM();
        //$id_disp = $im_class->get_id_disponibilidad($id);
        //$id_disp = mysqli_fetch_array($id_disp);
        //$id_disp = $id_disp["id_disp_cnl"];
        $notas_rnec = $im_class->get_notas_registro_rnec($id_falla_prv,$id_disp_cnl);
//        echo 'variable que tiene:'.$id_disp;
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        $row = mysqli_fetch_array($notas_rnec);

        do {
            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_rnec($pos,$i, $row, $fallas, 'disabled');
            $i++;
        } while ($row = mysqli_fetch_array($notas_rnec));
        return $campos;
    }

    function nota_html_rnec($posicion,$indice, $row, $fallas, $propiedad)
    {
        $im_class = new IM();


        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();

        //marcar cada uno de los indices 

        $campos = "<div id='div_nota_nueva_rnec_{$posicion}_{$indice}'>";

        $campos .= "<div id='elementor_br_{$posicion}_{$indice}' style='display: none;'>";
        $campos .= "<div class='red darken-3 white-text'>";
        $campos .= "<center>";
        //$campos .= "<div id='close'><a class='d-flex flex-row-reverse bd-highlight' href='#' id='hides' title='Cerrar este formulario '><i class='fa fa-times' aria-hidden='true'></i></a></div> "; //este va en la nueva  copy
        $campos .= "<center><H2><i>RESPUESTA RNEC A TIGO # {$indice}</i></H2></center>";

        $campos .= "</center>";
        $campos .= "</div>";

        // $campos.= "<div class='myDiv'>";
        //  $campos .= " <div class='d-flex justify-content-around'>";   d-flex p-2   
        // $campos .= " <div class='row justify-content-around'>"; 
        $campos .= " <div class='align-self-baseline'>";

        $campos .= "<div class='myDiv'>";

//aca iria la separacion de color del div y la nota/////////////// SEPARACION COLOR NOTA


//$campos.= "<div class='myDiv'>";
//$campos.= "</div>";


        $campos .= " <center>";

//start fallas justificada
        $campos .= " <div class='container'>";
        $campos .= "  <div class='row'>";
        $campos .= "  <div class='col-6'>";


        $campos .= " <label class='control-label' for='nota_observacion'style='font-weight: 500;'>FALLA JUSTIFICADA </label>";


        $campos .= "<div class='form-check'>";
        //$campos .="    <input type='radio' class='custom-control-input' id='falla_justif_si' name='falla_justif' value='0' disabled>";
        $campos .= "<label class='form-check-label' for='falla_justif_si'>" . $row['falla_justif'] . "</label>";

        $campos .= "   </div>";

        /*                         $campos .="    <div class='custom-control custom-radio'>";
                           $campos .="    <input type='radio' class='custom-control-input' id='falla_justif_no' name='falla_justif' value='1' checked disabled>";
                            $campos .="   <label class='custom-control-label' for='falla_justif_no'>NO</label>";
                        $campos .="     </div>  ";*/
        $campos .= "  </div>   ";

//end falla justificada

        //start aplica o no resarcimiento
        $campos .= "<div class='col-md-6'> ";


        $campos .= " <label class='control-label' for='nota_observacion'style='font-weight: 500;'>APLICA RESARCIMIENTO</label>";
        $campos .= "<div class='form-check'>";
        //  $campos .=" <input type='radio' class='form-check-input' id='aplica_resarc_si' name='aplica_resarc' disabled value=".$row['aplica_resarc'].">";
        $campos .= " <label class='form-check-label' for='aplica_resarc_si'>" . $row['aplica_resarc'] . "</label>";
        $campos .= " </div>";


        $campos .= "  </div>";

        $campos .= "  </br>";
        //fin aplica o no resarcimiento


//start obervaciones
        $campos .= "<br>";

        //  $campos .="  <div class='row justify-content-center'>";
        $campos .= "  <div class='col-12'>";

        $campos .= "<label class='control-label col-sm-8'style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES DE RNEC </label>";
        $campos .= "<div class='col-sm-12'>";
        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_rnec{$indice}'id='nota_observacion_rnec{$indice}' rows='5' readonly>" . stripslashes($row['observ_conc']) . "</textarea>";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</br> <!-- /saltolinea-->";
//end observacione
//QUIEN LO REALIZO

        $campos .= "<label class='row align-items-start'  style='font-style: italic; color:#424242; font-weight: 400;' for='nota_observacion_{$indice}'>&nbsp&nbsp   GESTIONADO POR:&nbsp " . $row['gestionado'] . "</label>";
        $campos .= "</div>";
        $campos .= "</div>";
//FIN QUIEN LO REALIZO
//$campos.= "</div>";


        $campos .= "</div> <!-- /fin de p-2 -->";
        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</div> <!-- /elemntor -->";
        $campos .= "</div> <!-- /div nota nueva rnec -->";

        $campos .= "</div> <!-- /elemntor -->";

        return $campos;
    }

//fin prueba rechazo notas rnec

    function get_notas_concilia($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_concilia = $im_class->get_notas_registro($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        //     echo $notas == TRUE ? "hay algo en notas":"no hay nada en notas";
        $row = mysqli_fetch_array($notas_concilia);

        do {

            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_rnec_concilia($i, $row, $fallas, 'disabled');
            $i++;
        } while ($row = mysqli_fetch_array($notas_concilia));

        return $campos;
    }

//funcion mierdero prueba conciliado
    function nota_html_rnec_concilia($indice, $row, $fallas, $propiedad)
    {

        $im_class = new IM();
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

        <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
    */

        //marcar cada uno de los indices 

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}>' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";
        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        //<option value=''>--</option>"                
        if ($hora < 10) {
            $campos .= "<option value='{$hora}'>{$hora}</option>";
        } else {
            $campos .= "<option value='{$hora}'>{$hora}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";   
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla   

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
        //<option value=''>--</option>"                
        if ($hora < 10) {
            $campos .= "<option value='{$hora1}'>{$hora1}</option>";
        } else {
            $campos .= "<option value='{$hora1}'>{$hora1}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->"; 
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla        


        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>" . stripslashes($row['durac_falla_tpf']) . "</textarea>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";  
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->"; 
        //  $campos .= "</div> <!-- /fin de p-2 -->";   
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";


        $campos .= "<p align='left'> 
             
             
        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='save_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        $campos .= "</form>";


        //comienza el miErdero
        $campos .= "<legend style='font-weight: 500;'>ZONA DE CONCILIACION</legend></br>";

        $campos .= "<div class='container'>";

        $campos .= "<form id='guardar_im' class='form-horizontal' action='index.php?contr=Consulta&act=revisar&id=<?php echo $id?>' method='post'> ";
        $campos .= "</br>";


        $campos .= "<div class='container'>";
        $campos .= " <div class='row'>";
        $campos .= "<div class='col'>";

        $campos .= "<label class='control-label' for='nota_observacion_{$indice}'style='font-weight: 500;'>FALLA JUSTIFICADA</label>";
        $campos .= "<div class='custom-control custom-radio'>";
        $campos .= "<input type='radio' class='custom-control-input' id='falla_justif_si_{$indice}' name='falla_justif_{$indice}' value='SI' checked>";
        $campos .= "<label class='custom-control-label' for='falla_justif_si_{$indice}'>SI</label>";
        $campos .= "</div>";

        //<!-- Default checked -->
        $campos .= "<div class='custom-control custom-radio'>";
        $campos .= "<input type='radio' class='custom-control-input' id='falla_justif_no_{$indice}' name='falla_justif_{$indice}' value='NO'>";
        $campos .= "<label class='custom-control-label' for='falla_justif_no_{$indice}'>NO</label>";
        $campos .= "</div> ";
        $campos .= "</div> ";
        $campos .= "</br>";
        $campos .= " <div class='col-md-3'> ";
        $campos .= "<label class='control-label' for='nota_observacion_{$indice}' style='font-weight: 500;'>APLICA RESARCIMIENTO</label>";
        $campos .= "<div class='form-check'>";
        $campos .= "<input type='radio' class='form-check-input' id='aplica_resarc_si_{$indice}' name='aplica_resarc_{$indice}' value='SI'>";
        $campos .= "<label class='form-check-label' for='aplica_resarc_si_{$indice}'>SI</label>";
        $campos .= "</div>";

        // <!-- Material checked -->
        $campos .= "<div class='form-check'>";
        $campos .= "<input type='radio' class='form-check-input' id='aplica_resarc_no_{$indice}' name='aplica_resarc_{$indice}' value='NO' checked>";
        $campos .= "<label class='form-check-label' for='aplica_resarc_no_{$indice}'>NO</label>";
        $campos .= "</div>";
        $campos .= "</div>";
        $campos .= "<div class='col-md-6'>";
        $campos .= "<label class='control-label ' for='nota_observacion_rnec_{$indice}'style='font-weight: 500;'>OBSERVACIONES PARA CONCILIACION TIGO</label>";
        $campos .= "<div class='col-sm-12'>";
        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_rnec_{$indice}' id='nota_observacion_rnec_{$indice}' rows='2' required></textarea>";
        $campos .= "</div>";
        $campos .= "</div>";
        $campos .= "</div>";
        // <!--FIN SECCION DE CAMPOS PARA MENSAJE QUE ENVIA RNEC -->
//termina el mierdero

        return $campos;
    }


    function get_notas($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas = $im_class->get_notas_registro($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        //     echo $notas == TRUE ? "hay algo en notas":"no hay nada en notas";
        $row = mysqli_fetch_array($notas);

        do {

            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html($i, $row, $fallas, 'disabled', $id);
            $i++;
        } while ($row = mysqli_fetch_array($notas));

        return $campos;
    }

    function nota_html($indice, $row, $fallas, $propiedad, $id)
    {
        $im_class = new IM();
        $durac_falla = '';
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        //$fallas = $im_class->get_fallas();
        $fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

        <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
    */

        if ($row['durac_compartida'] == 'NO') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice >= 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = $row['durac_falla_hor'];
        }


        //marcar cada uno de los indices 

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}&indice={$indice}&id={$id}&mth=editar' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";

        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";

        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='date' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
                            //<option value=''>--</option>"
                            if ($hora < 10) {
                                $campos .= "<option value='{$hora}'>{$hora}</option>";
                            } else {
                                $campos .= "<option value='{$hora}'>{$hora}</option>";
                            }
                            $campos .= "</select>";    */
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";   
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla   

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='date' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
                            //<option value=''>--</option>"                
                            if ($hora < 10) {
                                $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                            } else {
                                $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                            }
                            $campos .= "</select>";  */
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->"; 
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla        


        //AQUI AGREGO EL CAMPO PARA INDICAR SI LA FALLA ES COMPARTIDA O NO
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-10' style='font-weight: 500;' for='durac_compart_{$indice}'>Tiempo compartido:</label>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control' id='durac_compart_{$indice}' name='durac_compart_{$indice}' value='" . stripslashes($row['durac_compartida']) . "' disabled>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin completo p-2 -->";

        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($row['durac_falla_tpf'])."</textarea>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($durac_falla)."</textarea>";
        //$campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='".stripslashes($row['durac_falla_tpf'])."'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='" . stripslashes($durac_falla) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";

        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";  
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->"; 
        //  $campos .= "</div> <!-- /fin de p-2 -->";   
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";


        $campos .= "<p align='left'> 
             
             
        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}' name='edit_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='edit_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        $campos .= "</form>";

        /*notas rnec*/


        return $campos;


    }


    function get_notas_sin_tramitar_rnec($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_sin_tramitar_rnec = $im_class->get_notas_registro($id_disp);
        $notas_rnec = $im_class->get_notas_registro_rnec($id_disp,$id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        $j = 1;
        //     echo $notas == TRUE ? "hay algo en notas":"no hay nada en notas";
        $row = mysqli_fetch_array($notas_sin_tramitar_rnec);
        $row2 = mysqli_fetch_array($notas_rnec);
        do {

            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_sin_tramitar_rnec($i, $row, $fallas, 'disabled');
            do {
                $campos .= $this->get_notas_rnec($i,$row['id_falla_prv'],$id_disp);
            } while ($row2 = mysqli_fetch_array($notas_rnec));
            $i++;
        } while ($row = mysqli_fetch_array($notas_sin_tramitar_rnec));

        return $campos;
    }

    function nota_html_sin_tramitar_rnec($indice, $row, $fallas, $propiedad)
    {
        $im_class = new IM();
        $durac_falla = '';
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

            <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
        */

        if ($row['durac_compartida'] == 'NO') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice >= 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = $row['durac_falla_hor'];
        }


        //marcar cada uno de los indices

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        //$campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}&indice={$indice}&id={$id}&mth=editar' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";

        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";

        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    }
                                    $campos .= "</select>";    */
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    }
                                    $campos .= "</select>";  */
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla


        //AQUI AGREGO EL CAMPO PARA INDICAR SI LA FALLA ES COMPARTIDA O NO
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-10' style='font-weight: 500;' for='durac_compart_{$indice}'>Tiempo compartido:</label>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control' id='durac_compart_{$indice}' name='durac_compart_{$indice}' value='" . stripslashes($row['durac_compartida']) . "' disabled>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin completo p-2 -->";

        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($row['durac_falla_tpf'])."</textarea>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($durac_falla)."</textarea>";
        //$campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='".stripslashes($row['durac_falla_tpf'])."'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='" . stripslashes($durac_falla) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";

        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->";
        //  $campos .= "</div> <!-- /fin de p-2 -->";
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";

        $campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='show_{$indice}'>MOSTRAR EVALUACION</a></p>"; //primer boton

        $campos .= "<p align='left'>


        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}' name='edit_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='edit_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        //$campos .= "</form>";

        $campos .= "<div id='elemente_{$indice}' style='display: none;'>";

//$campos .= "<p><a class='btn btn-primary' href='#' id='show'><i class='fa fa-eye'></i> Mostrar</a></p>";



//contenido aca a ocultar
        //$campos .= "<h2>aca lo que oculto</h2>";

        $campos .= "<div class='deep-orange darken-1 white-text'>";
        //$campos .= "<div id='close'><a class='d-flex flex-row-reverse bd-highlight' href='#' id='hide' title='Cerrar este formulario'><i class='fa fa-times' aria-hidden='true'></i></a></div> ";
        $campos .= "<center>";
        $campos .= "<center><H2>ZONA DE CONCILIACION</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";
        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";
        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= "</br>";

        $campos .= "<div class='container'>";


        $campos .= "</br>";
        //<!--SECCION DE CAMPOS PARA MENSAJE QUE ENVIA RNEC -->


        $campos .= "<div class='container'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col'>";

        $campos .= "<label class='control-label' for='nota_observacion' style='font-weight: 500;'>FALLA
                        JUSTIFICADA</label>";

        $campos .= "<div class='custom-control custom-radio'>";
        $campos .= "<input type='radio' class='custom-control-input' id='falla_justif_si_{$indice}' name='falla_justif_{$indice}'
                               value='SI' checked>";
        $campos .= "<label class='custom-control-label' for='falla_justif_si_{$indice}'>SI</label>";
        $campos .= "</div>";

        //<!-- Default checked -->
        $campos .= "<div class='custom-control custom-radio'>";
        $campos .= "<input type='radio' class='custom-control-input' id='falla_justif_no_{$indice}' name='falla_justif_{$indice}'
                               value='NO'>";
        $campos .= "<label class='custom-control-label' for='falla_justif_no_{$indice}'>NO</label>";
        $campos .= "</div>";
        $campos .= "</div>";
        $campos .= "</br>";
        $campos .= "<div class='col-md-3'>";
        $campos .= "<label class='control-label' for='nota_observacion' style='font-weight: 500;'>APLICA
                        RESARCIMIENTO</label>";

        $campos .= "<div class='form-check'>";
        $campos .= "<input type='radio' class='form-check-input' id='aplica_resarc_si_{$indice}' name='aplica_resarc_{$indice}'
                               value='SI'>";
        $campos .= "<label class='form-check-label' for='aplica_resarc_si_{$indice}'>SI</label>";
        $campos .= "</div>";

        // <!-- Material checked -->
        $campos .= "<div class='form-check'>";
        $campos .= " <input type='radio' class='form-check-input' id='aplica_resarc_no_{$indice}' name='aplica_resarc_{$indice}'
                               value='NO' checked>";
        $campos .= "<label class='form-check-label' for='aplica_resarc_no_{$indice}'>NO</label>";
        $campos .= " </div>";
        $campos .= " </div>";
        $campos .= "<div class='col-md-6'>";
        $campos .= " <label class='control-label ' for='nota_observacion_rnec_{$indice}' style='font-weight: 500;'>OBSERVACIONES
                        ESPECIFICAS DE LA FALLA TIPIFICADA</label>";

        $campos .= "<div class='col-sm-12'>";
        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_rnec_{$indice}'
                                  id='nota_observacion_rnec_{$indice}' rows='2'></textarea>";
        $campos .= "</div>";
        $campos .= "</div>";
        $campos .= "</div>";
        $campos .= "</div>";
        $campos .= "</div>";


        $campos .= "</br>";
        $campos .= "</br>";
        $campos .= "</br>";

        //$campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi'>MOSTRAR RESPUESTA RNEC</a></p>"; //SEGUNDP BOTON
        $campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi_{$indice}'>Mostrar Respuestas</a></p>"; //primer boton

        //<!--FIN SECCION DE CAMPOS PARA MENSAJE QUE ENVIA RNEC -->
//TRAIGO ZONA DE CONCILIACION PARA RNEC


        $campos .= "</div>";
        $campos .= "</div>";

        return $campos;


    }


    function get_notas_pendientes_rnec($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_pendientes_rnec = $im_class->get_notas_registro($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        $row = mysqli_fetch_array($notas_pendientes_rnec);

        do {
            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_pendientes_rnec($i, $row, $fallas, 'disabled');
            $campos .= $this->get_notas_rnec($i,$row['id_falla_prv'],$id_disp);
            $i++;
        } while ($row = mysqli_fetch_array($notas_pendientes_rnec));

        return $campos;
    }

    function nota_html_pendientes_rnec($indice, $row, $fallas, $propiedad)
    {
        $im_class = new IM();
        $durac_falla = '';
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

            <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
        */

        if ($row['durac_compartida'] == 'NO') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice >= 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = $row['durac_falla_hor'];
        }


        //marcar cada uno de los indices

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}&indice={$indice}&id={$id}&mth=editar' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";

        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";

        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    }
                                    $campos .= "</select>";    */
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    }
                                    $campos .= "</select>";  */
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla


        //AQUI AGREGO EL CAMPO PARA INDICAR SI LA FALLA ES COMPARTIDA O NO
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-10' style='font-weight: 500;' for='durac_compart_{$indice}'>Tiempo compartido:</label>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control' id='durac_compart_{$indice}' name='durac_compart_{$indice}' value='" . stripslashes($row['durac_compartida']) . "' disabled>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin completo p-2 -->";

        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($row['durac_falla_tpf'])."</textarea>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($durac_falla)."</textarea>";
        //$campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='".stripslashes($row['durac_falla_tpf'])."'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='" . stripslashes($durac_falla) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";

        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->";
        //  $campos .= "</div> <!-- /fin de p-2 -->";
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";

        //$campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi'>Mostrar Respuestas</a></p>"; //primer boton
        $campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi_{$indice}'>Mostrar Respuestas</a></p>"; //primer boton


        $campos .= "<p align='left'>


        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}' name='edit_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='edit_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";




        $campos .= "</form>";

        /*notas rnec*/
        //$campos .= "<div id='elementor' class='elementor_br' style='display: none;'>";

        return $campos;

    }


    function get_notas_pendientes($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_pendientes = $im_class->get_notas_registro($id_disp);
        //$notas_rnec = $im_class->get_notas_registro_rnec($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        $row = mysqli_fetch_array($notas_pendientes);

        do {

            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_pendientes($i, $row, $fallas, 'disabled', $id);
            $campos .= $this->get_notas_rnec($i,$row['id_falla_prv'],$id_disp);
            $i++;
        } while ($row = mysqli_fetch_array($notas_pendientes));

        return $campos;
    }

    function nota_html_pendientes($indice, $row, $fallas, $propiedad, $id)
    {
        $im_class = new IM();
        $durac_falla = '';
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        //$fallas = $im_class->get_fallas();
        $fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

            <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
        */

        if ($row['durac_compartida'] == 'NO') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice == 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice > 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = '0:0';
        }


        //marcar cada uno de los indices

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}&indice={$indice}&id={$id}&mth=pendiente' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";

        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";

        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='date' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    }
                                    $campos .= "</select>";    */
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='date' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    }
                                    $campos .= "</select>";  */
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla


        //AQUI AGREGO EL CAMPO PARA INDICAR SI LA FALLA ES COMPARTIDA O NO
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-10' style='font-weight: 500;' for='durac_compart_{$indice}'>Tiempo compartido:</label>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control' id='durac_compart_{$indice}' name='durac_compart_{$indice}' value='" . stripslashes($row['durac_compartida']) . "' disabled>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin completo p-2 -->";

        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($row['durac_falla_tpf'])."</textarea>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($durac_falla)."</textarea>";
        //$campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='".stripslashes($row['durac_falla_tpf'])."'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='" . stripslashes($durac_falla) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";

        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->";
        //  $campos .= "</div> <!-- /fin de p-2 -->";
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";

        //$campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi'>Mostrar Respuestas RNEC</a></p>"; //primer boton

        $campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi_{$indice}'>Mostrar Respuestas</a></p>"; //primer boton


        $campos .= "<p align='left'>


        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}' name='edit_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='edit_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        $campos .= "</form>";

        /*notas rnec*/


        return $campos;


    }


    function get_notas_aprobadas($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_aprobadas = $im_class->get_notas_registro($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        $row = mysqli_fetch_array($notas_aprobadas);

        do {
            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_aprobadas($i, $row, $fallas, 'disabled');
            $campos .= $this->get_notas_rnec($i,$row['id_falla_prv'],$id_disp);
            $i++;
        } while ($row = mysqli_fetch_array($notas_aprobadas));

        return $campos;
    }

    function nota_html_aprobadas($indice, $row, $fallas, $propiedad)
    {
        $im_class = new IM();
        $durac_falla = '';
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

            <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
        */

        if ($row['durac_compartida'] == 'NO') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice >= 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = $row['durac_falla_hor'];
        }


        //marcar cada uno de los indices

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}&indice={$indice}&id={$id}&mth=editar' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";

        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";

        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    }
                                    $campos .= "</select>";    */
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    }
                                    $campos .= "</select>";  */
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla


        //AQUI AGREGO EL CAMPO PARA INDICAR SI LA FALLA ES COMPARTIDA O NO
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-10' style='font-weight: 500;' for='durac_compart_{$indice}'>Tiempo compartido:</label>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control' id='durac_compart_{$indice}' name='durac_compart_{$indice}' value='" . stripslashes($row['durac_compartida']) . "' disabled>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin completo p-2 -->";

        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($row['durac_falla_tpf'])."</textarea>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($durac_falla)."</textarea>";
        //$campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='".stripslashes($row['durac_falla_tpf'])."'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='" . stripslashes($durac_falla) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";

        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->";
        //  $campos .= "</div> <!-- /fin de p-2 -->";
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";

        $campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi_{$indice}'>Mostrar Respuestas</a></p>"; //primer boton



        $campos .= "<p align='left'>


        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}' name='edit_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='edit_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        $campos .= "</form>";
        $campos .= "</div>";
        /*notas rnec*/


        return $campos;


    }


    function get_notas_tramitadas($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_tramitadas = $im_class->get_notas_registro($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        $row = mysqli_fetch_array($notas_tramitadas);

        do {
            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_tramitadas($i, $row, $fallas, 'disabled');
            $campos .= $this->get_notas_rnec($i,$row['id_falla_prv'],$id_disp);
            $i++;
        } while ($row = mysqli_fetch_array($notas_tramitadas));

        return $campos;
    }

    function nota_html_tramitadas($indice, $row, $fallas, $propiedad)
    {
        $im_class = new IM();
        $durac_falla = '';
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

            <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
        */

        if ($row['durac_compartida'] == 'NO') {
            $durac_falla = $row['durac_falla_tpf'];
        } else if ($indice >= 1 && $row['durac_compartida'] == 'SI') {
            $durac_falla = $row['durac_falla_hor'];
        }


        //marcar cada uno de los indices

        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}&indice={$indice}&id={$id}&mth=editar' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";

        $campos .= "<center><input type='hidden' id='indice' name='indice' value={$indice}></center>";

        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora}'>{$hora}</option>";
                                    }
                                    $campos .= "</select>";    */
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        /*                            $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
                                    //<option value=''>--</option>"
                                    if ($hora < 10) {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    } else {
                                        $campos .= "<option value='{$hora1}'>{$hora1}</option>";
                                    }
                                    $campos .= "</select>";  */
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla


        //AQUI AGREGO EL CAMPO PARA INDICAR SI LA FALLA ES COMPARTIDA O NO
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-10' style='font-weight: 500;' for='durac_compart_{$indice}'>Tiempo compartido:</label>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control' id='durac_compart_{$indice}' name='durac_compart_{$indice}' value='" . stripslashes($row['durac_compartida']) . "' disabled>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin completo p-2 -->";

        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($row['durac_falla_tpf'])."</textarea>";
        //$campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>".stripslashes($durac_falla)."</textarea>";
        //$campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='".stripslashes($row['durac_falla_tpf'])."'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlob_{$indice}' disabled value='" . stripslashes($durac_falla) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";

        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->";
        //  $campos .= "</div> <!-- /fin de p-2 -->";
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";


        //$campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi'>Mostrar Respuestas RNEC</a></p>"; //primer boton
        $campos .= "<p align='right'><a class='btn sunny-morning-gradient text-dark' href='#' id='showi_{$indice}'>Mostrar Respuestas</a></p>"; //primer boton

        $campos .= "<p align='left'>


        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}' name='edit_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='edit_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        $campos .= "</form>";

        /*notas rnec*/


        return $campos;


    }


//esta sera el clon para replicar notas rnec junto a notas tigo
    function get_notas_replica($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_replica = $im_class->get_notas_registro($id_disp);
        // $notas_evaluacion = $im_class->get_notas_registro_rnec($id_disp);
        // $notas_evaluacion = mysqli_fetch_array($notas_evaluacion);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        //     echo $notas == TRUE ? "hay algo en notas":"no hay nada en notas";
        $row = mysqli_fetch_array($notas_replica);

        do {

            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_replica($i, $row, $fallas, 'disabled', $notas_evaluacion, $id_disp);
            $i++;
        } while ($row = mysqli_fetch_array($notas_replica));


        return $campos;
    }

    function nota_html_replica($indice, $row, $fallas, $propiedad, $notas_evaluacion, $id_disp)
    {
        $im_class = new IM();
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fallas = $im_class->get_fallas();
        //$fallas = $im_class->get_fallas_disponibles();
        $id_falla_prv = $row['id_falla_prv'];


        /*

        <form id="edit-IM" class="form-horizontal" action="index.php?contr=Consulta&act=guardar&id=<?php echo $id?>&mth=editar" method="post">
    */

        //marcar cada uno de los indices 
        $campos .= "<div>"; //este es alternayivo
        $campos = "<div id='div_nota_nueva_{$indice}'>";

        $campos .= "<form id='edit-falla_{$indice}' class='form-horizontal' action='index.php?contr=Consulta&act=editar_falla_individual&id_falla_prv={$id_falla_prv}>' method='post'>";
        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "<center><input type='hidden' id='id_falla_prv_{$indice}' name='id_falla_prv_{$indice}' value='" . stripslashes($id_falla_prv) . "'></center>";
        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;'for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  disabled='disabled'>";
        //<option value=''>--</option>"                
        if ($hora < 10) {
            $campos .= "<option value='{$hora}'>{$hora}</option>";
        } else {
            $campos .= "<option value='{$hora}'>{$hora}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";   
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla   

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' style='font-weight: 500;' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='text' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  disabled='disabled'>";
        //<option value=''>--</option>"                
        if ($hora < 10) {
            $campos .= "<option value='{$hora1}'>{$hora1}</option>";
        } else {
            $campos .= "<option value='{$hora1}'>{$hora1}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' disabled='disabled'>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->"; 
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla        


        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' style='font-weight: 500;'for='duracGlob_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<class='form-control' name='duracGlob_{$indice}' style='font-weight: 300;font-size: 22px;' id='duracGlob_{$indice}'  disabled>" . stripslashes($row['durac_falla_tpf']) . "</textarea>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-6' style='font-weight: 500;'for='tipo_falla_nuevo_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_nuevo_{$indice}' id='tipo_falla_nuevo_{$indice}' disabled='disabled'>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";  
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}' disabled>";
        $campos .= "</div>";
        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' disabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";


        // $campos .= "</div> <!-- /form-group -->"; 
        //  $campos .= "</div> <!-- /fin de p-2 -->";   
        //fin observaciones    <button onclick='disable() 'class='btn young-passion-gradient text-black'>ELIMINAR</button>


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";

        $campos .= "</br> <!-- /salto de linea -->";


        $campos .= "<p align='left'> 
             
             
        <button class='btn young-passion-gradient text-black' value='ELIMINAR' id='delete_tipificado_{$indice}'>ELIMINAR</button>
        <a href='#' class='btn btn-info text-black' id='edit_tipificado_{$indice}' value='EDITAR'>EDITAR</a>
             <button class='btn young-passion-gradient text-black' value='GUARDAR' id='save_tipificado_{$indice}' name='save_tipificado_{$indice}' style='display: none;'>GUARDAR</button>
            </p>";
        $campos .= "</form>";


        /*notas rnec*/
//aca empieza la notarnec replica
//$campos = "<div id='div_nota_nueva_{$indice}'>";


        $campos .= "<div class='red darken-3 white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2><i>RESPUESTA RNEC A TIGO # {$indice}</i></H2></center>";
        $campos .= "</center>";
        $campos .= "</div>";
        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='align-self-baseline'>";
        $campos .= " <center'>";
//start fallas justificada
        $campos .= " <div class='container'>";
        $campos .= "  <div class='row'>";
        $campos .= "  <div class='col-6'>";
        $campos .= " <label class='control-label' for='nota_observacion'style='font-weight: 500;'>FALLA JUSTIFICADA </label>";
        $campos .= "<div class='form-check'>";
        $campos .= "    <input type='radio' class='custom-control-input' id='falla_justif_si' name='falla_justif' value='0' disabled>";
        $campos .= "<label class='form-check-label' for='falla_justif_si'>" . $row['falla_justif'] . "</label>";
        $campos .= "   </div>";
        /*                         $campos .="    <div class='custom-control custom-radio'>";
                           $campos .="    <input type='radio' class='custom-control-input' id='falla_justif_no' name='falla_justif' value='1' checked disabled>";
                            $campos .="   <label class='custom-control-label' for='falla_justif_no'>NO</label>";
                        $campos .="     </div>  ";*/
        $campos .= "  </div>   ";
//end falla justificada
        //start aplica o no resarcimiento
        $campos .= "<div class='col-md-6'> ";
        $campos .= " <label class='control-label' for='nota_observacion'style='font-weight: 500;'>APLICA RESARCIMIENTO</label>";
        $campos .= "<div class='form-check'>";
        //  $campos .=" <input type='radio' class='form-check-input' id='aplica_resarc_si' name='aplica_resarc' disabled value=.'$row['aplica_resarc'].'>";
        $campos .= " <label class='form-check-label' for='aplica_resarc_si'>" . $row['aplica_resarc'] . "</label>";
        $campos .= " </div>";
        $campos .= "  </div>";
        $campos .= "</br>";
        $campos .= "</br>";
        //fin aplica o no resarcimiento
//start obervaciones
        $campos .= "<br>";
        $campos .= "</br>";
        $campos .= "</br>";

        //$campos .="  <div class='col-12'>";
        $campos .= "  <div class='d-flex justify-content-center'>";
        $campos .= "</br>";
        $campos .= "<label class='control-label col-sm-12'style='font-weight: 500;' for='nota_observacion_{$indice}'>OBSERVACIONES DE RNEC </label>";
        $campos .= "</br>";
        $campos .= "</div> <!-- /fin de p-2 -->";
        $campos .= "<div class='col-sm-12'>";
        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_rnec{$indice}'id='nota_observacion_rnec{$indice}' rows='5' readonly>" . stripslashes($row['observ_conc']) . "</textarea>";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</br> <!-- /saltolinea-->";
//end observacione
//QUIEN LO REALIZO                     
//$campos.= "<label class='row align-items-start'  style='font-style: italic; color:#424242; font-weight: 400;' for='nota_observacion_{$indice}'>&nbsp&nbsp   GESTIONADO POR:&nbsp ".$row['gestionado']."</label>";
//FIN QUIEN LO REALIZO
//$campos .= "</div> <!-- /fin de p-2 -->"; 
//$campos .= "</div> <!-- /fin de p-2 -->"; 
        $campos .= "</br> <!-- /saltolinea-->";

//aca acaba nota rnec replica


        return $campos;


    }


//fin clon replicar notas rnec tigo


//empieza notas editables
    function get_notas_editables($id = 0)
    {
        if ($id == 0)
            $id = $_POST['id'];
        $im_class = new IM();
        $id_disp = $im_class->get_id_disponibilidad($id);
        $id_disp = mysqli_fetch_array($id_disp);
        //       echo "id_disp = ".$id_disp["id_disp_cnl"];
        $id_disp = $id_disp["id_disp_cnl"];
        $notas_editables = $im_class->get_notas_registro($id_disp);
        $fallas = $im_class->get_fallas();
        $campos = '';
        $i = 1;
        //     echo $notas == TRUE ? "hay algo en notas":"no hay nada en notas";
        $row = mysqli_fetch_array($notas_editables);

        do {

            mysqli_data_seek($fallas, 0);
            $campos .= $this->nota_html_editables($i, $row, $fallas, 'enabled');
            $i++;
        } while ($row = mysqli_fetch_array($notas_editables));

        return $campos;
    }

    function nota_html_editables($indice, $row, $fallas, $propiedad)
    {
        $im_class = new IM();
        $hora = ($row['fec_ini_falla_tpf'] != '') ? date("H", strtotime($row['fec_ini_falla_tpf'])) : '';
        $minuto = ($row['fec_ini_falla_tpf'] != '') ? date("i", strtotime($row['fec_ini_falla_tpf'])) : '';
        $fecha = ($row['fec_ini_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_ini_falla_tpf'])) : '';

        $hora1 = ($row['fec_fin_falla_tpf'] != '') ? date("H", strtotime($row['fec_fin_falla_tpf'])) : '';
        $minuto1 = ($row['fec_fin_falla_tpf'] != '') ? date("i", strtotime($row['fec_fin_falla_tpf'])) : '';
        $fecha1 = ($row['fec_fin_falla_tpf'] != '') ? date("Y-m-d", strtotime($row['fec_fin_falla_tpf'])) : '';
        //$fallas = $im_class->get_fallas();
        $fallas = $im_class->get_fallas_disponibles();

        //marcar cada uno de los indices 

        $campos = "<div id='div_nota_nueva_{$indice}'>";


        $campos .= "<div class='mdb-color white-text'>";
        $campos .= "<center>";
        $campos .= "<center><H2>REGISTRO TIPIFICADO TIGO # {$indice}</H2></center>";
        $campos .= "</center>";
        $campos .= "</div>";


        $campos .= " <div class='d-flex justify-content-around'>";
        $campos .= " <div class='p-2'>";

        //comienzo fecha inicial falla


        $campos .= "<label class='control-label col-sm-5 fecha1' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Inicial </label>";

        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='date' class='form-control fechas' name='nota_fecha_creado_nuevo_{$indice}' id='nota_fecha_creado_nuevo_{$indice}' value='{$fecha}'>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        $campos .= "<select class='form-control lista horas' name='nota_hora_creado_nuevo_{$indice}' id='nota_hora_creado_nuevo_{$indice}'  enabled='enabled''>";
        $campos .= "<option value='{$hora}' selected>{$hora}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_creado_nuevo_{$indice}'  id='nota_minuto_creado_nuevo_{$indice}' value='{$minuto}' enabled='enabled''>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        //   $campos .= "</div> <!-- /form-group -->";   
        $campos .= "</div> <!-- /fin de p-2 -->";

        //fin fecha inicial falla   

        //comienzo fecha final falla
        //fecha inicial   = fec_ini_falla_tpf
//fecha finakl = fec_fin_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-5 fecha1' for='nota_fecha_creado_nuevo_{$indice}'>Fecha Final </label>";
        $campos .= "<div class='col-sm-8 fecha' id='nota_creacion_nuevo_{$indice}'>";
        $campos .= "<div class='row'>";
        $campos .= "<div class='col-sm-5'>";
        $campos .= "<input type='date' class='form-control fechas' name='nota_fecha_finalizado_nuevo_{$indice}' id='nota_fecha_finalizado_nuevo_{$indice}' value='{$fecha1}' enabled='enabled''>";
        $campos .= "</div> <!-- /col-sm-5 -->";
        $campos .= "<div class='col-sm-4'>";
        $campos .= "<select class='form-control lista horas' name='nota_hora_finalizado_nuevo_{$indice}' id='nota_hora_finalizado_nuevo_{$indice}'  enabled='enabled''>";
        $campos .= "<option value='{$hora1}' selected>{$hora1}</option>";
        for ($i = 0; $i < 24; $i++) {
            if ($hora < 10) {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            } else {
                $campos .= "<option value='" . $i . "'>" . $i . "</option>";
            }
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        $campos .= "<div class='col-sm-3'>";
        $campos .= "<input type='text' class='form-control minutos' name='nota_minuto_finalizado_nuevo_{$indice}'  id='nota_minuto_finalizado_nuevo_{$indice}' value='{$minuto1}' enabled='enabled''>";
        $campos .= "</div> <!-- /col-sm-3 -->";
        $campos .= "</div> <!-- /row -->";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</div> <!-- /form-group -->"; 
        $campos .= "</div> <!-- /fin de p-2 -->";
        //fin fecha final falla        


        //inicio campo tiempo de duracion   duracion= durac_falla_tpf
        $campos .= " <div class='p-2'>";
        $campos .= "<label class='control-label col-sm-8' for='duracGlobPend_{$indice}'>Duracion:</label>";
        $campos .= "<div class='col-sm-6'>";
        $campos .= "<input class='form-control' name='duracGlob_{$indice}' id='duracGlobPend_{$indice}' value='" . stripslashes($row['durac_falla_tpf']) . "'>";
        $campos .= "</div> <!-- /controls -->";
        $campos .= "</div> <!-- /fin de p-2 -->";
        // fin campo duracion
        $campos .= "</div> <!-- /fin completo p-2 -->";
        $campos .= "</br> <!-- /salto de linea -->";


///////////////////////////////////////////////////////////2 renglon tipo de flla y observaciones
//prueba
        $campos .= " <div class='row justify-content-around'>";
        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-6' for='tipo_falla_{$indice}'>Tipo de Falla </label>";
        $campos .= "<select class='form-control lista' name='tipo_falla_{$indice}' id='tipo_falla_{$indice}' enabled='enabled''>";
        $rows = $im_class->get_falla_por_id($row['id_tipo_falla']);
        $rows = mysqli_fetch_array($rows);
        $campos .= "<option value='{$rows['tipo_falla_id']}' selected>{$rows['tipo_falla_responsable']}#{$rows['tipo_falla_descripcion']}</option>";
        while ($rows2 = mysqli_fetch_array($fallas)) {
            $campos .= "<option value='{$rows2['tipo_falla_id']}'>{$rows2['tipo_falla_responsable']}#{$rows2['tipo_falla_descripcion']}</option>";
        }
        $campos .= "</select>";
        $campos .= "</div> <!-- /col-sm-4 -->";
        // $campos .= "</select>";  
//fin prueba

        //comienzo numero ticket
        $campos .= "<div class='col-sm-2'>";
        $campos .= "<label class='control-label' style='font-weight: 500;' for='numero_ticket_{$indice}'>Numero de Ticket </label>";
        $campos .= "<input type='text' class='form-control' id='numero_ticket_{$indice}' name='numero_ticket_{$indice}' value='{$row['num_ticket']}'>";
        $campos .= "</div>";

        //comienzo observaciones

        $campos .= " <div class='col-sm-4'>";
        $campos .= "<label class='control-label col-sm-5' for='nota_observacion_{$indice}'>OBSERVACIONES </label>";


        $campos .= "<textarea class='form-control nota_observacion' name='nota_observacion_{$indice}' id='nota_observacion_{$indice}' rows='5' enabled>" . stripslashes($row['observ_falla_tpf']) . "</textarea>";
        // $campos .= "</div> <!-- /col-6 -->";
        $campos .= "</div> <!-- /row -->";

        // $campos .= "</div> <!-- /form-group -->"; 
        //  $campos .= "</div> <!-- /fin de p-2 -->";   
        //fin observaciones 


        $campos .= "</div> <!-- /fin de p-2 -->";

        $campos .= "</br> <!-- /saltolinea-->";
//$campos .= "<p>_______________________________________________________________________________________________________________________________________________________________</p> <!-- /saltolinea-->";


        $campos .= "</br> <!-- /salto de linea -->";
        return $campos;
    }
    //acaba notas editables


//-*-*-*-*-*-* COMIENZO FUNCIONES QUE CREAN EXCEL
    function consulta_reporte_registros_cargados()
    { //FUNCION QUE LLAMA EXCEL  SIN TRAMITAR RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_registros_cargados.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        //$im_abiertos = $im->get_registro_fallas_dias_horario($tipo);
        $im_abiertos = $im->get_registros_cargados();
        /*$datos_im_fechas = array();
       $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
       $i = 0;*/

        //echo "ENTRE A LA FUNCION consulta_reporte_dias_horario"."<br>";
        $numrows = mysqli_num_rows($im_abiertos);
        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');
        //carga la plantilla
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_cargados.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //echo 'CANTIDAD REGISTROS ENCONTRADOS DIAS = '.$numrows."<br>";
        //$this->listar();

    }

    function consulta_reporte_canales_caidos()
    { //FUNCION QUE LLAMA EXCEL  SIN TRAMITAR RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_canales_caidos.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        //$im_abiertos = $im->get_registro_fallas_dias_horario($tipo);
        $im_abiertos = $im->get_registro_canales_caidos();
        /*$datos_im_fechas = array();
       $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
       $i = 0;*/

        //echo "ENTRE A LA FUNCION consulta_reporte_dias_horario"."<br>";
        $numrows = mysqli_num_rows($im_abiertos);
        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');
        //carga la plantilla
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_caidos.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //echo 'CANTIDAD REGISTROS ENCONTRADOS DIAS = '.$numrows."<br>";
        //$this->listar();

    }

    function consulta_reporte_cantidad_tipificados_usuario(){
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_registros_tipificados.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registros_tipificados_usuario();

        $numrows = mysqli_num_rows($im_abiertos);
        //carga la plantilla
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_tipificados_usuario.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
    }


    function consulta_reporte_registros_sin_tramitar(){
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_registros_sin_tramitar.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registros_sin_tramitar($tipo);

        $numrows = mysqli_num_rows($im_abiertos);
        //carga la plantilla
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_sin_tramitar.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
    }

    function consulta_reporte_valores_canales(){
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_valores_canales.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_valores_canales($tipo);

        $numrows = mysqli_num_rows($im_abiertos);
        //carga la plantilla
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_valores.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
    }

    function consulta_reporte_dias_horario()
    { //FUNCION QUE LLAMA EXCEL  SIN TRAMITAR RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reporte_dias_fallas_horario.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registro_fallas_dias_horario($tipo);
        /*$datos_im_fechas = array();
       $datos_im = $im->reporte($fecha_menor, $fecha_mayor);
       $i = 0;*/

        //echo "ENTRE A LA FUNCION consulta_reporte_dias_horario"."<br>";
        $numrows = mysqli_num_rows($im_abiertos);
        //$ruta = $this->view->path($config->get('contenido') .'im_reporte_generar.php');        
        //carga la plantilla 
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_abierto.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //echo 'CANTIDAD REGISTROS ENCONTRADOS DIAS = '.$numrows."<br>";
        //$this->listar();

    }

    function consulta_reporte_fallas_tipificadas()
    { //FUNCION QUE LLAMA EXCEL  tramitado tigo y sin tramitar RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reportes_fallas_tipificadas.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registro_fallas_tipificadas($tipo);
        $numrows = mysqli_num_rows($im_abiertos);
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_tramitado.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();  
    }


    function consulta_reporte_pendiente()
    { //FUNCION QUE LLAMA EXCEL  pendiente tigo- RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reportes_pendientes.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registro_pendiente($tipo);
        $numrows = mysqli_num_rows($im_abiertos);
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_pendiente.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();  
    }

    function consulta_reporte_aprobado()
    { //FUNCION QUE LLAMA EXCEL aprobado RNEC
        // Header para crear archivo EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Reportes_aprobados.xls"); //aca cambio la cabecera

        $tipo = $_GET['tipo'];
        // var_dump($tipo);
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $divipol = new Divipol();
        $im_abiertos = $im->get_registro_aprobado($tipo);
        $numrows = mysqli_num_rows($im_abiertos);
        ob_start();
        include $config->get('contenido') . 'consulta_reporte_aprobado.php';
        $pagina = ob_get_clean();
        $this->view->view_page($pagina);
        //$this->listar();  
    }


    //-*-*-*-*-*-*-*FIN FUNCIONES QUE CREAN EL,EXCEL  
    function actualizar_desarrollo()
    {
        require 'configs.php'; //Archivo con configuraciones.
        set_time_limit(0);
        $im = new IM();
        $lista_im = $im->get_list_ticket_im_id_0();
        while ($row = mysqli_fetch_array($lista_im)) {
            $id = mysqli_fetch_array($im->get_otrs_ticket_id($row['reg_ticket_num']));
            $im->update_registro_ticket_id($row['reg_ticket_num'], $id['id']);
        }


    }

    function get_cliente()
    {
        $id_depart = $_GET['id_depart'];
        $id_munic = $_GET['id_munic'];
        $id_sede = $_GET['id_sede'];
        $im = new IM();
        $cliente = $im->get_cliente($id_depart, $id_munic, $id_sede);
        $numrows = @mysqli_num_rows($cliente);
        if ($numrows > 0)
            $cliente_data = mysqli_fetch_array($cliente);
        else
            $cliente_data = array('reg_cliente' => '');
        echo json_encode($cliente_data);
        //echo $cleinte_data['reg_cliiente'];
    }


    function listar_archivos()
    {
        //$ruta = "\\\\172.20.60.111\\Documentos-UneTigo\\Seguimiento_proyectos\\";
        //$ruta = "Z:\\1. Fichas de Proyectos";
        //$ruta = "C:\\Users\\rnunez\\Desktop\\pagos";
        $ruta = "pagos";
        $salida = '';
        $salida = "<div id='MainMenu'>";
        $salida .= '<div class="list-group panel">';
        //$salida .= '<ul class="nav nav-stacked" id="accordion1">';
        $salida .= $this->listar_directorios_ruta($ruta);
        //$salida .= '</ul>';
        $salida .= '</div>';
        $salida .= '</div>';


        /*$salida .= '<div id="MainMenu">
  <div class="list-group panel">
    <a href="#demo3" class="list-group-item list-group-item-success strong" data-toggle="collapse" data-parent="#MainMenu">Item 1 <i class="fa fa-caret-down"></i></a>
    <div class="collapse" id="demo3">
      <a href="#SubMenu1" class="list-group-item strong" data-toggle="collapse" data-parent="#SubMenu1">Subitem 1 <i class="fa fa-caret-down"></i></a>
      <div class="collapse list-group-submenu" id="SubMenu1">
        <a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 1 a</a>
        <a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 2 b</a>
        <a href="#SubSubMenu1" class="list-group-item strong" data-toggle="collapse" data-parent="#SubSubMenu1"><i class="glyphicon glyphicon-user"></i> Subitem 3 c <i class="fa fa-caret-down"></i></a>
        <div class="collapse list-group-submenu list-group-submenu-1" id="SubSubMenu1">
          <a href="#" class="list-group-item" data-parent="#SubSubMenu1">Sub sub item 1</a>
          <a href="#" class="list-group-item" data-parent="#SubSubMenu1">Sub sub item 2</a>
        </div>
        <a href="#" class="list-group-item" data-parent="#SubMenu1">Subitem 4 d</a>
        <a href="#SubSubMenu3" class="list-group-item strong" data-toggle="collapse" data-parent="#SubSubMenu3"><i class="glyphicon glyphicon-dashboard"></i> Subitem 5 e <i class="fa fa-caret-down"></i></a>
            <div class="collapse list-group-submenu list-group-submenu-1" id="SubSubMenu3">
                <a href="#" class="list-group-item" data-parent="#SubSubMenu3">Sub sub item 5.1</a>
                <a href="#" class="list-group-item" data-parent="#SubSubMenu3">Sub sub item 5.2</a>
            </div>
      </div>
      <a href="#" class="list-group-item">Subitem 2</a>
      <a href="#" class="list-group-item">Subitem 3</a>
    </div>
    <a href="#demo4" class="list-group-item list-group-item-success strong" data-toggle="collapse" data-parent="#MainMenu">Item 2 <i class="fa fa-caret-down"></i></a>
    <div class="collapse" id="demo4">
      <a href="#" class="list-group-item">Subitem 1</a>
      <a href="#SubSubMenu4" class="list-group-item strong" data-toggle="collapse" data-parent="#SubSubMenu4"><i class="glyphicon glyphicon-thumbs-up"></i> Subitem 2 <i class="fa fa-caret-down"></i></a>
      <div class="collapse list-group-submenu list-group-submenu-1" id="SubSubMenu4">
        <a href="#" class="list-group-item" data-parent="#SubSubMenu1"><i class="glyphicon glyphicon-flag"></i> Sub sub item 1</a>
        <a href="#" class="list-group-item" data-parent="#SubSubMenu1"><i class="glyphicon glyphicon-cog"></i> Sub sub item 2</a>
        </div>
      <a href="#" class="list-group-item">Subitem 3</a>
    </div>
  </div>
</div>';*/


        $ruta = $this->view->path('default/page1.php');
        //carga la plantilla 
        $pagina = $this->view->load_page($ruta);
        $pagina = $this->view->load_template('Arbol de Archivos ', $pagina);
        //$contenido = $this->view->load_page($config->get('contenido') .'tabla.php');
        //$pagina = $this->view->load_content();

        $pagina = $this->view->replace_content('/\#CONTENIDO#/ms', $salida, $pagina);
        //cargar el Script para generar la trabla
        //$pagina = $this->view->replace_content('/\<!--script-->/ms', $script_insert , $pagina);
        $this->view->view_page($pagina);
    }


    function listar_directorios_ruta($ruta = '', $sub = false)
    {
        //$prefijo = "file:\\";
        $salida = '';
        /*if($rutas == '') 
            $ruta = "\\\\172.20.60.111\\Documentos-UneTigo\\Seguimiento_proyectos\\";
        else
            $ruta = $rutas;*/
        // Se comprueba que realmente sea la ruta de un directorio
        if (is_dir($ruta)) {
            // Abre un gestor de directorios para la ruta indicada
            $gestor = opendir($ruta);
            //array con lo valores que se van a remplazar en la cadena de la ruta del archivo  
            $remplazo = array(":", "\\", ".", " ");

            // Recorre todos los elementos del directorio
            while (($archivo = readdir($gestor)) !== false) {

                //echo $ruta_completa;

                // Se muestran todos los archivos y carpetas excepto "." y ".."
                if ($archivo != "." && $archivo != "..") {
                    $ruta_completa = $ruta . "\\" . $archivo;
                    $ruta_completa_2 = $ruta . "/" . $archivo;
                    $ruta_completa_2 = str_replace("\\", "/", $ruta_completa_2);
                    $archivoSinEspacios = str_replace($remplazo, "_", $ruta_completa);
                    //echo $ruta_completa;

                    // Si es un directorio se recorre recursivamente
                    if (is_dir($ruta_completa)) {
                        if (!$sub) {
                            $salida .= "<a href='#$archivoSinEspacios' class='list-group-item list-group-item-success strong' data-toggle='collapse' data-parent='#MainMenu'>$archivo<i class='fa fa-caret-down'></i></a>";
                            $salida .= "<div class='collapse' id='$archivoSinEspacios'>";
                        } else {
                            $salida .= "<a href='#$archivoSinEspacios' class='list-group-item strong' data-toggle='collapse' data-parent='#$archivoSinEspacios'>$archivo<i class='fa fa-caret-down'></i></a>";
                            $salida .= "<div class='collapse list-group-submenu' id='$archivoSinEspacios'>";
                        }
                        //$salida .= "<li class='panel'> <a data-toggle='collapse' data-parent='#accordion1' href='#Link_$archivo'>$archivo</a>"; 
                        //$salida .= "<ul id='Link_$archivo' class='collapse'>";                       
                        //echo "<li>" . $archivo . "</li>";
                        $salida .= $this->listar_directorios_ruta($ruta_completa, true);
                        $salida .= "</div>";
                        //$salida .= "</li>";

                    } else {
                        if (!$sub) {
                            $salida .= "<a href='$ruta_completa_2' target='_blank' class='list-group-item'>$archivo</a>";
                            //$salida .= "<li>" . $archivo . "</li>";
                        } else {
                            $salida .= "<a href='$ruta_completa_2' target='_blank' class='list-group-item' data-parent='#$archivoSinEspacios'>$archivo</a>";
                        }
                    }
                }
            }
            // Cierra el gestor de directorios
            closedir($gestor);
            //echo "</ul>";
        } else {
            echo $ruta;
            echo "No es una ruta de directorio valida<br/>";
        }
        return $salida;
    }

    /***************************************/
    /***************************************/
    /*LISTA DE FUNCIONES DEL NUEVO PROYECTO*/
    /***************************************/
    /***************************************/

    function sedes()
    {
        $consulta = new Consulta();
        $divipol = new Divipol();
        $id_depart = $_GET['id'];
        $seleccionados = explode(",", $id_depart);
        foreach ($seleccionados as $seleccionado) {
            $sedes = $consulta->get_sedes($seleccionado);
            $departamento = $divipol->get_departamento_by_id($seleccionado);
            $departamento = mysqli_fetch_array($departamento);
            echo "<select class='form-control lista' name='sedes_" . $seleccionado . "[]' id='sedes_" . $seleccionado . "' multiple style='height: 500px; width: 500px;'>";
            echo "<optgroup label='" . $departamento['departamento_nombre'] . "'>";
            while ($row = mysqli_fetch_array($sedes)) {
                echo "<option value='" . $row['alias_sede'] . "'>" . $row['alias_sede'] . "</option>";
            }
            echo "</optgroup>";
            echo "</select><br>";
        }
    }

    function consulta_sedes()
    {
        $consulta = new Consulta();
        $divipol = new Divipol();
        $id_depart = $_GET['id'];
        $ctn = 1;
        $seleccionados = explode(",", $id_depart);
        echo "<div class='row'>";
        foreach ($seleccionados as $seleccionado){
            echo "<div class='col-4'  style='background-color:#ffffff; border: 1px solid grey;'>";
            $sedes = $consulta->get_sedes($seleccionado);
            $departamento = $divipol->get_departamento_by_id($seleccionado);
            $departamento = mysqli_fetch_array($departamento);
            echo "<hr><p align='center'><strong>".$departamento['departamento_nombre']."</strong></p><hr>";
            while ($row = mysqli_fetch_array($sedes)){
               echo "<p align='left'><input type='checkbox' class='ck' id='sd_".$row['id_sede']."' name='sd_".$row['id_sede']."' value='".$row['id_sede']."'>";
               echo "&nbsp<span>".$row['alias_sede']."</span></p>";
            }
            echo "</div>";
            $ctn++;
        }
        echo "</div>";

    }





    function obtener_fecha($cadena)
    {
        $cadena_fecha = str_replace("/", "-", $cadena);
        $fecha_final = date('Y-m-d H:i:s', strtotime($cadena_fecha));
        return $fecha_final;
    }


    function obtener_fecha_consulta($cadena, $tipo_fecha)
    {
        $fecha_consulta = '';
        $cadena_fecha = str_replace("/", "-", $cadena);
        $cadena_fecha = explode(" ", $cadena_fecha);
        $cadena_fecha = $cadena_fecha[0];
        if ($tipo_fecha == "desde") {
            $hora_desde = "00:00:00";
            $fecha_inicial = $cadena_fecha . " " . $hora_desde;
            $fecha_consulta = date('Y-m-d H:i:s', strtotime($fecha_inicial));
        }
        if ($tipo_fecha == "hasta") {
            $hora_hasta = "23:59:59";
            $fecha_final = $cadena_fecha . " " . $hora_hasta;
            $fecha_consulta = date('Y-m-d H:i:s', strtotime($fecha_final));
        }

        return $fecha_consulta;
    }


    function conversion_porcentaje($porc)
    {
        $porcentaje = $porc * 100;
        $porcentaje .= "%";
        return $porcentaje;
    }


    public function get_nombre_dia($fecha)
    {
        $fechats = strtotime($fecha); //pasamos a timestamp
        //el parametro w en la funcion date indica que queremos el dia de la semana
        //lo devuelve en numero 0 domingo, 1 lunes,....
        switch (date('w', $fechats)) {
            case 0:
                return "Domingo";
                break;
            case 1:
                return "Lunes";
                break;
            case 2:
                return "Martes";
                break;
            case 3:
                return "Miercoles";
                break;
            case 4:
                return "Jueves";
                break;
            case 5:
                return "Viernes";
                break;
            case 6:
                return "Sabado";
                break;
        }
    }


    function obtener_fecha_completa($cadena)
    {
        $cadena_fecha = str_replace("/", "-", $cadena);
        $fecha_final = date('Y-m-d H:i:s', strtotime($cadena_fecha));
        return $fecha_final;
    }


    function obtener_fallas_dias_horario($id)
    {
        //echo "ENTRE AL METODO obtener_fallas_dias_horario"."<br>";
        $consulta_class = new IM();
        $im_regitro = '';
        $im_reg_disponibilidad = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
                //echo "Entro por get_registro"."<br>";
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        //$numrows = mysqli_num_rows($im_regitro);

        //if($numrows > 0){
        $im_regitro = mysqli_fetch_array($im_regitro);
        //$im_regitro['reg_observacion'] = str_replace("⌂Ç", "\n", $im_regitro['reg_observacion']);
        $id_disp_cnl = $im_regitro['id_disp_cnl'];
        //echo "TENGO EL id = ".$id."<br>";
        //echo "TENGO EL id_disp_cnl = ".$id_disp_cnl."<br>";
        $fallas_dias = $this->get_fallas_dias($id_disp_cnl);
        //}
        //header("Location: ../resarcimientos/index.php?contr=Consulta&act=index");
        return $fallas_dias;

    }


    function get_fallas_dias($id_disp_cnl)
    {
        //echo "ENTRE AL METODO get_fallas_dias"."<br>";
        $consulta_class = new IM();
        $fallas_dias = $consulta_class->get_fallas_dias_por_id($id_disp_cnl);
        $campos = '';

        //$campos = "<div class='container' id='fallas_dias'>";
        //$campos .= "<h2>Fallas registradas dentro del horario laboral</h2>";
        $campos .= "<table class='table table-bordered'>";
        $campos .= "<thead><tr>";
        $campos .= "<th>Dia</th>";
        $campos .= "<th>Fecha y hora inicial</th>";
        $campos .= "<th>Fecha y hora final</th>";
        $campos .= "<th>Duracion de la falla</th>";
        $campos .= "</tr></thead>";
        $campos .= "<tbody>";

        while ($row = mysqli_fetch_array($fallas_dias)) {
            $campos .= $this->nota_falla_dia($row, $campos);
        }
        $campos .= "</tbody>";
        $campos .= "</table>";
        //$campos .= "</div>";
        echo $campos;
        return $campos;
    }


    function nota_falla_dia($row)
    {
        $campos = '';
        $campos .= "<tr>";
        $campos .= "<td>{$row['nombre_dia']}</td>";
        $campos .= "<td>{$row['fec_ini_dia']}</td>";
        $campos .= "<td>{$row['fec_fin_dia']}</td>";
        $campos .= "<td>{$row['durac_falla_dia']}</td>";
        $campos .= "</tr>";
        return $campos;
    }


    //CODIGO ORIGINAL
    /*
    function consultar(){
        //$cadena_equipo1=$cadena_equipo;
        $consulta = new IM();
        $divipol = new Divipol();
        $nombre_sedes = array();
        $sedes = array();
        $fechaDesde = $this->obtener_fecha_consulta($_POST['desdeFec'],"desde");
        $fechaHasta = $this->obtener_fecha_consulta($_POST['hastaFec'],"hasta");
        $departamentos = $_POST['departamento'];
        $horario = $_POST['horario'];
        $duracion = $_POST['cant_minutos'];
        $horaDesde = $_POST['horario_desde'];
        $horaHasta = $_POST['horario_hasta'];
//        $boton = $_POST['consulta'];

        $desdeFec=$_POST['desdeFec'];
        $hastaFec=$_POST['hastaFec'];
        $tomarboton=$_POST['control_boton'];
        $departamento=$_POST['departamento'];

        if ($desdeFec=="" or substr($desdeFec,0,1)==" ") {} else {$_SESSION['desdeFec']=$desdeFec;}
        if ($hastaFec=="" or substr($hastaFec,0,1)==" ") {} else {$_SESSION['hastaFec']=$hastaFec;}
        if ($departamento=="" or substr($departamento,0,1)==" ") {} else {$_SESSION['departamento']=$departamento;}
        if ($tomarboton=="" or substr($tomarboton,0,1)==" ") {} else {$_SESSION['control_boton']=$tomarboton;}

        // echo "Fecha desde = ".$fechaDesde."<br>"; original
        // echo "de chimbas =" .$_SESSION['hastaFec'];
        //   echo "Fecha desde = ".$_SESSION['desdeFec']."<br>";
        //  echo "Fecha hasta = ".$_SESSION['hastaFec']."<br>";
        // echo "el depto cod es=".$cadena_equipo."<br>";
        //  echo "Horario = ",$horario."<br>";
        // echo "Hora desde = ".$horaDesde."<br>";
        // echo "Hora hasta = ".$horaHasta."<br>";




        $query_departamentos = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades
        ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl WHERE ((fallas.fec_ini_falla_cnl >= '".$fechaDesde."'
         AND fallas.fec_fin_falla_cnl <= '".$fechaHasta."') OR disponibilidades.estado_canal = 'DOWN') AND fallas.durac_min_cnl >= '".$duracion."'
         AND disponibilidades.id_departamento IN(";
        $query_sedes = $query_departamentos;
        $query_enviado = '';
        //echo "Fecha desde = ".$fechaDesde."<br>";
        //echo "Fecha hasta = ".$fechaHasta."<br>";
        //echo "Horario = ".$horario."<br>";
        //echo "Duracion = ".$duracion."<br>";
        //echo "Hora desde = ".$horaDesde."<br>";
        //echo "Hora hasta = ".$horaHasta."<br>";
        //echo "Boton = ".$boton."<br>";
        for($i=0;$i<count($departamentos);$i++){
            //echo "id_departamento = ".$departamentos[$i]."<br>";
            $query_sedes .= $departamentos[$i];
            if($i == count($departamentos) - 1){
                $query_sedes .= ")";
            }else{
                $query_sedes .= ", ";
            }
            $sedes = @$_POST['sedes_'.$departamentos[$i]];
            if($sedes != ''){
                for($j=0;$j<count($sedes);$j++){
                    //echo "id_alias = ".$sedes[$j]."<br>";
                    array_push($nombre_sedes,$sedes[$j]);
                    $resultados_2 = $consulta->get_id_departamento_sede($sedes[$j]);
                    $resultados_2 = mysqli_fetch_array($resultados_2);
                    if($resultados_2['id_depart']==$departamentos[$i]){
                        $resultados_3 = $consulta->get_consulta_por_sedes($fechaDesde,$fechaHasta,$departamentos[$i],$duracion,$sedes[$j]);
                        while($row=mysqli_fetch_array($resultados_3)){
                            //echo "<div>'".$row['id_falla_cnl']."'</div><br>";
                            $consulta->get_disponibilidad_horario($row['id_falla_cnl'],$horario,$horaDesde,$horaHasta);
                        }
                    }
                }
            }else{
                $resultados = $consulta->get_consulta_por_departamento($fechaDesde,$fechaHasta,$departamentos[$i],$duracion);
                $query_departamentos .= $departamentos[$i];
                if($i == count($departamentos) - 1){
                    $query_departamentos .= ")";
                }else{
                    $query_departamentos .= ", ";
                }
                while($row=mysqli_fetch_array($resultados)){
                    //echo "<div>'".$row['id_falla_cnl']."'</div><br>";
                    $consulta->get_disponibilidad_horario($row['id_falla_cnl'],$horario,$horaDesde,$horaHasta);
                }
            }
        }


        //session_start();

        //  echo "query resultante = ".$query."<br>";
        //$_SESSION['query_resultante'] = $query;
        //$_SESSION['query_resultante2'] = $queryprueba;
        //   echo "query variable de sesion = ".$_SESSION['query_resultante']."<br>";
        //$consulta->insertpruebasdato($cadena);
        //echo "acabo de agregar a la bd el query"."<br>";

        // session_start();

        //
        //  $desdeFec=$_POST['desdeFec'];
        //   $hastaFec=$_POST['hastaFec'];
        //   $tomarboton=$_POST['control_boton'];
        //  $departamento=$_POST['departamento'];

        //   if ($desdeFec=="" or substr($desdeFec,0,1)==" ") {} else {$_SESSION['desdeFec']=$desdeFec;}
        //   if ($hastaFec=="" or substr($hastaFec,0,1)==" ") {} else {$_SESSION['hastaFec']=$hastaFec;}
        //  if ($departamento=="" or substr($departamento,0,1)==" ") {} else {$_SESSION['departamento']=$departamento;}
        //   if ($tomarboton=="" or substr($tomarboton,0,1)==" ") {} else {$_SESSION['control_boton']=$tomarboton;}


        if($sedes != ''){
            $cadena = " AND fallas.alias_sede_cnl IN(";
            for($k=0;$k<count($nombre_sedes);$k++){
                $cadena .= "'".$nombre_sedes[$k]."'";
                if($k == count($nombre_sedes) - 1){
                    $cadena .= ")";
                }else{
                    $cadena .= ", ";
                }
            }
            //echo "sedes = ".$cadena."<br>";
            $query_sedes .= $cadena;
            $query_enviado = $query_sedes;
            //echo "query resultante sedes = ".$query_enviado."<br>";
        }else{
            $query_enviado = $query_departamentos;
            //echo "query resultante departamentos = ".$query_enviado."<br>";
        }

        //echo "query_enviado = ".$query_enviado."<br>";

        $_SESSION['query_resultante'] = $query_enviado;

        //echo "query_resultante (asignado) = ".$_SESSION['query_resultante']."<br>";

/*        switch($boton){
            case 'sin_tramitar':
                $condicion = " AND estado_tramite = 'SIN TRAMITAR'";
                $query_enviado .= $condicion;
                $this->index($query_enviado);
                //$consulta->show_registros($query_enviado);
            break;
            case 'tramitados':
                $condicion = " AND estado_tramite = 'TRAMITADO'";
                $query_enviado .= $condicion;
                $this->index($query_enviado);
                //$consulta->show_registros($query_enviado);
            break;
            case 'pendientes':
                $condicion = " AND estado_tramite = 'PENDIENTE'";
                $query_enviado .= $condicion;
                $this->index($query_enviado);
                //$consulta->show_registros($query_enviado);
            break;
            case 'aprobados':
                $condicion = " AND estado_tramite = 'APROBADO'";
                $query_enviado .= $condicion;
                $this->index($query_enviado);
                //$consulta->show_registros($query_enviado);
            break;
        }*/


    /*
        $_SESSION['deptos_seleccionados'] = array();

        for($i=0;$i<count($departamento);$i++){
            array_push($_SESSION['deptos_seleccionados'], $departamento[$i]);
            //   echo "estoy guardando este codigo de departamento = ".$departamentos[$i]."<br>";




            $array_equipo = $_SESSION['deptos_seleccionados'];

            $cadena_equipo = implode(",", $array_equipo);
            //    echo "El equipo separaro por ',' es el siguiente: " .$cadena_equipo;

            $cadena_equipo2 = implode($array_equipo);
            //      echo "<br><br>El equipo sin parámetro string es el siguiente: " .$cadena_equipo2;


            $_SESSION['deptos_seleccionados']=$cadena_equipo;
            //      echo 'mis deptos son:'.$_SESSION['deptos_seleccionados'];


            $cadena_equipo=$_POST['deptos_seleccionados'];
            if ($cadena_equipo=="" or substr($cadena_equipo,0,1)==" ") {} else {$_SESSION['deptos_seleccionados']=$cadena_equipo;}
            //    echo "<p>MISDATOSSSSS: ".$_SESSION['deptos_seleccionados']."</p>";

        }

        //        echo "<p>deptos seleccionados ya: ".$cadena_equipo;



        $this->imprimir_array($_SESSION['deptos_seleccionados']);
        //      echo "imprimo el print_r"."<br>";
        //        print_r($_SESSION['deptos_seleccionados']);

        //       echo 'mis deptos son:'.$_SESSION['deptos_seleccionados'];


    }*/


    //CODIGO EN PRUEBA EN LA IMPLEMENTACION DE LA FUNCIONALIDAD QUE PERMITE FILTRAR LOS REGISTROS DE LOS DIAS LABORALES EN LA CONSULTA
    function consultar()
    {
        //$cadena_equipo1=$cadena_equipo;
        $consulta = new IM();
        $divipol = new Divipol();
        $nombre_sedes = array();
        $sedes = array();
        $fechaDesde = $this->obtener_fecha_consulta($_POST['desdeFec'], "desde");
        $fechaHasta = $this->obtener_fecha_consulta($_POST['hastaFec'], "hasta");
        $departamentos = $_POST['departamento'];
        $horario = $_POST['horario'];
        $duracion = $_POST['cant_minutos'];
        $horaDesde = $_POST['horario_desde'];
        $horaHasta = $_POST['horario_hasta'];
//        $boton = $_POST['consulta'];

        $desdeFec = $_POST['desdeFec'];
        $hastaFec = $_POST['hastaFec'];
        $tomarboton = $_POST['control_boton'];
        $departamento = $_POST['departamento'];



        //ASIGNACION DE VARIABLES DE SESION PARA COMPLETAR CAMPOS DE LA TABLA INVENTOS
        $_SESSION['horario'] = $horario;
        $_SESSION['horario_desde'] = $horaDesde;
        $_SESSION['horario_hasta'] = $horaHasta;
        $_SESSION['cant_minutos'] = $duracion;
        $_SESSION['fecha_desde'] = $desdeFec;
        $_SESSION['fecha_hasta'] = $hastaFec;


        if ($desdeFec == "" or substr($desdeFec, 0, 1) == " ") {
        } else {
            $_SESSION['desdeFec'] = $desdeFec;
        }
        if ($hastaFec == "" or substr($hastaFec, 0, 1) == " ") {
        } else {
            $_SESSION['hastaFec'] = $hastaFec;
        }
        if ($departamento == "" or substr($departamento, 0, 1) == " ") {
        } else {
            $_SESSION['departamento'] = $departamento;
        }
        if ($tomarboton == "" or substr($tomarboton, 0, 1) == " ") {
        } else {
            $_SESSION['control_boton'] = $tomarboton;
        }

        // echo "Fecha desde = ".$fechaDesde."<br>"; original
        // echo "de chimbas =" .$_SESSION['hastaFec'];
        //   echo "Fecha desde = ".$_SESSION['desdeFec']."<br>";
        //  echo "Fecha hasta = ".$_SESSION['hastaFec']."<br>";
        // echo "el depto cod es=".$cadena_equipo."<br>";
        //  echo "Horario = ",$horario."<br>";
        // echo "Hora desde = ".$horaDesde."<br>";
        // echo "Hora hasta = ".$horaHasta."<br>";


        $query_departamentos = "SELECT * FROM fallas_canales AS fallas INNER JOIN disponibilidad_canales AS disponibilidades
        ON fallas.id_falla_cnl = disponibilidades.id_falla_cnl WHERE (fallas.fec_ini_falla_cnl >= '" . $fechaDesde . "'
         AND fallas.fec_ini_falla_cnl <= '" . $fechaHasta . "') AND fallas.durac_min_cnl >= '" . $duracion . "'
         AND disponibilidades.estado_canal = 'UP' AND disponibilidades.id_departamento IN(";
        $query_sedes = $query_departamentos;
        $query_enviado = '';
        //echo "Fecha desde = ".$fechaDesde."<br>";
        //echo "Fecha hasta = ".$fechaHasta."<br>";
        //echo "Horario = ".$horario."<br>";
        //echo "Duracion = ".$duracion."<br>";
        //echo "Hora desde = ".$horaDesde."<br>";
        //echo "Hora hasta = ".$horaHasta."<br>";
        //echo "Boton = ".$boton."<br>";
        for ($i = 0; $i < count($departamentos); $i++) {
            //echo "id_departamento = ".$departamentos[$i]."<br>";
            $query_sedes .= $departamentos[$i];
            if ($i == count($departamentos) - 1) {
                $query_sedes .= ")";
            } else {
                $query_sedes .= ", ";
            }
            $sedes = @$_POST['sedes_' . $departamentos[$i]];
            if ($sedes != '') {
                for ($j = 0; $j < count($sedes); $j++) {
                    //echo "id_alias = ".$sedes[$j]."<br>";
                    array_push($nombre_sedes, $sedes[$j]);
                    $resultados_2 = $consulta->get_id_departamento_sede($sedes[$j]);
                    $resultados_2 = mysqli_fetch_array($resultados_2);
                    if ($resultados_2['id_depart'] == $departamentos[$i]) {
                        $resultados_3 = $consulta->get_consulta_por_sedes($fechaDesde, $fechaHasta, $departamentos[$i], $duracion, $sedes[$j]);
                        while ($row = mysqli_fetch_array($resultados_3)) {
                            //echo "<div>'".$row['id_falla_cnl']."'</div><br>";
                            $consulta->get_disponibilidad_horario($row['id_falla_cnl'], $horario, $horaDesde, $horaHasta);
                        }
                    }
                }
            } else {
                $resultados = $consulta->get_consulta_por_departamento($fechaDesde, $fechaHasta, $departamentos[$i], $duracion);
                $query_departamentos .= $departamentos[$i];
                if ($i == count($departamentos) - 1) {
                    $query_departamentos .= ")";
                } else {
                    $query_departamentos .= ", ";
                }
                while ($row = mysqli_fetch_array($resultados)) {
                    //echo "<div>'".$row['id_falla_cnl']."'</div><br>";
                    $consulta->get_disponibilidad_horario($row['id_falla_cnl'], $horario, $horaDesde, $horaHasta);
                }
            }
        }


        //session_start();

        //  echo "query resultante = ".$query."<br>";
        //$_SESSION['query_resultante'] = $query;
        //$_SESSION['query_resultante2'] = $queryprueba;
        //   echo "query variable de sesion = ".$_SESSION['query_resultante']."<br>";
        //$consulta->insertpruebasdato($cadena);
        //echo "acabo de agregar a la bd el query"."<br>";

        // session_start();

        //
        //  $desdeFec=$_POST['desdeFec'];
        //   $hastaFec=$_POST['hastaFec'];
        //   $tomarboton=$_POST['control_boton'];
        //  $departamento=$_POST['departamento'];

        //   if ($desdeFec=="" or substr($desdeFec,0,1)==" ") {} else {$_SESSION['desdeFec']=$desdeFec;}
        //   if ($hastaFec=="" or substr($hastaFec,0,1)==" ") {} else {$_SESSION['hastaFec']=$hastaFec;}
        //  if ($departamento=="" or substr($departamento,0,1)==" ") {} else {$_SESSION['departamento']=$departamento;}
        //   if ($tomarboton=="" or substr($tomarboton,0,1)==" ") {} else {$_SESSION['control_boton']=$tomarboton;}


        if ($sedes != '') {
            $cadena = " AND fallas.alias_sede_cnl IN(";
            for ($k = 0; $k < count($nombre_sedes); $k++) {
                $cadena .= "'" . $nombre_sedes[$k] . "'";
                if ($k == count($nombre_sedes) - 1) {
                    $cadena .= ")";
                } else {
                    $cadena .= ", ";
                }
            }
            //echo "sedes = ".$cadena."<br>";
            $query_sedes .= $cadena;
            $query_enviado = $query_sedes;
            //echo "query resultante sedes = ".$query_enviado."<br>";
        } else {
            $query_enviado = $query_departamentos;
            //echo "query resultante departamentos = ".$query_enviado."<br>";
        }




        if($horario == 'Abierto'){
            //echo "ENTRE POR CONSULTA DE HORARIO ABIERTO"."<br>";
            $query_filtrado = $consulta->filtrar_registros_tiempo_laboral($query_enviado, $horaDesde, $horaHasta);
            //echo "query recibido de la funcion de filtrado = ".$query_filtrado."<br>";
            $consulta->insertpruebasdato($query_filtrado);
            //$cadena = "\"" . $query_filtrado . "\"";
            //echo "LO ASIGNO Y QUEDA EN LA VARIABLE DE SESION = ".$cadena."<br>";
        }
        if($horario == 'Cerrado') {
            //echo "ENTRE POR CONSULTA DE HORARIO CERRADO"."<br>";
            //echo "query_enviado = ".$query_enviado."<br>";
            $consulta->insertpruebasdato($query_enviado);
            //$cadena = "\"" . $query_enviado . "\"";
            //echo "LO ASIGNO Y QUEDA EN LA VARIABLE DE SESION = ".$cadena."<br>";
        }


        //$_SESSION['query_resultante'] = $query_enviado;

        //echo "query_resultante (asignado) = ".$_SESSION['query_resultante']."<br>";

        /*        switch($boton){
                    case 'sin_tramitar':
                        $condicion = " AND estado_tramite = 'SIN TRAMITAR'";
                        $query_enviado .= $condicion;
                        $this->index($query_enviado);
                        //$consulta->show_registros($query_enviado);
                    break;
                    case 'tramitados':
                        $condicion = " AND estado_tramite = 'TRAMITADO'";
                        $query_enviado .= $condicion;
                        $this->index($query_enviado);
                        //$consulta->show_registros($query_enviado);
                    break;
                    case 'pendientes':
                        $condicion = " AND estado_tramite = 'PENDIENTE'";
                        $query_enviado .= $condicion;
                        $this->index($query_enviado);
                        //$consulta->show_registros($query_enviado);
                    break;
                    case 'aprobados':
                        $condicion = " AND estado_tramite = 'APROBADO'";
                        $query_enviado .= $condicion;
                        $this->index($query_enviado);
                        //$consulta->show_registros($query_enviado);
                    break;
                }*/

        $_SESSION['deptos_seleccionados'] = array();

        for ($i = 0; $i < count($departamento); $i++) {
            array_push($_SESSION['deptos_seleccionados'], $departamento[$i]);
            //   echo "estoy guardando este codigo de departamento = ".$departamentos[$i]."<br>";


            $array_equipo = $_SESSION['deptos_seleccionados'];

            $cadena_equipo = implode(",", $array_equipo);
            //    echo "El equipo separaro por ',' es el siguiente: " .$cadena_equipo;

            $cadena_equipo2 = implode($array_equipo);
            //      echo "<br><br>El equipo sin parámetro string es el siguiente: " .$cadena_equipo2;


            $_SESSION['deptos_seleccionados'] = $cadena_equipo;
            //      echo 'mis deptos son:'.$_SESSION['deptos_seleccionados'];


            $cadena_equipo = $_POST['deptos_seleccionados'];
            if ($cadena_equipo == "" or substr($cadena_equipo, 0, 1) == " ") {
            } else {
                $_SESSION['deptos_seleccionados'] = $cadena_equipo;
            }
            //    echo "<p>MISDATOSSSSS: ".$_SESSION['deptos_seleccionados']."</p>";

        }

        //        echo "<p>deptos seleccionados ya: ".$cadena_equipo;


        $this->imprimir_array($_SESSION['deptos_seleccionados']);
        //      echo "imprimo el print_r"."<br>";
        //        print_r($_SESSION['deptos_seleccionados']);

        //       echo 'mis deptos son:'.$_SESSION['deptos_seleccionados'];


    }

    function imprimir_array($array)
    {
        for ($j = 0; $j < count($array); $j++) {
            // echo "tengo el dato = ".$array[$j]."<br>";
        }
    }


    //CODIGO ORIGINAL
    /*    function revisar(){
        @session_start();
        $consulta_class = new IM();        
        //$im_regitro = '';
        $im_reg_disponibilidad = '';
        //if($id == ''){  
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
                //echo "Entro por get_registro"."<br>";
            }else{
                $id = $_POST['id'];
                $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
                //$im_regitro = $consulta_class->get_registro_num($id);
                //echo "Entro por get_registro_num"."<br>";
            }
        //}else{
            //$id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
        //}

        $id_disp_cnl = mysqli_fetch_array($id_disp_cnl);
        $im_regitro['id_disp_cnl'] = $id_disp_cnl['id_disp_cnl'];
        $im_regitro['nota_observacion'] = $_POST['nota_observacion_rnec'];
        $im_regitro['horar_eval'] = $_POST['horar_eval'];
        $im_regitro['horar_desde_eval'] = $_POST['horar_desde_eval'];
        $im_regitro['horar_hasta_eval'] = $_POST['horar_hasta_eval'];
        $im_regitro['aplica_resarc'] = $_POST['aplica_resarc'];
        $im_regitro['falla_justif'] = $_POST['falla_justif'];
        $im_regitro['boton'] = $_POST['revisar'];
        $apag_contr = $consulta_class->get_id_apag_contr_sede($id);
        $apag_contr = mysqli_fetch_array($apag_contr);
        $id_sede= $apag_contr['id_sede'];
        $apag_contr = $apag_contr['apag_contr'];
        $horario_aplicado = $consulta_class->get_horario_aplicado($id);
        $horario_aplicado = mysqli_fetch_array($horario_aplicado);
        $horario_aplicado = $horario_aplicado['horario_aplicado'];
        $id_disp_cnl = $im_regitro['id_disp_cnl'];
        $aplica_resarc = $im_regitro['aplica_resarc'];

        //echo "boton = ".$_POST['revisar']."<br>";
        //echo "apag_contr = ".$apag_contr."<br>";
        //echo "id_sede = ".$id_sede."<br>";
        //echo "id_disp_cnl = ".$id_disp_cnl."<br>";
        //echo "horario_aplicado = ".$horario_aplicado."<br>";
        //echo "aplica_resarc = ".$im_regitro['aplica_resarc']."<br>";
        //echo "falla_justif = ".$im_regitro['falla_justif']."<br>";
        //echo "observ = ".$im_regitro['nota_observacion']."<br>";

        $fallas_tipificadas = $consulta_class->get_fallas_tipificadas_por_id($id_disp_cnl);
        if($im_regitro['boton'] == 'ENVIAR A REVISION'){

            $consulta_class->set_nota_conciliacion($im_regitro);
            $consulta_class->set_estado_pendientes($id_disp_cnl);

            while($row=mysqli_fetch_array($fallas_tipificadas)){
                //echo "REVISANDO EL REGISTRO CON id_falla_prv = ".$row['id_falla_prv']."<br>";
                $consulta_class->set_tiempo_resarcimiento($row['id_falla_prv'],$id_disp_cnl,$row,$horario_aplicado,$apag_contr,$id_sede,$id);
                $consulta_class->set_estado_falla_pendiente($row['id_falla_prv']);
            }
        }
        if($im_regitro['boton'] == 'APROBADO'){

            $consulta_class->set_nota_conciliacion($im_regitro);
            $consulta_class->set_estado_aprobados($id_disp_cnl);

            while($row=mysqli_fetch_array($fallas_tipificadas)){
                //echo "REVISANDO EL REGISTRO CON id_falla_prv = ".$row['id_falla_prv']."<br>";
                $consulta_class->set_tiempo_resarcimiento($row['id_falla_prv'],$id_disp_cnl,$row,$horario_aplicado,$apag_contr,$id_sede,$id);
                $consulta_class->set_estado_falla_aprobada($row['id_falla_prv']);
            }

        }


        //PRUEBA VISTAS
        header("Location: ../resarcimientos/index.php?contr=Consulta&act=index");
        //FIN PRUEBA VISTAS



    }*/


//CODIGO EN PRUEBA PARA LA IMPLEMENTACION DE LAS NOTAS CONCILIACION POR CADA FALLA TIPIFICADA
    function revisar()
    {
        @session_start();
        $consulta_class = new IM();
        //$im_regitro = '';
        $im_reg_disponibilidad = '';
        //if($id == ''){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
            //echo "Entro por get_registro"."<br>";
        } else {
            $id = $_POST['id'];
            $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
            //$im_regitro = $consulta_class->get_registro_num($id);
            //echo "Entro por get_registro_num"."<br>";
        }
        //}else{
        //$id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
        //}

        //$id_disp_cnl = mysqli_fetch_array($id_disp_cnl);
        //$im_regitro['id_disp_cnl'] = $id_disp_cnl['id_disp_cnl'];
        //$im_regitro['nota_observacion'] = $_POST['nota_observacion_rnec'];
        //$im_regitro['horar_eval'] = $_POST['horar_eval'];
        //$im_regitro['horar_desde_eval'] = $_POST['horar_desde_eval'];
        //$im_regitro['horar_hasta_eval'] = $_POST['horar_hasta_eval'];
        //$im_regitro['aplica_resarc'] = $_POST['aplica_resarc'];
        //$im_regitro['falla_justif'] = $_POST['falla_justif'];
        //$im_regitro['boton'] = $_POST['revisar'];

        //$horario_aplicado = $consulta_class->get_horario_aplicado($id);
        //$horario_aplicado = mysqli_fetch_array($horario_aplicado);
        //$horario_aplicado = $horario_aplicado['horario_aplicado'];
        //$id_disp_cnl = $im_regitro['id_disp_cnl'];
        //$aplica_resarc = $im_regitro['aplica_resarc'];

        //echo "ENTRO AL METODO revisar"."<br>";
        //echo "boton = ".$_POST['revisar']."<br>";
        //echo "apag_contr = ".$apag_contr."<br>";
        //echo "id_sede = ".$id_sede."<br>";
        //echo "id_disp_cnl = ".$id_disp_cnl."<br>";
        //echo "horario_aplicado = ".$horario_aplicado."<br>";
        //echo "aplica_resarc = ".$im_regitro['aplica_resarc']."<br>";
        //echo "falla_justif = ".$im_regitro['falla_justif']."<br>";
        //echo "observ = ".$im_regitro['nota_observacion']."<br>";
        $id_disp_cnl = mysqli_fetch_array($id_disp_cnl);
        $id_disp_cnl = $id_disp_cnl['id_disp_cnl'];
        $decision = $_POST['revisar'];

        //echo "id_disp_cnl = ".$id_disp_cnl."<br>";
        //echo "decision = ".$decision."<br>";

        if ($decision == 'ENVIAR A REVISION') {
            $consulta_class->set_estado_pendientes($id_disp_cnl);
        }
        if ($decision == 'APROBADO') {
            $consulta_class->set_estado_aprobados($id_disp_cnl);
        }

        $apag_contr = $consulta_class->get_id_apag_contr_sede($id);
        $apag_contr = mysqli_fetch_array($apag_contr);
        $id_sede = $apag_contr['id_sede'];
        $apag_contr = $apag_contr['apag_contr'];

        $cadena = "id_falla_prv_";
        $cont = 1;
        $evalua = 0;

        //echo "COMIENZA EL CICLO"."<br>";
        do {
            $identif = $cadena . $cont;
            $id_falla_prv = $_POST[$identif];

            //echo "identif = ".$identif."<br>";
            //echo "id_falla_prv = ".$id_falla_prv."<br>";

            if ($id_falla_prv == "") {
                $evalua = 1;
            } else {
                $im_regitro['id_disp_cnl'] = $id_disp_cnl;
                $im_regitro['id_falla_prv'] = $id_falla_prv;
                $im_regitro['nota_observacion'] = $_POST['nota_observacion_rnec_' . $cont];
                $im_regitro['horar_eval'] = $_POST['horar_eval'];
                $im_regitro['horar_desde_eval'] = $_POST['horar_desde_eval'];
                $im_regitro['horar_hasta_eval'] = $_POST['horar_hasta_eval'];
                $im_regitro['aplica_resarc'] = $_POST['aplica_resarc_' . $cont];
                $im_regitro['falla_justif'] = $_POST['falla_justif_' . $cont];
                //echo "IMPRIMO LOS DATOS QUE RECIBO DEL FORMULARIO"."<br>";
                //echo "id_falla_prv = ".$im_regitro['id_falla_prv']."<br>";
                //echo "nota_observacion = ".$im_regitro['nota_observacion']."<br>";
                //echo "aplica_resarc = ".$im_regitro['aplica_resarc']."<br>";
                //echo "falla_justif = ".$im_regitro['falla_justif']."<br>";
                //echo "horar_eval = ".$im_regitro['horar_eval']."<br>";
                //echo "horar_desde_eval = ".$im_regitro['horar_desde_eval']."<br>";
                //echo "horar_hasta_eval = ".$im_regitro['horar_hasta_eval']."<br>";
                $consulta_class->set_nota_conciliacion($im_regitro);
                //$consulta_class->set_tiempo_resarcimiento($im_regitro, $id_disp_cnl, $apag_contr, $id_sede, $id);

                if ($decision == 'ENVIAR A REVISION') {
                    $consulta_class->set_estado_falla_pendiente($id_falla_prv);
                }
                if ($decision == 'APROBADO') {
                    $consulta_class->set_estado_falla_aprobada($id_falla_prv);
                    //$consulta_class->set_tiempo_resarcimiento($im_regitro, $id_disp_cnl, $apag_contr, $id_sede, $id);
                }
            }
            $cont++;
        } while ($evalua != 1);


        $notas_generales = $_POST['nota_observacion_gral'];
        //echo "id_disp_cnl = ".$id_disp_cnl."<br>";
        //echo "NOTA GENERAL = ".$notas_generales."<br>";
        $consulta_class->set_nota_general($id_disp_cnl,$notas_generales);




        //echo "TERMINA EL CICLO"."<br>";

        /*        $fallas_tipificadas = $consulta_class->get_fallas_tipificadas_por_id($id_disp_cnl);
        if($im_regitro['boton'] == 'ENVIAR A REVISION'){

            $consulta_class->set_nota_conciliacion($im_regitro);
            $consulta_class->set_estado_pendientes($id_disp_cnl);

            while($row=mysqli_fetch_array($fallas_tipificadas)){
                //echo "REVISANDO EL REGISTRO CON id_falla_prv = ".$row['id_falla_prv']."<br>";
                $consulta_class->set_tiempo_resarcimiento($row['id_falla_prv'],$id_disp_cnl,$row,$horario_aplicado,$apag_contr,$id_sede,$id);
                $consulta_class->set_estado_falla_pendiente($row['id_falla_prv']);
            }
        }
        if($im_regitro['boton'] == 'APROBADO'){

            $consulta_class->set_nota_conciliacion($im_regitro);
            $consulta_class->set_estado_aprobados($id_disp_cnl);

            while($row=mysqli_fetch_array($fallas_tipificadas)){
                //echo "REVISANDO EL REGISTRO CON id_falla_prv = ".$row['id_falla_prv']."<br>";
                $consulta_class->set_tiempo_resarcimiento($row['id_falla_prv'],$id_disp_cnl,$row,$horario_aplicado,$apag_contr,$id_sede,$id);
                $consulta_class->set_estado_falla_aprobada($row['id_falla_prv']);
            }

        }*/


        //PRUEBA VISTAS
       // header("Location: ../resarcimientos/index.php?contr=Consulta&act=index");
        header("Location: ../resarcimientos/index.php?contr=Consulta&tipo=tramitado");
        //FIN PRUEBA VISTAS


    }


    function actualizar_fallas_tigo()
    {
        @session_start();
        $consulta_class = new IM();
        $i = 1;

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
            //echo "Entro por get_registro"."<br>";
        } else {
            $id = $_POST['id'];
            $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
            //$im_regitro = $consulta_class->get_registro_num($id);
            //echo "Entro por get_registro_num"."<br>";
        }


        $id_disp_cnl = mysqli_fetch_array($id_disp_cnl);
        $id_disp_cnl = $id_disp_cnl['id_disp_cnl'];
        //$fallas_tipificadas = $consulta_class->get_fallas_tipificadas_por_id($id_disp_cnl);

        $consulta_class->set_estado_falla_tramitado_2($id_disp_cnl);
        $consulta_class->set_estado_tramitados($id_disp_cnl);
        header("Location: ../resarcimientos/index.php?contr=Consulta&act=index");

    }


    function get_apagado_canal($id)
    {
        $consulta_class = new IM();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
        } else {
            $id = $_POST['id'];
            $id_disp_cnl = $consulta_class->get_registro_disponibilidad($id);
        }

        $id_disp_cnl = mysqli_fetch_array($id_disp_cnl);
        $id_disp_cnl = $id_disp_cnl['id_disp_cnl'];

        $id_depart = $consulta_class->get_departamento_id($id_disp_cnl);
        $id_depart = mysqli_fetch_array($id_depart);
        $id_depart = $id_depart['id_departamento'];

        $sede = $consulta_class->get_sede_canal($id);
        $sede = mysqli_fetch_array($sede);
        $sede = $sede['alias_sede_cnl'];

        $apagado = $consulta_class->get_tipo_apagado($sede, $id_depart);
        $apagado = mysqli_fetch_array($apagado);
        $apagado = $apagado['apag_contr'];

        return $apagado;
    }


    function editar_falla_individual()
    {
        $consulta_class = new IM();
        $id_falla_prv = '';
        $indice = '';
        $id = '';
        $id_disp_cnl = '';
        $mth = '';
        //$registro = '';
        if (isset($_GET['id_falla_prv'])) {
            $id_falla_prv = $_GET['id_falla_prv'];
        }
        if (isset($_GET['indice'])) {
            $indice = $_GET['indice'];
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        if (isset($_GET['id_falla_prv'])) {
            $mth = $_GET['mth'];
        }
        $id_disp_cnl = $consulta_class->get_id_disp_canal($id);
        $id_disp_cnl = mysqli_fetch_array($id_disp_cnl);
        $id_disp_cnl = $id_disp_cnl['id_disp_cnl'];
        $decision = $_POST["edit_tipificado_" . $indice];
        $fecha_inicio = $_POST["nota_fecha_creado_nuevo_" . $indice];
        $hora_inicio = $_POST["nota_hora_creado_nuevo_" . $indice];
        $minuto_inicio = $_POST["nota_minuto_creado_nuevo_" . $indice];
        $cadena_fecha_inicio = $fecha_inicio . " " . $hora_inicio . ":" . $minuto_inicio . ":00";
        $fec_ini_falla_tpf = date("Y-m-d H:i:s", strtotime($cadena_fecha_inicio));
        $fecha_fin = $_POST["nota_fecha_finalizado_nuevo_" . $indice];
        $hora_fin = $_POST["nota_hora_finalizado_nuevo_" . $indice];
        $minuto_fin = $_POST["nota_minuto_finalizado_nuevo_" . $indice];
        $cadena_fecha_fin = $fecha_fin . " " . $hora_fin . ":" . $minuto_fin . ":00";
        $fec_fin_falla_tpf = date("Y-m-d H:i:s", strtotime($cadena_fecha_fin));
        $durac_falla_tpf = $_POST["duracGlob_" . $indice];
        $id_tipo_falla = $_POST["tipo_falla_nuevo_" . $indice];
        $num_ticket = $_POST["numero_ticket_" . $indice];
        $observ_falla_tpf = $_POST["nota_observacion_" . $indice];

        //CAPTURA DE DATOS DEL FORMULARIO

        //echo "decision = ".$decision."<br>";
        //echo "id_falla_prv = ".$id_falla_prv."<br>";
        //echo "id_disp_cnl = ".$id_disp_cnl."<br>";
        //echo "id = ".$id."<br>";
        //echo "indice = ".$indice."<br>";
        //echo "mth = ".$mth."<br>";
        //echo "fecha_inicio = ".$cadena_fecha_inicio."<br>";
        //echo "fecha_final = ".$cadena_fecha_fin."<br>";
        //echo "duracion = ".$durac_falla_tpf."<br>";
        //echo "tipo_falla = ".$id_tipo_falla[0]."<br>";
        //echo "num_ticket = ".$num_ticket."<br>";
        //echo "observ = ".$observ_falla_tpf."<br>";

        //$registro = array($fec_ini_falla_tpf,$fec_fin_falla_tpf,$durac_falla_tpf,$id_tipo_falla,$num_ticket,$observ_falla_tpf);

        if ($decision == 'GUARDAR') {
            //echo "ENTRO POR EDITAR"."<br>";
            $consulta_class->actualizar_falla_individual($id,$id_disp_cnl,$id_falla_prv,$fec_ini_falla_tpf,$fec_fin_falla_tpf,$durac_falla_tpf,$id_tipo_falla,$num_ticket,$observ_falla_tpf,$mth);

        }
        if ($decision == "ELIMINAR") {
            //echo "ENTRO POR ELIMINAR"."<br>";
            $consulta_class->eliminar_falla_individual($id,$id_falla_prv,$fec_ini_falla_tpf,$fec_fin_falla_tpf,$durac_falla_tpf,$id_tipo_falla,$num_ticket,$observ_falla_tpf,$mth);

        }
        /*DEFINO HACIA QUE VISTA SE DEBE DIRECCIONAR DEPENDIENDO DEL TIPO DE GUARDADO SE ESTA HACIENDO*/
        if ($mth == 'editar') {
            $this->editar($id);
        }
        if ($mth == 'pendiente') {
            $this->pendiente($id);
        }
    }



    function asignar_fecha_subida($id = 0){
        $consulta_class = new IM();
        $im_regitro = '';
        if ($id == '') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            } else {
                $id = $_POST['id'];
                $im_regitro = $consulta_class->get_registro_disponibilidad($id);
            }
        } else {
            $im_regitro = $consulta_class->get_registro_disponibilidad($id);
        }

        //echo "ENTRO AL METODO asignar_fecha_subida"."<br>";
        //echo "id_falla_cnl = ".$id."<br>";
        $numrows = mysqli_num_rows($im_regitro);
        if($numrows > 0){
            $fecha_subida = $_POST['fecha_subida'];
            $hora_subida = $_POST['hora_subida'];
            $minuto_subida = $_POST['minuto_subida'];
            $fecha_subida_completa = $fecha_subida." ".$hora_subida.":".$minuto_subida.":"."00";
            //echo "fecha_subida_completa = ".$fecha_subida_completa."<br>";
            $fecha_subida_completa = $this->obtener_fecha_completa($fecha_subida_completa);
            $fecha_caida = $_POST['fecha_caida_'];
            $hora_caida = $_POST['hora_caida_'];
            $minuto_caida = $_POST['minuto_caida_'];
            $fecha_caida_completa = $fecha_caida." ".$hora_caida.":".$minuto_caida.":"."00";
            //echo "fecha_caida_completa = ".$fecha_caida_completa."<br>";
            $fecha_caida_completa = $this->obtener_fecha_completa($fecha_caida_completa);

            if($fecha_subida_completa > $fecha_caida_completa){
                //echo "SE CUMPLE fecha_subida_completa > fecha_caida_completa"."<br>";
                $durac_falla = $consulta_class->calcular_diferencia_fechas($fecha_caida_completa,$fecha_subida_completa);
                $durac_global = $durac_falla[0];
                $durac_min = $durac_falla[1];
                //$cant_horas = explode(":",$durac_global);
                //$cant_horas = $cant_horas[0];
                $cant_dias = $consulta_class->calcular_cantidad_dias($fecha_caida_completa,$fecha_subida_completa);
                //$porc_disp = $consulta_class->calcular_porcentaje_disponibilidad($cant_dias,$cant_horas);
                //echo "durac_global = ".$durac_global."<br>";
                //echo "durac_min = ".$durac_min."<br>";
                //echo "cant_horas = ".$cant_horas."<br>";
                //echo "cant_dias = ".$cant_dias."<br>";
                //echo "porc_disp = ".$porc_disp."<br>";
                $consulta_class->actualizar_fecha_subida_canal($id,$fecha_caida_completa,$fecha_subida_completa,$durac_global,$durac_min,$cant_dias);
            }

        }
        header("Location: ../resarcimientos/index.php?contr=Consulta&tipo=canales_caidos");
    }


    function consultar_estadisticas_botones(){
        $consulta = new IM();
        $cant_sin_tramitar = 0;
        $cant_tramitados = 0;
        $cant_pendientes = 0;
        $cant_aprobados = 0;
        $cant_caidos = 0;
        $cant_sin_tramitar_rnec = 0;
        $cant_cargados = 0;
        $result = $consulta->consultapruebasdato();
        $result = mysqli_fetch_array($result);
        $query_bd = $result['cadenacompleta'];
        $fecha_desde = $result['fecha_desde'];
        $fecha_hasta = $result['fecha_hasta'];
        $estadisticas = $consulta->consultar_registros_por_estado($query_bd,$fecha_desde,$fecha_hasta);
        if($estadisticas[0] != null){
            $cant_sin_tramitar = $estadisticas[0];
        }

        if($estadisticas[1] != null){
            $cant_tramitados = $estadisticas[1];
        }

        if($estadisticas[2] != null){
            $cant_pendientes = $estadisticas[2];
        }

        if($estadisticas[3] != null){
            $cant_aprobados = $estadisticas[3];
        }

        if($estadisticas[4] != null){
            $cant_caidos = $estadisticas[4];
        }

        if($estadisticas[5] != null){
            $cant_sin_tramitar_rnec = $estadisticas[5];
        }

        if($estadisticas[6] != null){
            $cant_cargados = $estadisticas[6];
        }

        $respuesta = array("cant_caidos"=>$cant_caidos,"cant_sin_tramitar"=>$cant_sin_tramitar,"cant_tramitados"=>$cant_tramitados,"cant_pendientes"=>$cant_pendientes,"cant_aprobados"=>$cant_aprobados,"cant_sin_tramitar_rnec"=>$cant_sin_tramitar_rnec,"cant_cargados"=>$cant_cargados);
        echo json_encode($respuesta);
    }
}


?>
