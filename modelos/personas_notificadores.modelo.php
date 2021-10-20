<?php

require_once "conexion.db.php";

class ModeloPersonasNotificadores {

	/*=============================================
	MOSTRAR LOS DATOS DE PERSONA NOTIFICADOR EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarPersonasNotificadores($tabla, $item, $valor) {

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

	static public function mdlIngresarPersonaNotificador($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();

		// try {
 
		//     //We start our transaction.
		//     $pdo->beginTransaction();
		 
		//     //Query 1: Attempt to insert the payment record into our database.
			
			$stmt = $pdo->prepare("INSERT INTO $tabla(paterno_notificador, materno_notificador, nombre_notificador, telefono_notificador, cargo_notificador, id_ficha) VALUES (:paterno_notificador, :materno_notificador, :nombre_notificador, :telefono_notificador, :cargo_notificador, :id_ficha)");

			$stmt->bindParam(":paterno_notificador", $datos["paterno_notificador"], PDO::PARAM_STR);
			$stmt->bindParam(":materno_notificador", $datos["materno_notificador"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_notificador", $datos["nombre_notificador"], PDO::PARAM_STR);
			$stmt->bindParam(":telefono_notificador", $datos["telefono_notificador"], PDO::PARAM_STR);
			$stmt->bindParam(":cargo_notificador", $datos["cargo_notificador"], PDO::PARAM_STR);
			$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				return  "ok";

				// $id_persona_notificador = $pdo->lastInsertId();
		    
			 //    //Query 2: Attempt to update the fichas.

			 //    $stmt = $pdo->prepare("UPDATE fichas SET id_persona_notificador = :id_persona_notificador WHERE id = :id");

			 //    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
				// $stmt->bindParam(":id_persona_notificador", $id_persona_notificador, PDO::PARAM_INT);

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