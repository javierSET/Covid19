<?php

require_once "conexion.db.php";

class ModeloReportesCovid {

	/*=============================================
	MOSTRAR LOS DATOS DE AFILIADOS CON LABORATORIO COVID-19
	=============================================*/
	
	static public function mdlMostrarReportesCovidFechas($tabla, $valor1, $valor2, $valor3) {

		if ($valor3 == "TODO") {

			// devuelve los campos que coincidan con el rango de fechas

			$sql = "SELECT cr.id, cr.cod_laboratorio, cr.cod_asegurado, concat_ws(' ', cr.paterno, cr.materno, cr.nombre) as nombre_completo, cr.documento_ci, cr.fecha_muestra, cr.fecha_recepcion, cr.muestra_control, d.nombre_depto, e.abreviatura_establecimiento, cr.sexo, cr.telefono, YEAR(CURDATE())-YEAR(cr.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(cr.fecha_nacimiento,'%m-%d'), 0 , -1 ) AS edad, cr.fecha_resultado, cr.resultado, cr.cod_empleador, cr.nombre_empleador, cr.observaciones FROM covid_resultados cr, departamentos d, establecimientos e WHERE cr.id_departamento = d.id AND cr.id_establecimiento = e.id AND cr.estado = 1 AND cr.fecha_resultado BETWEEN :fechaInicio AND :fechaFin ORDER BY cod_laboratorio";

			$stmt = Conexion::conectar()->prepare($sql);

			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetchAll();

		} else {

			// devuelve todos los datos campos que coincidan con el rango de fechas y resultado de laboratorio

			$sql = "SELECT cr.id, cr.cod_laboratorio, cr.cod_asegurado, concat_ws(' ', cr.paterno, cr.materno, cr.nombre) as nombre_completo, cr.documento_ci, cr.fecha_muestra, cr.fecha_recepcion, cr.muestra_control, d.nombre_depto, e.abreviatura_establecimiento, cr.sexo, cr.telefono, YEAR(CURDATE())-YEAR(cr.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(cr.fecha_nacimiento,'%m-%d'), 0 , -1 ) AS edad, cr.fecha_resultado, cr.resultado, cr.cod_empleador, cr.nombre_empleador, cr.observaciones FROM covid_resultados cr, departamentos d, establecimientos e WHERE cr.id_departamento = d.id AND cr.id_establecimiento = e.id AND cr.resultado = :resultado AND cr.estado = 1 AND cr.fecha_resultado BETWEEN :fechaInicio AND :fechaFin ORDER BY cod_laboratorio";

			$stmt = Conexion::conectar()->prepare($sql);

			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
			$stmt->bindParam(":resultado", $valor3, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR LOS DATOS EN REPORTE DE AFILIADOS CON LABORATORIO COVID-19
	=============================================*/

	static public function mdlMostrarReportesCovidPersonal($tabla, $item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetch();

		} else {

			// devuelve todos los datos de la tabla

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}

}