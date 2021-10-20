<?php

require_once "../controladores/formulario_bajas.controlador.php";
require_once "../controladores/formulario_bajas_externos.controlador.php";
require_once "../modelos/formulario_bajas.modelo.php";

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

require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/pacientes_asegurados.modelo.php";

require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";

require_once "../controladores/formulario_bajas_externos.controlador.php";
require_once "../modelos/formulario_bajas_externos.modelo.php";

require_once "../modelos/personas_notificadores.modelo.php";

require_once('../extensiones/tcpdf/tcpdf.php');

class AjaxFormularioBajas {

	public $idCovidResultado;
	public $idFicha;

	public function ajaxMostrarFormularioBajas($request){

		if (isset($request["id_ficha"])) { 
			$item = "id_ficha";
			$valor = $request["id_ficha"];
			$respuesta = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item, $valor);

			if(!$respuesta){ // Esto es por que se esta controlando la duplicidad de fichas
				$ficha = ControladorFichas::ctrMostrarFichas('id_ficha',$valor);
				$respuesta = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $ficha['id_paciente']);
			}

			echo json_encode($respuesta);
		}
		else if(isset($request["idCovidResultado"])){

			$item = "id";		 
			$valor = $request["idCovidResultado"];
	
			$respuesta =ControladorCovidResultados::ctrMostrarCovidResultados($item, $valor);

			//Para extraer todas las bajas de un paciente
			$bajas = ControladorPacientesAsegurados::ctrMostrarBajas($respuesta['cod_asegurado']);
			if($bajas != null && count($bajas) > 0)
				$respuesta['fecha_fin'] = $bajas[0]['fecha_fin'];
			else $respuesta['fecha_fin'] = date('Y-m-d');
	
			echo json_encode($respuesta);
		}
	}

	public $riesgo;
	public $fechaIni;
	public $fechaFin;
	public $diasIncapacidad;
	public $lugar;
	public $fecha;
	public $clave;
	public $codAsegurado;
	public $observacionesBaja;
	public $codEmpleador;
	public $nombreEmpleador;

	public function ajaxIngresarFormularioBaja($request) {

		// Patrón (admite letras acentuadas y espacios):
		$patron_texto_numero = "/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ- ]+$/";
		if($this->idCovidResultado != null){  //guardar baja con resultado
			if (!empty($this->idCovidResultado) || !empty($this->riesgo) || !empty($this->fechaIni) || !empty($this->fechaFin) || !empty($this->diasIncapacidad) || !empty($this->lugar) || !empty($this->fecha) || !empty($this->clave) || !empty($this->codAsegurado)) {
				if (/*preg_match($patron_texto_numero, $this->lugar)  &&
					preg_match($patron_texto_numero, $this->clave) */ true) {

					$codigo = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
					$tabla = "formulario_bajas";
					$datos = array("id_covid_resultado" => $this->idCovidResultado,
									"riesgo" 		    => $this->riesgo,
									"fecha_ini" 		=> $this->fechaIni, 
									"fecha_fin"         => $this->fechaFin,
									"dias_incapacidad"	=> $this->diasIncapacidad,
									"lugar" 		    => $this->lugar,
									"fecha"		        => $this->fecha,
									"clave"   		    => $this->clave,
									"codigo"   		    => $this->codAsegurado.'-'.$codigo,
									"establecimiento"   => $request['establecimiento'],
									"observacion_baja"	=> strtoupper($this->observacionesBaja)
					);

					$datos1 = array("cod_empleador"    => strtoupper($this->codEmpleador),
									"nombre_empleador" => strtoupper($this->nombreEmpleador),
									"cod_afiliado"     => strtoupper($this->clave),

									"paterno"          => strtoupper(trim($request["paterno"])),
									"materno"          => strtoupper(trim($request["materno"])),
									"nombre"           => strtoupper(trim($request["nombre"])),
									"cod_asegurado"     => strtoupper(trim($request["codAsegurado"])),
									"id_covid_resultado"       => trim($this->idCovidResultado)
					);

					$respuesta = ModeloFormularioBajas::mdlIngresarFormularioBaja($tabla, $datos);
					if($respuesta == 'ok'){
						$respuesta1 = ControladorPacientesAsegurados::ctrEditarPacineteAseguradoNombreEmpleador("cod_afiliado",$datos1);
						if($respuesta1 == 'ok'){
							//$respuesta2 = ControladorCovidResultados::ctrEditarNombreEmpleador("id",$datos1);
							$respuesta2 = ControladorCovidResultados::ctrEditarNombreEmpleador("cod_afiliado",$datos1);
							$respuesta = $respuesta1;
							if($respuesta2 == 'ok'){
								$respuesta = $respuesta2;
							}
							else{
								$respuesta="error al Actualizar covid resultado 1";
							}
						}
						else{
							$respuesta="error al Actualizar informacion del paciente 1";
						}
					}
					else{
						$respuesta="error al crear formulario de baja 1";
					}

				} 
				else {
					$respuesta = "error1";
				}				
			} 
			else {
				$respuesta = "error2";
			}
		}
		else{ //guardar baja de sospechoso

			$codigo = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
			$tabla = "formulario_bajas";
			$datos = array("id_covid_resultado" => -1,
							"id_ficha"          => $this->idFicha, 
							"riesgo" 		    => $this->riesgo,
							"fecha_ini" 		=> $this->fechaIni, 
							"fecha_fin"         => $this->fechaFin,
							"dias_incapacidad"	=> $this->diasIncapacidad,
							"lugar" 		    => $this->lugar,
							"fecha"		        => $this->fecha,
							"clave"   		    => $this->clave,
							"codigo"   		    => $this->codAsegurado.'-'.$codigo,
							"observacion_baja"	=> $this->observacionesBaja,

							"establecimiento"  => strtoupper($request['establecimiento'])
			);

			$respuesta = ModeloFormularioBajas::mdlIngresarFormularioBajasSospechoso($tabla, $datos);
			if($respuesta != -1) //Retorna un valor distinto de -1 cuando lo crea un registro en la BD
				$idBaja = $respuesta;
			else $idBaja = -1;

			$id_pacientes_asegurados = ModeloPacientesAsegurados::mdlMostrarPacientesAsegurados("pacientes_asegurados","id_ficha",$this->idFicha);

			if(!$id_pacientes_asegurados){ // Se modifico por la duplicidad
				$ficha = ControladorFichas::ctrMostrarFichas('id_ficha', $this->idFicha);
				$id_pacientes_asegurados = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $ficha['id_paciente']);
			}

			$id_persona_notificadora = ModeloPersonasNotificadores::mdlMostrarPersonasNotificadores("personas_notificadores","id_ficha",$this->idFicha);
			
			$datos2 = array("id_ficha"               => $this->idFicha, 
						"id_pacientes_asegurados"    => $id_pacientes_asegurados['id'],
						"id_personas_notificadores"  => $id_persona_notificadora['id'],
						"tipo_baja"                  => "SOSPECHOSO",
						"id_formulario_baja"	     => $idBaja,
			);

			$datosModificar = array("cod_empleador"      => $this->codEmpleador,
							"nombre_empleador"   => strtoupper($this->nombreEmpleador),
							"cod_afiliado"       => strtoupper($this->clave),
							"id_ficha"           => $this->idFicha,
							"id_formulario_baja" => $idBaja,
							"id_pacientes_asegurados"    => $id_pacientes_asegurados['id'],

							"paterno"          => strtoupper($request['paterno']),
							"materno"          => strtoupper($request['materno']),
							"nombre"           => strtoupper($request['nombre']),
							"codAsegurado"     => strtoupper($request['codAsegurado'])
			);

			if($respuesta != -1){ //Retorna exitoso si es distinto de -1
				//$respuesta1 = ControladorPacientesAsegurados::ctrEditarPacineteAseguradoNombreEmpleador2("id_ficha",$datosModificar);
				$respuesta1 = ControladorPacientesAsegurados::ctrEditarPacineteAseguradoNombreEmpleador2("id",$datosModificar);
				if($respuesta1 == 'ok'){
					$respuesta2 = ControladorBajasExterno::mdlIngresarFormularioBajaSospechoso($datos2);  //ingresa un registro en table formulario_bajas_externo
					$respuesta = $respuesta1;
					if($respuesta2 == 'ok'){
						$respuesta = $respuesta2;
					}
					else{
						$respuesta="error al Crear en tabla intermedia sospechoso 2";
					}
				}
				else{
					$respuesta="error al Actualizar informacion del paciente 2";
				}
			}
			else{
				$respuesta="error al crear formulario de baja 2";
			}
		}

		echo $respuesta;

	}

	/*=============================================
	MOSTRAR FORMULARIO DE BAJA GENERADO EN PDF
	=============================================*/

	public $idFormularioBaja;

	public function ajaxImprimirFormularioBaja(){

		/*=============================================
		TRAEMOS LOS DATOS DE FORMULARIO BAJA
		=============================================*/

		$item = "id";
        $valor = $this->idFormularioBaja;
        $covid_respuesta = ControladorFormularioBajas::ctrMostrarFormularioBajas($item, $valor);
		$formulario_bajas_externo = ControladorBajasExterno::ctrMostrarFormularioBajaExterno("id_formulario_baja",$valor); 
		
		/*
		 ESTABLECIMIENTO
		 */

		 $establecimiento = ControladorEstablecimientos::ctrMostrarEstablecimientos("id",$covid_respuesta["establecimiento"]);
		 $establecimientoNombre = $establecimiento["nombre_establecimiento"];
		 if($establecimientoNombre == 'Centro Centinela covid-19 Anexo N32'){
			$establecimientoNombre = 'ANEXO-32';
		 }

        /*=============================================
        TRAEMOS LOS DATOS DE COVID RESULTADOS
        =============================================*/

        $valorCovidResultado = $covid_respuesta["id_covid_resultado"];
		if($valorCovidResultado==-1){
			$covidResultado= ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item,$formulario_bajas_externo["id_pacientes_asegurados"]);				
		}else{
        	$covidResultado = ControladorCovidResultados::ctrMostrarCovidResultados($item, $valorCovidResultado);
		}

        /*=============================================
        Extend the TCPDF class to create custom Header and Footer
        =============================================*/

		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('formularioIncapacidad-'.$valor);
		$pdf->SetSubject('Reporte Resultados Covid CNS');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, CovidCNS');

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5, 10, 5, 5); 
		$pdf->SetAutoPageBreak(true, 10); 
		$pdf->SetFont('Helvetica', '', 10);
		$pdf->addPage();

		// set cell padding
		$pdf->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		$pdf->setCellMargins(1, 1, 1, 1);

		// set color for background
		$pdf->SetFillColor(255, 255, 127);

		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)

		// Título del Formulario
		$title1 = 'CAJA NACIONAL DE SALUD
		DEPARTAMENTO DE AFILIACIÓN
		CERTIFICADO DE INCAPACIDAD TEMPORAL';

		// Estilos necesarios para el Codigo QR
		$style = array(
		    'border' => 0,
		    'vpadding' => 'auto',
		    'hpadding' => 'auto',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255)
		    'module_width' => 1, // width of a single module in points
		    'module_height' => 1 // height of a single module in points
		);

		//	Datos a mostrar en el código QR
		// $codeContents = 'AP. PATERNO: '.$covidResultado["paterno"]."\n";
		// $codeContents .= 'AP. MATERNO: '.$covidResultado["materno"]."\n";
		// $codeContents .= 'NOMBRE: '.$covidResultado["nombre"]."\n";
		// $codeContents .= 'Nro. Asegurado: '.$covidResultado["cod_asegurado"]."\n";
		// $codeContents .= 'NOMBRE DEL EMPLEADOR: '.$covidResultado["nombre_empleador"]."\n";
		// $codeContents .= 'Nro. Empleador: '.$covidResultado["cod_empleador"]."\n";
		$codeContents = 'Cod. del Documento: '.$covidResultado["cod_asegurado"].'-'.$covid_respuesta["codigo"];
		/*=============================================
		CONTRUCCION DEL FORMULARIO PRINCIPAL Y SU COPIA
		=============================================*/

		$n = 5;
		
		for ($i = 0; $i < 1; $i++) {
			
			/*=============================================
			PRIMERA SECCION CABEZERA DEL FORMULARIOS
			=============================================*/

			$pdf->MultiCell(200, 22, '', 1, 'C', 0, 0, 5, 2 + $n, true);

			$image_file = K_PATH_IMAGES.'cns-logo-simple.png';
	        $pdf->Image($image_file, 10, 5 + $n, 18, '', 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);

			// Multicell test
			$pdf->MultiCell(110, 20, $title1, 0, 'C', 0, 0, '', '', true);

			$pdf->MultiCell(60, 20, 'AVC-09', 0, 'R', 0, 1, '', '', true);

			$pdf->write2DBarcode($codeContents, 'QRCODE,H', 180, 160 + $n, 24, 24, $style, 'N');	

			/*=============================================
			SEGUNDA SECCION DATOS ASEGURADO
			=============================================*/

			$pdf->SetFont('Helvetica', 'B', 10);

			$pdf->MultiCell(50, 5, '(1) AP. PATERNO', 1, 'C', 0, 0, '',24 + $n, true, 1);
			$pdf->MultiCell(50, 5, '(2) AP. MATERNO', 1, 'C', 0, 0, 55, '', true, 1);
			$pdf->MultiCell(50, 5, '(3) NOMBRE', 1, 'C', 0, 0, 105, '', true, 0);
			$pdf->MultiCell(50, 5, '(4) Número Asegurado', 1, 'C', 0, 1, 155, '', true);

			$pdf->SetFont('Helvetica', '', 10);

			$pdf->MultiCell(50, 5, $covidResultado["paterno"], 1, 'C', 0, 0, '', 30.5 + $n, true, 0);
			$pdf->MultiCell(50, 5, $covidResultado["materno"], 1, 'C', 0, 0, 55, '', true, 0);
			$pdf->MultiCell(50, 5, $covidResultado["nombre"], 1, 'C', 0, 0, 105, '', true, 0);
			$pdf->MultiCell(50, 5, $covidResultado["cod_asegurado"], 1, 'C', 0, 1, 155, '', true,0);

			$pdf->SetFont('Helvetica', 'B', 10);

			$pdf->MultiCell(150, 5, '(5) NOMBRE O RAZÓN SOCIAL DEL EMPLEADOR', 1, 'C', 0, 0, '', 37 + $n, true, 0);
			$pdf->MultiCell(50, 5, '(6) Número Empleador', 1, 'C', 0, 1, 155, '', true);

			$pdf->SetFont('Helvetica', '', 10);

			$pdf->MultiCell(150, 12, $covidResultado["nombre_empleador"], 1, 'L', 0, 0, '', 43.5 + $n, true);
			$pdf->MultiCell(50, 12, $covidResultado["cod_empleador"], 1, 'C', 0, 1, 155, '', true);

			/*=============================================
				TERCERA SECCION DATOS FORMULARIO DE BAJA
			=============================================*/

			$left_column = '			
			<table border="0">
				<tr>
					<td width="35%"> (7) Riesgo</td>
					<td width="65%">'.$covid_respuesta["riesgo"].'</td>
				</tr>				
				<tr>
					<td width="35%">INCAPACIDAD DESDE: </td>
					<td width="65%">'.date("d-m-Y", strtotime($covid_respuesta["fecha_ini"])).'</td>
				</tr>
				<tr>
					<td width="35%">INCAPACIDAD HASTA: </td>
					<td width="65%">'.date("d-m-Y", strtotime($covid_respuesta["fecha_fin"])).'</td>
				</tr>
				<tr>
					<td width="35%">DÍAS INCAPACIDAD: </td>
					<td width="65%">'.$covid_respuesta["dias_incapacidad"].'</td>
				</tr>';
					if($covid_respuesta["observacion_baja"]!=""){
						$left_column .= '
						<tr>
							<td width="35%">OBSERVACION: </td>
							<td width="65%">'.$covid_respuesta["observacion_baja"].'</td>
						</tr>
						';						
					}
				
				$left_column .= '<tr>
					<td> FIRMA DEL MÉDICO</td>
					<td align="center">'.$covid_respuesta["lugar"].' '.date("d-m-Y", strtotime($covid_respuesta["fecha"])).'<br><br>.........................................<br>Lugar y Fecha<br></td>
				</tr>
				<tr>
					<td width="65%"> UNIDAD SAN IT.: '.$establecimientoNombre.'</td>
					<td width="35%">CLAVE: '.$covid_respuesta["clave"].'</td>
				</tr>
			</table>';

			$right_column = '
			<table>
				<tr>
					<td>(8)</td>
				</tr>
				<tr>
					<td>Salario Bs. ............................................<br></td>
					
				</tr>
				<tr>
					<td>Importe Subsidio Bs. .................................<br></td>
					
				</tr>
				<tr>
					<td>SON:........................................................................................................BOLIVIANOS<br></td>
					
				</tr>
				<tr>
					<td>CERTIFICO: .................................<br></td>
					
				</tr>
				<tr>
					<td align="center"><br>..................................................<br>Nombre y Firma C.N.S.</td>
					
				</tr>
			</table>';

			// // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			// get current vertical position
			$y = $pdf->getY();


			// write the first column 50 y 130
			$pdf->writeHTMLCell(130, '', '', 55 + $n, $left_column, 1, 0, 0, true, 'J', true);

			$pdf->writeHTMLCell(70, '', 135, '', $right_column, 1, 1, 0, true, 'J', true);


			/*=============================================
			CUARTA SECCION FIRMAS
			=============================================*/

			$pdf->MultiCell(200, 30, '', 1, 'C', 0, 0, 5, 110 + $n, true);

			$pdf->MultiCell(185, 5, '(9)....................................................................................', 0, 'C', 0, 1, '', 110 + $n, true, 0);

			$pdf->MultiCell(185, 5, 'Lugar y Fecha', 0, 'C', 0, 1, '', 114 + $n, true);

			$pdf->MultiCell(95, 5, '(10)..............................................................', 0, 'C', 0, 0, '', 122 + $n, true, 0);
			$pdf->MultiCell(90, 5, '(11)..............................................................', 0, 'C', 0, 1, 90, '', true);

			$pdf->MultiCell(95, 5, 'Firma del Asegurado', 0, 'C', 0, 0, '', 128 + $n, true, 0);
			$pdf->MultiCell(90, 5, 'Sello Y Firma Empresa', 0, 'C', 0, 1, 90, '', true);

			/*=============================================
			QUINTA SECCION DATOS FORMULARIO DE BAJA
			=============================================*/

			$left_column2 = '
			<table>
				<tr>
					<td><p>Se emite la baja de incapacidad temporal digital excepcionalmente por COVID-19, en cumplimiento y en sujeción al D.S. 4295 por lo que se considera una declaración jurada del asegurado.</p></td>
				</tr>
			</table>';

			$right_column2 = '
			<table>
				<tr>
					<td align="center"><br><br>Queda incólume y subsistente la casilla 9 y 11<br><br></td>
				</tr>
			</table>';

			// // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			// get current vertical position
			$y = $pdf->getY();


			// write the first column
			$pdf->writeHTMLCell(105, 20, '', 140 + $n, $left_column2, 1, 0, 0, true, 'J', true);

			$pdf->writeHTMLCell(95, 20, 110, '', $right_column2, 1, 1, 0, true, 'J', true);

			$left_column3 = '
			<table>
				<tr>
					<td><p>Nota: Al momento de incorporarse el asegurado a su lugar de trabajo, deberá proceder a la firma del presente formulario a objeto de otorgarle el valor legal correspondiente</p><br><br><br></td>
				</tr>
			</table>';

			$right_column3 = '
			<table>
				<tr>
					<td>
						Código del documento
						<br>
						<br>
						<span style="font-weight: bold; font-size: 38px;">'.$covid_respuesta["codigo"].'</span>
					</td>
					
				</tr>
			</table>';

			// // writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

			// get current vertical position
			//$y = $pdf->getY();


			// write the first column
			$pdf->writeHTMLCell(105, 30, '', 160 + $n, $left_column3, 1, 0, 0, true, 'J', true);

			$pdf->writeHTMLCell(95, 30, 110, '', $right_column3, 1, 1, 0, true, 'J', true);


			$n = $n + 185;
			
		}	

		$pdf->writeHTML($right_column3, true, 0, true, 0);

		$pdf->lastPage();

		$direc ="../temp/".$covidResultado['cod_afiliado']."/";
		if (!file_exists($direc)){
			mkdir($direc);
		}
		if($valorCovidResultado==-1){
			$pdf->output('../temp/'.$covidResultado['cod_afiliado'].'/formularioIncapacidad-'.$covidResultado['id'].'.pdf', 'F'); 
		}else{
			$pdf->output('../temp/'.$covidResultado['cod_afiliado'].'/formularioIncapacidad-'.$covidResultado['id_ficha'].'.pdf', 'F'); 
		}
		
	}

}

/*===========================================
MOSTRAR FORMULARIOS DE BAJA
=============================================*/

if (isset($_POST["mostrarFormBaja"])) {

	$formularioBaja = new AjaxFormularioBajas();
	$formularioBaja -> ajaxMostrarFormularioBajas($_POST);

}

/*=============================================
AGREGAR DATOS AL FORMULARIO BAJA
=============================================*/

if (isset($_POST["agregarFormBaja"])) {

	$formularioBaja = new AjaxFormularioBajas();
	if(isset($_POST["idFicha"])){
		$formularioBaja -> idFicha = $_POST["idFicha"];
		$formularioBaja -> idCovidResultado = null;
	}
	else{
		$formularioBaja -> idCovidResultado = $_POST["idCovidResultado"];
		$formularioBaja -> idFicha = null;
	}

	$formularioBaja -> riesgo = $_POST["riesgo"];
	$formularioBaja -> fechaIni = $_POST["fechaIni"];
	$formularioBaja -> fechaFin = $_POST["fechaFin"];
	$formularioBaja -> diasIncapacidad = $_POST["diasIncapacidad"];
	$formularioBaja -> lugar = $_POST["lugar"];
	$formularioBaja -> fecha = $_POST["fecha"];
	$formularioBaja -> clave = $_POST["clave"];
	$formularioBaja -> codAsegurado = $_POST["codAsegurado"];	
	$formularioBaja -> observacionesBaja = $_POST["observacionesBaja"];
	$formularioBaja -> nombreEmpleador = trim($_POST["nombreEmpleador"]);
	$formularioBaja -> codEmpleador = trim($_POST["codEmpleador"]);
	$formularioBaja -> ajaxIngresarFormularioBaja($_POST);

}

/*=============================================
IMPRIMIR FORMULARIO DE BAJA
=============================================*/

if (isset($_POST["imprimirFormBaja"])) {

	$formularioBaja = new AjaxFormularioBajas();
	$formularioBaja -> idFormularioBaja = $_POST["idFormularioBaja"];
	$formularioBaja -> nombre_usuario = $_POST["nombre_usuario"];
	$formularioBaja -> ajaxImprimirFormularioBaja();

}