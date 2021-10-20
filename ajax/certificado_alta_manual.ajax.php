<?php

require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../controladores/formulario_alta_manual.controlador.php";

require_once "../modelos/pacientes_asegurados.modelo.php";
require_once "../modelos/formulario_altas_manual.modelo.php";



session_start();

class AjaxCertificadoAltaManual{

	public $idCertificadoAltaManual;
	public $idPacienteAsegurado;

	public function ajaxEliminarCertificadoAltaManual(){

		$respuesta = ControladorPacientesAsegurados::ctrEliminarPacientesAsegurados("id",$this->idPacienteAsegurado);
		$respuesta1 = ControladorFormularioAltasManual::ctrEliminarFormularioAltaManual("id",$this->idCertificadoAltaManual);

		print_r($respuesta1);
	}

}

if(isset($_POST["certificadoAltaManual"])){

	$certificadoAltaManul = new AjaxCertificadoAltaManual();
	$certificadoAltaManul->idCertificadoAltaManual = $_POST["idCertificadoAlta"];
	$certificadoAltaManul->idPacienteAsegurado = $_POST["idPacienteAsegurado"];
	$certificadoAltaManul->ajaxEliminarCertificadoAltaManual();

}

?>