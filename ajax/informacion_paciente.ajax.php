<?php

require_once "../controladores/covid_resultados.controlador.php";
require_once "../controladores/formulario_bajas.controlador.php";
require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../controladores/personas_notificadores.controlador.php";
require_once "../controladores/datos_clinicos.controlador.php";
require_once "../controladores/malestar.controlador.php";
require_once "../controladores/establecimientos.controlador.php";
require_once "../controladores/formulario_alta_manual.controlador.php";
require_once "../controladores/formulario_bajas_externos.controlador.php";

require_once "../modelos/covid_resultados.modelo.php";
require_once "../modelos/formulario_bajas.modelo.php";
require_once "../modelos/pacientes_asegurados.modelo.php";
require_once "../modelos/personas_notificadores.modelo.php";
require_once "../modelos/datos_clinicos.modelo.php";
require_once "../modelos/malestar.modelo.php";
require_once "../modelos/establecimientos.modelo.php";
require_once "../modelos/formulario_altas_manual.modelo.php";
require_once "../modelos/formulario_bajas_externos.modelo.php";


require_once "../extensiones/tcpdf/tcpdf.php";
require_once "../extensiones/phpqrcode/qrlib.php";

require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";

// incluye funciones para obtener la fecha literal
@include "../funciones/funcionesAuxiliares.php";

session_start();

/*==================================================
	Clase para generar la impresio del PDF de concentiiento de paciente
 ===================================================*/
class AjaxConcentimiento{

	public $id_ficha;

	public function ajaxMostarInformacionPaciente(){

		$valor = $this->id_ficha;


	/*===================================================================
			BUSCAR PACIENTE ASEGURADO
	  ====================================================================*/
		$item = "id_ficha";
	  	$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item,$valor);

		if(!$paciente_asegurado){ // Se modifico por la duplicidad
			$ficha = ControladorFichas::ctrMostrarFichas('id_ficha', $valor);
			$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $ficha['id_paciente']);
		}
		  
		//var_dump($paciente_asegurado);
		$persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item, $valor);
		//var_dump($persona_notificador);
		
		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('Concentimiento '.$valor);
		$pdf->SetSubject('Concentimiento paciente');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, concentimiento,Covid-19');

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('Helvetica', '', 8);

		// add a page
		$pdf->AddPage();

		$content = '
		<html lang="en">
			<head>
				<style>
					.contenido{
					}
					.header{						
					}
					.caja {
					}
				</style>					
			</head>
			<body>
				<header>
					<table border="0" cellpadding="3">
						<tr>
							<td width="10%" align="center">
							<img src="../vistas/img/cns/logo-CNS.png" height="55px" style="margin: 0 auto;"/>
							</td>
							<td width="80%" align="center">
								<h2>HOJA DE INFORMACION AL PACIENTE Y CONSENTIMIENTO INFORMADO PARA CUMPLIR AISLAMIENTO DOMICILIARIO COVID-19</h2>
							</td>
							<td width="10%">';
								$dir ="../temp/cod_qr/";
								if (!file_exists($dir))
									mkdir($dir);
								$filename = $dir.'certConsentimiento.png';
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
						<tr>
							<td>
							</td>
							<td>
								<span>Reparticion:</span>
							</td>
							<td>
								<span>Cite Nº</span>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<h3>INFORMACION PARA EL PACIENTE</h3>
							</td>
						</tr>
					</table>
				</header>
				<div class="contenido">
					<p style="text-align: justify;">
						Ante la expansión de COVID-19, se han dispuesto varias normas para contener la enfermedad, 
						empezando por la cuarentena general dispuesta por el Gobierno del Estado plurinacional de 
						Bolivia, también el Ministerio de Salud de Bolivia ha dejado normas claras en cuanto a 
						las acciones a tomar en situación de contactos, de pacientes sospechosos y pacientes 
						confirmados, como el distanciamiento social que en el primer caso se denominara cuarentena y 
						en cuestión de sospecha y confirmación de caso se llamara <strong>aislamiento</strong>. Ambas 
						<strong> consisten en la restricción de movimiento, desplazamiento o actividades o la separación 
						de personas que no están enfermas, pero que pueden estar expuestas a un agente infeccioso o 
						a enfermedad, con el objetivo de evitar, disminuir o retrasar la transmisión, en este caso, COVID-19.</strong>
					</p>

					<p style="text-align: justify;">
						El 25 de marzo mediante un comunicado oficial del Ministerio de Justicia y Transparencia Institucional 
						se informa que la población que incumpla la cuarentena podría ser sancionada por privación de libertad 
						de 1 a 10 años, disposición amparada en el artículo 216 del código penal que establece la sanción 
						para quien propague enfermedades graves o contagios, ocasione epidemias o realice cualquier acto que afecte la salud de la población.
					</p>

					<p>
						Para realizar el aislamiento domiciliario, es necesario cumplir con algunas condiciones básicas de importancia:
						<ol start="1">
							<li>
								Tener un cuarto aislado exclusivo con baño privado o cerca al cuarto
							</li>
							<li>
								Contar con una persona que pueda cuidarlo en su domicilio
							</li>
						</ol>
						<strong>En este contexto y teniendo conocimiento de la información precedente:</strong>
					</p>
					
					<table border="0">
						<tr>
							<td width="70%">
								<label for="">Yo (Paciente): '.$paciente_asegurado['nombre'].' '.$paciente_asegurado['paterno'].' '.$paciente_asegurado['materno'].'</label> 
							</td>
							<td width="30%">
								<label for="">con C.I. :  '.$paciente_asegurado['nro_documento'].'</label>
							</td>							
						</tr>
						<tr>
							<td width="70%">
								<label for=""> Yo (apoderado): '.$paciente_asegurado['nombre_apoderado'].'</label>
							</td>
							<td width="30%">
								<label for="">con Telefono:  '.$paciente_asegurado['telefono_apoderado'].'</label>
							</td>							
						</tr>
						<tr>
							<td width="70%">
								<label for=""> con domicilio: '
									.'  Zona: '.$paciente_asegurado['zona']
									.'  Calle: '.$paciente_asegurado['calle']
									.'  Nro: '.$paciente_asegurado['nro_calle'].'</label>
							</td>
							<td width="30%">
								<label for="">numero de teléfono :  '.$paciente_asegurado['telefono'].'</label>
							</td>							
						</tr>
					</table>					
					<p>
					</p>
					<p>
						Consultado con el/la Dr(a). '.$persona_notificador['nombre_notificador'].' '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].' y me ha informado acerca de la posible enfermedad que puedo 
						cursar COVID-19 y me encuentro catalogado como CASO SOSPECHOSO. Se me ha informado sobre los cuidados que debo 
						realizar durante este tiempo, también de las sanciones en caso de no cumplir con el aislamiento domiciliario estricto.
					</p>
					<p>
						Por lo tanto, doy mi consentimiento para el control domiciliario, hospitalario y toma de muestra, correspondiente y me 
						comprometo a cumplir todas las normas establecidas para evitar el contagio colectivo cumpliendo estrictamente el 
						protocolo de la cuarentena impuesta por la Autoridad de Salud del Gobierno del Estado Plurinacional de Bolivia 
						y admito que cumplo con todos los requisitos para realizar aislamiento domiciliario.
					</p>
					<p>
						En caso de no cumplir o transgredir el aislamiento, asumiré todos los costos y gastos que se hubieren realizado, incluso 
						los gastos que se generen en las personas con las que me relacione y se compruebe de forma posterior que contrajeron COVID 19.   
					</p>
					<p>
                        <em><strong> Croquis de su Domicilio: </strong></em>
                    </p>
					<table border="0">
						<tr>
							<td width="10%"></td>
							<td width="80%">
								<table border="0">
									<tr>
										<td width="25%" height="50" border="1"></td>
										<td width="2%"></td>
										<td width="25%" height="50" border="1"></td>
										<td width="2%"></td>
										<td width="25%" height="50" border="1"></td>
										<td width="2%"></td>
										<td width="25%" height="50" border="1"></td>
									</tr>
									<tr>
										<td></td>
									</tr>
									<tr>
										<td width="25%" height="50" border="1"></td>
										<td width="2%"></td>
										<td width="25%" height="50" border="1"></td>
										<td width="2%"></td>
										<td width="25%" height="50" border="1"></td>
										<td width="2%"></td>
										<td width="25%" height="50" border="1"></td>
									</tr>
								</table>
							</td>
							<td width="10%"></td>
						
						</tr>
					</table>

					<table border="0">
						<tr>
							<td width="50%" height="60"></td>
							<td></td>
						</tr>
						<tr>
							<td width="50%" align="center;">
								<label for=""> Firma del Paciente</label><br>
								<label for="">'.$paciente_asegurado['nombre'].' '.$paciente_asegurado['paterno'].' '.$paciente_asegurado['materno'].'</label><br>
								<label for="">C.I.: '.$paciente_asegurado['nro_documento'].'</label>
							</td>
							<td width="50%" align="center;">
								<label for=""> Sello y Firma del Medico</label><br>
									<label for="">'.$persona_notificador['nombre_notificador'].' '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].'</label>
								</td>
						</tr>
					</table>
				</div>    
			</body>
		</html>
		';


		// Reconociendo la estructura HTML
		$pdf->writeHTML($content, false, 0, false, false,"L");

		$direc ="../temp/".$paciente_asegurado['cod_afiliado']."/";
		if (!file_exists($direc)){
			mkdir($direc);
		}
		//$pdf->output($direc.'ficha-epidemiologica-'.$valor.'.pdf', 'F');
		$pdf->output($direc.'consentimiento-'.$valor.'.pdf', 'F');
	}
}

/*==================================================
	Clase para generar la impresion del PDF de concentiiento de paciente
 ===================================================*/
 class AjaxCertificadoMEdico{

	public $id_ficha;
	public $numdias;

	public function ajaxMostarCertificadoMedico(){

		$valor = $this->id_ficha;
        $numeroDiasCertificado = $this->numdias;

		/*===================================================================
			BUSCAR PACIENTE ASEGURADO
	  ====================================================================*/
		$item = "id_ficha";
	  	$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item,$valor);
		//var_dump($paciente_asegurado);
		$persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item, $valor);

		$datos_clinicos = ControladorDatosClinicos::ctrMostrarDatosClinicos($item,$valor);
		$malestar = ControladorMalestar::ctrMostrarMalestar($valor);
		
		
		$hoy =  obtenerFechaEnLetra(date('d-m-Y'));
		//var_dump($hoy);
		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('Certificado Medico-'.$valor);
		$pdf->SetSubject('Certificado MEdico');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, certificado, medico,Covid-19');

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$pdf->SetMargins(6.35, 6.35, 6.35, 0);
		$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);

		// set font
		$pdf->SetFont('Helvetica', '', 8);

		// add a page
		$pdf->AddPage();

		$content = '
		<html lang="en">
			<head>
				<style>
					.contenido{
						//border: 1px solid blue;
						
					}
					.negrita{
						font-weight: bold;
					}
					.header{						
					}
				</style>					
			</head>
			<body>
				<header>
					<table border="0" cellpadding="2">
						<tr>
							<td width="10%" align="center">
								<img src="../vistas/img/cns/logo-CNS.png" height="55px" style="margin: 0 auto;"/>
							</td>
							<td width="80%" align="center">
								<H1>CAJA NACIONAL DE SALUD REGIONAL COCHABAMBA</H1>																
							</td>
							<td width="10%">';
								$dir ="../temp/cod_qr/";
								if (!file_exists($dir))
									mkdir($dir);
								$filename = $dir.'certMedico.png';
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
					<p  align="center">
						<h1 class="titulo">CERTIFICADO MEDICO (COVID-19)</h1>
					</p>
					<p>
						EL SUSCRITO MEDICO DE LA CAJA NACIONAL DE SALUD.
					</p>
					<P>
						CERTIFICA QUE EL PACIENTE:
					</P>
					<table border="0">
						<tr>
							<td colspan="2" width="60%">
								<label for=""><span class="negrita">NOMBRES Y APELLIDOS:</span> '.$paciente_asegurado['nombre'].' '.$paciente_asegurado['paterno'].' '.$paciente_asegurado['materno'].'</label>
							</td>                
							<td width="40%">
								<Label><span class="negrita">Edad:</span> '.$paciente_asegurado['edad'].'</Label>
							</td>
						</tr>
						<tr>
							<td width="40%">';
								if($paciente_asegurado['sexo']=="M"){
									$content .=
										'<label for="" class="negrita">Masculino:</label>
										<label for="" style="border: 1px solid black;">X</label>    
										<label for="" class="negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Femenino</label>
										<label for="" style="border: 1px solid black;"></label>
									';
								}
								else if($paciente_asegurado['sexo']=="F"){
									$content .=
										'<label for="" class="negrita">Masculino:</label>
										<label for="" style="border: 1px solid black;"></label>
										<label for="" class="negrita">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Femenino</label>
										<label for="" style="border: 1px solid black;">X</label> 
									';
								}
								$content .=
							'</td>
							<td width="20%">
								<label for=""><span class="negrita">Telefono:</span> '.$paciente_asegurado['telefono'].'</label>
							</td>
							<td width="40%">
								<label for=""><span class="negrita">Direccion : </span>'
								.'  Zona: '.$paciente_asegurado['zona']
								.'  Calle: '.$paciente_asegurado['calle']
								.'  Nro: '.$paciente_asegurado['nro_calle'].'
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<label for=""><span class="negrita">Nº DE ASEGURADO: '.$paciente_asegurado['cod_asegurado'].'</label>
							</td>
							<td>
								<label for=""><span class="negrita">C.I.:</span> '.$paciente_asegurado['nro_documento'].'</label>
							</td>
							<td>
								<label for=""><span class="negrita">EMPRESA:</span> '.$paciente_asegurado['nombre_empleador'].'</label>                    
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<label for="" class="negrita">ACUDE A: .............................</label>                
							</td>                
						</tr>
					</table>

					<p>
						Se considera <em><strong>SOSPECHOSO de INFECCIÓN por COVID-19</strong></em>
					</p>
					<p>
						<strong>Al momento el paciente presenta:</strong>
					</p>

					<table border="0" width="500" aling="center">
						<tr>
							<td width="45%">
								<label for="">Sintomatico: </label>
							</td>
							<td width="5%">';
								if($datos_clinicos['sintoma']=="SINTOMATICO"){
									$content .=
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=
										'<label for=""></label>
									';
								}
								$content .=							
							'</td>
							<td width="45%">
								<label for="">Asintomatico:</label>
							</td>
							<td width="5%">';
								if($datos_clinicos['sintoma']=="ASINTOMATICO"){	
									$content .=
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=
										'<label for=""></label>
									';
								}
								$content .=
							'</td>							
						</tr> 
						<tr>
							<td>
								<label for="">Fiebre: </label>
							</td>
							<td>';
								if($malestar['fiebre']=="FIEBRE"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
							<td>
								<label for="">Dolor de garganta: </label>
							</td>
							<td>';
								if($malestar['dolor_garganta'] =="DOLOR DE GARGANTA"){	
									$content .=
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
						</tr>
						<tr>
							<td>
								<label for="">Tos: </label>
							</td>
							<td>';
								if($malestar['tos_seca']=="TOS SECA"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
							<td>
								<label for="">Malestar general: </label>
							</td>
							<td>';
								if($malestar['malestar_general'] == "MALESTAR GENERAL"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
						</tr>
						<tr>
							<td>
								<label for="">Dificultad respiratoria:</label>
							</td>
							<td>';
								if($malestar['dificultad_respiratoria'] == "DIFICULTAD RESPIRATORIA"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
							<td>
								<label for="">Mialgias:</label>
							</td>
							<td>';
								if($malestar['mialgias'] == "MIALGIAS"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
						</tr>
						<tr>
							<td>
								<label for="">Cefalea:</label>
							</td>
							<td>';
								if($malestar['cefalea'] == "CEFALEA"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
							<td>
								<label for="">Dificultad respiratoria</label>
							</td>
							<td>';
								if($malestar['dificultad_respiratoria'] == "DIFICULTAD RESPIRATORIA"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
						</tr>
						<tr>
							<td>
								<label for="">Perdida o disminución del sentido del olfato:</label>
							</td>
							<td>';
								if($malestar['perdida_olfato'] == "PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO"){
									$content .=	
										'<label for=""><strong>X</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
							<td colspan="2">
								<label for="">Otros:      </label>';
								if($malestar['otros'] != ""){
									$content .=	
										'<label for=""><strong>'.$malestar['otros'].'</strong></label>
									';
								}
								else{
									$content .=	
										'<label for=""></label>
									';
								}
								$content .=
							'</td>
						</tr>           
					</table>
					<p></p>

					<p>
						El paciente gozara del aislamiento domiciliario siguiendo las instrucciones descritas en el documento de,
						<strong>“COMPROMISO DEL PACIENTE PARA EL CUMPLIMIENTO DE NORMAS EN CASO DE AISLAMIENTO DOMICILIARIO”, </strong> 
						por el lapso de <strong>
						'; 

						switch ($numeroDiasCertificado) {
		
							case "1":
								$content .= 'Un día.';
								break;
		
							case "2":
								$content .= 'Dos días. ';
								break;
		
							case "3":
								$content .= 'Tres días.';
								break;
		
							case "4":
								$content .= 'Cuatro días.';
								break;
		
							case "5":
								$content .= 'Cinco días.';
								break;										
									
							default: 
								$content .= 'Un dia';
								break;
							}
							$content .= 
		
						'
						</strong> Una vez confirmado el caso, el paciente <em>gozará del Certificado de Incapacidad Temporal.</em>
					</p>
					<p>
						<em>
							Se otorga el presente CERTIFICADO. Para acogerse al PERMISO EXCEPCIONAL. Respaldado por la RESOLUCIÓN 
							BI-MINISTERIAL 001/20 de fecha 13 de marzo 2020. Donde indica en su artículo V Párrafo II 
							“Los casos sospechosos de haber contraído el Coronavirus (COVID-19), gozarán de un PERMISO 
							EXCEPCIONAL en su fuente laboral por el tiempo que dure la medida de observación y aislamiento 
							establecido por la autoridad de salud que corresponde”
						</em>            
					</p>
					<p>
						<em>
							“En aplicación de la resolución Bi-Ministerial 001/20 emitido por el MINISTERIO DE SALUD Y DE TRABAJO, 
							EMPLEO Y PREVISIÓN SOCIAL en su artículo quinto párrafo V y VI, el presente CERTIFICADO MEDICO, 
							documento legal válido para otorgar el PERMISO EXCEPCIONAL, aquellas personas que se vean afectadas 
							por el incumplimiento de lo establecido en el presente Artículo podrán presentar su denuncia ante el 
							Ministerio de Trabajo, Empleo y Previsión Social, con el fin de hacer prevalecer sus derechos.”
						</em>
					</p>

					<table border="0" align="center">
						<tr>
							<td height="30" colspan="3" align="center;">
								<label for="">ES CUANTO CERTIFICO, PARA FINES QUE CONVENGA AL INTERESADO</label>
							</td>
						</tr>
						<tr>
							<td >
								<label for=""></label>
							</td>
							<td height="80">
								<label for="">Cochabamba: ';
									$content .=
										$hoy;									 
									 $content .=
									 '</label>
							</td>
							<td>								
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<label for="">Firma y Sello de Medico</label>
							</td>
						</tr>
					</table>
					
				</div> 
			</body>
		</html>
		';

		$direc = '../temp/' . $paciente_asegurado['cod_afiliado'] . '/';
		
		//$pdf->writeHTML($content, false, 0, false, false,"L");
		$pdf->writeHTML($content, true, 0, true, 0);  

		if (!file_exists($direc)){
			mkdir($direc);
		}

		$pdf->output($direc.'certificado-medico-'.$valor.'.pdf', 'F');
	}	
}

/*==================================================
	Clase para generar la impresion del PDF de Certificado de alta
 ===================================================*/
 class AjaxCertificadoDeAlta{

	public $id_ficha;
	public $id_covid_resultado;

	public function ajaxMostarCertificadoDeAltaPDF(){

		$valor = $this->id_ficha;

		$item = "id_ficha";
		$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item,$valor);		
		if(!$paciente_asegurado){ // Se modifico por la duplicidad
			$ficha = ControladorFichas::ctrMostrarFichas('id_ficha', $valor);
			$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $ficha['id_paciente']);
		}

		$item = "id_ficha";
		$covid_resultado = ControladorCovidResultados::ctrMostrarCovidResultados($item,$valor);
		
		$bajaSospechoso = ControladorBajasExterno::ctrMostrarFormularioBajaExterno("id_ficha",$this->id_ficha);

		$baja = ControladorFormularioBajas::ctrMostrarFormularioBajas("id",$bajaSospechoso["id_formulario_baja"]);
		$fechaIni = ControladorFormularioBajas::ctrBuscarFechaIniFin($baja["id"],$this->id_covid_resultado,"ASC");
		$fechaFin = ControladorFormularioBajas::ctrBuscarFechaIniFin($baja["id"],$this->id_covid_resultado,"DESC");

		$fecha1 = new DateTime($fechaIni["fecha_ini"]);
		$fecha2 = new DateTime($fechaFin["fecha_fin"]);

		$dias = $fecha1->diff($fecha2);

		$total = ControladorFormularioBajas::ctrSumaTodasBajas($baja["id"],$this->id_covid_resultado);
		
		$persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores("id_ficha",$valor);

		$establecimineto = ControladorEstablecimientos::ctrMostrarEstablecimientos("id",$covid_resultado['id_establecimiento']);

		$hoy =  obtenerFechaEnLetra(date('d-m-Y'));

		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('Certificado de Alta '.$valor);
		$pdf->SetSubject('Certificado de Alta');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Certificado, Covid-19');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);
		// set font
		$pdf->SetFont('Helvetica', '', 10);
		// add a page
		$pdf->AddPage();

		$content = '
		<html lang="en">
			<head>
				<style>
					.contenido{
						font-size: 28px;						
					}
					.negrita{
						font-weight: bold;
					}
					.parrafo{
						text-align:justify; 
						line-height: 2em;
					}
					.contenido table{					
					}							
				</style>					
			</head>
			<body>
				<div class="cuerpo">
					<header>
						<table border="0" cellpadding="2">
							<tr>
								<td width="12%" align="center">
									<img src="../vistas/img/cns/cns-logo.png" height="55px" style="margin: 0 auto;"/>
								</td>
								<td width="75%" align="center">									
									<h1>CERTIFICADO DE ALTA MEDICA A PACIENTE COVID-19</h1>									
								</td>
								<td width="13%" aling="center">';
									$dir ="../temp/cod_qr/";
									if (!file_exists($dir))
										mkdir($dir);
									$filename = $dir.'certAlta.png';
									$tamaño = 10; //Tamaño de Pixel
									$level = 'H'; //Precisión alta
									$framSize = 3; //Tamaño en blanco										
									$contenido = 'COD. FICHA: '.$this->id_ficha."\n"; // texto
										//Enviamos los parametros a la Función para generar código QR 
									QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
										//Mostramos la imagen generada
									$content .=									
									'<img src="'.$dir.basename($filename).'" height="55px"/>
								</td>
							</tr>							
						</table>
					</header>
					<table>
						<tr>
							<td height="40">
							</td>
						</tr>
					</table>
					<div class="contenido">
						<table border="0" cellpadding="3">
							<tr>
								<td width="100%">
									<p class="parrafo">A solicitud de la Sra. (a):
										<span class="negrita">'
											.$covid_resultado['nombre'].' '.$covid_resultado['paterno'].' '.$covid_resultado['materno'].' 
										</span>
										con C.I.  
										<span class="negrita">'
											.$covid_resultado['documento_ci'].
										'</span>, con domicilio en Zona: 
										<span class="negrita">'
											.$covid_resultado['zona'].
										'</span>  Calle:  
										<span class="negrita">'
											.$covid_resultado['calle'].'
										</span>  Nº: 
										<span class="negrita">'
											.$covid_resultado['nro_calle'].
										'</span> asegurada/o a la Caja Nacional de Salud con Matricula Nº: 
										<span class="negrita"> '
											.$covid_resultado['cod_asegurado'].
										'</span>, Por la empresa
										<span class="negrita">'
											.$covid_resultado['nombre_empleador'].'
										</span>
										con resultado: <span class="negrita">'.$covid_resultado['resultado'].'</span> para COVID-19
										por la prueba molecular 

										<span class="negrita">';
											if($covid_resultado['metodo_diagnostico_pcr_tiempo_real']!=""){
												$content .= $covid_resultado['metodo_diagnostico_pcr_tiempo_real'];											
											}
											else if($covid_resultado['metodo_diagnostico_pcr_genexpert']!=""){
												$content .= $covid_resultado['metodo_diagnostico_pcr_genexpert'];											
											}
											else if($covid_resultado['metodo_diagnostico_prueba_antigenica']!=""){
												$content .= $covid_resultado['metodo_diagnostico_prueba_antigenica'];
											}else{
												$content .='';
											}

											$content .='
										</span> en el Laboratorio de Biología Molecular
										<span class="negrita">'.$establecimineto['nombre_establecimiento'].'.</span>
										, en fecha</span>
										<span class="negrita">'
											.date('d-m-Y',strtotime($covid_resultado['fecha_muestra'])).'
									</p>
								</td>
							</tr>																		
							<tr>
								<td>
									<p class="parrafo">El paciente cumplió con el compromiso de aislamiento domiciliario
										por el tiempo de: <span class="negrita">'. ($dias->days+1).' Dias</span>   
										del <span class="negrita">'.date('d-m-Y', strtotime($fechaIni['fecha_ini'])).'</span>  
										al <span class="negrita">'.date("d-m-Y", strtotime($fechaFin['fecha_fin'])).'.</span>
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<H4>ALTA POR CRITERIO CLINICO Y EPIDEMIOLOGICO</H4>
								</td>
							</tr>
							<tr>
								<td height="30">
								</td>
							</tr>
							<tr>
								<td colspan="3" style="text-align: justify;">
									<p class="parrafo">
										El que certifica, es el personal de salud de la Caja Nacional de Salud
										del <strong>'.$establecimineto['nombre_establecimiento'].'</strong> que realizo el control 
										Del paciente, según expediente clinico que acredita constituye un conjunto de documentos
										escritos de orden médico legal.
									</p>
								</td>
							</tr>
							<tr>
								<td>
								</td>
							</tr>
							<tr>
								<td colspan="3" style="text-align: justify;">
									<p class="parrafo">
										En base y al Instructivo del SEDES Cochabamba <strong>Nº CITE/UR/DN-B-E. SP/89/2020
										del 26 de junio 2020 y recomendaciones de la OMS y OPS se procede a dar el
										<strong>ALTA MEDICA. </strong> </strong>
									</p>
								</td>
							</tr>
					
							<tr>
								<td height="80">
								</td>
							</tr>
							<tr>
								<td width="20%">
									
								</td>
								<td width="60%">
									<label style="text-align: center; font-size:28px;"><strong>Cochabamba,  '.$hoy.'</strong></label>
								</td>
								<td width="20%">
									
								</td>
							</tr>
							<tr>
								<td height="100">
								</td>
							</tr>
							<tr>
								<td width="50%">DR. '.$persona_notificador['nombre_notificador'].' '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].'</td>
								<td width="50%">'.$establecimineto['nombre_establecimiento'].'</td>
							</tr>
						</table>						
					</div>
				</div>
			</body>
		</html>';
		// Reconociendo la estructura HTML
		$pdf->writeHTML($content, false, 0, false, false,"L");

		$direc ="../temp/".$paciente_asegurado['cod_afiliado']."/";
		if (!file_exists($direc)){
			mkdir($direc);
		}
		//$pdf->output($direc.'ficha-epidemiologica-'.$valor.'.pdf', 'F');
		$pdf->output($direc.'certificado-alta-'.$valor.'.pdf', 'F');		
	}

}


/*==================================================
	Clase para generar la impresio del PDF de Certificado de alta para pacientes Descartados
 ===================================================*/
 class AjaxCertificadoDeAltaDescartado{

	public $id_ficha;

	public function ajaxMostarCertificadoDeAltaDescartadoPDF(){

		$valor = $this->id_ficha;

		$item = "id_ficha";
		$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item,$valor);
	
		if(!$paciente_asegurado){ // Se modifico por la duplicidad
			$ficha = ControladorFichas::ctrMostrarFichas('id_ficha', $valor);
			$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $ficha['id_paciente']);
		}

		$item = "id_ficha";
		$covid_resultado = ControladorCovidResultados::ctrMostrarCovidResultados($item,$valor);
		
		$item = "id_covid_resultado";
		$valor1 = $covid_resultado["id"];

		$baja = ControladorFormularioBajas::ctrMostrarFormularioBajas($item,$valor1);

		$persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores("id_ficha",$valor);
		$establecimineto = ControladorEstablecimientos::ctrMostrarEstablecimientos("id",$covid_resultado['id_establecimiento']);

		$hoy =  obtenerFechaEnLetra(date('d-m-Y'));

		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('Certificado de Alta '.$valor);
		$pdf->SetSubject('Certificado de Alta');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Certificado, Covid-19');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);
		// set font
		$pdf->SetFont('Helvetica', '', 14);
		$pdf->SetLeftMargin(12);
		// add a page
		$pdf->AddPage();
		
		$content = '
		<html lang="en">
			<head>
				<style>
					.contenido{
						font-size: 28px;						
					}
					.negrita{
						font-weight: bold;
					}
					.parrafo{
						text-align:justify; 
						line-height: 2em;
					}
					.contenido table{					
					}							
				</style>					
			</head>
			<body>
				<div class="cuerpo">
					<header>
						<table border="0" cellpadding="2">
							<tr>
								<td width="12%" align="center">
									<img src="../vistas/img/cns/cns-logo.png" height="55px" style="margin: 0 auto;"/>
								</td>
								<td width="75%" align="center">
									<h2>CERTIFICADO DE RESULTADO NEGATIVO A COVID-19</h2>
								</td>
								<td width="13%" aling="center">';
									$dir ="../temp/cod_qr/";
									if (!file_exists($dir))
										mkdir($dir);
									$filename = $dir.'certAltaDescartado.png';
									$tamaño = 10; //Tamaño de Pixel
									$level = 'H'; //Precisión alta
									$framSize = 3; //Tamaño en blanco										
									$contenido = 'COD. FICHA: '.$this->id_ficha."\n"; // texto
										//Enviamos los parametros a la Función para generar código QR 
									QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
										//Mostramos la imagen generada
									$content .=									
									'<img src="'.$dir.basename($filename).'" height="55px"/>
								</td>
							</tr>							
						</table>
					</header>
					<table>
						<tr>
							<td height="30">
							</td>
						</tr>
					</table>
					<div class="contenido">
						<table border="0" cellpadding="5" style="text-align: justify;">
							<tr>
								<td width="100%">
									<p class="parrafo">A solicitud de la Sr. (a):									
										<span class="negrita">'
											.$covid_resultado['nombre'].' '.$covid_resultado['paterno'].' '.$covid_resultado['materno'].'
										</span>
										con C.I. 
										<span class="negrita">'
											.$covid_resultado['documento_ci'].
										'</span>, con domicilio en Zona: 
										<span class="negrita">'
											.$covid_resultado['zona'].
										'</span>  Calle:  
										<span class="negrita">'
											.$covid_resultado['calle'].'
										</span>  Nº:
										<span class="negrita">'
											.$covid_resultado['nro_calle'].
										'</span> asegurada/o a la Caja Nacional de Salud con Matricula Nº: 
										<span class="negrita"> '
											.$covid_resultado['cod_asegurado'].
										'</span>, Por la empresa
										<span class="negrita">'
											.$covid_resultado['nombre_empleador'].',</span>
										<span class="negrita"> con Resultado '.$covid_resultado['resultado'].'											
										para COVID-19 por la prueba Diagnóstica </span>
										<span class="negrita">';
											if($covid_resultado['metodo_diagnostico_pcr_tiempo_real']!=""){
												$content .= $covid_resultado['metodo_diagnostico_pcr_tiempo_real'];											
											}
											else if($covid_resultado['metodo_diagnostico_pcr_genexpert']!=""){
												$content .= $covid_resultado['metodo_diagnostico_pcr_genexpert'];											
											}
											else if($covid_resultado['metodo_diagnostico_prueba_antigenica']!=""){
												$content .= $covid_resultado['metodo_diagnostico_prueba_antigenica'];
											}else{
												$content .='';
											}

											$content .='</span>										
										en el Laboratorio de Biologia Molecular 
										<span class="negrita">'.$establecimineto['nombre_establecimiento'].'</span>
										de fecha
										<span class="negrita">'
											.date('d-m-Y',strtotime($covid_resultado['fecha_muestra'])).'
										</span> 
									</p>
								</td>
							</tr>';																		
							/* <tr>
								<td style="text-align: justify;">
									<p class="parrafo">El paciente cumplió con el compromiso de aislamiento domiciliario según el protocolo entregado
										durante: <span class="negrita">'.$baja['dias_incapacidad'].'</span>   
										del <span class="negrita">'.date('d-m-Y', strtotime($baja['fecha_ini'])).'</span>  
										al <span class="negrita">'.date("d-m-Y", strtotime($baja['fecha_fin'])).'.</span>
									</p>
								</td>
							</tr> */
							$content .='
							<tr>
								<td height="25">
								</td>
							</tr>
							<tr>
								<td colspan="3" style="text-align: justify;">
									<p class="parrafo">
										El que certifica, es el personal de salud de la Caja Nacional de Salud de 
										<strong>'.$establecimineto['nombre_establecimiento'].'</strong>, que realizo el control del paciente, según 
										expediente clínico que acredita y constituye un conjunto de documentos escritos de orden medico legal.
									</p>
								</td>
							</tr>
							<tr>
								<td>
								</td>
							</tr>
							<tr>
								<td colspan="3" style="text-align: justify;">
									<p class="parrafo">
										En base y al instructivo del SEDES Cochabamba <strong> N° CITE/UR/DN-B-E. SP/89/2020, 
										del 26 de junio de 2020 y recomendaciones de la OMS y OPS se procede a dar el Alta médica.</strong>
									</p>
								</td>
							</tr>
					
							<tr>
								<td height="80">
								</td>
							</tr>
							<tr>
								<td width="20%">
									
								</td>
								<td width="60%">
									<label style="text-align: center; font-size:28px;"><strong>Cochabamba,  '.$hoy.'</strong></label>
								</td>
								<td width="20%">
									
								</td>
							</tr>
							<tr>
								<td height="100">
								</td>
							</tr>
							<tr>
								<td colspan="2" width="50%">
									DR. '.$persona_notificador['nombre_notificador'].' '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].'	
								</td>								

								<td width="50%">
									'.$establecimineto['nombre_establecimiento'].'<br>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</body>
		</html>';
		// Reconociendo la estructura HTML
		$pdf->writeHTML($content, false, 0, false, false,"L");

		$direc ="../temp/".$paciente_asegurado['cod_afiliado']."/";
		if (!file_exists($direc)){
			mkdir($direc);
		}
		$pdf->output($direc.'certificado-alta-descartado-'.$valor.'.pdf', 'F');		
	}
}

/*==================================================
		FORMULARIO PARA CERTIFICADO DE ALTA PACIENTE SIN FICHA EPIDEMIOLOGICA
 ===================================================*/

class AjaxCertificadoDeAltaManual{

	/*seccion para datos del asegurado */
	public $id_ficha;
	public $id_afiliado;
	public $nombrecompleto;
	public $id_Asegurado;
	public $nombre_Asegurado;
	public $paterno_Asegurado;
	public $materno_Asegurado;
	public $ci;
	public $zona;
	public $calle;
	public $sexo;
	public $matricula;
	public $codempleador;
	public $empleador;
	public $fechanacimiento;
	public $nro;
	public $telefono;
	public $establecimiento_laboratorio;
	/*seccion para los datos del formulario de alta manual */
	public $id_formularioAlta;
	public $tipo_Muestra;
	public $fecha_resultado;
	public $establecimiento_notificador;
	public $dias_baja;
	public $fecha_ini;
	public $fecha_fin;	

	public function ajaxMostarCertificadoDeAltaHTML($session, $request){

		//$valor = $this->id_ficha;
		$idAfiliado = $this->id_afiliado;

		
		//$baja = ControladorFormularioBajas::ctrMostrarFormularioBajas('codigo', $idAfiliado);

		$nombrecompleto =  $this->nombrecompleto ;
		$ci = $this->ci;
		$zona =  $this->zona ;
		$calle =  $this->calle ;
		$sexo =  $this->sexo ;
		$matricula =  $this->matricula ;
		$codempleador = $this->codempleador;
		$empleador = $this->empleador;
		$fechanacimiento =  $this->fechanacimiento ;
		$nro =  $this-> nro ;
		$telefono =  $this->telefono ;
		$fecha_actual = date("d-m-Y");
	
			$hoy =  obtenerFechaEnLetra(date('d-m-Y'));	
	
			$content = '
			<html lang="en">
				<head>
					<style>
						.contenido{
							font-size: 14px;
							font-family: Arial, Helvetica, sans-serif;
							line-height: 28pt;
						}
						.negrita{
							font-weight: bold;
						}
						.parrafo{
							text-align:justify; 
							/* line-height: 2em; */
						}
						.cuerpo{
							padding-left: 50px;
							padding-right: 50px;
							border: 2px solid #17a2b8;
							border-radius: 50px 10px;
						}
						.form-control-p{
							height:30px;
							border: 1px solid #3C807C;
							/*background-color: #D1FFD6;*/
						}
						textarea:focus, input:focus, input[type]:focus {
							border-color: rgb(60, 128, 124);
							box-shadow: 0 1px 1px rgba(80, 199, 193, 0.075)inset, 0 0 8px rgba(80, 199, 193,0.6);
							outline: 0 none;
						}
						.mayuscula{
							text-transform:uppercase;
						  }							
					</style>					
				</head>
				<body>
					<div class="cuerpo">
						<header>
							<center><h3>CERTIFICADO DE ALTA DE PACIENTE DESCARTADO COVID-19</h3></center>
							<hr>
						</header>					
						<div class="contenido">
							<form action="" method="post" id="formformularioBajaDescartadoManual">
								<table border="0" cellpadding="3">
									<tr>
										<td>
											<div class="">A solicitud escrita del Sr/Sra.';
												if ($nombrecompleto =="")
													$content.= 'Ingrese sus datos personales del paciente.
														<div class="form-row">
															<div class="form-group col-md-4">
																<label for="txtapellidopaterno">Apellido Paterno</label>
																<input class="form-control-p mayuscula" type="text" name="txtapellidopaterno"  id="txtapellidopaterno" value="'.$request['primerapellido'].'" placeholder="Apellido Paterno">
															</div>
															<div class="form-group col-md-4">
																<label for="txtapellidomaterno">Apellido Materno</label>
																<input class="form-control-p mayuscula" type="text" name="txtapellidomaterno"  id="txtapellidomaterno" value="'.$request['segundoapellido'].'" placeholder="Apellido Materno">
															</div>
															<div class="form-group col-md-4">																																
																<label for="txtnombre">Nombres</label>
																<input class="form-control-p mayuscula" type="text" name="txtnombre"  id="txtnombre" value="'.$request['nombre'].'" placeholder="Ingrese su snombre">
															</div>
														</div>';
												else $content.= 'Ingrese sus datos personales del paciente.
														<div class="form-row">
															<div class="form-group col-md-4">
																<label class="my-0" for="txtapellidopaterno">Apellido Paterno</label>
																<input class="form-control-p mayuscula" type="text" name="txtapellidopaterno"  id="txtapellidopaterno" value="'.$request['primerapellido'].'" placeholder="Apellido Paterno" style="width:210px;">
															</div>
															<div class="form-group col-md-4">
																<label class="my-0" for="txtapellidomaterno">Apellido Materno</label>
																<input class="form-control-p mayuscula" type="text" name="txtapellidomaterno"  id="txtapellidomaterno" value="'.$request['segundoapellido'].'" placeholder="Apellido Materno" style="width:210px;">
															</div>
															<div class="form-group col-md-4">																																
																<label class="my-0" for="txtnombre">Nombres</label>
																<input class="form-control-p mayuscula" type="text" name="txtnombre"  id="txtnombre" value="'.$request['nombre'].'" placeholder="Ingrese su snombre" style="width:210px;">
															</div>
														</div>';
												$content.='con CI:  
												<input class="form-control-p mayuscula" type="text" name="txtCi"  id="txtCi" value="'.$ci.'" style="width:140px;">
												, con domicilio en Zona: 
												';

												if($zona == "undefined")
												$content .= '<input class="form-control-p mayuscula" type="text" name="zona"  id="zona" placeholder="Ingrese la zona" style="width:300px;">';
												else $content .= '<input class="form-control-p mayuscula" type="text" name="zona"  id="zona" placeholder="Ingrese la zona" style="width:300px;">';	
											
												$content .=
												'Calle:  
												<span class="negrita">';

												if($calle == "undefined")
													$content .= '<input class="form-control-p mayuscula" type="text" name="calle" id="calle" placeholder="Ingrese la calle" style="width:240px;">';
												else 
													$content .= '<input class="form-control-p mayuscula" type="text" name="calle" id="calle" placeholder="Ingrese la calle" style="width:240px;">';	
										
												$content .=													
												'</span>  Nº:  
												<span class="negrita">';

												if($nro == "undefined")
													$content .= '<input class="form-control-p mayuscula" type="text" name="nro" id="nro" placeholder="Ingrese el nro o SN" style="width:60px;">';
												else 
													$content .= '<input class="form-control-p mayuscula" type="text" name="nro" id="nro" value="'.$nro.'" style="width:60px;" >';
										
												$content .=
												'</span> asegurada/o a la Caja Nacional de Salud con Matricula Nº: 
												<span class="negrita" id="matriculaAsegurado"> '
													.$matricula.
												'</span>, Por la empresa
												<span class="negrita">';
												if($codempleador==0)
													$content .= '<label for="">Cod Empresa</label> <input class="form-control-p mayuscula" type="text" name="codEmpleador" id="codEmpleador" value="'.$codempleador.'" style="width:240px;" placeholder="Cod Empleador">';
												else
													$content .= '<label for="">Cod Empresa</label> <input class="form-control-p mayuscula" type="text" name="codEmpleador" id="codEmpleador" value="'.$codempleador.'" style="width:240px;" placeholder="Cod Empleador">';

												if($empleador == "Sin Empleador")
													$content .= '  <label for=""> Nombre Empresa</label> <input class="form-control-p mayuscula" type="text" name="empleador" id="empleador" style="width:520px;" value="'.$empleador.'" placeholder="Ingrese el empleador">';
												else 
													$content .= ' <label for=""> Nombre Empresa</label> <input class="form-control-p mayuscula" type="text" name="empleador" id="empleador" value="'.$empleador.'" placeholder="Ingrese el empleador" style="width:520px;">';
										
												$content .=
												'</span> fue diagnosticado de COVID-19 por la prueba diagnóstica

												<select class="form-control-p" name="tipoMuestra" id="tipoMuestra">
													<option value="Antigeno SARS COV-2"><span class="negrita">Antigeno SARS COV-2</span></option>
													<option value="Prueba Antigénica"><span class="negrita">Prueba Antigénica</span></option>
													<option value="RT-PCR GENEXPERT"><span class="negrita">RT-PCR GENEXPERT</span></option>
													<option value="RT-PCR en tiempo Real"><span class="negrita">RT-PCR en tiempo Real</span></option>
												</select> con Resultado:

												<select class="form-control-p" name="selectResultado" id="selectResultado">
													<option value="NEGATIVO"><span class="negrita">NEGATIVO</span></option>
												</select>

												, en fecha: <input class="form-control-p" type="date" name="fechaAlta" id="fechaAlta" style="width:130px;" value="'.date('Y-m-d').'">
												en el Laboratorio del establecimiento

												<input class="form-control-p mayuscula" list="listacentros"  id="centros" name="centros" value="" style="width:270px;" placeholder="Seleccione un centro">
												<datalist id="listacentros">
													<option value="Centro Centinela covid-19 Anexo N32">Centro Centinela covid-19 Anexo N32</option>
													<option value="CIMFA SUR">CIMFA SUR</option>
													<option value="CIMFA QUILLACOLLO">CIMFA QUILLACOLLO</option>
													<option value="HOSPITAL OBRERO NRO 2">HOSPITAL OBRERO NRO 2</option>
													<option value="CIMFA M.A.V.-CLINICA POLICIAL">CIMFA M.A.V.-CLINICA POLICIAL</option>
												</datalist>

											</div>
										</td>
									</tr>																		
									<tr>
										<td>
											<!--<p class="parrafo">El paciente cumplió con el compromiso de aislamiento domiciliario según el protocolo entregado <br>
												durante:
												<input class="form-control-p" name="diasBaja" id="diasBaja" value="1" style="width:30px;" disabled> dias 
												del <input class="form-control-p"type="date" name="fechaAltaini" value="'.date('Y-m-d').'" id="fechaAltaini" onchange="verificarFechaIni()">
												al  <input class="form-control-p"type="date" name="fechaAltafin" value="'.date('Y-m-d').'" id="fechaAltafin" min="'.date('Y-m-d').'" max="'.date("Y-m-d",strtotime($fecha_actual."+ 2 days")).'" onchange="verificarFechaFin()">
											</p>-->
										</td>
									</tr>
									<tr>
										<td height="10">
										</td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: justify;">
											<p class="parrafo">
												El que certifica, es el personal de salud de la Caja Nacional de Salud
												del

												<select class="form-control-p mayuscula" name="selectcentro" id="selectcentro">
													<option value="seleccione"><span class="negrita">Seleccione..</span></option>
													<option value="1"><span class="negrita">Centro Centinela covid-19 Anexo N32</span></option>
													<option value="2"><span class="negrita">CIMFA SUR</span></option>
													<option value="3"><span class="negrita">CIMFA QUILLACOLLO</span></option>
													<option value="4"><span class="negrita">HOSPITAL OBRERO NRO 2</span></option>
													<option value="13"><span class="negrita">CIMFA M.A.V.-CLINICA POLICIAL</span></option>
												</select>
											</p>
										</td>
									</tr>
									<tr>
										<td>
										</td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: justify;">
											<p class="parrafo">
												En base y al Instructivo del SEDES Cochabamba <strong>Nº CITE/UE/DN-B-E.SP/89/2020
												del 26 de junio 2020 y recomendaciones de la OMS y OPS se procede a dar el
												<strong>ALTA MEDICA </strong> </strong>.
											</p>
										</td>
									</tr>
							
									<tr>
										<td>
										</td>
									</tr>
									<tr>
										<td>
											<center><label style="text-align: center;"><strong>Cochabamba,  '.$hoy.'</strong></label></center>
											<input type="hidden" value="'.$idAfiliado.'" id="backupIdAfiliado">
											<input type="hidden" value="'.$session["idUsuarioCOVID"].'" id="backupSesion">
											<input type="hidden" value="'.$request['nombre'].'" id="nombre">
											<input type="hidden" value="'.$request['primerapellido'].'" id="primerapellido">
											<input type="hidden" value="'.$request['segundoapellido'].'" id="segundoapellido">
											<input type="hidden" value="'.$request['departamento'].'" id="departamento">
											<input type="hidden" value="'.$request['localidad'].'" id="localidad">
											<input type="hidden" value="'.$request['municipio'].'" id="municipio">
											<input type="hidden" value="'.$request['provincia'].'" id="provincia">
											<input type="hidden" value="'.$request['sexo'].'" id="sexo">
											<input type="hidden" value="'.$request['fechanacimiento'].'" id="fechanacimiento">											
										</td>						
									</tr>
								</table>
								<hr>
							</form>						
						</div>
					</div>
				</body>
			</html>';
			echo $content;
		/* }
		else echo "sinBaja"; */
	}

	public function ajaxMostarCertificadoDeAltaManualDescartadoPDF($request){
		$guardoEnBD = $this->guardarNuevoCertificadoAlta($request);
		if(is_numeric($guardoEnBD) > 0){

			$hoy =  obtenerFechaEnLetra(date('d-m-Y'));
	
			$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);
	
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('CNS Cochabamba');
			$pdf->SetTitle('Certificado de Alta ');
			$pdf->SetSubject('Certificado de Alta');
			$pdf->SetKeywords('TCPDF, PDF, CNS, Certificado, Covid-19');
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
			$pdf->setPrintHeader(false); 
			$pdf->setPrintFooter(false);
	
			$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);
			// set font
			$pdf->SetFont('Helvetica', '', 8);
			// add a page
			$pdf->AddPage();
	
			$content = '
			<html lang="en">
				<head>
					<style>
						.contenido{
							font-size: 28px;					
						}
						.negrita{
							font-weight: bold;
						}
						.parrafo{
							text-align:justify; 
							line-height: 2em;
						}
						.contenido table{					
						}							
					</style>					
				</head>
				<body>
					<div class="cuerpo">
						<header>
							<table border="0" cellpadding="2">
								<tr>
									<td width="12%" align="center">
										<img src="../vistas/img/cns/cns-logo.png" height="55px" style="margin: 0 auto;"/>
									</td>
									<td width="75%" align="center">
										<tr heigth="60">
											<h1>CERTIFICADO PACIENTE DESCARTADO COVID-19</h1>
										</tr>
									</td>
									<td width="13%" aling="center">';
										$dir ="../temp/cod_qr/";
										if (!file_exists($dir))
											mkdir($dir);
										$filename = $dir.'certAltaDescartado.png';
										$tamaño = 10; //Tamaño de Pixel
										$level = 'H'; //Precisión alta
										$framSize = 3; //Tamaño en blanco										
										$contenido = 'COD. FICHA: '.trim($request["matriculaAsegurado"])."\n"; // texto
											//Enviamos los parametros a la Función para generar código QR 
										QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
											//Mostramos la imagen generada
										$content .=									
										'<img src="'.$dir.basename($filename).'" height="55px"/>
									</td>
								</tr>							
							</table>
						</header>
						<table>
							<tr>
								<td height="30">
								</td>
							</tr>
						</table>
						<div class="contenido">
							<table border="0" cellpadding="3">
								<tr>
									<td width="100%">
										<p class="parrafo">A solicitud escrita del Sr/Sra.									
											<span class="negrita">'
												.strtoupper($request["nombre"]).' '.strtoupper($request["primerapellido"]).' '.strtoupper($request["segundoapellido"]).'
											</span>con CI:
											<span class="negrita">'
												.strtoupper($request["ciAsegurado"]).
											'</span>, con domicilio en Zona:
											<span class="negrita">'
												.strtoupper($request["zona"]).
											'</span>  Calle:
											<span class="negrita">'
												.strtoupper($request["calle"]).'
											</span>Nº:
											<span class="negrita">'
												.$request["nro"].
											'</span> asegurada/o a la Caja Nacional de Salud con Matricula Nº:
											<span class="negrita">'
												.trim($request["matriculaAsegurado"]).
											'</span>, Por la empresa
											<span class="negrita">'
												.strtoupper($request["empleador"]).'
											</span> fue diagnosticado de COVID-19 por la prueba diagnóstica
											<span class="negrita">'
												.strtoupper($request['tipoMuestra']).
											'</span> con resultado 
											<span class="negrita">'.$request['resultado'].',</span> en fecha
											<span class="negrita">'
												.date('d-m-Y',strtotime($request['fechaAlta'])).
											'</span> en el Laboratorio del establecimiento
											<span class="negrita">'.strtoupper($request['centro']).'.</span>
										</p>
									</td>
								</tr>																		
								<tr>
									<td style="text-align: justify;">
										<!--<p class="parrafo">El paciente cumplió con el compromiso de aislamiento domiciliario según el protocolo entregado
											durante: <span class="negrita">'.$request['diasBaja'].'</span> días  
											del <span class="negrita">'.date('d-m-Y', strtotime($request['fechaAltaini'])).'</span>  
											al <span class="negrita">'.date("d-m-Y", strtotime($request['fechaAltafin'])).'.</span>
										</p>-->
									</td>
								</tr>
								<tr>
									<td height="30">
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align: justify;">
										<p class="parrafo">
											El que certifica, es el personal de salud de la Caja Nacional de Salud del ';
											if($request['selectcentro']==1)
												$content .= '<strong>Centro Centinela covid-19</strong>';
											else if($request['selectcentro']==2)
												$content .= '<strong>CIMFA SUR</strong>';
											else if($request['selectcentro']==3)
												$content .= '<strong>CIMFA QUILLACOLLO</strong>';
											else if($request['selectcentro']==4)
												$content .= '<strong>HOSPITAL OBRERO NRO 2</strong>';
											else if($request['selectcentro']==13)
												$content .= '<strong>CIMFA M.A.V.-CLINICA POLICIAL</strong>';										
								$content.='</p>
									</td>
								</tr>
								<tr>
									<td>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align: justify;">
										<p class="parrafo">
											En base y al Instructivo del SEDES Cochabamba <strong>Nº CITE/UE/DN-B-E.SP/89/2020
											del 26 de junio 2020 y recomendaciones de la OMS y OPS se procede a dar el ALTA MEDICA.</strong>
										</p>
									</td>
								</tr>
						
								<tr>
									<td height="180">
									</td>
								</tr>
								<tr>
									<td width="20%">
										
									</td>
									<td width="60%">
										<label style="text-align: center; font-size:28px;"><strong>Cochabamba,  '.$hoy.'</strong></label>
									</td>
									<td width="20%">
										
									</td>
								</tr>
							</table>						
						</div>
					</div>
				</body>
			</html>';
			// Reconociendo la estructura HTML
			$pdf->writeHTML($content, false, 0, false, false,"L");
	
			$direc ="../temp/".$request['idafiliado']."/";
			if (!file_exists($direc)){
				mkdir($direc);
			}
			$pdf->output($direc.'certificado-alta-descartado-'.$request['idafiliado'].'.pdf', 'F');		
		}
		else {
			//return json_encode(array(0 =>"errorBDManual"));
			echo "errorBDManual";
		}

	}

	public function guardarNuevoCertificadoAlta($request){
		$respuesta2 = 0;
		$datos = array(
			"cod_asegurado" => strtoupper(trim($request["matriculaAsegurado"])),
			"cod_afiliado" => strtoupper(trim($request["idafiliado"])),
			"cod_empleador" => strtoupper(trim($request["codempleador"])),
			"nombre_empleador" => strtoupper(trim($request["empleador"])),
			"paterno" => strtoupper(trim($request["primerapellido"])),
			"materno" => strtoupper(trim($request["segundoapellido"])),
			"nombre" => strtoupper(trim($request["nombre"])),
			"sexo" => strtoupper(trim($request["sexo"])),
			"nro_documento" => strtoupper(trim($request["ciAsegurado"])),
			"fecha_nacimiento" => strtoupper(trim($request["fechanacimiento"])),
			"edad" => calculaedad(trim($request["fechanacimiento"])),
			"id_departamento_paciente" => 1,
			"id_provincia_paciente" => 1,
			"id_municipio_paciente" => 21, /* 21 */
			"id_pais_paciente" =>  1,
			"zona"=> strtoupper(trim($request["zona"])),
			"calle" => strtoupper(trim($request["calle"])),
			"nro_calle" => strtoupper(trim($request["nro"])),
			"telefono" => '',
			"email" => '',
			"nombre_apoderado" => '',
			"telefono_apoderado" => '',
			"id_ficha" => -1
		);

		$respuesta = ModeloPacientesAsegurados:: mdlIngresarPacienteAseguradoPorAltaManual("pacientes_asegurados", $datos);
		$hoy = date("Y-m-d");
		if(is_numeric($respuesta)>0){
			$datos1 = array(
				"id_pacientes_asegurados" => $respuesta,
				"id_personas_notificadores" => trim($request["id_personas_notificadores"]),
				"prueba_diagnostica" => (trim($request["tipoMuestra"])),
				"resultado" => strtoupper(trim($request["resultado"])),
				"fecha_resultado" => trim($request["fecha_resultado"]),
				"establecimiento_resultado" => strtoupper(trim($request["establecimiento_resultado"])),
				"dias_baja" => trim($request["dias_baja"]),
				"fecha_ini" => trim($hoy),
				"fecha_fin" => trim($request["fecha_fin"]),
				"establecimiento_notificador" => strtoupper(trim($request["selectcentro"]))	
			);
			$respuesta2 = ModeloFormularioBajas::mdlIngresarFormularioAltaManual($datos1);
		}

		return $respuesta2;
	}
	/*
	 Funciones  para editar los datos del formulario de altas manuales
	 
	 */
	public function editarCertificadoAlta(){
		$datos = array(
			"id" => trim($this->id_Asegurado),
			"cod_empleador" => trim($this->codempleador),
			"nombre_empleador" => strtoupper(trim($this->empleador)),
			"paterno" => strtoupper(trim($this->paterno_Asegurado)),
			"materno" => strtoupper(trim($this->materno_Asegurado)),
			"nombre" => strtoupper(trim($this->nombre_Asegurado)),	
			"nro_documento" => strtoupper(trim($this->ci)),	
			"zona"=> strtoupper(trim($this->zona)),
			"calle" => strtoupper(trim($this->calle)),
			"nro_calle" => strtoupper(trim($this->nro))	
		);

		$establecimientoD = array(
			"id" => trim($this->id_formularioAlta),
			"prueba_diagnostica" => (trim($this->tipo_Muestra)),
			"establecimiento_resultado" => strtoupper(trim($this->establecimiento_laboratorio)),
			"establecimiento_notificador" => trim($this->establecimiento_notificador)
		);
		$personaAsegurada = ControladorPacientesAsegurados::ctrEditarPacineteAsegurado("id",$datos);
		$formularioAlta = ControladorFormularioAltasManual::ctrEditarFormularioAltaManualEstablecimiento("id",$establecimientoD);

		echo json_encode($formularioAlta+$personaAsegurada);
	}

	public function ajaxMostarCertificadoDeAltaManualDescartadoPDFLista($request){

			$hoy =  obtenerFechaEnLetra(date('d-m-Y'));
	
			$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);
	
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('CNS Cochabamba');
			$pdf->SetTitle('Certificado de Alta ');
			$pdf->SetSubject('Certificado de Alta');
			$pdf->SetKeywords('TCPDF, PDF, CNS, Certificado, Covid-19');
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
			$pdf->setPrintHeader(false); 
			$pdf->setPrintFooter(false);
	
			$pdf->SetAutoPageBreak(TRUE,PDF_MARGIN_BOTTOM);
			// set font
			$pdf->SetFont('Helvetica', '', 8);
			// add a page
			$pdf->AddPage();
	
			$content = '
			<html lang="en">
				<head>
					<style>
						.contenido{
							font-size: 28px;					
						}
						.negrita{
							font-weight: bold;
						}
						.parrafo{
							text-align:justify; 
							line-height: 2em;
						}
						.contenido table{					
						}							
					</style>					
				</head>
				<body>
					<div class="cuerpo">
						<header>
							<table border="0" cellpadding="2">
								<tr>
									<td width="12%" align="center">
										<img src="../vistas/img/cns/cns-logo.png" height="55px" style="margin: 0 auto;"/>
									</td>
									<td width="75%" align="center">
										<tr heigth="60">
											<h1>CERTIFICADO PACIENTE ALTA MANUAL COVID-19</h1>
										</tr>
									</td>
									<td width="13%" aling="center">';
										$dir ="../temp/cod_qr/";
										if (!file_exists($dir))
											mkdir($dir);
										$filename = $dir.'certAltaDescartado.png';
										$tamaño = 10; //Tamaño de Pixel
										$level = 'H'; //Precisión alta
										$framSize = 3; //Tamaño en blanco										
										$contenido = 'COD. FICHA: '.trim($request["matriculaAsegurado"])."\n"; // texto
											//Enviamos los parametros a la Función para generar código QR 
										QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
											//Mostramos la imagen generada
										$content .=									
										'<img src="'.$dir.basename($filename).'" height="55px"/>
									</td>
								</tr>							
							</table>
						</header>
						<table>
							<tr>
								<td height="30">
								</td>
							</tr>
						</table>
						<div class="contenido">
							<table border="0" cellpadding="3">
								<tr>
									<td width="100%">
										<p class="parrafo">A solicitud de la Sr/Sra.									
											<span class="negrita">'
												.$request["nombre_Asegurado"].' '.$request["apellido_Paterno"].' '.$request["apellido_Materno"].'
											</span>con CI:
											<span class="negrita">'
												.$request["nro_documento"].
											'</span>, con domicilio en Zona:
											<span class="negrita">'
												.$request["zona"].
											'</span>  Calle:
											<span class="negrita">'
												.$request["calle"].'
											</span>Nº:
											<span class="negrita">'
												.$request["nro_calle"].
											'</span> asegurada/o a la Caja Nacional de Salud con Matricula Nº:
											<span class="negrita">'
												.trim($request["matriculaAsegurado"]).
											'</span>, Por la empresa
											<span class="negrita">'
												.$request["nombreEmpleador"].'
											</span> fue diagnosticado de COVID-19 por la prueba diagnóstica
											<span class="negrita">'
												.$request['tipo_Muestra'].
											'</span> con resultado 
											<span class="negrita">'.$request['resultado'].',</span> en fecha
											<span class="negrita">'
												.date('d-m-Y',strtotime($request['fecha_resultado'])).
											'</span> en el Laboratorio del establecimiento
											<span class="negrita">'.$request['establecimiento_laboratorio'].'.</span>
										</p>
									</td>
								</tr>																		
								<tr>
									<!-- <td style="text-align: justify;">
										<p class="parrafo">El paciente cumplió con el compromiso de aislamiento domiciliario según el protocolo entregado
											durante: <span class="negrita">'.$request['diasBaja'].'</span> días  
											del <span class="negrita">'.date('d-m-Y', strtotime($request['fechaAltaini'])).'</span>  
											al <span class="negrita">'.date("d-m-Y", strtotime($request['fechaAltafin'])).'.</span>
										</p>
									</td> -->
								</tr>
								<tr>
									<td height="30">
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align: justify;">
										<p class="parrafo">
											El que certifica, es el personal de salud de la Caja Nacional de Salud del ';
											if($request['establecimiento_notificador']==1)
												$content .= '<strong>Centro Centinela covid-19</strong>';
											else if($request['establecimiento_notificador']==2)
												$content .= '<strong>CIMFA SUR</strong>';
											else if($request['establecimiento_notificador']==3)
												$content .= '<strong>CIMFA QUILLACOLLO</strong>';
											else if($request['establecimiento_notificador']==4)
												$content .= '<strong>HOSPITAL OBRERO NRO 2</strong>';
											else if($request['establecimiento_notificador']==13)
												$content .= '<strong>CIMFA M.A.V.-CLINICA POLICIAL</strong>';												
								$content.=', que realizo el control del paciente, según expediente clínico que acredita y constituye un conjunto de documentos escritos de orden médico legal.</p>
									</td>
								</tr>
								<tr>
									<td>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="text-align: justify;">
										<p class="parrafo">
										En base y al instructivo del SEDES Cochabamba<strong> N° CITE/UR/DN-B-E. SP/89/2020, del 26 de junio de 2020 y recomendaciones de la OMS y OPS se procede a dar el Alta médica</strong>
										</p>
									</td>
								</tr>
						
								<tr>
									<td height="180">
									</td>
								</tr>
								<tr>
									<td width="20%">
										
									</td>
									<td width="60%">
										<label style="text-align: center; font-size:28px;"><strong>Cochabamba,  '.$hoy.'</strong></label>
									</td>
									<td width="20%">
										
									</td>
								</tr>
							</table>						
						</div>
					</div>
				</body>
			</html>';
			// Reconociendo la estructura HTML
			$pdf->writeHTML($content, false, 0, false, false,"L");
	
			$direc ="../temp/".$request['idafiliado']."/";
			if (!file_exists($direc)){
				mkdir($direc);
			}
			$pdf->output($direc.'certificado-alta-descartado-'.$request['idafiliado'].'.pdf', 'F');		


	}
}



if (isset($_POST["concentimientoPDF"])) {
	$mostrarConcentimiento = new AjaxConcentimiento();
	$mostrarConcentimiento->id_ficha = $_POST["idFicha"];
	$mostrarConcentimiento->ajaxMostarInformacionPaciente();
}

if (isset($_POST["certificadoDeAltaDescartado"])) {
	$mostrarCertificadoAltaDescartado = new AjaxCertificadoDeAltaDescartado();
	$mostrarCertificadoAltaDescartado->id_ficha = $_POST["idFicha"];
	$mostrarCertificadoAltaDescartado->ajaxMostarCertificadoDeAltaDescartadoPDF();
}

if (isset($_POST["certificadoMedicoPDF"])) {
	$mostrarCertificadoMedico = new AjaxCertificadoMEdico();
	$mostrarCertificadoMedico->id_ficha = $_POST["idFicha"];
	$mostrarCertificadoMedico->numdias = $_POST["numdias"];
	$mostrarCertificadoMedico->ajaxMostarCertificadoMedico();
}

if (isset($_POST["certificadoDeAlta"])) {
	$mostrarCertificadoAlta = new AjaxCertificadoDeAlta();
	$mostrarCertificadoAlta->id_ficha = $_POST["idFicha"];
	$mostrarCertificadoAlta->id_covid_resultado = $_POST["idCovidResultado"];
	$mostrarCertificadoAlta->ajaxMostarCertificadoDeAltaPDF();
}

if (isset($_POST["certificadoDeAltaManual"])) {
	$mostrarCertificadoAlta = new AjaxCertificadoDeAltaManual();
	$mostrarCertificadoAlta->id_afiliado = $_POST["idAfiliado"];
	$mostrarCertificadoAlta->nombrecompleto = $_POST["nombrecompleto"];
	$mostrarCertificadoAlta->ci =$_POST["ci"];
	$mostrarCertificadoAlta->zona = $_POST["zona"];
	$mostrarCertificadoAlta->calle = $_POST["calle"];
	$mostrarCertificadoAlta->sexo = $_POST["sexo"];
	$mostrarCertificadoAlta->matricula = $_POST["matricula"];
	$mostrarCertificadoAlta->codempleador = $_POST["codempleador"];
	$mostrarCertificadoAlta->empleador =$_POST["empleador"];
	$mostrarCertificadoAlta->fechanacimiento = $_POST["fechanacimiento"];
	$mostrarCertificadoAlta->nro = $_POST["nro"];
	$mostrarCertificadoAlta->telefono = $_POST["telefono"];
	$mostrarCertificadoAlta->ajaxMostarCertificadoDeAltaHTML($_SESSION, $_REQUEST);
}

if (isset($_POST["generarAltaManualPDF"])) {
	$mostrarCertificadoAlta = new AjaxCertificadoDeAltaManual();
	$mostrarCertificadoAlta->ajaxMostarCertificadoDeAltaManualDescartadoPDF($_REQUEST);
}

if(isset($_POST["editarCertificadoAltaManual"])){
	$editarCertificadoAltaManual = new AjaxCertificadoDeAltaManual();
	$editarCertificadoAltaManual->id_Asegurado = $_POST["idPacienteAsegurado"];
	$editarCertificadoAltaManual->nombre_Asegurado = $_POST["nombre_Asegurado"];
	$editarCertificadoAltaManual->paterno_Asegurado = $_POST["apellido_Paterno"];
	$editarCertificadoAltaManual->materno_Asegurado = $_POST["apellido_Materno"];
	$editarCertificadoAltaManual->ci = $_POST["nro_documento"];
	$editarCertificadoAltaManual->calle = $_POST["calle"];
	$editarCertificadoAltaManual->zona = $_POST["zona"];
	$editarCertificadoAltaManual->nro = $_POST["nro_calle"];
	$editarCertificadoAltaManual->codempleador = $_POST["codEmpleador"];
	$editarCertificadoAltaManual->empleador = $_POST["nombreEmpleador"];
	$editarCertificadoAltaManual->establecimiento_laboratorio = $_POST["establecimiento_laboratorio"];

	$editarCertificadoAltaManual->id_formularioAlta = $_POST["idAltamanual"];
	$editarCertificadoAltaManual->tipo_Muestra = $_POST["tipo_Muestra"];
	$editarCertificadoAltaManual->fecha_resultado = $_POST["fecha_resultado"];	
	$editarCertificadoAltaManual->dias_baja = $_POST["dias_baja"];
	$editarCertificadoAltaManual->fecha_ini = $_POST["fecha_ini"];
	$editarCertificadoAltaManual->fecha_fin = $_POST["fecha_fin"];
	$editarCertificadoAltaManual->establecimiento_notificador = $_POST["establecimiento_notificador"];
	$editarCertificadoAltaManual->editarCertificadoAlta();
}

if(isset($_POST["imprimirCertificadoAltaManual"])){
	$imprimirCertificadoAlta = new AjaxCertificadoDeAltaManual();
	$imprimirCertificadoAlta->ajaxMostarCertificadoDeAltaManualDescartadoPDFLista($_REQUEST);	
}