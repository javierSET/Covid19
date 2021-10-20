<?php


class ControladorOcupaciones {

	/*=============================================
	MOSTRAR OCUPACIONES
	=============================================*/
	
	static public function ctrMostrarOcupaciones($item, $valor) {

		$tabla = "ocupaciones";

		$respuesta = ModeloOcupaciones::mdlMostrarOcupaciones($tabla, $item, $valor);

		return $respuesta;

	}

}