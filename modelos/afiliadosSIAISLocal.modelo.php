<?php
/*
	@Author: Daniel Villegas Veliz
	@version: 
	@description: 
*/

require_once "conexion.db.php";

class ModeloAfiliadosSIAISLaboratorio {

	static public function mdlMostrarAfiliadosSIAISLocal($valor, $vista) {
		$pdo = Conexion::conectarBDFicha();
		if($valor!=""){
			$stmt = $pdo->prepare("SELECT *
									FROM $vista
									WHERE nombre_completo = :nombre_completo OR
											cod_asegurado = :cod_asegurado");
			$stmt->bindParam(":nombre_completo",$valor,PDO::PARAM_STR);
			$stmt->bindParam(":cod_asegurado",$valor,PDO::PARAM_STR);

			if($stmt->execute())
				$respuesta = $stmt->fetchAll();
			else
				$respuesta = $stmt->errorInfo();
		}
		return $respuesta;
	}

}