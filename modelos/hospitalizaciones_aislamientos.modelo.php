<?php

require_once "conexion.db.php";

class ModeloHospitalizacionesAislamientos {

	/*=============================================
	MOSTRAR LOS DATOS DE HOSPITALIZACIONES AISLAMIENTOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function mdlMostrarHospitalizacionesAislamientos($tabla, $item, $valor) {

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
	REGISTRO DATOS DE HOSPITALIZACION Y AISLAMIENTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	static public function mdlIngresarHospitalizacionAislamiento($tabla, $datos) {

		$pdo = Conexion::conectarBDFicha();

		// try {
 
		//     //We start our transaction.
		//     $pdo->beginTransaction();
		 
		//     //Query 1: Attempt to insert the payment record into our database.
			
			$stmt = $pdo->prepare("INSERT INTO $tabla(fecha_aislamiento, lugar_aislamiento, fecha_internacion, establecimiento_internacion, ventilacion_mecanica, terapia_intensiva, fecha_ingreso_UTI, id_ficha) VALUES (:fecha_aislamiento, :lugar_aislamiento, :fecha_internacion, :establecimiento_internacion, :ventilacion_mecanica, :terapia_intensiva, :fecha_ingreso_UTI, :id_ficha)");

			$stmt->bindParam(":fecha_aislamiento", $datos["fecha_aislamiento"], PDO::PARAM_STR);
			$stmt->bindParam(":lugar_aislamiento", $datos["lugar_aislamiento"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_internacion", $datos["fecha_internacion"], PDO::PARAM_STR);
			$stmt->bindParam(":establecimiento_internacion", $datos["establecimiento_internacion"], PDO::PARAM_STR);
			$stmt->bindParam(":ventilacion_mecanica", $datos["ventilacion_mecanica"], PDO::PARAM_STR);
			$stmt->bindParam(":terapia_intensiva", $datos["terapia_intensiva"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_ingreso_UTI", $datos["fecha_ingreso_UTI"], PDO::PARAM_STR);
			$stmt->bindParam(":id_ficha", $datos["id_ficha"], PDO::PARAM_INT);

			if ($stmt->execute()) {

				return  "ok";

				// $id_hospitalizacion_aislamiento = $pdo->lastInsertId();
		    
			 //    //Query 2: Attempt to update the fichas.

			 //    $stmt = $pdo->prepare("UPDATE fichas SET id_hospitalizacion_aislamiento = :id_hospitalizacion_aislamiento WHERE id = :id");

			 //    $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
				// $stmt->bindParam(":id_hospitalizacion_aislamiento", $id_hospitalizacion_aislamiento, PDO::PARAM_INT);

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