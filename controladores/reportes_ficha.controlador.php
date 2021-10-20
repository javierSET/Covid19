<?php

class ControladorReportesFicha {

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA BUSQUEDA ACTIVA
	=============================================*/
	
	static public function ctrContarBusquedaActiva($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarBusquedaActiva($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA SEXO PACIENTE
	=============================================*/
	
	static public function ctrContarSexoPaciente($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarSexoPaciente($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OCUPACIÓN
	=============================================*/
	
	static public function ctrContarOcupacion($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarOcupacion($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OTRA OCUPACIÓN
	=============================================*/
	
	static public function ctrContarOtraOcupacion($valor1, $valor2) {

		$respuesta = ModeloReportesFicha::mdlContarOtraOcupacion($valor1, $valor2);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA ANTECEDENTES DE VACUNACIÓN INFLUENZA
	=============================================*/
	
	static public function ctrContarVacunaInfluenza($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarVacunaInfluenza($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA VIAJE DE RIESGO
	=============================================*/
	
	static public function ctrContarViajeRiesgo($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarViajeRiesgo($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA CONTACTO COVID
	=============================================*/
	
	static public function ctrContarContactoCovid($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarContactoCovid($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA MALESTARES
	=============================================*/
	
	static public function ctrContarMalestar($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarMalestar($valor1, $valor2, $valor3);

		return $respuesta;

	}

	static public function ctrContarSintomaticoAsintomatico($valor1, $valor2, $valor3){
		$respuesta = ModeloReportesFicha::mdlContarSintomaticoAsintomatico($valor1, $valor2, $valor3);

		return $respuesta;
	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OTROS MALESTARES
	=============================================*/
	
	static public function ctrContarOtroMalestar($valor1, $valor2) {

		$respuesta = ModeloReportesFicha::mdlContarOtroMalestar($valor1, $valor2);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA ESTADO PACIENTE
	=============================================*/
	
	static public function ctrContarEstadoPaciente($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarEstadoPaciente($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA DIAGNOSTICO CLÍNICO
	=============================================*/
	
	static public function ctrContarDiagnostico($valor1, $valor2, $valor3) {

		$respuesta = ModeloReportesFicha::mdlContarDiagnostico($valor1, $valor2, $valor3);

		return $respuesta;

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OTRO DIAGNOSTICO CLINICO
	=============================================*/
	
	static public function ctrContarOtroDiagnostico($valor1, $valor2) {

		$respuesta = ModeloReportesFicha::mdlContarOtroDiagnostico($valor1, $valor2);

		return $respuesta;

	}


}