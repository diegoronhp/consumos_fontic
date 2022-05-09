<?php
    /*
      CLASE PARA LA GESTION DE LOS TIPOS DE EQUIPO
     */
    require_once "bd/BD_remote.class.php";
    require_once "bd/BD.class.php";    
    class IM {

        private $bd;
        private $bd_remote;
        private $im;

        public function __construct() {
            $this->bd_remote = Database_Remote::getInstance();
            $this->bd = Database::getInstance();            
            $this->im = array();
        }

        public function show_registros($estado="", $tipo="") {
            if($estado == "Cerrado")
                $query = "SELECT * FROM registro WHERE reg_estado = '{$estado}' ORDER BY reg_fecha_creacion DESC LIMIT 1000;";
            else
                $query = "SELECT * FROM registro WHERE reg_tipo = '{$tipo}' AND reg_estado != 'Cerrado'";
            $this->result = $this->bd->select($query);
			//var_dump($query);
            return $this->result;
        }

        public function show_registros_cerrados() {
            $query = "SELECT * FROM registro WHERE reg_estado = 'Cerrado'";
            $this->result = $this->bd->select($query);
            return $this->result;
        }      

        public function reporte($fecha_menor, $fecha_mayor) {
            /*
            $query = "SELECT * FROM registro WHERE reg_fecha_cierre BETWEEN '{$fecha_menor}' AND '{$fecha_mayor}' ORDER BY reg_fecha_creacion ASC";
            $this->result = $this->bd->select($query);
            //var_dump($query);
            return $this->result;
            */
            //$query = "SELECT * FROM registro WHERE reg_fecha_cierre BETWEEN '{$fecha_menor}' AND '{$fecha_mayor}' ORDER BY reg_fecha_creacion ASC";
            $query = "SELECT * FROM registro WHERE reg_fecha_cierre BETWEEN '{$fecha_menor}' AND '{$fecha_mayor}' ORDER BY reg_departamento_id, reg_municipio_id, reg_tipo_sede, reg_fecha_creacion ASC";
            $this->result = $this->bd->select($query);
            //var_dump($query);
            return $this->result;
        
        }
		
		public function get_user_id_closed($ticket_id) {
            $query = "SELECT hr.*, u.loginUsers nombre 
					  FROM historial_registro hr, users u 
					  WHERE hr.his_id_ticket = {$ticket_id} AND hr.his_id_user = u.idUsers ORDER BY hr.his_id DESC Limit 1";
            $this->result = mysqli_fetch_array($this->bd->select($query));
            //var_dump($query);
            return $this->result;
        }

        public function new_registro($im, $user_id) {
            date_default_timezone_set("America/Bogota");
            $date = date("Y") . "-" . date("m") . "-" . date("d");
            
            /*$query = "INSERT INTO 
                    registro(reg_id, reg_ticket_num, reg_tipo_sede, reg_sede, reg_fecha_creacion, reg_fecha_cierre,
                            reg_cola, reg_estado, reg_cliente, reg_tipo, reg_falla, reg_responsabilidad, reg_observacion,
                            reg_fecha_solucion, reg_departamento_id, reg_municipio_id, reg_tipo_alerta) 
                    VALUES('', '{$im["ticket_num"]}', '{$im["tipo_sede"]}', '{$im["sede"]}', '{$im["fecha_creacion"]}',
                           '{$im["fecha_cierre"]}', '{$im["cola"]}', '{$im["estado"]}', '{$im["cliente"]}', '{$im["tipo"]}',
                           '{$im["falla"]}', '{$im["responsabilidad"]}', '{$im["observacion"]}', '{$im["fecha_solucion"]}',
                           '{$im["departamento_id"]}', '{$im["municipio_id"]}', '{$im["tipo_alerta"]}')";*/
                            /*
            $query = "INSERT INTO 
                    registro(reg_ticket_id, reg_ticket_num, reg_tipo_sede, reg_fecha_creacion, reg_fecha_cierre,
                            reg_estado, reg_cliente, reg_tipo, reg_fecha_solucion, reg_departamento_id, reg_municipio_id, reg_tipo_alerta, reg_ticket_proveedor, 
							reg_fecha_creacion_proveedor, reg_fecha_solucion_proveedor) 
                    VALUES('{$im["ticket_id"]}', '{$im["ticket_num"]}', '{$im["tipo_sede"]}', '{$im["fecha_creacion"]}',
                           '{$im["fecha_cierre"]}', '{$im["estado"]}', '{$im["cliente"]}', '{$im["tipo"]}',
                           '{$im["fecha_solucion"]}', '{$im["departamento_id"]}', '{$im["municipio_id"]}', '{$im["tipo_alerta"]}', '{$im["ticket_num_proveedor"]}', 
						   '{$im["fecha_creacion_proveedor"]}', '{$im["fecha_solucion_proveedor"]}')"; */



                           /*
                           $query = "INSERT INTO 
                    registro(reg_id, reg_ticket_id, reg_ticket_num, reg_tipo_sede, reg_fecha_creacion, reg_fecha_cierre,
                            reg_estado, reg_cliente, reg_tipo, reg_fecha_solucion, reg_departamento_id, reg_municipio_id, reg_tipo_alerta, reg_ticket_proveedor, 
                            reg_fecha_creacion_proveedor, reg_fecha_solucion_proveedor) 
                    VALUES('', '{$im["ticket_id"]}', '{$im["ticket_num"]}', '{$im["tipo_sede"]}', '{$im["fecha_creacion"]}',
                           '{$im["fecha_cierre"]}', '{$im["estado"]}', '{$im["cliente"]}', '{$im["tipo"]}',
                           '{$im["fecha_solucion"]}', '{$im["departamento_id"]}', '{$im["municipio_id"]}', '{$im["tipo_alerta"]}', '{$im["ticket_num_proveedor"]}', 
                           '{$im["fecha_creacion_proveedor"]}', '{$im["fecha_solucion_proveedor"]}')";*/

$query = "INSERT INTO 
                    registro( reg_ticket_num, reg_tipo_sede, reg_fecha_creacion, reg_estado, reg_cliente, reg_tipo, reg_fecha_solucion, reg_departamento_id, reg_municipio_id, reg_tipo_alerta, reg_ticket_proveedor, reg_fecha_creacion_proveedor, reg_fecha_solucion_proveedor) 
                    VALUES( '{$im["ticket_num"]}', '{$im["tipo_sede"]}', '{$im["fecha_creacion"]}','{$im["estado"]}','{$im["cliente"]}','{$im["tipo"]}',NULL,'{$im["departamento_id"]}','{$im["municipio_id"]}','{$im["tipo_alerta"]}','{$im["ticket_num_proveedor"]}','{$im["fecha_creacion_proveedor"]}','{$im["fecha_solucion_proveedor"]}')";
                         var_dump($query);
                        // print_r($query);

/*
                           INSERT INTO registro(reg_ticket_id, reg_ticket_num, reg_tipo_sede, reg_fecha_creacion, reg_estado, reg_cliente, reg_tipo, reg_fecha_solucion, reg_departamento_id, reg_municipio_id, reg_tipo_alerta, reg_ticket_proveedor, reg_fecha_creacion_proveedor, reg_fecha_solucion_proveedor) VALUES(0, 6666666, 'Municipal', '2015-09-23 14:29:00', 'Abierto', 'Javier Alonso Betancur Sepulveda', 'Monitoreo_IM', '2015-09-23 17:29:00', 2, 15, 4, 0,'2015-09-23 17:29:00', '2015-09-23 17:29:00');

*/

            
            $this->bd->insert($query);
            $reg_num = $this->get_registro_by_ticket($im["ticket_num"]);
            $row = mysqli_fetch_array($reg_num);
            $fecha = date("Y-m-d H:i:s");            
            $query = "INSERT INTO historial_registro(his_id_ticket, his_id_user, his_tipo, his_fecha)
                        VALUES('{$row["reg_id"]}', '{$user_id}', '1','{$fecha}')";
            $this->bd->insert($query);
        }
        
        public function new_fechas_registro($fecha) {
            date_default_timezone_set("America/Bogota");
            //$date = date("Y") . "-" . date("m") . "-" . date("d");

            $query = "INSERT INTO 
                    fecha(registro_id, fecha_creacion, fecha_actualizacion, fecha_apertura) 
                    VALUES('{$fecha["registro_id"]}', '{$fecha["fecha_creacion"]}', '{$fecha["fecha_actualizacion"]}', '{$fecha["fecha_apertura"]}')";
            //print_r($query);
            $this->bd->insert($query);
            /*$reg_num = $this->get_registro_by_ticket($im["ticket_num"]);
            $row = mysqli_fetch_array($reg_num);
            $fecha = date("Y-m-d H:i:s");            
            $query = "INSERT INTO historial_registro(his_id, his_id_ticket, his_id_user, his_tipo, his_fecha)
                        VALUES('', '" . $row["reg_id"] . "', '" . $user_id. "', '1','". $fecha."')";
            $this->bd->insert($query);*/
        }
        /**
         * Funcion para agregar notas a un registro de IM
         */
        public function new_nota($nota) {
            date_default_timezone_set("America/Bogota");
            //$date = date("Y") . "-" . date("m") . "-" . date("d");

            $query = "INSERT INTO nota(ticket_id, falla_id, usuario_id, nota_fecha, nota_fecha_creado, nota_observacion) 
                    VALUES('{$nota["ticket"]}', '{$nota["falla"]}', '{$nota["usuario"]}', '{$nota["fecha"]}', '{$nota["fecha_creado"]}', '{$nota["observacion"]}')";
            print_r($query);
            //var_dump($query);
			$this->bd->insert($query);
            
        }
        
        public function update_fechas_registro($fecha, $id = 0, $user_id = 0) {
            date_default_timezone_set("America/Bogota");
            $date = date("Y") . "-" . date("m") . "-" . date("d");
           
            $query = "UPDATE fecha SET fecha_actualizacion = '{$fecha["fecha_actualizacion"]}', fecha_cierre = '{$fecha["fecha_cierre"]}'
                                            WHERE fecha_id = {$fecha["fecha_id"]}";
                                           // print_r($query);
             //var_dump($query);                                
            $this->bd->insert($query);            
            /*$fecha = date("Y-m-d H:i:s");            
            $query = "INSERT INTO historial_registro(his_id, his_id_ticket, his_id_user, his_tipo, his_fecha)
                        VALUES('', '{$id}', '{$user_id}', '2','{$fecha}')";
            $this->bd->insert($query);*/
        }

        public function update_registro($im, $id, $user_id) {
            date_default_timezone_set("America/Bogota");
            $date = date("Y") . "-" . date("m") . "-" . date("d");

            /*$query = "UPDATE registro SET reg_fecha_cierre = '" . $im["fecha_cierre"] . "', reg_cola = '" . $im["cola"] . "', reg_estado = '" . $im["estado"] . "',  
                                            reg_falla = '" . $im["falla"] . "', reg_responsabilidad = '" . $im["responsabilidad"] . "', 
                                            reg_observacion = '" . $im["observacion"] . "', reg_fecha_solucion = '" . $im["fecha_solucion"] . "'
                                            WHERE reg_id = " . $id;*/
            
/*            $query = "UPDATE registro SET reg_fecha_cierre = '{$im["fecha_cierre"]}', reg_estado = '{$im["estado"]}',                                             
                                            reg_fecha_solucion = '{$im["fecha_solucion"]}', reg_ticket_proveedor = '{$im["ticket_num_proveedor"]}', 
											reg_fecha_creacion_proveedor = '{$im["fecha_creacion_proveedor"]}', reg_fecha_solucion_proveedor = '{$im["fecha_solucion_proveedor"]}' 
                                            WHERE reg_id = {$id}";*/

               //  $ticketprovee =  0;                        

            $query = "UPDATE registro SET reg_fecha_cierre = '{$im["fecha_cierre"]}', reg_estado = '{$im["estado"]}', reg_fecha_solucion = '{$im["fecha_solucion"]}', reg_ticket_proveedor = '{$im["ticket_num_proveedor"]}',  reg_fecha_creacion_proveedor = '{$im["fecha_creacion_proveedor"]}', reg_fecha_solucion_proveedor = '{$im["fecha_solucion_proveedor"]}' 
                                            WHERE reg_id = {$id}";

                                            


/*
              $query ="  UPDATE registro SET reg_fecha_cierre = '2019-05-12', reg_estado = 'Cerrado', reg_fecha_solucion = '1000-01-01 00:00:00', reg_ticket_proveedor = '0', reg_fecha_creacion_proveedor = '1000-01-01 00:00:00', reg_fecha_solucion_proveedor = '1000-01-01 00:00:00' WHERE reg_id =38236";

        UPDATE registro
SET reg_fecha_creacion_proveedor = '0000-00-00 00:00:00'
WHERE reg_ticket_proveedor = 0;

0001-01-01 00:00:00

*/




            $this->bd->insert($query);            
            $fecha = date("Y-m-d H:i:s");            
            $query = "INSERT INTO historial_registro(his_id_ticket, his_id_user, his_tipo, his_fecha)
                        VALUES('{$id}', '{$user_id}', '2','{$fecha}')";
                        //print_r($query);
            $this->bd->insert($query);
        }

        public function get_registro($id) {
            $query = "SELECT * FROM registro WHERE reg_id = '{$id}'";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
		
		public function get_registro_abiertos($estado = 'Abierto') {
            $query = "SELECT * FROM registro WHERE reg_estado = '{$estado}' ORDER BY reg_tipo asc";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function get_im_id($id) {
            $query = "SELECT * FROM registro WHERE reg_ticket_num = {$id}";
            $this->result = $this->bd->query($query);
            return $this->result;
        }
        
        public function get_fechas_registro($registro_id) {
            $query = "SELECT * FROM fecha WHERE registro_id = '{$registro_id}' ORDER BY fecha_id";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function get_notas_registro($registro_id) {
            $query = "SELECT nota.*, falla.falla_responsable as responsable, falla.falla_descripcion as descripcion FROM nota, falla WHERE nota.ticket_id = '{$registro_id}' AND falla.falla_id = nota.falla_id ORDER BY nota_id";            
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function get_fallas() {
            $query = "SELECT * FROM falla ORDER BY falla_responsable DESC";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function get_registro_num($id) {
            $query = "SELECT * FROM registro WHERE reg_ticket_num = '{$id}'";
            $this->result = $this->bd->select($query);
            return $this->result;
        }

        public function get_registro_by_ticket($ticket) {
            $query = "SELECT reg_id FROM registro WHERE reg_ticket_num = '{$ticket}' ORDER BY reg_id DESC limit 1";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function get_tipo_registraduria($id) {
            $query = "SELECT * FROM tipo_registraduria WHERE tipo_registraduria_id = '{$id}' limit 1";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function get_historial($id) {
            $query = "SELECT users.loginUsers as usuario, hr.his_tipo as tipo, hr.his_fecha as fecha
                      FROM historial_registro as hr, users
                      WHERE users.idUsers = hr.his_id_user AND hr.his_id_ticket = '{$id}' ORDER BY hr.his_fecha ASC";
            $this->result = $this->bd->select($query);
            return $this->result;
        }
        
        public function cargar_registros($id) {
            $query = "LOAD DATA LOCAL INFILE '{$destino}' INTO TABLE bienes FIELDS TERMINATED BY ';' ENCLOSED BY '\"' ESCAPED BY '\\\' LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES";
            $this->result = $this->bd->select($query);
            return $this->result;
        }   

		public function get_ticket_proveedor($fecha_menor, $fecha_mayor) {
            $query = "SELECT r.*, w.proveedor, d.departamento_nombre, m.municipio_nombre, tp.tipo_registraduria_nombre  
					  FROM registro r, wan w, departamento d, municipio m, tipo_registraduria tp 
					  WHERE r.reg_ticket_proveedor != '0' AND r.reg_fecha_solucion_proveedor BETWEEN '{$fecha_menor} 00:00:01' AND '{$fecha_mayor} 23:59:59' AND 
					  r.reg_departamento_id = w.departamento_id AND r.reg_municipio_id = w.municipio_id AND r.reg_tipo_sede = w.tipo_registraduria_id AND r.reg_departamento_id = d.departamento_id AND 
					  r.reg_municipio_id = m.municipio_id AND r.reg_tipo_sede = tp.tipo_registraduria_id
					  ORDER BY reg_fecha_creacion ASC";
            $this->result = $this->bd->select($query);
            //var_dump($query);
            return $this->result;
        }
		
		public function get_cliente($id_depart, $id_munic, $id_sede) {        
        $query = "SELECT registro.reg_cliente FROM registro 
				WHERE registro.reg_departamento_id = {$id_depart} AND registro.reg_municipio_id = {$id_munic} AND registro.reg_tipo_sede = {$id_sede} ORDER BY reg_ticket_num DESC LIMIT 1";        
		$this->result = $this->bd->select($query);
		//var_dump($query);
        return $this->result;
    }
        
        public function get_otrs_num($id) {
            //$query = "SELECT ticket.*, ticket_type.name as name_tk, queue.name as name_qu, customer_user.* FROM ticket,ticket_type,queue,customer_user WHERE tn = " .$id. " AND ticket.type_id = ticket_type.id AND ticket.queue_id = queue.id AND ticket.customer_user_id = customer_user.login" ;            
            $query = "SELECT ticket.*, ticket_type.name as name_tk, queue.name as name_qu FROM ticket,ticket_type,queue WHERE tn = {$id} AND ticket.type_id = ticket_type.id AND ticket.queue_id = queue.id" ;
            $this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
        
        public function get_otrs_last_nota($id) {
            //$query = "SELECT ticket.*, ticket_type.name as name_tk, queue.name as name_qu, customer_user.* FROM ticket,ticket_type,queue,customer_user WHERE tn = " .$id. " AND ticket.type_id = ticket_type.id AND ticket.queue_id = queue.id AND ticket.customer_user_id = customer_user.login" ;            
            //$query = "SELECT ticket_history.id, ticket_history.create_time fecha FROM otrs.ticket_history, otrs.ticket where ticket_history.ticket_id = ticket.id AND ticket.tn = {$id} ORDER BY id DESC LIMIT 1;" ;
            /*$query = "SELECT ticket_history.id, ticket_history.article_id, ticket_history.create_time fecha, article.a_body body 
                        FROM otrs.ticket_history, otrs.ticket, otrs.article 
                        where ticket_history.ticket_id = ticket.id AND article.id = ticket_history.article_id  AND  ticket.tn = {$id} AND ticket_history.article_id != '' ORDER BY id DESC LIMIT 1;";*/
			$query = "SELECT ticket_history.id, ticket_history.article_id, ticket_history.create_time fecha, article.a_body body 
                        FROM otrs.ticket_history, otrs.article 
                        where ticket_history.ticket_id = {$id} AND article.id = ticket_history.article_id AND ticket_history.article_id != '' ORDER BY id DESC LIMIT 1;";
            $this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_abiertos($desde, $hasta) {
			//date_default_timezone_set("America/Bogota");
			//$desde = date("Y-m-d");			
			//$hasta = date("Y-m-d H:i:s");
            $query = "SELECT t.*, th.queue_id cola FROM ticket t, ticket_history th WHERE t.create_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' AND t.id = th.ticket_id AND history_type_id = 1" ;            
            //$query = "SELECT ticket.* FROM ticket WHERE ticket.create_time BETWEEN '{$desde} 00:00:01' AND '{$hasta}'" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_abiertos_cerrados($desde, $hasta) {
			//date_default_timezone_set("America/Bogota");
			//$desde = date("Y-m-d");			
			//$hasta = date("Y-m-d H:i:s");
            $query = "SELECT t.*, th.queue_id cola FROM ticket t, ticket_history th WHERE t.create_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' AND t.change_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' AND t.ticket_state_id IN (2,3) AND t.sla_id IS NOT NULL AND t.id = th.ticket_id AND th.history_type_id = 1;";            
            //$query = "SELECT ticket.* FROM ticket WHERE ticket.create_time BETWEEN '{$desde} 00:00:01' AND '{$hasta}'" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_abiertos_viejos($desde) {
			date_default_timezone_set("America/Bogota");
			//$desde = date("Y-m-d");			
			$hasta = date("Y-m-d H:i:s");
            //$query = "SELECT ticket.*, ticket_type.name as name_tk, queue.name as name_qu, customer_user.* FROM ticket,ticket_type,queue,customer_user WHERE tn = " .$id. " AND ticket.type_id = ticket_type.id AND ticket.queue_id = queue.id AND ticket.customer_user_id = customer_user.login" ;            
            $query = "SELECT t.*, th.queue_id cola FROM ticket t, ticket_history th WHERE t.create_time < '{$desde} 00:00:01' AND t.ticket_state_id NOT IN (2,3) AND t.sla_id IS NOT NULL AND t.id = th.ticket_id AND th.history_type_id = 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_cerrados_viejos($fecha) {
			date_default_timezone_set("America/Bogota");
			$desde = $fecha;//date("Y-m-d");			
			$hasta = $fecha;//date("Y-m-d");
            //$query = "SELECT ticket.*, ticket_type.name as name_tk, queue.name as name_qu, customer_user.* FROM ticket,ticket_type,queue,customer_user WHERE tn = " .$id. " AND ticket.type_id = ticket_type.id AND ticket.queue_id = queue.id AND ticket.customer_user_id = customer_user.login" ;            
            $query = "SELECT t.*, th.queue_id cola FROM ticket t, ticket_history th WHERE t.create_time < '{$desde} 00:00:01' AND t.change_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' AND t.ticket_state_id IN (2,3) AND t.sla_id IS NOT NULL AND t.id = th.ticket_id AND history_type_id = 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		/**
		* Esta funcion valida los ticket que fueron cerrados posterior a la fecha de consulta con el fin de determinar los tickets que estaban abiertos para dicha fecha y que fueron creados antes de la fecha de consluta
		* $desde = $fecha_consulta + 1 dia
		*/
		public function get_otrs_abiertos_viejos_fecha($fecha_consulta, $desde) {
			date_default_timezone_set("America/Bogota");
			//$desde = $fecha;//date("Y-m-d");			
			$hasta = date("Y-m-d");
            //$query = "SELECT ticket.*, ticket_type.name as name_tk, queue.name as name_qu, customer_user.* FROM ticket,ticket_type,queue,customer_user WHERE tn = " .$id. " AND ticket.type_id = ticket_type.id AND ticket.queue_id = queue.id AND ticket.customer_user_id = customer_user.login" ;            
            $query = "SELECT t.*, th.queue_id cola FROM ticket t, ticket_history th WHERE t.create_time < '{$fecha_consulta} 00:00:01' AND t.change_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' AND t.ticket_state_id IN (2,3) AND t.sla_id IS NOT NULL AND t.id = th.ticket_id AND history_type_id = 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_ticket_escalado($id, $desde, $hasta) {			
			$query = "SELECT th.* FROM ticket t, ticket_history th WHERE t.id = {$id} AND t.id = th.ticket_id AND th.history_type_id = 16 AND th.queue_id != 17 AND th.change_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' ORDER BY th.id ASC LIMIT 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_ticket_uClosed($id, $desde, $hasta) {			
			$query = "SELECT th.* FROM ticket t, ticket_history th WHERE t.id = {$id} AND t.id = th.ticket_id AND th.history_type_id = 16 AND th.queue_id = 17 AND th.change_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' ORDER BY th.id DESC LIMIT 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_ticket_cerrados($desde, $hasta) {			
			$query = "SELECT t.id, t.tn, t.customer_user_id user, q.name FROM ticket t, queue q WHERE t.sla_id IS NOT NULL AND t.sla_id!=15 AND  t.change_time BETWEEN '{$desde} 00:00:01' AND '{$hasta} 23:59:59' AND t.ticket_state_id in(2,3) AND t.queue_id = q.id ORDER BY t.tn ASC" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_ticket_cola_uClosed($id) {			
			$query = "SELECT th.* FROM ticket t, ticket_history th WHERE t.id = {$id} AND t.id = th.ticket_id AND th.history_type_id = 16 AND th.queue_id = 17 ORDER BY th.id DESC LIMIT 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		
		public function get_otrs_users_by_ticket($id) {			
			$query = "SELECT DISTINCT th.ticket_id, th.create_by FROM ticket_history th WHERE th.ticket_id = {$id} AND th.change_by != 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		
		public function get_otrs_user($id) {			
			$query = "SELECT u.* FROM users u WHERE u.id = {$id} LIMIT 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		//Consultas para actualizar la BBDD de desarrollo Une con el id del ticket que maneja OTRS
		//trae el id del ticket de OTRS
		public function get_otrs_ticket_id($id) {			
			$query = "SELECT t.id FROM ticket t WHERE t.tn = {$id} LIMIT 1" ;			
            //var_dump($query);
			$this->result = $this->bd_remote->query($query);           
            return $this->result;
        }
		//trae el listado de ticket en desarrollo une que tiene el nuevo campo ticket_id en cero
		public function get_list_ticket_im_id_0(){
			$query = "SELECT r.reg_ticket_num FROM registro r WHERE reg_ticket_id = 0";
			$this->result = $this->bd->query($query);           
            return $this->result;
		}
		//actualiza la tabla de registro de ticket con el id de OTRS
		public function update_registro_ticket_id($ticket, $id) {          
            $query = "UPDATE registro SET reg_ticket_id = '{$id}' 
                                            WHERE reg_ticket_num = {$ticket} limit 1";
            $this->bd->insert($query);          
        }
    }
?>