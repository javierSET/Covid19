/**
 * @author Daniel Villegas Veliz
 * @version 1.0
 * @description 
 */

/*=============================================
	CARGAR LA TABLA DINÁMICA DE COVID RESULTADOS @dan
=============================================*/
// variables globales
var perfilOculto = $("#txtHideRol").val()
var laboratorio = $("#txtHideLaboratorio").val()
var fechaMuestra = $("#fechaMuestra").val()

var tableCovidResultado = $('#tablaCovidResultadosLaboratorio').DataTable({

		"order": [[ 0, "desc" ]],
		"language": {
			"emptyTable":		"No hay datos disponibles en la tabla.",
			"sProcessing":     	"Procesando...",		
			"sLengthMenu":     	"Mostrar _MENU_ registros",
			"sZeroRecords":    	"No se encontraron resultados",
			"sEmptyTable":     	"Ningún dato disponible en esta tabla",
			"sInfo":           	"Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      	"Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   	"(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    	"",
			"sSearch":         	"Buscar:",
			"searchPlaceholder":"Escribe aquí para buscar...",
			"sUrl":            	"",
			"sInfoThousands":  	",",
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

		"ajax": {
			url: "ajax/datatable-covid_resultados_laboratorios.ajax.php",
			data: { 'perfilOculto' : perfilOculto, 'laboratorio' : laboratorio },
			type: "post"
		},	
		"processing": true,
		"serverSide": true,
		"orderCellsTop": true,
		"responsive": true,
		//"lengthMenu": [[10,50, 100, 500000], [10, 50, 100, "Todo"]],
		//"iDisplayLength":100,
		"bJQueryUI":  false,
		"pageLength": 10,
		"lengthChange": false,
		"bFilter": true,		
		"columnDefs": [
			{
				"targets": [2,4,5,9,10,13,14,15,16,17,18,19,20,21,22], // estes posiciones no se muestran
				"visible": false,
			},
			
		],    

		"rowCallback": function(row, data, index) {		
			var resultado =  data[11].indexOf("EN ESPERA...");
			if ( data[24] == 0 && resultado === -1) { //Publicado o no
			$('td', row).addClass('bg-faltaPublicar');
			$('tr.child', row).addClass('bg-faltaPublicar');
			}
			if ( data[24] == 0 && resultado !== -1) { //No tiene resultado
				$('td', row).addClass('bg-lightblue color-palette');
				$('tr.child', row).addClass('bg-lightblue color-palette');
			}
		},

		/* "dom":'Blfrtip',
		"buttons": [
			{
				extend:    'excelHtml5',
				title: 	   'Reporte ',
				text:      '<i class="fas fa-file-excel"></i> Generar EXCEL',
				titleAttr: 'Exportar a Excel',
				className: 'btn btn-success m-1',
				exportOptions: {
					//columns: [1, 2, 3, 5, 8, 10, 11, 12, 13, 14], 
					modifier: {
						search: 'applied',
						order: 'applied'
					}
				}
				
			},
			{
				extend:    'pdf',
				title: 	   'Reporte ',
				text:      '<i class="fas fa-file-pdf"></i> Generar PDF',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-warning m-1',
				exportOptions: {
					columns: [3, 10,18,19,21]// muestra solo esas columnas
				}
				
			}		
		] */		
});

/*=============================================
BOTON QUE GENERA LOS RESULTADOS COVID POR FILTRADO DE FECHA
=============================================*/
$(document).on("click","#btnBuscarEstableFecha", function(){
	var establecimiento = $('#cbEstablecimientos').val().trim()
	var fechaMuestra = $('#fechaMuestra').val().trim()
	var accion = "busquedaEstablecimientoFechaMuestra"
	buscarCovidResultadoLaboratorioEstatablecimientoFechaMuestra(accion,establecimiento,fechaMuestra)
});


/*********************************************
 *  boton para habilitar edicion @dan
 *********************************************/
$(document).on("click",".btnHabilitarEdicion",function(){
	var id_ficha=$(this).attr('idFicha')	
	var accion = "restablecerCovidResultado"
	swal.fire({
		title: 'Realmente quiere Editar?',
		text: "Uds puede editar Tipo Diagnostico y Resultado!",
		icon: 'warning',
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Habilitar!'
	  }).then((result) => {
		if (result.value) {
			restablecerDatosCovidResultado(accion,id_ficha)
			$('#selectDiagnostico'+id_ficha).val("")
			$('#selectDiagnostico'+id_ficha).removeAttr('disabled')
			$('#selectResultado'+id_ficha).removeAttr('disabled')
			$('#selectResultado'+id_ficha).val("") 
		}
	  })	
})

/*  */
/**************************************************
 *  cambiar los datos en la BD covid_resultado
 **************************************************/
$(document).on("change",".tipoDiagnostico",function(){
	var tipoDiagnostico = $(this).val()
	var id_ficha = $(this).attr("idFicha")
	var accion = "guardarCampoTipoDiagnostico"	
	if(tipoDiagnostico!=""){
		actualizarCamposCovidResultadoTipoDiagnostico(accion,id_ficha,tipoDiagnostico)
	}
})

/**************************************************
 * cambiar los datos en la BD covid_resultado
 **************************************************/
$(document).on("change",".cambioCovidResultado",function(){
	var resultado = $(this).val()
	var responsable = $("#nombreUsuarioOculto").val()
	var id_ficha = $(this).attr("idFicha")	
	var accion = "guardarCamposResultadoEstadoResponsable"
	if(resultado != ""){
		actualizarCamposCovidResultadoEstadoResponsable(accion,id_ficha,resultado,responsable)			
	}
		
})

/*=======================================================
	Funcion para modificar los campos resultado, responsanble, estado de la tabla covid resultado @dan
=========================================================*/
function actualizarCamposCovidResultadoEstadoResponsable(accion,id_ficha,resultado,responsable){
	var datos = new FormData()
	datos.append(accion,accion)
	datos.append("id_ficha",id_ficha)
	datos.append("resultado",resultado)
	datos.append("reponsable",responsable)
	$.ajax({
		url: "ajax/covid_resultados.ajax.php",
		method: "POST",
		cache: false,
		data: datos,
		contentType: false,
		processData: false,
		dataType: "html",
		success: function(respuesta){
			$('#selectResultado'+id_ficha).attr('disabled','disabled')
			toastr.success('Se modifico correctamente!!!')
		},
		error: function(error){
			toastr.warning('¡Error! Falla en la conexion a la BD, no se modifico')
		}
	})

}
/***************************************************
 *  agregar tipo diagnostico en la tabla covid_resultados @dan
 ***************************************************/
function actualizarCamposCovidResultadoTipoDiagnostico(accion,id_ficha,tipoDiagnostico){	
	var datos = new FormData()
	datos.append(accion,accion)
	datos.append("id_ficha", id_ficha)
	datos.append("tipoDiagnostico",tipoDiagnostico)
	$.ajax({
		url:"ajax/covid_resultados.ajax.php",
		method: "POST",
		cache: false,
		data: datos,
		contentType: false,
		processData: false,
		dataType:"html",
		success: function(respuesta){
			$('#selectDiagnostico'+id_ficha).attr('disabled','disabled')
			toastr.success('Se agrego correctamente')
		},
		error: function(error){			
			toastr.warning('¡Error! Falla en la conexion a la BD, no se modifico')
		}
	});	
}
/*=====================================================
	Funcion para restablecer los valores de la tabla covid resultado
 ======================================================*/
function restablecerDatosCovidResultado(accion,id_ficha){
	var datos = new FormData()
	datos.append(accion,accion)
	datos.append("id_ficha",id_ficha)
	$.ajax({
		url: "ajax/covid_resultados.ajax.php",
		method: "POST",
		cache: false,
		data: datos,
		contentType: false,
		processData: false,
		dataType: "html",
		success: function(respuesta){			
			//toastr.success('Se modifico correctamente!!!')
		},
		error: function(error){
			toastr.warning('¡Error! Falla en la conexion a la BD, no se modifico')
		}
	})
}
/*=============================================================
	FUNCION PARA BUSCAR A TODOS LOS PACIENTES QUE NO TIENEN RESULTADO HO2 @dan
  =============================================================*/
function buscarCovidResultadoLaboratorioEstatablecimientoFechaMuestra(accion,establecimiento,fechaMuestra){
	var perfilOculto = $("#txtHideRol").val()

	$('#tablaCovidResultadosLaboratorio').remove()
	$('#tablaCovidResultadosLaboratorio_wrapper').remove()
	$('#resultadosCovidLaboratorio').append('<table class="table table-bordered table-striped dt-responsive table-hover" id="tablaCovidResultadosLaboratorio" width="100%">'+
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
                      '<th>METODO DE DIAGNOSTICO</th>'+
                      '<th>MUESTRA DE CONTROL</th>'+
                      '<th>DEPARTAMENTO</th>'+
                      '<th>RESULTADO</th>'+
                      '<th>ESTABLECIMIENTO</th>'+
                      '<th>SEXO</th>'+
                      '<th>FECHA NACIMIENTO</th>'+
                      '<th>TELÉFONO</th>'+
                      '<th>EMAIL</th>'+
                      '<th>LOCALIDAD</th>'+
                      '<th>ZONA</th>'+
                      '<th>DIRECCION</th>'+
                      '<th>FECHA RESULTADO</th>'+
                      '<th>OBSERVACIONES</th>'+
                      '<th>MEDICO</th>'+
                      '<th>ACCIONES</th>'+
                    '</tr>'+
                  '</thead>'+
				  '</table>')

	$('#tablaCovidResultadosLaboratorio').DataTable({
		"order": [[ 0, "desc" ]],
		"language": {
			"emptyTable":		"No hay datos disponibles en la tabla.",
			"sProcessing":     	"Procesando...",		
			"sLengthMenu":     	"Mostrar _MENU_ registros",
			"sZeroRecords":    	"No se encontraron resultados",
			"sEmptyTable":     	"Ningún dato disponible en esta tabla",
			"sInfo":           	"Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      	"Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   	"(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    	"",
			"sSearch":         	"Buscar:",
			"searchPlaceholder":"Escribe aquí para buscar...",
			"sUrl":            	"",
			"sInfoThousands":  	",",
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

		"ajax": {
			url: "ajax/datatable-covid_resultados_laboratorios.ajax.php",
			data: {'accion': accion,'perfilOculto' : perfilOculto,'establecimiento': establecimiento, 'fechaMuestra': fechaMuestra},
			type: "POST"
		},	
		"processing": true,
		"serverSide": true,
		"orderCellsTop": true,
		"responsive": true,
		//"lengthMenu": [[10,50, 100, 500000], [10, 50, 100, "Todo"]],
		"iDisplayLength":10,
		"bJQueryUI":  false,
		"pageLength": 10,
		"lengthChange": false,
		"bFilter": true,		
		"columnDefs": [
			{
				"targets": [2,4,5,9,10,13,14,15,16,17,18,19,20,21,22], // estes posiciones no se muestran
				"visible": false,
			},
			
		],
		"rowCallback": function(row, data, index) {		
			var resultado =  data[11].indexOf("EN ESPERA...");
			if ( data[24] == 0 && resultado === -1) { //Publicado o no
			$('td', row).addClass('bg-faltaPublicar');
			$('tr.child', row).addClass('bg-faltaPublicar');
			}
			if ( data[24] == 0 && resultado !== -1) { //No tiene resultado
				$('td', row).addClass('bg-lightblue color-palette');
				$('tr.child', row).addClass('bg-lightblue color-palette');
			}
		},		
	})

}