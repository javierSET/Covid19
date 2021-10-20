<?php

require_once "conexion.db.php";

class ModeloMalestar {

	/*=============================================
	MOSTRAR LOS DATOS CLINICOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarMalestar($tabla, $item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectarBDFicha()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetch();

		}

		$stmt->close();
		$stmt = null;

	}

	/**
	 * funcion para buscar un malestar pasando por dato el id_ficha
	 */
	static public function mldMostrarMalesarId_ficha($item){
		if($item!=null){
			$stmt= Conexion::conectarBDFicha()->prepare("SELECT * 
															FROM malestar ma,datos_clinicos da
															WHERE 	da.id = ma.id_datos_clinicos AND
																	da.id_ficha = :$item");
			$stmt->bindParam(":".$item,$item,PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetch();
		}
	}

	/*=============================================
	REGISTRO DE DATOS CLINICOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarMalestar($id_datos_clinicos, $item, $valor, $tabla) {

		$pdo = Conexion::conectarBDFicha();
		 
	    // Consulta 1: Ingreso de datos por defecto en la tabla fichas.

		$sql = "UPDATE $tabla SET $item = :valor WHERE id_datos_clinicos = :id_datos_clinicos";

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
		$stmt->bindParam(":id_datos_clinicos", $id_datos_clinicos, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";
				
		} else {

		    return $stmt->errorInfo();

		}
		
		$stmt->close();
		$stmt = null;
	}

}