<?php


class ControladorProvincia {

	/*=============================================
	MOSTRAR PROVINCIA
	=============================================*/
	
	static public function ctrMostrarProvincia($item, $valor) {

		$tabla = "provincia";

		$respuesta = ModeloProvincia::mdlMostrarProvincia($tabla, $item, $valor);

		return $respuesta;

	}
	

	static public function ctrMostrarProvinciaPertenescanDepartamento($valor) {

		$respuesta = ModeloProvincia::mdlMostrarProvinciaPertenescanDepartamento($valor);

		return $respuesta;

	}
	
	static public function mdlMostrarProvinciaMark($item, $valor) {

		$tabla = "provincia";

		$respuesta = ModeloProvincia::mdlMostrarProvinciaMark($tabla, $item, $valor);

		return $respuesta;

	}

}