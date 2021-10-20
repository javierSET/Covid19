<?php

require_once "conexion.db.php";

class ModeloEnfermedadesBases {

	/*=============================================
	MOSTRAR LOS DATOS DE HOSPITALIZACIONES AISLAMIENTOSENFERMEDADES BASES EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarEnfermedadesBases($tabla, $item, $valor) {

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
	REGISTRO DE DATOS DE ENFERMEDADES BASES EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarEnfermedadBase($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();

		// try {
 
		//     //We start our transaction.
		//     $pdo->beginTransaction();
		 
		//     //Query 1: Attempt to insert the payment record into our database.
			
			$stmt = $pdo->prepare("INSERT INTO $tabla(enf_estado, enf_riesgo, enf_riesgo_otros, id_ficha) VALUES (:enf_estado, :enf_riesgo, :enf_riesgo_otros, :id_ficha)");

			$stmt->bindParam(":enf_estado", $datos["enf_estado"], PDO::PARAM_STR);
			$stmt->bindParam(":enf_riesgo", $datos["enf_riesgo"], PDO::PARAM_STR);
			$stmt->bindParam(":enf_riesgo_otros", $datos["enf_riesgo_otros"], PDO::PARAM_STR);
			$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				return  "ok";

				// $id_enfermedad_base = $pdo->lastInsertId();
		    
			 //    //Query 2: Attempt to update the fichas.

			 //    $stmt = $pdo->prepare("UPDATE fichas SET id_enfermedad_base = :id_enfermedad_base WHERE id = :id");

			 //    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
				// $stmt->bindParam(":id_enfermedad_base", $id_enfermedad_base, PDO::PARAM_INT);

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