<?php

require_once "conexion.db.php";

class ModeloFormularioAltasManual {

	/*=============================================
	MOSTRAR LOS DATOS DE FORMULARIO DE ALTA QUE CUENTE UN AFILIADO
	=============================================*/
	
	static public function mdlMostrarFormularioAltasManual($tabla, $item, $valor) {

		if ($item != null) {
			// devuelve los campos que coincidan con el valor del item
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();
			$respuesta = $stmt->fetch();

		} else {
			// devuelve todos los datos de la tabla
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");
			$stmt->execute();
			$respuesta = $stmt->fetchAll();
		}
		return $respuesta;

	}

	/*=============================================
		EDITAR EL CAMPO ESTABLECIMIENTO NOTIFICADOR 
	=============================================*/
	
	static public function mdlEditarFormularioAltasManualEstablecimiento($tabla, $item, $datos) {
			$pdo = Conexion::conectar();
			$stmt = $pdo->prepare("UPDATE $tabla SET establecimiento_resultado = :establecimiento_resultado,
								establecimiento_notificador = :establecimiento_notificador,
								prueba_diagnostica = :prueba_diagnostica 
							   WHERE $item = :$item");
			$stmt->bindParam(":establecimiento_resultado",$datos['establecimiento_resultado'],PDO::PARAM_STR);
			$stmt->bindParam(":establecimiento_notificador",$datos['establecimiento_notificador'],PDO::PARAM_INT);
			$stmt->bindParam(":prueba_diagnostica",$datos['prueba_diagnostica'],PDO::PARAM_STR);
			$stmt->bindParam(":".$item,$datos['id'],PDO::PARAM_INT);
			
			if($stmt->execute())
				$respuesta = "ok";
			else 
				$respuesta = $stmt->errorInfo();
			
		return $respuesta;

	}

	/*=============================================
	ELIMINAR FORMULARIO DE ALTA QUE CUENTE UN AFILIADO
	=============================================*/
	
	static public function mdlEliminarFormularioAltasManual($tabla, $item, $valor) {		
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
		if($stmt->execute()){
			$respuesta = $stmt->fetch();
		}else{
			$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

	
}