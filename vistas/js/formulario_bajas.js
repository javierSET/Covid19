/*==================================================================
CARGAR LA TABLA DINÁMICA DE FORMULARIOS DE BAJA POR METODO POST
====================================================================*/

var perfilOculto = $("#perfilOculto").val();

var table = $('#tablaFormularioBajas').DataTable({

	"processing": true,
	
    "serverSide": true,

	//"pageLength": 5,

	"ajax": {
		url: "ajax/datatable-formulario_bajas.ajax.php",
		data: { 'perfilOculto' : perfilOculto },
		type: "post"
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

	"lengthChange": false,

});


/* $('#tablaFormularioBajas').DataTable({

	"ajax": "ajax/datatable-formulario_bajas.ajax.php?perfilOculto="+perfilOculto,
	"deferRender": true,
	"retrieve" : true,
	"processing" : true,

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

});  */

/*=============================================
CARGAR DATOS DE ASEGURADO AL MODAL AL FORMULARIO DE BAJA COVID RESULTADOS 
=============================================*/

$(document).on("click", ".btnMostrarFormBaja", function() {
	
	var ruta = window.location.href;
	var bajaSospechoso  = "ficha-epidemiologica";
	let posBajaSospechoso = ruta.indexOf(bajaSospechoso);

	var datos = new FormData();
	var codAfiliado =  $(this).data("code");
	datos.append("mostrarFormBaja", 'mostrarFormBaja');
	datos.append("codAfiliado", codAfiliado);

	if (posBajaSospechoso !== -1){ //Es una baja sospechoso
		var id_ficha = $(this).attr("idFicha");
		datos.append("id_ficha", id_ficha);
		$("#idFichaFormBaja").val(id_ficha);
	}
	else{	
		var idCovidResultado = $(this).attr("idCovidResultado");
		datos.append("idCovidResultado", idCovidResultado);
	}
	$.ajax({
		url: "ajax/formulario_bajas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {
			    //console.log(respuesta);
				if (posBajaSospechoso !== -1){
					//var idFicha = $(this).attr("idFicha");
					$("#idFichaFormBaja").val(id_ficha);
					//alert("se cargo ficha: " + $("#idFichaFormBaja").val());
				}else  $("#idCovidResultadoFormBaja").val(respuesta["id"]);
			   
				//Se comento esto para habilitar estos campos
				/* $("#paternoFormBaja").html(respuesta["paterno"]);
				$("#maternoFormBaja").html(respuesta["materno"]);
				$("#nombreFormBaja").html(respuesta["nombre"]);
				$("#codAseguradoFormBaja").html(respuesta["cod_asegurado"]); */

				//Colocamos la fecha de la ultima baja emitida si no es una baja de sospecha
				if (posBajaSospechoso === -1){
					$('#fechaIniFormBaja').val(respuesta["fecha_fin"]);
					$('#fechaIniFormBaja').attr('min',respuesta["fecha_fin"]);
				}

				$("#paternoFormBaja").val(respuesta["paterno"]);
				$("#maternoFormBaja").val(respuesta["materno"]);
				$("#nombreFormBaja").val(respuesta["nombre"]);
				$("#codAseguradoFormBaja").val(respuesta["cod_asegurado"]);

				$("#codAsegurado").val(respuesta["cod_asegurado"]);
				$("#nombreEmpleadorFormBaja").val(respuesta["nombre_empleador"]);
				$("#codEmpleadorFormBaja").val(respuesta["cod_empleador"]);
				if( (respuesta["cod_empleador"]=="0" || respuesta["nombre_empleador"].toUpperCase=="SIN EMPLEADOR") ||
				    (respuesta["cod_empleador"]=="" || respuesta["nombre_empleador"]=="") ){
					$("#nombreEmpleadorFormBaja").removeAttr('readonly');
					$("#codEmpleadorFormBaja").removeAttr('readonly');			
				}
				else{
					//comentamos estas dos lineas por que quieren editar el nombre y codigo empleador
					/* $("#nombreEmpleadorFormBaja").attr('readonly',true);  
					$("#codEmpleadorFormBaja").attr('readonly',true); */

					//Se aumentaron estas dos lineas por que quieren editar el nombre y codigo empleador
					$("#nombreEmpleadorFormBaja").removeAttr('readonly');
					$("#codEmpleadorFormBaja").removeAttr('readonly');	

					$("#nombreEmpleadorFormBaja").val(respuesta["nombre_empleador"]);
					$("#codEmpleadorFormBaja").val(respuesta["cod_empleador"]);
				}
				$("#observacionesBaja").val(respuesta["observacion_baja"]);
				$('#claveFormBaja').val(codAfiliado); 
		},
		error: function(error){

		  console.log("error", error);
			
		}

	});


});

/*=============================================
BORRAR DATOS AL PRESIONAR EL BOTON CERRAR DEL FORMULARIO DE BAJA
=============================================*/

$(document).on("click", ".btnCerrarFormBaja", function() {

	//$("#fechaIniFormBaja").val("");
	$("#fechaFinFormBaja").val("");
	$("#diasIncapacidadFormBaja").val("0 DÌAS");
	//$("#lugarFormBaja").val("");
	//$("#fechaFormBaja").val("");
	$("#claveFormBaja").val("");
	$("#observacionesBaja").val("");

});

/*=============================================
AGREGAR DATOS AL FORMULARIO DE BAJA
=============================================*/

$(document).on("click", ".btnAgregarFormBaja", function() {

	var fechaIni = $("#fechaIniFormBaja").val();
	var fechaFin = $("#fechaFinFormBaja").val();

	var nombreEmpleador = $("#nombreEmpleadorFormBaja").val();
	var codEmpleador =  $("#codEmpleadorFormBaja").val();
	var establecimiento = $("#establFormNuevaBaja").val();

	var diasImpedimento = restaFechas(fechaIni,fechaFin)+1;

	if(verificarForm(fechaFin,diasImpedimento,codEmpleador,nombreEmpleador,establecimiento)){
		var observacionesBaja = $("#observacionesBaja").val();	
		if(diasImpedimento > 7){
			if(observacionesBaja != '' && observacionesBaja.length > 6){
				//alert(observacionesBaja.length);
				guardarBaja(false);
			}
			else{
				$("#observacionesBaja").css('border', '2px solid red')
				Swal.fire({
					title: 'Ups',
					text: "¡Ingresar una observacion por que los dias de Incapacidad es mayor a 7!",
					icon: 'warning',
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Ingresar Observacion'
				  });
			}
		}
		else{
			var ruta = window.location.href;
			var bajaSospechoso  = "ficha-epidemiologica";
			let posBajaSospechoso = ruta.indexOf(bajaSospechoso);
			if (posBajaSospechoso !== -1){ //Es una baja por Sospechoso
				guardarBaja(true);
			}
			else{
				guardarBaja(false);
			}  
		}
	}
	else{		
		/* $("#nombre_empleador").css('border', '2px solid red');
		$("#cod_empleador").css('border', '2px solid red');
		$("#fechaFinFormBaja").css('border', '2px solid red');	 */		
		Swal.fire({
			title: 'Ups',
			text: "¡Revise los datos marcados en Rojo!",
			icon: 'warning',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Revisar'
		  });
	}
});

function verificarForm(fechaFin, diasImpedimento, codEmpleador, nombreEmpleador,establecimiento){
	//alert(nombreEmpleador);
	resFechaFin = false;
	resDiasImpedimento = false;
	resCodEmpleador = false;
	resNombreEmpleador = false;
	resEstablecimiento = false;

	if(fechaFin != ''){
		resFechaFin = true;
		$("#fechaFinFormBaja").css('border', 'initial');	
	} else $("#fechaFinFormBaja").css('border', '2px solid red');

	if(diasImpedimento > 0){
		resDiasImpedimento = true;
	}

	if(codEmpleador != '0' && codEmpleador != '' && codEmpleador != null && codEmpleador != undefined){
		resCodEmpleador = true;
		$("#codEmpleadorFormBaja").css('border', 'initial');	
	} else{
		$("#codEmpleadorFormBaja").css('border', '2px solid red');
		$("#codEmpleadorFormBaja").removeAttr('readonly');
	} 

	if( nombreEmpleador.toUpperCase()  != "SIN EMPLEADOR" && nombreEmpleador.toUpperCase()  != "" && nombreEmpleador.toUpperCase() != null && nombreEmpleador.toLowerCase() != undefined){
		resNombreEmpleador = true;
		$("#nombreEmpleadorFormBaja").css('border', 'initial');
	} else{
		$("#nombreEmpleadorFormBaja").css('border', '2px solid red');
		$("#nombreEmpleadorFormBaja").removeAttr('readonly');
	} 

	if(establecimiento != ''){
		resEstablecimiento = true;
		$("#establFormNuevaBaja").css('border', '1px solid #ced4da');
	}
	else{
		$("#establFormNuevaBaja").css('border', '2px solid red');
	}

	return resFechaFin && resDiasImpedimento && resCodEmpleador && resNombreEmpleador && resEstablecimiento;
}

function guardarBaja(sospechoso){

	var fechaIni = $("#fechaIniFormBaja").val();
	var fechaFin = $("#fechaFinFormBaja").val();
	var observacionesBaja = $("#observacionesBaja").val();
	//var idCovidResultado = $("#idCovidResultadoFormBaja").val();
	var riesgo = $("input:radio[name=riesgoFormBaja]:checked").val(); 
	var diasIncapacidad = $("#diasIncapacidadFormBaja").val();
	var lugar = $("#lugarFormBaja").val();
	var fecha = $("#fechaFormBaja").val();
	var clave = $("#claveFormBaja").val();
	//var codAsegurado = $("#codAsegurado").val();
	var nombre_empleador = $("#nombreEmpleadorFormBaja").val();
	var cod_empleador = $("#codEmpleadorFormBaja").val();

	var establecimiento = $("#establFormNuevaBaja").val();
	var paterno = $("#paternoFormBaja").val();
	var materno = $("#maternoFormBaja").val();
	var nombre  = $("#nombreFormBaja").val();
	var codAsegurado = $("#codAseguradoFormBaja").val();

	var datos = new FormData();
	datos.append("agregarFormBaja", 'agregarFormBaja');
	//datos.append("idCovidResultado", idCovidResultado);
	datos.append("riesgo", riesgo);
	datos.append("fechaIni", fechaIni);
	datos.append("fechaFin", fechaFin);
	datos.append("diasIncapacidad", diasIncapacidad);
	datos.append("lugar", lugar);
	datos.append("fecha", fecha);
	datos.append("clave", clave);
	//datos.append("codAsegurado", codAsegurado);
	datos.append("nombreEmpleador", nombre_empleador);
	datos.append("codEmpleador", cod_empleador);

	datos.append("establecimiento", establecimiento);
	datos.append("paterno", paterno);
	datos.append("materno", materno);
	datos.append("nombre", nombre);
	datos.append("codAsegurado", codAsegurado);

	if(restaFechas(fechaIni,fechaFin) > 7 || sospechoso)
	   datos.append("observacionesBaja", observacionesBaja);
	else{
		//datos.append("observacionesBaja", '');
		datos.append("observacionesBaja", observacionesBaja);
	}    

	new Response(datos).text().then(console.log)

	if(sospechoso){
		var idficha = $("#idFichaFormBaja").val();
		datos.append("idFicha", idficha);
	}
	else{
		var idCovidResultado = $("#idCovidResultadoFormBaja").val();
		datos.append("idCovidResultado", idCovidResultado);
	}

	$.ajax({
		url: "ajax/formulario_bajas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "html",
		success: function(respuesta) {

			if (respuesta == "ok") {

				swal.fire({
					
					icon: "success",
					title: "¡El Certificado de Incapacidad ha sido guardado correctamente!",
					showConfirmButton: true,
					allowOutsideClick: false,
					confirmButtonText: "Cerrar",
					closeOnConfirm: false

				}).then((result) => {
  					
  					if (result.value) {

						window.location = "formulario-bajas";

					}

				});

			} else {

				swal.fire({
						
					icon: "error",
					title: "¡Ocurrio un error en el servidor!",
					showConfirmButton: true,
					allowOutsideClick: false,
					confirmButtonText: "Reportar",
					closeOnConfirm: false

				});
				
			}

		},
	    error: function(error){

	      console.log("error", error);
	        
	    }

	});
}


/*=================================================
		CARGAR EL MODAL DE NUEVO FORMULARIO BAJAS @DANPINCH
==================================================*/

$(document).on("click", "#btnNuevoFormularioBaja", function() {
	$("#modalCodAseguradoFormularioBaja").modal('show');
});


/*=============================================
OBTENER LOS DIAS DE INCAPACIDAD PARA EDITAR FECHA @DANPINCH
=============================================*/
$("#fechaIniFormEditarBaja").change(function(){
	//console.log($(".fechaIniFormEditarBaja").val());
});
$("#fechaFinFormEditarBaja").change(function(){
	var fechaInicio = $("#fechaIniFormEditarBaja").val();
	var fechaFin = $("#fechaFinFormEditarBaja").val();
	var diasImpedimento = restaFechas(fechaInicio,fechaFin);
	var divObservaciones = document.getElementById("divObservaciones");
	console.log(diasImpedimento);
	if(diasImpedimento > 7 ){
		divObservaciones.style.display="block";		
		$("#diasIncapacidadFormEditarBaja").val(diasImpedimento+' DÍAS');
	}else{
		$("#diasIncapacidadFormEditarBaja").val(diasImpedimento+' DÍAS');
		divObservaciones.style.display="none";
		$('#divObservaciones').text("");
	}

});
/*=============================================
OBTENER LOS DIAS DE INCAPACIDAD @DANPINCH
=============================================*/

$("#fechaIniFormBaja").change(function() {
	var fecha1 = $("#fechaIniFormBaja").val();
	var fecha2 = $("#fechaFinFormBaja").val();
	var diasImpedimento = restaFechas(fecha1,fecha2)+1;
	if(diasImpedimento > 0){
		$('button[type="submit"]').removeAttr('disabled');
		var divObservaciones=$("#observacionesBaja");
		$('#fechaIniFormBaja').css('border', '1px solid #ced4da');
		if(diasImpedimento>7){
			divObservaciones.removeAttr("readonly");
			$("#diasIncapacidadFormBaja").val(diasImpedimento+" DÍAS");
		}else{
			$("#diasIncapacidadFormBaja").val(diasImpedimento+" DÍAS");
			divObservaciones.attr("readonly","readonly");
			divObservaciones.css('border', '1px solid #ced4da')
			$('#observacionesBaja').val("");
		}	
	}
	else{
		$('button[type="submit"]').attr('disabled','disabled');
		$('#fechaIniFormBaja').css('border', '1px solid red');

		Swal.fire({
			title: 'Ups',
			text: "¡La fecha debe ser DESTE no puede ser mayor a la fecha HASTA",
			icon: 'warning',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Modificar Fecha'
		  });
	}

});

$("#fechaFinFormBaja").change(function() {
	var fecha1 = $("#fechaIniFormBaja").val();
	var fecha2 = $("#fechaFinFormBaja").val();
	var diasImpedimento = restaFechas(fecha1,fecha2)+1;
	if(diasImpedimento > 0){
		$('button[type="submit"]').removeAttr('disabled');
		var divObservaciones=$("#observacionesBaja");
		$('#fechaFinFormBaja').css('border', '1px solid #ced4da');
		if(diasImpedimento>7){
			divObservaciones.removeAttr("readonly");
			$("#diasIncapacidadFormBaja").val(diasImpedimento+" DÍAS");
		}else{
			var ruta = window.location.href;
			var bajaSospechoso  = "ficha-epidemiologica";
			let posBajaSospechoso = ruta.indexOf(bajaSospechoso);
			if (posBajaSospechoso !== -1){ //Esta creando una baja por Sospechoso
				$("#diasIncapacidadFormBaja").val(diasImpedimento+" DÍAS");
				divObservaciones.removeAttr("readonly");
				divObservaciones.val("BAJA POR SOSPECHA COVID-19");
			}
			else {
				var ruta = window.location.href;
				var editarBajaSospechoso  = "esSospechoso=SOSPECHOSO";
				let posEditBajaSospechoso = ruta.indexOf(editarBajaSospechoso);
				if(posEditBajaSospechoso !== -1){ //Esta editando una baja Sospechoso
					$("#diasIncapacidadFormBaja").val(diasImpedimento+" DÍAS");
					divObservaciones.removeAttr("readonly");
				}
				else { //Esta creando una baja Manual o por el flujo normal
					$("#diasIncapacidadFormBaja").val(diasImpedimento+" DÍAS");
					//divObservaciones.attr("readonly","readonly"); //quitamos este campo a requerimiento
					divObservaciones.removeAttr("readonly");  //habilitamos el campo
					divObservaciones.css('border', '1px solid #ced4da')
					//$('#observacionesBaja').val("");
				}
			} 
		}	
	}
	else{
		$('button[type="submit"]').attr('disabled','disabled');
		$('#fechaFinFormBaja').css('border', '1px solid red');
		Swal.fire({
			title: 'Ups',
			text: "¡La fecha debe ser mayor a la fecha DESDE!",
			icon: 'warning',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Modificar Fecha'
		  });
	}

});



// Función para calcular los días transcurridos entre dos fechas
restaFechas = function(f1, f2) {
 var aFecha1 = f1.split('-');
 var aFecha2 = f2.split('-');
 var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
 var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24));

 return dias;

}

/*=============================================
BOTÓN EDITAR FORMULARIO BAJA
=============================================*/

$("#tablaFormularioBajas tbody").on("click", "button.btnEditarFormularioBaja", function() {

	var idFormularioBaja = $(this).attr("idFormularioBaja");
	var esSospechoso = $(this).attr("esSospechoso");
	//console.log("idFormularioBaja", idFormularioBaja);
	if(esSospechoso == 'SOSPECHOSO')
		window.location = "index.php?ruta=editar-formulario-bajas&idFormularioBaja="+idFormularioBaja+"&esSospechoso="+esSospechoso;
	else window.location = "index.php?ruta=editar-formulario-bajas&idFormularioBaja="+idFormularioBaja;

});


/*=============================================
SUBIENDO LA IMAGEN DEL FORMULARIO 
=============================================*/
$(".imagenFormBaja").change(function() {
 	
 	var imagen = this.files[0];

 	/*=============================================
	SUBIENDO LA FOTO DEL AFILIADO
	=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

		$(".imagenFormBaja").val("");

		swal.fire({
			
			title: "Error al subir la imagen",
			text: "La imagen debe estar en formato JPG o PNG",
			icon: "error",
			allowOutsideClick: false,
			confirmButtonText: "¡Cerrar!"

		});

	} else if(imagen["size"] > 2000000) {

		$(".imagenFormBaja").val("");

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
IMPRIMIR FORMULARIO BAJA
=============================================*/

$("#tablaFormularioBajas").on("click", ".btnImprimirFormularioBaja", function() {

	var idFormularioBaja = $(this).attr("idFormularioBaja");
	var code = $(this).data("code");
	var idFicha = $(this).data("idficha");

	var nombre_usuario = $("#nombreUsuarioOculto").val();
	
	var datos = new FormData();

	datos.append("imprimirFormBaja", "imprimirFormBaja");
	datos.append("idFormularioBaja", idFormularioBaja);
	datos.append("nombre_usuario", nombre_usuario);

	$.ajax({

		url: "ajax/formulario_bajas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	

			PDFObject.embed("temp/"+code+"/formularioIncapacidad-"+idFicha+".pdf", "#view_pdf");

		}

	});

});

/*=============================================
ELIMINAR FORMULARIO BAJA
=============================================*/

$(document).on("click", "button.btnEliminarFormularioBaja", function() {
	
	var idFormularioBaja = $(this).attr("idFormularioBaja");
	// var codAfiliado = $(this).attr("codAfiliado");
	var imagen = $(this).attr("imagen");

	swal.fire({

		title: "¿Está seguro de borrar el formulario?",
		text: "¡Si no lo está puede cancelar la acción!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "¡Si, borrar formulario!"

	}).then((result)=> {

		if (result.value) {

			window.location = "index.php?ruta=formulario-bajas&idFormularioBaja="+idFormularioBaja+"&imagen="+imagen;

		}

	});		
});

/*============================================================
	REGISTRAR NUEVO FORMULARIO DE BAJAS
 =============================================================*/

 $("#fechaIniFormNuevaBaja").change(function(){	 
 });

 $("#fechaFinFormNuevaBaja").change(function(){
	var fechaFin = $(this).val();
	var fechaInicio = $("#fechaIniFormNuevaBaja").val();
	var diasImpedimento=restaFechas(fechaInicio,fechaFin);
	var divObservaciones=$("#observacionesBaja");
	console.log(diasImpedimento);
	if(diasImpedimento>7){
		divObservaciones.removeAttr("readonly");
		$("#diasIncapacidadFormNuevaBaja").val(diasImpedimento+' DÍAS');
	}else{
		$("#diasIncapacidadFormNuevaBaja").val(diasImpedimento+' DÍAS');
		divObservaciones.attr("readonly","readonly");
		$('#observacionesBaja').val("");
	}
});




/*============================================================
	VALIDANDO DATOS DEL FORMULARIO BAJAS
==============================================================*/

$("#formAgregarFormBaja").validate({
	rules:{
		observacionesBaja : { required: true},
	},
	messages:{
		observacionesBaja : "La Fecha de Baja es mayor a 7 dias agrege una observacion!!",
	},
	errorPlacement: function(label, element) {

		if (element.attr("name") == "enfEstado" ) {
		 
		 label.addClass('errorMsq');
			element.parent().parent().append(label);

	 } else {

		 label.addClass('errorMsq');
		 element.parent().append(label);

	 }

 },
});

$("#nombreEmpleadorFormBaja").change(function(){
	var nombreEmpleador = $("#nombreEmpleadorFormBaja").val();
	if(nombreEmpleador != "SIN EMPLEADOR" && nombreEmpleador != ""){
		$("#nombreEmpleadorFormBaja").css('border', 'initial');
	}
	else{
		$("#nombreEmpleadorFormBaja").css('border', '2px solid red');
	}
});

$("#codEmpleadorFormBaja").change(function(){
    var codEmpleador =  $("#codEmpleadorFormBaja").val();
	if(codEmpleador != '0' && codEmpleador != ''){
		$("#codEmpleadorFormBaja").css('border', 'initial');
	}
	else{
		$("#codEmpleadorFormBaja").css('border', '2px solid red');
	}
});
