<?php


class ControladorFormularioBajas {
	
	/*=============================================
	MOSTRAR LOS AFILIADOS QUE TIENEN PRUEBAS DE LABORATORIO COVID-19 Y FORMULARIOS DE BAJA
	=============================================*/
	
	static public function ctrMostrarFormularioBajas($item, $valor) {

		$tabla = "formulario_bajas";

		$respuesta = ModeloFormularioBajas::mdlMostrarFormularioBajas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
		MOSTRAR TODAS LAS BAJAS QUE TIENEN PRUEBAS DE LABORATORIO COVID-19 
	=============================================*/
	
	static public function ctrMostrarFormularioBajasTotales($item, $valor) {

		$tabla = "formulario_bajas";

		$respuesta = ModeloFormularioBajas::mdlMostrarFormularioBajasTotales($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR TODOS LOS REGISTROS DE LA VISTA bajas_con_cresultados M@rk
	=============================================*/
	
	static public function getFormularioBajasConSinCovidResultados($tabla, $contrarRegistros = false) {

		$respuesta = ModeloFormularioBajas::getFormularioBajasConSinCovidResultados($tabla, $contrarRegistros);

		return $respuesta;

	}

	/*===========================================================================
	MOSTRAR TODOS LOS REGISTROS FILTRADOS DE LA VISTA bajas_con_cresultados M@rk
	===========================================================================*/

	static public function getFormularioBajasFiltrado($tabla, $sql, $contrarRegistros = false){

		$respuesta = ModeloFormularioBajas::getFormularioBajasFiltrado($tabla, $sql, $contrarRegistros);
	
		return $respuesta;		
	}

	/*=============================================
			NUEVO DE FORMULARIO BAJA @DANPINCH
	=============================================*/
	/* begin nuevo formulario baja danpinch*/
	static public function ctrNuevoFormularioBaja() {
		
		//$codigo = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
		if (isset($_POST["fechaIniFormBaja"])) {
			if(isset($_POST["observacionesBaja"])){
				$observacion = $_POST["observacionesBaja"];
			}else{
				$observacion="";
			}
			if(isset($_POST['edad'])){
				$edad = $_POST['edad'];
			}else{
				$edad = 0;
			}
			//if (preg_match($patron_numerosTexto, $_POST["claveFormNuevaBaja"])) {

				$datos = array("id_covid_resultado"	=> $_POST["idCovidResultado"], 
							   "riesgo"             => $_POST["riesgoFormBaja"],
							   "fecha_ini" 		    => date("Y-m-d", strtotime($_POST["fechaIniFormBaja"])),
							   "fecha_fin"	        => date("Y-m-d", strtotime($_POST["fechaFinFormBaja"])),
							   "dias_incapacidad"	=> $_POST["diasIncapacidadFormBaja"],
							   "lugar"			    => $_POST["lugarFormNuevaBaja"],
							   "fecha"				=> date("Y-m-d", strtotime($_POST["fechaFormBaja"])),
							   "clave"   		    => $_POST["claveFormNuevaBaja"],
							   /* "codigo"   		    => $_POST["cod_asegurado"].'-'.$codigo, */
							   "codigo"   		    => trim($_POST["cod_afiliado"]),
							   "establFormNuevaBaja" => $_POST["establFormNuevaBaja"],							
							   "observacion_baja"	=> strtoupper($observacion));
								
				$respuesta = ModeloFormularioBajas::mdlIngresarFormularioBajaExterno("formulario_bajas", $datos);

				$datos1 = array("cod_asegurado" => strtoupper(trim($_POST["codAseguradoFormBaja"])),
								//"cod_asegurado" => trim($_POST["cod_asegurado"]),
								"cod_afiliado" => trim(strtoupper($_POST["cod_afiliado"])),
								"cod_empleador" => trim(strtoupper($_POST["cod_empleador"])),
								"nombre_empleador" => strtoupper(trim($_POST["nombre_empleador"])),
								/* "paterno" => trim($_POST["paterno"]),
								"materno" => trim($_POST["materno"]),
								"nombre" => trim($_POST["nombre"]), */

								"paterno" => strtoupper(trim($_POST["paternoFormBaja"])),
								"materno" => strtoupper(trim($_POST["maternoFormBaja"])),
								"nombre" => strtoupper(trim($_POST["nombreFormBaja"])),

								"sexo" => trim($_POST["sexo"]),
								"nro_documento" => trim($_POST["nro_documento"]),
								"fecha_nacimiento" => trim(date("Y-m-d",strtotime($_POST["fecha_nacimiento"]))),
								"edad" => trim($edad),
								"id_departamento_paciente" => "1",
								"id_provincia_paciente" => "1",
								"id_municipio_paciente" => "21",
								"id_pais_paciente" => "1",
								"zona"=> "",
								"calle" => "",
								"nro_calle" => "",
								"telefono" => "",
								"email" => "",
								"nombre_apoderado" => "",
								"telefono_apoderado" => "",
								"id_ficha" => -1
				);
                // Verificamos si el paciente existe para no duplicar informacion
				if(isset($_POST["idPaciente"]) && $_POST["idPaciente"] != -1){
					$respuesta1 = $_POST["idPaciente"];
				} else $respuesta1 = ModeloPacientesAsegurados::mdlIngresarPacienteAseguradoExterno("pacientes_asegurados",$datos1);

				// Verificamos si se creo correctamente la baja para proceder a crear la baja externa
				if (is_numeric($respuesta) && is_numeric($respuesta1)) {
					$datos2 = array("id_pacientes_asegurados" => $respuesta1,
									"id_personas_notificadores" => $_POST['idUsuario'],
									"id_formulario_baja" => $respuesta
								);
					ModeloFormularioBajasExterno::mdlIngresarFormularioBajaExterno("formulario_bajas_externo",$datos2);
					//Antes de mostrar el swal debemos controlar k se creo un registro en la tabla formulario_bajas_externo
					echo '<script>
						swal.fire({							
							icon: "success",
							title: "¡El formulario ha sido agregado correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
						}).then((result) => {		  					
		  					if (result.value) {
								window.location = "formulario-bajas";
							}
						});
					</script>';
				}
				else {
					echo '<script>
						swal.fire({
							title: "Error de Base de Datos",
							text: "¡Error en la consulta a la Base de Datos!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"
						}).then((result) => {		  					
		  					if (result.value) {
								//window.location = "index.php?ruta=formulario-bajas";
							}
						});
					</script>';
				}

		//	} else {

		//		echo '<script>		

		//			swal.fire({

		//				title: "Error al introducir datos",
		//				text: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!,
		//				icon: "error",
		//				allowOutsideClick: false,
		//				confirmButtonText: "¡Cerrar!"

		//			}).then((result) => {
	  					
	  	//				if (result.value) {

		//					/* window.location = "index.php?ruta=editar-formulario-bajas&idFormularioBaja="'+$_POST["idFormularioBaja"]+'; */

		//				}

		//			});

		//		</script>';

		//	} 

		}

	}
	/* end nuevo formulario baj*/
	/*=============================================
			EDITAR FORMULARIO BAJA
	=============================================*/

	static public function ctrEditarFormularioBaja() {

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
		$patron_numerosTexto = "/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/";

		if (isset($_POST["fechaIniFormBaja"])) {
				
			if (/* preg_match($patron_numerosTexto, $_POST["claveFormBaja"]) */true) {

				
				//VALIDAR IMAGEN
				
				
				$ruta = $_POST["ImagenActual"];

				/*
				if (isset($_FILES["imagenFormBaja"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["imagenFormBaja"]["tmp_name"]);
					
					$nuevoAncho = $ancho;
					$nuevoAlto = $alto;

					
					//CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL AFILIADO QUE TIENE RESULTADOS DE LABORATIRO COVID
					

					$directorio = "vistas/img/form_bajas/".$_POST["idFormularioBaja"];

					
					//PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					

					if (!empty($_POST["ImagenActual"])) {

						unlink($_POST["ImagenActual"]);

					} else {

						mkdir($directorio, 0755);

					}

					
					//DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					

					if ($_FILES["imagenFormBaja"]["type"] == "image/jpeg") {
						
						
						//GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/form_bajas/".$_POST["idFormularioBaja"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["imagenFormBaja"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if ($_FILES["imagenFormBaja"]["type"] == "image/png") {
						
						
						//GUARDAMOS LA IMAGEN EN EL DIRECTORIO
					

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/form_bajas/".$_POST["idFormularioBaja"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["imagenFormBaja"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}
				*/

				/*=============================================
				ALMACENANDO LOS DATOS EN LA BD
				=============================================*/

				$tabla = "formulario_bajas";
				if (isset($_POST["observacionesBaja"]))
				    $observaciones   = $_POST["observacionesBaja"];
				else $observaciones = "";	
   
				$datos = array("id"					=> $_POST["idFormularioBaja"],
							   "id_covid_resultado"	=> $_POST["idCovidResultado"], 
							   "riesgo"             => $_POST["riesgoFormBaja"],
							   "fecha_ini" 		    => date("Y-m-d", strtotime($_POST["fechaIniFormBaja"])),
							   "fecha_fin"	        => date("Y-m-d", strtotime($_POST["fechaFinFormBaja"])),
							   "observacion_baja"	=> strtoupper($observaciones),
							   "dias_incapacidad"	=> $_POST["diasIncapacidadFormBaja"],
							   "lugar"			    => $_POST["lugarFormBaja"],
							   "fecha"				=> date("Y-m-d", strtotime($_POST["fechaFormBaja"])),
							   "clave"   		    => $_POST["claveFormBaja"],
							   "establFormNuevaBaja" => $_POST["establFormNuevaBaja"],
							   /* "observacion_baja"	=> $_POST["observacionesBaja"], */
							   "imagen"     		=> $ruta);


				$respuesta = ModeloFormularioBajas::mdlEditarFormularioBaja($tabla, $datos);

				if( isset($_POST['modificarPaciente']) && $_POST['modificarPaciente'] == 'SI' ){ //Bandera que controla si modifico el nombre empleador i/o codEmpleador
					$datos1 = array("cod_empleador"    => trim(strtoupper($_POST['cod_empleador'])),
									"nombre_empleador" => trim(strtoupper($_POST['nombre_empleador'])),
									"cod_afiliado"     => strtoupper(trim($_POST['cod_afiliado'])),
									"id_paciente"      => trim($_POST['pacienteAsegurado']),
									"id_covid"         => $_POST["idCovidResultado"],
									"paterno"          => strtoupper(trim($_POST["paternoFormBaja"])),
									"materno"          => strtoupper(trim($_POST["maternoFormBaja"])),
									"nombre"           => strtoupper(trim($_POST["nombreFormBaja"])),
									"cod_asegurado"    => strtoupper(trim($_POST["codAseguradoFormBaja"])) //cambie por sospechoso
							  );

					$respuesta1 = ControladorPacientesAsegurados::ctrEditarPacineteAseguradoNombreEmpleador("cod_afiliado",$datos1);
					$respuesta = $respuesta1;

					if( $_POST["idCovidResultado"] != -1){ //Actualizamos tambien el covid resultado si es que tuviera
						$respuesta2 = ControladorCovidResultados::ctrEditarNombreEmpleador("cod_afiliado",$datos1);
						$respuesta = $respuesta2;
					}
				}

				if ($respuesta == "ok") {
					
					echo '<script>		

						swal.fire({
							
							icon: "success",
							title: "¡El formulario ha sido editado correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "formulario-bajas";

							}
						});

					</script>';

				}

				else {

					echo '<script>		

						swal.fire({

							title: "Error de Base de Datos",
							text: "¡Error en la consulta a la Base de Datos!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "index.php?ruta=editar-formulario-bajas&idFormularioBaja="'+$_POST["idFormularioBaja"]+';
							}

						});

					</script>';

				}

			} else {

				echo '<script>		

					swal.fire({

						title: "Error al introducir datos",
						text: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!,
						icon: "error",
						allowOutsideClick: false,
						confirmButtonText: "Corregir!"

					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "index.php?ruta=editar-formulario-bajas&idFormularioBaja="'+$_POST["idFormularioBaja"]+';

						}

					});

				</script>';

			}

		}

	}

	/*=============================================
	BORRAR REGISTRO DE AFILIADO CON RESULTADOS DE LABORATORIO COVID-19
	=============================================*/

	static public function ctrEliminarFormularioBaja() {
		
		if (isset($_GET["idFormularioBaja"])) {
			
			$tabla = "formulario_bajas";
			$datos = $_GET["idFormularioBaja"];


			if ($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/form_bajas/default/anonymous.png") {
				
				unlink($_GET["imagen"]);
				rmdir("vistas/img/form_bajas/".$_GET["idFormularioBaja"]);
			}		

			$respuesta = ModeloFormularioBajas::mdlEliminarFormularioBaja($tabla, $datos);			
			$formularioBajas = ControladorBajasExterno::ctrMostrarFormularioBajaExterno("id_formulario_baja",$datos);
			if($formularioBajas!=""){				
				ControladorPacientesAsegurados::ctrEliminarPacientesAsegurados("id",$formularioBajas["id_pacientes_asegurados"]);
				ControladorBajasExterno::ctrEliminarFormularioBajaExterno("id",$formularioBajas["id"]);
			}

			if ($respuesta == "ok") {
					
				echo '<script>		

					swal.fire({
						
						icon: "success",
						title: "¡El formulario ha sido borrado correctamente!",
						showConfirmButton: true,
						allowOutsideClick: false,
						confirmButtonText: "Cerrar"
						
					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "formulario-bajas";

						}
					});

				</script>';

			}

			else {

				echo '<script>		

					swal.fire({

						title: "Error de Base de Datos",
						text: "¡Error en la consulta a la Base de Datos!",
						icon: "error",
						allowOutsideClick: false,
						confirmButtonText: "¡Cerrar!"

					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "formulario-bajas";
						}

					});

				</script>';
				
			}

		}
		
	}


	/*========================================================
	RECUPERA LOS DATOS DE LA TABLA 'formulario_bajas_externo'
	==========================================================*/

	static public function ctrMostrarFormularioBajasExterno($item, $valor) {

		$tabla = "formulario_bajas_externo";

		$respuesta = ModeloFormularioBajas::mdlMostrarFormularioBajasExterno($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
		SUMAR TODAS LOS 
	=============================================*/
	
	static public function ctrSumaTodasBajas($id_baja, $id_covid_resultado) {

		$tabla = "formulario_bajas";

		$respuesta = ModeloFormularioBajas::mdlSumarTodasBajas($tabla, $id_baja, $id_covid_resultado);

		return $respuesta;

	}

	/*=============================================
		SUMAR TODAS LOS 
	=============================================*/
	
	static public function ctrBuscarFechaIniFin($id_baja, $id_covid_resultado,$ascdesc) {

		$tabla = "formulario_bajas";

		$respuesta = ModeloFormularioBajas::mdlBuscarFechaIniFin($tabla, $id_baja, $id_covid_resultado,$ascdesc);

		return $respuesta;

	}

}