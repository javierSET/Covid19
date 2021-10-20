<?php

	/* Controladores */
require_once "../controladores/personas_notificadores.controlador.php";
require_once "../controladores/covid_resultados.controlador.php";
require_once "../controladores/departamentos.controlador.php";
require_once "../controladores/establecimientos.controlador.php";
require_once "../controladores/localidades.controlador.php";
require_once "../controladores/usuarios.controlador.php";

	/* MODELOS */
require_once "../modelos/personas_notificadores.modelo.php";
require_once "../modelos/covid_resultados.modelo.php";
require_once "../modelos/departamentos.modelo.php";
require_once "../modelos/establecimientos.modelo.php";
require_once "../modelos/localidades.modelo.php";
require_once "../modelos/usuarios.modelo.php";

@include('../funciones/funcionesAuxiliares.php');
require_once("../extensiones/tcpdf/tcpdf.php");
require_once "../extensiones/phpqrcode/qrlib.php";

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
	}

    // Page footer
    public function Footer() {    
    }
}

class AjaxReporteCovid {
	
	public $file;
	public $id_ficha;

	public function ajaxEliminarReportePDF(){	
		$file = $this->file;
		unlink('../'.$file);
	}



	/*=============================================
	MOSTRAR EN PDF RESULTADO COVID
	=============================================*/	

	public function ajaxMostrarReporteCovidPDF(){


		/*=============================================
	    			 DATOS DEL PACIENTE
		=============================================*/		
		
		$item = "id_ficha";
		$valor = $this->id_ficha;		
		$fichaReporteCovi= ControladorCovidResultados::ctrMostrarCovidResultados($item,$valor);
		$edad = calculaedad($fichaReporteCovi['fecha_nacimiento']);
		

		/*=============================================
	    	BUSCAR AL MEDICO POR ID
		=============================================*/
		$item = "id_ficha";
		$valor = $this->id_ficha;
		$persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item,$valor);
			

		/*=============================================
	    	 DATOS DEL ESTABLECIMIENTO
		=============================================*/		

		$valor_establecimiento = $fichaReporteCovi['id_establecimiento'];
		$establecimiento= ControladorEstablecimientos::ctrMostrarEstablecimientos('id',$valor_establecimiento);

		// Extend the TCPDF class to create custom Header and Footer

		$pdf = new MYPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('Resultado del Laboratorio'.$valor);
		$pdf->SetSubject('Resultado del Laboratorio Covid-19 CNS');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, Ficha Epidemiologica,Covid-19');

		$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);

		// add a page
		$pdf->AddPage();

		$content = '';

		  $content .= '
		  <html lang="es">
				<head>
					<style>
					.contenido{
						font-size: 24px;
						font-family: "Times New Roman", Times, serif;
					}
					.cuerpo{
						border: solid 5px black;
					}
					</style>
				</head>
				<body>
					<div class="cuerpo">
						<header>
							<table cellpadding="2">
								<tr>
									<td width="10%" align="center">
										<img src="../vistas/img/cns/logo-CNS.png" height="55px" style="margin: 0 auto;"/>
									</td>
									<td width="80%" align="center">
										<tr heigth="100">										
										</tr>
										<h3 class="titulo">LABORATORIO CLINICO CAJA NACIONAL DE SALUD INFORME DE LABORATORIO</h3>
									</td>
									<td width="10%">';
										$dir ="../temp/cod_qr/";
										if (!file_exists($dir))
											mkdir($dir);
										$filename = $dir.'laboratorio.png';
										$tamaño = 10; //Tamaño de Pixel
										$level = 'H'; //Precisión alta
										$framSize = 3; //Tamaño en blanco										
										$contenido = 'COD. FICHA: '.$this->id_ficha."\n"; // texto
											//Enviamos los parametros a la Función para generar código QR 
										QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
											//Mostramos la imagen generada
										$content .=									
										'<img src="'.$dir.basename($filename).'" />	
									</td>
								</tr>
							</table>
						</header>
						<div class="contenido">				
							<table border="0" cellpadding="3">
								<tr>
									<td width="70%">
										<label class="">Apellido(s) y Nombre(s):  '.$fichaReporteCovi['paterno'].' '.$fichaReporteCovi['materno'].' '.$fichaReporteCovi['nombre'].'</label>
									</td>
									<td width="30%">
										<label class="">Edad:  '.$edad.'</label>
									</td>
								</tr>
								<tr>
									<td width="">
										<label class="">N° Carnet de Indentidad:  '.$fichaReporteCovi['documento_ci'].'</label>
									</td>
								</tr>
								<tr>
									<td width="">
										<label class="">N° Asegurado:  '.$fichaReporteCovi['cod_asegurado'].'</label>
									</td>
								</tr>
								<tr>
									<td width="">
										<label class="">Cod. Beneficiario:  '.$fichaReporteCovi['cod_afiliado'].'</label>
									</td>
								</tr>								
								<tr>
									<td>
										<label> Médico Solicitante:  '.$persona_notificador['nombre_notificador'].' '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].'</label>
									</td>
								</tr>
								<tr>
									<td>
										<label class="">Establecimiento de salud:  '.$establecimiento['nombre_establecimiento'].'</label>
									</td>
								</tr>
								<tr>
									<td>
										<label class="">Fecha de Solicitud:  '.date('d-m-Y',strtotime($fichaReporteCovi['fecha_muestra'])).'</label>
									</td>
								</tr>
							</table>
							<table border="0">
								<tr>
									<td width="15%" height="20">
									</td>
									<td width="70%">';
										if($fichaReporteCovi['metodo_diagnostico_pcr_tiempo_real']=="RT-PCR en tiempo Real"){
											$content .='<strong>PRUEBA RT-PCR EN TIEMPO REAL: SARS-COV-2</strong>';
										}
										else if($fichaReporteCovi['metodo_diagnostico_pcr_genexpert']=="RT-PCR GENEXPERT"){
											$content .='<strong>PRUEBA RT-PCR GENEXPERT: SARS-COV-2</strong>';
										}
										else if($fichaReporteCovi['metodo_diagnostico_prueba_antigenica']=="Prueba Antigénica"){
											$content .='<strong>PRUEBA RAPIDA CUALITATIVA DE ANTIGENOS: SARS-COV-2</strong>';
										}										
										$content.='
									</td>
									<td width="15%">
									</td>
								</tr>
							</table>						
							<table border="0">					    	
								<tr>
									<td width="10%" height="20">								
									</td>
									<td width="15%">
										<label class="">RESULTADO: </label>
									</td>
									<td width="25%">
										<label class=""><strong><span>'.$fichaReporteCovi['resultado'].'</span></strong></label>
									</td>
									<td width="50%">
									</td>					    		
								</tr>
							</table>
							<table border="0" cellpadding="3">
								<tr>
									<td width="10%" height="20">								
									</td>
									<td width="90%">
										<label class=""><strong>Nota: </strong> Para la interpretacion de resultados se deberá tomar en cuenta los datos colectados en la ficha epidemiológica, además de la fecha y tiempo de la realización de la toma de muestra.</label>
									</td>
								</tr>
							</table>
							<table border="0" cellpadding="1">
								<tr>
									<td width="5%">
									</td>							 
									<td width="55%">
										<label class="">Responsable del Análisis:   '.$fichaReporteCovi['responsable_muestra'].'</label>
									</td>
									<td width="40%">
										<label class="">Fecha:  '.date('d-m-Y',strtotime($fichaReporteCovi['fecha_resultado'])).'</label>
									</td>
								</tr>
							</table>								
						</div>
					</div>					
				</body>
			</html>';

			$pdf->writeHTML($content, true, 0, true, true);
		
			$direc ="../temp/".$fichaReporteCovi['cod_afiliado']."/";
			if (!file_exists($direc)){
				mkdir($direc);
			}
			$pdf->output($direc."resultado-laboratorio-".$valor.'.pdf', "F");
		
	}
}

/*=============================================
MOSTRAR REPORTE PDF POR FECHA DE RESULTADO Y TIPO DE RESULTADO COVID EN PDF
=============================================*/
if (isset($_POST["fichaCovidResultado"])) {
	$reporteCovid = new AjaxReporteCovid();
	$reporteCovid->id_ficha  =  $_POST["idFicha"];
	$reporteCovid ->ajaxMostrarReporteCovidPDF();
}

?>
