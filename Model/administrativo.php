<?php
	include_once("ManejadorBD.php");

	class administrativo extends ManejadorBD {

		private $idAdministrativo;
		private $Personal;
		private $departamento_idDepartamento;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdAdministrativo($idAdministrativo) {
			$this->idAdministrativo= $idAdministrativo;
			return $this;
		}

		public function getIdAdministrativo() {
			return $this->idAdministrativo;
		}

		public function setPersonal($Personal) {
			$this->Personal= $Personal;
			return $this;
		}

		public function getPersonal() {
			return $this->Personal;
		}

		public function setDepartamentoID($departamento_idDepartamento) {
			$this->departamento_idDepartamento= $departamento_idDepartamento;
			return $this;
		}

		public function getDepartamentoID() {
			return $this->departamento_idDepartamento;
		}

		public function consultarAdministrativo() {
			try {
				$statement= $this->db->prepare("SELECT * FROM administrativo WHERE idAdministrativo= :idAdministrativo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idAdministrativo', $this->idAdministrativo);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosAdministrativo() {
			try {
				$statement= $this->db->prepare("SELECT * FROM administrativo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosAdministrativoXDepartamento() {
			try {
				$statement= $this->db->prepare("SELECT * FROM administrativo WHERE departamento_idDepartamento= :departamento_idDepartamento");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':departamento_idDepartamento', $this->departamento_idDepartamento);

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
				$statement= $this->db->prepare("SELECT idAdministrativo FROM administrativo WHERE Personal= :Personal");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Personal', $this->Personal);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirAdministrativo() {
			try {
				$statement= $this->db->prepare("INSERT INTO administrativo (Personal, departamento_idDepartamento) VALUES (:Personal, :departamento_idDepartamento)");

				$statement->bindParam(':Personal', $this->Personal);
				$statement->bindParam(':departamento_idDepartamento', $this->departamento_idDepartamento);

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