<?php
	include_once("ManejadorBD.php"); //clase para el manejo de la conexion a la base de datos

	class usuario extends ManejadorBD {

		private $Username;
		private $Password;
		private $Estado;
		private $clases_usuario_idClase;

		private $db;

		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setUsername($Username) {
			$this->Username = $Username;
			return $this;
		}

		public function getUsername() {
			return $this->Username;
		}

		public function setPassword($Password) {
			$this->Password= $Password;
			return $this;
		}

		public function getPassword() {
			return $this->Password;
		}

		public function setEstado($Estado) {
			$this->Estado= $Estado;
			return $this;
		}

		public function getEstado() {
			return $this->Estado;
		}

		public function setRolID($clases_usuario_idClase) {
			$this->clases_usuario_idClase= $clases_usuario_idClase;
			return $this;
		}

		public function getRolID() {
			return $this->clases_usuario_idClase;
		}

		//metodos de la clase

		public function consultarUsuarios() {
			try {
				$statement= $this->db->prepare("SELECT Username, Estado ,clases_usuario_idClase FROM usuario");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		//solo podra ser usado por administrador		
		public function crearUsuario() {
			try {
				$statement= $this->db->prepare("INSERT INTO usuario (Username, Password, Estado, clases_usuario_idClase) 
													VALUES (:Username, :Password, :Estado, :clases_usuario_idClase)");

				//se asignan los valores
				$statement->bindParam(':Username', $this->Username);
				$statement->bindParam(':Password', $this->Password);
				$statement->bindParam(':Estado', $this->Estado);
				$statement->bindParam(':clases_usuario_idClase', $this->clases_usuario_idClase);

				//ejecucion
				$success= $statement->execute();
				return $success;

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function seleccionarUsuario() {
			try {
				$statement= $this->db->prepare("SELECT * FROM usuario WHERE Username= :Username");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Username', $this->Username);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		//puede ser usado por todos y el administrador para "resetear" la contraseña de un usuario que la olvide
		public function cambioPassword() {
			try {
				$statement= $this->db->prepare("UPDATE usuario SET Password= :Password WHERE Username= :Username");

				//se asigna el valor de la contraseña
				$statement->bindParam(':Password', $this->Password);
				$statement->bindParam(':Username', $this->Username);

				$statement->execute();
				return $statement->rowCount();

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function cambioRol() {
			try {
				$statement= $this->db->prepare("UPDATE usuario SET clases_usuario_idClase= :clases_usuario_idClase WHERE Username= :Username");

				//se asignan los valores
				$statement->bindParam(':clases_usuario_idClase', $this->clases_usuario_idClase);
				$statement->bindParam(':Username', $this->Username);

				$statement->execute();
				return $statement->rowCount();
				
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		//solo puede ser usado por el administrador
		public function CambiarEstado() {
			try {
				$statement= $this->db->prepare("UPDATE usuario SET Estado = :Estado WHERE Username= :Username");

				$statement->bindParam(':Estado', $this->Estado);
				$statement->bindParam(':Username', $this->Username);

				$statement->execute();
				return $statement->rowCount();
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}
	}
?>