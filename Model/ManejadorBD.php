<?php
   //Codigo del Profesor Francisco Montilla
	include_once("config.php"); // Valores de la conexion

	class ManejadorBD extends PDO {

		public $srv	= SRV; // Servidor
		public $usr	= USR; // Usuario
		public $pas	= PAS; // Password
		public $dbn	= BDN; // Base de Datos

		private $conexionBD; // Conexion Base de Database

		public function __construct($tipoConexion) { 
			// Constructor de la clase
		}

		public function conectar($tipoConexion){
			try{
				switch ($tipoConexion) {
				    case 0: // Postgresql
				        $dsn = "pgsql:dbname=$this->dbn;host=$this->srv";
				        $mensaje = "Conexion Exitosa Postgresql";
				        break;
				    case 1: // Mysql
				        $dsn = "mysql:host=$this->srv;dbname=$this->dbn";
				        //$mensaje = "Conexion Exitosa Mysql";
				        break;				    
				}
				$dbh = new PDO($dsn, $this->usr, $this->pas);
    			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Permite manejar los errores
    			//echo $mensaje;
			}catch(PDOException $error){
                echo "Error al Conectar con la Base de Datos: ".$error->getMessage();
                exit(); 
			}
            
            $this->conexionBD = $dbh;
			return $this->conexionBD;	
		}

		public function cerrarConexion(){
			$this->conexionBD = null;
		}
	}
	
	//Redirecciona a otra pagina dentro del directorio de ejecucion
	function redireccionar($url) { 
		ob_start();   // Se utiliza para solucionar el error de  headers already sent 
		$host=$_SERVER['HTTP_HOST'];  //Devuelve la direccion web: Ejemplo: www.cantv.net
		//echo "Host: ".$host."<br>";
		$uri=rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); //Devuelve el Directorio desde donde se esta ejecutando la pagina que invoca la funcion.
		//echo "Uri: ".$uri."<br>";
		header("Location: http://$host$uri/$url"); //Redirecciona a la Pagina Solicitada
		ob_flush();  // Se utiliza para solucionar el error de  headers already sent 
	}
	// Fin Funcion
?>