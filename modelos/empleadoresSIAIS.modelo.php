<?php

require_once "conexion.db.php";

class ModeloEmpleadoresSIAIS {

	/*=============================================
	MOSTRAR EMPLEADORES DE LA BASE DE DATOS SIAIS
	=============================================*/
	
	static public function mdlMostrarEmpleadoresSIAIS($item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectarSQLServer()->query("SELECT * FROM hcl_empleador WHERE $item = '$valor'");

			// $stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);

			//$stmt->execute();
			//return $stmt->fetch();

			return $stmt->fetch(PDO::FETCH_ASSOC);

		} else {

			// devuelve todos los datos de la tabla

			$stmt = Conexion::conectarSQLServer()->query("SELECT e.idempleador, e.emp_nombre, e.emp_nro_empleador, e.emp_nro_padron, e.emp_telefono, e.emp_fecha_iniciacion, a.act_nombre FROM hcl_empleador e, hcl_actividad_economica a WHERE e.idactividad=a.idactividad");

			//$stmt->execute();
			//return $stmt->fetchAll();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		$stmt->close();
		$stmt = null;

	}

}