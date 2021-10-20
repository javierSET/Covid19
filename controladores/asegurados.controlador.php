<?php 

class ControladorAsegurados {
	
	/*=============================================
	MOSTRAR ASEGURADOS
	=============================================*/
	
	static public function ctrMostrarAsegurados($item, $valor) {

		$tabla = "asegurados";

		$respuesta = ModeloAsegurados::mdlMostrarAsegurados($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	REGISTRO DE NUEVO ASEGURADO
	=============================================*/

	static public function ctrCrearAsegurado() {
		
		if (isset($_POST["nuevoNombre"])) {
			
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoPaterno"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoMaterno"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombre"]) &&
				preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoDocumentoCI"]) &&
				preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) &&
				preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["nuevoEmail"]) &&
				preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaZona"]) &&
				preg_match('/^[#\.\-a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevaCalle"]) &&
				preg_match('/^[-0-9]+$/', $_POST["nuevoNroCalle"]) &&
				preg_match('/^[.0-9 ]+$/', $_POST["nuevoSalario"])) {

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				
				$ruta = "";

				if (isset($_FILES["nuevaFotoAsegurado"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["nuevaFotoAsegurado"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL ASEGURADO
					=============================================*/

					$directorio = "vistas/img/asegurados/".$_POST["nuevoDocumentoCI"];

					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if ($_FILES["nuevaFotoAsegurado"]["type"] == "image/jpeg") {
						
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/asegurados/".$_POST["nuevoDocumentoCI"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaFotoAsegurado"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if ($_FILES["nuevaFotoAsegurado"]["type"] == "image/png") {
						
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/asegurados/".$_POST["nuevoDocumentoCI"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFotoAsegurado"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				/*=============================================
				GENERAR LA MATRICULA
				=============================================*/

				$anio = date("y", strtotime($_POST["nuevaFechaNacimiento"]));

				if ($_POST["nuevoSexo"] == "MUJER") {

					$mes = date("m", strtotime($_POST["nuevaFechaNacimiento"]))+50;

				} else {

					$mes = date("m", strtotime($_POST["nuevaFechaNacimiento"]));

				}
				
				$dia = date("d", strtotime($_POST["nuevaFechaNacimiento"]));

				$paterno = $_POST["nuevoPaterno"];
				$materno = $_POST["nuevoMaterno"];
				$nombre = $_POST["nuevoNombre"];

				$matricula = $anio.$mes.$dia.substr($paterno, 0, 1).substr($materno, 0, 1).substr($nombre, 0, 1);

				
				/*=============================================
				ALMACENANDO LOS DATOS EN LA BD
				=============================================*/

				$tablaAsegurado = "asegurados";

				$datosAsegurado = array("paterno"			    => $_POST["nuevoPaterno"], 
								        "materno"               => $_POST["nuevoMaterno"],
								        "nombre" 		        => $_POST["nuevoNombre"],
								        "sexo"	                => $_POST["nuevoSexo"],
								        "fecha_nacimiento"	    => $_POST["nuevaFechaNacimiento"],
								        "documento_ci"			=> $_POST["nuevoDocumentoCI"],
								        "telefono"				=> $_POST["nuevoTelefono"],
								        "email"					=> $_POST["nuevoEmail"],
								        "id_localidad"			=> $_POST["nuevaLocalidad"],
								        "zona"   		        => $_POST["nuevaZona"],
								        "calle"   		        => $_POST["nuevaCalle"],
								        "nro_calle"   		    => $_POST["nuevoNroCalle"],
								        "salario"   		    => $_POST["nuevoSalario"],
								        "id_ocupacion"   		=> $_POST["nuevaOcupacion"],
								        "fecha_ingreso"   		=> $_POST["nuevaFechaIngreso"],
								        "id_empleador"   		=> $_POST["idEmpleador"],
								        "id_seguro"   		    => $_POST["nuevoTipoSeguro"],
								        "matricula"     		=> $matricula,
								        "foto"     		        => $ruta);

				$idAsegurado = ModeloAsegurados::mdlIngresarAsegurado($tablaAsegurado, $datosAsegurado);

				$tablaBeneficiario = "beneficiarios";

				$datosBeneficiario = array("paterno"			=> $_POST["nuevoPaterno"], 
								           "materno"            => $_POST["nuevoMaterno"],
								           "nombre" 		    => $_POST["nuevoNombre"],
								           "sexo"	            => $_POST["nuevoSexo"],
								           "fecha_nacimiento"	=> $_POST["nuevaFechaNacimiento"],
								           "documento_ci"		=> $_POST["nuevoDocumentoCI"],
								           "telefono"			=> $_POST["nuevoTelefono"],
								           "email"				=> $_POST["nuevoEmail"],
								           "zona"   		    => $_POST["nuevaZona"],
								           "calle"   		    => $_POST["nuevaCalle"],
								           "nro_calle"   		=> $_POST["nuevoNroCalle"],
								           "id_parentesco"		=> "29",
								           "fecha_extincion"	=> "0000-00-00",
								           "id_establecimiento"	=> $_POST["nuevoEstablecimiento"],
								           "id_consultorio"   	=> $_POST["nuevoConsultorio"],
								           "id_asegurado"     	=> $idAsegurado);

				$respuesta = ModeloBeneficiarios::mdlIngresarBeneficiario($tablaBeneficiario, $datosBeneficiario);



				if ($respuesta == "ok") {
					
					echo '<script>		

						swal.fire({
							
							icon: "success",
							title: "¡El asegurado ha sido guardado correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "index.php?ruta=beneficiarios&idEmpleador="'.$_POST["idEmpleador"].';

							}

						});

					</script>';

				}

			} else {

				echo '<script>		

					swal.fire({
						
						icon: "error",
						title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!",
						showConfirmButton: true,
						allowOutsideClick: false,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false

					}).then((result) => {
	  					
	  					if (result.value) {

							window.location = "index.php?ruta=nuevo-asegurado&idEmpleador="'.$_POST["idEmpleador"].';

						}

					});

				</script>';

			}

		} 

	}
	
}