<?php
	include_once("ManejadorBD.php");

	class sistema_operativo extends ManejadorBD {
		
		private $idSistema_operativo;
		private $SO;

		private $db;

		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setID($idSistema_operativo) {
			$this->idSistema_operativo= $idSistema_operativo;
			return $this;
		}

		public function getID() {
			return $this->idSistema_operativo;
		}

		public function setSO($SO) {
			$this->SO= $SO;
			return $this;
		}

		public function getSO() {
			return $this->SO;
		}

		public function consultarSO() {
			try {
				$statement= $this->db->prepare("SELECT SO FROM sistema_operativo WHERE idSistema_operativo= :idSistema_operativo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idSistema_operativo', $this->idSistema_operativo);

				$statement->execute();
				return $statement->fetchAll();
				
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosSO() {
			try {
				$statement= $this->db->prepare("SELECT * FROM sistema_operativo");
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
				$statement= $this->db->prepare("SELECT idSistema_operativo FROM sistema_operativo WHERE SO= :SO");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':SO', $this->SO);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirSO() {
			try {
				$statement= $this->db->prepare("INSERT INTO sistema_operativo (SO) VALUES (:SO)");

				$statement->bindParam(':SO', $this->SO);

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