<?php
	include_once("ManejadorBD.php"); //clase para el manejo de la conexion a la base de datos

	class clases_usuario extends ManejadorBD {

		private $idClase;
		private $Tipo_Usuario;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdClase($idClase) {
			$this->idClase= $idClase;
			return $this;
		}

		public function getIdClase() {
			return $this->idClase;
		}

		public function setTipo_Usuario($Tipo_Usuario) {
			$this->Tipo_Usuario= $Tipo_Usuario;
			return $this;
		}

		public function getTipo_Usuario() {
			return $this->Tipo_Usuario;
		}

		public function consultaTipoUsuario() {
			try {
				$statement= $this->db->prepare("SELECT Tipo_Usuario FROM clases_usuario WHERE idClase = :idClase");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idClase', $this->idClase);

				$statement->execute();
				return $statement->fetchAll();
				
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultaIdTipoUsuario() {
			try {
				$statement= $this->db->prepare("SELECT idClase FROM clases_usuario WHERE Tipo_Usuario = :Tipo_Usuario");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Tipo_Usuario', $this->Tipo_Usuario);

				$statement->execute();
				return $statement->fetchAll();
				
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosTiposUsuario() {
			try {
				$statement= $this->db->prepare("SELECT * FROM clases_usuario");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}
	}
?>