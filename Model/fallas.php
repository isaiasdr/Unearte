<?php
	include_once("ManejadorBD.php");

	class fallas extends ManejadorBD {

		private $idFallas;
		private $Fallas;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdFallas($idFallas) {
			$this->idFallas= $idFallas;
			return $this;
		}

		public function getIdFallas() {
			return $this->idFallas;
		}

		public function setFallas($Fallas) {
			$this->Fallas= $Fallas;
			return $this;
		}

		public function getFallas() {
			return $this->Fallas;
		}

		public function consultarFallas() {
			try {
				$statement= $this->db->prepare("SELECT Fallas FROM fallas WHERE idFallas= :idFallas");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idFallas', $this->idFallas);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodasFallas() {
			try {
				$statement= $this->db->prepare("SELECT * FROM fallas");
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
				$statement= $this->db->prepare("SELECT idFallas FROM fallas WHERE Fallas= :Fallas");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Fallas', $this->Fallas);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function registrarFalla() {
			try {
				$statement= $this->db->prepare("INSERT INTO fallas (Fallas) VALUES (:Fallas)");

				$statement->bindParam(':Fallas', $this->Fallas);

				$success= $statement->execute();
				return $success;

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}
	}
?>