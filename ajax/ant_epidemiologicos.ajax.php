<?php

// require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/ant_epidemiologicos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxAntEpidemiologicos {
	
	/*=============================================
	CREAR DATOS DE ANTECEDENTES EPIDEMIOLOGICOS
	=============================================*/
	
	public $ocupacion; 
	public $ant_vacuna_influenza; 
	public $fecha_vacuna_influenza; 
	public $viaje_riesgo; 
	public $pais_ciudad_riesgo; 
	public $fecha_retorno; 
	public $nro_vuelo; 
	public $nro_asiento; 
	public $contacto_covid; 
	public $fecha_contacto_covid; 
	public $nombre_contacto_covid; 
	public $telefono_contacto_covid; 
	public $pais_contacto_covid; 
	public $departamento_contacto_covid; 
	public $localidad_contacto_covid; 
	public $id_ficha; 

	public function ajaxCrearAntEpidemiologico()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "ant_epidemiologicos";

		$datos = array( "ocupacion"		  			       => $this->ocupacion, 
						"ant_vacuna_influenza"	      	   => $this->ant_vacuna_influenza, 
						"fecha_vacuna_influenza"    	   => $this->fecha_vacuna_influenza,
						"viaje_riesgo"    	               => $this->viaje_riesgo,
						"pais_ciudad_riesgo"     	       => $this->pais_ciudad_riesgo,
						"fecha_retorno"     	      	   => $this->fecha_retorno,
						"nro_vuelo"     	      	       => $this->nro_vuelo,
						"nro_asiento"     	          	   => $this->nro_asiento,
						"contacto_covid"    		       => $this->contacto_covid,
						"fecha_contacto_covid"    	       => $this->fecha_contacto_covid,
						"nombre_contacto_covid"     	   => $this->nombre_contacto_covid,
						"telefono_contacto_covid"    	   => $this->telefono_contacto_covid,
						"pais_contacto_covid"     	       => strtoupper($this->pais_contacto_covid),
						"departamento_contacto_covid"      => strtoupper($this->departamento_contacto_covid),
						"localidad_contacto_covid"   	   => strtoupper($this->localidad_contacto_covid),
						"id_ficha"  					   => $this->id_ficha,
						);	

		$respuesta = ModeloAntEpidemiologicos::mdlIngresarAntEpidemiologico($tabla, $datos);

		//var_dump($respuesta);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS DE ANTECEDENTES EPIDEMIOLOGICOS
=============================================*/

if (isset($_POST["guardarAntEpidemiologicos"])) {

	$guardarAntEpidemiologicos = new AjaxAntEpidemiologicos();
	$guardarAntEpidemiologicos -> ocupacion = $_POST["ocupacion"];
	$guardarAntEpidemiologicos -> ant_vacuna_influenza = $_POST["ant_vacuna_influenza"];
	$guardarAntEpidemiologicos -> fecha_vacuna_influenza = $_POST["fecha_vacuna_influenza"];
	$guardarAntEpidemiologicos -> viaje_riesgo = $_POST["viaje_riesgo"];
	$guardarAntEpidemiologicos -> pais_ciudad_riesgo = $_POST["pais_ciudad_riesgo"];
	$guardarAntEpidemiologicos -> fecha_retorno = $_POST["fecha_retorno"];
	$guardarAntEpidemiologicos -> nro_vuelo = $_POST["nro_vuelo"];
	$guardarAntEpidemiologicos -> nro_asiento = $_POST["nro_asiento"];
	$guardarAntEpidemiologicos -> contacto_covid = $_POST["contacto_covid"];
	$guardarAntEpidemiologicos -> fecha_contacto_covid = $_POST["fecha_contacto_covid"];
	$guardarAntEpidemiologicos -> nombre_contacto_covid = $_POST["nombre_contacto_covid"];
	$guardarAntEpidemiologicos -> telefono_contacto_covid = $_POST["telefono_contacto_covid"];
	$guardarAntEpidemiologicos -> pais_contacto_covid = $_POST["pais_contacto_covid"];
	$guardarAntEpidemiologicos -> departamento_contacto_covid = $_POST["departamento_contacto_covid"];
	$guardarAntEpidemiologicos -> localidad_contacto_covid = $_POST["localidad_contacto_covid"];
	$guardarAntEpidemiologicos -> id_ficha = $_POST["id_ficha"];
	$guardarAntEpidemiologicos -> ajaxCrearAntEpidemiologico();

}
