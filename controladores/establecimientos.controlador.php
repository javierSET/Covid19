<?php

class ControladorEstablecimientos {

	/*=============================================
	MOSTRAR ESTABLECIMIENTOS
	=============================================*/
	
	static public function ctrMostrarEstablecimientos($item, $valor) {

		$tabla = "establecimientos";

		$respuesta = ModeloEstablecimientos::mdlMostrarEstablecimientos($tabla, $item, $valor);

		return $respuesta;

	}

}