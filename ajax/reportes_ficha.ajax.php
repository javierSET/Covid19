<?php

require_once "../controladores/reportes_ficha.controlador.php";
require_once "../modelos/reportes_ficha.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/departamentos.controlador.php";
require_once "../modelos/departamentos.modelo.php";

require_once "../controladores/establecimientos.controlador.php";
require_once "../modelos/establecimientos.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";

require_once('../extensiones/tcpdf/tcpdf.php');

class AjaxReportesFicha {
	
	/*=============================================
	MOSTRAR REPORTE POR FECHA DE TOMA DE MUESTRA
	=============================================*/
	
	public $fechaInicio;
	public $fechaFin;

	public $nombre_usuario;
	public $exportar;

	public function ajaxMostrarReportesFichaFechas()	{
		
		$valor1 = date("Y-m-d", strtotime($this->fechaInicio));
		$valor2 = date("Y-m-d", strtotime($this->fechaFin));

		/** SECCION 1 */

		$valor3 = "SI";

		$busquedaActivaSI = ControladorReportesFicha::ctrContarBusquedaActiva($valor1, $valor2, $valor3);

		$valor3 = "NO";

		$busquedaActivaNO = ControladorReportesFicha::ctrContarBusquedaActiva($valor1, $valor2, $valor3);

		/** SECCION 2 */

		$valor3 = "F";

		$sexo_femenino = ControladorReportesFicha::ctrContarSexoPaciente($valor1, $valor2, $valor3);

		$valor3 = "M";

		$sexo_masculino = ControladorReportesFicha::ctrContarSexoPaciente($valor1, $valor2, $valor3);

		/** SECCION 3 */

		$valor3 = "PERSONAL DE SALUD";

		$personal_salud = ControladorReportesFicha::ctrContarOcupacion($valor1, $valor2, $valor3);

		$valor3 = "PERSONAL DE LABORATORIO";

		$personal_laboratorio = ControladorReportesFicha::ctrContarOcupacion($valor1, $valor2, $valor3);

		$valor3 = "TRABAJADOR PRENSA";

		$trabajador_prensa = ControladorReportesFicha::ctrContarOcupacion($valor1, $valor2, $valor3);

		$valor3 = "FF.AA.";

		$ff_aa = ControladorReportesFicha::ctrContarOcupacion($valor1, $valor2, $valor3);

		$valor3 = "POLICIA";

		$policia = ControladorReportesFicha::ctrContarOcupacion($valor1, $valor2, $valor3);

		$otra_ocupacion = ControladorReportesFicha::ctrContarOtraOcupacion($valor1, $valor2);

		/** SECCION 4 */

/* 		$valor3 = "SI";

		$vacunaSI = ControladorReportesFicha::ctrContarVacunaInfluenza($valor1, $valor2, $valor3);

		$valor3 = "NO";

		$vacunaNO = ControladorReportesFicha::ctrContarVacunaInfluenza($valor1, $valor2, $valor3);

		$valor3 = "SI";

		$viajeSI = ControladorReportesFicha::ctrContarViajeRiesgo($valor1, $valor2, $valor3);

		$valor3 = "NO";

		$viajeNO = ControladorReportesFicha::ctrContarViajeRiesgo($valor1, $valor2, $valor3);
 */
		$valor3 = "SI";

		$contactoSI = ControladorReportesFicha::ctrContarContactoCovid($valor1, $valor2, $valor3);

		$valor3 = "NO";

		$contactoNO = ControladorReportesFicha::ctrContarContactoCovid($valor1, $valor2, $valor3);
		
		/** SECCION 5*/

		$valor3 = "TOS SECA";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$tos_seca = $malestares[0]["tos_seca"];

		
		$valor3 = "FIEBRE";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$fiebre = $malestares[0]["fiebre"]; 

		$valor3 = "MALESTAR GENERAL";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$malestar = $malestares[0]["malestar_general"]; 

		$valor3 = "CEFALEA";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$cefalea = $malestares[0]["cefalea"];

		$valor3 = "DIFICULTAD RESPIRATORIA";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$dif_respiratoria = $malestares[0]["dificultad_respiratoria"];

		$valor3 = "MIALGIAS";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$mialgias = $malestares[0]["mialgias"];

		$valor3 = "DOLOR DE GARGANTA";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$dolor_garganta = $malestares[0]["dolor_garganta"];
		
		$valor3 = "PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$perd_olfato = $malestares[0]["perdida_olfato"];

		$valor3 = "SINTOMATICO";
		$malestares = ControladorReportesFicha::ctrContarSintomaticoAsintomatico($valor1, $valor2, $valor3);
		$sintomatico = $malestares["sintoAsinto"];

		$valor3 = "ASINTOMATICO";
		$malestares = ControladorReportesFicha::ctrContarSintomaticoAsintomatico($valor1, $valor2, $valor3);
		$asintomatico = $malestares["sintoAsinto"];

		$valor3 = "OTROS";
		$malestares = ControladorReportesFicha::ctrContarMalestar($valor1, $valor2, $valor3);
		$malestares_otros = $malestares[0]["otros"];

		/** SECCION 6*/

		$valor3 = "LEVE";

		$estadoPacienteLeve = ControladorReportesFicha::ctrContarEstadoPaciente($valor1, $valor2, $valor3);

		$valor3 = "GRAVE";

		$estadoPacienteGrave = ControladorReportesFicha::ctrContarEstadoPaciente($valor1, $valor2, $valor3);

		$valor3 = "FALLECIDO";

		$estadoPacienteFallecido = ControladorReportesFicha::ctrContarEstadoPaciente($valor1, $valor2, $valor3);

		/** SECCION 7*/

		/* $valor3 = "IRA";  */
		$valor3 = "GRIPAL/IRA/BRONQUITIS";
		$diagnostico_ira = ControladorReportesFicha::ctrContarDiagnostico($valor1, $valor2, $valor3);

		$valor3 = "IRAG";

		$diagnostico_irag  = ControladorReportesFicha::ctrContarDiagnostico($valor1, $valor2, $valor3);

		$valor3 = "NEUMONIA";

		$diagnostico_neumonia  = ControladorReportesFicha::ctrContarDiagnostico($valor1, $valor2, $valor3);

		$otro_diagnostico = ControladorReportesFicha::ctrContarOtroDiagnostico($valor1, $valor2);


		// echo $tos_seca." ".$fiebre." ".$malestar;

		// var_dump($malestares);

		$datosJson = '{
			"data": [';

		$datosJson .='
			"'.$busquedaActivaSI["busqueda_activa"].'",	
			"'.$busquedaActivaNO["busqueda_activa"].'",
			"'.$sexo_femenino["sexo"].'",	
			"'.$sexo_masculino["sexo"].'",
			"'.$personal_salud["ocupacion"].'",
			"'.$personal_laboratorio["ocupacion"].'",
			"'.$trabajador_prensa["ocupacion"].'",
			"'.$ff_aa["ocupacion"].'",
			"'.$policia["ocupacion"].'",
			"'.$otra_ocupacion["ocupacion"].'",
			"'.$contactoSI["contacto_covid"].'",
			"'.$contactoNO["contacto_covid"].'",
			"'.$tos_seca.'",
			"'.$fiebre.'",
			"'.$malestar.'",
			"'.$cefalea.'",
			"'.$dif_respiratoria.'",
			"'.$mialgias.'",
			"'.$dolor_garganta.'",
			"'.$perd_olfato.'",
			"'.$sintomatico.'",		
			"'.$asintomatico.'",
			"'.$malestares_otros.'",
			"'.$estadoPacienteLeve["estado_paciente"].'",
			"'.$estadoPacienteGrave["estado_paciente"].'",
			"'.$estadoPacienteFallecido["estado_paciente"].'",
			"'.$diagnostico_ira["diagnostico_clinico"].'",
			"'.$diagnostico_irag["diagnostico_clinico"].'",
			"'.$diagnostico_neumonia["diagnostico_clinico"].'",
			"'.$otro_diagnostico["diagnostico_clinico"].'"
		';

		$datosJson .= ']
		}';	

		$dataJson2 = array();
		array_push($dataJson2, $busquedaActivaSI["busqueda_activa"]);	
		array_push($dataJson2, $busquedaActivaNO["busqueda_activa"]);
		array_push($dataJson2, $sexo_femenino["sexo"]);	
		array_push($dataJson2, $sexo_masculino["sexo"]);
		array_push($dataJson2, $personal_salud["ocupacion"]);
		array_push($dataJson2, $personal_laboratorio["ocupacion"]);
		array_push($dataJson2, $trabajador_prensa["ocupacion"]);
		array_push($dataJson2, $ff_aa["ocupacion"]);
		array_push($dataJson2, $policia["ocupacion"]);
		array_push($dataJson2, $otra_ocupacion["ocupacion"]);
		array_push($dataJson2, $contactoSI["contacto_covid"]);
		array_push($dataJson2, $contactoNO["contacto_covid"]);
		array_push($dataJson2, $tos_seca);
		array_push($dataJson2, $fiebre);
		array_push($dataJson2, $malestar);
		array_push($dataJson2, $cefalea);
		array_push($dataJson2, $dif_respiratoria);
		array_push($dataJson2, $mialgias);
		array_push($dataJson2, $dolor_garganta);
		array_push($dataJson2, $perd_olfato);
		array_push($dataJson2, $sintomatico);
		array_push($dataJson2, $asintomatico);
		array_push($dataJson2, $malestares_otros);
		array_push($dataJson2, $estadoPacienteLeve["estado_paciente"]);
		array_push($dataJson2, $estadoPacienteGrave["estado_paciente"]);
		array_push($dataJson2, $estadoPacienteFallecido["estado_paciente"]);
		array_push($dataJson2, $diagnostico_ira["diagnostico_clinico"]);
		array_push($dataJson2, $diagnostico_irag["diagnostico_clinico"]);
		array_push($dataJson2, $diagnostico_neumonia["diagnostico_clinico"]);
		array_push($dataJson2, $otro_diagnostico["diagnostico_clinico"]);

	   if($this-> exportar == "false")
		   echo $datosJson;
	   else return $dataJson2 ;
	}
}

/*=============================================
MOSTRAR REPORTE FICHA POR FECHAS DE TOMA DE MUESTRA
=============================================*/

if (isset($_POST["reporte"])) {
    
	$reportesCovid = new AjaxReportesFicha();
	$reportesCovid -> fechaInicio = $_POST["fechaInicio"];
	$reportesCovid -> fechaFin = $_POST["fechaFin"];
	$reportesCovid -> exportar =  $_POST["exportar"];
	$reportesCovid -> ajaxMostrarReportesFichaFechas();
}

