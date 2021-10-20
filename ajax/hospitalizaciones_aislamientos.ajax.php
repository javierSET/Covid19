<?php

// require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/hospitalizaciones_aislamientos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxHospitalizacionesAislamientos {
	
	/*=============================================
	CREAR DATOS DE HOSPITALIZACION Y AISLAMIENTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	public $fecha_aislamiento; 
	public $lugar_aislamiento;
	public $fecha_internacion; 
	public $establecimiento_internacion; 
	public $ventilacion_mecanica; 
	public $terapia_intensiva; 
	public $fecha_ingreso_UTI; 
	public $id_ficha; 

	public function ajaxCrearHospitalizacionAislamiento()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "hospitalizaciones_aislamientos";

		$datos = array( "fecha_aislamiento"	           => $this->fecha_aislamiento, 
						"lugar_aislamiento"     	   => strtoupper($this->lugar_aislamiento),
						"fecha_internacion"    	       => $this->fecha_internacion,
						"establecimiento_internacion"  => strtoupper($this->establecimiento_internacion),
						"ventilacion_mecanica"         => $this->ventilacion_mecanica,
						"terapia_intensiva"   	       => $this->terapia_intensiva,
						"fecha_ingreso_UTI"   	       => $this->fecha_ingreso_UTI,
						"id_ficha"  				   => $this->id_ficha,
						);	

		$respuesta = ModeloHospitalizacionesAislamientos::mdlIngresarHospitalizacionAislamiento($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS DE HOSPITALIZACION Y AISLAMIENTO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["guardarHospitalizacion"])) {

	$guardarHospitalizacionAislamiento = new AjaxHospitalizacionesAislamientos();
	$guardarHospitalizacionAislamiento -> fecha_aislamiento = $_POST["fecha_aislamiento"];
	$guardarHospitalizacionAislamiento -> lugar_aislamiento = $_POST["lugar_aislamiento"];
	$guardarHospitalizacionAislamiento -> fecha_internacion = $_POST["fecha_internacion"];
	$guardarHospitalizacionAislamiento -> establecimiento_internacion = $_POST["establecimiento_internacion"];
	$guardarHospitalizacionAislamiento -> ventilacion_mecanica = $_POST["ventilacion_mecanica"];
	$guardarHospitalizacionAislamiento -> terapia_intensiva = $_POST["terapia_intensiva"];
	$guardarHospitalizacionAislamiento -> fecha_ingreso_UTI = $_POST["fecha_ingreso_UTI"];
	$guardarHospitalizacionAislamiento -> id_ficha = $_POST["id_ficha"];
	$guardarHospitalizacionAislamiento -> ajaxCrearHospitalizacionAislamiento();

}
