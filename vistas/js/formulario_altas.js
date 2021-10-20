/*=============================================
CARGAR LA TABLA DINÁMICA DE FORMULARIOS DE BAJA
=============================================*/

var perfilOculto = $("#perfilOculto").val();

var tableBajas = $('#tablaCertificadosAtaManual').DataTable({
	
	"ajax": "ajax/datatable-formulario_altas_manuales.ajax.php?perfilOculto="+perfilOculto,

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

});

// actualiza el contenido de la DataTable automaticamente cada
setInterval( function () {
    tableBajas.ajax.reload( null, false );
}, 30000 );

/*=============================================
	IMPRIMIR FORMAULARIO DE ALTA MANUAL
=============================================*/
$(document).on("click",".btnImprimirFormularioAltaManual",function(){

	var idAltamanual = $(this).attr("idformularioaltamanual")
	var idPacienteAsegurado = $(this).attr("idPacienteAsegurado")
	var nombreAsegurado = $(this).attr("nombreAsegurado")
	var apellidoPaterno = $(this).attr("apellidoPaterno")
	var apellidoMaterno = $(this).attr("apellidoMaterno")
	var nro_documento = $(this).attr("ciAsegurado")
	var calle = $(this).attr("calle")
	var zona = $(this).attr("zona")	
	var nro_calle = $(this).attr("nro_calle")
	var codEmpleador = $(this).attr("codEmpleador")
	var nombreEmpleador = $(this).attr("nombreEmpleador")
	var codAfiliado = $(this).attr("codAfiliado")
	var matriculaAsegurado = $(this).attr("matriculaAsegurado")
	var tipoMuestra = $(this).attr("tipoMuestra");
	var fecha_resultado = $(this).attr("fecha_resultado")
	var resultado = $(this).attr("resultado")
	var establecimiento_laboratorio = $(this).attr("establecimiento_resultado")
	var dias_baja = $(this).attr("dias")
	var fecha_ini = $(this).attr("fecha_ini")
	var fecha_fin = $(this).attr("fecha_fin")
	var establecimiento_notificador = $(this).attr("establecimiento_notificador")

	var datos = new FormData()
	datos.append("imprimirCertificadoAltaManual","imprimirCertificadoAltaManual")
	datos.append("idAltamanual",idAltamanual)
	datos.append("idPacienteAsegurado",idPacienteAsegurado)
	datos.append("nombre_Asegurado",nombreAsegurado)
	datos.append("apellido_Paterno",apellidoPaterno)
	datos.append("apellido_Materno",apellidoMaterno)
	datos.append("nro_documento",nro_documento)
	datos.append("idafiliado",codAfiliado)
	datos.append("calle",calle)
	datos.append("zona",zona)
	datos.append("nro_calle",nro_calle)
	datos.append("codEmpleador",codEmpleador)
	datos.append("nombreEmpleador",nombreEmpleador)
	datos.append("matriculaAsegurado",matriculaAsegurado)
	datos.append("tipo_Muestra",tipoMuestra)
	datos.append("resultado",resultado)
	datos.append("fecha_resultado",fecha_resultado)
	datos.append("establecimiento_laboratorio",establecimiento_laboratorio)
	datos.append("dias_baja",dias_baja)
	datos.append("fecha_ini",fecha_ini)
	datos.append("fecha_fin",fecha_fin)
	datos.append("establecimiento_notificador",establecimiento_notificador)
	
	$.ajax({
		url: "ajax/informacion_paciente.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: '',
		success: function(respuesta){
			$('#alta_manual-pdf').modal({
				show:true,
				backdrop:'static'
			});
			PDFObject.embed("temp/"+codAfiliado+"/certificado-alta-descartado-"+codAfiliado+".pdf", "#mostrar_pdf");
		}		
	});
		
		
});

/*=============================================
	EDITAR FORMAULARIO DE ALTA MANUAL
=============================================*/
$(document).on("click",".btnEditarFormularioAltaManual",function(){
	var idAltamanual = $(this).attr("idformularioaltamanual")
	var idPacienteAsegurado = $(this).attr("idPacienteAsegurado")
	var nombreAsegurado = $(this).attr("nombreAsegurado")
	var apellidoPaterno = $(this).attr("apellidoPaterno")
	var apellidoMaterno = $(this).attr("apellidoMaterno")
	var nro_documento = $(this).attr("ciAsegurado")
	var calle = $(this).attr("calle")
	var zona = $(this).attr("zona")	
	var nro_calle = $(this).attr("nro_calle")
	var codempleador = $(this).attr("codEmpleador")
	var nombreEmpleador = $(this).attr("nombreEmpleador")
	var tipoMuestra = $(this).attr("tipoMuestra");
	var fecha_resultado = $(this).attr("fecha_resultado")
	var establecimiento_laboratorio = $(this).attr("establecimiento_resultado")
	var dias_baja = $(this).attr("dias")
	var fecha_ini = $(this).attr("fecha_ini")
	var fecha_fin = $(this).attr("fecha_fin")
	var establecimiento_notificador = $(this).attr("establecimiento_notificador")

	$("#idAltaManual").val(idAltamanual)
	$("#idPacienteAsegurado").val(idPacienteAsegurado)
	$("#txtnombre").val(nombreAsegurado)
	$("#txtapellidopaterno").val(apellidoPaterno)
	$("#txtapellidomaterno").val(apellidoMaterno)
	$("#txtCi").val(nro_documento)
	$("#calle").val(calle)
	$("#zona").val(zona)
	$("#nro").val(nro_calle)
	$("#codEmpleador").val(codempleador)
	$("#nombreempleador").val(nombreEmpleador)
	$("#tipoMuestra").val(tipoMuestra)
	$("#fechaAlta").val(fecha_resultado)
	$("#centros").val(establecimiento_laboratorio)
	$("#diasBaja").val(dias_baja)
	$("#fechaAltaini").val(fecha_ini)
	$("#fechaAltafin").val(fecha_fin) 
	$("#establecimientoNotificador").val(establecimiento_notificador)

	$('#editar_alta_manual').modal({
		show:true,
		backdrop:'static'

	});
	
});

$(document).on("click","#btnGuardarAltManual",function(){
	var idAltamanual = $("#idAltaManual").val()
	var idPacienteAsegurado = $("#idPacienteAsegurado").val()
	var nombreAsegurado = $("#txtnombre").val()
	var apellidoPaterno = $("#txtapellidopaterno").val()
	var apellidoMaterno = $("#txtapellidomaterno").val()
	var nro_documento = $("#txtCi").val()
	var calle = $("#calle").val()
	var zona = $("#zona").val()
	var nro_calle = $("#nro").val()
	var codEmpleador = $("#codEmpleador").val()
	var nombreEmpleador = $("#nombreempleador").val()
	var tipoMuestra = $("#tipoMuestra").val()
	var fecha_resultado = $("#fechaAlta").val()
	var establecimiento_laboratorio = $("#centros").val()
	var dias_baja = $("#diasBaja").val()
	var fecha_ini = $("#fechaAltaini").val()
	var fecha_fin = $("#fechaAltafin").val()
	var establecimiento_notificador = $("#establecimientoNotificador").val()

	console.log("id alta "+idAltamanual)
	console.log("id paciente "+idPacienteAsegurado)
	console.log("nombre "+nombreAsegurado)
	console.log("paterno "+apellidoPaterno)
	console.log("materno "+apellidoMaterno)
	console.log("ci "+nro_documento)
	console.log("calle "+calle)
	console.log("zona "+zona)
	console.log("nro_calle "+nro_calle)
	console.log("cod empleador "+codEmpleador)
	console.log("nombre Empleador "+nombreEmpleador)
	console.log("tipo muestra "+tipoMuestra)
	console.log("fecha resultado "+fecha_resultado)
	console.log("establecimiento laboratorio "+establecimiento_laboratorio)
	console.log("dias baja "+dias_baja)
	console.log("fecha ini "+fecha_ini)
	console.log("fecha fin "+fecha_fin)
	console.log("establecimiento notificador "+establecimiento_notificador)

	
	if(nombreAsegurado != "" && apellidoMaterno != "" && nro_documento != "" && calle != "" && 
	zona != "" && nro_calle != "" && codEmpleador != "" && nombreEmpleador != ""  && 
	tipoMuestra != "" && establecimiento_laboratorio != "" && establecimiento_notificador != 0 && fecha_resultado!="")
	{
		swal.fire({

			title: "¿Está seguro de modificar los datos?",
			text: "¡Si esta seguro de que todos los datos son correctos prosiga!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si estoy Seguro!"
		
		}).then((result)=> {	
			if (result.value) {
				var datos = new FormData()
				datos.append("editarCertificadoAltaManual","editarCertificadoAltaManual")
				datos.append("idAltamanual",idAltamanual)
				datos.append("idPacienteAsegurado",idPacienteAsegurado)
				datos.append("nombre_Asegurado",nombreAsegurado)
				datos.append("apellido_Paterno",apellidoPaterno)
				datos.append("apellido_Materno",apellidoMaterno)
				datos.append("nro_documento",nro_documento)
				datos.append("calle",calle)
				datos.append("zona",zona)
				datos.append("nro_calle",nro_calle)
				datos.append("codEmpleador",codEmpleador)
				datos.append("nombreEmpleador",nombreEmpleador)
				datos.append("tipo_Muestra",tipoMuestra)
				datos.append("fecha_resultado",fecha_resultado)
				datos.append("establecimiento_laboratorio",establecimiento_laboratorio)
				datos.append("dias_baja",dias_baja)
				datos.append("fecha_ini",fecha_ini)
				datos.append("fecha_fin",fecha_fin)
				datos.append("establecimiento_notificador",establecimiento_notificador)
				$.ajax({
					url: "ajax/informacion_paciente.ajax.php",
					type: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: '',
					success: function(respuesta){
						window.location="certificado-alta-manual";
					}		
				});
			}
		})
	}else{
		camposRequeridosEdirar();
		Swal.fire({
			title: 'Ups',
			text: "¡Revise los datos, todos son requeridos",
			icon: 'warning',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Revisar'
		  });
	}

});

function camposRequeridosEdirar(){
	if($('#txtnombre').val() == "")
		$('#txtnombre').css('border-color', 'red')
	else $('#txtnombre').css('border-color', 'initial')

	if($('#txtapellidomaterno').val() == "")			
		$('#txtapellidomaterno').css('border-color', 'red')
	else  $('#txtapellidomaterno').css('border-color', 'initial')

	if($('#txtCi').val() == "")
		$('#txtCi').css('border-color', 'red')
	else  $('#txtCi').css('border-color', 'initial')

	if($('#calle').val() == "")
		$('#calle').css('border-color', 'red');
	else  $('#calle').css('border-color', 'initial')

	if($('#zona').val() == "")		
		$('#zona').css('border-color', 'red')
	else  $('#zona').css('border-color', 'initial')

	if($('#nro').val() == "")		
		$('#nro').css('border-color', 'red');
	else  $('#nro').css('border-color', 'initial')

	if($('#codEmpleador').val() == "")	
		$('#codEmpleador').css('border-color', 'red')
	else  $('#codEmpleador').css('border-color', 'initial')

	if($('#nombreempleador').val() == "" || $('#nombreempleador').val() == "Sin Empleador")
		$('#nombreempleador').css('border-color', 'red')
	else  $('#nombreempleador').css('border-color', 'initial')
	

	if($('#centros').val() == "")	
		$('#centros').css('border-color', 'red')
	else  $('#centros').css('border-color', 'initial')

	if($('#establecimientoNotificador').val() == 0)	
		$('#establecimientoNotificador').css('border-color', 'red')
	else  $('#establecimientoNotificador').css('border-color', 'initial')

}

/*=============================================
	ELIMINAR PACIENTE ASEGURADO Y EL FORMULARIO DE ALTAS MANUALES
=============================================*/
$(document).on("click","button.btnEliminarFormularioAltaManual",function(){

	var idCertificadoAlta = $(this).attr("idFormularioAltaManual");
	var idPacienteAsegurado = $(this).data("code");
	datos = new FormData();	
	datos.append("certificadoAltaManual","certificadoAltaManual");
	datos.append("idCertificadoAlta",idCertificadoAlta);
	datos.append("idPacienteAsegurado",idPacienteAsegurado);

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
				$.ajax({
					url: "ajax/certificado_alta_manual.ajax.php",
					type: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					success: function(respuesta) {
						window.location="certificado-alta-manual";					
					}
				});
			}
		});
});

$(document).on("click","#btnCerrarImpreAlta",function(){
	window.location="certificado-alta-manual";	
})


$(document).on("click","#btnCerrarModal",function(){
	window.location="certificado-alta-manual";	
})