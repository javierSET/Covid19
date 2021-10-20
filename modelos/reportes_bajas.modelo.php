<?php

require_once "conexion.db.php";

class ModeloReportesBajas {

	/*=============================================
	MOSTRAR LAS CANTIDAD DE ABJAS EN UN RANGO
	
	=============================================*/
	
	static public function mdlMostrarReportesBajasFechas($tabla, $valor1, $valor2) {

		
			// devuelve los campos que coincidan con el rango de fechas

			$sql = "SELECT a.establecimiento, b.nombre_establecimiento As nombre, COUNT(a.id) As sumadia ,(SELECT COUNT(id)  
 					FROM formulario_bajas WHERE fecha between '2021-01-01' AND  :fechaFin AND a.establecimiento = establecimiento ) As suma
 					FROM formulario_bajas a, establecimientos b WHERE fecha BETWEEN :fechaInicio AND :fechaFin AND  a.establecimiento = b.id 
 					GROUP BY establecimiento";

			$stmt = Conexion::conectar()->prepare($sql);

			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetchAll();

		

		$stmt->close();
		$stmt = null;

	}



}