<?php 

class ControladorUsuarios {

	/*=============================================
	INGRESO DE USUARIO
	=============================================*/
	
	static public function ctrIngresoUsuario() {

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis)
		$patron_textoEspecial = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+$/";

		// Patrón (admite numero y letras y tambien -)
		$patron_numerosLetras = "/^[A-Za-z0-9-]+$/";

		// Patrón (admite numero y letras)
		$patron_password = "/^[a-zA-Z0-9]+$/";

		if (isset($_POST["loginMatricula"])) {
			
			if (preg_match($patron_numerosLetras, $_POST["loginMatricula"]) &&
				preg_match($patron_numerosLetras, $_POST["loginCI"]) &&
				preg_match($patron_password, $_POST["loginPassword"])) {

				// encriptar el password ingresado para vereficar
				$encriptar = crypt($_POST["loginPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				
				// envió de parametros al modelo para obtener datos de usuario 

				$tabla = "usuarios";		
				$item = "matricula";
				$valor = $_POST["loginMatricula"];

				$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

				if ($respuesta["matricula"] == $_POST["loginMatricula"] && $respuesta["documento_ci"] == $_POST["loginCI"] && $respuesta["password"] == $encriptar) {

					if ($respuesta["estado"] == "ACTIVO") {

						// session_start();
						
						$_SESSION["iniciarSesionCOVID"] = "ok";
						$_SESSION["idUsuarioCOVID"] = $respuesta["id"];
						$_SESSION["paternoUsuarioCOVID"] = $respuesta["paterno"];
						$_SESSION["maternoUsuarioCOVID"] = $respuesta["materno"];
						$_SESSION["nombreUsuarioCOVID"] = $respuesta["nombre"];
						$_SESSION["cargoUsuarioCOVID"] = $respuesta["cargo"];
						$_SESSION["MatriculaUsuarioCOVID"] = $respuesta["matricula"];
						$_SESSION["fotoUsuarioCOVID"] = $respuesta["foto"];
						$_SESSION["perfilUsuarioCOVID"] = $respuesta["perfil"];


						echo '<script>

							window.location = "inicio";

						</script>';

					} else {

						echo '<div class="alert alert-danger mt-3">El usuario no está activo. Contactese con el Administrador de Sistemas.</div>';

					}					

				}else {

					echo '<div class="alert alert-danger mt-3">Error al ingresar, vuelva a intentarlo</div>';

				}

			}

		}

	}

	/*=============================================
	LISTADO DE USUARIOS
	=============================================*/
	
	static public function ctrMostrarUsuarios($item, $valor) {

		$tabla = "usuarios";
		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function ctrCrearUsuario() {

		// Patrón (admite letras acentuadas y espacios):
		$patron_texto = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/";

		// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
		$patron_textoEspecial = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+$/";

		// Patrón (admite numero y letras y tambien -)
		$patron_numerosLetras = "/^[A-Za-z0-9-]+$/";

		// Patrón (admite numero y letras)
		$patron_password = "/^[a-zA-Z0-9]+$/";
		
		if (isset($_POST["nuevaMatricula"])) {
			
			if (preg_match($patron_texto, $_POST["nuevoNombre"]) &&
				preg_match($patron_numerosLetras, $_POST["nuevaMatricula"]) &&
				preg_match($patron_numerosLetras, $_POST["nuevoCI"]) &&
				preg_match($patron_password , $_POST["nuevoPassword"]) &&
				preg_match($patron_textoEspecial, $_POST["nuevoCargo"])) {

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = "";

				if (isset($_FILES["nuevaFoto"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["nuevaFoto"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["nuevaMatricula"];

					mkdir($directorio, 0755);

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if ($_FILES["nuevaFoto"]["type"] == "image/jpeg") {
						
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["nuevaMatricula"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if ($_FILES["nuevaFoto"]["type"] == "image/png") {
						
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["nuevaMatricula"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["nuevaFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuarios";

				$encriptar = crypt($_POST["nuevoPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datos = array("paterno" 	    => strtoupper($_POST["nuevoPaterno"]),
				               "materno" 		=> strtoupper($_POST["nuevoMaterno"]),
				               "nombre" 		=> strtoupper($_POST["nuevoNombre"]), 
							   "matricula"      => $_POST["nuevaMatricula"],
							   "documento_ci"	=> $_POST["nuevoCI"],
							   "password" 		=> $encriptar,
							   "cargo"		    => strtoupper($_POST["nuevoCargo"]),
							   "perfil"   		=> $_POST["nuevoPerfil"],
							   "foto"     		=> $ruta);

				$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);

				if ($respuesta == "ok") {
					
					echo '<script>		

						swal.fire({
							
							icon: "success",
							title: "¡El usuario ha sido guardado correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "usuarios";

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

							window.location = "usuarios";

						}

					});

				</script>';

			}

		} 

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function ctrEditarUsuario() {

		if (isset($_POST["editarMatricula"])) {

			// Patrón (admite letras acentuadas y espacios):
			$patron_texto = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/";

			// Patrón (admite letras acentuadas y espacios y Caracteres Especiales -> punto y parentesis:
			$patron_textoEspecial = "/^[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+$/";

			// Patrón (admite numero y letras y tambien -)
			$patron_numerosLetras = "/^[A-Za-z0-9-]+$/";

				
			if (preg_match($patron_texto, $_POST["editarNombre"]) &&
				preg_match($patron_numerosLetras, $_POST["editarCI"]) &&
				preg_match($patron_textoEspecial, $_POST["editarCargo"])) {

				/*=============================================
				VALIDAR IMAGEN
				=============================================*/

				$ruta = $_POST["fotoActual"];

				if (isset($_FILES["editarFoto"]["tmp_name"]) && !empty($_FILES["editarFoto"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["editarFoto"]["tmp_name"]);
					
					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/img/usuarios/".$_POST["editarMatricula"];

					/*=============================================
					PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
					=============================================*/

					if (!empty($_POST["fotoActual"])) {

						unlink($_POST["fotoActual"]);

					} else {

						mkdir($directorio, 0755);

					}

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if ($_FILES["editarFoto"]["type"] == "image/jpeg") {
						
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarMatricula"]."/".$aleatorio.".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if ($_FILES["editarFoto"]["type"] == "image/png") {
						
						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$ruta = "vistas/img/usuarios/".$_POST["editarMatricula"]."/".$aleatorio.".png";

						$origen = imagecreatefrompng($_FILES["editarFoto"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized(dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "usuarios";

				if ($_POST["editarPassword"] != "") {

					if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarPassword"])) {
							
						$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

					} else {

						echo '<script>		

							swal.fire({
								
								icon: "error",
								title: "¡La contraseña no puede ir vacio o llevar caracteres especiales!",
								showConfirmButton: true,
								allowOutsideClick: false,
								confirmButtonText: "Cerrar",
								closeOnConfirm: false

							}).then((result) => {
			  					
			  					if (result.value) {

									window.location = "usuarios";

								}
							});

						</script>';
					}
					
				} else {

					$encriptar = $_POST["passwordActual"];

				}

				$datos = array("paterno" 	    => strtoupper($_POST["editarPaterno"]),
				               "materno" 		=> strtoupper($_POST["editarMaterno"]),
				               "nombre" 		=> strtoupper($_POST["editarNombre"]), 
							   "matricula"      => $_POST["editarMatricula"],
							   "documento_ci"	=> $_POST["editarCI"],
							   "password" 		=> $encriptar,
							   "cargo"		    => strtoupper($_POST["editarCargo"]),
							   "perfil"   		=> $_POST["editarPerfil"],
							   "foto"     		=> $ruta);

				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if ($respuesta == "ok") {
					
					echo '<script>		

						swal.fire({
							
							icon: "success",
							title: "¡El usuario ha sido editado correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar",
							closeOnConfirm: false

						}).then((result) => {
		  					
		  					if (result.value) {

								window.location = "usuarios";

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

							window.location = "usuarios";

						}
					});

				</script>';

			}

		}

	}

}