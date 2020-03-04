<?php
	include_once("ManejadorBD.php");

	class status extends ManejadorBD {

		private $idStatus;
		private $Status;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdStatus($idStatus) {
			$this->idStatus= $idStatus;
			return $this;
		}

		public function getIdStatus() {
			return $this->idStatus;
		}

		public function setStatus($Status) {
			$this->Status= $Status;
			return $this;
		}

		public function getStatus() {
			return $this->Status;
		}

		public function consultarStatus() {
			try {
				$statement= $this->db->prepare("SELECT Status FROM status WHERE idStatus= :idStatus");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idStatus', $this->idStatus);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosStatus() {
			try {
				$statement= $this->db->prepare("SELECT * FROM status");
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
				$statement= $this->db->prepare("SELECT idStatus FROM status WHERE Status= :Status");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Status', $this->Status);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirStatus() {
			try {
				$statement= $this->db->prepare("INSERT INTO status (Status) VALUES (:Status)");

				$statement->bindParam(':Status', $this->Status);

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