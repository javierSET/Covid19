<?php

require_once "conexion.db.php";

class ModeloProvincia {

	/*=============================================
	MOSTRAR PROVINCIA
	=============================================*/
	
	static public function mdlMostrarProvincia($tabla, $item, $valor) {

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

	static public function mdlMostrarProvinciaPertenescanDepartamento($valor){
		if($valor != null){			
			$stmt = Conexion::conectar()->prepare("SELECT 	p.id,
															p.nombre_provincia
													FROM 	departamentos d, provincia p
													WHERE 	d.id=p.id_departamento AND
															d.id=$valor");
			$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
		}		
		$stmt->close();			
	}

	static public function mdlMostrarProvinciaMark($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor/* :$item*/");
		
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function getIdProvinciaDadoUnItem($item, $valor){
		$tabla =  'provincia';
		$nombreProvincia = trim($valor);
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE CONCAT ('%','$nombreProvincia', '%')");		
		$stmt->execute();
		return $stmt->fetchAll();
	}
}