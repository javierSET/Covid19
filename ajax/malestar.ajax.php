<?php

require_once "../modelos/malestar.modelo.php";
require_once "../controladores/malestar.controlador.php";
require_once "../modelos/datos_clinicos.modelo.php";
require_once "../controladores/datos_clinicos.controlador.php";

class AjaxMalestar {
	
	/*=============================================
	CREAR MALESTARES DATOS CLINICOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	public $item; 
	public $valor;
	public $tabla;
	public $id_datos_clinicos;

	public function ajaxCreaMalestar()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$id_datos_clinicos = $this->id_datosclinico;
		$item = $this->item;
		$valor = mb_strtoupper($this->valor,'utf-8');
		$tabla = $this->tabla;
		$respuesta = ModeloMalestar::mdlIngresarMalestar($id_datos_clinicos, $item, $valor, $tabla);
		print_r($respuesta);

	}

}

/*=============================================
CREAR DATOS CLINICOS DEL PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
=============================================*/
if (isset($_POST["guardarMalestar"])) {
	$ajaxMalestar = new AjaxMalestar();
	$id_ficha = $_POST["id_ficha"];
	$id_datos_clinico = ControladorDatosClinicos::ctrMostrarDatosClinicos("id_ficha",$id_ficha);
	$id = (int)$id_datos_clinico["id"];
	$ajaxMalestar->id_datosclinico=$id;
	$ajaxMalestar->item=$_POST["item"];
	$ajaxMalestar->valor=$_POST["valor"];
	$ajaxMalestar->tabla=$_POST["tabla"];
	$ajaxMalestar -> ajaxCreaMalestar();

}