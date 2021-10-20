<?php

require_once "../controladores/covid_resultados.controlador.php";
require_once "../modelos/covid_resultados.modelo.php";

require_once "../controladores/departamentos.controlador.php";
require_once "../modelos/departamentos.modelo.php";

require_once "../controladores/establecimientos.controlador.php";
require_once "../modelos/establecimientos.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";
require_once "../modelos/formulario_bajas.modelo.php";

require_once "../controladores/establecimientos.controlador.php";
require_once "../modelos/establecimientos.modelo.php";

class TablaCovidResultadosLoratorio {

	public $establecimiento;
	public $fechaMuestra;
	public $request;
	public $perfil;		

	/*=============================================
	MOSTRAR TODA LA INFORMACION DEL PACIENTE EN EL DATATABLE COVID_RESULTADO_LABORATORIO @dan
	=============================================*/
		
	public function mostrarTablaCovidResultadosLaboratorio() {

		$request = $this->request;
		
		$col = array(
		    0   =>  'id',
		    1   =>  'cod_laboratorio',
		    2   =>  'cod_asegurado',
		    3   =>  'cod_afiliado',
			4   =>  'documento_ci',
			5   =>  'fecha_muestra',
			6   =>  'fecha_recepcion',
			7   =>  'tipo_muestra',
		    8   =>  'muestra_control',
		    9   =>  'id_ficha',
			10   =>  'nombre_depto',
			11   =>  'nombre_establecimiento',
			12   =>  'sexo',
			13   =>  'fecha_nacimiento',
			14   =>  'telefono',
			15   =>  'email',
		    16   =>  'nombre_localidad',
		    17   =>  'zona',
			18   =>  'direccion',
			19   =>  'fecha_resultado',
			20   =>  'resultado',
			21   =>  'nombre_medico',
			22   =>  'observaciones'
		);  //create column like table in database		
		
		
		if($this->establecimiento=="todo"){
			$sql = "AND fecha_muestra='".$this->fechaMuestra."'";			
		}else if($this->establecimiento==""){
			$sql = "";			
		}
		else{
			$sql = "AND nombre_establecimiento='".$this->establecimiento."'";
			$sql .= "AND fecha_muestra='".$this->fechaMuestra."'";			
		}		

		if(!empty($request['search']['value'])) {
		    $sql .= " AND (id Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
			$sql .= " OR resultado Like '".$request['search']['value']."%' ";
			$sql .= " OR cod_laboratorio Like '%".$request['search']['value']."%' ";
			$sql .= " OR nombre_establecimiento Like '%".$request['search']['value']."%' ";
		    $sql .= " OR documento_ci Like '".$request['search']['value']."%' )";
						
		}

		$totalData = ControladorCovidResultados::ctrContarFiltradoCovidResultadosLaboratorio($sql);

		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']." LIMIT ".
    		$request['start']."  ,".$request['length']."  ";

		
    	$covidResultados = ControladorCovidResultados::ctrMostrarCovidResultadosLaboratorio($sql);
		$totalFilter = $totalData;

  		$data = array();

		for ($i = 0; $i < count($covidResultados); $i++) {
			/*=============================================
			RESULTADO LABORATORIO
			=============================================*/	

			if ($covidResultados[$i]["resultado"] == "POSITIVO") {				
				$resultado = "<button class='btn btn-danger btn-sm' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";
			} 
			else {
				if ($covidResultados[$i]["resultado"] == "NEGATIVO")
				    $resultado = "<button class='btn btn-success btn-sm' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";
				else
				    $resultado = "<select class='btn-warning btn-sm cambioCovidResultado' id='selectResultado".$covidResultados[$i]["id_ficha"]."' idFicha='".$covidResultados[$i]["id_ficha"]."' idCovidResultadoCambio='".$covidResultados[$i]["id"]."'>"
					."<option value=''>EN ESPERA...</option>
						<option value='POSITIVO'>POSITIVO</option>
						<option value='NEGATIVO'>NEGATIVO</option>"."</select>";
			}

			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/
			$botonHabilitarEdicion = "<button class='btn btn-warning btn-sm btnHabilitarEdicion' idFicha='".$covidResultados[$i]["id_ficha"]."' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='far fa-save'></i></button>";
			$botonEditar = "<button class='btn btn-warning btn-sm btnEditarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
			$botonEliminar ="<button class='btn btn-danger btn-sm btnEliminarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' codAsegurado='".$covidResultados[$i]["cod_asegurado"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
			$botonImprimir = "<button class='btn btn-danger btn-sm btnImprimirCovidResultadoLab' idFicha='".$covidResultados[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";
			
			if (isset($this->perfil) && $this->perfil == "ADMIN_SYSTEM") {

				if ($covidResultados[$i]["estado"] != '0') {
                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='0' data-toggle='tooltip' title='Quitar Resultado Público'><i class='fas fa-download'></i></button>";
                } 
				else {
                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='1' data-toggle='tooltip' title='Publicar Resultado'><i class='fas fa-upload'></i></button>";
                }                
				$botones = "<div class='btn-group'>".$botonEditar.$botonEliminar.$botonHabilitarEdicion."</div>";
				
			} 
			else {
				if ($covidResultados[$i]["estado"] != '0') {					
					$botones = "<div class='btn-group'>".$botonImprimir."</div>";
                } 
				else {               
                    // Agrupamos los botones
					$botones = "<div class='btn-group'>".$botonHabilitarEdicion."</div>";
                }

			}

			$tipoDiagnostico = "<select class='btn-warning btn-sm tipoDiagnostico' id='selectDiagnostico".$covidResultados[$i]["id_ficha"]."' idFicha='".$covidResultados[$i]["id_ficha"]."'>
									<option value=''>SELECCIONE...</option>
									<option value='RT-PCR en tiempo Real'>RT-PCR EN TIEMPO REAL</option>
									<option value='RT-PCR GENEXPERT'>RT-PCR GENEXPER</option>
									<option value='Prueba Antigénica'>PRUEBA ANTIGENICA</option>
								</select>";

			$subdata = array();
		    $subdata[] = $covidResultados[$i]["cod_laboratorio"]; 
		    $subdata[] = $covidResultados[$i]["cod_asegurado"];
		    $subdata[] = $covidResultados[$i]["cod_afiliado"]; 
		    $subdata[] = $covidResultados[$i]["nombre_completo"]; 
		    $subdata[] = $covidResultados[$i]["documento_ci"];
			
			if($covidResultados[$i]["fecha_recepcion"] =="0000-00-00")
				$subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_muestra"]));
			else 	
				$subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_recepcion"]));

		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_muestra"])); 
		    $subdata[] = $covidResultados[$i]["tipo_muestra"];
			$subdata[] = $tipoDiagnostico;
		    $subdata[] = $covidResultados[$i]["muestra_control"];			
		    $subdata[] = $covidResultados[$i]["nombre_depto"];
			$subdata[] = $resultado; 
		    $subdata[] = $covidResultados[$i]["nombre_establecimiento"]; 
		    $subdata[] = $covidResultados[$i]["sexo"]; 
		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_nacimiento"])); 
		    $subdata[] = $covidResultados[$i]["telefono"]; 
		    $subdata[] = $covidResultados[$i]["email"]; 
		    $subdata[] = $covidResultados[$i]["nombre_localidad"]; 
		    $subdata[] = $covidResultados[$i]["zona"]; 
		    $subdata[] = $covidResultados[$i]["direccion"];		    
			if($covidResultados[$i]["fecha_resultado"] == "0000-00-00")
				$subdata[]="";			
			else
				$subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_resultado"]));

		    $subdata[] = $covidResultados[$i]["observaciones"];
			$subdata[] = $covidResultados[$i]["nombre_medico"]; 
		    $subdata[] = $botones;
		    $subdata[] = $covidResultados[$i]["estado"];

		    $data[] = $subdata;

		}	

		$json_data = array(
		    "draw"              =>  intval($request['draw']),
		    "recordsTotal"      =>  intval($totalData),
		    "recordsFiltered"   =>  intval($totalFilter),
		    "data"              =>  $data
		);

		echo json_encode($json_data);
	
	}	

}

/*===================================================
	Clase que permite extraer todos los resultados que generea el responsable de laboratorio
	del Hospital Obrero Nº2 
 ====================================================*/
class mostrarTablaCovidResultadosReporteLaboratorio{
	public $establecimiento;
	public $fechaResultado;
	public $request;
	public $perfil;
	public $responsable_muestra;

	public function mostrarTablaCovidResultadosRepostesLaboratorio() {

		$request = $this->request;
		
		$col = array(
		    0   =>  'id',
		    1   =>  'cod_laboratorio',
		    2   =>  'cod_asegurado',
		    3   =>  'cod_afiliado',
			4   =>  'documento_ci',
			5   =>  'fecha_muestra',
			6   =>  'fecha_recepcion',
			7   =>  'tipo_muestra',
		    8   =>  'muestra_control',
		    9   =>  'id_ficha',
			10   =>  'nombre_depto',
			11   =>  'nombre_establecimiento',
			12   =>  'sexo',
			13   =>  'fecha_nacimiento',
			14   =>  'telefono',
			15   =>  'email',
		    16   =>  'nombre_localidad',
		    17   =>  'zona',
			18   =>  'direccion',
			19   =>  'fecha_resultado',
			20   =>  'resultado',
			21   =>  'nombre_medico',
			22   =>  'observaciones'
		);  //create column like table in database		
		
		

		if($this->establecimiento=="todo"){
			$sql = "AND fecha_resultado='".$this->fechaResultado."'";
			$sql .= "AND responsable_muestra = '".$this->responsable_muestra."'";

		}else if($this->establecimiento==""){
			$sql = "AND responsable_muestra = '".$this->responsable_muestra."'";			
		}
		else{
			$sql = "AND nombre_establecimiento='".$this->establecimiento."'";
			$sql .= "AND fecha_resultado='".$this->fechaResultado."'";
			$sql .= "AND responsable_muestra = '".$this->responsable_muestra."'";			
		}		

		if(!empty($request['search']['value'])) {
		    $sql .= " AND (id Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
			$sql .= " OR resultado Like '".$request['search']['value']."%' ";
			$sql .= " OR cod_laboratorio Like '%".$request['search']['value']."%' ";
			$sql .= " OR nombre_establecimiento Like '%".$request['search']['value']."%' ";
		    $sql .= " OR documento_ci Like '".$request['search']['value']."%' )";						
		}

		$totalData = ControladorCovidResultados::ctrContarFiltradoCovidResultadosReportesLaboratorio($sql);

		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']." LIMIT ".
    		$request['start']."  ,".$request['length']."  ";

		
    	$covidResultados = ControladorCovidResultados::ctrMostrarCovidResultadosReportesLaboratorio($sql);
		$totalFilter = $totalData;

  		$data = array();

		for ($i = 0; $i < count($covidResultados); $i++) {

			$subdata = array();
		    $subdata[] = $covidResultados[$i]["cod_laboratorio"]; 
		    $subdata[] = $covidResultados[$i]["cod_asegurado"];
		    $subdata[] = $covidResultados[$i]["cod_afiliado"]; 
		    $subdata[] = $covidResultados[$i]["nombre_completo"]; 
		    $subdata[] = $covidResultados[$i]["documento_ci"];
			
			if($covidResultados[$i]["fecha_recepcion"] =="0000-00-00")
				$subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_muestra"]));
			else 	
				$subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_recepcion"]));

		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_muestra"])); 
		    $subdata[] = $covidResultados[$i]["tipo_muestra"];
			$subdata[] = $covidResultados[$i]["metodo_diagnostico"];
		    $subdata[] = $covidResultados[$i]["muestra_control"];			
		    $subdata[] = $covidResultados[$i]["nombre_depto"];
			$subdata[] = $covidResultados[$i]["resultado"];
		    $subdata[] = $covidResultados[$i]["nombre_establecimiento"]; 
		    $subdata[] = $covidResultados[$i]["sexo"]; 
		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_nacimiento"])); 
		    $subdata[] = $covidResultados[$i]["telefono"]; 
		    $subdata[] = $covidResultados[$i]["email"]; 
		    $subdata[] = $covidResultados[$i]["nombre_localidad"]; 
		    $subdata[] = $covidResultados[$i]["zona"]; 
		    $subdata[] = $covidResultados[$i]["direccion"];		    
			if($covidResultados[$i]["fecha_resultado"] == "0000-00-00")
				$subdata[]="";			
			else
				$subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_resultado"]));

		    $subdata[] = $covidResultados[$i]["observaciones"];
			$subdata[] = $covidResultados[$i]["nombre_medico"];
			$subdata[] = $covidResultados[$i]["responsable_muestra"]; 
		    $subdata[] = $covidResultados[$i]["estado"];

		    $data[] = $subdata;

		}	

		$json_data = array(
		    "draw"              =>  intval($request['draw']),
		    "recordsTotal"      =>  intval($totalData),
		    "recordsFiltered"   =>  intval($totalFilter),
		    "data"              =>  $data
		);

		echo json_encode($json_data);
	
	}	

}
/*=============================================
ACTIVAR TABLA DE COVID RESULTADOS
=============================================*/

if (isset($_POST["laboratorio"])) {
	if ($_POST["laboratorio"] == "laboratorio") {
		$activarCovidResultadosLaboratorios = new TablaCovidResultadosLoratorio();
		$activarCovidResultadosLaboratorios -> request = $_REQUEST;
		$activarCovidResultadosLaboratorios -> perfil = $_POST["perfilOculto"];
		$activarCovidResultadosLaboratorios -> mostrarTablaCovidResultadosLaboratorio();
	} 
}

/*================================================

  ================================================*/
  if(isset($_POST["accion"])){
	$activarCovidResultadosLaboratorios = new TablaCovidResultadosLoratorio();
	$activarCovidResultadosLaboratorios->request = $_REQUEST;
	$activarCovidResultadosLaboratorios->perfil = $_POST["perfilOculto"];
	$activarCovidResultadosLaboratorios->establecimiento=$_POST["establecimiento"];
	$activarCovidResultadosLaboratorios->fechaMuestra=$_POST["fechaMuestra"];
	$activarCovidResultadosLaboratorios->mostrarTablaCovidResultadosLaboratorio();
  }

  /*==============================================
    ==============================================*/

  if(isset($_POST["reportes"])){
	  $reportesHospitalObrero = new mostrarTablaCovidResultadosReporteLaboratorio();
	  $reportesHospitalObrero->request = $_REQUEST;
	  $reportesHospitalObrero->perfil = $_POST["perfilOculto"];
	  $reportesHospitalObrero->responsable_muestra = $_POST["nombreUsuarioOculto"];
	  $reportesHospitalObrero->mostrarTablaCovidResultadosRepostesLaboratorio();
  }

  if(isset($_POST["reporteEstableciminetoFecha"])){
	$reportesHospitalObrero = new mostrarTablaCovidResultadosReporteLaboratorio();
	$reportesHospitalObrero->request = $_REQUEST;
	$reportesHospitalObrero->perfil = $_POST["perfilOculto"];
	$reportesHospitalObrero->establecimiento = $_POST["establecimiento"];
	$reportesHospitalObrero->fechaResultado = $_POST["fechaResultado"];
	$reportesHospitalObrero->responsable_muestra = $_POST["nombreUsuarioOculto"];
	$reportesHospitalObrero->mostrarTablaCovidResultadosRepostesLaboratorio();
  }