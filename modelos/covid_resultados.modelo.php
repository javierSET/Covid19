<?php

require_once "conexion.db.php";

class ModeloCovidResultados {

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO)
	=============================================*/
	
	static public function mdlContarCovidResultadosLab($tabla) {

		// devuelve el numero de registros de la vista mostrar_covid_resultados

		$sql = "SELECT * FROM $tabla";

		$stmt = Conexion::conectar()->prepare($sql);

		$stmt->execute();

		$cuenta_col = $stmt->rowCount();

		return $cuenta_col;

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (LABORATORIO)
	=============================================*/
	
	static public function mdlContarFiltradoCovidResultadosLab($tabla, $sql) {


		if($sql != "") {

			// devuelve el numero de registros de la vista_covid_resultados

			$sql2 = "SELECT * FROM $tabla WHERE 1 = 1";

			$stmt = Conexion::conectar()->prepare($sql2);

			$stmt->execute();

			$cuenta_col = $stmt->rowCount();

			return $cuenta_col;

		} else {

			// devuelve el numero de registros de la vista_covid_resultados

			$sql2 = "SELECT * FROM $tabla WHERE 1 = 1 $sql";

			$stmt = Conexion::conectar()->prepare($sql2);

			$stmt->execute();

			$cuenta_col = $stmt->rowCount();

			return $cuenta_col;

		}

		$stmt->close();
		$stmt = null;
	}

	/*================================================
	CONTADOR DE COLUMNAS DEVUELVE INT danpinch
	==================================================*/
	static public function mdlContarFiltradoCovidResultadosLaboratorio($tabla,$sql){
		$pdo = Conexion::conectar();
		if($sql != ""){
			$sql1 = "SELECT * FROM $tabla WHERE 1=1 $sql";			
		}
		else{			
			$sql1 = "SELECT * FROM $tabla";		
		}
		$stmt = $pdo->prepare($sql1);
		$stmt->execute();
		$respuesta = $stmt->rowCount();

		return $respuesta;
	}

	/*=============================================
	MOSTAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO)
	=============================================*/
	
	static public function mdlMostrarCovidResultadosLab($tabla, $sql) {

		// devuelve el numero de registros de la vista mostrar_covid_resultados

		$sql = "SELECT * FROM $tabla WHERE 1 = 1 $sql";

		$stmt = Conexion::conectar()->prepare($sql);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO) danpinch
	=============================================*/
	
	static public function mdlMostrarCovidResultadosLaboratorio($tabla, $sql) {

		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM $tabla WHERE 1 = 1 $sql";
		$stmt = $pdo->prepare($sql);
		if($stmt->execute())
			$respuesta = $stmt->fetchAll();
		else
			$respuesta = $stmt->errorInfo();

		return $respuesta;


	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (CENTRO COVID)
	=============================================*/
	
	static public function mdlContarCovidResultadosCentro($tabla) {

		// devuelve el numero de registros de la vista mostrar_covid_resultados

		$sql2 = "SELECT * FROM $tabla WHERE estado = 1";

		$stmt = Conexion::conectar()->prepare($sql2);

		$stmt->execute();

		$cuenta_col = $stmt->rowCount();

		return $cuenta_col;

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR LOS AFILIADOS QUE TIENEN RESULTADOS DE PRUEBAS DE LABORATORIO COVID-19 (CENTRO COVID)
	=============================================*/
	
	static public function mdlContarFiltradoCovidResultadosCentro($tabla, $sql) {

		// devuelve el numero de registros de la vista mostrar_covid_resultados

		if($sql != "") {

			$sql2 = "SELECT * FROM $tabla WHERE 1 = 1 AND estado = 1";

			$stmt = Conexion::conectar()->prepare($sql2);

			$stmt->execute();

			$cuenta_col = $stmt->rowCount();

			return $cuenta_col;

		} else {

			// devuelve el numero de registros de la vista mostrar_covid_resultados

			$sql2 = "SELECT * FROM $tabla WHERE 1 = 1 AND estado = 1 $sql";

			$stmt = Conexion::conectar()->prepare($sql2);

			$stmt->execute();

			$cuenta_col = $stmt->rowCount();

			return $cuenta_col;

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (CENTRO COVID)
	=============================================*/
	
	static public function mdlMostrarCovidResultadosCentro($tabla, $sql) {

		// devuelve el numero de registros de la vista mostrar_covid_resultados

		$sql = "SELECT * FROM $tabla WHERE 1 = 1 AND estado = 1 $sql";

		$stmt = Conexion::conectar()->prepare($sql);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR LOS DATOS DE AFILIADOS CON LABORATORIO COVID-19
	=============================================*/
	
	static public function mdlMostrarCovidResultados($tabla, $item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetch();

		} else {
			//devuelve todos los datos de la tabla
			$sql = "SELECT cr.id, 
					cr.cod_laboratorio, 
					cr.cod_asegurado,
					cr.metodo_diagnostico_pcr_tiempo_real AS tiempoReal,
					cr.metodo_diagnostico_pcr_genexpert AS genExpert,
					cr.metodo_diagnostico_prueba_antigenica AS pruebaAntigenica,
					cr.cod_afiliado, 
					concat_ws(' ', cr.paterno, cr.materno, cr.nombre) AS nombre_completo, 
					cr.documento_ci, 
					cr.fecha_muestra, 
					cr.tipo_muestra, 
					cr.fecha_recepcion, 
					cr.muestra_control, 
					cr.fecha_resultado, 
					cr.resultado, 
					cr.estado,
					cr.id_ficha
			        FROM $tabla cr";

			$stmt = Conexion::conectar()->prepare($sql);
			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	MOSTRAR LOS RESULTADOS COVID DE ACUERDO A LA FECHA DE RESULTADO
	=============================================*/
	
	static public function mdlMostrarCovidResultadosFecha($tabla, $item, $valor) {

		if ($item != null) {

			// devuelve los campos que coincidan con el valor del item

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY cod_laboratorio");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetchAll();

		} else {

			// devuelve todos los datos de la tabla

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY cod_laboratorio ASC LIMIT 5000");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	REGISTRO DE NUEVO AFILIADOS CON LABORATORIO COVID RESULTADO
	=============================================*/

	static public function mdlIngresarCovidResultado($tabla, $datos) {

		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("INSERT INTO $tabla(cod_asegurado, cod_afiliado, cod_empleador, nombre_empleador, fecha_recepcion, fecha_muestra, cod_laboratorio, nombre_laboratorio, muestra_control, tipo_muestra, id_departamento, id_establecimiento, documento_ci, foto, paterno, materno, nombre, sexo, fecha_nacimiento, telefono, email, id_localidad, zona, calle, nro_calle, resultado, fecha_resultado, observaciones, id_usuario) VALUES (:cod_asegurado, :cod_afiliado, :cod_empleador, :nombre_empleador, :fecha_recepcion, :fecha_muestra, :cod_laboratorio, :nombre_laboratorio, :muestra_control, :tipo_muestra, :id_departamento, :id_establecimiento, :documento_ci, :foto, :paterno, :materno, :nombre, :sexo, :fecha_nacimiento, :telefono, :email, :id_localidad, :zona, :calle, :nro_calle, :resultado, :fecha_resultado, :observaciones, :id_usuario)");

		$stmt->bindParam(":cod_asegurado", $datos["cod_asegurado"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_afiliado", $datos["cod_afiliado"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_empleador", $datos["cod_empleador"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_empleador", $datos["nombre_empleador"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_recepcion", $datos["fecha_recepcion"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_muestra", $datos["fecha_muestra"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_laboratorio", $datos["cod_laboratorio"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_laboratorio", $datos["nombre_laboratorio"], PDO::PARAM_STR);
		$stmt->bindParam(":muestra_control", $datos["muestra_control"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_muestra", $datos["tipo_muestra"], PDO::PARAM_STR);
		$stmt->bindParam(":id_departamento", $datos["id_departamento"], PDO::PARAM_INT);
		$stmt->bindParam(":id_establecimiento", $datos["id_establecimiento"], PDO::PARAM_INT);
		$stmt->bindParam(":documento_ci", $datos["documento_ci"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":id_localidad", $datos["id_localidad"], PDO::PARAM_STR);
		$stmt->bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_calle", $datos["nro_calle"], PDO::PARAM_STR);
		$stmt->bindParam(":resultado", $datos["resultado"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_resultado", $datos["fecha_resultado"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR REGISTRO DE AFILIADO CON LABORATORIO COVID RESULTADO
	=============================================*/

	static public function mdlEditarCovidResultado($tabla, $datos) {

		$pdo1 = Conexion::conectar();
		$pdo2 = Conexion::conectarBDFicha();

		try {
 
		    //We start our transaction.
		    $pdo1->beginTransaction();
		    $pdo2->beginTransaction();
		 
		    //Consulta 1: Actualizando datos del listado de Covid Resultados

			$stmt = $pdo1->prepare("UPDATE $tabla SET cod_asegurado = :cod_asegurado, cod_afiliado = :cod_afiliado, cod_empleador = :cod_empleador, /* nombre_empleador = :nombre_empleador, */ fecha_recepcion = :fecha_recepcion, fecha_muestra = :fecha_muestra, cod_laboratorio = :cod_laboratorio, nombre_laboratorio = :nombre_laboratorio, muestra_control = :muestra_control, tipo_muestra = :tipo_muestra, id_departamento = :id_departamento, id_establecimiento = :id_establecimiento, documento_ci = :documento_ci, foto = :foto, paterno = :paterno, materno = :materno, nombre = :nombre, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, email = :email, id_localidad = :id_localidad, zona = :zona, calle = :calle, nro_calle = :nro_calle, resultado = :resultado, fecha_resultado = :fecha_resultado, observaciones = :observaciones, id_usuario = :id_usuario WHERE id = :id");

			$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
			$stmt->bindParam(":cod_asegurado", $datos["cod_asegurado"], PDO::PARAM_STR);
			$stmt->bindParam(":cod_afiliado", $datos["cod_afiliado"], PDO::PARAM_STR);
			$stmt->bindParam(":cod_empleador", $datos["cod_empleador"],PDO::PARAM_STR);
			/* $stmt->bindParam(":nombre_empleador", $datos["nombre_empleador"], PDO::PARAM_STR); */
			$stmt->bindParam(":fecha_recepcion", $datos["fecha_recepcion"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_muestra", $datos["fecha_muestra"], PDO::PARAM_STR);
			$stmt->bindParam(":cod_laboratorio", $datos["cod_laboratorio"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_laboratorio", $datos["nombre_laboratorio"], PDO::PARAM_STR);
			$stmt->bindParam(":muestra_control", $datos["muestra_control"], PDO::PARAM_STR);
			$stmt->bindParam(":tipo_muestra", $datos["tipo_muestra"], PDO::PARAM_STR);
			$stmt->bindParam(":id_departamento", $datos["id_departamento"], PDO::PARAM_INT);
			$stmt->bindParam(":id_establecimiento", $datos["id_establecimiento"], PDO::PARAM_INT);
			$stmt->bindParam(":documento_ci", $datos["documento_ci"], PDO::PARAM_STR);
			$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
			$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
			$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
			$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
			$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
			$stmt->bindParam(":id_localidad", $datos["id_localidad"], PDO::PARAM_STR);
			$stmt->bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
			$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
			$stmt->bindParam(":nro_calle", $datos["nro_calle"], PDO::PARAM_STR);
			$stmt->bindParam(":resultado", $datos["resultado"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_resultado", $datos["fecha_resultado"], PDO::PARAM_STR);
			$stmt->bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
			$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				//Consulta 2: Actualizando datos de la ficha Epidemiologica

				$stmt2 = $pdo2->prepare("UPDATE laboratorios SET tipo_muestra = :tipo_muestra, nombre_laboratorio = :nombre_laboratorio, cod_laboratorio = :cod_laboratorio, /*observaciones_muestra = :observaciones_muestra,*/ resultado_laboratorio = :resultado_laboratorio, fecha_resultado = :fecha_resultado WHERE id_ficha = :id_ficha");

				$stmt2->bindParam(":tipo_muestra", $datos["tipo_muestra"], PDO::PARAM_STR);
				$stmt2->bindParam(":nombre_laboratorio", $datos["nombre_laboratorio"], PDO::PARAM_STR);
				$stmt2->bindParam(":cod_laboratorio", $datos["cod_laboratorio"], PDO::PARAM_STR);
				/*$stmt2->bindParam(":observaciones_muestra", $datos["observaciones"], PDO::PARAM_STR);*/
				$stmt2->bindParam(":resultado_laboratorio", $datos["resultado"], PDO::PARAM_STR);
				$stmt2->bindParam(":fecha_resultado", $datos["fecha_resultado"], PDO::PARAM_STR);
				$stmt2->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

				if ($stmt2->execute()) {

					//We've got this far without an exception, so commit the changes.
				    $pdo1->commit();
				    $pdo2->commit();

				    return "ok";

				} else {

					$pdo1->rollBack();
					$pdo2->rollBack();

		    		return "error2";

				}

			} else {
				
				return "error";

			}

		} 
		//Our catch block will handle any exceptions that are thrown.
		catch (Exception $e){
		    //An exception has occured, which means that one of our database queries
		    //failed.
		    //Print out the error message.
		    echo $e->getMessage();
		    //Rollback the transaction.
		    $pdo1->rollBack();
		    $pdo2->rollBack();

		    return "error";

		}
		
		$stmt->close();
		$stmt = null;
		$stmt2->close();
		$stmt2 = null;

	}

	/*=======================================================================
			EDITAR NOMBRE DE EMPLEADOR Y CODIGO EMPLEADOR DE UN PACIENTE
	=========================================================================*/

	static public function mdlEditarCovidResultadoNombreEmpleador($tabla,$item,$datos){
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("UPDATE $tabla SET cod_empleador = :cod_empleador, nombre_empleador = :nombre_empleador,
									  paterno = :paterno, materno = :materno, nombre = :nombre, cod_asegurado = :cod_asegurado
							   WHERE $item = :$item");
		$stmt->bindParam(":cod_empleador",$datos['cod_empleador'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre_empleador",$datos['nombre_empleador'],PDO::PARAM_STR);

		$stmt->bindParam(":paterno",$datos['paterno'],PDO::PARAM_STR);
		$stmt->bindParam(":materno",$datos['materno'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
		$stmt->bindParam(":cod_asegurado",$datos['cod_asegurado'],PDO::PARAM_STR);  //cambie por una baja con covid resultado
		
		$stmt->bindParam(":".$item,$datos['cod_afiliado'],PDO::PARAM_INT);
		//$stmt->bindParam(":".$item,$datos['id_covid_resultado'],PDO::PARAM_INT); //verificar
		
		if($stmt->execute()){
			//$respuesta = $stmt->fetch();
			$respuesta = 'ok';
		}
		else{
			//$respuesta = $stmt -> errorInfo();
			$respuesta = 'error';
		}
		return $respuesta;
	}

	/*=======================================================================
			EDITAR NOMBRE DE EMPLEADOR Y CODIGO EMPLEADOR DE UN PACIENTE
	=========================================================================*/

	static public function mdlEditarCovidResultadoNombreEmpleadorId_Ficha($tabla,$item,$datos){
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("UPDATE $tabla SET cod_empleador = :cod_empleador,nombre_empleador = :nombre_empleador WHERE $item = :$item");
		$stmt->bindParam(":cod_empleador",$datos['cod_empleador'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre_empleador",$datos['nombre_empleador'],PDO::PARAM_STR);
		$stmt->bindParam(":".$item,$datos['cod_afiliado'],PDO::PARAM_STR);
		if($stmt->execute()){
			$respuesta = $stmt->fetch();
		}
		else{
			$respuesta = $stmt -> errorInfo();
		}
		return $respuesta;
	}

	/*=============================================
	BORRAR REGISTRO DE AFILIADO CON LABORATORIO COVID RESULTADO
	=============================================*/

	static public function mdlEliminarCovidResultado($tabla, $datos) {

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
	PUBLICAR REGISTRO DE AFILIADO CON LABORATORIO COVID RESULTADO
	=============================================*/

	static public function mdlPublicarCovidResultado($tabla, $id, $estado) {

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE id = :id");

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return "ok";

		} else {
			
			return "error";

		}
		
		$stmt->close();
		$stmt = null;
		
	}
	
	static public function getResultadoDeFichaX($id_ficha){
		$tabla =  'covid_resultados';
		$item = 'id';
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = $id_ficha");
		
		$stmt->execute();
		return $stmt->fetchAll();
	}

	static public function getCovidResultados($tabla, $item, $valor) {

		// devuelve los campos que coincidan con el valor del item

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetchAll();
	}


	static public function mdlEditarCamposCovidResultado($id, $items, $datos){
		//if($id == 613){

			$pdo = Conexion::conectar();
			$stmt = $pdo->prepare("UPDATE covid_resultados SET $items[0] = :md_pcr_tiempo_real , 
																$items[1] = :md_pcr_genexpet,
																$items[2] = :md_prueba_antigenica,
																$items[3] = :md_resultado
														WHERE id_ficha = $id");
	
			$stmt->bindParam(":md_pcr_tiempo_real", $datos[0], PDO::PARAM_STR);
			$stmt->bindParam(":md_pcr_genexpet", $datos[1], PDO::PARAM_STR);
			$stmt->bindParam(":md_prueba_antigenica", $datos[2], PDO::PARAM_STR);
			$stmt->bindParam(":md_resultado", $datos[3], PDO::PARAM_STR);
			if($stmt->execute()){
				//$respuesta = $stmt->fetch();
				return 'ok';
			}
			else{
				$respuesta = $stmt -> errorInfo();
				return $respuesta;
			}
	//	}				
	}

	/*===========================================
	 Cambia los campos pasados por agumentos @dan
	 ===========================================*/
	 static public function mdlEditarCamposCovidResultadoTipoDiagnostico($id_ficha, $datos){
			$pdo = Conexion::conectar();
			$stmt = $pdo->prepare("UPDATE covid_resultados
									SET metodo_diagnostico_pcr_tiempo_real = :pcr_tiempo_real,
									metodo_diagnostico_pcr_genexpert = :pcr_genexpert,
									metodo_diagnostico_prueba_antigenica =:prueba_antigenica									
									WHERE id_ficha = $id_ficha");
			$stmt->bindParam(":pcr_tiempo_real", $datos[0],PDO::PARAM_STR);
			$stmt->bindParam(":pcr_genexpert", $datos[1], PDO::PARAM_STR);
			$stmt->bindParam(":prueba_antigenica", $datos[2], PDO::PARAM_STR);
			if($stmt->execute()){
				$respuesta = "ok";
			}
			else{
				$respuesta = $stmt -> errorInfo();				
			}
		return $respuesta;	
	}

	/*============================================================
	 		FUNCION PARA MODIFICAR EL RESULTADO, FECHA_RESULTADO, ESTADO DE COVID RESULTADO @dan
	 =============================================================*/
	static public function mdlEditarcamposCovidResultadoFechaEstadoResponsable($id_ficha,$resultado,$responsable){
		$pdo = Conexion::conectar();
		$hoy = date("Y-m-d");
		$estado = 1;
		$stmt = $pdo->prepare("UPDATE covid_resultados
										SET resultado = :resultado,
										fecha_resultado =:fecha_resultado,
										responsable_muestra =:responsable_muestra,
										estado=:estado
										WHERE id_ficha = $id_ficha");
		$stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
		$stmt->bindParam(":fecha_resultado", $hoy, PDO::PARAM_STR);
		$stmt->bindParam(":responsable_muestra", $responsable, PDO::PARAM_STR);	
		$stmt->bindParam(":estado",$estado,PDO::PARAM_INT);
		if($stmt->execute()){
			$respuesta="ok";
		}else{
			$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

	/*===============================================================
		FUNCION PARA RESTABLECER VALORES POR DEFECTO DE COVID RESULTADO
	  ===============================================================*/
	  static public function mdlRestablecerCamposCovidResultadoDiagnosticoResultadoResponsableEstado($id_ficha){
		$pdo = Conexion::conectar();
		$fecha = "0000-00-00";
		$estado = 0;
		$aux = "";
		$stmt = $pdo->prepare("UPDATE covid_resultados
									SET metodo_diagnostico_pcr_tiempo_real = :pcr_tiempo_real,
									metodo_diagnostico_pcr_genexpert = :pcr_genexpert,
									metodo_diagnostico_prueba_antigenica =:prueba_antigenica,
									resultado = :resultado,
									fecha_resultado =:fecha_resultado,
									responsable_muestra =:responsable_muestra,
									estado=:estado
									WHERE id_ficha = $id_ficha");
		$stmt->bindParam(":pcr_tiempo_real", $aux,PDO::PARAM_STR);
		$stmt->bindParam(":pcr_genexpert", $aux, PDO::PARAM_STR);
		$stmt->bindParam(":prueba_antigenica", $aux, PDO::PARAM_STR);									
		$stmt->bindParam(":resultado",$aux,PDO::PARAM_STR);
		$stmt->bindParam(":fecha_resultado", $fecha, PDO::PARAM_STR);
		$stmt->bindParam(":responsable_muestra", $aux, PDO::PARAM_STR);	
		$stmt->bindParam(":estado",$estado,PDO::PARAM_INT);
		if($stmt->execute()){
		$respuesta="ok";
		}else{
		$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	  }

}