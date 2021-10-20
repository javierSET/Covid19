<?php

require_once "conexion.db.php";

class ModeloFormularioBajas {

	/*=============================================
	MOSTRAR LOS DATOS DE FORMULARIO DE BAJA QUE CUENTE UN AFILIADO
	=============================================*/
	
	static public function mdlMostrarFormularioBajas($tabla, $item, $valor) {

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

	/*=============================================
		MOSTRAR TODOS LOS FORMUALRIOS ASIGNADOS A UN PACIENTE
	=============================================*/
	
	static public function mdlMostrarFormularioBajasTotales($tabla, $item, $valor) {			

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
		if($stmt->execute())
			$respuesta = $stmt->fetchAll();
		else
			$respuesta = $stmt->errorInfo();
		
		return $respuesta;
	}


	/*=============================================
	OBTIENE TODOS LOS DATOS DE LA TABLA ENVIADA M@rk
	=============================================*/
	
	static public function getFormularioBajasConSinCovidResultados($tabla, $contrarRegistros = false) {
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE 1 = 1");
		$stmt->execute();
		if($contrarRegistros){
			return $stmt->rowCount();
		}
		else{
			return $stmt->fetchAll();
		}
	}

	/*====================================================================
	OBTIENE TODAS LAS BAJAS FILTRADOS SEGUN EL SQL DE LA TABLA ENVIADA M@rk
	====================================================================*/

	static public function getFormularioBajasFiltrado($tabla, $sql, $contrarRegistros = false){

		if($sql != "") {
			$sql2 = "SELECT * FROM $tabla WHERE 1 = 1 $sql";
			$stmt = Conexion::conectar()->prepare($sql2);
			$stmt->execute();
			
			if($contrarRegistros){
				return $stmt->rowCount();;
			}
			else{
				return $stmt->fetchAll();
			}
		} else {
			$sql2 = "SELECT * FROM $tabla WHERE 1 = 1";
			$stmt = Conexion::conectar()->prepare($sql2);
			$stmt->execute();
			if($contrarRegistros){
				return $stmt->rowCount();;
			}
			else{
				return $stmt->fetchAll();
			}
		}
	}



	/*=============================================
	REGISTRO DE NUEVO FORMULARIO DE BAJA A UN AFILIADO QUE TIENE RESULTADO DE LABORATORIO COVID
	=============================================*/

	static public function mdlIngresarFormularioBaja($tabla, $datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla(id_covid_resultado, riesgo, fecha_ini, fecha_fin, dias_incapacidad, lugar, fecha, clave, codigo, establecimiento, observacion_baja) VALUES (:id_covid_resultado, :riesgo, :fecha_ini, :fecha_fin, :dias_incapacidad, :lugar, :fecha, :clave, :codigo, :establecimiento, :observacion_baja)");

		$stmt->bindParam(":id_covid_resultado", $datos["id_covid_resultado"], PDO::PARAM_INT);
		$stmt->bindParam(":riesgo", $datos["riesgo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ini", $datos["fecha_ini"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":dias_incapacidad", $datos["dias_incapacidad"], PDO::PARAM_STR);
		$stmt->bindParam(":lugar", $datos["lugar"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		
		$stmt->bindParam(":establecimiento", $datos["establecimiento"], PDO::PARAM_INT);

		$stmt->bindParam(":observacion_baja", $datos["observacion_baja"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";

		} else {
			
			return $stmt->errorInfo();

		}
		
		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	REGISTRO DE NUEVO FORMULARIO DE BAJA SOSPECHOSO
	=============================================*/

	static public function mdlIngresarFormularioBajasSospechoso($tabla, $datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla(id_covid_resultado, riesgo, fecha_ini, fecha_fin, dias_incapacidad, lugar, fecha, clave, codigo, establecimiento, observacion_baja) VALUES (:id_covid_resultado, :riesgo, :fecha_ini, :fecha_fin, :dias_incapacidad, :lugar, :fecha, :clave, :codigo, :establecimiento, :observacion_baja)");

		$stmt->bindParam(":id_covid_resultado", $datos["id_covid_resultado"], PDO::PARAM_INT);
		$stmt->bindParam(":riesgo", $datos["riesgo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ini", $datos["fecha_ini"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":dias_incapacidad", $datos["dias_incapacidad"], PDO::PARAM_STR);
		$stmt->bindParam(":lugar", $datos["lugar"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":establecimiento", $datos["establecimiento"], PDO::PARAM_INT);
		$stmt->bindParam(":observacion_baja", $datos["observacion_baja"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return $pdo->lastInsertId();

		} else {
			
			return -1;

		}
		
		$stmt->close();
		$stmt = null;

	}
	

	/*=============================================
	REGISTRO DE NUEVO FORMULARIO DE BAJA A UN AFILIADO QUE TIENE RESULTADO DE LABORATORIO COVID
	=============================================*/

	static public function mdlIngresarFormularioBajaExterno($tabla, $datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla(id_covid_resultado, riesgo, fecha_ini, fecha_fin, dias_incapacidad, lugar, fecha, clave, codigo, establecimiento, observacion_baja) VALUES (:id_covid_resultado, :riesgo, :fecha_ini, :fecha_fin, :dias_incapacidad, :lugar, :fecha, :clave, :codigo, :establecimiento, :observacion_baja)");

		$stmt->bindParam(":id_covid_resultado", $datos["id_covid_resultado"], PDO::PARAM_INT);
		$stmt->bindParam(":riesgo", $datos["riesgo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ini", $datos["fecha_ini"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":dias_incapacidad", $datos["dias_incapacidad"], PDO::PARAM_STR);
		$stmt->bindParam(":lugar", $datos["lugar"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":establecimiento", $datos["establFormNuevaBaja"], PDO::PARAM_INT);
		$stmt->bindParam(":observacion_baja", $datos["observacion_baja"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			$respuesta = $pdo->lastInsertId();

		} else {
			
			$respuesta = $stmt->errorInfo();

		}
		return $respuesta;
	}

	/*=============================================
	EDITAR DATOS DE FORMULARIO BAJA
	=============================================*/

	static public function mdlEditarFormularioBaja($tabla, $datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("UPDATE $tabla SET id_covid_resultado = :id_covid_resultado, riesgo = :riesgo, fecha_ini = :fecha_ini, fecha_fin = :fecha_fin, dias_incapacidad = :dias_incapacidad, lugar = :lugar, fecha = :fecha, clave = :clave, establecimiento = :establecimiento, imagen = :imagen, observacion_baja=:observacion_baja WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_covid_resultado", $datos["id_covid_resultado"], PDO::PARAM_INT);
		$stmt->bindParam(":riesgo", $datos["riesgo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_ini", $datos["fecha_ini"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":dias_incapacidad", $datos["dias_incapacidad"], PDO::PARAM_STR);
		$stmt->bindParam(":lugar", $datos["lugar"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":clave", $datos["clave"], PDO::PARAM_STR);
		$stmt->bindParam(":establecimiento", $datos["establFormNuevaBaja"], PDO::PARAM_INT);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion_baja", $datos["observacion_baja"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

	/*=============================================
		BUSQUEDA DE PACIENTES POR ID FORMULARIO DE 
	=============================================*/

	static public function mdlObtenerIdFichaPaciente($tabla,$datos){

	}

	/*=============================================
	BORRAR REGISTRO DE FORMULARIO BAJA
	=============================================*/

	static public function mdlEliminarFormularioBaja($tabla, $datos) {

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			
			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;
		
	}

	/*=============================================
	MOSTRAR LOS DATOS DE FORMULARIO DE ALTA MANUAL
	=============================================*/
	
	static public function mdlMostrarFormularioBajasExterno($tabla, $item, $valor) {

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

		/*=============================================
	REGISTRO DE NUEVO FORMULARIO DE CERTIFICADO DE ALTA MANUAL
	=============================================*/

	static public function mdlIngresarFormularioAltaManual($datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO certificado_alta_manual (
										id_pacientes_asegurados, id_personas_notificadores, prueba_diagnostica,
										resultado, fecha_resultado, establecimiento_resultado, dias_baja, fecha_ini, fecha_fin,
										establecimiento_notificador
										)
							   VALUES (:id_pacientes_asegurados, :id_personas_notificadores, :prueba_diagnostica, 
							           :resultado, :fecha_resultado, :establecimiento_resultado, :dias_baja, :fecha_ini, :fecha_fin,
									   :establecimiento_notificador
									   )"
							);

		$stmt->bindParam(":id_pacientes_asegurados", $datos["id_pacientes_asegurados"], PDO::PARAM_INT);
		$stmt->bindParam(":id_personas_notificadores", $datos["id_personas_notificadores"], PDO::PARAM_INT);
		$stmt->bindParam(":prueba_diagnostica", $datos["prueba_diagnostica"], PDO::PARAM_STR);
		$stmt->bindParam(":resultado", $datos["resultado"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_resultado", $datos["fecha_resultado"], PDO::PARAM_STR);
		$stmt->bindParam(":establecimiento_resultado", $datos["establecimiento_resultado"], PDO::PARAM_STR);
		$stmt->bindParam(":dias_baja", $datos["dias_baja"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_ini", $datos["fecha_ini"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_fin", $datos["fecha_fin"], PDO::PARAM_STR);
		$stmt->bindParam(":establecimiento_notificador", $datos["establecimiento_notificador"], PDO::PARAM_STR);	

		if ($stmt->execute()) {

			$respuesta = $pdo->lastInsertId();

		} else {
			
			$respuesta = $stmt->errorInfo();

		}
		return $respuesta;
	}

	/*=============================================
		SUMAR TODAS LAS BAJAS
	=============================================*/
	
	static public function mdlSumarTodasBajas($tabla, $id_baja, $id_covid_resultado) {	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(SUBSTRING_INDEX(dias_incapacidad,' ',1))as total
												FROM $tabla
												WHERE id=:id OR id_covid_resultado=:id_covid_resultado");
		$stmt->bindParam(":id", $id_baja, PDO::PARAM_STR);
		$stmt->bindParam(":id_covid_resultado", $id_covid_resultado, PDO::PARAM_STR);
		if($stmt->execute())
			$respuesta = $stmt->fetch();
		else
			$respuesta = $stmt->errorInfo();
		
		return $respuesta;
	}

	/*=============================================
		SUMAR TODAS LAS BAJAS
	=============================================*/
	
	static public function mdlBuscarFechaIniFin($tabla, $id_baja, $id_covid_resultado,$ascdesc) {

		$stmt = Conexion::conectar()->prepare("SELECT *
												FROM $tabla
												WHERE id=:id OR id_covid_resultado=:id_covid_resultado
												ORDER BY id $ascdesc LIMIT 1");
		$stmt->bindParam(":id", $id_baja, PDO::PARAM_STR);
		$stmt->bindParam(":id_covid_resultado", $id_covid_resultado, PDO::PARAM_STR);
		if($stmt->execute())
			$respuesta = $stmt->fetch();
		else
			$respuesta = $stmt->errorInfo();
		
		return $respuesta;
	}
}