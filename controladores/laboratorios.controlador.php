<?php 

//@include "../modelos/laboratorios.modelo.php";

class ControladorLaboratorios {
	
	/*=============================================
	MOSTRAR LOS DATOS DE LABORATORIO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarLaboratorios($item, $valor) {

		$tabla = "laboratorios";

		$respuesta = ModeloLaboratorios::mdlMostrarLaboratorios($tabla, $item, $valor);

		return $respuesta;

	}
	static public function ctrMostrarLaboratoriosAll() {

		$tabla = "laboratorios";

		$respuesta = ModeloLaboratorios::mdlMostrarLaboratoriosAll($tabla);

		return $respuesta;

	}

	/*==========================================================
	 	ACTUALIZAR CAMPO tansferencia_hospital_obrero de la tabla laboratorios
	  ==========================================================*/
	static public function ctrActualizarCamposLaboratorio($item,$valor,$id_ficha){
		$tabla="laboratorios";
		$respuesta = ModeloLaboratorios::mdlActualizarCamposLaboratorios($tabla,$item,$valor,$id_ficha);
		return $respuesta;
	}
}