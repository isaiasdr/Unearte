<?php
	include_once("ManejadorBD.php");

	class departamento extends ManejadorBD {

		private $idDepartamento;
		private $Departamento;
		private $piso_idPiso; 

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdDepartamento($idDepartamento) {
			$this->idDepartamento= $idDepartamento;
			return $this;
		}

		public function getIdDepartamento() {
			return $this->idDepartamento;
		}

		public function setDepartamento($Departamento) {
			$this->Departamento= $Departamento;
			return $this;
		}

		public function getDepartamento() {
			return $this->Departamento;
		}

		public function setPisoID($piso_idPiso) {
			$this->piso_idPiso= $piso_idPiso;
			return $this;
		}

		public function getPisoID() {
			return $this->piso_idPiso;
		}

		public function consultarDepartamento() {
			try {
				$statement= $this->db->prepare("SELECT * FROM departamento WHERE idDepartamento= :idDepartamento");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idDepartamento', $this->idDepartamento);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosDepartamentosXPiso() {
			try {
				$statement= $this->db->prepare("SELECT * FROM departamento WHERE piso_idPiso= :piso_idPiso");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':piso_idPiso', $this->piso_idPiso);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosDepartamentos() {
			try {
				$statement= $this->db->prepare("SELECT * FROM departamento");
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
				$statement= $this->db->prepare("SELECT idDepartamento FROM departamento WHERE Departamento= :Departamento");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Departamento', $this->Departamento);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirDepartamento() {
			try {
				$statement= $this->db->prepare("INSERT INTO departamento (Departamento, piso_idPiso) VALUES (:Departamento, :piso_idPiso)");

				$statement->bindParam(':Departamento', $this->Departamento);
				$statement->bindParam(':piso_idPiso', $this->piso_idPiso);

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