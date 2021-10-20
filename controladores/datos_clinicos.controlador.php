<?php 

class ControladorDatosClinicos {
	
	/*=============================================
	MOSTRAR LOS DATOS CLINICOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarDatosClinicos($item, $valor) {

		$tabla = "datos_clinicos";

		$respuesta = ModeloDatosClinicos::mdlMostrarDatosClinicos($tabla, $item, $valor);

		return $respuesta;

	}

}