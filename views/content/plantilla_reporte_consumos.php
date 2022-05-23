
<!DOCTYPE html>
<html lang = "es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>REPORTE CONSUMOS PERIODO</title>

        <style type="text/css">
            th{
                padding: 3px 10px;
                height: 30px;
                /*imagen de 36px*/
                /*background:#089c6d url("img/th.png") repeat-x;*/
                color:#FFF;
                border:1px solid #ccc;
            }

            /*** Tabla consulta*/
            .tabla_cons{
                font-family:Arial,Helvetica,sans-serif;
                font-size:12px;
                border-collapse:collapse;
            }

            .tabla_cons tr{
    background:#FFF;
}

            .tabla_cons tr.odd{
    background:#F8F8F8;
}

            .tabla_cons td{
    border: 1px solid #CCC;
                padding:1px 4px;
                white-space:nowrap;
                text-align:left;
                text-transform:uppercase;
            }
        </style>
    </head>
    <body>
        <table border="0" cellpadding="0" cellspacing="0" class="tabla_cons" width="90%" >
            <thead>
                <tr>
                    <th>#REGISTRO</th>
                    <th>DEPARTAMENTO</th>
				 	<th>SEDE</th>
                    <th>FECHA-HORA DOWN</th>
                    <th>FECHA-HORA UP</th>
                    <th>DURACION TOTAL</th>
                    <th>CANTIDAD TOTAL DIAS</th>
                    <th>RESPONSABLE DE FALLA</th>
                    <th>DESCRIPCION DE FALLA</th>
                    <th>FECHA-HORA INICIAL TIPIFICADA</th>
                    <th>FECHA-HORA FINAL TIPIFICADA</th>
                    <th>DURACION TOTAL FALLA TIPIFICADA</th>
                    <th>NUMERO DEL TICKET</th>
                    <th>APLICA RESARCIMIENTO</th>
                    <th>TIEMPO RESARCIMIENTO</th>
                    <th>OBSERVACIONES FALLA</th>
                    <th>GESTIONADO POR</th>
                    <!--<th>CAMPOS A MOSTRAR EN EL EXCEL GENERADO</th>-->

                </tr>
            </thead>
            <?php
          //  error_reporting(E_ALL);
                $i = 0;
                //while ($row = mysqli_fetch_array($datos_im)) {
                    //$divipol = new Divipol();
                  //  $registraduria_tipo = $divipol->get_registraduria_tipo();
					//$registraduria_tipo_enlace = $divipol->get_registraduria_tipo_enlace();
					//while($row=mysqli_fetch_array($im_abiertos)){
                        //$enlace_wan = $divipol->get_wan_by_id($row['id_enlace']);
                        //$enlace_wan = mysqli_fetch_array($enlace_wan);
                        //  $depar_munic = $divipol->departamento_municipio_app($row['reg_departamento_id'], $row['reg_municipio_id']);

                        $apag_contr = $row['apag_contr'] == 1 ? "SI": "NO";
                        $color = ($i % 2 == 0) ? "class='odd'" : "class=''";

                        echo "<tr $color>";
                        //	echo "<td>{$row['reg_ticket_num']}</td>";
                        //   echo "<td>{$row['depart_nombre_cnl']}</td>";

/*                        echo "<td>{$row['id_falla_cnl']}</td>";
                        echo "<td>{$row['depart_nombre_cnl']}</td>";
                        echo "<td>{$row['alias_sede_cnl']}</td>";
                        echo "<td>{$row['fec_ini_falla_cnl']}</td>";
                        echo "<td>{$row['fec_fin_falla_cnl']}</td>";
                        echo "<td>{$row['durac_disp_glob']}</td>";
                        echo "<td>{$row['cant_dias_global']}</td>";
                        echo "<td>{$row['tipo_falla_responsable']}</td>";
                        echo "<td>{$row['tipo_falla_descripcion']}</td>";
                        echo "<td>{$row['fec_ini_falla_tpf']}</td>";
                        echo "<td>{$row['fec_fin_falla_tpf']}</td>";
                        echo "<td>{$row['durac_falla_tpf']}</td>";
                        echo "<td>{$row['num_ticket']}</td>";
                        echo "<td>{$row['aplica_resarc']}</td>";
                        echo "<td>{$row['tiempo_resarc']}</td>";
                        echo "<td>{$row['observ_falla_tpf']}</td>";
                        echo "<td>{$row['gestionado']}</td>";*/


                        //echo "asi quedaria el query con inner fallas_proveedor = ".$_SESSION["$query_completo"]."<br>";
                        /*
                          if(mysqli_num_rows($depar_munic['departamento'])>0){
                            while ($depar = mysqli_fetch_array($depar_munic['departamento'])){
                                echo "<td>" .$depar['departamento_nombre']."</td>";
                            }
                        }
                        */




                        /*
                        if(mysqli_num_rows($depar_munic['municipio'])>0){
                            while ($munic = mysqli_fetch_array($depar_munic['municipio'])){
                                echo "<td>" .$munic['municipio_nombre']."</td>";
                            }
                        }else {
                            echo "<td> </td>";
                        }
						if(mysqli_num_rows($registraduria_tipo)>0){
                            $nombre = '';
                            while ($regis = mysqli_fetch_array($registraduria_tipo)){
                                if($regis['tipo_registraduria_id']==$row['reg_tipo_sede']){
                                    $nombre = $regis['tipo_registraduria_nombre'];
                                }
                            }
                            echo "<td>".$nombre."</td>";
                            mysqli_data_seek($registraduria_tipo,0);
                        }
                        echo "<td>{$row['reg_cliente']}</td>";
						echo "<td>{$row['reg_tipo']}</td>";
                        echo "</tr>";
                        $i++;

                        */
                        echo "</tr>";
                        $i++;
                    //}
					@ldap_close($ldap);
                //}
            ?>
</table>
</body>
</html>




