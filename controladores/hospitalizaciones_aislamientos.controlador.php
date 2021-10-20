<?php 

class ControladorHospitalizacionesAislamientos {
	
	/*=============================================
	MOSTRAR LOS DATOS DE HOSPITALIZACIONES AISLAMIENTOS EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	static public function ctrMostrarHospitalizacionesAislamientos($item, $valor) {

		$tabla = "hospitalizaciones_aislamientos";

		$respuesta = ModeloHospitalizacionesAislamientos::mdlMostrarHospitalizacionesAislamientos($tabla, $item, $valor);

		return $respuesta;

	}

}