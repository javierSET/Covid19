<?php


class ControladorFormularioAltasManual {
	
	/*=============================================
	MOSTRAR LOS AFILIADOS QUE TIENEN FORMULARIOS DE ALTAS MANUALES
	=============================================*/
	
	static public function ctrMostrarFormularioAltaManual($item, $valor) {

		$tabla = "certificado_alta_manual";

		$respuesta = ModeloFormularioAltasManual::mdlMostrarFormularioAltasManual($tabla, $item, $valor);

		return $respuesta;

	}

	/* EDITAR EL CAMPO ESTABLECIMIENTO NOTIFICADOR */

	static public function ctrEditarFormularioAltaManualEstablecimiento($item, $datos) {

		$tabla = "certificado_alta_manual";

		$respuesta = ModeloFormularioAltasManual::mdlEditarFormularioAltasManualEstablecimiento($tabla, $item, $datos);

		return $respuesta;

	}


	/*=============================================
	ELIMINAR LOS AFILIADOS QUE TIENEN FORMULARIOS DE ALTAS MANUALES
	=============================================*/
	
	static public function ctrEliminarFormularioAltaManual($item, $valor) {

		$tabla = "certificado_alta_manual";

		$respuesta = ModeloFormularioAltasManual::mdlEliminarFormularioAltasManual($tabla, $item, $valor);

		return $respuesta;

	}

	

}