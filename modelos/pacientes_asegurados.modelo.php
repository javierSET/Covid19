<?php

require_once "conexion.db.php";

class ModeloPacientesAsegurados {

	/*==================================================================
	MOSTRAR LOS DATOS DE PACIENTES ASEGURADOS EN LA FICHA EPIDEMIOLOGICA
	====================================================================*/
	
	static public function mdlMostrarPacientesAsegurados($tabla, $item, $valor) {

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

	/*==================================================================
	MOSTRAR TODAS LAS BAJAS DADO UN PACIENTE X M@RK
	====================================================================*/

	static public function ctrMostrarBajas($cod_asegurado) {
		$bajas = array();

		$stmt = Conexion::conectar()->prepare("SELECT * FROM bajas_sin_cresultado WHERE cod_asegurado  = :$cod_asegurado order by id_baja desc");
		$stmt->bindParam(":".$cod_asegurado, $cod_asegurado, PDO::PARAM_STR);
		$stmt->execute(); 
		$bajasSinCR= $stmt->fetchAll(PDO::FETCH_ASSOC); //Se usa FETCH_ASSOC para no mostrar indices

		$stmt2 = Conexion::conectar()->prepare("SELECT * FROM bajas_con_cresultados WHERE cod_asegurado  = :$cod_asegurado order by id_baja desc");
		$stmt2->bindParam(":".$cod_asegurado, $cod_asegurado, PDO::PARAM_STR);
		$stmt2->execute(); 
		$bajasConCR = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($bajasSinCR as $key => $value){
			$bajas[] =  $value;
		}

		foreach($bajasConCR as $key => $value){
			$bajas[] =  $value;
		}

		return $bajas;
	}

	/*=======================================================================================
	BUSCAR EL PACIENTES EN LA TABLA PACIENTES_ASEGURADOS ANTES DE BUSCAR EN SIAIS M@rk
	=======================================================================================*/

	static public function mdlMostrarPacientesAseguradosSIAIS($tabla, $valor) {
		$newValor = trim($valor);
		if ($newValor != "" && strlen($newValor) > 2) {
	
			$stmt = Conexion::conectarBDFicha()->prepare("SELECT * FROM $tabla WHERE cod_afiliado LIKE '%$newValor%' OR nombre_completo LIKE '%$newValor%'");
			$stmt->execute(); 

			//return $stmt->fetch();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);		
		}
		else return null;

	}	

	/*=============================================
	REGISTRO DE DATOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarPacienteAsegurado($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();

		// try {
 
		//     //We start our transaction.
		//     $pdo->beginTransaction();
		 
		    //Query 1: Attempt to insert the payment record into our database.
			
			$stmt = $pdo->prepare("INSERT INTO $tabla(cod_asegurado, cod_afiliado, cod_empleador, nombre_empleador, paterno, materno, nombre, sexo, nro_documento, fecha_nacimiento, edad, id_departamento_paciente, id_provincia_paciente , id_municipio_paciente , id_pais_paciente , zona, calle, nro_calle, telefono, email, nombre_apoderado, telefono_apoderado, id_ficha) VALUES (:cod_asegurado, :cod_afiliado, :cod_empleador, :nombre_empleador, :paterno, :materno, :nombre, :sexo, :nro_documento, :fecha_nacimiento, :edad, :id_departamento_paciente, :id_provincia_paciente  , :id_municipio_paciente, :id_pais_paciente, :zona, :calle, :nro_calle, :telefono, :email, :nombre_apoderado, :telefono_apoderado, :id_ficha)");

			$stmt->bindParam(":cod_asegurado", $datos["cod_asegurado"], PDO::PARAM_STR);
			$stmt->bindParam(":cod_afiliado", $datos["cod_afiliado"], PDO::PARAM_STR);
			$stmt->bindParam(":cod_empleador", $datos["cod_empleador"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_empleador", $datos["nombre_empleador"], PDO::PARAM_STR);
			$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
			$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
			$stmt->bindParam(":nro_documento", $datos["nro_documento"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
			$stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_INT);
			$stmt->bindParam(":id_departamento_paciente", $datos["id_departamento_paciente"], PDO::PARAM_INT);
			$stmt->bindParam(":id_provincia_paciente", $datos["id_provincia_paciente"], PDO::PARAM_INT);
			$stmt->bindParam(":id_municipio_paciente", $datos["id_municipio_paciente"], PDO::PARAM_INT);
			$stmt->bindParam(":id_pais_paciente", $datos["id_pais_paciente"], PDO::PARAM_INT);
			$stmt->bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
			$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
			$stmt->bindParam(":nro_calle", $datos["nro_calle"], PDO::PARAM_STR);
			$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
			$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_apoderado", $datos["nombre_apoderado"], PDO::PARAM_STR);
			$stmt->bindParam(":telefono_apoderado", $datos["telefono_apoderado"], PDO::PARAM_STR);
			$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				return "ok";

				// $id_paciente_asegurado = $pdo->lastInsertId();
		    
			    //Query 2: Attempt to update the fichas.

			 //    $stmt = $pdo->prepare("UPDATE fichas SET id_paciente_asegurado = :id_paciente_asegurado WHERE id = :id");

			 //    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
				// $stmt->bindParam(":id_paciente_asegurado", $id_paciente_asegurado, PDO::PARAM_INT);

				// if ($stmt->execute()) {


				// 	//We've got this far without an exception, so commit the changes.
				//     $pdo->commit();

				//     return "ok";

				// } else {

				// 	$pdo->rollBack();

		  //   		return "error2";

				// }

			} else {
				
				return $stmt->errorInfo();

			}
		    
		// } 
		// //Our catch block will handle any exceptions that are thrown.
		// catch (Exception $e){
		//     //An exception has occured, which means that one of our database queries
		//     //failed.
		//     //Print out the error message.
		//     echo $e->getMessage();
		//     //Rollback the transaction.
		//     $pdo->rollBack();

		//     return "error";

		// }
		
		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	REGISTRO DE DATOS DEL PACIENTE ASEGURADO PARA REALIZAR FORMULARIOS DE BAJAS DE LABORATORIOS PARTICULARES
	=============================================*/

	static public function mdlIngresarPacienteAseguradoExterno($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();			
		$stmt = $pdo->prepare("INSERT INTO $tabla(cod_asegurado, cod_afiliado, cod_empleador, nombre_empleador, paterno, materno, nombre, sexo, nro_documento, fecha_nacimiento, edad, id_departamento_paciente, id_provincia_paciente , id_municipio_paciente , id_pais_paciente , zona, calle, nro_calle, telefono, email, nombre_apoderado, telefono_apoderado, id_ficha) VALUES (:cod_asegurado, :cod_afiliado, :cod_empleador, :nombre_empleador, :paterno, :materno, :nombre, :sexo, :nro_documento, :fecha_nacimiento, :edad, :id_departamento_paciente, :id_provincia_paciente  , :id_municipio_paciente, :id_pais_paciente, :zona, :calle, :nro_calle, :telefono, :email, :nombre_apoderado, :telefono_apoderado, :id_ficha)");
		$stmt->bindParam(":cod_asegurado", $datos["cod_asegurado"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_afiliado", $datos["cod_afiliado"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_empleador", $datos["cod_empleador"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_empleador", $datos["nombre_empleador"], PDO::PARAM_STR);
		$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_documento", $datos["nro_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_INT);
		$stmt->bindParam(":id_departamento_paciente", $datos["id_departamento_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_provincia_paciente", $datos["id_provincia_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_municipio_paciente", $datos["id_municipio_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_pais_paciente", $datos["id_pais_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_calle", $datos["nro_calle"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_apoderado", $datos["nombre_apoderado"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono_apoderado", $datos["telefono_apoderado"], PDO::PARAM_STR);
		$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			$respuesta = $pdo->lastInsertId();
		} else {
			
			$respuesta = $stmt->errorInfo();

		}
		return $respuesta;
	}

	/*====================================================================
				ELIMINAR PACIENTE ASEGURADO
	======================================================================*/

	static public function mdlEliminarPacienteAsegurado($tabla,$item ,$valor){
		$pdo = Conexion::conectarBDFicha();
		$stmt = $pdo->prepare("DELETE FROM $tabla WHERE $item = :$item");
		$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);
		if($stmt->execute()){
			$respuesta = $stmt->fetch();
		}else{
			$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

	/*===================================================================
					MODIFICAR LOS CAMPOS COD_EMPLEADOR, NOMBRE_EMPLEADOR 
	 ====================================================================*/

	 static public function mdlEditarPacienteAseguradoNombreEmpleador($tabla,$item,$datos){
		 $pdo = Conexion::conectarBDFicha();
		 $stmt = $pdo->prepare("UPDATE $tabla SET cod_empleador = :cod_empleador, nombre_empleador = :nombre_empleador,
												  paterno = :paterno, materno = :materno, nombre = :nombre,
												  cod_asegurado = :cod_asegurado
		 						WHERE $item = :$item");
		 $stmt->bindParam(":cod_empleador",$datos['cod_empleador'],PDO::PARAM_STR);
		 $stmt->bindParam(":nombre_empleador",$datos['nombre_empleador'],PDO::PARAM_STR);

		 $stmt->bindParam(":paterno",$datos['paterno'],PDO::PARAM_STR);
		 $stmt->bindParam(":materno",$datos['materno'],PDO::PARAM_STR);
		 $stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
		 $stmt->bindParam(":cod_asegurado",$datos['cod_asegurado'],PDO::PARAM_STR);

		 $stmt->bindParam(":".$item,$datos['cod_afiliado'],PDO::PARAM_STR);

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

	/*===================================================================
		MODIFICAR LOS CAMPOS COD_EMPLEADOR, NOMBRE_EMPLEADOR COPIA DE ARRIBA PARA K NO CAUSE UN CRASH
	 ====================================================================*/

	 static public function mdlEditarPacienteAseguradoNombreEmpleador2($tabla,$item,$datos){
		$pdo = Conexion::conectarBDFicha();
		$stmt = $pdo->prepare("UPDATE $tabla SET cod_empleador = :cod_empleador, nombre_empleador = :nombre_empleador,
							   paterno = :paterno, materno = :materno, nombre = :nombre, cod_asegurado = :cod_asegurado
							   WHERE $item = :$item");
		$stmt->bindParam(":cod_empleador",$datos['cod_empleador'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre_empleador",$datos['nombre_empleador'],PDO::PARAM_STR);

		$stmt->bindParam(":paterno",$datos['paterno'],PDO::PARAM_STR);
		$stmt->bindParam(":materno",$datos['materno'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
		$stmt->bindParam(":cod_asegurado",$datos['codAsegurado'],PDO::PARAM_STR);

		//$stmt->bindParam(":".$item,$datos['id_ficha'],PDO::PARAM_INT);
		$stmt->bindParam(":".$item,$datos['id_pacientes_asegurados'],PDO::PARAM_INT);
		
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
	
	
	/*================================================================================================================
		MODIFICAR LOS CAMPOS COD_EMPLEADOR, NOMBRE_EMPLEADOR ASEGURADO(NOMBRE,PATERNO,MATERNO,CI,ZONA,CALLE,NRO) M@rk
	 =================================================================================================================*/

	 static public function mdlEditarPacienteAsegurado($tabla,$item,$datos){

		$pdo = Conexion::conectarBDFicha();
		$stmt = $pdo->prepare("UPDATE $tabla SET cod_empleador = :cod_empleador, nombre_empleador = :nombre_empleador,
							   paterno = :paterno, materno = :materno, nombre = :nombre, nro_documento= :nro_documento,
							   zona =:zona, calle = :calle, nro_calle = :nro_calle
							   WHERE $item = :$item");
		$stmt->bindParam(":cod_empleador",$datos['cod_empleador'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre_empleador",$datos['nombre_empleador'],PDO::PARAM_STR);
		$stmt->bindParam(":paterno",$datos['paterno'],PDO::PARAM_STR);
		$stmt->bindParam(":materno",$datos['materno'],PDO::PARAM_STR);
		$stmt->bindParam(":nombre",$datos['nombre'],PDO::PARAM_STR);
		$stmt->bindParam(":nro_documento",$datos['nro_documento'],PDO::PARAM_STR);
		$stmt->bindParam(":zona",$datos['zona'],PDO::PARAM_STR);
		$stmt->bindParam(":calle",$datos['calle'],PDO::PARAM_STR);
		$stmt->bindParam(":nro_calle",$datos['nro_calle'],PDO::PARAM_STR);
		$stmt->bindParam(":".$item,$datos['id'],PDO::PARAM_INT);
		
		if($stmt->execute()){			
			$respuesta = 'ok';
		}
		else{
			$respuesta = $stmt -> errorInfo();			
			//$respuesta = 'error';
		}
		return $respuesta;
	}

	/*============================================================
	  MODIFICAR UNA COLUMNA DADA DE LA TABLA PACIENTES ASEGURADOS
	 =============================================================*/

	 static public function mdlEditarPacienteAseguradoItem($idPaciente,$item,$valor){
		$pdo = Conexion::conectarBDFicha();
		$stmt = $pdo->prepare("UPDATE pacientes_asegurados SET $item = $valor
							   WHERE id = $idPaciente ");
		
		if($stmt->execute()){			
			$respuesta = 'ok';
		}
		else{
			$respuesta = $stmt -> errorInfo();			
			//$respuesta = 'error';
		}
		return $respuesta;
	 }

	/*========================================================================================================
	REGISTRO DE DATOS DEL PACIENTE ASEGURADO PARA REALIZAR FORMULARIOS DE BAJAS DE LABORATORIOS PARTICULARES
	==========================================================================================================*/

	static public function mdlIngresarPacienteAseguradoPorAltaManual($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();			
		$stmt = $pdo->prepare("INSERT INTO $tabla(cod_asegurado, cod_afiliado, cod_empleador, nombre_empleador, paterno, materno, nombre, sexo, nro_documento, fecha_nacimiento, edad, id_departamento_paciente, id_provincia_paciente , id_municipio_paciente , id_pais_paciente , zona, calle, nro_calle, telefono, email, nombre_apoderado, telefono_apoderado, id_ficha) VALUES (:cod_asegurado, :cod_afiliado, :cod_empleador, :nombre_empleador, :paterno, :materno, :nombre, :sexo, :nro_documento, :fecha_nacimiento, :edad, :id_departamento_paciente, :id_provincia_paciente  , :id_municipio_paciente, :id_pais_paciente, :zona, :calle, :nro_calle, :telefono, :email, :nombre_apoderado, :telefono_apoderado, :id_ficha)");
		$stmt->bindParam(":cod_asegurado", $datos["cod_asegurado"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_afiliado", $datos["cod_afiliado"], PDO::PARAM_STR);
		$stmt->bindParam(":cod_empleador", $datos["cod_empleador"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_empleador", $datos["nombre_empleador"], PDO::PARAM_STR);
		$stmt->bindParam(":paterno", $datos["paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":materno", $datos["materno"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_documento", $datos["nro_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":edad", $datos["edad"], PDO::PARAM_INT);
		$stmt->bindParam(":id_departamento_paciente", $datos["id_departamento_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_provincia_paciente", $datos["id_provincia_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_municipio_paciente", $datos["id_municipio_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_pais_paciente", $datos["id_pais_paciente"], PDO::PARAM_INT);
		$stmt->bindParam(":zona", $datos["zona"], PDO::PARAM_STR);
		$stmt->bindParam(":calle", $datos["calle"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_calle", $datos["nro_calle"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_apoderado", $datos["nombre_apoderado"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono_apoderado", $datos["telefono_apoderado"], PDO::PARAM_STR);
		$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			$respuesta = $pdo->lastInsertId();
		} else {
			
			$respuesta = $stmt->errorInfo();

		}
		return $respuesta;
	}

	/*===============================================================================================================
		BUSQUEDA DE PACIENTE QUE TENGAN ALMENOS UNA BAJA POR SOSPECHOSO
	=================================================================================================================*/

	static public function mldBusquedaPacienteBajaSospechosoActiva($codAsegurado,$hoy){
		$codAseguradoa = trim($codAsegurado);
		$fecha = trim($hoy);
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("SELECT *
								FROM bajas_sin_cresultado
								WHERE (cod_asegurado = '$codAseguradoa' OR  nombre_completo like '%$codAseguradoa%')
										AND '$fecha' BETWEEN fecha_ini AND fecha_fin");
										
		if($stmt->execute()){
			$respuesta = $stmt->fetchAll();
		}else{
			$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

	/*===============================================================================================================
		BUSQUEDA DE PACIENTE QUE TENGAN ALMENOS UNA BAJA POR SOSPECHOSO
	=================================================================================================================*/

	static public function mldBusquedaPacienteBajaPositivoActiva($codAsegurado,$hoy){
		$codAseguradoa = trim($codAsegurado);
		$fecha = trim($hoy);
		$pdo = Conexion::conectar();
		$stmt = $pdo->prepare("SELECT *
									FROM bajas_con_cresultados
									WHERE (cod_asegurado = '$codAseguradoa' OR nombre_completo like '%$codAseguradoa%')
									AND '$fecha' BETWEEN fecha_ini and fecha_fin");
		if($stmt->execute()){
			$respuesta = $stmt->fetchAll();
		}else{
			$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

	/*=======================================================================================
	BUSCAR EL PACIENTES EN LA TABLA PACIENTES_ASEGURADOS ANTES DE BUSCAR EN SIAIS danpinch
	=======================================================================================*/
	static public function mdlMostrarPacientesAseguradosSIAISBajas($valor) {
		$newValor = trim($valor);
		$codAsegurado = trim($valor."ID");
		$pdo = Conexion::conectarBDFicha();
		$stmt = $pdo->prepare("SELECT *
								FROM vista_pacientes
								WHERE (cod_afiliado='$codAsegurado'OR nombre_completo LIKE '%$newValor%')");
		if($stmt->execute())
			$respuesta = $stmt->fetchAll();
		else
			$respuesta = $stmt->errorInfo();
		
		return $respuesta;	

	}

}