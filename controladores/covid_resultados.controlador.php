<?php 

class ControladorCovidResultados {

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO)
	=============================================*/
	
	static public function ctrContarCovidResultadosLab() {

		$tabla = "vista_covid_resultados";

		$respuesta = ModeloCovidResultados::mdlContarCovidResultadosLab($tabla);

		return $respuesta;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (LABORATORIO)
	=============================================*/
	
	static public function ctrContarFiltradoCovidResultadosLab($sql) {

		$tabla = "vista_covid_resultados";

		$respuesta = ModeloCovidResultados::mdlContarFiltradoCovidResultadosLab($tabla, $sql);

		return $respuesta;

	}


	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (LABORATORIO) danpinch
	=============================================*/
	
	static public function ctrContarFiltradoCovidResultadosLaboratorio($sql) {
		$tabla = "vista_covid_resultados_laboratorios";
		$respuesta = ModeloCovidResultados::mdlContarFiltradoCovidResultadosLaboratorio($tabla, $sql);
		return $respuesta;
	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (LABORATORIO) danpinch
	=============================================*/
	
	static public function ctrContarFiltradoCovidResultadosReportesLaboratorio($sql) {
		$tabla = "vista_covid_resultados_reporte_laboratorio";
		$respuesta = ModeloCovidResultados::mdlContarFiltradoCovidResultadosLaboratorio($tabla, $sql);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO) danpinch
	=============================================*/
	
	static public function ctrMostrarCovidResultadosLaboratorio($sql) {
		$tabla = "vista_covid_resultados_laboratorios";
		$respuesta = ModeloCovidResultados::mdlMostrarCovidResultadosLaboratorio($tabla, $sql);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO) danpinch
	=============================================*/
	
	static public function ctrMostrarCovidResultadosReportesLaboratorio($sql) {
		$tabla = "vista_covid_resultados_reporte_laboratorio";
		$respuesta = ModeloCovidResultados::mdlMostrarCovidResultadosLaboratorio($tabla, $sql);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (LABORATORIO)
	=============================================*/
	
	static public function ctrMostrarCovidResultadosLab($sql) {

		$tabla = "vista_covid_resultados";

		$respuesta = ModeloCovidResultados::mdlMostrarCovidResultadosLab($tabla, $sql);

		return $respuesta;

	}


	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (CENTRO COVID)
	=============================================*/
	
	static public function ctrContarCovidResultadosCentro() {

		$tabla = "vista_covid_resultados";

		$respuesta = ModeloCovidResultados::mdlContarCovidResultadosCentro($tabla);

		return $respuesta;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (CENTRO COVID)
	=============================================*/
	
	static public function ctrContarFiltradoCovidResultadosCentro($sql) {

		$tabla = "vista_covid_resultados";

		$respuesta = ModeloCovidResultados::mdlContarFiltradoCovidResultadosCentro($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (CENTRO COVID)
	=============================================*/
	
	static public function ctrMostrarCovidResultadosCentro($sql) {

		$tabla = "vista_covid_resultados";

		$respuesta = ModeloCovidResultados::mdlMostrarCovidResultadosCentro($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LOS AFILIADOS QUE TIENEN PRUEBAS DE LABORATORIO COVID-19
	=============================================*/
	
	static public function ctrMostrarCovidResultados($item, $valor) {

		$tabla = "covid_resultados";

		$respuesta = ModeloCovidResultados::mdlMostrarCovidResultados($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LOS AFILIADOS QUE TIENEN PRUEBAS DE LABORATORIO COVID-19 DE ACUERDO A LA FECHA DE RESULTADO
	=============================================*/
	
	static public function ctrMostrarCovidResultadosFecha($item, $valor) {

		$tabla = "covid_resultados";

		$respuesta = ModeloCovidResultados::mdlMostrarCovidResultadosFecha($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	REGISTRO DE NUEVO AFILIADO CON RESULTADOS DE LABORATORIO COVID-19
	=============================================*/

	static public function ctrCrearCovidResultado() {

		// Patrón (admite letras acentuadas y espacios):
		$patron_texto = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/";

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
		$patron_textoEspecial = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+$/";

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
		$patron_numerosTexto = "/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/";

		// Patrón (admite numero y letras y tambien -)
		$patron_numerosLetras = "/^[A-Za-z0-9-]+$/";
		
		if (isset($_POST["nuevaFechaRecepcion"])) {
			
			if (preg_match($patron_numerosTexto, $_POST["nuevoTipoMuestra"]) &&
				preg_match($patron_numerosLetras, $_POST["nuevoDocumentoCI"])) {

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				
				$ruta = "vistas/img/covid_resultados/default/anonymous.png";

				/*=============================================
				TRAEMOS DATOS DE EMPLEADORES DE LA BASE DE DATOS SIAIS
				=============================================*/

				if ($_POST['codEmpleador'] != "SIN REGISTRAR") {

					$item = "emp_nro_empleador";
		            $valor = $_POST['codEmpleador'];

		            $empleador = ControladorEmpleadoresSIAIS::ctrMostrarEmpleadoresSIAIS($item, $valor);
					
				} else {

					$empleador["emp_nombre"] = "SIN REGISTRAR";

				}


				/*=============================================
				SI NO EXISTE EL CAMPO OBSERVACIÓN SE GUARDA DATOS DE PRUEBA ELISA
				=============================================*/

				if (isset($_POST["nuevaObservacion"])) {

					$observaciones = strtoupper($_POST["nuevaObservacion"]);

				} else {

					$observaciones = '(lgM   '.$_POST["lgM"].'   >=1,0)   (lgG   '.$_POST["lgG"].'   >=1,0)';
				}

				/*=============================================
				ALMACENANDO LOS DATOS EN LA BD
				=============================================*/

				$tabla = "covid_resultados";

				$datos = array( "cod_asegurado"			=> strtoupper($_POST["codAsegurado"]), 
								"cod_afiliado"			=> $_POST["codAfiliado"], 

								"cod_empleador"     	=> $_POST["codEmpleador"],
								"nombre_empleador"     	=> rtrim($empleador["emp_nombre"]),
								"fecha_recepcion"  		=> $_POST["nuevaFechaRecepcion"],
								"fecha_muestra"     	=> $_POST["nuevaFechaMuestra"],
								"cod_laboratorio"   	=> strtoupper($_POST["nuevoCodLab"]),
								"nombre_laboratorio"   	=> strtoupper($_POST["nuevoNombreLab"]),
								"muestra_control"   	=> $_POST["nuevaMuestraControl"],
								"tipo_muestra"   		=> strtoupper($_POST["nuevoTipoMuestra"]),
								"id_departamento"   	=> $_POST["nuevoDepartamento"],
								"id_establecimiento"	=> $_POST["nuevoEstablecimiento"],
								"documento_ci"			=> $_POST["nuevoDocumentoCI"],
								"paterno"				=> strtoupper($_POST["nuevoPaterno"]),
								"materno"				=> strtoupper($_POST["nuevoMaterno"]),
								"nombre" 		        => strtoupper($_POST["nuevoNombre"]),
								"sexo"	                => $_POST["nuevoSexo"],
								"fecha_nacimiento"	    => $_POST["nuevaFechaNacimiento"],
								"telefono"				=> $_POST["nuevoTelefono"],
								"email"					=> $_POST["nuevoEmail"],
								"id_localidad"			=> $_POST["nuevaLocalidad"],
								"zona"   		        => strtoupper($_POST["nuevaZona"]),
								"calle"   		        => strtoupper($_POST["nuevaCalle"]),
								"nro_calle"   		    => strtoupper($_POST["nuevoNroCalle"]),
								"resultado"   		    => $_POST["nuevoResultado"],
								"fecha_resultado"   	=> $_POST["nuevaFechaResultado"],
								"observaciones"   		=> $observaciones,
								"id_usuario"	   		=> $_POST["idUsuario"],
								"foto"     		        => $ruta);	

				$respuesta = ModeloCovidResultados::mdlIngresarCovidResultado($tabla, $datos);


				if ($respuesta == "ok") {
					
					echo '<script>		

						swal.fire({
							
							icon: "success",
							title: "¡Los datos han sido guardado correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "covid-resultados-lab";

							}

						});

					</script>';

				}

				else {

					if ( $_POST["idAfiliado"] != "") {

						echo '<script>		

							swal.fire({

								title: "Error de Base de Datos",
								text: "¡Error en la consulta a la Base de Datos!",
								icon: "error",
								allowOutsideClick: false,
								confirmButtonText: "¡Cerrar!"

							}).then((result) => {
			  					
			  					if (result.value) {

									window.location = "index.php?ruta=nuevo-covid-resultado&idAfiliado="'+$_POST["idAfiliado"]+';
								}

							});

						</script>';

					} else {

						echo '<script>		

							swal.fire({

								title: "Error de Base de Datos",
								text: "¡Error en la consulta a la Base de Datos!",
								icon: "error",
								allowOutsideClick: false,
								confirmButtonText: "¡Cerrar!"

							}).then((result) => {
			  					
			  					if (result.value) {

									window.location = "index.php?ruta=nuevo-covid-resultado-no-afiliado;
								}

							});

						</script>';

					}

				}

			} else {

				if ( $_POST["idAfiliado"] != "") {

					echo '<script>		

						swal.fire({

							title: "Error al introducir datos",
							text: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!,
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "index.php?ruta=nuevo-covid-resultado&idAfiliado="'+$_POST["idAfiliado"]+';

							}

						});

					</script>';

				} else {

					echo '<script>		

						swal.fire({

							title: "Error al introducir datos",
							text: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!,
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "index.php?ruta=nuevo-covid-resultado-no-afiliado;

							}

						});

					</script>';

				}

			}

		} 

	}

	/*=============================================
	EDITAR REGISTRO DE AFILIADO CON RESULTADOS DE LABORATORIO COVID-19
	=============================================*/

	static public function ctrEditarCovidResultado() {

		// Patrón (admite letras acentuadas y espacios):
		$patron_texto = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/";

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
		$patron_textoEspecial = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+$/";

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
		$patron_numerosTexto = "/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/";

		// Patrón (admite numero y letras y tambien -)
		$patron_numerosLetras = "/^[A-Za-z0-9-]+$/";
		
		if (isset($_POST["editarFechaRecepcion"])) {
			
			if (preg_match($patron_numerosTexto, $_POST["nuevoTipoMuestra"]) /* &&
				preg_match($patron_numerosLetras, $_POST["editarDocumentoCI"]) */) {

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				
				$ruta = "vistas/img/covid_resultados/default/anonymous.png";

				/*=============================================
				TRAEMOS DATOS DE EMPLEADORES DE LA BASE DE DATOS SIAIS
				=============================================*/

				if ($_POST['codEmpleador'] != "SIN REGISTRAR") {

					$item = "emp_nro_empleador";
		            $valor = $_POST['codEmpleador'];

		            $empleador = ControladorEmpleadoresSIAIS::ctrMostrarEmpleadoresSIAIS($item, $valor);
					
				} else {

					$empleador["emp_nombre"] = "SIN REGISTRAR";

				}

				/*=============================================
				SI NO EXISTE EL CAMPO OBSERVACIÓN SE GUARDA DATOS DE PRUEBA ELISA
				=============================================*/

				if (isset($_POST["editarObservacion"])) {

					$observaciones = strtoupper($_POST["editarObservacion"]);

				} else {

					$observaciones = '(lgM   '.$_POST["lgM"].'   >=1,0)   (lgG   '.$_POST["lgG"].'   >=1,0)';
				}
		
				/*=============================================
				ALMACENANDO LOS DATOS EN LA BD
				=============================================*/

				$tabla = "covid_resultados";

				$datos = array( "id"					=> $_POST["idCovidResultado"], 
								"cod_asegurado"			=> $_POST["codAsegurado"], 
								"cod_afiliado"			=> $_POST["codAfiliado"], 
								"cod_empleador"     	=> $_POST["codEmpleador"],
								"nombre_empleador"     	=> rtrim($empleador["emp_nombre"]),
								"fecha_recepcion"  		=> $_POST["editarFechaRecepcion"],
								"fecha_muestra"     	=> $_POST["editarFechaMuestra"],
								"cod_laboratorio"   	=> strtoupper($_POST["editarCodLab"]),
								"nombre_laboratorio"   	=> strtoupper($_POST["editarNombreLab"]),
								"muestra_control"   	=> $_POST["editarMuestraControl"],
								"tipo_muestra"   		=> $_POST["nuevoTipoMuestra"],
								"id_departamento"   	=> $_POST["editarDepartamento"],
								"id_establecimiento"	=> $_POST["editarEstablecimiento"],
								"documento_ci"			=> $_POST["editarDocumentoCI"],
								"paterno"				=> strtoupper($_POST["editarPaterno"]),
								"materno"				=> strtoupper($_POST["editarMaterno"]),
								"nombre" 		        => strtoupper($_POST["editarNombre"]),
								"sexo"	                => $_POST["editarSexo"],
								"fecha_nacimiento"	    => $_POST["editarFechaNacimiento"],
								"telefono"				=> $_POST["editarTelefono"],
								"email"					=> $_POST["editarEmail"],
								"id_localidad"			=> $_POST["editarLocalidad"],
								"zona"   		        => strtoupper($_POST["editarZona"]),
								"calle"   		        => strtoupper($_POST["editarCalle"]),
								"nro_calle"   		    => $_POST["editarNroCalle"],
								"resultado"   		    => $_POST["editarResultado"],
								"fecha_resultado"   	=> $_POST["editarFechaResultado"],
								"observaciones"   		=> $observaciones,
								"id_usuario"	   		=> $_POST["idUsuario"],
								"id_ficha"	   			=> $_POST["idFicha"],
								"foto"     		        => $ruta);	

				//var_dump($datos);
				$respuesta = ModeloCovidResultados::mdlEditarCovidResultado($tabla, $datos);

				if ($respuesta == "ok") {
					
					echo '<script>		

						swal.fire({
							
							icon: "success",
							title: "¡Los datos han sido editados correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "covid-resultados-lab";

							}

						});

					</script>';

				} else {

					echo '<script>		

						swal.fire({

							title: "Error de Base de Datos",
							text: "¡Error en la consulta a la Base de Datos!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "index.php?ruta=editar-covid-resultado&idCovidResultado=1"'+$_POST["idCovidResultado"]+';
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
						confirmButtonText: "¡Cerrar!"

					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "index.php?ruta=editar-covid-resultado&idCovidResultado=2"'+$_POST["idCovidResultado"]+';

						}

					});

				</script>';

			}

		} 

	}

	/*=============================================
	BORRAR REGISTRO DE AFILIADO CON RESULTADOS DE LABORATORIO COVID-19
	=============================================*/

	static public function ctrEliminarCovidResultado() {
		
		if (isset($_GET["idCovidResultado"])) {
			
			$tabla = "covid_resultados";
			$datos = $_GET["idCovidResultado"];

			if ($_GET["foto"] != "" && $_GET["foto"] != "vistas/img/covid_resultados/default/anonymous.png") {
				
				unlink($_GET["foto"]);
				rmdir("vistas/img/covid_resultados/".$_GET["codAfiliado"]);
			}

			$respuesta = ModeloCovidResultados::mdlEliminarCovidResultado($tabla, $datos);

			if ($respuesta == "ok") {
					
				echo '<script>		

					swal.fire({
						
						icon: "success",
						title: "¡El Registro ha sido borrado correctamente!",
						showConfirmButton: true,
						allowOutsideClick: false,
						confirmButtonText: "Cerrar"
						
					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "covid-resultados-lab";

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

							window.location = "covid-resultados-lab";
						}

					});

				</script>';
				
			}

		}
		
	}

	/*=====================================================================

	=======================================================================*/
	static public function ctrEditarNombreEmpleador($item,$datos){
		$tabla = "covid_resultados";
		$respuesta = ModeloCovidResultados::mdlEditarCovidResultadoNombreEmpleador($tabla,$item,$datos);
		return $respuesta;
	}

	/*=====================================================================

	=======================================================================*/
	static public function ctrEditarNombreEmpleadorId_Ficha($item,$datos){
		$tabla = "covid_resultados";
		$respuesta = ModeloCovidResultados::mdlEditarCovidResultadoNombreEmpleadorId_Ficha($tabla,$item,$datos);
		return $respuesta;
	}

	/*======================================================================
	PUBLICAR REGISTRO DE AFILIADO CON RESULTADOS DE LABORATORIO COVID-19
	======================================================================*/

	static public function ctrPublicarCovidResultado() {
		
		if (isset($_GET["idCovidResultado"])) {
			
			$tabla = "covid_resultados";
			$idCovidResultado = $_GET["idCovidResultado"];
			$estado = $_GET["estadoResultado"];

			$respuesta = ModeloCovidResultados::mdlPublicarCovidResultado($tabla, $idCovidResultado, $estado);

			if ($respuesta == "ok") {
					
				echo '<script>		

					swal.fire({
						
						icon: "success",
						title: "¡El Registro ha sido modificado correctamente!",
						showConfirmButton: true,
						allowOutsideClick: false,
						confirmButtonText: "Cerrar"
						
					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "covid-resultados-lab";

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

							window.location = "covid-resultados-lab";
						}

					});

				</script>';
				
			}

		}
		
	}

    /*=====================================================================
	METODO QUE ACTUALIZA LOS CAMPOS DE UN REGISTRO DE COVID RESULTADO
	======================================================================*/
	static public function mdlEditarCamposCovidResultado($id, $items, $datos){
		ModeloCovidResultados::mdlEditarCamposCovidResultado($id, $items, $datos);
	}

	/*=====================================================================
		Funcion para modificar el campo Tipo diagnostico en covid resultado @dan
	======================================================================*/
	static public function ctrEditarCovidResultadoTipoDiagnostico($id_ficha,$datos){
		$respuesta=ModeloCovidResultados::mdlEditarCamposCovidResultadoTipoDiagnostico($id_ficha,$datos);
		return $respuesta;
	}

	/*=====================================================================
	 FUNCION PARA MODIFICAR EL RESULTADO ESTADO Y RESPONDABLE DE COVID RESULTADO @dan
	 ======================================================================*/
	static public function ctrEditarcamposCovidResultadoFechaEstadoResponsable($id_ficha,$resultado,$responsable){
		$respuesta = ModeloCovidResultados::mdlEditarcamposCovidResultadoFechaEstadoResponsable($id_ficha,$resultado,$responsable);
		return $respuesta;
	}
	/*====================================================================

	 =====================================================================*/
	 static public function ctrRestablecerCamposCovidResultadoDiagnosticoResultadoResponsableEstado($id_ficha){
		 $respuesta = ModeloCovidResultados::mdlRestablecerCamposCovidResultadoDiagnosticoResultadoResponsableEstado($id_ficha);
		 return $respuesta;
	 }
	
}