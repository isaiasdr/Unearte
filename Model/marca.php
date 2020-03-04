<?php
	include_once("ManejadorBD.php");

	class marca extends ManejadorBD {

		private $idMarca;
		private $Marca;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdMarca($idMarca) {
			$this->idMarca= $idMarca;
			return $this;
		}

		public function getIdMarca() {
			return $this->idMarca;
		}

		public function setMarca($Marca) {
			$this->Marca= $Marca;
			return $this;
		}

		public function getMarca() {
			return $this->Marca;
		}

		public function consultarMarca() {
			try {
				$statement= $this->db->prepare("SELECT Marca FROM marca WHERE idMarca= :idMarca");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idMarca', $this->idMarca);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosMarcas() {
			try {
				$statement= $this->db->prepare("SELECT * FROM marca");
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
				$statement= $this->db->prepare("SELECT idMarca FROM marca WHERE Marca= :Marca");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Marca', $this->Marca);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirMarca() {
			try {
				$statement= $this->db->prepare("INSERT INTO marca (Marca) VALUES (:Marca)");

				$statement->bindParam(':Marca', $this->Marca);

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