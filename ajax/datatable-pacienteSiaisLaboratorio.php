<?php
/*
	@Author: Daniel Villegas Veliz
	@version: 1.0
	@descripsion: Manejador de tabla 
 */


require_once "../controladores/afiliadosSIAISLocal.controlador.php";
require_once "../modelos/afiliadosSIAISLocal.modelo.php";

require_once "../controladores/laboratorios.controlador.php";
require_once "../modelos/laboratorios.modelo.php";

require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";



/*========================================================
	Clase tabla para mostrar a los pacientes
  ========================================================*/
class TablaPacienteSiaisLaboratorio {
	/*=====================================
		funcion para mostra
	  =====================================*/

	public function mostrarTablaPacienteSiaisLocal($valor){		
		$pacienteLocalLaboratorio = ControladorAfiliadosSIAISLocal::ctrMostrarAfiliadosSIAISLocal($valor);
		$data = array();
		for ($i=0; $i < count($pacienteLocalLaboratorio); $i++) {
			$subData = array();
			$subData[] = $pacienteLocalLaboratorio[$i]["nombre_completo"];
			$subData[] = $pacienteLocalLaboratorio[$i]["cod_asegurado"];
			$subData[] = $pacienteLocalLaboratorio[$i]["cod_afiliado"];
			$subData[] = $pacienteLocalLaboratorio[$i]["cod_empleador"];
			$subData[] = $pacienteLocalLaboratorio[$i]["nombre_empleador"];
			$data[] = $subData;
		}
		echo json_encode($data);

	}
}

if(isset($_POST["buscarPaciente"])){
	$buscadorPacienteSiais = new TablaPacienteSiaisLaboratorio();
	$buscadorPacienteSiais->mostrarTablaPacienteSiaisLocal($_POST["valor"]);	
}