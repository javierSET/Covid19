<?php


class ControladorConsultorios {

	/*=============================================
	MOSTRAR CONSULTORIOS
	=============================================*/
	
	static public function ctrMostrarConsultorios($item, $valor) {

		$tabla = "consultorios";

		$respuesta = ModeloConsultorios::mdlMostrarConsultorios($tabla, $item, $valor);

		return $respuesta;

	}

	static public function consultoriosDadoUnEstablecimiento($item, $valor) {

		$tabla = "consultorios";

		$respuesta = ModeloConsultorios::consultoriosDadoUnEstablecimiento($tabla, $item, $valor);

		return $respuesta;

	}

}