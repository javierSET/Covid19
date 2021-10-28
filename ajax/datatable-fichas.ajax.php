<?php

require_once "../controladores/fichas.controlador.php";
require_once "../controladores/laboratorios.controlador.php";
require_once "../controladores/covid_resultados.controlador.php";
require_once "../modelos/fichas.modelo.php";
require_once "../modelos/asegurados.modelo.php";

require_once "../controladores/formulario_bajas_externos.controlador.php";
require_once "../modelos/formulario_bajas_externos.modelo.php";

class TablaFichas {

	public $request;
	public $perfil;

	/*=============================================
	MOSTRAR LA TABLA DE FICHAS PARA LABORATORIO
	=============================================*/
		
	public function mostrarTablaFichasLab() {

		$request = $this->request;

		$col = array(
		    0   =>  'id_ficha',
		    1   =>  'cod_asegurado',
		    2   =>  'nombre_completo',
		    3   =>  'nro_documento'
		);  //create column like table in database

		$totalData = ControladorFichas::ctrContarFichasLab();

		$totalFilter = $totalData;

		// echo json_encode($totalData);

		//Search
		$sql = "";

		if(!empty($request['search']['value'])) {

		    $sql .= " AND (id_ficha Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
		    $sql .= " OR nro_documento Like '".$request['search']['value']."%' )";

		    $respuesta = ControladorFichas::ctrContarFiltradoFichasLab($sql);
		}

		

		//Order
		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    	$request['start']."  ,".$request['length']."  ";


    	$fichas = ControladorFichas::ctrMostrarFichasLab($sql);

  		$data = array();

		for ($i = 0; $i < count($fichas); $i++) {

			/*=============================================
			FORMATEAMOS LAS FECHAS
			=============================================*/
			// fecha nacimiento
			if ($fichas[$i]['fecha_nacimiento'] == "0000-00-00" ) {

				$fecha_nacimiento = "";

			} else {

				$fecha_nacimiento = date("d/m/Y", strtotime($fichas[$i]['fecha_nacimiento']));
			}

			// fecha muestra
			if ($fichas[$i]['fecha_muestra'] == "0000-00-00" ) {

				$fecha_muestra = "";

			} else {

				$fecha_muestra = date("d/m/Y", strtotime($fichas[$i]['fecha_muestra']));
			}

			//fecha resultado
			if ($fichas[$i]['fecha_resultado'] == "0000-00-00" ) {

				$fecha_resultado = "";

			} else {

				$fecha_resultado = date("d/m/Y", strtotime($fichas[$i]['fecha_resultado']));
			}

			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/
			if ($fichas[$i]['tipo_ficha'] == "FICHA EPIDEMIOLOGICA") {
				
				$botonImprimir = "<button class='btn btn-danger btnImprimirFichaEpidemiologica' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

				$botonEditar = "<button class='btn btn-warning btnEditarFichaEpidemiologica' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

				$botonLaboratorio = "<button class='btn btn-info btnAgregarResultadoLab' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Agregar Resultado' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-vial'></i></button>";
				
			} else {

				$botonImprimir = "<button class='btn btn-danger btnImprimirFichaControl' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

				$botonEditar = "<button class='btn btn-warning btnEditarFichaControl' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

				$botonLaboratorio = "<button class='btn btn-info btnAgregarResultadoControlLab' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Agregar Resultado' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-vial'></i></button>";

			}

			if ($this->perfil == "ADMIN_SYSTEM") {

				// Agrupamos los botones
				$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonLaboratorio."</div>";

			} else if ($this->perfil == "ESTADISTICA" || $this->perfil == "LABORATORISTA") {

				if ($fichas[$i]['resultado_laboratorio'] == "") { // Cuando la ficha carece de resultado
					$botones = "<div class='btn-group'>".$botonLaboratorio."</div>";

				} else { //Cuando la ficha ya tiene resultado
					$botones = "<div class='btn-group'>".$botonImprimir."</div>";
				}				

			} else {

				$botones = "";

			}

			$subdata = array();
		    $subdata[] = $fichas[$i]["id_ficha"]; 
		    $subdata[] = $fichas[$i]["tipo_ficha"];
		    $subdata[] = $fichas[$i]["cod_asegurado"]; 
		    $subdata[] = $fichas[$i]["nombre_completo"]; 
		    $subdata[] = $fichas[$i]["nro_documento"];  
		    $subdata[] = $fichas[$i]["sexo"]; 
		    $subdata[] = $fecha_nacimiento; 
		    $subdata[] = $fecha_muestra;

			if( $fichas[$i]["resultado_laboratorio"] == 'undefined')
				$subdata[] = '<span class="label warning">En espera..</span>';
			else
			$subdata[] = $fichas[$i]["resultado_laboratorio"];
			
		    $subdata[] = $fecha_resultado; 
		    $subdata[] = $botones;
		    $subdata[] = $fichas[$i]["estado_ficha"];

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

	/*=============================================
	MOSTRAR LA TABLA DE FICHAS PARA LABORATORIO
	=============================================*/
		
	public function mostrarTablaFichasCentro() {

		$request = $this->request;

		$col = array(
		    0   =>  'id_ficha',
		    1   =>  'cod_asegurado',
		    2   =>  'nombre_completo',
		    3   =>  'nro_documento',
			4   =>  'resultado_laboratorio'
		);  //create column like table in database

		$totalData = ControladorFichas::ctrContarFichasCentro();
		
		$totalFilter = $totalData;
		
		// echo json_encode($totalData); ->fecth proba el ->fetchColumn();


		//Search
		$sql = "";

		if(!empty($request['search']['value'])) {

		    $sql .= " AND (id_ficha Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
			$sql .= " OR resultado_laboratorio Like '".$request['search']['value']."%' ";
		    $sql .= " OR nro_documento Like '".$request['search']['value']."%' )";


		    $respuesta = ControladorFichas::ctrContarFiltradoFichasCentro($sql);
		}

		

		//Order
		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    	$request['start']."  ,".$request['length']."  ";


    	$fichas = ControladorFichas::ctrMostrarFichasCentro($sql);

  		$data = array();
		for ($i = 0; $i < count($fichas); $i++) {

			//$paciente = ModeloPacientesAsegurados::mdlMostrarPacientesAsegurados('pacientes_asegurados','id_ficha',$fichas[$i]['id_ficha']);

			/*=============================================
			FORMATEAMOS LAS FECHAS
			=============================================*/
			// fecha nacimiento
			if ($fichas[$i]['fecha_nacimiento'] == "0000-00-00" ) {

				$fecha_nacimiento = "";

			} else {

				$fecha_nacimiento = date("d/m/Y", strtotime($fichas[$i]['fecha_nacimiento']));
			}

			// fecha muestra
			if ($fichas[$i]['fecha_muestra'] == "0000-00-00" ) {

				$fecha_muestra = "";

			} else {

				$fecha_muestra = date("d/m/Y", strtotime($fichas[$i]['fecha_muestra']));
			}

			//fecha resultado
			if ($fichas[$i]['fecha_resultado'] == "0000-00-00" ) {

				$fecha_resultado = "";

			} else {

				$fecha_resultado = date("d/m/Y", strtotime($fichas[$i]['fecha_resultado']));
			}

			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/
			if ($fichas[$i]['tipo_ficha'] == "FICHA EPIDEMIOLOGICA") {
				
				$botonImprimir = "<button class='btn btn-danger btnImprimirFichaEpidemiologica' idFicha='".$fichas[$i]["id_ficha"]. "' data-toggle='tooltip' title='Imprimir PDF' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

				$botonEditar = "<button class='btn btn-warning btnEditarFichaEpidemiologica' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

				$botonLaboratorio = "<button class='btn btn-info btnAgregarResultadoLab' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Agregar Resultado' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-vial'></i></button>";

				$botonConcentimiento = "<button class='btn btn-dark btnImprimrConcentimiento'  idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir Consentimiento' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-file-word'></i></button>";

				$botonCertificadoMedico = "<button class='btn btn-success btnCertificadoMedico' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir Certificado Medico' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fa fa-certificate'></i></button>";

				$botonBajaSospecha = "<button class='btn btn-primary btnMostrarFormBaja' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='modal' data-target='#modalFormBaja' data-toggle='tooltip' title='Formulario de Baja Sospechoso' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fab fa-wpforms'></i></button>";
				
				$botonBajaSospechaDisabled = "<button class='btn btn-primary btnMostrarFormBaja' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='modal' data-target='#modalFormBaja' data-toggle='tooltip' title='Formulario de Baja Sospechoso ya emitido!'  data-code='".$fichas[$i]["cod_afiliado"]. "' disabled><i class='fab fa-wpforms'></i></button>";
			
				$botonCertificadoDeAlto = "<button class='btn btn-primary btnCertificadoDeAlta' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir Certificado De Alta' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fa fa-cogs'></i></button>";
			} else {

				$botonImprimir = "<button class='btn btn-danger btnImprimirFichaControl' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

				$botonEditar = "<button class='btn btn-warning btnEditarFichaControl' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

				$botonLaboratorio = "<button class='btn btn-info btnAgregarResultadoControlLab' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Agregar Resultado'><i class='fas fa-vial'></i></button>";

			}

			if ($this->perfil == "ADMIN_SYSTEM") {

				// Agrupamos los botones	
				$botonEliminarficha = "<button class='btn btn-danger btnEliminarFicha' idFicha='".$fichas[$i]["id_ficha"]. "' data-toggle='tooltip' title='Eliminar Ficha' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-trash-alt'></i></button>";
				
				if($fichas[$i]["estado_ficha"] == 0)
					$botones = "<div class='btn-group'>".$botonEditar.$botonEliminarficha."</div>";
				else 	
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonLaboratorio.$botonConcentimiento.$botonCertificadoMedico.$botonBajaSospecha."</div>";
			
			} else if ($this->perfil == "MEDICO") {

				if ($fichas[$i]["estado_ficha"] == 0){
					$botones = "<div class='btn-group'>".$botonEditar."</div>";
				}
				else if($fichas[$i]['resultado_laboratorio'] == "") {  //Cuando aun no tiene resultado

					$emitioBajaSospecha = ControladorBajasExterno:: ctrMostrarFormularioBajaExterno('id_ficha',$fichas[$i]["id_ficha"]);
					if($emitioBajaSospecha != "" && count($emitioBajaSospecha) > 0) //Verificamos si ya se emitio la baja por sospecha
						$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonConcentimiento.$botonBajaSospechaDisabled."</div>";
					else $botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonConcentimiento.$botonBajaSospecha."</div>";	
							
				} else { //Cuando ya tiene resultado					
					$botones = "<div class='btn-group'>".$botonImprimir.$botonConcentimiento."</div>";
				}					

			}else{
				$botones = "";
			}

			$subdata = array();
		    $subdata[] = $fichas[$i]["id_ficha"]; 
		    $subdata[] = $fichas[$i]["tipo_ficha"];
		    $subdata[] = $fichas[$i]["cod_asegurado"]; 
		    $subdata[] = $fichas[$i]["nombre_completo"]; 
		    $subdata[] = $fichas[$i]["nro_documento"];  
		    $subdata[] = $fichas[$i]["sexo"]; 
		    $subdata[] = $fecha_nacimiento; 
		    $subdata[] = $fecha_muestra; 

			if( $fichas[$i]["resultado_laboratorio"] == 'undefined')
		    	$subdata[] = '<span class="label warning">En espera..</span>';
			else
			    $subdata[] = $fichas[$i]["resultado_laboratorio"];

		    $subdata[] = $fecha_resultado; 
		    $subdata[] = $botones;
		    $subdata[] = $fichas[$i]["estado_ficha"];

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

	public $fecha;
	public $action;

	/*=============================================
	MOSTRAR LA TABLA DE FICHAS
	=============================================*/
		
	public function mostrarTablaFichasFechaMuestra() {

		$item = $this->action;
		$valor = $this->fecha;

		$fichas = ControladorFichas::ctrMostrarFichasFecha($item, $valor);

		if ($fichas == null) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
				"data": [';

				for ($i = 0; $i < count($fichas); $i++) { 

					$loading = "<span><img src='vistas/img/cargando.gif' class='cargando hide'></span>";

					/*=============================================
					TRAEMOS LAS ACCIONES
					=============================================*/
					if ($fichas[$i]['tipo_ficha'] == "FICHA EPIDEMIOLOGICA") {
						
						$botonImprimir = "<button class='btn btn-danger btnImprimirFichaEpidemiologica' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF'><i class='fas fa-file-pdf'></i></button>";

						$botonEditar = "<button class='btn btn-warning btnEditarFichaEpidemiologica' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

						$botonLaboratorio = "<button class='btn btn-info btnAgregarResultadoLab' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Agregar Resultado'><i class='fas fa-vial'></i></button>";

						
					} else {

						$botonImprimir = "<button class='btn btn-danger btnImprimirFichaControl' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF'><i class='fas fa-file-pdf'></i></button>";

						$botonEditar = "<button class='btn btn-warning btnEditarFichaControl' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

						$botonLaboratorio = "<button class='btn btn-info btnAgregarResultadoControlLab' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Agregar Resultado'><i class='fas fa-vial'></i></button>";

					}

					if ($_GET["perfilOculto"] == "ADMIN_SYSTEM") {

						// Agrupamos los botones
						$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonLaboratorio.$loading."</div>";

					} else if ($_GET["perfilOculto"] == "MEDICO") {

						if ($fichas[$i]['resultado_laboratorio'] == "") {

							// Agrupamos los botones
							$botones = "<div class='btn-group'>".$botonEditar."</div>";
						} else {

							// Agrupamos los botones
							$botones = "<div class='btn-group'>".$botonImprimir.$loading."</div>";
						}					

					} else if ($_GET["perfilOculto"] == "ESTADISTICA" || $_GET["perfilOculto"] == "LABORATORISTA") {

						// Agrupamos los botones
						$botones = "<div class='btn-group'>".$botonLaboratorio."</div>";

					} else {

						$botones = "";

					}

					if ($_GET["perfilOculto"] == "ESTADISTICA" || $_GET["perfilOculto"] == "LABORATORISTA" && $fichas[$i]["estado_ficha"] == 1) {

						$datosJson .='[					
							"'.$fichas[$i]['id_ficha'].'",
							"'.$fichas[$i]['tipo_ficha'].'",
							"'.$fichas[$i]['cod_asegurado'].'",
							"'.$fichas[$i]['nombre_completo'].'",
							"'.$fichas[$i]['nro_documento'].'",
							"'.$fichas[$i]['sexo'].'",
							"'.date("d/m/Y", strtotime($fichas[$i]["fecha_nacimiento"])).'",
							"'.date("d/m/Y", strtotime($fichas[$i]['fecha_muestra'])).'",
							"'.$fichas[$i]['resultado_laboratorio'].'",
							"'.date("d/m/Y", strtotime($fichas[$i]["fecha_resultado"])).'",
							"'.$botones.'"
						],';

					}

					if ($_GET["perfilOculto"] == "ADMIN_SYSTEM" || $_GET["perfilOculto"] == "MEDICO") {

						$datosJson .='[					
							"'.$fichas[$i]['id_ficha'].'",
							"'.$fichas[$i]['tipo_ficha'].'",
							"'.$fichas[$i]['cod_asegurado'].'",
							"'.$fichas[$i]['nombre_completo'].'",
							"'.$fichas[$i]['nro_documento'].'",
							"'.$fichas[$i]['sexo'].'",
							"'.date("d/m/Y", strtotime($fichas[$i]["fecha_nacimiento"])).'",
							"'.date("d/m/Y", strtotime($fichas[$i]['fecha_muestra'])).'",
							"'.$fichas[$i]['resultado_laboratorio'].'",
							"'.date("d/m/Y", strtotime($fichas[$i]["fecha_resultado"])).'",
							"'.$botones.'"
						],';
						
					}

				}

				$datosJson = substr($datosJson, 0, -1);

			$datosJson .= ']

			}';

		}
		
		echo $datosJson;
	
	}

	public function mostrarTablaFichasFechaResultado(){

	}

	public function crearFichaSeguimiento() {

		$request = $this->request;

		$col = array(
		    0   =>  'id_ficha',
		    1   =>  'cod_asegurado',
		    2   =>  'nombre_completo',
		    3   =>  'nro_documento'
		);  //create column like table in database

		$totalData = ControladorFichas::ctrContarFichasSeguimiento();
		
		$totalFilter = $totalData;

		// echo json_encode($totalData);

		//Search
		$sql = "";

		if(!empty($request['search']['value'])) {

		    $sql .= " AND (id_ficha Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
		    $sql .= " OR nro_documento Like '".$request['search']['value']."%' )";
		}

		$respuesta = ControladorFichas::ctrContarFiltradoFichasSeguimiento($sql);

		//Order
		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    	$request['start']."  ,".$request['length']."  ";


    	$fichas = ControladorFichas::ctrMostrarFichasSeguimiento($sql);

  		$data = array();

		for ($i = 0; $i < count($fichas); $i++) {
		
			/*=============================================
			FORMATEAMOS LAS FECHAS
			=============================================*/
			// fecha nacimiento
			if ($fichas[$i]['fecha_nacimiento'] == "0000-00-00" ) {

				$fecha_nacimiento = "";

			} else {

				$fecha_nacimiento = date("d/m/Y", strtotime($fichas[$i]['fecha_nacimiento']));
			}

			// fecha muestra
			if ($fichas[$i]['fecha_muestra'] == "0000-00-00" ) {

				$fecha_muestra = "";

			} else {

				$fecha_muestra = date("d/m/Y", strtotime($fichas[$i]['fecha_muestra']));
			}

			//fecha resultado
			if ($fichas[$i]['fecha_resultado'] == "0000-00-00" ) {

				$fecha_resultado = "";

			} else {

				$fecha_resultado = date("d/m/Y", strtotime($fichas[$i]['fecha_resultado']));
			}

			/*=============================================
			CREACION DE LOS BOTONES DE ACUERDO A LA FICHA
			=============================================*/
			if ($fichas[$i]['resultado_laboratorio'] == "POSITIVO") {
				
				$botonAgregarSeguimiento = "<button class='btn btn-success btnSeguimiento' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Crear Ficha de Seguimiento'><i class='fas fa-shoe-prints'></i></button>";

			} else {

				$botonAgregarSeguimiento = "<button class='btn btn-success btnSeguimiento' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Crear Ficha de Seguimiento'><i class='fas fa-shoe-prints'></i></button>";
			}

			if ($this->perfil == "ADMIN_SYSTEM") {
				// Agrupamos los botones
				$botones = "<div class='btn-group'>".$botonAgregarSeguimiento."</div>";

			} else if ($this->perfil == "MEDICO") {

				if ($fichas[$i]['resultado_laboratorio'] == "") {
					// Agrupamos los botones
					$botones = "<div class='btn-group'>".$botonAgregarSeguimiento."</div>";					
				} else {
					// Agrupamos los botones					
					$botones = "<div class='btn-group'>".$botonAgregarSeguimiento."</div>";
				}					

			} else {

				$botones = "";

			}

			$subdata = array();
		    $subdata[] = $fichas[$i]["id_ficha"]; 
		    /* $subdata[] = $fichas[$i]["tipo_ficha"]; */
		    $subdata[] = $fichas[$i]["cod_asegurado"]; 
		    $subdata[] = $fichas[$i]["nombre_completo"]; 
		    $subdata[] = $fichas[$i]["nro_documento"];  
		    /* $subdata[] = $fichas[$i]["sexo"];  */
		    $subdata[] = $fecha_nacimiento; 
		    $subdata[] = $fecha_muestra; 
		    $subdata[] = $fichas[$i]["resultado_laboratorio"]; 
		    $subdata[] = $fecha_resultado; 
		    $subdata[] = $botones;
		    $subdata[] = $fichas[$i]["estado_ficha"];

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

	public function mostrarTablaFichasSeguimiento() {

		$request = $this->request;

		$col = array(
		    0   =>  'id_ficha',
		    1   =>  'cod_asegurado',
		    2   =>  'nombre_completo',
		    3   =>  'nro_documento'
		);  //create column like table in database

		$totalData = ControladorFichas::ctrContarFichasSeguimientoTableSeguimientos(); 
		
		$totalFilter = $totalData;

		// echo json_encode($totalData);

		//Search
		$sql = "";

		if(!empty($request['search']['value'])) {

		    $sql .= " AND (id_ficha Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
		    $sql .= " OR nro_documento Like '".$request['search']['value']."%' )";
		}

		$respuesta = ControladorFichas::ctrContarFiltradoFichasSeguimientoTableSeguimiento($sql); 

		//Order
		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    	$request['start']."  ,".$request['length']."  ";


    	$fichas = ControladorFichas::ctrMostrarFichasSeguimientoTableSeguimiento($sql); 

  		$data = array();

		for ($i = 0; $i < count($fichas); $i++) {
		
			/*=============================================
			FORMATEAMOS LAS FECHAS
			=============================================*/
			// fecha fecha_aislamiento
/* 			if ($fichas[$i]['fecha_aislamiento'] == "0000-00-00" ) {

				$fecha_nacimiento = "";

			} else {

				$fecha_nacimiento = date("d/m/Y", strtotime($fichas[$i]['fecha_aislamiento']));
			}

			// fecha fecha_internacion
			if ($fichas[$i]['fecha_internacion'] == "0000-00-00" ) {

				$fecha_muestra = "";

			} else {

				$fecha_muestra = date("d/m/Y", strtotime($fichas[$i]['fecha_internacion']));
			}

			//fecha fecha_UTI
			if ($fichas[$i]['fecha_UTI'] == "0000-00-00" ) {

				$fecha_resultado = "";

			} else {

				$fecha_resultado = date("d/m/Y", strtotime($fichas[$i]['fecha_UTI']));
			} */

			/*=============================================
			CREACION DE LOS BOTONES DE ACUERDO A LA FICHA
			=============================================*/
		
			$botonImprimir = "<button class='btn btn-danger btnImprimirSeguimiento' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$fichas[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

			$botonEditar = "<button class='btn btn-warning btnEditarFichaSeguimiento' idFicha='".$fichas[$i]["id_ficha"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

			if ($this->perfil == "ADMIN_SYSTEM") {
				// Agrupamos los botones
				$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";

			} else if ($this->perfil == "MEDICO") {

				if ($fichas[$i]['resultado_laboratorio'] == "") {
					// Agrupamos los botones
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";					
				} else {
					// Agrupamos los botones					
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";
				}					

			} else {

				$botones = "";

			}

			$subdata = array();
		    $subdata[] = $fichas[$i]["id_ficha"]; 
		    /* $subdata[] = $fichas[$i]["tipo_ficha"]; */
		    $subdata[] = $fichas[$i]["cod_asegurado"]; 
		    $subdata[] = $fichas[$i]["nombre_completo"]; 
		    $subdata[] = $fichas[$i]["nro_documento"];  
		    /* $subdata[] = $fichas[$i]["sexo"];  */
		    /* $subdata[] = $fecha_nacimiento;  */
		    /* $subdata[] = $fecha_muestra;  */
		    $subdata[] = $fichas[$i]["resultado_laboratorio"]; 
		   /*  $subdata[] = $fecha_resultado;  */
		   $subdata[] = $fichas[$i]["nro_control"];
		    $subdata[] = $botones;
		    /* $subdata[] = $fichas[$i]["estado_ficha"]; */
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

	public function controlarBDCovidLaboratorio(){

		$respuestaLab = ControladorLaboratorios::ctrMostrarLaboratoriosAll();
		$respuestaCovidR = ControladorCovidResultados::ctrMostrarCovidResultados(null,null);
		$correctos = array();
		$incorrectos = array();
		foreach($respuestaLab as $keyLab => $valueLab){
			foreach($respuestaCovidR as $keyCr => $valueCr){
				if($valueLab['id_ficha'] ==  $valueCr['id_ficha']){
					if($valueLab['pruebaAntigenica'] ==  $valueCr['pruebaAntigenica'] && 
					   $valueLab['tiempoReal'] ==  $valueCr['tiempoReal'] && 
					   $valueLab['genExpert'] ==  $valueCr['genExpert'] && 
					   $valueLab['resultado_laboratorio'] ==  $valueCr['resultado']){
						array_push($correctos,$valueCr);
						//En esta seccion se tiene k actualizar la tabla covid resultados
						break;	
					}
					else{
						//En esta seccion se tiene k actualizar la tabla covid resultados
						$items = ['metodo_diagnostico_pcr_tiempo_real','metodo_diagnostico_pcr_genexpert','metodo_diagnostico_prueba_antigenica','resultado'];
						$datos = [$valueLab['tiempoReal'], $valueLab['genExpert'], $valueLab['pruebaAntigenica'], $valueLab['resultado_laboratorio']];
						ControladorCovidResultados::mdlEditarCamposCovidResultado($valueCr['id_ficha'], $items, $datos);
						
						array_push($incorrectos,$valueCr);
						break;
					}	
				}
			}
		}

		$respuesta = array();
		array_push($respuesta,$correctos);
		array_push($respuesta,$incorrectos);

/* 		$respuesta = array();
		array_push($respuesta,$respuestaLab);
		array_push($respuesta,$respuestaCovidR); */
		
		//var_dump($respuesta);
		echo json_encode($respuesta);
	}

}

/*=============================================
ACTIVAR TABLA FICHAS
=============================================*/

if (isset($_GET["actionBuscarFichaFecha"])) {

	if ($_GET["actionBuscarFichaFecha"] == "fecha_resultado") {

		$activarFichas = new TablaFichas();
		$activarFichas -> action = $_GET["actionBuscarFichaFecha"];
		$activarFichas -> fecha = $_GET["fecha"];
		$activarFichas -> mostrarTablaFichasFechaResultado();

	} else if ($_GET["actionBuscarFichaFecha"] == "fecha_muestra") {

		$activarFichas = new TablaFichas();
		$activarFichas -> action = $_GET["actionBuscarFichaFecha"];
		$activarFichas -> fecha = $_GET["fecha"];
		$activarFichas -> mostrarTablaFichasFechaMuestra();

	// } else if ($_GET["actionCovidResultados"] == "lab") {

	// 	$activarCovidResultados = new TablaCovidResultados();
	// 	$activarCovidResultados -> mostrarTablaCovidResultadosLab();

	// } else if ($_GET["actionBuscarFichaFecha"] == "centro") {

	// 	$activarFichas = new TablaFichas();
	// 	$activarFichas -> mostrarTablaFichas();

	}

}

if (isset($_POST["actionFichas"])) { 

	if ($_POST["actionFichas"] == "lab") {

		// var_dump($_REQUEST);

		$activarFichas = new TablaFichas();
		$activarFichas -> request = $_REQUEST;
		$activarFichas -> perfil = $_POST["perfilOculto"];
		$activarFichas -> mostrarTablaFichasLab();

	} else if ($_POST["actionFichas"] == "centro") {

		$activarFichas = new TablaFichas();
		$activarFichas -> request = $_REQUEST;
		$activarFichas -> perfil = $_POST["perfilOculto"];
		$activarFichas -> mostrarTablaFichasCentro();

	}
	else if($_POST["actionFichas"] == "crearFichaSeguimiento"){
		$activarFichas = new TablaFichas();
		$activarFichas -> request = $_REQUEST;
		$activarFichas -> perfil = $_POST["perfilOculto"];
		$activarFichas -> crearFichaSeguimiento();
	}
	else if($_POST["actionFichas"] == "listarFichasSeguimiento"){
		$activarFichas = new TablaFichas();
		$activarFichas -> request = $_REQUEST;
		$activarFichas -> perfil = $_POST["perfilOculto"];
		$activarFichas -> mostrarTablaFichasSeguimiento();
	}
}

if (isset($_POST["controlarBD"])) {
	if($_POST["controlarBD"] == "unificarLabCovid"){
		$activarFichas = new TablaFichas();
		$activarFichas -> request = $_REQUEST;
		$activarFichas -> controlarBDCovidLaboratorio();
	}
}