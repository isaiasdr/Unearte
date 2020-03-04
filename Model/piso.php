<?php
	include_once("ManejadorBD.php");

	class piso extends ManejadorBD {

		private $idPiso;
		private $Piso;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdPiso($idPiso) {
			$this->idPiso= $idPiso;
			return $this;
		}

		public function getIdPiso() {
			return $this->idPiso;
		}

		public function setPiso($Piso) {
			$this->Piso= $Piso;
			return $this;
		}

		public function getPiso() {
			return $this->Piso;
		}

		public function consultarPiso() {
			try {
				$statement= $this->db->prepare("SELECT Piso FROM piso WHERE idPiso= :idPiso");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idPiso', $this->idPiso);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosPisos() {
			try {
				$statement= $this->db->prepare("SELECT * FROM piso ORDER BY piso ASC");
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
				$statement= $this->db->prepare("SELECT idPiso FROM piso WHERE Piso= :Piso");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Piso', $this->Piso);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirPiso() {
			try {
				$statement= $this->db->prepare("INSERT INTO piso (Piso) VALUES (:Piso)");

				$statement->bindParam(':Piso', $this->Piso);

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