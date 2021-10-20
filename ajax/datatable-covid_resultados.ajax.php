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


class TablaCovidResultados {

	public $request;
	public $perfil;

	/*=============================================
	MOSTRAR LA TABLA DE DE AFILIADOS CON RESULTADOS DE LABORATORIO COVID PARA LABORATORIO
	=============================================*/
		
	public function mostrarTablaCovidResultadosLab() {

		$request = $this->request;

		$col = array(
		    0   =>  'id',
		    1   =>  'cod_asegurado',
		    2   =>  'nombre_completo',
		    3   =>  'documento_ci',
			4   =>  'resultado',
			5   =>  'cod_laboratorio'
		);  //create column like table in database

		// Devuelve el número de columnas que tiene la tabla
		$totalData = ControladorCovidResultados::ctrContarCovidResultadosLab();

		$totalFilter = $totalData;

		// echo json_encode($totalData);

		//Search
		$sql = "";

		if(!empty($request['search']['value'])) {

		    $sql .= " AND (id Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
			$sql .= " OR resultado Like '".$request['search']['value']."%' ";
			$sql .= " OR cod_laboratorio Like '%".$request['search']['value']."%' ";
		    $sql .= " OR documento_ci Like '".$request['search']['value']."%' )";

		}

		$respuesta = ControladorCovidResultados::ctrContarFiltradoCovidResultadosLab($sql);

		//Order
		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    	$request['start']."  ,".$request['length']."  ";


    	$covidResultados = ControladorCovidResultados::ctrMostrarCovidResultadosLab($sql);

  		$data = array();

		for ($i = 0; $i < count($covidResultados); $i++) { 

			/*=============================================
			RESULTADO LABORATORIO
			=============================================*/	

			if ($covidResultados[$i]["resultado"] == "POSITIVO") {
				
				$resultado = "<button class='btn btn-danger' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

			} else {

				if ($covidResultados[$i]["resultado"] == "NEGATIVO")
				    $resultado = "<button class='btn btn-success' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";
				else
				    $resultado = "<button class='btn btn-warning' idCovidResultado='".$covidResultados[$i]["id"]."'>"."EN ESPERA..."."</button>";	

			}

			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/

			$botonEditar = "<button class='btn btn-warning btnEditarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

			$botonEliminar ="<button class='btn btn-danger btnEliminarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' codAsegurado='".$covidResultados[$i]["cod_asegurado"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";

			$botonImprimir = "<button class='btn btn-danger btnImprimirCovidResultadoLab' idFicha='".$covidResultados[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

			if (isset($this->perfil) && $this->perfil == "ADMIN_SYSTEM") {

				if ($covidResultados[$i]["estado"] != '0') {

                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='0' data-toggle='tooltip' title='Quitar Resultado Público'><i class='fas fa-download'></i></button>";

                } else {

                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='1' data-toggle='tooltip' title='Publicar Resultado'><i class='fas fa-upload'></i></button>";

                }

                // Agrupamos los botones
				$botones = "<div class='btn-group'>".$botonEditar.$botonEliminar.$botonPublicar."</div>";
				
			} else {

				if ($covidResultados[$i]["estado"] != '0') {

					// Agrupamos los botones (Si se publico el resultado no se podra modificar por los usuarios)
					// Daniel
					$botones = "<div class='btn-group'>".$botonImprimir."</div>";

                } else {

					if ($covidResultados[$i]["resultado"] == "POSITIVO" || $covidResultados[$i]["resultado"] == "NEGATIVO" ) {
						$botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='1' data-toggle='tooltip' title='Publicar Resultado'><i class='fas fa-upload'></i></button>";
					}
					else{
						$botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='1' data-toggle='tooltip' title='Publicar Resultado' disabled><i class='fas fa-upload'></i></button>";
					}                
                    // Agrupamos los botones
					$botones = "<div class='btn-group'>".$botonEditar.$botonPublicar."</div>";

                }

			}

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
		    $subdata[] = $covidResultados[$i]["muestra_control"]; 
		    $subdata[] = $covidResultados[$i]["nombre_depto"]; 
		    $subdata[] = $covidResultados[$i]["nombre_establecimiento"]; 
		    $subdata[] = $covidResultados[$i]["sexo"]; 
		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_nacimiento"])); 
		    $subdata[] = $covidResultados[$i]["telefono"]; 
		    $subdata[] = $covidResultados[$i]["email"]; 
		    $subdata[] = $covidResultados[$i]["nombre_localidad"]; 
		    $subdata[] = $covidResultados[$i]["zona"]; 
		    $subdata[] = $covidResultados[$i]["direccion"]; 
		    $subdata[] = $resultado; 
		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_resultado"]));
		    $subdata[] = $covidResultados[$i]["observaciones"]; 
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

	/*=============================================
	MOSTRAR LA TABLA DE DE AFILIADOS CON RESULTADOS DE LABORATORIO COVID PARA CENTRO COVID
	=============================================*/
		
	public function mostrarTablaCovidResultadosCentro() {

		$request = $this->request;

		$col = array(
		    0   =>  'id',
		    1   =>  'cod_asegurado',
		    2   =>  'nombre_completo',
		    3   =>  'documento_ci',
			4   =>  'resultado',
			5   =>  'cod_laboratorio'
		);  //create column like table in database

		$totalData = ControladorCovidResultados::ctrContarCovidResultadosCentro();

		$totalFilter = $totalData;

		// echo json_encode($totalData);

		//Search
		$sql = "";

		if(!empty($request['search']['value'])) {

		    $sql .= " AND (id Like '".$request['search']['value']."%' ";
		    $sql .= " OR cod_asegurado Like '".$request['search']['value']."%' ";
		    $sql .= " OR nombre_completo Like '".$request['search']['value']."%' ";
			$sql .= " OR resultado Like '".$request['search']['value']."%' ";
			$sql .= " OR cod_laboratorio Like '%".$request['search']['value']."%' ";
		    $sql .= " OR documento_ci Like '".$request['search']['value']."%' )";

		}

		$respuesta = ControladorCovidResultados::ctrContarFiltradoCovidResultadosCentro($sql);

		//Order
		$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    	$request['start']."  ,".$request['length']."  ";


    	$covidResultados = ControladorCovidResultados::ctrMostrarCovidResultadosCentro($sql);

  		$data = array();

		for ($i = 0; $i < count($covidResultados); $i++) { 

			/*=============================================
			RESULTADO LABORATORIO
			=============================================*/	
	
			if ($covidResultados[$i]["resultado"] == "POSITIVO") {
				
				$resultado = "<button class='btn btn-danger' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

			} else {

				$resultado = "<button class='btn btn-success' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

			}

			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/		

			$botonFormBaja = "<button class='btn btn-primary btnMostrarFormBaja' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='modal' data-target='#modalFormBaja' data-toggle='tooltip' title='Formulario de Baja' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fab fa-wpforms'></i></button>";
			$botonFormBajaDisabled = "<button class='btn btn-primary btnMostrarFormBaja' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='modal' data-target='#modalFormBaja' data-toggle='tooltip' title='Formulario de Baja' data-code='".$covidResultados[$i]["cod_afiliado"]. "' disabled><i class='fab fa-wpforms'></i></button>";
			$botonCertificadoDeAlto = "<button class='btn btn-success btnCertificadoDeAlta' idFicha='".$covidResultados[$i]["id_ficha"]."' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='tooltip' title='Imprimir Certificado De Alta' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fa fa-cogs'></i></button>";
			$botonCertificadoDeAltoDisabled = "<button class='btn btn-success btnCertificadoDeAlta' idFicha='".$covidResultados[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir Certificado De Alta' data-code='".$covidResultados[$i]["cod_afiliado"]. "' disabled><i class='fa fa-cogs'></i></button>";
			$botonCertificadoDeAltoDescartado = "<button class='btn btn-success btnCertificadoDeAltaDescartado' idFicha='".$covidResultados[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir Certificado De Alta' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fa fa-cogs'></i></button>";
			$botonCertificadoDeAltoDescartadoDisabled = "<button class='btn btn-success btnCertificadoDeAltaDescartado' idFicha='".$covidResultados[$i]["id_ficha"]."' data-toggle='tooltip' title='Imprimir Certificado De Alta' data-code='".$covidResultados[$i]["cod_afiliado"]. "' disabled><i class='fa fa-cogs'></i></button>";
			
			$tieneBaja = ModeloFormularioBajas::mdlMostrarFormularioBajas('formulario_bajas','id_covid_resultado',$covidResultados[$i]["id"]);

			if ($covidResultados[$i]["resultado"] == "POSITIVO") {        		
				if($tieneBaja != null)
					$botones = "<div class='btn-group'>".$botonFormBaja.$botonCertificadoDeAlto."</div>";
				else 
				    $botones = "<div class='btn-group'>".$botonFormBaja.$botonCertificadoDeAltoDisabled."</div>";

        	} else if ($covidResultados[$i]["resultado"] == "NEGATIVO"){
	/* 			if($tieneBaja != null)
        			$botones = "<div class='btn-group'>".$botonFormBajaDisabled.$botonCertificadoDeAltoDescartado."</div>";
				else
					$botones = "<div class='btn-group'>".$botonFormBaja.$botonCertificadoDeAltoDescartadoDisabled."</div>";	 */
				$botones = "<div class='btn-group'>".$botonCertificadoDeAltoDescartado."</div>";

        	} else $botones = "<div class='btn-group'></div>";

			if($covidResultados[$i]["fecha_recepcion"] =="0000-00-00")
			   $fecha = $covidResultados[$i]["fecha_recepcion"];
				
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
		    $subdata[] = $covidResultados[$i]["muestra_control"]; 
		    $subdata[] = $covidResultados[$i]["nombre_depto"]; 
		    $subdata[] = $covidResultados[$i]["nombre_establecimiento"]; 
		    $subdata[] = $covidResultados[$i]["sexo"]; 
		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_nacimiento"])); 
		    $subdata[] = $covidResultados[$i]["telefono"]; 
		    $subdata[] = $covidResultados[$i]["email"]; 
		    $subdata[] = $covidResultados[$i]["nombre_localidad"]; 
		    $subdata[] = $covidResultados[$i]["zona"]; 
		    $subdata[] = $covidResultados[$i]["direccion"]; 
		    $subdata[] = $resultado; 
		    $subdata[] = date("d/m/Y", strtotime($covidResultados[$i]["fecha_resultado"]));
		    $subdata[] = $covidResultados[$i]["observaciones"];
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

	/*=============================================
	MOSTRAR LA TABLA DE DE AFILIADOS CON RESULTADOS DE LABORATORIO COVID FILTRADO POR FECHA DE RESULTADO
	=============================================*/
	
	public $fecha;
	public $action;

	public function mostrarTablaCovidResultadosFechaResultado() {

		$item = $this->action;
		$valor = date("Y-m-d", strtotime($this->fecha));

		$covidResultados = ControladorCovidResultados::ctrMostrarCovidResultadosFecha($item, $valor);

		if ($covidResultados == null) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
			"data": [';

			for ($i = 0; $i < count($covidResultados); $i++) { 

				/*=============================================
				TRAEMOS EL DEPARTAMENTO
				=============================================*/

				$itemDepartamento = "id";
				$valorDepartamento = $covidResultados[$i]["id_departamento"];

				$departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($itemDepartamento, $valorDepartamento);

				/*=============================================
				TRAEMOS EL ESTABLECIMIENTO
				=============================================*/

				$itemEstablecimiento = "id";
				$valorEstablecimiento = $covidResultados[$i]["id_establecimiento"];

				$establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($itemEstablecimiento, $valorEstablecimiento);

				/*=============================================
				TRAEMOS LA LOCALIDAD
				=============================================*/

				$itemLocalidad = "id";
				$valorLocalidad = $covidResultados[$i]["id_localidad"];

				$localidades = ControladorLocalidades::ctrMostrarLocalidades($itemLocalidad, $valorLocalidad);


				/*=============================================
				RESULTADO LABORATORIO
				=============================================*/	

				if ($covidResultados[$i]["resultado"] == "POSITIVO") {
					
					$resultado = "<button class='btn btn-danger' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

				} else {

					$resultado = "<button class='btn btn-success' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

				}

				/*=============================================
					TRAEMOS LAS ACCIONES
				=============================================*/

				$botonEditar = "<button class='btn btn-warning btnEditarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";

				$botonEliminar ="<button class='btn btn-danger btnEliminarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' codAsegurado='".$covidResultados[$i]["cod_asegurado"]."' foto='".$covidResultados[$i]["foto"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";

				$botonImprimir = "<button class='btn btn-danger btnImprimirCovidResultadoLab' idFicha='".$covidResultados[$i]["id"]."' data-toggle='tooltip' title='Imprimir PDF' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fas fa-file-pdf'></i></button>";

				// REVISAR

				if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "ADMIN_SYSTEM") {

					if ($covidResultados[$i]["estado"] != '0') {

	                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='0' data-toggle='tooltip' title='Quitar Resultado Público'><i class='fas fa-download'></i></button>";

	                } else {

	                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='1' data-toggle='tooltip' title='Publicar Resultado'><i class='fas fa-upload'></i></button>";

	                }

	                // Agrupamos los botones
					$botones = "<div class='btn-group'>".$botonEditar.$botonEliminar.$botonPublicar."</div>";
					
				} else {

					if ($covidResultados[$i]["estado"] != '0') {

	                    // Agrupamos los botones (Si se publico el resultado no se podra modificar por los usuarios)
						//$botones = "<div class='btn-group'></div>";
						$botones = "<div class='btn-group'>".$botonImprimir."</div>";

	                } else {

	                    $botonPublicar = "<button class='btn btn-info btnPublicarCovidResultado' idCovidResultado='".$covidResultados[$i]["id"]."' estadoResultado='1' data-toggle='tooltip' title='Publicar Resultado'><i class='fas fa-upload'></i></button>";

	                    // Agrupamos los botones
						$botones = "<div class='btn-group'>".$botonEditar.$botonEliminar.$botonPublicar."</div>";

	                }

				}
				

				$datosJson .='[
					"'.$covidResultados[$i]["cod_laboratorio"].'",	
					"'.$covidResultados[$i]["cod_asegurado"].'",
					"'.$covidResultados[$i]["cod_afiliado"].'",	
					"'.$covidResultados[$i]["paterno"].' '.$covidResultados[$i]["materno"].' '.$covidResultados[$i]["nombre"].'",
					"'.$covidResultados[$i]["documento_ci"].'",
					"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_recepcion"])).'",
					"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_muestra"])).'",
					"'.$covidResultados[$i]["tipo_muestra"].'",
					"'.$covidResultados[$i]["muestra_control"].'",
					"'.$departamentos["nombre_depto"].'",
					"'.$establecimientos["nombre_establecimiento"].'",
					"'.$covidResultados[$i]["sexo"].'",
					"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_nacimiento"])).'",
					"'.$covidResultados[$i]["telefono"].'",
					"'.$covidResultados[$i]["email"].'",
					"'.$localidades["nombre_localidad"].'",
					"'.$covidResultados[$i]["zona"].'",
					"'.$covidResultados[$i]["calle"].' '.$covidResultados[$i]["nro_calle"].'",
					"'.$resultado.'",
					"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_resultado"])).'",
					"'.$covidResultados[$i]["observaciones"].'",
					"'.$botones.'",
					"'.$covidResultados[$i]["estado"].'"
				],';
			}

			$datosJson = substr($datosJson, 0, -1);

			$datosJson .= ']
			}';	

		}

		echo $datosJson;
	
	}

	/*=============================================
	MOSTRAR LA TABLA DE DE AFILIADOS CON RESULTADOS DE LABORATORIO COVID FILTRADO POR FECHA DE MUESTRA
	=============================================*/

	public function mostrarTablaCovidResultadosFechaMuestra() {

		$item = $this->action;
		$valor = date("Y-m-d", strtotime($this->fecha));

		$covidResultados = ControladorCovidResultados::ctrMostrarCovidResultadosFecha($item, $valor);

		if ($covidResultados == null) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
			"data": [';

			for ($i = 0; $i < count($covidResultados); $i++) { 

				/*=============================================
				TRAEMOS EL DEPARTAMENTO
				=============================================*/

				$itemDepartamento = "id";
				$valorDepartamento = $covidResultados[$i]["id_departamento"];

				$departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($itemDepartamento, $valorDepartamento);

				/*=============================================
				TRAEMOS EL ESTABLECIMIENTO
				=============================================*/

				$itemEstablecimiento = "id";
				$valorEstablecimiento = $covidResultados[$i]["id_establecimiento"];

				$establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($itemEstablecimiento, $valorEstablecimiento);

				/*=============================================
				TRAEMOS LA LOCALIDAD
				=============================================*/

				$itemLocalidad = "id";
				$valorLocalidad = $covidResultados[$i]["id_localidad"];

				$localidades = ControladorLocalidades::ctrMostrarLocalidades($itemLocalidad, $valorLocalidad);


				/*=============================================
				RESULTADO LABORATORIO
				=============================================*/	

				if ($covidResultados[$i]["resultado"] == "POSITIVO") {
					
					$resultado = "<button class='btn btn-danger' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

				} else {

					$resultado = "<button class='btn btn-success' idCovidResultado='".$covidResultados[$i]["id"]."'>".$covidResultados[$i]["resultado"]."</button>";

				}

				/*=============================================
				TRAEMOS LAS ACCIONES
				=============================================*/		

				$botonFormBaja = "<button class='btn btn-primary btnMostrarFormBaja' idCovidResultado='".$covidResultados[$i]["id"]."' data-toggle='modal' data-target='#modalFormBaja' data-toggle='tooltip' title='Formulario de Baja' data-code='".$covidResultados[$i]["cod_afiliado"]. "'><i class='fab fa-wpforms'></i></button>";

				if ($covidResultados[$i]["resultado"] == "POSITIVO") {

            		$botones = "<div class='btn-group'>".$botonFormBaja."</div>";

            	} else {

            		$botones = "<div class='btn-group'></div>";

            	}		
					

				if (isset($_GET["perfilOculto"]) && $_GET["perfilOculto"] == "MEDICO" && $covidResultados[$i]["estado"] == "0") {

				

				} else {

					$datosJson .='[
						"'.$covidResultados[$i]["cod_laboratorio"].'",	
						"'.$covidResultados[$i]["cod_asegurado"].'",
						"'.$covidResultados[$i]["cod_afiliado"].'",	
						"'.$covidResultados[$i]["paterno"].' '.$covidResultados[$i]["materno"].' '.$covidResultados[$i]["nombre"].'",
						"'.$covidResultados[$i]["documento_ci"].'",
						"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_recepcion"])).'",
						"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_muestra"])).'",
						"'.$covidResultados[$i]["tipo_muestra"].'",
						"'.$covidResultados[$i]["muestra_control"].'",
						"'.$departamentos["nombre_depto"].'",
						"'.$establecimientos["nombre_establecimiento"].'",
						"'.$covidResultados[$i]["sexo"].'",
						"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_nacimiento"])).'",
						"'.$covidResultados[$i]["telefono"].'",
						"'.$covidResultados[$i]["email"].'",
						"'.$localidades["nombre_localidad"].'",
						"'.$covidResultados[$i]["zona"].'",
						"'.$covidResultados[$i]["calle"].' '.$covidResultados[$i]["nro_calle"].'",
						"'.$resultado.'",
						"'.date("d/m/Y", strtotime($covidResultados[$i]["fecha_resultado"])).'",
						"'.$covidResultados[$i]["observaciones"].'",
						"'.$botones.'",
						"'.$covidResultados[$i]["estado"].'"
					],';

				}

			}

			$datosJson = substr($datosJson, 0, -1);

			$datosJson .= ']
			}';	

		}

		echo $datosJson;
	
	}

}

/*=============================================
ACTIVAR TABLA DE COVID RESULTADOS
=============================================*/

if (isset($_GET["actionCovidResultados"])) {

	if ($_GET["actionCovidResultados"] == "fecha_resultado") {

		$activarCovidResultados = new TablaCovidResultados();
		$activarCovidResultados -> action = $_GET["actionCovidResultados"];
		$activarCovidResultados -> fecha = $_GET["fecha"];
		$activarCovidResultados -> mostrarTablaCovidResultadosFechaResultado();

	} else if ($_GET["actionCovidResultados"] == "fecha_muestra") {

		$activarCovidResultados = new TablaCovidResultados();
		$activarCovidResultados -> action = $_GET["actionCovidResultados"];
		$activarCovidResultados -> fecha = $_GET["fecha"];
		$activarCovidResultados -> mostrarTablaCovidResultadosFechaMuestra();

	// } else if ($_GET["actionCovidResultados"] == "lab") {

	// 	$activarCovidResultados = new TablaCovidResultados();
	// 	$activarCovidResultados -> mostrarTablaCovidResultadosLab();

	// } else if ($_GET["actionCovidResultados"] == "centro") {

	// 	$activarCovidResultados = new TablaCovidResultados();
	// 	$activarCovidResultados -> mostrarTablaCovidResultadosCentro();

	}

}

if (isset($_POST["actionCovidResultados"])) { 

	if ($_POST["actionCovidResultados"] == "lab") {

		// var_dump($_REQUEST);

		$activarCovidResultados = new TablaCovidResultados();
		$activarCovidResultados -> request = $_REQUEST;
		$activarCovidResultados -> perfil = $_POST["perfilOculto"];
		$activarCovidResultados -> mostrarTablaCovidResultadosLab();

	} else if ($_POST["actionCovidResultados"] == "centro") {

		$activarCovidResultados = new TablaCovidResultados();
		$activarCovidResultados -> request = $_REQUEST;
		$activarCovidResultados -> perfil = $_POST["perfilOculto"];
		$activarCovidResultados -> mostrarTablaCovidResultadosCentro();

	}

}