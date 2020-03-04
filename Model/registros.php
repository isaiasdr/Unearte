<?php
	include_once("ManejadorBD.php");

	class registros extends ManejadorBD {
		
		private $idRegistros;
		private $Usuario;
		private $Fecha;
		private $Descripcion;
		private $evento_idEvento;

		private $db;

		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setID($idRegistros) {
			$this->idRegistros= $idRegistros;
			return $this;
		}

		public function getID() {
			return $this->idRegistros;
		}

		public function setUsuario($Usuario) {
			$this->Usuario= $Usuario;
			return $this;
		}

		public function getUsuario() {
			return $this->Usuario;
		}

		public function setFecha($Fecha) {
			$this->Fecha= $Fecha;
			return $this;
		}

		public function getFecha() {
			return $this->Fecha;
		}

		public function setDescripcion($Descripcion) {
			$this->Descripcion= $Descripcion;
			return $this;
		}

		public function getDescripcion() {
			return $this->Descripcion;
		}

		public function setEventoID($evento_idEvento) {
			$this->evento_idEvento= $evento_idEvento;
			return $this;
		}

		public function getEventoID() {
			return $this->evento_idEvento;
		}

		public function consultarRegistros() {
			try {
				$statement= $this->db->prepare("SELECT * FROM registros");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->execute();
				return $statement->fetchAll();
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function crearRegistro() {
			try {
				$statement= $this->db->prepare("INSERT INTO registros (Usuario, Fecha, Descripcion, evento_idEvento)
											VALUES (:Usuario, :Fecha, :Descripcion, :evento_idEvento)");

				//se asignan los valores
				$statement->bindParam(':Usuario', $this->Usuario);
				$statement->bindParam(':Fecha', $this->Fecha);
				$statement->bindParam(':Descripcion', $this->Descripcion);
				$statement->bindParam(':evento_idEvento', $this->evento_idEvento);

				$success= $statement->execute();
				return $success;

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}
	}
?>