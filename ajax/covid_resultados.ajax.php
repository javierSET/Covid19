<?php

require_once "../controladores/reportes_covid.controlador.php";
require_once "../modelos/reportes_covid.modelo.php";

require_once "../controladores/covid_resultados.controlador.php";
require_once "../modelos/covid_resultados.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/departamentos.controlador.php";
require_once "../modelos/departamentos.modelo.php";

require_once "../controladores/establecimientos.controlador.php";
require_once "../modelos/establecimientos.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";

require_once('../extensiones/tcpdf/tcpdf.php');

class AjaxCovidResultados {
	
	/*=============================================
	MOSTRAR RESULTADOS COVID POR FECHA DE TOMA DE MUESTRA
	=============================================*/
	
	public $fechaMuestra;

	public function ajaxMostrarCovidResultadosFechaMuestra()	{

		$fecha_formato = date("Y-m-d", strtotime($this->fechaMuestra));

		$item = "fecha_muestra";
		$valor = $fecha_formato;

		//$respuesta = ControladorCovidResultados::ctrMostrarCovidResultadosFechaMuestra($item, $valor);

		//echo json_encode($respuesta);

	}

	/*=============================================
	MOSTRAR RESULTADOS COVID POR FECHA DE RESULTADO
	=============================================*/
	
	// public $fechaResultado;

	// public function ajaxMostrarCovidResultadosFechaResultado()	{

	// 	$fecha_formato = date("Y-m-d", strtotime($this->fechaResultado));

	// 	$item = "fecha_resultado";
	// 	$valor = $fecha_formato;

	// 	$respuesta = ControladorCovidResultados::ctrMostrarCovidResultadosFechaResultado($item, $valor);

	// 	echo json_encode($respuesta);

	// }

}

/*=====================================================
	Clase para administrar todo referente a la resultados para el Hospital Obrero @dan
=======================================================*/
class AjaxCovidResultado{	
	public $id_ficha;
	public $resultado;
	public $responsable;
	public $tipoDiagnostico;
	

	/*==================================================
		funcion para guardar el cambio de tipo diagnostico de la tabla covid resultado @dan
	====================================================*/
	public function AjaxCambiarTipoDiagnostico(){
		$respuesta = ControladorCovidResultados::ctrEditarCovidResultadoTipoDiagnostico($this->id_ficha,$this->tipoDiagnostico);
		return $respuesta;
	}
	/*===================================================
		funcion para guardar los cambios de resutado, responsable, estado de la tabla covid resultado @dan
	=====================================================*/
	public function AjaxCambiarResultadoEstadoResponsable(){
		$respuesta = ControladorCovidResultados::ctrEditarcamposCovidResultadoFechaEstadoResponsable($this->id_ficha,$this->resultado,$this->responsable);
		return $respuesta;
	}

	/*=====================================================
	Funcion para asignar valores por defecto en la tabla covid resltdo 
	 ======================================================*/
	 public function AjaxRestablecerCamposResultadoEstadoRespondableTipoDiagnostico(){
		 $respuesta = ControladorCovidResultados::ctrRestablecerCamposCovidResultadoDiagnosticoResultadoResponsableEstado($this->id_ficha);
		 return $respuesta;
	 }

}

/*====================================================
		clase para realizar la busqueda por fecha @dan
  ====================================================*/
class AjaxCovidResultadoEstablecimientoFecha{
	public $establecimineto;
	public $fecha;
	
	public function AjaxBusquedaPorEstablecimientoFechaMuestra(){
		$respuesta ="";
		return $respuesta;
	}
}



/*=============================================
	Agregar tipo diagnostico
 =============================================*/
if(isset($_POST["guardarCampoTipoDiagnostico"])){	
	if($_POST["tipoDiagnostico"]=="RT-PCR en tiempo Real"){
		$tipoDiagnostico = array(
								0=>"RT-PCR en tiempo Real",
								1=>"",
								2=>"");
	}else if($_POST["tipoDiagnostico"]=="RT-PCR GENEXPERT"){
		$tipoDiagnostico = array(
									0=>"",
									1=>"RT-PCR GENEXPERT",
									2=>"");
	}else if($_POST["tipoDiagnostico"]=="Prueba Antigénica"){
		$tipoDiagnostico = array(
									0=>"",
									1=>"",
									2=>"Prueba Antigénica");
	}
	$cambiarTipoDiagnostico = new AjaxCovidResultado();
	$cambiarTipoDiagnostico->id_ficha = $_POST["id_ficha"];
	$cambiarTipoDiagnostico->tipoDiagnostico = $tipoDiagnostico;
	$cambiarTipoDiagnostico->AjaxCambiarTipoDiagnostico();

}

 /*============================================
 Cambiar Resultado, Estado, Responsable @dan
  =============================================*/
if(isset($_POST["guardarCamposResultadoEstadoResponsable"])){
	$cambiarResultadoEstadoResponsable = new AjaxCovidResultado();
	$cambiarResultadoEstadoResponsable->id_ficha = $_POST["id_ficha"];
	$cambiarResultadoEstadoResponsable->resultado = $_POST["resultado"];
	$cambiarResultadoEstadoResponsable->responsable = $_POST["reponsable"];
	$cambiarResultadoEstadoResponsable->AjaxCambiarResultadoEstadoResponsable();	
	  
}

if(isset($_POST["restablecerCovidResultado"])){
	$restablecerCovidResultado = new AjaxCovidResultado();
	$restablecerCovidResultado->id_ficha = $_POST["id_ficha"];
	$restablecerCovidResultado->AjaxRestablecerCamposResultadoEstadoRespondableTipoDiagnostico();
}

/*=============================================
MOSTRAR RESULTADOS COVID POR FECHA DE TOMA DE MUESTRA
=============================================*/

if (isset($_POST["resultadosFormBaja"])) {
	$resultadosCovid = new AjaxCovidResultados();
	$resultadosCovid -> fechaMuestra = $_POST["fechaMuestra"];
	$resultadosCovid -> ajaxMostrarCovidResultadosFechaMuestra();
}

/*=============================================
MOSTRAR RESULTADOS COVID POR FECHA DE TOMA DE MUESTRA
=============================================*/

// if (isset($_POST["resultadosLab"])) {

// 	$resultadosCovid = new AjaxCovidResultados();
// 	$resultadosCovid -> fechaResultado = $_POST["fechaResultado"];
// 	$resultadosCovid -> ajaxMostrarCovidResultadosFechaResultado();

// }