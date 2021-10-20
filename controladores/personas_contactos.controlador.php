<?php 

class ControladorPersonasContactos {
	
	/*=============================================
	MOSTRAR DATOS DE VARIAS PERSONAS CONTACTOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarPersonasContactos($item, $valor) {

		$tabla = "personas_contactos";

		$respuesta = ModeloPersonasContactos::mdlMostrarPersonasContactos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR DATOS DE UNA PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarPersonaContacto($item, $valor) {

		$tabla = "personas_contactos";

		$respuesta = ModeloPersonasContactos::mdlMostrarPersonaContacto($tabla, $item, $valor);

		return $respuesta;

	}

}