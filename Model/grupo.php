<?php
	include_once("ManejadorBD.php");

	class grupo extends ManejadorBD {

		private $idGrupo;
		private $Grupo;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdGrupo($idGrupo) {
			$this->idGrupo= $idGrupo;
			return $this;
		}

		public function getIdGrupo() {
			return $this->idGrupo;
		}

		public function setGrupo($Grupo) {
			$this->Grupo= $Grupo;
			return $this;
		}

		public function getGrupo() {
			return $this->Grupo;
		}

		public function consultarGrupo() {
			try {
				$statement= $this->db->prepare("SELECT Grupo FROM grupo WHERE idGrupo= :idGrupo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idGrupo', $this->idGrupo);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarTodosGrupos() {
			try {
				$statement= $this->db->prepare("SELECT * FROM grupo");
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
				$statement= $this->db->prepare("SELECT idGrupo FROM grupo WHERE Grupo= :Grupo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Grupo', $this->Grupo);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirGrupo() {
			try {
				$statement= $this->db->prepare("INSERT INTO grupo (Grupo) VALUES (:Grupo)");

				$statement->bindParam(':Grupo', $this->Grupo);

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