<?php

require_once "../controladores/formulario_bajas.controlador.php";
require_once "../modelos/formulario_bajas.modelo.php";
require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../controladores/establecimientos.controlador.php";

require_once "../controladores/covid_resultados.controlador.php";
require_once "../modelos/covid_resultados.modelo.php";
require_once "../modelos/formulario_bajas_externos.modelo.php";
require_once "../modelos/pacientes_asegurados.modelo.php";
require_once "../modelos/establecimientos.modelo.php";

class TablaFormularioBajas {

	/*==================================================================
	MOSTRAR TODAS LAS BAJAS RESULTO QUE TARDA MUCHO 15-35 SEGUNDOS M@RK
	====================================================================*/
		
	public function mostrarTablaFormularioBajas() {
		session_start();
		$item = null;
		$valor = null;

		$formularioBajas = ControladorFormularioBajas::ctrMostrarFormularioBajas($item, $valor);
		//$formularioBajasExterno = ModeloFormularioBajasExterno::mdlMostrarFormularioBajasExterno("formulario_bajas_externo",null,null);	//No sirve revisar	
		
		if (count($formularioBajas) == 0) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
			"data": [';

			for ($i = 0; $i < count($formularioBajas); $i++) {

				/*=============================================
				TRAEMOS EL ESTABLECIMIENTO DE CADA BAJA
				=============================================*/
				
				
				$establecimiento = "Sin definir";
				if($formularioBajas[$i]['establecimiento'] != null){
					$establecimientoBuscado = ControladorEstablecimientos::ctrMostrarEstablecimientos('id',$formularioBajas[$i]['establecimiento']);
					$establecimiento = $establecimientoBuscado['nombre_establecimiento'];
				}


				/*=============================================
				TRAEMOS LOS DATOS COVID RESULTADOS
				=============================================*/

				$itemCovidResultado = "id";
				$valorCovidResultado = $formularioBajas[$i]["id_covid_resultado"];
				$valor = $formularioBajas[$i]["id"];

				$covidResultado = null;
				$formularioBajasExterno = null;
				$paciente_asegurado = null;
				if($valorCovidResultado == -1){ //Es baja manual o baja Sospechoso
					$formularioBajasExterno = ModeloFormularioBajasExterno::mdlMostrarFormularioBajasExterno("formulario_bajas_externo","id_formulario_baja",$formularioBajas[$i]["id"]);
					$paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados("id",$formularioBajasExterno["id_pacientes_asegurados"]);
				}
				else{
					$covidResultado = ControladorCovidResultados::ctrMostrarCovidResultados($itemCovidResultado, $valorCovidResultado);
				} 

				/*=============================================
				TRAEMOS LAS ACCIONES
				=============================================*/
				if($covidResultado != null){ //tiene covid_resultado
					$botonImprimir = "<button class='btn btn-info btnImprimirFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' data-toggle='tooltip' title='Imprimir' data-code='".$covidResultado["cod_afiliado"]. "' data-idFicha='".$covidResultado["id_ficha"]. "'><i class='fas fa-print'></i></button>";
					$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
				    $botonEliminar ="<button class='btn btn-danger btnEliminarFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' imagen='".$formularioBajas[$i]["imagen"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
					
				}else if($paciente_asegurado != null){ //no tiene covid_resultado
					if($formularioBajasExterno != null && $formularioBajasExterno['tipo_baja'] == 'SOSPECHOSO'){ //Es sospechoso
						$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' esSospechoso='".$formularioBajasExterno['tipo_baja']."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
					}
					else{ //Es Manual						
						$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";						
					}
					$botonImprimir = "<button class='btn btn-info btnImprimirFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' data-toggle='tooltip' title='Imprimir' data-code='".$paciente_asegurado["cod_afiliado"]. "' data-idFicha='".$paciente_asegurado["id"]. "'><i class='fas fa-print'></i></button>";
					$botonEliminar ="<button class='btn btn-danger btnEliminarFormularioBaja' idFormularioBaja='".$formularioBajas[$i]["id"]."' imagen='".$formularioBajas[$i]["imagen"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
				}
				
				if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM" ) {
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonEliminar."</div>";
				}
				else if($_SESSION['perfilUsuarioCOVID'] == "MEDICO" ){
						// if($formularioBajasExterno != null && $formularioBajasExterno['tipo_baja'] == 'SOSPECHOSO'){
					//		$botones = "<div class='btn-group'>".$botonImprimir."</div>";
					//	}
					//	else{ 
							$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";
						//}
				} else {
					$botones = "<div class='btn-group'>".$botonImprimir."</div>";
				}

				//Quitamos todos los caracteres especiales (menos el spacio) de las observaciones para que no cause problemas con el objeto JSON
				$observaciones = $formularioBajas[$i]["observacion_baja"];
				$observacionSanitizada = preg_replace('([^A-Za-z0-9 ])', '', $observaciones);


				if($covidResultado != null){ //tiene covid_resultado
					$datosJson .='[
						"'.$covidResultado["cod_laboratorio"].'",	
						"'.$covidResultado["cod_asegurado"].'",	
						"'.$covidResultado["paterno"].' '.$covidResultado["materno"].' '.$covidResultado["nombre"].'",
						"'.str_replace('"', '\"', $covidResultado["nombre_empleador"]).'",
						"'.$covidResultado["cod_empleador"].'",
						"'.$formularioBajas[$i]["riesgo"].'",
						"'.date("d-m-Y", strtotime($formularioBajas[$i]["fecha_ini"])).'",
						"'.date("d-m-Y", strtotime($formularioBajas[$i]["fecha_fin"])).'",
						"'.$formularioBajas[$i]["dias_incapacidad"].'",
						"'.$formularioBajas[$i]["lugar"].' '.date("d-m-Y", strtotime($formularioBajas[$i]["fecha"])).'",
						"'.$formularioBajas[$i]["clave"].'",
						"'.$formularioBajas[$i]["codigo"].'",
						"'.$establecimiento.'",
						"'.$observacionSanitizada.'",
						"'.$botones.'"
					],';
				}
				else if($paciente_asegurado != null){ //no tiene covid_resultado es baja manual o sospechoso
						if($formularioBajasExterno != null && $formularioBajasExterno['id_ficha'] != null && $formularioBajasExterno['tipo_baja'] != null){ //Es baja sospechoso
							$datosJson .='[
								"SOSPECHOSO",	
								"';
						}
						else{ //Es baja manual
								$datosJson .='[
									"MANUAL",	
									"';
						}
					 
						$datosJson .= $paciente_asegurado["cod_asegurado"].'",	
							"'.$paciente_asegurado["paterno"].' '.$paciente_asegurado["materno"].' '.$paciente_asegurado["nombre"].'",
							"'.str_replace('"', '\"', $paciente_asegurado["nombre_empleador"]).'",
							"'.$paciente_asegurado["cod_empleador"].'",
							"'.$formularioBajas[$i]["riesgo"].'",
							"'.date("d-m-Y", strtotime($formularioBajas[$i]["fecha_ini"])).'",
							"'.date("d-m-Y", strtotime($formularioBajas[$i]["fecha_fin"])).'",
							"'.$formularioBajas[$i]["dias_incapacidad"].'",
							"'.$formularioBajas[$i]["lugar"].' '.date("d-m-Y", strtotime($formularioBajas[$i]["fecha"])).'",
							"'.$formularioBajas[$i]["clave"].'",
							"'.$formularioBajas[$i]["codigo"].'",
							"'.$establecimiento.'",
							"'.$observacionSanitizada.'",
							"'.$botones.'"
						],';
				}
			}

			$datosJson = substr($datosJson, 0, -1); //quitamos la ultima coma

			$datosJson .= ']
			}';
		}
		echo $datosJson;
	}

	/*====================================================================================================================
		METODO QUE MUESTRA LAS BAJAS MEJORADO ESTA CON VISTAS, TARDA 5-8 SEGUNDOS MIENTRAS CRECE MAS LA BD TARDA MAS M@rk
    ======================================================================================================================*/
	public function mostrarTablaFormularioBajasConVistas() {
		session_start();

		$bajasConCResultado = ControladorFormularioBajas::getFormularioBajasConSinCovidResultados('bajas_con_cresultados', false);
		$bajasSinCResultado = ControladorFormularioBajas::getFormularioBajasConSinCovidResultados('bajas_sin_cresultado', false);
	
		if (count($bajasConCResultado) == 0 && count($bajasSinCResultado) == 0 ) {
			
			$datosJson = '{
				"data": []
			}';
		
		} else {
		
			$datosJson = '{
			"data": [';

			/*===================================================
				MOSTRAMOS LAS BAJAS QUE NO TIENEN COVID RESULTADO
			=====================================================*/

			foreach ($bajasSinCResultado as $key => $bajaS) {

				//TRAEMOS EL ESTABLECIMIENTO DE CADA BAJA

				$establecimiento = "Sin definir";
				if($bajaS['establecimiento'] != null){
					$establecimientoBuscado = ControladorEstablecimientos::ctrMostrarEstablecimientos('id',$bajaS['establecimiento']);
					$establecimiento = $establecimientoBuscado['nombre_establecimiento'];
				}
		
				//TRAEMOS LAS ACCIONES
				
				if($bajaS['tipo_baja'] == 'SOSPECHOSO'){ //Es sospechoso
					$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' esSospechoso='".$bajaS['tipo_baja']."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
				}
				else{ //Es Manual						
					$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";						
				}
				$botonImprimir = "<button class='btn btn-info btnImprimirFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' data-toggle='tooltip' title='Imprimir' data-code='".$bajaS["cod_afiliado"]. "' data-idFicha='".$bajaS["id_paciente"]. "'><i class='fas fa-print'></i></button>";
				$botonEliminar ="<button class='btn btn-danger btnEliminarFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' imagen='".$bajaS["imagen"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
			
				
				if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM" ) {
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonEliminar."</div>";
				}
				else if($_SESSION['perfilUsuarioCOVID'] == "MEDICO" ){
						$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";
				} else {
					$botones = "<div class='btn-group'>".$botonImprimir."</div>";
				}
		
				//Quitamos todos los caracteres especiales (menos el spacio) de las observaciones para que no cause problemas con el objeto JSON
				$observaciones = $bajaS["observacion_baja"];
				$observacionSanitizada = preg_replace('([^A-Za-z0-9 ])', '', $observaciones);
		
				if($bajaS['tipo_baja'] == 'SOSPECHOSO'){  //Es baja sospechoso
					$datosJson .='[
						"SOSPECHOSO",	
						"';
				}
				else{ //Es baja manual
						$datosJson .='[
							"MANUAL",	
							"';
				}
				
				$datosJson .= $bajaS["cod_asegurado"].'",	
					"'.$bajaS["paterno"].' '.$bajaS["materno"].' '.$bajaS["nombre"].'",
					"'.str_replace('"', '\"', $bajaS["nombre_empleador"]).'",
					"'.$bajaS["cod_empleador"].'",
					"'.$bajaS["riesgo"].'",
					"'.date("d-m-Y", strtotime($bajaS["fecha_ini"])).'",
					"'.date("d-m-Y", strtotime($bajaS["fecha_fin"])).'",
					"'.$bajaS["dias_incapacidad"].'",
					"'.$bajaS["lugar"].' '.date("d-m-Y", strtotime($bajaS["fecha"])).'",
					"'.$bajaS["clave"].'",
					"'.$bajaS["codigo"].'",
					"'.$establecimiento.'",
					"'.$observacionSanitizada.'",
					"'.$botones.'"
				],';
			}

			/*=============================================
				MOSTRAMOS LAS BAJAS QUE TIENE COVID RESULTADO
			=============================================*/

			foreach ($bajasConCResultado as $key => $bajaCCR) {
		
				//TRAEMOS EL ESTABLECIMIENTO DE CADA BAJA

				$establecimiento = "Sin definir";
				if($bajaCCR['establecimiento'] != null){
					$establecimientoBuscado = ControladorEstablecimientos::ctrMostrarEstablecimientos('id',$bajaCCR['establecimiento']);
					$establecimiento = $establecimientoBuscado['nombre_establecimiento'];
				}

				//TRAEMOS LAS ACCIONES

				$botonImprimir = "<button class='btn btn-info btnImprimirFormularioBaja' idFormularioBaja='".$bajaCCR["id_baja"]."' data-toggle='tooltip' title='Imprimir' data-code='".$bajaCCR["cod_afiliado"]. "' data-idFicha='".$bajaCCR["id_ficha"]. "'><i class='fas fa-print'></i></button>";
				$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$bajaCCR["id_baja"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
				$botonEliminar ="<button class='btn btn-danger btnEliminarFormularioBaja' idFormularioBaja='".$bajaCCR["id_baja"]."' imagen='".$bajaCCR["imagen"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
					
				if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM" ) {
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonEliminar."</div>";
				}
				else if($_SESSION['perfilUsuarioCOVID'] == "MEDICO" ){
						$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";
				} else {
					$botones = "<div class='btn-group'>".$botonImprimir."</div>";
				}
		
				//Quitamos todos los caracteres especiales (menos el spacio) de las observaciones para que no cause problemas con el objeto JSON
				$observaciones = $bajaCCR["observacion_baja"];
				$observacionSanitizada = preg_replace('([^A-Za-z0-9 ])', '', $observaciones);
		
				$datosJson .='[
					"'.$bajaCCR["cod_laboratorio"].'",	
					"'.$bajaCCR["cod_asegurado"].'",	
					"'.$bajaCCR["paterno"].' '.$bajaCCR["materno"].' '.$bajaCCR["nombre"].'",
					"'.str_replace('"', '\"', $bajaCCR["nombre_empleador"]).'",
					"'.$bajaCCR["cod_empleador"].'",
					"'.$bajaCCR["riesgo"].'",
					"'.date("d-m-Y", strtotime($bajaCCR["fecha_ini"])).'",
					"'.date("d-m-Y", strtotime($bajaCCR["fecha_fin"])).'",
					"'.$bajaCCR["dias_incapacidad"].'",
					"'.$bajaCCR["lugar"].' '.date("d-m-Y", strtotime($bajaCCR["fecha"])).'",
					"'.$bajaCCR["clave"].'",
					"'.$bajaCCR["codigo"].'",
					"'.$establecimiento.'",
					"'.$observacionSanitizada.'",
					"'.$botones.'"
				],';

			}
		
			$datosJson = substr($datosJson, 0, -1); //quitamos la ultima coma
		
			$datosJson .= ']
			}';		
		}

		echo $datosJson;
		//echo json_encode($datosJson);
	
	}

	/*====================================================================================================================
	 METODO QUE MUESTRA LAS BAJAS OPTIMIZADO ES EL OFICIAL TARDA MENOS DE 1 SEGUNDO M@RK
    ======================================================================================================================*/

	public function mostrarTablaFormularioBajasConVistasOptimizado($request) {
		session_start();

		$col = array( // Parametros para el buscador datatable
            0   => 'id_baja',
		    1   => 'cod_asegurado',
		    2   => 'nombre_completo'
		); 
		// Mandamos bandera true para contar los registros obtenidos
		$registrosConResultado = ControladorFormularioBajas::getFormularioBajasConSinCovidResultados('bajas_con_cresultados', true);

		// Mandamos bandera true para contar los registros obtenidos
		$registrosBajasSinCResultado = ControladorFormularioBajas::getFormularioBajasConSinCovidResultados('bajas_sin_cresultado', true); 

		$totalData = $registrosBajasSinCResultado + $registrosConResultado;
		
		$totalFilter = $totalData;

		$sql = "";

		if(!empty($request['search']['value'])) {
			$sql .= " AND (id_baja Like '".trim($request['search']['value'])."%' ";
		    $sql .= " OR cod_asegurado Like '".trim($request['search']['value'])."%' ";
		    $sql .= " OR nombre_completo Like '".trim($request['search']['value'])."%' )";
		}

		// Mandamos bandera true para contar los registros obtenidos
		//$tamSinCR = ControladorFormularioBajas::getFormularioBajasFiltrado('bajas_sin_cresultado', $sql, true);
		//$tamConCR  = ControladorFormularioBajas::getFormularioBajasFiltrado('bajas_con_cresultados',$sql, true);

		$tamanio = 5;

		if($request['start'] == 0){
			$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
			$request['start']."  ,".$tamanio."  ";
		}
		else{
			$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
			($request['start']/2)."  ,".$tamanio."  ";
		}

		// Obtenemos las bajas con resultado covid y las sin resultado covid
    	$bajasSinCResultado = ControladorFormularioBajas::getFormularioBajasFiltrado('bajas_sin_cresultado', $sql, false);
		$bajasConCResultado = ControladorFormularioBajas::getFormularioBajasFiltrado('bajas_con_cresultados', $sql, false);

		// Controles si alguna de las vistas ya no tiene registros que mostrar
		if(count($bajasConCResultado) == 0 && empty($request['search']['value'])){ //ojo aqui hay perdida de registros mas adelante revisar cuando haya tiempo

			$sql =" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
			$request['start']."  ,".'10'."  ";

			$bajasSinCResultado = ControladorFormularioBajas::getFormularioBajasFiltrado('bajas_sin_cresultado', $sql, false);
		}
		else if(count($bajasSinCResultado) == 0 && empty($request['search']['value'])){
			$sql =" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
			$request['start']."  ,".'10'."  ";

			$bajasConCResultado = ControladorFormularioBajas::getFormularioBajasFiltrado('bajas_con_cresultados', $sql, false);
		}

  		$datosJson = array(); 

		/*=================================================
			MOSTRAMOS LAS BAJAS QUE NO TIENEN COVID RESULTADO
		===================================================*/
		foreach ($bajasSinCResultado as $key => $bajaS) {

			$datosBaja = array();

			//TRAEMOS EL ESTABLECIMIENTO DE CADA BAJA
			$establecimiento = "Sin definir";
			if($bajaS['establecimiento'] != null){
				$establecimientoBuscado = ControladorEstablecimientos::ctrMostrarEstablecimientos('id',$bajaS['establecimiento']);
				$establecimiento = $establecimientoBuscado['nombre_establecimiento'];
			}
	
			//TRAEMOS LAS ACCIONES
			
			if($bajaS['tipo_baja'] == 'SOSPECHOSO'){ //Es sospechoso
				$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' esSospechoso='".$bajaS['tipo_baja']."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
			}
			else{ //Es Manual						
				$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";						
			}
			$botonImprimir = "<button class='btn btn-info btnImprimirFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' data-toggle='tooltip' title='Imprimir' data-code='".$bajaS["cod_afiliado"]. "' data-idFicha='".$bajaS["id_paciente"]. "'><i class='fas fa-print'></i></button>";
			$botonEliminar ="<button class='btn btn-danger btnEliminarFormularioBaja' idFormularioBaja='".$bajaS["id_baja"]."' imagen='".$bajaS["imagen"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
		
			
			if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM" ) {
				$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonEliminar."</div>";
			}
			else if($_SESSION['perfilUsuarioCOVID'] == "MEDICO" ){
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";
			} else {
				$botones = "<div class='btn-group'>".$botonImprimir."</div>";
			}
	
			//Quitamos todos los caracteres especiales (menos el spacio) de las observaciones para que no cause problemas con el objeto JSON
			$observaciones = $bajaS["observacion_baja"];
			$observacionSanitizada = preg_replace('([^A-Za-z0-9ñÑáéíóúÁÉÍÓÚ#° ])', '', $observaciones);
	
			if($bajaS['tipo_baja'] == 'SOSPECHOSO'){  //Es baja sospechoso
					$datosBaja[] = "SOSPECHOSO";
			}
			else{ 
						$datosBaja[] = "MANUAL";		
			}
			
			$datosBaja[] = $bajaS["cod_asegurado"];
			$datosBaja[] = $bajaS["paterno"].' '.$bajaS["materno"].' '.$bajaS["nombre"];
			$datosBaja[] = str_replace('"', '\"', $bajaS["nombre_empleador"]);
			$datosBaja[] = $bajaS["cod_empleador"];
			$datosBaja[] = $bajaS["riesgo"];
			$datosBaja[] = date("d-m-Y", strtotime($bajaS["fecha_ini"]));
			$datosBaja[] = date("d-m-Y", strtotime($bajaS["fecha_fin"]));
			$datosBaja[] = $bajaS["dias_incapacidad"];
			$datosBaja[] = $bajaS["lugar"].' '.date("d-m-Y", strtotime($bajaS["fecha"]));
			$datosBaja[] = $bajaS["clave"];
			$datosBaja[] = $bajaS["codigo"];
			$datosBaja[] = $establecimiento;
			$datosBaja[] = $observacionSanitizada;
			$datosBaja[] = $botones;

			// Almacenamos el array
			array_push($datosJson,$datosBaja);
		}

		/*================================================
			MOSTRAMOS LAS BAJAS QUE TIENEN COVID RESULTADO
		==================================================*/
		
		foreach ($bajasConCResultado as $key => $bajaCCR) {

			$datosBaja = array();
	
			//TRAEMOS EL ESTABLECIMIENTO DE CADA BAJA

			$establecimiento = "Sin definir";
			if($bajaCCR['establecimiento'] != null){
				$establecimientoBuscado = ControladorEstablecimientos::ctrMostrarEstablecimientos('id',$bajaCCR['establecimiento']);
				$establecimiento = $establecimientoBuscado['nombre_establecimiento'];
			}

			//TRAEMOS LAS ACCIONES

			$botonImprimir = "<button class='btn btn-info btnImprimirFormularioBaja' idFormularioBaja='".$bajaCCR["id_baja"]."' data-toggle='tooltip' title='Imprimir' data-code='".$bajaCCR["cod_afiliado"]. "' data-idFicha='".$bajaCCR["id_ficha"]. "'><i class='fas fa-print'></i></button>";
			$botonEditar = "<button class='btn btn-warning btnEditarFormularioBaja' idFormularioBaja='".$bajaCCR["id_baja"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
			$botonEliminar ="<button class='btn btn-danger btnEliminarFormularioBaja' idFormularioBaja='".$bajaCCR["id_baja"]."' imagen='".$bajaCCR["imagen"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-trash-alt'></i></button>";
				
			if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM" ) {
				$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonEliminar."</div>";
			}
			else if($_SESSION['perfilUsuarioCOVID'] == "MEDICO" ){
					$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";
			} else {
				$botones = "<div class='btn-group'>".$botonImprimir."</div>";
			}
	
			//Quitamos todos los caracteres especiales (menos el spacio) de las observaciones para que no cause problemas con el objeto JSON
			$observaciones = $bajaCCR["observacion_baja"];
			$observacionSanitizada = preg_replace('([^A-Za-z0-9ñÑáéíóúÁÉÍÓÚ#° ])', '', $observaciones); //a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ 

			$datosBaja[] = $bajaCCR["cod_laboratorio"];
			$datosBaja[] = $bajaCCR["cod_asegurado"];
			$datosBaja[] = $bajaCCR["paterno"].' '.$bajaCCR["materno"].' '.$bajaCCR["nombre"];
			$datosBaja[] = str_replace('"', '\"', $bajaCCR["nombre_empleador"]);
			$datosBaja[] = $bajaCCR["cod_empleador"];
			$datosBaja[] = $bajaCCR["riesgo"];
			$datosBaja[] = date("d-m-Y", strtotime($bajaCCR["fecha_ini"]));
			$datosBaja[] = date("d-m-Y", strtotime($bajaCCR["fecha_fin"]));
			$datosBaja[] = $bajaCCR["dias_incapacidad"];
			$datosBaja[] = $bajaCCR["lugar"].' '.date("d-m-Y", strtotime($bajaCCR["fecha"]));
			$datosBaja[] = $bajaCCR["clave"];
			$datosBaja[] = $bajaCCR["codigo"];
			$datosBaja[] = $establecimiento;
			$datosBaja[] = $observacionSanitizada;
			$datosBaja[] = $botones;

			// Almacenamos el array
			array_push($datosJson,$datosBaja);

		}
		
		$json_data = array(
		    "draw"              =>  intval($request['draw']),
		    "recordsTotal"      =>  intval($totalData),
		    "recordsFiltered"   =>  intval($totalFilter),
		    "data"              =>  $datosJson
		);

		echo json_encode($json_data);
	}
}

/*=============================================
ACTIVAR TABLA DE COVIDRESULTADOS
=============================================*/

if (isset($_GET["perfilOculto"])){ 
	$activarFormularioBajas = new TablaFormularioBajas();
	//$activarFormularioBajas -> mostrarTablaFormularioBajas();
	$activarFormularioBajas -> mostrarTablaFormularioBajasConVistas();
}
if (isset($_POST["perfilOculto"])){
	/* $request = $_POST;
	$res = array();
	echo json_encode($res); */
	$activarFormularioBajas = new TablaFormularioBajas();
	$activarFormularioBajas -> mostrarTablaFormularioBajasConVistasOptimizado($_POST);
}
