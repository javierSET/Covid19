<?php

require_once "../controladores/reportes_bajas.controlador.php";
require_once "../modelos/reportes_bajas.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/departamentos.controlador.php";
require_once "../modelos/departamentos.modelo.php";

require_once "../controladores/establecimientos.controlador.php";
require_once "../modelos/establecimientos.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";

require_once('../extensiones/tcpdf/tcpdf.php');
@include('./reportes_ficha.ajax.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'cns-logo.png';
        $this->Image($image_file, 5, 5, 10, '', 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 14);
        // Titulo
        $this->Cell(0, 0, 'CAJA  NACIONAL  DE  SALUD        ', 0, 1, 'C', 0, '', 1);
        // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Subtitulo
        //$this->Cell(0, 0, 'LABORATORIO HOSPITAL OBRERO', 0, 1, 'C', 0, '', 1);

	}

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

class AjaxReportesBajas { 
	
	/*=============================================
	MOSTRAR REPORTE POR FECHA DE RESULTADO Y TIPO DE RESULTADO
	=============================================*/
	
	public $fechaInicio;
	public $fechaFin;
	public $resultado;

	public $nombre_usuario;

	public function ajaxMostrarReportesBajasFechas()	{
		
		$valor1 = date("Y-m-d", strtotime($this->fechaInicio));
		$valor2 = date("Y-m-d", strtotime($this->fechaFin));
		$valor3 = $this->resultado;

		$respuesta = ControladorReportesBajas::ctrMostrarReportesBajasFechas($valor1, $valor2, $valor3);

		echo json_encode($respuesta);

	}

	/*=============================================
	MOSTRAR REPORTE GENERADO EN PDF POR FECHA DE RESULTADO Y TIPO DE RESULTADO
	=============================================*/

	public function ajaxMostrarReportesBajasFechasPDF()	{
		
		$valor1 = date("Y-m-d", strtotime($this->fechaInicio));
		$valor2 = date("Y-m-d", strtotime($this->fechaFin));
		$valor3 = $this->resultado;

		/*=============================================
		USANDO LA LIBRERIA TCPDF
		=============================================*/

		// Extend the TCPDF class to create custom Header and Footer


		$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('reporte-'.$valor1.'-'.$valor2.'-'.$valor3);
		$pdf->SetSubject('Reporte Resultados Bajas CNS');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, CovidCNS');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, 22, 5, 5);
		//$pdf->SetMargins(5, 15, 5, 5);
		$pdf->SetAutoPageBreak(true, 25); 
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->setFontSubsetting(false);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('Helvetica', '', 6);

		// add a page
		$pdf->AddPage();

		$respuesta = ControladorReportesBajas::ctrMostrarReportesBajasFechas($valor1, $valor2, $valor3);

		$valor1 = date("d/m/Y", strtotime($valor1));
		$valor2 = date("d/m/Y", strtotime($valor2));

		$content = '';

		if ($valor3 == "TODO") {

			$content .= '
				<div class="row">
				
		        	<div class="col-md-12">
						
						<h1 style="text-align:center;">Reporte: Resultados Bajas</h1>
		            	<h3 style="text-align:center;">Desde '.$valor1.' hasta: '.$valor2.'</h3>';
			
		} else {

			$content .= '
				<div class="row">
				
		        	<div class="col-md-12">
						
						<h1 style="text-align:center;">Reporte: Resultados Bajas '.$valor3.'</h1>
		            	<h3 style="text-align:center;">Desde '.$valor1.' hasta: '.$valor2.'</h3>';	

		}

		    $content .= '

		    <table border="1" cellpadding="5">
		        <thead>
		          	<tr bgcolor="#E5E5E5">
			            <th width="50px" align="center">COD</th>
	                    <th width="70px" align="center">ESTABLECIMIENTO</th>
	                    <th width="100px" align="center">SUMA BAJAS</th>
	                     <th width="100px" align="center">BAJAS DESDE ENERO</th>
	                </tr>
		        </thead>
			';

			foreach ($respuesta as $key => $value) {
					
				$content .= '
				  <tbody>
					<tr>
			            <td width="50px" align="center">'.$value["cod"].'</td>
			            <td width="70px">'.$value["establecimiento"].'</td>
			            <td width="60px"><b>'.$value["resultado"].'</b></td>
			            <td width="60px"><b>'.$value["suma"].'</b></td>
			        </tr>
				  </tbody>	
				';

			}

			$content .= '</table>';

			$content .= '</br>
					<h3 style="text-align: left; padding-top: 10px;">Reporte Generado por el Usuario: '.$this->nombre_usuario.'</h3>
					<h3 style="text-align: left; padding-top: 10px;">Reporte Generado en fecha: '.date("d/m/Y H:i:s").'</h3>
				</div>
				
		    </div>';

			
		//$pdf->writeHTML($content, true, 0, true, 0);
		//$pdf->writeHTML($content, false, 0, false, 0);
		$pdf->writeHTML($content, false, 0, false, false,"L");
		$pdf->lastPage();
		$pdf->output('../temp/reporte-'.$this->fechaInicio.'-'.$this->fechaFin.'-'.$valor3.'.pdf', 'F');
	}

	/*=============================================
	ELIMINADO REPORTE PDF GENERADO
	=============================================*/
	
	public $file;

	public function ajaxEliminarReportePDF()	{
		
		$file = $this->file;

		unlink('../'.$file);

	}

	/*=============================================
	MOSTRAR REPORTE GENERADO EN PDF POR PERSONA ASEGURADA
	=============================================*/

	public $idBajasResultado;

	public function ajaxMostrarReportesBajasFechaPDF()	{

		/*=============================================
		TRAEMOS LOS DATOS DEL AFILIADO CON RESULTADOS BAJAS
		=============================================*/

		$item = "id";
        $valor = $this->idBajasResultado;
        $bajas_respuesta = ControladorReportesBajas::ctrMostrarReportesBajasFechas($item, $valor); 

       
        /*=============================================
        TRAEMOS LOS DATOS DE ESTABLECIMIENTO
        =============================================*/

        $valor_est = $bajas_respuesta["establecimiento"];
        $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor_est);

        
		// Extend the TCPDF class to create custom Header and Footer


		$pdf = new MYPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('reporte-'.$valor);
		$pdf->SetSubject('Reporte Resultados Bajas Covid-19 CNS');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, CovidCNS');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, 20, 5, 5);
		$pdf->SetAutoPageBreak(true, 5); 
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('Helvetica', '', 8);

		$pdf->SetPrintFooter(false);

		// add a page
		$pdf->AddPage();

		$content = '';


		    $content .= '

		    <div>

		    	
		    	<table width="800px" cellspacing="1" cellpadding="4" border="1">
					<tr bgcolor="#E5E5E5">
					    <td align="center" width="205px"><b>Fecha Inicio</b></td>
					    <td align="center" width="105px"><b>Fecha Final</b></td>
					</tr>
					<tr>
					    <td align="center" width="205px">'.date("d/m/Y", strtotime($bajas_respuesta["fecha_ini"])).'</td>
					    <td align="center" width="205px">'.date("d/m/Y", strtotime($bajas_respuesta["fecha_fin"])).'</td>
					</tr>

					
					<tr bgcolor="#E5E5E5">
					    <td align="center" width="205px"><b>Codigo(s)</b></td>
					    <td align="center" width="205px"><b>Establecimiento</b></td>
					    <td align="center" width="105px"><b>Suma</b></td>
					    <td align="center" width="105px"><b>SumaTotal</b></td>
					</tr>
					<tr>
					    <td align="center" width="205px">'.$bajas_respuesta["id"].'</td>
					    <td align="center" width="105px">'.$bajas_respuesta["establecimiento"].'</td>
					    <td align="center" width="311px">'.$bajas_respuesta["sumadia"].'</td>
					     <td align="center" width="411px">'.$bajas_respuesta["suma"].'</td>
					</tr>

				</table>

			';

			$content .= '</br>
					<h3 style="text-align: left; padding-top: 10px;">Reporte Generado por el Usuario: '.$this->nombre_usuario.'</h3>
					<h3 style="text-align: left; padding-top: 10px;">Reporte Generado en fecha: '.date("d/m/Y H:i:s").'</h3>		
		    </div>';

			
		//CONSULTA

		$pdf->writeHTML($content, true, 0, true, 0);

		$pdf->lastPage();

		$pdf->output('../temp/reporte-'.$valor.'.pdf', 'F');

	}
}

/*=============================================
MOSTRAR REPORTE POR FECHAS DE RESULTADO BAJAS
=============================================*/

if (isset($_POST["reporte"])) {

	$reportesCovid = new AjaxReportesBajas();
	$reportesCovid -> fechaInicio = $_POST["fechaInicio"];
	$reportesCovid -> fechaFin = $_POST["fechaFin"];
	$reportesCovid -> resultado = $_POST["resultado"];
	$reportesCovid -> ajaxMostrarReportesBajasFechas();

}

/*=============================================
MOSTRAR REPORTE PDF POR FECHA DE RESULTADO Y TIPO DE RESULTADO BAJSA EN PDF
=============================================*/

if (isset($_POST["reportePDF"])) {

	$reportesCovid = new AjaxReportesBajas();
	$reportesCovid -> fechaInicio = $_POST["fechaInicio"];
	$reportesCovid -> fechaFin = $_POST["fechaFin"];
	$reportesCovid -> resultado = $_POST["resultado"];
	$reportesCovid -> nombre_usuario = $_POST["nombre_usuario"];
	$reportesCovid -> ajaxMostrarReportesBajasFechasPDF();

}



