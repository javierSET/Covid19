<?php

require_once "conexion.db.php";

class ModeloAntEpidemiologicos {

	/*=============================================
	MOSTRAR LOS DATOS DE ANTECEDENTES EPIDEMIOLOGICOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarAntEpidemiologico($tabla, $item, $valor) {

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

	static public function mdlMostrarAntEpidemiologicoMark($tabla, $item, $valor) {

		$stmt = Conexion::conectarBDFicha()->prepare("SELECT * FROM $tabla WHERE $item = $valor/* :$item*/");
		
		$stmt->execute();
		return $stmt->fetchAll();

	}


	/*=============================================
	REGISTRO DE DATOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarAntEpidemiologico($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();

		// try {
 
		//     //We start our transaction.
		//     $pdo->beginTransaction();
		 
		    //Query 1: Attempt to insert the payment record into our database.
			
			$stmt = $pdo->prepare("INSERT INTO $tabla(ocupacion, ant_vacuna_influenza, fecha_vacuna_influenza, viaje_riesgo, pais_ciudad_riesgo, fecha_retorno, nro_vuelo, nro_asiento, contacto_covid, fecha_contacto_covid, nombre_contacto_covid, telefono_contacto_covid, pais_contacto_covid, departamento_contacto_covid, localidad_contacto_covid, id_ficha) VALUES (:ocupacion, :ant_vacuna_influenza, :fecha_vacuna_influenza, :viaje_riesgo, :pais_ciudad_riesgo, :fecha_retorno, :nro_vuelo, :nro_asiento, :contacto_covid, :fecha_contacto_covid, :nombre_contacto_covid, :telefono_contacto_covid, :pais_contacto_covid, :departamento_contacto_covid, :localidad_contacto_covid, :id_ficha)");

			$stmt->bindParam(":ocupacion", $datos["ocupacion"], PDO::PARAM_STR);
			$stmt->bindParam(":ant_vacuna_influenza", $datos["ant_vacuna_influenza"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_vacuna_influenza", $datos["fecha_vacuna_influenza"], PDO::PARAM_STR);
			$stmt->bindParam(":viaje_riesgo", $datos["viaje_riesgo"], PDO::PARAM_STR);
			$stmt->bindParam(":pais_ciudad_riesgo", $datos["pais_ciudad_riesgo"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_retorno", $datos["fecha_retorno"], PDO::PARAM_STR);
			$stmt->bindParam(":nro_vuelo", $datos["nro_vuelo"], PDO::PARAM_STR);
			$stmt->bindParam(":nro_asiento", $datos["nro_asiento"], PDO::PARAM_STR);
			$stmt->bindParam(":contacto_covid", $datos["contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_contacto_covid", $datos["fecha_contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_contacto_covid", $datos["nombre_contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":telefono_contacto_covid", $datos["telefono_contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":pais_contacto_covid", $datos["pais_contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":departamento_contacto_covid", $datos["departamento_contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":localidad_contacto_covid", $datos["localidad_contacto_covid"], PDO::PARAM_STR);
			$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				return  "ok";

				// $id_ant_epidemiologico = $pdo->lastInsertId();
		    
			 //    //Query 2: Attempt to update the fichas.

			 //    $stmt = $pdo->prepare("UPDATE fichas SET id_ant_epidemiologico = :id_ant_epidemiologico WHERE id = :id");

			 //    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
				// $stmt->bindParam(":id_ant_epidemiologico", $id_ant_epidemiologico, PDO::PARAM_INT);

				// if ($stmt->execute()) {


				// 	//We've got this far without an exception, so commit the changes.
				//     $pdo->commit();

				//     return "ok";

				// } else {

				// 	$pdo->rollBack();

		  //   		return "error2";

				// }

			} else {
				
				return  "error";

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

}