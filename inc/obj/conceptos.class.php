<?php

	class Concepto{

		public function __construct($LOG, $CONN, $nombreConcepto, $descConcepto){
			$this->CONN = $CONN;
			$this->idConcepto = null;
			$this->nombreConcepto = $nombreConcepto;
			$this->descConcepto = $descConcepto;
		}

		public function cargarTodos(){
			if($this->CONN != null){
				$sql = $this->CONN->query("CALL redefectiva.SP_LOAD_CONCEPTOS()");
				$conceptos = array();

				while($row = mysqli_fetch_array($sql)){
					$conceptos[] = $row;
				}//while
			}//if
			return $conceptos;
		}// function cargarTodos

		public function cargarActivos(){
			if($this->CONN != null){
				$sql = $this->CONN->query("CALL redefectiva.SP_LOAD_CONCEPTOS_ACTIVOS()");
				$conceptos = array();

				while($row = mysqli_fetch_array($sql)){
					$conceptos[] = $row;
				}//while
			}//if
			return $conceptos;
		}// function cargarTodos

		public function crearConcepto($nombreConcepto, $descConcepto){
			if($this->CONN != null){
				$sql = $this->CONN->query("CALL redefectiva.SP_CREATE_CONCEPTO('$nombreConcepto', '$descConcepto');");

				$row = mysqli_fetch_assoc($sql);
				$row["msg"] = "";
				if($row["error"] != 0){
					$row["msg"] = "Ha ocurrido un error";
				}
			}
			else{
				$row["msg"] = "Ha ocurrido un error";
			}

			return $row;
		}// function crearConcepto

		public function actualizarConcepto($idConcepto, $nombreConcepto, $descConcepto){
			if($this->CONN != null){
				$sql = $this->CONN->query("CALL redefectiva.SP_UPDATE_CONCEPTO($idConcepto, '$nombreConcepto', '$descConcepto')");

				if(!$this->CONN->error()){
					$row["idConcepto"] = $idConcepto;
					$row["error"] = 0;
					$row["msg"] = "";
				}
				else{
					$row["error"] = 1;
					$row["msg"] = "Ha ocurrido un error";
				}
			}

			return $row;
		}// function actualizarConcepto

		public function getConcepto($idConcepto){
			if($this->CONN != null){
				$sql = $this->CONN->query("CALL redefectiva.SP_LOAD_CONCEPTO($idConcepto)");

				$concepto = mysqli_fetch_assoc($sql);

				return $concepto;
			}
		}// function getConcepto

		public function deleteConcepto($idConcepto){
			if($this->CONN != null){
				$sql = $this->CONN->query("CALL SP_DELETE_CONCEPTO($idConcepto, 1)");

				$res = array();
				if(!$this->CONN->error()){
					$res["idConcepto"] = $idConcepto;
					$res["error"] = 0;
					$res["msg"] = "";
				}
				else{
					$res["error"] = 1;
					$res["msg"] = "Ha ocurrido un error";
				}
			}

			return $res;
		}// function deleteConcepto
	}
?>