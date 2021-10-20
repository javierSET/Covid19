<?php

require_once "../controladores/afiliadosSIAIS.controlador.php";
require_once "../modelos/afiliadosSIAIS.modelo.php";
require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/pacientes_asegurados.modelo.php";

require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";

class TablaAfiliadosSIAIS {

	/*=============================================
	MOSTRAR LA TABLA DE POBLACION AFILIADA
	=============================================*/

	public $afiliado;

	public function mostrarTablaAfiliadosSIAIS($request) {
 	
		$item1 = "nombre_completo";
		$item2 = "cod_asegurado";
		$valor = $this->afiliado;

		if(isset($request['buscarLocal'])){

			if($request['buscarLocal'] == "true"){ // bandera que confirma que se hara una busqueda local y SIAIS

				$bandera = null;
				$respuesta = null;
				
				$pacienteLocal = ControladorPacientesAsegurados::ctrMostrarPacientesAseguradosSIAIS($valor); // busqueda en la BD SIAIS
				if($pacienteLocal != null && count($pacienteLocal) > 0){// buscamos en la Base de Datos Local
					$bandera =  array("bdlocal" => true);
					array_push($pacienteLocal, $bandera);
					$respuesta = $pacienteLocal;
				}
				else{// Si no lo encontramos Buscamos en la BD de SIAIS
					$bandera = array("bdlocal" => false);
					$respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);
					array_push($respuesta, $bandera);
				}

				if(isset($request['buscarDuplicado'])){ // Bandera que indica que se quiere aperturar una ficha
					$count = 0;
					foreach($respuesta as $key => $value){
						// Si el paciente se encontro en la BD local es por posiblemente tiene ficha
						if($pacienteLocal != null && count($pacienteLocal) > 0){
						 	if(isset($value['id_ficha'])){
								 if($value['id_ficha'] != -1 && $value['id_ficha'] != -2 && $value['id_ficha'] != null){									
									 $respuesta[$key]['tieneFicha'] = true;
									 // Buscamos si tiene mas fichas
									 $fichas = ControladorFichas::ctrMostrarFichas('id_paciente',$value['id_paciente'],true);
									 $fichasPaciente = array(array('id_ficha'=> $value['id_ficha']));
									 if(count($fichas) > 0){
										foreach($fichas as $key1 => $value1){
											array_push($fichasPaciente, $value1);
										}
									 }
									 $respuesta[$key]['ficha'] = $fichasPaciente;								 
								 }
								 else {
									 $fichas = ControladorFichas::ctrMostrarFichas('id_paciente',$value['id_paciente'],true); //Se aumento una columna en la BD para evitar duplicidad de pacientes
									 if(count($fichas) > 0){ //si el tamaño del array es > 0 es por que tiene al menos una ficha
										$respuesta[$key]['tieneFicha'] = true;
										$respuesta[$key]['ficha'] = $fichas;
									 }	
									 else{										 
										 $respuesta[$key]['tieneFicha'] = false;
										 $respuesta[$key]['ficha'] = array();
									 } 
								 }
							 }
						}
						else{ // Si el paciente se encontro en la BD SIAIS es por que no se le aperturo una ficha aqui falta controlar a todos los encontrados en la BD SIAIS 
							if($count < 30){ //Si la busqueda es " " un espacio, esta seccion es solo para hacer pruebas para los programadores
								if(isset($value['cod_beneficiario'])){

									$paciente = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('cod_afiliado',trim($value['cod_beneficiario']));
									if(isset($paciente['id_ficha']) && $paciente['id_ficha'] != -1 && $paciente['id_ficha'] != -2){
										
										$fichas = ControladorFichas::ctrMostrarFichas('id_paciente',$paciente['id'],true); //Se aumento una columna en la BD para evitar duplicidad de pacientes
										$fichasPaciente = array(array('id_ficha'=> $paciente['id_ficha']));
										if(count($fichas) > 0){ //si el tamaño del array es > 0 es por que tiene al menos una ficha
										   $respuesta[$key]['tieneFicha'] = true;
										   foreach($fichas as $key1 => $value1){
										   	array_push($fichasPaciente ,$value1);
										   }
										   $respuesta[$key]['ficha'] = $fichasPaciente;
										}	
										else{										 
											$respuesta[$key]['tieneFicha'] = false;
											$respuesta[$key]['ficha'] = array();
										} 
									}						
									else{
										if(isset($paciente['id_ficha'])){
											$fichas = ControladorFichas::ctrMostrarFichas('id_paciente',$paciente['id'],true); //Se aumento una columna en la BD para evitar duplicidad de pacientes
											if(count($fichas) > 0){ //si el tamaño del array es > 0 es por que tiene al menos una ficha
											   $respuesta[$key]['tieneFicha'] = true;											
											   $respuesta[$key]['ficha'] = $fichas;
											}	
											else{										 
												$respuesta[$key]['tieneFicha'] = false;
												$respuesta[$key]['ficha'] = array();
											} 
										}
										else{
											$respuesta[$key]['tieneFicha'] = false;
											$respuesta[$key]['ficha'] = array();
										}
									} 
								}
								$count++;
							}
							else{
								$arraySalida = array_slice($respuesta, 0, 30);
								$respuesta = $arraySalida;
								break;
							}
						}
					}
			    }
			}
			else{ // Buscamos solo en SIAIS
				$respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);
			}
		}
		else if(isset($request['buscadorBajas'])){
			if($request['buscadorBajas']== "true"){
				$bandera = null;
				$respuesta = null;
				$hoy = date("Y/m/d"); // fecha actual
				//$hoy = "2021-07-24";


				$pacienteLocal = ControladorPacientesAsegurados::ctrMostrarPacientesAseguradosSIAISBajas($valor); // busqueda en la BD SIAIS
				//var_dump("ENTROOO".$pacienteLocal);
				$pacienteLocalSospechoso = ControladorPacientesAsegurados::ctrBusquedaPacienteBajaSospechosoActiva($valor,$hoy);// buqueda de pacientes con bajas de sospechoso				
				$pacienteLocalPositivo = ControladorPacientesAsegurados::ctrBusquedaPacienteBajaPositivoActiva($valor,$hoy); // busqueda de pacientes con bajas

				if($pacienteLocalSospechoso !=null && count($pacienteLocalSospechoso)>0){
					$bandera =  array("buscadorBajas" => true, "tipoPaciente"=> 'S');
					array_push($pacienteLocalSospechoso, $bandera);
					$respuesta = $pacienteLocalSospechoso;
				}				
				else if($pacienteLocalPositivo !=null && count($pacienteLocalPositivo)>0){
					$bandera =  array("buscadorBajas" => true, "tipoPaciente"=> 'A');					
					array_push($pacienteLocalPositivo,$bandera);
					$respuesta = $pacienteLocalPositivo;
				}
				else if($pacienteLocal !=null && count($pacienteLocal)>0){
					$bandera =  array("buscadorBajas" => true, "tipoPaciente"=> 'L');
					array_push($pacienteLocal, $bandera);
					$respuesta = $pacienteLocal;
				}
				else{
					$bandera = array("buscadorBajas" => false);
					$respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);
					array_push($respuesta, $bandera);
				}				
			}
		}
		else{
			$respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);
		}
		
		session_start(); 

		$_SESSION['backupAfiliado'] = $respuesta;
		$borrar = json_encode($respuesta);
		echo json_encode($respuesta);
	}

	public function mostrarTablaAfiliadosSIAISAltaManual() {
		
		$item1 = "nombre_completo";
		//$item1 = null;
		$item2 = "cod_asegurado";
		//$item2 = null;
		$valor = $this->afiliado;

		$respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAISAltaManual($item1, $item2, $valor);

		session_start();

		$_SESSION['backupAfiliado'] = $respuesta;
		
		//echo "HOLA";
		echo json_encode($respuesta);
		//return json_encode($respuesta);

	}
	
	/*=============================================
	MOSTRAR LA TABLA DE POBLACION AFILIADA DE ACUERDO AL CRITERIO DE IDEMPLEADOR
	=============================================*/
	
	public $idEmpleador;

	public function mostrarTablaAfiliadosEmpleadorSIAIS() {

		$item1 = "idempleador";
		$item2 = null;
		$valor = $this->idEmpleador;

		$afiliados = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);

		if ($afiliados == null) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
				"data": [';

				for ($i = 0; $i < count($afiliados); $i++) { 

					/*=============================================
					TRAEMOS LAS ACCIONES
					=============================================*/

					$botones = "<div class='btn-group'><button class='btn btn-info btnRegistrarResultadosCovid' idAfiliado='".$afiliados[$i]["idafiliacion"]."' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>";

					
					$datosJson .='[
						"'.($i+1).'",					
						"'.$afiliados[$i]['pac_numero_historia'].'",
						"'.$afiliados[$i]['pac_codigo'].'",
						"'.$afiliados[$i]['pac_primer_apellido'].' '.$afiliados[$i]['pac_segundo_apellido'].' '.$afiliados[$i]['pac_nombre'].'",
						"'.date("d/m/Y", strtotime($afiliados[$i]['pac_fecha_nac'])).'",
						"'.$afiliados[$i]['emp_nro_empleador'].'",
						"'.$botones.'"
					],';
				}

				$datosJson = substr($datosJson, 0, -1);

			$datosJson .= ']

			}';

		}
		
		echo $datosJson;
	
	}

}

/*=============================================
ACTIVAR TABLA AFILIADOS
=============================================*/

if (isset($_GET["idEmpleador"])) {

	$activarAfiliadosSIAIS = new TablaAfiliadosSIAIS();
	$activarAfiliadosSIAIS -> idEmpleador = $_GET["idEmpleador"];
	$activarAfiliadosSIAIS -> mostrarTablaAfiliadosEmpleadorSIAIS();

} else if (isset($_POST["afiliado"])) {

	$activarAfiliadosSIAIS = new TablaAfiliadosSIAIS();
	$activarAfiliadosSIAIS -> afiliado = $_POST["afiliado"];
	$activarAfiliadosSIAIS -> mostrarTablaAfiliadosSIAIS($_POST);

} else if (isset($_POST["afiliadoAltaManual"])) {

	$activarAfiliadosSIAIS = new TablaAfiliadosSIAIS();
	$activarAfiliadosSIAIS -> afiliado = $_POST["afiliadoAltaManual"];
	$activarAfiliadosSIAIS -> mostrarTablaAfiliadosSIAISAltaManual();

}