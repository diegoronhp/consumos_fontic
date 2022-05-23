<?php
/*
CLASE PARA LA GENERACION DEL REPORTE DE CONSUMOS DEL PERIODO
*/
//require_once "../model/bd/BD_remote.class.php";
require_once "../model/bd/BD.class.php";
//include('../model/bd/dbconect.php');

class Reporte{
    private $bd;
    private $consumo;

    public function __construct() {
        $this->bd = Database::getInstance();
        $this->consumo = array();
    }

    public function consultar($query){
        return $this->bd->select($query);
    }

    public function contar_filas($query){
        return $this->bd->consulta_cant($query);
    }

    public function insertar($query){
        return $this->bd->insert($query);
    }

    public function actualizar($query){
        return $this->bd->update($query);
    }

    public function eliminar($query){
        return $this->bd->delete($query);
    }

    function consultar_campos($query) {
        return $this->bd->consulta_punt($query);
        // $rs = mysqli_query($con, $query);
        // $num_rows = mysqli_num_rows($rs);
        // $row = ($num_rows != 0)?mysqli_fetch_array($rs):"";
        // return $row;
    }

    function get_conection(){
        return $this->bd->get_con();
    }

}

?>