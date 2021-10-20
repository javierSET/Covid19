<?php

class ControladorReportesCovid {

	/*=============================================
	MOSTRAR RESULTADOS COVID POR FECHAS DE RESULTADO
	=============================================*/
	
	static public function ctrMostrarReportesCovidFechas($valor1, $valor2, $valor3) {

		$tabla = "covid_resultados";

		$respuesta = ModeloReportesCovid::mdlMostrarReportesCovidFechas($tabla, $valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR RESULTADOS COVID POR PERSONA
	=============================================*/
	
	static public function ctrMostrarReportesCovidPersonal($item, $valor) {

		$tabla = "covid_resultados";

		$respuesta = ModeloReportesCovid::mdlMostrarReportesCovidPersonal($tabla, $item, $valor);

		return $respuesta;

	}

}