<?php
	include_once("ManejadorBD.php");

	class modelo extends ManejadorBD {

		private $idModelo;
		private $Modelo;
		private $marca_idMarca;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdModelo($idModelo) {
			$this->idModelo= $idModelo;
			return $this;
		}

		public function getIdModelo() {
			return $this->idModelo;
		}

		public function setModelo($Modelo) {
			$this->Modelo= $Modelo;
			return $this;
		}

		public function getModelo() {
			return $this->Modelo;
		}

		public function setMarcaID($marca_idMarca) {
			$this->marca_idMarca= $marca_idMarca;
			return $this;
		}

		public function getMarcaID() {
			return $this->marca_idMarca;
		}

		public function consultarModelo() {
			try {
				$statement= $this->db->prepare("SELECT * FROM modelo WHERE idModelo= :idModelo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idModelo', $this->idModelo);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosModelos() {
			try {
				$statement= $this->db->prepare("SELECT * FROM modelo WHERE marca_idMarca= :marca_idMarca");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':marca_idMarca', $this->marca_idMarca);

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
				$statement= $this->db->prepare("SELECT idModelo FROM modelo WHERE Modelo= :Modelo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Modelo', $this->Modelo);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirModelo() {
			try {
				$statement= $this->db->prepare("INSERT INTO modelo (Modelo, marca_idMarca) VALUES (:Modelo, :marca_idMarca)");

				$statement->bindParam(':Modelo', $this->Modelo);
				$statement->bindParam(':marca_idMarca', $this->marca_idMarca);

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