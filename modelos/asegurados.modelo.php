<?php

require_once "conexion.db.php";

class ModeloAsegurados {

	/*=============================================
	MOSTRAR ASEGURADOS
	=============================================*/
	
	static public function mdlMostrarAsegurados($tabla, $item, $valor) {

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

	/*=============================================
	REGISTRO DE NUEVO ASEGURADO
	=============================================*/

	static public function mdlIngresarAsegurado($tabla, $datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla(id_empleador, id_seguro, id_localidad, id_ocupacion, matricula, documento_ci, foto, paterno, materno, nombre, sexo, fecha_nacimiento, telefono, email, zona, calle, nro_calle, salario, fecha_ingreso) VALUES (:id_empleador, :id_seguro, :id_localidad, :id_ocupacion, :matricula, :documento_ci, :foto, :paterno, :materno, :nombre, :sexo, :fecha_nacimiento, :telefono, :email, :zona, :calle, :nro_calle, :salario, :fecha_ingreso)");

		$stmt->bindParam(":id_empleador", $datos["id_empleador"], PDO::PARAM_INT);
		$stmt->bindParam(":id_seguro", $datos["id_seguro"], PDO::PARAM_INT);
		$stmt->bindParam(":id_localidad", $datos["id_localidad"], PDO::PARAM_INT);
		$stmt->bindParam(":id_ocupacion", $datos["id_ocupacion"], PDO::PARAM_INT);
		$stmt->bindParam(":matricula", $datos["matricula"], PDO::PARAM_STR);
		$stmt->bindParam(":documento_ci", $datos["documento_ci"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_calle", $datos["nro_calle"], PDO::PARAM_STR);
		$stmt->bindParam(":salario", $datos["salario"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ingreso", $datos["fecha_ingreso"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return $pdo->lastInsertId();

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

}