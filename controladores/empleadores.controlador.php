<?php


class ControladorEmpleadores {

	/*=============================================
	NUEVO EMPLEADOR
	=============================================*/
	
	static public function ctrCrearEmpleador() {
		
		if(isset($_POST["nuevoEmpresa"])){

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCliente"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["nuevoDocumentoCI"])){

		   	$tabla = "clientes";

		   	$datos = array("nombre"						=> $_POST["nuevoCliente"],
				               "documento_ci"     => $_POST["nuevoDocumentoCI"],
				               "direccion"        => $_POST["nuevaDireccion"],
				               "telefono"         => $_POST["nuevoTelefono"],
				               "email"            => $_POST["nuevoEmail"],
				               "fecha_nacimiento" => $_POST["nuevaFechaNacimiento"]);

		   	$respuesta = ModeloClientes::mdlIngresarCliente($tabla, $datos);

		   	if ($respuesta == "ok") {

					echo'<script>

						swal.fire({
							
							icon: "success",
							title: "El cliente ha sido guardado correctamente",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar"
						}).then((result) => {
							
							if (result.value) {

								window.location = "clientes";

							}
						})

					</script>';

				}

			} else {

				echo '<script>		

					swal.fire({
						icon: "error",
						title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						allowOutsideClick: false,
						confirmButtonText: "Cerrar"
					
					}).then((result) => {

						if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	MOSTRAR EMPLEADORES
	=============================================*/
	
	static public function ctrMostrarEmpleadores($item, $valor) {

		$tabla = "empleadores";

		$respuesta = ModeloEmpleadores::mdlMostrarEmpleadores($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAR EMPLEADOR
	=============================================*/
	
	static public function ctrEditarEmpleador() {
		
		if(isset($_POST["editarCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarCliente"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["editarDocumentoCI"])){

		   	$tabla = "clientes";

		   	$datos = array("idcliente"				=> $_POST["idCliente"],
		   				         "nombre"           => $_POST["editarCliente"],
				               "documento_ci"     => $_POST["editarDocumentoCI"],
				               "direccion"        => $_POST["editarDireccion"],
				               "telefono"         => $_POST["editarTelefono"],
				               "email"            => $_POST["editarEmail"],
				               "fecha_nacimiento" => $_POST["editarFechaNacimiento"]);

		   	$respuesta = ModeloClientes::mdlEditarCliente($tabla, $datos);
		   	
		   	if($respuesta == "ok"){

					echo'<script>

						swal.fire({
							
							icon: "success",
							title: "El cliente ha sido cambiado correctamente",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar"

						}).then((result) => {
							
							if (result.value) {

								window.location = "clientes";

							}
						})

					</script>';

				}

			}else{

				echo '<script>		

					swal.fire({
						icon: "error",
						title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						allowOutsideClick: false,
						confirmButtonText: "Cerrar"
					
					}).then((result) => {

						if (result.value) {

							window.location = "clientes";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	ELIMINAR EMPLEADOR
	=============================================*/

	static public function ctrEliminarEmpleador()	{

		if (isset($_GET["idCliente"])) {
			
			$tabla = "clientes";
			$datos = $_GET["idCliente"];

			$respuesta = ModeloClientes:: mdlEliminarCliente($tabla, $datos);

			if ($respuesta == "ok") {
				
				echo'<script>

						swal.fire({
							
							icon: "success",
							title: "El cliente ha sido borrado correctamente",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Cerrar"
							
						}).then((result) => {
							
							if (result.value) {

								window.location = "clientes";

							}
						})

					</script>';

			}

		}
		
	}

}
