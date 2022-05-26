<?php
class View{
    function __construct(){	
        //echo "CONSTRUYO View"."<br>";
    }
 
    public function path($name, $vars = array()){
	//$name es el nombre de nuestra plantilla, por ej, listado.php
        //$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.
 
        //Traemos una instancia de nuestra clase de configuracion.		
        $config = Configs::getInstance();
 
        //Armamos la ruta a la plantilla
        $path = $config->get('carpetaVista') . $name;
        //$path = 'views/'. $name;
 
        //Si no existe el fichero en cuestion, mostramos un 404
        if (file_exists($path) == false){
            trigger_error ('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
 
        //Si hay variables para asignar, las pasamos una a una.
        /*if(is_array($vars)){
			foreach ($vars as $key => $value){
				$key = $value;
			}
		}*/
        //Finalmente, incluimos la plantilla.
        return $path;
    }
	
	/* METODO QUE CARGA LAS PARTES PRINCIPALES DE LA PAGINA WEB
		INPUT
		$title | titulo en string del header
		OUTPIT
		$pagina | string que contiene toda el cocigo HTML de la plantilla 
	*/	
	public function load_template($title='Sin Titulo', $pagina){
        //$pagina = $this->load_page('views/default/page1.php');
        $header = $this->load_page('views/default/sections/s.header.php');
        $pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
        $pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);
        //$menu_left = $this->load_page('views/default/sections/s.menuizquierda.php');
        //$pagina = $this->replace_content('/\#MENULEFT\#/ms' ,$menu_left , $pagina);
        $footer = $this->load_page('views/default/sections/s.footer.php');
        $pagina = $this->replace_content('/\#FOOTER\#/ms' ,$footer , $pagina);
        ob_start();
        include 'views/default/sections/s.menuizquierda.php';
        $menu = ob_get_clean();
        //$menu = $this->load_page('views/default/sections/s.menuizquierda.php');
        $pagina = $this->replace_content('/\#MENULEFT\#/ms', $menu , $pagina);
        $pagina = $this->replace_content('/\#USUARIO_ID\#/ms', @$_SESSION["id_user"], $pagina);
        
        $pagina = $this->replace_content('/\#USUARIO\#/ms', @$_SESSION["usuario"] , $pagina);
        return $pagina;
	}
	
	/* METODO QUE CARGA UNA PAGINA DE LA SECCION VIEW Y LA MANTIENE EN MEMORIA
		INPUT
		$page | direccion de la pagina 
		OUTPUT
		STRING | devuelve un string con el codigo html cargado
	*/
	public function load_page($page){
            return file_get_contents($page);
	}
	
	/* PARSEA LA PAGINA CON LOS NUEVOS DATOS ANTES DE MOSTRARLA AL USUARIO
		INPUT
		$out | es el codigo html con el que sera reemplazada la etiqueta CONTENIDO
		$pagina | es el codigo html de la pagina que contiene la etiqueta CONTENIDO
		OUTPUT
		HTML | cuando realiza el reemplazo devuelve el codigo completo de la pagina
	*/
	public function replace_content($in='/\#CONTENIDO\#/ms', $out,$pagina){
            return preg_replace($in, $out, $pagina);
	}
	
	/* METODO QUE ESCRIBE EL CODIGO PARA QUE SEA VISTO POR EL USUARIO
		INPUT
		$html | codigo html
		OUTPUT
		HTML | codigo html 
	*/
	public function view_page($html){
		echo $html;
	}
	
	public function load_script($path){
        If($path=="")
            return "<!--cargar_script-->";
        else
            return "<script src=\"".$path."\" type=\"text/javascript\"></script>
                    <!--cargar_script-->";
	}
	public function load_css($path){
        If($path=="")
            return "<!--cargar_css-->";
        else
            return "<link rel=\"stylesheet\" href=\"".$path."\" type=\"text/css\" media=\"screen\" />
                    <!--cargar_css-->";
	}
        
    public function load_content($in='/\#CONTENIDO\#/ms', $out,$pagina){           
        return $pagina;
	}
}

?>