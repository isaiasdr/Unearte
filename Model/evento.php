<?php
	include_once("ManejadorBD.php");

	class evento extends ManejadorBD {

		private $idEvento;
		private $Evento;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdEvento($idEvento) {
			$this->idEvento= $idEvento;
			return $this;
		}

		public function getIdEvento() {
			return $this->idEvento;
		}

		public function setEvento($Evento) {
			$this->Evento= $Evento;
			return $this;
		}

		public function getEvento() {
			return $this->Evento;
		}

		public function consultarIDEvento() {
			try {
				$statement= $this->db->prepare("SELECT idEvento FROM evento WHERE Evento= :Evento");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Evento', $this->Evento);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarEvento() {
			try {
				$statement= $this->db->prepare("SELECT Evento FROM evento WHERE idEvento= :idEvento");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idEvento', $this->idEvento);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirEvento() {
			try {
				$statement= $this->db->prepare("INSERT INTO evento (Evento) VALUES (:Evento)");

				$statement->bindParam(':Evento', $this->Evento);

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