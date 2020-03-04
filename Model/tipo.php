<?php
	include_once("ManejadorBD.php");

	class tipo extends ManejadorBD {

		private $idTipo;
		private $Tipo;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdTipo($idTipo) {
			$this->idTipo= $idTipo;
			return $this;
		}

		public function getIdTipo() {
			return $this->idTipo;
		}

		public function setTipo($Tipo) {
			$this->Tipo= $Tipo;
			return $this;
		}

		public function getTipo() {
			return $this->Tipo;
		}

		public function consultarTipo() {
			try {
				$statement= $this->db->prepare("SELECT Tipo FROM tipo WHERE idTipo= :idTipo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idTipo', $this->idTipo);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosTipos() {
			try {
				$statement= $this->db->prepare("SELECT * FROM tipo");
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
				$statement= $this->db->prepare("SELECT idTipo FROM tipo WHERE Tipo= :Tipo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Tipo', $this->Tipo);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirTipo() {
			try {
				$statement= $this->db->prepare("INSERT INTO tipo (Tipo) VALUES (:Tipo)");

				$statement->bindParam(':Tipo', $this->Tipo);

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