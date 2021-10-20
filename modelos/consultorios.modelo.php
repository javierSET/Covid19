<?php

require_once "conexion.db.php";

class ModeloConsultorios {

	/*=============================================
	MOSTRAR CONSULTORIOS
	=============================================*/
	
	static public function mdlMostrarConsultorios($tabla, $item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor/* :$item*/");

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

	static public function consultoriosDadoUnEstablecimiento($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $valor/* :$item*/");

		$stmt->execute();
		return $stmt->fetchAll();
	}

}