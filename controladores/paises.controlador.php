<?php


class ControladorPaises {

	/*=============================================
	MOSTRAR DEPARTAMENTOS
	=============================================*/
	
	static public function ctrMostrarPaises($item, $valor) {

		$tabla = "paises";

		$respuesta = ModeloPaises::mdlMostrarPaises($tabla, $item, $valor);

		return $respuesta;

	}

}