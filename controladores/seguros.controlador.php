<?php


class ControladorSeguros {

	/*=============================================
	MOSTRAR TIPOS DE SEGUROS
	=============================================*/
	
	static public function ctrMostrarSeguros($item, $valor) {

		$tabla = "seguros";

		$respuesta = ModeloSeguros::mdlMostrarSeguros($tabla, $item, $valor);

		return $respuesta;

	}

}