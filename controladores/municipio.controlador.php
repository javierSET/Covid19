<?php


class ControladorMunicipio {

	/*=============================================
	MOSTRAR Municipio
	=============================================*/
	
	static public function ctrMostrarMunicipio($item, $valor) {

		$tabla = "municipio";

		$respuesta = ModeloMunicipio::mdlMostrarMunicipio($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarMunicipioPerteneceProvincia($valor) {

		$respuesta = ModeloMunicipio::mdlMostrarMunicipioPerteneceProvincia($valor);

		return $respuesta;

	}

	static public function ctrMostrarMunicipioMark($item, $valor) {

		$tabla = "municipio";

		$respuesta = ModeloMunicipio::mdlMostrarMunicipioMark($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarMunicipioDadoUnIdMunicipio($idMunicipio){

		$tabla = "municipio";

		$respuesta = ModeloMunicipio::ctrMostrarMunicipioDadoUnIdMunicipio($tabla,'id', $idMunicipio);

		return $respuesta;
	}

}

