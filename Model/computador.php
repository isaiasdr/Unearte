<?php
	include_once("ManejadorBD.php");

	class computador extends ManejadorBD {
		
		private $idComputador;
		private $Nombre_Equipo;
		private $MAC;
		private $IP;
		private $Red;
		private $Voz;
		private $grupo_idGrupo;
		private $sistema_operativo_idSistema_operativo;
		private $administrativo_idAdministrativo;

		private $db;

		public function __construct($conexion) {
			$this->db = parent::conectar($conexion); //ejecuta el metodo conectar de la clase padre
		}

		public function __destruct() {
			parent::cerrarConexion(); //ejecuta el metodo cerrar conexion para eliminar la conexion con la BD
		}

		//Getters y Setters

		public function setID($idComputador) {
			$this->idComputador= $idComputador;
			return $this;
		}

		public function getID() {
			return $this->idComputador;
		}

		public function setNombre_Equipo($Nombre_Equipo) {
			$this->Nombre_Equipo= $Nombre_Equipo;
			return $this;
		}

		public function getNombre_Equipo() {
			return $this->Nombre_Equipo;
		}

		public function setMAC($MAC) {
			$this->MAC = $MAC;
			return $this;
		}

		public function getMAC() {
			return $this->MAC;
		}

		public function setIP($IP) {
			$this->IP = $IP;
			return $this;
		}

		public function getIP() {
			return $this->IP;
		}

		public function setRed($Red) {
			$this->Red = $Red;
			return $this;
		}

		public function setVoz($Voz) {
			$this->Voz = $Voz;
			return $this;
		}

		public function getVoz() {
			return $this->Voz;
		}

		public function getRed() {
			return $this->Red;
		}

		public function setGrupoID($grupo_idGrupo) {
			$this->grupo_idGrupo= $grupo_idGrupo;
			return $this;
		}

		public function getGrupoID() {
			return $this->grupo_idGrupo;
		}

		public function setSOID($sistema_operativo_idSistema_operativo) {
			$this->sistema_operativo_idSistema_operativo = $sistema_operativo_idSistema_operativo;
			return $this;
		}

		public function getSOID() {
			return $this->sistema_operativo_idSistema_operativo;
		}

		public function setAdministrativoID($administrativo_idAdministrativo) {
			$this->administrativo_idAdministrativo = $administrativo_idAdministrativo;
			return $this;
		}

		public function getAdministrativoID() {
			return $this->administrativo_idAdministrativo;
		}

		public function consultarComputador() {
			try {
				$statement= $this->db->prepare("SELECT * FROM computador WHERE administrativo_idAdministrativo= :administrativo_idAdministrativo");
				$statement->setFetchMode(PDO::FETCH_ASSOC);

				$statement->bindParam(':administrativo_idAdministrativo', $this->administrativo_idAdministrativo);

				$statement->execute();
				return $statement->fetchAll();
				
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function añadirComputador() {
			try {
				$statement= $this->db->prepare("INSERT INTO computador (Nombre_Equipo, MAC, IP, Red, Voz, grupo_idGrupo, 
												sistema_operativo_idSistema_operativo, administrativo_idAdministrativo) 
												VALUES (:Nombre_Equipo, :MAC, :IP, :Red, :Voz, :grupo_idGrupo, :sistema_operativo_idSistema_operativo,
												:administrativo_idAdministrativo)");

				//se asignan los valores
				$statement->bindParam(':Nombre_Equipo', $this->Nombre_Equipo);
				$statement->bindParam(':MAC', $this->MAC);
				$statement->bindParam(':IP', $this->IP);
				$statement->bindParam(':Red', $this->Red);
				$statement->bindParam(':Voz', $this->Voz);
				$statement->bindParam(':grupo_idGrupo', $this->grupo_idGrupo);
				$statement->bindParam(':sistema_operativo_idSistema_operativo', $this->sistema_operativo_idSistema_operativo);
				$statement->bindParam(':administrativo_idAdministrativo', $this->administrativo_idAdministrativo);

				$success= $statement->execute();
				return $success;

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function actualizarComputador() {
			try {
				$statement= $this->db->prepare("UPDATE computador SET Nombre_Equipo= :Nombre_Equipo, IP= :IP, Red= :Red, Voz= :Voz, 
												grupo_idGrupo= :grupo_idGrupo, sistema_operativo_idSistema_operativo= :sistema_operativo_idSistema_operativo WHERE
												administrativo_idAdministrativo= :administrativo_idAdministrativo");

				//se asignan los valores
				$statement->bindParam(':Nombre_Equipo', $this->Nombre_Equipo);
				$statement->bindParam(':IP', $this->IP);
				$statement->bindParam(':Red', $this->Red);
				$statement->bindParam(':Voz', $this->Voz);
				$statement->bindParam(':grupo_idGrupo', $this->grupo_idGrupo);
				$statement->bindParam(':sistema_operativo_idSistema_operativo', $this->sistema_operativo_idSistema_operativo);
				$statement->bindParam(':administrativo_idAdministrativo', $this->administrativo_idAdministrativo);

				$statement->execute();
				return $statement->rowCount();
			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}

		public function borrarComputador() {
			try {
				$statement= $this->db->prepare("DELETE FROM computador WHERE administrativo_idAdministrativo= :administrativo_idAdministrativo");

				$statement->bindParam(':administrativo_idAdministrativo', $this->administrativo_idAdministrativo);

				$statement->execute();
				return $statement->rowCount();

			} catch (Exception $error) {
				// Se muestra un mensaje genérico de error.
				echo "Error: ejecutando consulta SQL.".$error->getMessage();
				exit();
			}
		}
	}
?>