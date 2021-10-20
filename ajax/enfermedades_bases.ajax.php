<?php

// require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/enfermedades_bases.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxEnfermedadesBases {
	
	/*=============================================
	CREAR DATOS DE ENFERMEDADES DE BASE DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	public $enf_estado; 
	public $enf_riesgo;
	public $enf_riesgo_otros; 
	public $id_ficha; 

	public function ajaxCrearEnfermedadBase()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "enfermedades_bases";

		$datos = array( "enf_estado"	     => $this->enf_estado, 
						"enf_riesgo"         => $this->enf_riesgo,
						"enf_riesgo_otros"   => strtoupper($this->enf_riesgo_otros),
						"id_ficha"  		 => $this->id_ficha,
						);	

		$respuesta = ModeloEnfermedadesBases::mdlIngresarEnfermedadBase($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS DE ENFERMEDADES DE BASE DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["guardarEnfermedadesBases"])) {

	$guardarEnfermedadesBases = new AjaxEnfermedadesBases();
	$guardarEnfermedadesBases -> enf_estado = $_POST["enf_estado"];
	$guardarEnfermedadesBases -> enf_riesgo = $_POST["enf_riesgo"];
	$guardarEnfermedadesBases -> enf_riesgo_otros = $_POST["enf_riesgo_otros"];
	$guardarEnfermedadesBases -> id_ficha = $_POST["id_ficha"];
	$guardarEnfermedadesBases -> ajaxCrearEnfermedadBase();

}
