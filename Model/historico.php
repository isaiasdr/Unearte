<?php
	include_once("ManejadorBD.php");

	class historico extends ManejadorBD {

		private $idHistorico;
		private $Descripcion;
		private $FechaFalla;
		private $FechaMantenimiento;
		private $Requerimientos;
		private $Solventado;
		private $equipo_idEquipo;
		private $fallas_idFallas;		

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdhistorico($idHistorico) {
			$this->idHistorico= $idHistorico;
			return $this;
		}

		public function getIdhistorico() {
			return $this->idHistorico;
		}

		public function setDescripcion($Descripcion) {
			$this->Descripcion = $Descripcion;
			return $this;
		}

		public function getDescripcion() {
			return $this->Descripcion;
		}

		public function setFechaFalla($FechaFalla) {
			$this->FechaFalla = $FechaFalla;
			return $this;
		}

		public function getFechaFalla() {
			return $this->FechaFalla;
		}

		public function setFechaMantenimiento($FechaMantenimiento) {
			$this->FechaMantenimiento = $FechaMantenimiento;
			return $this;
		}

		public function getFechaMantenimiento() {
			return $this->FechaMantenimiento;
		}

		public function setRequerimientos($Requerimientos) {
			$this->Requerimientos= $Requerimientos;
			return $this;
		}

		public function getRequerimientos() {
			return $this->Requerimientos;
		}

		public function setSolventado($Solventado)
		{
			$this->Solventado= $Solventado;
			return $this;
		}

		public function getSolventado() {
			return $this->Solventado;
		}

		public function setEquipoID($equipo_idEquipo) {
			$this->equipo_idEquipo = $equipo_idEquipo;
			return $this;
		}

		public function getEquipoID() {
			return $this->equipo_idEquipo;
		}

		public function setFallasID($fallas_idFallas) {
			$this->fallas_idFallas = $fallas_idFallas;
			return $this;
		}

		public function getFallasID() {
			return $this->fallas_idFallas;
		}

		public function consultarHistorico() {
			try {
				$statement= $this->db->prepare("SELECT * FROM historico WHERE idHistorico= :idHistorico");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idHistorico', $this->idHistorico);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarHistoricoEquipo() {
			try {
				$statement= $this->db->prepare("SELECT * FROM historico WHERE equipo_idEquipo= :equipo_idEquipo ORDER BY idHistorico DESC");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':equipo_idEquipo', $this->equipo_idEquipo);
				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirHistorico() {
			try {
				$statement= $this->db->prepare("INSERT INTO historico (Descripcion, FechaFalla, FechaMantenimiento, Requerimientos, Solventado, equipo_idEquipo, fallas_idFallas) VALUES (:Descripcion, :FechaFalla, :FechaMantenimiento, :Requerimientos, :Solventado, :equipo_idEquipo, :fallas_idFallas)");

				//se asignan los valores
				$statement->bindParam(':Descripcion', $this->Descripcion);
				$statement->bindParam(':FechaFalla', $this->FechaFalla);
				$statement->bindParam(':FechaMantenimiento', $this->FechaMantenimiento);
				$statement->bindParam(':Requerimientos', $this->Requerimientos);
				$statement->bindParam(':Solventado', $this->Solventado);
				$statement->bindParam(':equipo_idEquipo', $this->equipo_idEquipo);
				$statement->bindParam(':fallas_idFallas', $this->fallas_idFallas);

				$success= $statement->execute();
				return $success;

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function registrarMantenimiento() {
			try {
				$statement= $this->db->prepare("UPDATE historico SET FechaMantenimiento= :FechaMantenimiento, Solventado= :Solventado WHERE idHistorico= :idHistorico");

				//se asignan los valores
				$statement->bindParam(':FechaMantenimiento', $this->FechaMantenimiento);
				$statement->bindParam(':Solventado', $this->Solventado);
				$statement->bindParam(':idHistorico', $this->idHistorico);

				$statement->execute();
				return $statement->rowCount();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function historicosPorFalla() {
			try {
				$statement= $this->db->prepare("SELECT * FROM historico WHERE fallas_idFallas= :fallas_idFallas AND Solventado= :Solventado");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':fallas_idFallas', $this->fallas_idFallas);
				$statement->bindParam(':Solventado', $this->Solventado);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function contarRegistrosHistorico() {
			try {
				$statement= $this->db->prepare("SELECT idHistorico FROM historico");
			
				$statement->execute();
				return $statement->rowCount();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}
	}
?>