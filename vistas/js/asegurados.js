/*=============================================
CARGAR LA TABLA DINÁMICA DE ASEGURADOS
=============================================*/

var perfilOculto = $("#perfilOculto").val();

$('#tablaAsegurados').DataTable({

	"ajax": "ajax/datatable-asegurados.ajax.php?perfilOculto="+perfilOculto,

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
		},
		"buttons": {
			"copy": "Copiar",
    	"colvis": "Visibilidad de columnas"
    }
		
	},

	"responsive": true,

	"lengthChange": false,

	"dom": 'Bfrtip',

	"buttons": [ 'copy', 'excel', 'pdf', 'colvis' ]

}).buttons().container()

  .appendTo( '#example_wrapper .col-md-6:eq(0)' ); 


/*=============================================
BOTÓN AGREGAR BENEFICIARIOS
=============================================*/

$("#tablaAsegurados tbody").on("click", "button.btnAgregarBeneficiario", function() {
	
	var idAsegurado = $(this).attr("idAsegurado");

	window.location = "index.php?ruta=nuevo-asegurado&idAsegurado="+idAsegurado;


});

/*=============================================
HABILITAR EL CALENDARIO PARA INGRESO DE FECHAS
=============================================*/

// $(function() {

//   $('.calendarioAsegurado').daterangepicker({

//     singleDatePicker: true,
//     showDropdowns: true,
//     locale: {
//         "format": "YYYY-MM-DD",
//         "separator": " - ",
//         "applyLabel": "Aplicar",
//         "cancelLabel": "Cancelar",
//         "fromLabel": "Desde",
//         "toLabel": "Hasta",
//         "customRangeLabel": "Personalizado",
//         "weekLabel": "W",
//         "daysOfWeek": [
//             "Do",
//             "Lu",
//             "Ma",
//             "Mi",
//             "Ju",
//             "Vi",
//             "Sa"
//         ],
//         "monthNames": [
//             "Enero",
//             "Febrero",
//             "Marzo",
//             "Abril",
//             "Mayo",
//             "Junio",
//             "Julio",
//             "Augosto",
//             "Septiembre",
//             "Octubre",
//             "Noviembre",
//             "Diciembre"
//         ],
//         "firstDay": 1
//     },
//     minDate: '1900-01-01',
//     maxDate: moment().format('YYYY-MM-DD')

//   });

// });

/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
$(".nuevaFotoAsegurado").change(function() {
    
    var imagen = this.files[0];

    /*=============================================
    SUBIENDO LA FOTO DEL USUARIO
    =============================================*/

    if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

        $(".nuevaFotoAsegurado").val("");

        swal.fire({
            
            title: "Error al subir la imagen",
            text: "La imagen debe estar en formato JPG o PNG",
            icon: "error",
            allowOutsideClick: false,
            confirmButtonText: "¡Cerrar!"

        });

    } else if(imagen["size"] > 2000000) {

        $(".nuevaFotoAsegurado").val("");

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