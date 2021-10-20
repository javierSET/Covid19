// /*=============================================
// CARGAR LA TABLA DINÁMICA DE COVID RESULTADOS
// =============================================*/

// var perfilOculto = $("#perfilOculto").val();

// var actionCovidResultados = $("#actionCovidResultados").val();

// $('#tablaCovidResultados').DataTable({

// 	"ajax": "ajax/datatable-covid_resultados.ajax.php?perfilOculto="+perfilOculto+"&actionCovidResultados="+actionCovidResultados,

// 	"deferRender": true,

// 	"retrieve" : true,

// 	"processing" : true,

// 	"rowCallback": function(row, data, index) {
// 		if ( data[22] == "0" ) {
//            $('td', row).addClass('bg-lightblue color-palette');
//            $('tr.child', row).addClass('bg-lightblue color-palette');
// 		}
// 	},

// 	"language": {

// 		"sProcessing":     "Procesando...",
// 		"sLengthMenu":     "Mostrar _MENU_ registros",
// 		"sZeroRecords":    "No se encontraron resultados",
// 		"sEmptyTable":     "Ningún dato disponible en esta tabla",
// 		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
// 		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
// 		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
// 		"sInfoPostFix":    "",
// 		"sSearch":         "Buscar:",
// 		"searchPlaceholder": "Escribe aquí para buscar...",
// 		"sUrl":            "",
// 		"sInfoThousands":  ",",
// 		"sLoadingRecords": "Cargando...",
// 		"oPaginate": {
// 		"sFirst":    "Primero",
// 		"sLast":     "Último",
// 		"sNext":     "Siguiente",
// 		"sPrevious": "Anterior"
// 		},
// 		"oAria": {
// 			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
// 			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
// 		}
		
// 	},

// 	"responsive": true,

// 	"lengthChange": false,

// 	"ordering": false

// }); 

/*=============================================
CARGAR LA TABLA DINÁMICA DE COVID RESULTADOS
=============================================*/

var perfilOculto = $("#perfilOculto").val();

var actionCovidResultados = $("#actionCovidResultados").val();

$('#tablaCovidResultados').DataTable({

	"processing": true,

    "serverSide": true,

    "ajax": {
		url: "ajax/datatable-covid_resultados.ajax.php",
		data: { 'perfilOculto' : perfilOculto, 'actionCovidResultados' : actionCovidResultados },
		type: "post"
	},

	"rowCallback": function(row, data, index) {
		var resultado =  data[18].indexOf("EN ESPERA...");
		if ( data[22] == 0 && resultado === -1) { //Publicado o no
           $('td', row).addClass('bg-faltaPublicar');
           $('tr.child', row).addClass('bg-faltaPublicar');
		}
		if ( data[22] == 0 && resultado !== -1) { //Publicado o no
			$('td', row).addClass('bg-lightblue color-palette');
			$('tr.child', row).addClass('bg-lightblue color-palette');
		 }
	},

	"order": [[ 0, "desc" ]],

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
		}
		
	},

	"responsive": true,

	"lengthChange": false

}); 

/*=============================================
SUBIENDO LA FOTO DEL AFILIADO 
=============================================*/
$(".nuevaFotoAfiladoResultado").change(function() {
 	
 	var imagen = this.files[0];

 	/*=============================================
	SUBIENDO LA FOTO DEL AFILIADO
	=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

		$(".nuevaFotoAfiladoResultado").val("");

		swal.fire({
			
			title: "Error al subir la imagen",
			text: "La imagen debe estar en formato JPG o PNG",
			icon: "error",
			allowOutsideClick: false,
			confirmButtonText: "¡Cerrar!"

		});

	} else if(imagen["size"] > 2000000) {

		$(".nuevaFotoAfiladoResultado").val("");

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
BOTÓN EDITAR COVID RESULTADOS
=============================================*/

$(document).on("click", "button.btnEditarCovidResultado", function() {
	
	var idCovidResultado = $(this).attr("idCovidResultado");

	window.location = "index.php?ruta=editar-covid-resultado&idCovidResultado="+idCovidResultado;


});

/*=============================================
ELIMINAR RESULTADO COVID
=============================================*/

$(document).on("click", "button.btnEliminarCovidResultado", function() {
	
	var idCovidResultado = $(this).attr("idCovidResultado");
	var codAfiliado = $(this).attr("codAfiliado");
	var foto = $(this).attr("foto");

	swal.fire({

		title: "¿Está seguro de borrar el registro?",
		text: "¡Si no lo está puede cancelar la acción!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "¡Si, borrar registro!"

	}).then((result)=> {

		if (result.value) {

			window.location = "index.php?ruta=covid-resultados-lab&eliminar&idCovidResultado="+idCovidResultado+"&foto="+foto+"&codAfiliado="+codAfiliado;

		}

	});
		
});

/*=============================================
PUBLICAR RESULTADO COVID
=============================================*/

$(document).on("click", "button.btnPublicarCovidResultado", function() {
	
	var idCovidResultado = $(this).attr("idCovidResultado");
	var estadoResultado = $(this).attr("estadoResultado");

	if (estadoResultado == 1) {

		swal.fire({

			title: "¿Está seguro de publicar el resultado?",
			text: "¡Si no lo está puede cancelar la acción!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, publicar resultado!"

		}).then((result)=> {

			if (result.value) {

				window.location = "index.php?ruta=covid-resultados-lab&publicar&idCovidResultado="+idCovidResultado+"&estadoResultado="+estadoResultado;

			}

		});

	} else {

		swal.fire({

			title: "¿Está seguro de quitar la publicación el resultado?",
			text: "¡Si no lo está puede cancelar la acción!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, quitar publicar resultado!"

		}).then((result)=> {

			if (result.value) {

				window.location = "index.php?ruta=covid-resultados-lab&publicar&idCovidResultado="+idCovidResultado+"&estadoResultado="+estadoResultado;

			}

		});

	}
		
});

/*=============================================
BOTON QUE GENERA LOS RESULTADOS COVID POR FILTRADO DE FECHA
=============================================*/

$(document).on("click", ".btnCovidResultados", function() {

	$('#tablaCovidResultados').remove();
	$('#tablaCovidResultados_wrapper').remove();

	$("#resultadosCovid").append(

	  '<table class="table table-bordered table-striped dt-responsive" id="tablaCovidResultados" width="100%">'+
        
        '<thead>'+
          
          '<tr>'+
            '<th>COD. LAB.</th>'+
            '<th>COD. ASEGURADO</th>'+
            '<th>COD. AFILIADO</th>'+
            '<th>APELLIDOS Y NOMBRES</th>'+
            '<th>CI</th>'+
            '<th>FECHA RECEPCIÓN</th>'+
            '<th>FECHA MUESTRA</th>'+
            '<th>TIPO DE MUESTRA</th>'+
            '<th>MUESTRA CONTROL</th>'+
            '<th>DEPARTAMENTO</th>'+
            '<th>ESTABLECIMIENTO</th>'+
            '<th>SEXO</th>'+
            '<th>FECHA NACIMIENTO</th>'+
            '<th>TELÉFONO</th>'+
            '<th>EMAIL</th>'+
            '<th>LOCALIDAD</th>'+
            '<th>ZONA</th>'+
            '<th>DIRECCION</th>'+
            '<th>RESULTADO</th>'+
            '<th>FECHA RESULTADO</th>'+
            '<th>OBSERVACIONES</th>'+
            '<th>ACCIONES</th>'+
          '</tr>'+

        '</thead>'+
        
      '</table>'  

    );       			

	var fecha = $("#fechaCovidResultados").val();

	/*=============================================
	CARGAR LA TABLA DINÁMICA DE COVID RESULTADOS
	=============================================*/

	var perfilOculto = $(this).attr("perfilOculto");

	var actionCovidResultados = $(this).attr("actionCovidResultados");

	$('#tablaCovidResultados').DataTable({

		"ajax": "ajax/datatable-covid_resultados.ajax.php?perfilOculto="+perfilOculto+"&actionCovidResultados="+actionCovidResultados+"&fecha="+fecha,

		"deferRender": true,

		"retrieve" : true,

		"processing" : true,

		"rowCallback": function(row, data, index) {
	       if ( data[22] == "0" )
	       {
	           $('td', row).addClass('bg-lightblue color-palette');
	           $('tr.child', row).addClass('bg-lightblue color-palette');
	       }
		},

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
			}
			
		},

		"responsive": true,

		"lengthChange": false,

		"ordering": false

	}); 


});

/*=============================================
SI NUEVO TIPO DE MUESTRA ES ELISA SE HABILITAN NUEVOS CAMPOS
=============================================*/

/* $(document).on("blur", "#nuevoTipoMuestra", function() {
	
	var tipoMuestra = $(this).val();
	
	if (tipoMuestra == "ELISA") {

		$(".observacion").replaceWith(
			'<div class="form-group col-md-6 observacion">'+
				'<div class="form-group col-md-2">'+
	                '<label for="lgM">lgM</label>'+
	                '<input type="text" class="form-control" id="lgM" name="lgM" pattern="[0-9 ,]+" title="Solo se admiten números y ," required>'+
	            '</div>'+
	            '<div class="form-group col-md-2">'+
	                '<label for="lgG">lgG</label>'+
	                '<input type="text" class="form-control" id="lgG" name="lgG" pattern="[0-9 ,]+" title="Solo se admiten números y ," required>'+
	            '</div>'+
            '</div>');

	} else {

		$(".observacion").replaceWith(
			'<div class="form-group col-md-6 observacion">'+
	            '<label for="nuevaObservacion">Observaciones</label>'+
	            '<textarea class="form-control mayuscula" id="nuevaObservacion" name="nuevaObservacion" placeholder="Ingresar observaciones (Opcional)" rows="3" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-(),/#]+" title="Caracteres no admitidos"></textarea>'+
	        '</div>');
	}

}); */

$(document).on("blur", "#editarTipoMuestra", function() {
	
	var tipoMuestra = $(this).val();
	
	if (tipoMuestra == "ELISA") {

		$(".observacion").replaceWith(
			'<div class="form-group col-md-6 observacion">'+
				'<div class="form-group col-md-2">'+
	                '<label for="lgM">lgM</label>'+
	                '<input type="text" class="form-control" id="lgM" name="lgM" pattern="[0-9 ,]+" title="Solo se admiten números y ," required>'+
	            '</div>'+
	            '<div class="form-group col-md-2">'+
	                '<label for="lgG">lgG</label>'+
	                '<input type="text" class="form-control" id="lgG" name="lgG" pattern="[0-9 ,]+" title="Solo se admiten números y ," required>'+
	            '</div>'+
            '</div>');

	} else {

		$(".observacion").replaceWith(
			'<div class="form-group col-md-6 observacion">'+
	            '<label for="editarObservacion">Observaciones</label>'+
	            '<textarea class="form-control mayuscula" id="editarObservacion" name="editarObservacion" placeholder="Ingresar observaciones (Opcional)" rows="3" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-(),/#]+" title="Caracteres no admitidos"></textarea>'+
	        '</div>');
	}

});


/***************************************************
 *  EVENTOS APARTADO 9 RESULTADOS
 ***************************************************/

$('#pcrTiempoReal').change(function(){
	valor = "";
	accionAEjecutar = "guardarCampoLaboratorios";
	//alert("hizo: " + valor);

	if ($('#pcrTiempoReal').prop('checked') ){
		valor = $('#l1pcrTiemporeal').text();
		$('#pcrGenExpert').removeAttr('required');
		//para obligar el metodo diagnostico
		$('#pcrGenExpert').removeAttr('required');	
		$('#pruebaAntigenica').removeAttr('required');
	}
	else if(!$('#pcrGenExpert').prop('checked') && !$('#pruebaAntigenica').prop('checked')) {
		$('#pcrTiempoReal').attr('required','required');
		$('#pcrGenExpert').attr('required','required');
		$('#pruebaAntigenica').attr('required','required');
	}


	actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'metodo_diagnostico_pcr_tiempo_real', valor, 'laboratorios');
	accionAEjecutar = "guardarCampoCovidResultados";
	actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'metodo_diagnostico_pcr_tiempo_real', valor, 'covid_resultados');
	
});

$('#pcrGenExpert').change(function(){
   valor = "";
   //alert("hizo: " + valor);
   accionAEjecutar = "guardarCampoLaboratorios";
   if ($('#pcrGenExpert').prop('checked') ){
	   valor = $('#l2pcrGenExpert').text();
	   //para obligar el Metodo Diagnostico
	   $('#pcrTiempoReal').removeAttr('required');
	   $('#pruebaAntigenica').removeAttr('required');
   }
   else if(!$('#pcrTiempoReal').prop('checked') && !$('#pruebaAntigenica').prop('checked')){
	   		$('#pcrGenExpert').attr('required','required');
			$('#pcrTiempoReal').attr('required','required');
			$('#pruebaAntigenica').attr('required','required');
   }

   actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'metodo_diagnostico_pcr_genexpert', valor, 'laboratorios');
   accionAEjecutar = "guardarCampoCovidResultados";
   actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'metodo_diagnostico_pcr_genexpert', valor, 'covid_resultados');
   
});

$('#pruebaAntigenica').change(function(){
   valor = "";
   accionAEjecutar = "guardarCampoLaboratorios";
   //alert("hizo: " + valor);
   if ($('#pruebaAntigenica').prop('checked')){
	   $('#nuevoFechaEnvio').val('');
	   actualizarCampoCovidResultados('guardarCampoLaboratorios',$("#idFicha").val(), 'fecha_envio', '', 'laboratorios');
	   $('#nuevoFechaEnvio').attr('disabled','disabled');
	   valor = $('#l3pcrPruebaAntigenica').text();
	   //para obligar el Metodo de Diagnostico
	   $('#pcrTiempoReal').removeAttr('required');
	   $('#pcrGenExpert').removeAttr('required');

   }
   else{
	   $('#nuevoFechaEnvio').removeAttr('disabled');
	   //para obligar el Metodo de Diagnostico
	   if(!$('#pcrTiempoReal').prop('checked') && !$('#pcrGenExpert').prop('checked')){
		   $('#pruebaAntigenica').attr('required','required');
		   $('#pcrTiempoReal').attr('required','required');
		   $('#pcrGenExpert').attr('required','required');
	   }
   }

   actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'metodo_diagnostico_prueba_antigenica', valor, 'laboratorios');
   accionAEjecutar = "guardarCampoCovidResultados";
   actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'metodo_diagnostico_prueba_antigenica', valor, 'covid_resultados');
});

/***************************************************
 *  ACTUALIZA UN CAMPO EN LA TABLA COVID_RESULTADOS
 ***************************************************/

function actualizarCampoCovidResultados(accionAEjecutar,id_ficha, item, valor, tabla) {

	var datos = new FormData();

	datos.append(accionAEjecutar, accionAEjecutar);
	datos.append("id_ficha", id_ficha);
	datos.append("item", item);
	datos.append("valor", valor);
	datos.append("tabla", tabla);

  $.ajax({

   	url:"ajax/fichas.ajax.php",
  	method: "POST",
  	data: datos,
  	cache: false,
  	contentType: false,
  	processData: false,
  	dataType: "html",
  	success: function(respuesta) {
		  console.log("esta es la respuesta");
		  console.log(respuesta);

	    if (respuesta == "") {

			toastr.success('El Dato se guardó correctamente.')

		} else {

			toastr.warning('¡Error! Falla 1 en la consulta a BD, no se modificaron.')
		}

  	},
	error: function(error) {
        //console.log(error);
      	toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.')
        
    }

	});

}

/*****************************************************************************************
 *  EVENTOS DE LA SECCION 9 RESULTADOS CAMBIANDO EL RESULTADO DE LA TABLA COVID_RESULTADOS
 *****************************************************************************************/
$('#positivo').change(function(){
	$('#nuevoFechaResultado').removeAttr('readonly');
	item = "resultado";
	valor = "POSITIVO";
	accionAEjecutar = "guardarCampoCovidResultados";
	id_ficha = $("#idFicha").val();
	tabla = "covid_resultados";
	actualizarCampoCovidResultados(accionAEjecutar,id_ficha, item, valor, tabla);
	actualizarCampoCovidResultados('guardarCampoLaboratorios',id_ficha,'resultado_laboratorio', valor, 'laboratorios');
});

$('#negativo').change(function(){
	$('#nuevoFechaResultado').removeAttr('readonly');
	item = "resultado";
	valor = "NEGATIVO";
	accionAEjecutar = "guardarCampoCovidResultados";
	id_ficha = $("#idFicha").val();
	tabla = "covid_resultados";
	actualizarCampoCovidResultados(accionAEjecutar,id_ficha, item, valor, tabla);
	actualizarCampoCovidResultados('guardarCampoLaboratorios',id_ficha, 'resultado_laboratorio', valor, 'laboratorios');
});

/*****************************************************************************************
 *  CAMBIANDO LA FECHA DE LA TABLA COVID_RESULTADOS
 *****************************************************************************************/

$('#nuevoFechaResultado').change(function(){
	//alert($('#nuevoFechaResultado').val());
	
	item = "fecha_resultado";
	valor = $('#nuevoFechaResultado').val();
	accionAEjecutar = "guardarCampoCovidResultados";
	id_ficha = $("#idFicha").val();
	tabla = "covid_resultados";
	actualizarCampoCovidResultados(accionAEjecutar,id_ficha, item, valor, tabla);
	actualizarCampoCovidResultados('guardarCampoLaboratorios',id_ficha, item, valor, 'laboratorios');
	
});

/************************************************************************************************
 *  GUARDANDO EL RESPONSABLE DE ANALISIS EN LA TABLA COVID_RESULTADOS
 ************************************************************************************************/
$('#responsableAnalisis').change(function(){
	valor = $('#responsableAnalisis').val();
	//alert(valor);

	accionAEjecutar = "guardarCampoCovidResultados";
	if (valor != 'Elegir...' )	
	 actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'responsable_muestra', valor, 'covid_resultados');
	else  actualizarCampoCovidResultados(accionAEjecutar,$("#idFicha").val(), 'responsable_muestra','', 'covid_resultados');
	 
 });

 $(document).ready(function(){

	var ruta = window.location.href;
	var editarLab  = "editar-ficha-epidemiologica-lab";
	let posEditarLab = ruta.indexOf(editarLab);

	//Controlamos que los cambios sean requeridos solo de la seccion 8
	if (!(posEditarLab !== -1)){
		
		if($('#pcrTiempoReal').prop('checked') ){
		   $('#pcrGenExpert').removeAttr('required');
		   $('#pruebaAntigenica').removeAttr('required');
		}
		else if(!$('#pcrGenExpert').prop('checked') && !$('#pruebaAntigenica').prop('checked')){
			   $('#pcrTiempoReal').attr('required','required');
		}
	
		if($('#pcrGenExpert').prop('checked') ){
		   $('#pcrTiempoReal').removeAttr('required');
		   $('#pruebaAntigenica').removeAttr('required');
		}
		else if(!$('#pcrTiempoReal').prop('checked') && !$('#pruebaAntigenica').prop('checked')){
		   $('#pcrGenExpert').attr('required','required');
		}
	
		if($('#pruebaAntigenica').prop('checked') ){
		   $('#pcrTiempoReal').removeAttr('required');
		   $('#pcrGenExpert').removeAttr('required');
		}
		else if(!$('#pcrTiempoReal').prop('checked') && !$('#pcrGenExpert').prop('checked')){
		   $('#pruebaAntigenica').attr('required','required');
		}
		
	}
	$('#transferenciaHospital').removeAttr('disabled')

 });

 $('#transferenciaHospital').change(function(){	 
	var accion = "actualizarTransferencia"
	var id_ficha = $("#idFicha").val()
	var item = "transferencia_hospital_obreo"
	var valor = ""
	 if($(this).prop('checked')){
		//toastr.success("POSITIVO")
		valor="SI"
		actualizarCampoTransferenciaHospitalObrero(accion,id_ficha,item,valor,'laboratorios')
		$('#idFichaEpiLaboratorioT').hide()
	 }else{
		//toastr.warning("NEGATIVO")
		valor=""
		actualizarCampoTransferenciaHospitalObrero(accion,id_ficha,item,valor,'laboratorios')
		$('#idFichaEpiLaboratorioT').show()
	 }
 })

 /*=======================================================================
 	Funcion para modificar el campo transferencia_hospital_obrero de la tabla Laboratorio @dan
   ======================================================================= */

   function actualizarCampoTransferenciaHospitalObrero(accion,id_ficha,item,valor,tabla) {
	   datos = new FormData()
	   datos.append(accion,accion)
	   datos.append("id_ficha",id_ficha)
	   datos.append("item",item)
	   datos.append("valor",valor)
	   datos.append("tabla",tabla)

	   $.ajax({
		url:"ajax/fichas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "html",
		success: function(respuesta) {			
			toastr.success('El Dato se guardó correctamente.')
		},
		error: function(error) {		 
			toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.')		 
		} 
	 })
   }