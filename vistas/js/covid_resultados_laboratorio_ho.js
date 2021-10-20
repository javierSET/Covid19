/**
 * @author Daniel Villegas Veliz
 * @version 1.0
 * @description 
 */

/*=============================================
	CARGAR LA TABLA DINÁMICA DE COVID RESULTADOS @dan
=============================================*/
// variables globales
var perfilOculto = $("#txtHideRolHo").val()
var reportes = $("#txtreportesHo").val()
var nombreUsuarioOcultoHo = $('#nombreUsuarioOcultoHo').val()
$('#tablaCovidResultadosLaboratorioHo').DataTable({

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
			data: { 'perfilOculto' : perfilOculto, 'reportes' : reportes, 'nombreUsuarioOculto': nombreUsuarioOcultoHo },
			type: "post"
		},	
		"processing": true,
		"serverSide": true,
		"orderCellsTop": true,
		"responsive": true,
		"lengthMenu": [[10,50, 100, 500000], [10, 50, 100, "Todo"]],
		"iDisplayLength":100,
		"bJQueryUI":  false,
		"pageLength": 10,
		"lengthChange": true,
		"bFilter": true,		
		"columnDefs": [
			{
				"targets": [2,4,5,9,10,13,14,15,16,17,18,19,21,22], // estes posiciones no se muestran
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

		"dom":'Blfrtip',
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
				title: 	   'Reporte',
				text:      '<i class="fas fa-file-pdf"></i> Generar PDF',
				titleAttr: 'Exportar a PDF',
				className: 'btn btn-warning m-1',
				exportOptions: {
					columns: [3,4, 11,12,20,22,23]// muestra solo esas columnas
				}
				
			}		
		]	
});

/*=============================================
BOTON QUE GENERA LOS RESULTADOS COVID POR FILTRADO DE FECHA
=============================================*/
$(document).on("click","#btnBuscarEstableFechaHo", function(){
	var establecimiento = $('#cbEstablecimientosHo').val()
	var fechaResultado = $('#fechaResultadoHo').val()
	var accion = 'reporteEstableciminetoFecha'
	buscarCovidResultadoReporteLaboratorioEstatablecimientoFechaMuestra(accion,establecimiento,fechaResultado)
});


/*=============================================================
	FUNCION PARA BUSCAR A TODOS LOS PACIENTES QUE NO TIENEN RESULTADO HO2 @dan
  =============================================================*/
function buscarCovidResultadoReporteLaboratorioEstatablecimientoFechaMuestra(accion,establecimiento,fechaResultado){
	var perfilOculto = $("#txtHideRolHo").val()
	$('#tablaCovidResultadosLaboratorioHo').remove()
	$('#tablaCovidResultadosLaboratorioHo_wrapper').remove()
	$('#resultadosCovidLaboratorioHo').append('<table class="table table-bordered table-striped dt-responsive table-hover" id="tablaCovidResultadosLaboratorioHo" width="100%">'+
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
                      '<th>RESPONSABLE RESULTADO</th>'+
                    '</tr>'+
                  '</thead>'+
				  '</table>')

	$('#tablaCovidResultadosLaboratorioHo').DataTable({
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
			data: {'reporteEstableciminetoFecha': accion,'perfilOculto' : perfilOculto,'establecimiento': establecimiento, 'fechaResultado': fechaResultado, 'nombreUsuarioOculto':nombreUsuarioOcultoHo},
			type: "POST"
		},	
		"processing": true,
		"serverSide": true,
		"orderCellsTop": true,
		"responsive": true,
		"lengthMenu": [[10,50, 100, 500000], [10, 50, 100, "Todo"]],
		"iDisplayLength":10,
		"bJQueryUI":  false,
		"pageLength": 10,
		"lengthChange": true,
		"bFilter": true,		
		"columnDefs": [
			{
				"targets": [2,4,5,9,10,13,14,15,16,17,18,19,21,22], // estes posiciones no se muestran
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
		"dom":'Blfrtip',
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
					columns: [3,4, 11,12,20,22,23]// muestra solo esas columnas
				}
				
			}		
		]		
	})

}