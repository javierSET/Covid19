<?php 

class ControladorEnfermedadesBases {
	
	/*=============================================
	MOSTRAR LOS DATOS DE ENFERMEDADES BASES EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarEnfermedadesBases($item, $valor) {

		$tabla = "enfermedades_bases";

		$respuesta = ModeloEnfermedadesBases::mdlMostrarEnfermedadesBases($tabla, $item, $valor);

		return $respuesta;

	}

}