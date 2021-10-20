<?php

require_once "conexion.db.php";

class ModeloPersonasContactos {

	/*=============================================
	MOSTRAR DATOS DE LA PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarPersonaContacto($tabla, $item, $valor) {

		if ($item != null) {
			
			$stmt = Conexion::conectarBDFicha()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR DATOS DE LA PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarPersonasContactos($tabla, $item, $valor) {

		if ($item != null) {
			
			$stmt = Conexion::conectarBDFicha()->prepare("SELECT * FROM  $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();

		} else {

			$stmt = Conexion::conectarBDFicha()->prepare("SELECT * FROM  $tabla");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	REGISTRO DE DATOS DE LA PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarPersonaContacto($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();
			
		$stmt = $pdo->prepare("INSERT INTO $tabla(paterno_contacto, materno_contacto, nombre_contacto, relacion_contacto, edad_contacto, telefono_contacto, direccion_contacto, fecha_contacto, lugar_contacto, id_ficha) VALUES (:paterno_contacto, :materno_contacto, :nombre_contacto, :relacion_contacto, :edad_contacto, :telefono_contacto, :direccion_contacto, :fecha_contacto, :lugar_contacto, :id_ficha)");

		$stmt->bindParam(":paterno_contacto", $datos["paterno_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":materno_contacto", $datos["materno_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_contacto", $datos["nombre_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":relacion_contacto", $datos["relacion_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":edad_contacto", $datos["edad_contacto"], PDO::PARAM_INT);
		$stmt->bindParam(":telefono_contacto", $datos["telefono_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion_contacto", $datos["direccion_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_contacto", $datos["fecha_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":lugar_contacto", $datos["lugar_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			$id_persona_contacto = $pdo->lastInsertId();

			return $id_persona_contacto;

		} else {
			
			return  "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR DE DATOS DE LA PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlEditarPersonaContacto($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();
			
		$stmt = $pdo->prepare("UPDATE $tabla SET paterno_contacto = :paterno_contacto, materno_contacto = :materno_contacto, nombre_contacto = :nombre_contacto, relacion_contacto = :relacion_contacto, edad_contacto = :edad_contacto, telefono_contacto = :telefono_contacto, direccion_contacto = :direccion_contacto, fecha_contacto = :fecha_contacto, lugar_contacto = :lugar_contacto WHERE id = :id ");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":paterno_contacto", $datos["paterno_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":materno_contacto", $datos["materno_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_contacto", $datos["nombre_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":relacion_contacto", $datos["relacion_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":edad_contacto", $datos["edad_contacto"], PDO::PARAM_INT);
		$stmt->bindParam(":telefono_contacto", $datos["telefono_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion_contacto", $datos["direccion_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_contacto", $datos["fecha_contacto"], PDO::PARAM_STR);
		$stmt->bindParam(":lugar_contacto", $datos["lugar_contacto"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return $datos["id"];

		} else {
			
			return  "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	BORRAR REGISTRO DE DATOS DE LA PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlEliminarPersonaContacto($tabla, $datos) {

		$stmt = Conexion::conectarBDFicha()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			
			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;
		
	}

}