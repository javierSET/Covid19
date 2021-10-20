// Uso del localStorage para asignar la clase activa al modulo en que se encuentra
if (localStorage.getItem("actual") != null) {

	if (localStorage.getItem("principal") == ".menu#undefined") {
		
		$(localStorage.getItem("inicial")).removeClass("active");
		$(localStorage.getItem("actual")).addClass("active");		

	} else {

		$(localStorage.getItem("inicial")).removeClass("active");
		$(localStorage.getItem("actual")).addClass("active");
		$(localStorage.getItem("principal")).addClass("active");
		$(localStorage.getItem("principal")).parent().addClass("menu-open");

	}	

}

/*===================================================================================
INDICADOR DE POSICION EN EL MENU
===================================================================================*/

$(document).ready(function() {

	/*=============================================
	//input Mask
	=============================================*/

	$(":input").inputmask();


	/*=============================================
	//Ubicador del menu de usuario
	=============================================*/

	// elementos de la lista
	var menu = $(".menu"); 

	// manejador de click sobre todos los elementos
	menu.click(function() {

		// eliminamos active de todos los elementos
		menu.removeClass("active");

		// activamos el elemento clicado.
		$(this).addClass("active");

		$(this).parent().parent().siblings().addClass("active");

		var inicial = menu.attr('id');
		var actual = $(this).attr('id');
		var principal = $(this).parent().parent().siblings().attr('id');

		localStorage.setItem("inicial", ".menu#"+inicial);
		localStorage.setItem("actual", ".menu#"+actual);    
		localStorage.setItem("principal", ".menu#"+principal);

		});

});

/*===================================================================================
TODOS LOS CAMPOS INPUT NECESARIO PARA MOSTRAR EN MAYUSCULAS
===================================================================================*/

$(document).ready("onkeyup", ".mayuscula", function() {


	console.log("mayuscula", 'se presiono un boton');

	// $(this).toUpperCase();

})


/*=============================================
HABILITAR EL CALENDARIO PARA INGRESO DE FECHAS
=============================================*/

$(function() {

  $('.calendarioAsegurado').daterangepicker({

    singleDatePicker: true,
    showDropdowns: true,
    locale: {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    minDate: '01-01-1900',
    maxDate: moment().format('DD-MM-YYYY')

  });

});

/*=============================================
HABILITAR EL CALENDARIO PARA INGRESO DE FECHAS EN EL FORM BAJA
=============================================*/

$(function() {

  $('.calendarioFormBaja').daterangepicker({

    singleDatePicker: true,
    showDropdowns: true,
    locale: {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    minDate: '01-01-1900',
    drops: "up"

  });

});

/*=============================================
HABILITAR EL CALENDARIO PARA INGRESO DE FECHAS EN EL FORM EDITAR BAJA
=============================================*/

$(function() {

  $('.calendarioFormEditarBaja').daterangepicker({

    singleDatePicker: true,
    showDropdowns: true,
    locale: {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
    minDate: '01-01-1900',
    drops: "up"

  });

});




