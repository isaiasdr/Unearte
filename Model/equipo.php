<?php
	include_once("ManejadorBD.php");

	class equipo extends ManejadorBD {

		private $idEquipo;
		private $Bien_Nacional;
		private $Chapa_Vieja;
		private $Serial;
		private $Observaciones;
		private $status_idStatus;
		private $tipo_idTipo;
		private $sede_idSede;
		private $modelo_idModelo;
		private $administrativo_idAdministrativo;

		private $db;
		
		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setIdEquipo($idEquipo) {
			$this->idEquipo= $idEquipo;
			return $this;
		}

		public function getIdEquipo() {
			return $this->idEquipo;
		}

		public function setBien_Nacional($Bien_Nacional) {
			$this->Bien_Nacional= $Bien_Nacional;
			return $this;
		}

		public function getBien_Nacional() {
			return $this->Bien_Nacional;
		}

		public function setChapa_Vieja($Chapa_Vieja) {
			$this->Chapa_Vieja= $Chapa_Vieja;
			return $this;
		}

		public function getChapa_Vieja() {
			return $this->Chapa_Vieja;
		}

		public function setSerial($Serial) {
			$this->Serial = $Serial;
			return $this;
		}

		public function getSerial() {
			return $this->Serial;
		}

		public function setObservaciones($Observaciones) {
			$this->Observaciones = $Observaciones;
			return $this;
		}

		public function getObservaciones() {
			return $this->Observaciones;
		}

		public function setStatusID($status_idStatus) {
			$this->status_idStatus = $status_idStatus;
			return $this;
		}

		public function getStatusID() {
			return $this->status_idStatus;
		}

		public function setTipoID($tipo_idTipo) {
			$this->tipo_idTipo= $tipo_idTipo;
			return $this;
		}

		public function getTipoID() {
			return $this->tipo_idTipo;
		}

		public function setSedeID($sede_idSede) {
			$this->sede_idSede= $sede_idSede;
			return $this;
		}

		public function getSedeID() {
			return $this->sede_idSede;
		}

		public function setModeloID($modelo_idModelo) {
			$this->modelo_idModelo= $modelo_idModelo;
			return $this;
		}

		public function getModeloID() {
			return $this->modelo_idModelo;
		}

		public function setAdministrativoID($administrativo_idAdministrativo) {
			$this->administrativo_idAdministrativo= $administrativo_idAdministrativo;
			return $this;
		}

		public function getAdministrativoID() {
			return $this->administrativo_idAdministrativo;
		}

		public function consultarEquipos() {
			try {
				$statement= $this->db->prepare("SELECT * FROM equipo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function seleccionarEquipo() {
			try {
				$statement= $this->db->prepare("SELECT * FROM equipo WHERE idEquipo= :idEquipo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':idEquipo', $this->idEquipo);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirEquipo() {
			try {
				$statement= $this->db->prepare("INSERT INTO equipo (Bien_Nacional, Chapa_Vieja, Serial, Observaciones, status_idStatus, tipo_idTipo, 
													sede_idSede, modelo_idModelo, administrativo_idAdministrativo) VALUES (:Bien_Nacional,
													:Chapa_Vieja, :Serial, :Observaciones, :status_idStatus, :tipo_idTipo, :sede_idSede, 
													:modelo_idModelo, :administrativo_idAdministrativo)");
				//se asignan los valores
				$statement->bindParam(':Bien_Nacional', $this->Bien_Nacional);
				$statement->bindParam(':Chapa_Vieja', $this->Chapa_Vieja);
				$statement->bindParam(':Serial', $this->Serial);
				$statement->bindParam(':Observaciones', $this->Observaciones);
				$statement->bindParam(':status_idStatus', $this->status_idStatus);
				$statement->bindParam(':tipo_idTipo', $this->tipo_idTipo);
				$statement->bindParam(':sede_idSede', $this->sede_idSede);
				$statement->bindParam(':modelo_idModelo', $this->modelo_idModelo);
				$statement->bindParam(':administrativo_idAdministrativo', $this->administrativo_idAdministrativo);

				$success= $statement->execute();
				return $success;

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		//en esta funcion quiero desplejar un formulario que muestre todos los datos llenos y solo deje alterar los que aparezcan aca para no darme mala vida modificando uno a uno
		public function actualizarEquipo() {
			try {
				$statement= $this->db->prepare("UPDATE equipo SET Bien_Nacional= :Bien_Nacional, Chapa_Vieja= :Chapa_Vieja,
											Observaciones= :Observaciones, sede_idSede= :sede_idSede, 
											administrativo_idAdministrativo= :administrativo_idAdministrativo WHERE idEquipo= :idEquipo");

				//se asignan los valores
				$statement->bindParam(':Bien_Nacional', $this->Bien_Nacional);
				$statement->bindParam(':Chapa_Vieja', $this->Chapa_Vieja);
				$statement->bindParam(':Observaciones', $this->Observaciones);
				$statement->bindParam(':sede_idSede', $this->sede_idSede);
				$statement->bindParam(':administrativo_idAdministrativo', $this->administrativo_idAdministrativo);
				$statement->bindParam(':idEquipo', $this->idEquipo);

				$statement->execute();
				return $statement->rowCount();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function borrarEquipo() {
			try {
				$statement= $this->db->prepare("DELETE FROM equipo WHERE idEquipo= :idEquipo");

				$statement->bindParam(':idEquipo', $this->idEquipo);

				$statement->execute();
				return $statement->rowCount();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function consultarID() {
			try {
				$statement= $this->db->prepare("SELECT idEquipo FROM equipo WHERE Serial= :Serial");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':Serial', $this->Serial);

				$statement->execute();
				return $statement->fetchAll();

			} catch (Exception $error) {
				// Mostramos un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function actualizarStatusEquipo() {
			try {
				$statement= $this->db->prepare("UPDATE equipo SET Observaciones= :Observaciones, status_idStatus= :status_idStatus WHERE idEquipo= :idEquipo");

				//se asignan los valores
				$statement->bindParam(':Observaciones', $this->Observaciones);
				$statement->bindParam(':status_idStatus', $this->status_idStatus);
				$statement->bindParam(':idEquipo', $this->idEquipo);

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