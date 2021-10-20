<?php

require_once "conexion.db.php";

class ModeloMunicipio {

	/*=============================================
	MOSTRAR MUNICIPIO
	=============================================*/
	
	static public function mdlMostrarMunicipio($tabla, $item, $valor) {

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

	static public function mdlMostrarMunicipioPerteneceProvincia($valor){
		if($valor != null){			
			$stmt = Conexion::conectar()->prepare("SELECT 	m.id,
															m.nombre_municipio
													FROM 	provincia p, municipio m
													WHERE 	p.id=m.id_provincia AND
															p.id=$valor");
			$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
		}		
		//$stmt->close();			
	}

	static public function mdlMostrarMunicipioMark($tabla, $item, $valor) {

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor/* :$item*/");
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function ctrMostrarMunicipioDadoUnIdMunicipio($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor/* :$item*/");
		$stmt->execute();
		return $stmt->fetchAll();
	}

}