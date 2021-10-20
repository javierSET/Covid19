<?php 

class ControladorAfiliadosSIAIS {

	/*=============================================
	LISTADO DE AFILIADOS DE LA BASE DE DATOS SIAIS
	=============================================*/
	
	static public function ctrMostrarAfiliadosSIAIS($item1, $item2, $valor) {

		$respuesta = ModeloAfiliadosSIAIS::mdlMostrarAfiliadosSIAIS($item1, $item2, $valor);

		return $respuesta;

	}

	static public function ctrMostrarAfiliadosSIAISAltaManual($item1, $item2, $valor) {

		$respuesta = ModeloAfiliadosSIAIS::mdlMostrarAfiliadosSIAISAltaManual($item1, $item2, $valor);

		return $respuesta;

	}

}