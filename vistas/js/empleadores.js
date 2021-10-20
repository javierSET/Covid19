/*=============================================
CARGAR LA TABLA DINÁMICA DE EMPRESAS
=============================================*/

var perfilOculto = $("#perfilOculto").val();

$('#tablaEmpleadores').DataTable({

	"ajax": "ajax/datatable-empleadores.ajax.php?perfilOculto="+perfilOculto,

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

$("#tablaEmpleadores tbody").on("click", "button.btnAgregarAsegurado", function() {
	
	var idEmpleador = $(this).attr("idEmpleador");

	window.location = "index.php?ruta=nuevo-asegurado&idEmpleador="+idEmpleador;


});