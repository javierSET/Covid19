<?php 

class ControladorPersonasNotificadores {
	
	/*=============================================
	MOSTRAR LOS DATOS DE PERSONA NOTIFICADOR EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarPersonasNotificadores($item, $valor) {

		$tabla = "personas_notificadores";

		$respuesta = ModeloPersonasNotificadores::mdlMostrarPersonasNotificadores($tabla, $item, $valor);

		return $respuesta;

	}

}