<?php

// require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/datos_clinicos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxDatosClinicos {
	
	/*=============================================
	CREAR DATOS CLINICOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	public $fecha_inicio_sintomas;  
	public $malestares;
	public $malestares_otros; 
	public $estado_paciente; 
	public $fecha_defuncion; 
	public $diagnostico_clinico; 
	public $id_ficha; 

	public function ajaxCrearDatoClinico()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "datos_clinicos";

		$datos = array( "fecha_inicio_sintomas"	 => $this->fecha_inicio_sintomas, 
						"malestares"             => $this->malestares,
						"malestares_otros"    	 => mb_strtoupper($this->malestares_otros,'utf-8'),
						"estado_paciente"     	 => $this->estado_paciente,
						"fecha_defuncion"        => $this->fecha_defuncion,
						"diagnostico_clinico"    => $this->diagnostico_clinico,
						"id_ficha"               => $this->id_ficha,
						);	

		$respuesta = ModeloDatosClinicos::mdlIngresarDatoClinico($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS CLINICOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["guardarDatosClinicos"])) {
	$guardarDatosClinicos = new AjaxDatosClinicos();
	$guardarDatosClinicos -> fecha_inicio_sintomas = $_POST["fecha_inicio_sintomas"];
	$guardarDatosClinicos -> malestares = $_POST["malestares"];
	$guardarDatosClinicos -> malestares_otros = $_POST["malestares_otros"];
	$guardarDatosClinicos -> estado_paciente = $_POST["estado_paciente"];
	$guardarDatosClinicos -> fecha_defuncion = $_POST["fecha_defuncion"];
	$guardarDatosClinicos -> diagnostico_clinico = $_POST["diagnostico_clinico"];
	$guardarDatosClinicos -> id_ficha = $_POST["id_ficha"];
	$guardarDatosClinicos -> ajaxCrearDatoClinico();

}
