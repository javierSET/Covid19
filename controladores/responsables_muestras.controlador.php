<?php


class ControladorResponsablesMuestras {

	/*=============================================
	MOSTRAR RESPONSABLES MUESTRAS
	=============================================*/
	
	static public function ctrMostrarResponsablesMuestras($item, $valor) {

		$tabla = "responsables_muestras";

		$respuesta = ModeloResponsablesMuestras::mdlMostrarResponsablesMuestras($tabla, $item, $valor);

		return $respuesta;

	}

}