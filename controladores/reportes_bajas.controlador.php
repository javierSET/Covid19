<?php

class ControladorReportesBajas {

	/*=============================================
	MOSTRAR RESULTADOS BAJAS POR FECHAS DE RESULTADO
	=============================================*/
	
	static public function ctrMostrarReportesBajasFechas($valor1, $valor2) {

		$tabla = "bajas_resultados";

		$respuesta = ModeloReportesBajas::mdlMostrarReportesBajasFechas($tabla, $valor1, $valor2);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR RESULTADOS BAJAS POR PERSONA
	=============================================*/
	
	static public function ctrMostrarReportesBajas($item, $valor) {

		$tabla = "bajas_resultados";

		$respuesta = ModeloReportesBajas::mdlMostrarReportesBajasFechas($tabla, $item, $valor);

		return $respuesta;

	}

}