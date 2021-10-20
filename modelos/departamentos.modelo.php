<?php

require_once "conexion.db.php";

class ModeloDepartamentos {

	/*=============================================
	MOSTRAR DEPARTAMENTOS
	=============================================*/
	
	static public function mdlMostrarDepartamentos($tabla, $item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		} else {

			// devuelve todos los datos de la tabla

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}

	static public function getIdDepartamentoDadoUnCampo($item, $valor){
		
		$tabla =  'departamentos';
		$nombreDepto = trim($valor);
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE CONCAT ('%','$nombreDepto', '%')");		
		$stmt->execute();
		return $stmt->fetchAll();
	}


}