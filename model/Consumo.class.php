<?php 
/*
CLASE PARA LA GESTION DE LOS CONSUMOS DE LAS LINEAS TELEFONICAS
*/
    //require_once "../model/bd/BD_remote.class.php";
    require_once "../model/bd/BD.class.php";   
    //include('../model/bd/dbconect.php');

    class Consumo{
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
        	//echo "ENTRO AL METODO insertar (Consumo) CON EL query = ".$query."<br>";
            return $this->bd->insert($query);
        }

        function consultar_campos($query) {
        	//echo "ENTRO AL METODO consultar_campos con el query = ".$query."<br>";
        	return $this->bd->consulta_punt($query);
            // $rs = mysqli_query($con, $query);
            // $num_rows = mysqli_num_rows($rs);
            // $row = ($num_rows != 0)?mysqli_fetch_array($rs):"";
            // return $row;
        }

    }

?>