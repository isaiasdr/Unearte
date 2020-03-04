<?php
	include_once("ManejadorBD.php");

	class sede extends ManejadorBD {

		private $idSede;
		private $Sede;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdSede($idSede) {
			$this->idSede= $idSede;
			return $this;
		}

		public function getIdSede() {
			return $this->idSede;
		}

		public function setSede($Sede) {
			$this->Sede= $Sede;
			return $this;
		}

		public function getSede() {
			return $this->Sede;
		}

		public function consultarSede() {
			try {
				$statement= $this->db->prepare("SELECT Sede FROM sede WHERE idSede= :idSede");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idSede', $this->idSede);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosSedes() {
			try {
				$statement= $this->db->prepare("SELECT * FROM sede");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarID() {
			try {
				$statement= $this->db->prepare("SELECT idSede FROM sede WHERE Sede= :Sede");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Sede', $this->Sede);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirSede() {
			try {
				$statement= $this->db->prepare("INSERT INTO sede (Sede) VALUES (:Sede)");

				$statement->bindParam(':Sede', $this->Sede);

				//ejecucion
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