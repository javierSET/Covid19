<?php

require_once "conexion.db.php";

class ModeloDatosClinicos {

	/*=============================================
	MOSTRAR LOS DATOS CLINICOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarDatosClinicos($tabla, $item, $valor) {

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

	/*=============================================
	REGISTRO DE DATOS CLINICOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarDatoClinico($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();

		// try {
 
		//     //We start our transaction.
		//     $pdo->beginTransaction();
		 
		//     //Query 1: Attempt to insert the payment record into our database.
			
			$stmt = $pdo->prepare("INSERT INTO $tabla(fecha_inicio_sintomas, malestares, malestares_otros, estado_paciente, fecha_defuncion, diagnostico_clinico, id_ficha) VALUES (:fecha_inicio_sintomas, :malestares, :malestares_otros, :estado_paciente, :fecha_defuncion, :diagnostico_clinico, :id_ficha)");

			$stmt->bindParam(":fecha_inicio_sintomas", $datos["fecha_inicio_sintomas"], PDO::PARAM_STR);
			$stmt->bindParam(":malestares", $datos["malestares"], PDO::PARAM_STR);
			$stmt->bindParam(":malestares_otros", $datos["malestares_otros"], PDO::PARAM_STR);
			$stmt->bindParam(":estado_paciente", $datos["estado_paciente"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_defuncion", $datos["fecha_defuncion"], PDO::PARAM_STR);
			$stmt->bindParam(":diagnostico_clinico", $datos["diagnostico_clinico"], PDO::PARAM_STR);
			$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				return  "ok";

				// $id_dato_clinico = $pdo->lastInsertId();
		    
			 //    //Query 2: Attempt to update the fichas.

			 //    $stmt = $pdo->prepare("UPDATE fichas SET id_dato_clinico = :id_dato_clinico WHERE id = :id");

			 //    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
				// $stmt->bindParam(":id_dato_clinico", $id_dato_clinico, PDO::PARAM_INT);

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