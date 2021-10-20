$(document).ready(function() {

	/*=============================================
	Data table
	=============================================*/

	$("#tablaUsuarios").DataTable({

		"language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"searchPlaceholder": "Escribe aquí para buscar...",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			},
			// "buttons": {
			// 	"copy": "Copiar",
		 //      	-"colvis": "Visibilidad de columnas"
		 //    }

		},

		"responsive": true,

		"lengthChange": false,

		//"dom": 'Bfrtip',

		//"buttons": [ 'copy', 'excel', 'pdf', 'colvis' ]

	}).buttons().container()

  	.appendTo( '#example_wrapper .col-md-6:eq(0)' );

});

/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
$(".nuevaFoto").change(function() {
 	
 	var imagen = this.files[0];

 	/*=============================================
	SUBIENDO LA FOTO DEL USUARIO
	=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

		$(".nuevaFoto").val("");

		swal.fire({
			
			title: "Error al subir la imagen",
			text: "La imagen debe estar en formato JPG o PNG",
			icon: "error",
			allowOutsideClick: false,
			confirmButtonText: "¡Cerrar!"

		});

	} else if(imagen["size"] > 2000000) {

		$(".nuevaFoto").val("");

		swal.fire({

			title: "Error al subir la imagen",
			text: "La imagen no debe pesar mas de 2MB",
			icon: "error",
			allowOutsideClick: false,
			confirmButtonText: "¡Cerrar!"

		});

	} else {

		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function(event){

			var rutaImagen = event.target.result;
			$(".previsualizar").attr("src", rutaImagen);

		});

	}

});

/*=============================================
EDITAR USUARIO
=============================================*/

$(document).on("click", ".btnEditarUsuario", function() {
	
	var idUsuario = $(this).attr("idUsuario");
	
	var datos = new FormData();
	datos.append("idUsuario", idUsuario);

	$.ajax({

		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			$("#editarPaterno").val(respuesta["paterno"]);
			$("#editarMaterno").val(respuesta["materno"]);
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarMatricula").val(respuesta["matricula"]);
			$("#editarCI").val(respuesta["documento_ci"]);
			$("#editarCargo").val(respuesta["cargo"]);
			$("#editarPerfil").html(respuesta["perfil"]);
			$("#editarPerfil").val(respuesta["perfil"]);
			$("#fotoActual").val(respuesta["foto"]);
			$("#passwordActual").val(respuesta["password"]);			

			if (respuesta["foto"] != "") {

				$(".previsualizar").attr("src", respuesta["foto"]);

			}

		},
	    error: function(error){

	      console.log("No funciona");
	        
	    }

	});

});

/*=============================================
ACTIVAR USUARIO
=============================================*/

$(document).on("click", ".btnActivar", function() {
	
	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");
	console.log("estadoUsuario", estadoUsuario);



	var datos = new FormData();
	datos.append("activarId", idUsuario);
	datos.append("activarUsuario", estadoUsuario);

	$.ajax({

		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {
			
			if (window.matchMedia("(max-width:767px)").matches) {

				swal.fire({
					
					title: "El usuario ha sido actualizado",
					icon: "success",
					allowOutsideClick: false,
					confirmButtonText: "¡Cerrar!"

				}).then(function(result) {

					if (result.value) {

						window.location = "usuarios";
					}

				});

			} else {

				swal.fire({
					
					title: "El usuario ha sido actualizado",
					icon: "success",
					allowOutsideClick: false,
					confirmButtonText: "¡Cerrar!"

				});

			}

		},
		error: function(error){

	    	console.log("No funciona");
	        
	    }

	});

	if (estadoUsuario == 'INACTIVO') {

		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('INACTIVO');
		$(this).attr('estadoUsuario', 'ACTIVO');

	} else {

		$(this).addClass('btn-success');
		$(this).removeClass('btn-danger');
		$(this).html('ACTIVO');
		$(this).attr('estadoUsuario', 'INACTIVO');

	}

});

/*=============================================
REVISAR SI EL USUARIO YA ESTÁ REGISTRADO
=============================================*/

$("#nuevaMatricula").change(function() {

	$(".invalid-feedback").remove();
	
	$(this).removeClass('is-invalid');
	$(this).addClass('is-valid');
	
	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("validarUsuario", usuario);

	$.ajax({
		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {

			if (respuesta) {

				$("#nuevaMatricula").parent().after('<div class="invalid-feedback" style="display: none;">Este usuario ya existe en la base de datos</div>');				

				$("#nuevaMatricula").addClass('is-invalid');
				
				$(".invalid-feedback").show('fast');

				$("#nuevaMatricula").val('');

				$("#nuevaMatricula").parent().after().removeClass('mb-3');

			} 

		},
		error: function(error){

	    	console.log("No funciona");
	        
	    }

	});

});

/*=============================================
ELIMINAR USUARIO
=============================================*/

$(document).on("click", ".btnEliminarUsuario", function() {
	
	var idUsuario = $(this).attr("idUsuario");
	var fotoUsuario = $(this).attr("fotoUsuario");
	var nickUsuario = $(this).attr("nickUsuario");

	swal.fire({

		title: '¿Está seguro de borrar el usuario?',
		text: '¡Si no lo esta puede cancelar la acción!',
		icon: 'warning',
		showCancelButton: true,
		allowOutsideClick: false,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar usuario!'

	}).then((result)=>{

		if (result.value) {

			window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&nickUsuario="+nickUsuario+"&fotoUsuario="+fotoUsuario;

		}

	});

});