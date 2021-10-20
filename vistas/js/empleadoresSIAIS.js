/*=============================================
CARGAR LA TABLA DINÁMICA DE EMPRESAS DE LAS BD SIAIS
=============================================*/

var perfilOculto = $("#perfilOculto").val();

$('#tablaEmpleadoresSIAIS').DataTable({

	"ajax": "ajax/datatable-empleadoresSIAIS.ajax.php?perfilOculto="+perfilOculto,

	"deferRender": true,

	"retrieve" : true,

	"processing" : true,

	"pageLength": 25,

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
		// "buttons": {
		// 	"copy": "Copiar",
  //   	"colvis": "Visibilidad de columnas"
    	//}
		
	},

	"responsive": true,

	"lengthChange": false

	//"dom": 'Bfrtip',

	//"buttons": [ 'copy', 'excel', 'pdf', 'colvis' ]

}).buttons().container()

  .appendTo( '#example_wrapper .col-md-6:eq(0)' ); 

/*=============================================
BOTÓN AGREGAR ASEGURADO
=============================================*/

$("#tablaEmpleadoresSIAIS tbody").on("click", "button.btnMostrarAfiliadosSIAIS", function() {
	
	var idEmpleador = $(this).attr("idEmpleador");

	window.location = "index.php?ruta=afiliadosEmpleadorSIAIS&idEmpleador="+idEmpleador;


});