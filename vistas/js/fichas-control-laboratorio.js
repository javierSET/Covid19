/*
@Author: Daniel Villegas Veliz
@description:
@version: 1.0
*/
/*==========================================
	button for show modal to do a search for people in cns @dan
  ==========================================*/
$('#btnNuevoBusquedaPaciente').on("click",function(){
	$('#modalFichasControlLab').modal('show')
})

/*==========================================

  ==========================================*/
$('.btnBuscadorAfiliadoSIAISLocal').on("click", function(){
	var datosPersona = $('#txtBuscadorAfiliadoSIAISLocal').val()
	var evento = "buscarPaciente"
	buscadorPacienteAfiliadoSiaisLocal(evento,datosPersona)
})

/*===========================================
function for search people 
  ===========================================*/
function buscadorPacienteAfiliadoSiaisLocal(evento,valor){

	datos = new FormData()
	datos.append(evento,evento)
	datos.append('valor',valor)

	$.ajax({
		url: "ajax/datatable-pacienteSiaisLaboratorio.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(respuesta){
			console.log(respuesta)
			/* $('#divTablaAfiliadosSIAISLocal').remove();
			$('#divTablaAfiliadosSIAISLocal_wrapper').remove(); */

			$("#divTablaAfiliadosSIAISLocal").append(
				'<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAISLocal" width="100%">'+	                
				'<thead>'+	                  
					'<tr>'+
					'<th>COD. ASEGURADO</th>'+
					'<th>COD. BENEFICIARIO</th>'+
					'<th>APELLIDOS Y NOMBRES</th>'+
					'<th>FECHA NACIMIENTO</th>'+
					'<th>COD. EMPLEADOR</th>'+										
					'</tr>'+
				'</thead>'+
				'</table>'
			);
			
			var t = $('#tablaAfiliadosSIAISLocal').DataTable({
				"data": respuesta,
				"columns": [					
					{ data: 0 },
					{ data: 1 },
					{ data: 2 },
					{ data: 3 },
					{ data: 4 },
				],

				"deferRender": true,

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

				"lengthChange": false,
				"searching": true,
				"ordering": true,
				"info": true,
			});
		}
	})
}