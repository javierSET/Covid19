<?php


class ControladorLocalidades {

	/*=============================================
	MOSTRAR LOCALIDADDES
	=============================================*/
	
	static public function ctrMostrarLocalidades($item, $valor) {

		$tabla = "localidades";

		$respuesta = ModeloLocalidades::mdlMostrarLocalidades($tabla, $item, $valor);

		return $respuesta;

	}

}