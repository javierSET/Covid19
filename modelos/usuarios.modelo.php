<?php

require_once "conexion.db.php";

class ModeloUsuarios {
	
	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/
	
	static public function mdlMostrarUsuarios($tabla, $item, $valor) {

		if ($item != null) {
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM  $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM  $tabla");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	REGISTRO DE USUARIOS
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(paterno, materno, nombre, matricula, documento_ci, password, foto, cargo, perfil) VALUES (:paterno, :materno, :nombre, :matricula, :documento_ci, :password, :foto, :cargo, :perfil)");

		$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":matricula", $datos["matricula"], PDO::PARAM_STR);
		$stmt->bindParam(":documento_ci", $datos["documento_ci"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);


		if ($stmt->execute()) {
			
			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt->bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;

	}	

		/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET paterno = :paterno, materno = :materno, nombre = :nombre, documento_ci = :documento_ci, password = :password, foto = :foto, cargo = :cargo, perfil = :perfil WHERE matricula = :matricula");

		$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":documento_ci", $datos["documento_ci"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":matricula", $datos["matricula"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

}