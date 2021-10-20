revisarURL();
$(document).ready(function(){

	$("#fichaEpidemiologicaLab :input").prop("disabled", true);
	//$("#fichaEpidemiologicaLab :select").prop("disabled", true);

	if($("#fichaEpidemiologicaLab :input").prop("disabled", true)){
		$('#tomoMuestraLaboratorioSi').removeAttr("disabled");
		$('#tomoMuestraLaboratorioNo').removeAttr("disabled");

		//$('#rechazoMuestra').removeAttr("disabled");
		//$('#nuevoTipoMuestra').removeAttr("disabled");

		$('#nuevoNombreLaboratorio').removeAttr("disabled");
		$('#nuevoFechaMuestra').removeAttr("disabled");

		if($('#nuevoFechaEnvio').attr("disabled") == 'disabled')
		     if(!$('#pruebaAntigenica').prop('checked'))
					$('#nuevoFechaEnvio').removeAttr("disabled");

		$('#nuevoObsMuestra').removeAttr("disabled");
		$('#pcrTiempoReal').removeAttr("disabled");
		$('#pcrGenExpert').removeAttr("disabled");
		$('#pruebaAntigenica').removeAttr("disabled");
		$('#positivo').removeAttr("disabled");
		$('#negativo').removeAttr("disabled");
		$('#nuevoFechaResultado').removeAttr("disabled");
		$('#nuevoCodLaboratorio').removeAttr("disabled");
		$('#nuevoResponsableMuestra').removeAttr("disabled");
		$('#btnGuardarLabl').removeAttr("disabled");
		$('.btnGuardarLab').removeAttr("disabled");
		$('#nuevoEstadoMuestra').removeAttr("disabled");
		$('#responsableAnalisis').removeAttr("disabled");
		
		if($('#tomoMuestraLaboratorioSi').prop('checked')){
			$('#nuevoTipoMuestra').removeAttr("disabled");
			$('#tomoMuestraLaboratorioNo').attr('disabled','disabled');			
		}

		if($('#tomoMuestraLaboratorioNo').prop('checked')){
			$('#rechazoMuestra').removeAttr("disabled");
			$('#tomoMuestraLaboratorioSi').attr('disabled','disabled');	
		}
					
	}
});

function cargarEstablecimiento(){
	var id_ficha= $("#idFicha").val();
	item = "id_establecimiento";
	id_establecimiento = $("#nuevoEstablecimiento").val();
	tabla = "laboratorios";
	actualizarCampoFicha(id_ficha,item,id_establecimiento,tabla);
	actualizarCampoFicha(id_ficha,"nombre_laboratorio","LABORATORIO",tabla);
  }

var perfilOculto = $("#perfilOculto").val();

var actionFichas = $("#actionFichas").val();


var table = $('#tablaFichas').DataTable( {

	"processing": true,
	
    "serverSide": true,

	"ajax": {
		url: "ajax/datatable-fichas.ajax.php",
		data: { 'perfilOculto' : perfilOculto, 'actionFichas' : actionFichas },
		type: "post"
	},

	"rowCallback": function(row, data, index) {
		if ( data[8] == "" ) { //resultado laboratorio
			$('td', row).addClass('bg-lightblue color-palette');
			$('tr.child', row).addClass('bg-lightblue color-palette');
 
			if ( data[11] == "0" ) { //estado ficha
				$('td', row).addClass('bg-maroon color-palette');
				//$('tr.child', row).addClass('bg-maroon color-palette');				
			 }

			 $('td:eq(10)', row).removeClass('bg-maroon color-palette');
			 $('td:eq(10)', row).removeClass('bg-lightblue color-palette');
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

	"lengthChange": false,

});

// actualiza el contenido de la DataTable automaticamente cada 10000 ms.
setInterval( function () {

    table.ajax.reload( null, false ); // user paging is not reset on reload

}, 30000 );


/*=============================================
CREAR UNA NUEVA FICHA EPIDEMIOLOGICA 
=============================================*/

$(document).on("click", ".btnNuevaFichaEpidemiologica", function() {
	$("#modalEvitarDuplicados").modal('show');
});

$(document).on("click", ".btnCrearFichaEpidemiologica", function() {
	
	$(this).attr('disabled','disabled');
	var tieneFicha = $(this).attr('tieneFicha');

	//Recuperamos al paciente para crear la ficha Epidemiologica
	var paciente = JSON.stringify({
		cod_asegurado: $(this).attr('cod_asegurado'),
		cod_afiliado: $(this).attr('cod_afiliado'),
		nombre_empleador: $(this).attr('nombre_empleador'),
		cod_empleador: $(this).attr('cod_empleador'),
		edad: calcularEdad($(this).attr('fecha_nacimiento')),
		fecha_nacimiento: $(this).attr('fecha_nacimiento'),
		paterno: $(this).attr('paterno'),
		materno: $(this).attr('materno'),
		nombre: $(this).attr('nombre'),
		nombre_completo: $(this).attr('nombre_completo'),
		sexo: $(this).attr('sexo') == 1? "M":"F",
		nro_documento: $(this).attr('nro_documento'),
		idAfiliado: $(this).attr('idAfiliado'),
		local: $(this).attr('localOSiais'),
		tieneFicha: $(this).attr('tieneFicha'),
		ficha: $(this).attr('ficha')
	});

	if(tieneFicha === 'true'){ // retornamos un sms si es que el paciente ya tiene ficha aperturada
		let sms = 	swal.fire({

			title: "El paciente ya tiene ficha",
			text: "¡Si quiere aperturar otra ficha para el mismo paciente prosiga!!",
			icon: "question",
			showCancelButton: true,
			allowOutsideClick: false, // Para k el popup no desaparesca haciendo click en el exterior
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si Crear!"
		
		}).then((result)=> {
			if (result.value) {
				console.log("se creo una ficha duplicada");
				crearFichaEpidemiologicaMethod(paciente);
			}
			else{
				$(this).removeAttr('disabled');
			}
		});
		return sms;
	}

	//Creamos la ficha Epidemiologica
	crearFichaEpidemiologicaMethod(paciente);
});

/*===============================================
PROCEDIMIENTO QUE CREA UNA FICHA EPIDEMIOLOGICA M@rk
=================================================*/
function crearFichaEpidemiologicaMethod(paciente){
	
	var paterno_notificador = $("#paternoNotificador").val();
	var materno_notificador = $("#maternoNotificador").val();
	var nombre_notificador = $("#nombreNotificador").val();
	var cargo_notificador = $("#cargoNotificador").val();

	var datos = new FormData();
	datos.append("crearFichaEpidemiologica", "crearFichaEpidemiologica");
	datos.append("paterno_notificador", paterno_notificador);
	datos.append("materno_notificador", materno_notificador);
	datos.append("nombre_notificador", nombre_notificador);
	datos.append("cargo_notificador", cargo_notificador);
	datos.append("paciente", paciente);

	$.ajax({

		url:"ajax/fichas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "html",
		success: function(respuesta) {
		
			if (respuesta != "error") {

				swal.fire({
					
					icon: "success",
					title: "¡FICHA EPIDEMIOLÓGICA generada correctamente!",
					showConfirmButton: true,
					allowOutsideClick: false,
					confirmButtonText: "Aceptar"

				}).then((result) => {
  					
  					if (result.value) {
						  //window.location = "index.php?ruta=editar-ficha-epidemiologica&idFicha="+respuesta;
						  window.location = "index.php?ruta=nuevo-ficha-epidemiologica&idFicha="+respuesta;
					}

				});

			} else {
				swal.fire({						
					title: "¡Error en la Base de Datos, No se puede Generar la FICHA EPIDEMIOLÓGICA!",
					icon: "error",
					allowOutsideClick: false,
					confirmButtonText: "¡Cerrar!"
				});
				
			}

		},
		error: function(error) {
	        console.log("No funciona");	        
	    }
	}); 
}

/*===============================================
CREAR UNA NUEVA FICHA CONTROL Y SEGUIMIENTO M@rk
=================================================*/

$(document).on("click", ".btnNuevaFichaControl", function() {
	alert("OK");
	var paterno_notificador = $("#paternoNotificador").val();
	var materno_notificador = $("#maternoNotificador").val();
	var nombre_notificador = $("#nombreNotificador").val();
	var cargo_notificador = $("#cargoNotificador").val();

	var datos = new FormData();
	datos.append("crearFichaControl", "crearFichaControl");
	datos.append("paterno_notificador", paterno_notificador);
	datos.append("materno_notificador", materno_notificador);
	datos.append("nombre_notificador", nombre_notificador);
	datos.append("cargo_notificador", cargo_notificador);
	
	alert("creo nueva ficha de seguimiento");

	/*
	$.ajax({

		url:"ajax/fichas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "html",
		success: function(respuesta) {
		
			if (respuesta != "error") {

				swal.fire({
					
					icon: "success",
					title: "¡FICHA DE CONTROL Y SEGUIMIENTO generada correctamente!",
					showConfirmButton: true,
					allowOutsideClick: false,
					confirmButtonText: "Aceptar"

				}).then((result) => {
  					
  					if (result.value) {

  						window.location = "index.php?ruta=editar-ficha-control&idFicha="+respuesta;

					}

				});

			} else {

				swal.fire({
						
					title: "¡Error en la Base de Datos, No se puede Generar la FICHA EPIDEMIOLÓGICA!",
					icon: "error",
					allowOutsideClick: false,
					confirmButtonText: "¡Cerrar!"

				});
				
			}

		},
		error: function(error) {

	        console.log("No funciona");
	        
	    }

	});
	*/

});

/*=============================================
BOTON QUE GENERA LOS DATOS DE FICHA EPIDEMIOLÓGICA FILTRADO POR FECHAS
=============================================*/

$(document).on("click", ".btnBuscarFichaFecha", function() {

	$('#tablaFichas').remove();
	$('#tablaFichas_wrapper').remove();

	$("#fichas").append(

	  '<table class="table table-bordered table-striped dt-responsive" id="tablaFichas" width="100%">'+
        
        '<thead>'+
          
          '<tr>'+
            '<th>COD. FICHA.</th>'+
            '<th>TIPO DE FICHA.</th>'+
            '<th>COD. ASEGURADO</th>'+
            '<th>APELLIDOS Y NOMBRES</th>'+
            '<th>CI</th>'+
            '<th>SEXO</th>'+
            '<th>FECHA NACIMIENTO</th>'+
            '<th>FECHA NOTIFICACIÓN</th>'+
            '<th>BÜSQUEDA ACTIVA</th>'+
            '<th>RESULTADO</th>'+
            '<th>FECHA RESULTADO</th>'+
            '<th>ACCIONES</th>'+
          '</tr>'+

        '</thead>'+
        
      '</table>'  

    );       			

	var fecha = $("#fechaMuestra").val();

	/*=============================================
	CARGAR LA TABLA DINÁMICA DE COVID RESULTADOS
	=============================================*/

	var perfilOculto = $(this).attr("perfilOculto");
   
	var actionBuscarFichaFecha = $(this).attr("actionBuscarFichaFecha");

	
	$('#tablaFichas').DataTable({

		"ajax": "ajax/datatable-fichas.ajax.php?perfilOculto="+perfilOculto+"&actionBuscarFichaFecha="+actionBuscarFichaFecha+"&fecha="+fecha,

		"deferRender": true,

		"retrieve" : true,

		"processing" : true,

		"rowCallback": function(row, data, index) {
	       if ( data[21] == "0" )
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

/*===============================================================================
BUSQUEDA DE AFILIADO A PARTIR DEL NOMBRE O COD ASEGURADO POR EL BOTON BUSCAR M@RK
=================================================================================*/

$(document).on("click", ".btnBuscarAfiliadoFichas", function() {
	buscarAfiliadoDuplicadoFichas();
});

function buscarAfiliadoDuplicadoFichas(){
	var ruta = revisarURLGeneric("/ficha-epidemiologica");
	var ruta1 = revisarURLGeneric("nuevo-ficha-epidemiologica");
	var ruta2 = revisarURLGeneric("editar-ficha-epidemiologica");

	//console.log(ruta);

	var afiliado = $("#buscardorAfiliadosFichas").val();

	if(afiliado != " ") //Solo para nuestras busquedas con vacio
		afiliado = afiliado.trim();
	else afiliado = afiliado.trim();
	 
	if (afiliado != "") {

		var datos = new FormData();
		datos.append("afiliado", afiliado);
		datos.append("buscarLocal",false);

		if(ruta || ruta1 || ruta2){ //Bandera que indica que se esta aperturando una nueva ficha
			datos.append("buscarDuplicado",true);
			datos.delete('buscarLocal');
			datos.append("buscarLocal",true);
		}

		//Para mostrar alerta personalizada de loading
		swal.fire({
	        text: 'Procesando...',
	        allowOutsideClick: false,
	        allowEscapeKey: false,
	        allowEnterKey: false,
	        onOpen: () => {
	            swal.showLoading()
	        }
	    });

		$.ajax({

			url: "ajax/datatable-afiliadosSIAIS.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta) {	
				//Para cerrar la alerta personalizada de loading
				swal.close();
				var localOSiais = {bdlocal:false}; //valor por defecto
				if(ruta || ruta1 || ruta2)
					localOSiais = respuesta.pop();

				console.log(respuesta);
				console.log(localOSiais);
				$('#tablaAfiliadosSIAISFichas').remove();
				$('#tablaAfiliadosSIAISFichas_wrapper').remove();

				$("#tblAfiliadosSIAISFichas").append(

				  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAISFichas" width="100%">'+
	                
	                '<thead>'+
	                  
	                  '<tr>'+
	                    '<th>COD. ASEGURADO</th>'+
	                    '<th>COD. BENEFICIARIO</th>'+
	                    '<th>APELLIDOS Y NOMBRES</th>'+
	                    '<th>FECHA NACIMIENTO</th>'+
	                    '<th>COD. EMPLEADOR</th>'+
	                    '<th>NOMBRE EMPLEADOR</th>'+
	                    '<th>FICHAS</th>'+
	                  '</tr>'+

	                '</thead>'+
	                
	              '</table>'  

	            );       			
				
				var tam = 10;
				let sizeScreen = screen.height;
				if(sizeScreen <= 720)
					tam = 3;	

				var t = $('#tablaAfiliadosSIAISFichas').DataTable({
					"scrollY":  "400px",
        			"scrollCollapse": true,
					"pageLength": tam,
					"data": respuesta,

					"columns": [
			            { data: "cod_asegurado" },
			            //{ data: "cod_beneficiario" },
						{render: function (data, type, row) {
							if(localOSiais.bdlocal)
								return row.cod_afiliado;
							else return row.cod_beneficiario;
							
						}},
			            { data: "nombre_completo" },
			            { render: function (data, type, row) {
							var date = new Date(row.fecha_nacimiento);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD-MM-YYYY"));
						}},
			            { data: "cod_empleador" },
			            { data: "nombre_empleador" },
			            { render: function(data, type, row) {
							//debugger;
							// Creamos la tabla de las fichas
							let tableFichas = "<table width='100%'>"+	                
											  "<thead>"+							  
											  "<tr>"+
												  "<th>FICHA</th>"+
												  "<th>ACCIONES</th>"+
											  "</tr>"+
											  "</thead>";

							if(ruta || ruta1 || ruta2){ //Nos asegura si se quiere aperturar ficha								
								var classButton = "btnCrearFichaEpidemiologica";
								if(ruta1 || ruta2)
									classButton = "btnSeleccionarAfiliadoFicha";

								if(row.tieneFicha){
									//Verificamos si el paciente tiene ficha
									if(localOSiais.bdlocal){
										if(row.ficha.length > 0){
											let ficha = "";	
											row.ficha.forEach(element => {
												fichaId = 	element.id_ficha;										
												let botones =  "<div class='btn-group'><button class='btn btn-danger "+ classButton +
																						"' cod_asegurado='" + String(row.cod_asegurado).trim() +
																						"' cod_afiliado='" + String(row.cod_afiliado).trim()+
																						"' nombre_empleador='" + String(row.nombre_empleador).trim()+
																						"' cod_empleador='" + String(row.cod_empleador).trim()+
																						"' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																						"' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																						"' paterno='" + String(row.paterno).trim()+
																						"' materno='" + String(row.materno).trim()+
																						"' nombre='" + String(row.nombre).trim()+
																						"' nombre_completo='" + String(row.nombre_completo).trim()+
																						"' sexo='" + String(row.sexo).trim()+
																						"' nro_documento='" + String(row.nro_documento).trim()+
																						"' idAfiliado='" + String(row.id_paciente).trim()+
																						"' localOSiais='true" +
																						"' tieneFicha='true" + 
																						"' ficha='" + String(fichaId).trim()+
																						"' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																						"<i class='fas fa-check'></i>"+
																				"</button>"+
														"</div>" +
														"<button class='btn btn-warning btnVerAfiliadoFicha' ficha='"+  String(fichaId).trim() + "' cod_afiliado='" + String(row.cod_afiliado).trim() + "' data-toggle='tooltip' title='ver la ficha'><i class='far fa-eye'></i></button>"+
														"</div>";
	
												ficha += "<tr>"+
															"<th>FICHA N° " +String(fichaId).trim()+ "</th>"+
															"<th>"+ botones + "</th>"
														"</tr>";
											} );
											let cierre =  "</table>";
											return tableFichas + ficha + cierre;			
										}
										else{
											let botones =  "<div class='btn-group'><button class='btn btn-success "+ classButton +
																						"' cod_asegurado='" + String(row.cod_asegurado).trim() +
																						"' cod_afiliado='" + String(row.cod_afiliado).trim()+
																						"' nombre_empleador='" + String(row.nombre_empleador).trim()+
																						"' cod_empleador='" + String(row.cod_empleador).trim()+
																						"' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																						"' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																						"' paterno='" + String(row.paterno).trim()+
																						"' materno='" + String(row.materno).trim()+
																						"' nombre='" + String(row.nombre).trim()+
																						"' nombre_completo='" + String(row.nombre_completo).trim()+
																						"' sexo='" + String(row.sexo).trim()+
																						"' nro_documento='" + String(row.nro_documento).trim()+
																						"' idAfiliado='" + String(row.id_paciente).trim()+
																						"' localOSiais='true" +
																						"' tieneFicha='true" + 
																						"' ficha='" + -1 +
																						"' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																						"<i class='fas fa-check'></i>"+
																				"</button>"+
														"</div>";
											return botones;			
										} 
											
									}
									else{
										if(row.ficha.length > 0){
											let ficha = "";	
											row.ficha.forEach(element => {
												fichaId = 	element.id_ficha;										
												let botones = "<div class='btn-group'><button class='btn btn-danger "+ classButton +
																				   "' cod_asegurado='" + String(row.cod_asegurado).trim() +
																				   "' cod_afiliado='" + String(row.cod_beneficiario).trim()+
																				   "' nombre_empleador='" + String(row.nombre_empleador).trim()+
																				   "' cod_empleador='" + String(row.cod_empleador).trim()+
																				   "' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																				   "' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																				   "' paterno='" + String(row.pac_primer_apellido).trim()+
																				   "' materno='" + String(row.pac_segundo_apellido).trim()+
																				   "' nombre='" + String(row.pac_nombre).trim()+
																				   "' nombre_completo='" + String(row.nombre_completo).trim()+
																				   "' sexo='" + String(row.idsexo).trim()+
																				   "' nro_documento='" + String(row.pac_documento_id).trim()+
																				   "' idAfiliado='" + String(row.idafiliacion).trim()+
																				   "' localOSiais='false" +
																				   "' tieneFicha='true" + 
																				   "' ficha='" + String(fichaId).trim() +
																				   "' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																				   "<i class='fas fa-check'></i>"+
																		   "</button>"+
													"</div>" +
													"<button class='btn btn-warning btnVerAfiliadoFicha' ficha='"+  String(fichaId).trim() + "' cod_afiliado='" + String(row.cod_beneficiario).trim() + "' data-toggle='tooltip' title='ver la ficha'><i class='far fa-eye'></i></button>"+
													"</div>";
	
													ficha += "<tr>"+
													"<th>FICHA N° " +String(fichaId).trim()+ "</th>"+
													"<th>"+ botones + "</th>"
													"</tr>";
											});
											let cierre =  "</table>";
											return tableFichas + ficha + cierre;		
										}
										else{
											let botones = "<div class='btn-group'><button class='btn btn-success "+ classButton +
																				   "' cod_asegurado='" + String(row.cod_asegurado).trim() +
																				   "' cod_afiliado='" + String(row.cod_beneficiario).trim()+
																				   "' nombre_empleador='" + String(row.nombre_empleador).trim()+
																				   "' cod_empleador='" + String(row.cod_empleador).trim()+
																				   "' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																				   "' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																				   "' paterno='" + String(row.pac_primer_apellido).trim()+
																				   "' materno='" + String(row.pac_segundo_apellido).trim()+
																				   "' nombre='" + String(row.pac_nombre).trim()+
																				   "' nombre_completo='" + String(row.nombre_completo).trim()+
																				   "' sexo='" + String(row.idsexo).trim()+
																				   "' nro_documento='" + String(row.pac_documento_id).trim()+
																				   "' idAfiliado='" + String(row.idafiliacion).trim()+
																				   "' localOSiais='false" +
																				   "' tieneFicha='true" + 
																				   "' ficha='" + -1 +
																				   "' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																				   "<i class='fas fa-check'></i>"+
																		   "</button>"+
													"</div>";
											return botones;		
										}
									}
									
								}
								else{ //mas adelante si es que se quiere aperturar otra ficha a un paciente que ya tiene guiarse con esta bandera if(localOSiais.bdlocal) 
									if(localOSiais.bdlocal){ // Paciente se encontro en local
										if(row.ficha.length > 0){
											let ficha = "";	
											row.ficha.forEach(element => {	
												 fichaId = 	element.id_ficha;									
												 let botones =  "<div class='btn-group'><button class='btn btn-info "+ classButton +
																				   "' cod_asegurado='" + String(row.cod_asegurado).trim() +
																				   "' cod_afiliado='" + String(row.cod_afiliado).trim()+
																				   "' nombre_empleador='" + String(row.nombre_empleador).trim()+
																				   "' cod_empleador='" + String(row.cod_empleador).trim()+
																				   "' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																				   "' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																				   "' paterno='" + String(row.paterno).trim()+
																				   "' materno='" + String(row.materno).trim()+
																				   "' nombre='" + String(row.nombre).trim()+
																				   "' nombre_completo='" + String(row.nombre_completo).trim()+
																				   "' sexo='" + String(row.sexo).trim()+
																				   "' nro_documento='" + String(row.nro_documento).trim()+
																				   "' idAfiliado='" + String(row.id_paciente).trim()+
																				   "' localOSiais='true" +
																				   "' tieneFicha='false" + 
																				   "' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																				   "<i class='fas fa-check'></i>"+
																		   "</button>"+
													"</div>";
	
												ficha += "<tr>"+
														 "<th>FICHA N° " +String(fichaId).trim()+ "</th>"+
														 "<th>"+ botones + "</th>"
														 "</tr>";	
											});
											let cierre =  "</table>";
											return tableFichas + ficha + cierre;		
										}
										else{
											let botones =  "<div class='btn-group'><button class='btn btn-info "+ classButton +
																				   "' cod_asegurado='" + String(row.cod_asegurado).trim() +
																				   "' cod_afiliado='" + String(row.cod_afiliado).trim()+
																				   "' nombre_empleador='" + String(row.nombre_empleador).trim()+
																				   "' cod_empleador='" + String(row.cod_empleador).trim()+
																				   "' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																				   "' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																				   "' paterno='" + String(row.paterno).trim()+
																				   "' materno='" + String(row.materno).trim()+
																				   "' nombre='" + String(row.nombre).trim()+
																				   "' nombre_completo='" + String(row.nombre_completo).trim()+
																				   "' sexo='" + String(row.sexo).trim()+
																				   "' nro_documento='" + String(row.nro_documento).trim()+
																				   "' idAfiliado='" + String(row.id_paciente).trim()+
																				   "' localOSiais='true" +
																				   "' tieneFicha='false" + 
																				   "' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																				   "<i class='fas fa-check'></i>"+
																		   "</button>"+
													"</div>";
											return botones;		
										}
									}
									else{ // Paciente no se encontro en local
										if(row.ficha.length > 0){										
											let ficha = "";
											row.ficha.forEach(element => {
												fichaId = 	element.id_ficha;											
												let botones = "<div class='btn-group'><button class='btn btn-info "+ classButton +
																				   "' cod_asegurado='" + String(row.cod_asegurado).trim() +
																				   "' cod_afiliado='" + String(row.cod_beneficiario).trim()+
																				   "' nombre_empleador='" + String(row.nombre_empleador).trim()+
																				   "' cod_empleador='" + String(row.cod_empleador).trim()+
																				   "' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																				   "' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																				   "' paterno='" + String(row.pac_primer_apellido).trim()+
																				   "' materno='" + String(row.pac_segundo_apellido).trim()+
																				   "' nombre='" + String(row.pac_nombre).trim()+
																				   "' nombre_completo='" + String(row.nombre_completo).trim()+
																				   "' sexo='" + String(row.idsexo).trim()+
																				   "' nro_documento='" + String(row.pac_documento_id).trim()+
																				   "' idAfiliado='" + String(row.idafiliacion).trim()+
																				   "' localOSiais='false" +
																				   "' tieneFicha='false" + 
																				   "' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																				   "<i class='fas fa-check'></i>"+
																		   "</button>"+
													"</div>";
	
												ficha += "<tr>"+
														 "<th>FICHA N° " +String(fichaId).trim()+ "</th>"+
														 "<th>"+ botones + "</th>"
														 "</tr>";	
											});
											
											let cierre =  "</table>";
											return tableFichas + ficha + cierre;
										}
										else{
											let botones = "<div class='btn-group'><button class='btn btn-info "+ classButton +
																				   "' cod_asegurado='" + String(row.cod_asegurado).trim() +
																				   "' cod_afiliado='" + String(row.cod_beneficiario).trim()+
																				   "' nombre_empleador='" + String(row.nombre_empleador).trim()+
																				   "' cod_empleador='" + String(row.cod_empleador).trim()+
																				   "' edad='" + String(calcularEdad(row.fecha_nacimiento))+ //calcular.trim()
																				   "' fecha_nacimiento='" + String(row.fecha_nacimiento).trim()+
																				   "' paterno='" + String(row.pac_primer_apellido).trim()+
																				   "' materno='" + String(row.pac_segundo_apellido).trim()+
																				   "' nombre='" + String(row.pac_nombre).trim()+
																				   "' nombre_completo='" + String(row.nombre_completo).trim()+
																				   "' sexo='" + String(row.idsexo).trim()+
																				   "' nro_documento='" + String(row.pac_documento_id).trim()+
																				   "' idAfiliado='" + String(row.idafiliacion).trim()+
																				   "' localOSiais='false" +
																				   "' tieneFicha='false" + 
																				   "' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'>"+
																				   "<i class='fas fa-check'></i>"+
																		   "</button>"+
													"</div>";
											return botones;		
										}
									}
								}
							}
							else{
								return "<div class='btn-group'><button class='btn btn-info btnSeleccionarAfiliadoFicha' idAfiliado='"+row.idafiliacion+"' data-toggle='tooltip' title='Seleccionar Afiliado para Aperturar Nueva Ficha'><i class='fas fa-check'></i></button></div>";
							}
			            }}
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
	        		
	        		"info":     false 

				});

			},
		    error: function(error){

		      console.log("No funciona");
		        
		    }

		});

	} else {	
		$('#tablaAfiliadosSIAISFichas').remove();
		$('#tablaAfiliadosSIAISFichas_wrapper').remove();

	}
}

/*=========================================================================
MOSTRAR LA FICHA DUPLICADA M@rk
===========================================================================*/
$(document).on("click", ".btnVerAfiliadoFicha", function(e) {

	let ficha = $(this).attr("ficha");
	let code = $(this).attr("cod_afiliado");
	var datos = new FormData();
	datos.append("fichaEpidemiologicaPDF", "fichaEpidemiologicaPDF");
	datos.append("idFicha", ficha);

	//Para mostrar alerta personalizada de loading
	swal.fire({
		text: 'Procesando...',
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		onOpen: () => {
			swal.showLoading()
		}
	});

	$.ajax({
		url: "ajax/fichas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		//dataType: "string",
		success: function(respuesta) {
			swal.close();
			$('#ver-duplicado').modal({
				show:true,
				backdrop:'static'
			});
			PDFObject.embed("temp/"+code+"/ficha-epidemiologica-"+ficha+".pdf", "#view_duplicado");
		}

	});

});

/*===============================================================================
BUSQUEDA DE AFILIADO A PARTIR DEL NOMBRE O COD ASEGURADO POR LA TECLA ENTER M@rk
=================================================================================*/

$(document).on("keypress", "#buscardorAfiliadosFichas", function(e) {

	if (e.which == 13) {
		buscarAfiliadoDuplicadoFichas();
    
/*     	var afiliado = $("#buscardorAfiliadosFichas").val();

		if (afiliado != "") {

			var datos = new FormData();
			datos.append("afiliado", afiliado);

			//Para mostrar alerta personalizada de loading
			swal.fire({
		        text: 'Procesando...',
		        allowOutsideClick: false,
		        allowEscapeKey: false,
		        allowEnterKey: false,
		        onOpen: () => {
		            swal.showLoading()
		        }
		    });

			$.ajax({

				url: "ajax/datatable-afiliadosSIAIS.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta) {		

					//Para cerrar la alerta personalizada de loading
					swal.close();		

					$('#tablaAfiliadosSIAISFichas').remove();
					$('#tablaAfiliadosSIAISFichas_wrapper').remove();

					$("#tblAfiliadosSIAISFichas").append(

					  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAISFichas" width="100%">'+
		                
		                '<thead>'+
		                  
		                  '<tr>'+
		                    '<th>COD. ASEGURADO123</th>'+
		                    '<th>COD. BENEFICIARIO</th>'+
		                    '<th>APELLIDOS Y NOMBRES</th>'+
		                    '<th>FECHA NACIMIENTO</th>'+
		                    '<th>COD. EMPLEADOR</th>'+
		                    '<th>NOMBRE EMPLEADOR</th>'+
		                    '<th>ACCIONES</th>'+
		                  '</tr>'+

		                '</thead>'+
		                
		              '</table>'  

		            );       			

					var t = $('#tablaAfiliadosSIAISFichas').DataTable({

						"data": respuesta,

						"columns": [
				            { data: "cod_asegurado" },
				            { data: "cod_beneficiario" },
				            { data: "nombre_completo" },
				            { render: function (data, type, row) {
								var date = new Date(row.fecha_nacimiento);
								date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
								return (moment(date).format("DD-MM-YYYY"));
							}},
				            { data: "cod_empleador" },
				            { data: "nombre_empleador" },
				            { render: function(data, type, row) {
				            	return "<div class='btn-group'><button class='btn btn-info btnSeleccionarAfiliadoFicha' idAfiliado='"+row.idafiliacion+"' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>"
				            }}
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
		        		
		        		"info":     false 

					});

				},
			    error: function(error){

			      console.log("No funciona");
			        
			    }

			});

		} else {

			
			$('#tablaAfiliadosSIAISFichas').remove();
			$('#tablaAfiliadosSIAISFichas_wrapper').remove();

		} */

	}

});


/*=============================================
SELECCIÓN DE AFILIADO Y TRASPASO AL FORMULARIO FICHA EPIDEMIOLOGICA
=============================================*/

$(document).on("click", ".btnSeleccionarAfiliadoFicha", function() {

	var idAfiliado = $(this).attr("idAfiliado");
	console.log("idAfiliado", idAfiliado);

	var idFicha = $("#idFicha").val();
	console.log("idFicha...", idFicha);

	$(this).removeClass("btn-info btnSeleccionarAfiliadoFicha");

	$(this).addClass("btn-default");

	var datos = new FormData();
	datos.append("guardarAfiliadoFicha", "guardarAfiliadoFicha");
	datos.append("idAfiliado", idAfiliado);
	datos.append("idFicha", idFicha);

//	cargarEstablecimiento();
	
	$.ajax({

		url:"ajax/afiliadosSIAIS.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json",
		success:function(respuesta) {
			
			toastr.success('El Dato se guardó correctamente.');
            //console.log(respuesta);
			var id = respuesta["idafiliacion"];
			var codAsegurado = respuesta["pac_numero_historia"];
			var codAfiliado = respuesta["pac_codigo"];
			var ci = respuesta["pac_documento_id"];
			var sexo = respuesta["idsexo"];
			var codEmpleador = respuesta["emp_nro_empleador"];
			var nombreEmpleador = respuesta["emp_nombre"];
			var paterno = respuesta["pac_primer_apellido"];
			var materno = respuesta["pac_segundo_apellido"];
			var nombre = respuesta["pac_nombre"];
			var fechaNacimiento = respuesta["pac_fecha_nac"];
			var edad = calcularEdad(fechaNacimiento);
			if (sexo==1){
				sexo="M";
			}if(sexo==2){
				sexo="F";
			}
			if(ci==0 || ci=="" || ci=="S/D" || ci=="X" || ci=="x" || ci=="XXXXXXXXXXXX" || ci==null || ci == "-1"){
				ci="";
			}

			$('#nuevoCodAsegurado').empty().prepend("<option value='"+codAsegurado+"' >"+codAsegurado+"</option>");
			$('#nuevoCodEmpleador').val(codEmpleador);
			$('#nuevoCodAfiliado').val(codAfiliado);
			$('#nuevoNombreEmpleador').val(nombreEmpleador);
			$('#nuevoPaternoPaciente').val(paterno);
			$('#nuevoMaternoPaciente').val(materno);
			$('#nuevoNombrePaciente').val(nombre);

			$('#nuevoNroDocumentoPaciente').val(ci);
			$('#nuevoSexoPaciente').val(sexo);

			//Eliminando la clase error
			$('#nuevoCodEmpleador').removeClass('error');
			$('#nuevoCodAfiliado').removeClass('error');
			$('#nuevoNombreEmpleador').removeClass('error');
			$('#nuevoPaternoPaciente').removeClass('error');
			$('#nuevoMaternoPaciente').removeClass('error');
			$('#nuevoNombrePaciente').removeClass('error');
			$('#nuevoCodAsegurado').removeClass('error');
			$('#nuevoSexoPaciente').removeClass('error');

			//Agregar la clase valid
			$('#nuevoCodEmpleador').removeAttr('style');
			$('#nuevoCodAfiliado').removeAttr('style');
			$('#nuevoNombreEmpleador').removeAttr('style');
			$('#nuevoPaternoPaciente').removeAttr('style');
			$('#nuevoMaternoPaciente').removeAttr('style');
			$('#nuevoNombrePaciente').removeAttr('style');
			$('#nuevoCodAsegurado').removeAttr('style');

			$('#nuevoNroDocumentoPaciente').val(ci);
			$('#nuevoSexoPaciente').val(sexo);
			$('#nuevoSexoPaciente').removeClass('error');
			$('#nuevoSexoPaciente').removeAttr('style');	

			//Actualizamos el sexo y el ci del paciente debido a que el ajax no modifico REVISAR
			actualizarCampoFicha($("#idFicha").val(),'sexo',$('#nuevoSexoPaciente').val(),'pacientes_asegurados');
			$ci = $('#nuevoNroDocumentoPaciente').val();
			if($ci != "Agregar")
			   actualizarCampoFicha($("#idFicha").val(),'nro_documento',$('#nuevoNroDocumentoPaciente').val(),'pacientes_asegurados');

			$('#nuevoFechaNacPaciente').val(fechaNacimiento);
			$('#nuevoFechaNacPaciente').removeClass('error');
			$('#nuevoFechaNacPaciente').removeAttr('style');

			 /*********************************************************
			 	verifica que la edad sea menor que 19 para habilitar
			 	datos de apoderado son datos importantes
			 **********************************************************/	
			
			//debugger;
			if(edad < 19){
				$("#divDatosApoderado").show();
			}else{
				$("#divDatosApoderado").hide();
			}

			$('#nuevoEdadPaciente').val(edad);
						
			$('#modalCodAsegurado').modal('toggle');		


		},
		error: function(error) {

	        toastr.warning('¡Error! Falla en la consulta a BD, no se modificaron.')
	        
	    }				

	});

});

/*=============================================
FUNCION PARA CALCULAR LA EDAD DE UNA PERSONA
=============================================*/

function calcularEdad(fecha) {

    // Si la fecha es correcta, calculamos la edad
    var values=fecha.split("-");
    var dia = values[2];
    //console.log("dia", dia);
    var mes = values[1];
    //console.log("mes", mes);
    var ano = values[0];
    //console.log("ano", ano);

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth()+1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;
    if ( ahora_mes < mes ) {

        edad--;

    }

    if ((mes == ahora_mes) && (ahora_dia < dia)) {

        edad--;

    }

    if (edad > 1900) {

        edad -= 1900;

    }

    // calculamos los meses
    var meses = 0;

    if(ahora_mes > mes)

        meses = ahora_mes - mes;

    if(ahora_mes < mes)

        meses = 12 - (mes - ahora_mes);

    if(ahora_mes == mes && dia > ahora_dia)

        meses = 11;

    // calculamos los dias
    var dias = 0;

    if (ahora_dia > dia)

        dias = ahora_dia - dia;

    if (ahora_dia < dia) {

        ultimoDiaMes = new Date(ahora_ano, ahora_mes, 0);
        dias = ultimoDiaMes.getDate() - (dia - ahora_dia);

    }

    return edad;

}

/*=============================================
SI TIENE ANTECEDENTES DE VACUNA HABILITAN LOS CAMPOS CASO CONTRARIO SE MANTIENEN INABILITADOS
=============================================*/

$(document).on("change", "#nuevoAntVacunaInfluenza", function() {

	if ($(this).val() == "SI") {

		$("#nuevoFechaVacunaInfluenza").removeAttr("readonly");

	} else {

		$("#nuevoFechaVacunaInfluenza").attr("readonly","");
		$("#nuevoFechaVacunaInfluenza").val("");

	}
	
});

/*=============================================
SI SELECCIONO POLICLINICO COMO ESTABLECIMIENTO SE HABILITAN LOS CONSULTORIOS
=============================================*/

$(document).on("change", "#nuevoEstablecimiento", function(event) {

	$("#nuevoConsultorio").removeAttr("disabled");

	/* if ($(this).val() == "2") {

		$("#nuevoConsultorio").removeAttr("disabled");

	} else {

		$("#nuevoConsultorio").attr("disabled","");
		$("#nuevoConsultorio").val("");

	} */
    //actualizando codigo de establecimiento
	$('#nuevoCodEstablecimiento').val($("#nuevoEstablecimiento option:selected").data("codestablecimiento"));

	//actualizando red de salud
	redsaludDate = $("#nuevoEstablecimiento option:selected").data("redsalud");
	$('#nuevoRedSalud').val(redsaludDate);

	resetearCamposTabla($("#idFicha").val(), 'red_salud', redsaludDate, 'fichas');
	
	//actualizando consultorios
	options = $("#nuevoEstablecimiento option:selected").data("objectestablecimiento");
	actualizarSelect('#nuevoConsultorio', convertirArrayJson(options));

	//actualizando tabla laboratorios
	cargarEstablecimiento();
});


function actualizarSelect(selectId,consultorios){
 	 //Vaciamos el select
	//$('#nuevoConsultorio').empty();
	$(selectId).empty();
	//iteramos el array consultorios
	console.log("ESTOS SON LOS CONSULTORIOS :  " +  consultorios.length);
	console.log(consultorios); 
	if(consultorios.length > 0){
		$.each(consultorios,function(index,value){
			//convertimos en Objeto JSON el value por que es cadena en este caso 
			if(value[0] != undefined){  //controlamos que no sea cadena vacia
				jsonObject = JSON.parse(value)
				//creamos las opciones del select
				$.each(jsonObject, function (i, item) { 
					$(selectId).append($("<option>",
					{ value: i,
					  text : item }));
					//console.log("ESTE ES EL ITEM: " + item);
				});
			}
		});
		//Una vez que seteamos el select volvemos a actualizar la tabla
		idConsul = $("#nuevoConsultorio option:selected").val();
		idFicha = $ ("#idFicha").val();
		resetearCamposTabla(idFicha,'id_consultorio', idConsul, 'fichas');	
	}
	
}

function convertirArrayJson(options){
  newCadena = options.replace(/'/g,'"');
  newCadena = newCadena.substring(0, newCadena.length - 1);
  
  consultorios = newCadena.split(',')
  return consultorios;

  //debugger;
  /*jsonmark = JSON.parse(consultorios[0]); 
  console.log(jsonmark);*/
}

/*=============================================
SI VIAJO ALGUN LUGAR DE RIESGO SE HABILITAN LOS CAMPOS CASO CONTRARIO SE MANTIENEN INABILITADOS
=============================================*/

$(document).on("change", "#nuevoViajeRiesgo", function() {

	if ($(this).val() == "SI") {

		$("#nuevoPaisCiudadRiesgo").removeAttr("readonly");
		$("#nuevoFechaRetorno").removeAttr("readonly");
		$("#nuevoEmpresaVuelo").removeAttr("readonly");
		$("#nuevoNroVuelo").removeAttr("readonly");
		$("#nuevoNroAsiento").removeAttr("readonly");

	} else {

		$("#nuevoPaisCiudadRiesgo").attr("readonly","");
		$("#nuevoPaisCiudadRiesgo").val("");
		$("#nuevoFechaRetorno").attr("readonly","");
		$("#nuevoFechaRetorno").val("");
		$("#nuevoEmpresaVuelo").attr("readonly","");
		$("#nuevoEmpresaVuelo").val("");
		$("#nuevoNroVuelo").attr("readonly","");
		$("#nuevoNroVuelo").val("");
		$("#nuevoNroAsiento").attr("readonly","");
		$("#nuevoNroAsiento").val("");
	}
	
});

/*=============================================
SI TUVO ALGUN CONTACTO CON ALGUIEN CON COVID SE HABILITAN LOS CAMPOS CASO CONTRARIO SE MANTIENEN INABILITADOS
=============================================*/
/*
$(document).on("change", "#nuevoContactoCovid", function() {

	if ($(this).val() == "SI") {

		$("#nuevoFechaContactoCovid").removeAttr("readonly");
		$("#nuevoNombreContactoCovid").removeAttr("readonly");
		$("#nuevoNombreContactoCovid").val("");
		$("#nuevoTelefonoContactoCovid").removeAttr("readonly");
		$("#nuevoPaisContactoCovid").removeAttr("readonly");
		$("#nuevoPaisContactoCovid").val("");
		$("#nuevoDepartamentoContactoCovid").removeAttr("readonly");
		$("#nuevoDepartamentoContactoCovid").val("");
		$("#nuevoLocalidadContactoCovid").removeAttr("readonly");
		$("#nuevoLocalidadContactoCovid").val("");

	} else {

		$("#nuevoFechaContactoCovid").attr("readonly","");
		$("#nuevoFechaContactoCovid").val("");
		$("#nuevoNombreContactoCovid").attr("readonly","");
		$("#nuevoNombreContactoCovid").val("COMUNITARIO");
		$("#nuevoTelefonoContactoCovid").attr("readonly","");
		$("#nuevoTelefonoContactoCovid").val("");
		$("#nuevoPaisContactoCovid").attr("readonly","");
		$("#nuevoPaisContactoCovid").val("BOLIVIA");
		$("#nuevoDepartamentoContactoCovid").attr("readonly","");
		$("#nuevoDepartamentoContactoCovid").val("COCHABAMBA");
		$("#nuevoLocalidadContactoCovid").attr("readonly","");
		$("#nuevoLocalidadContactoCovid").val("COCHABAMBA");

	}
	
});
*/
/*=============================================
SI ESTADO ACTUAL DEL PACIENTE ES FALLECIDO SE HABILITAN LOS CAMPOS CASO CONTRARIO SE MANTIENEN INABILITADOS
=============================================*/

$(document).on("change", "#nuevoEstadoPaciente", function() {	

	var id_ficha = $ ("#idFicha").val();
	item = "fecha_defuncion";
	valor = $(this).val();
	tabla = "datos_clinicos";
	if(valor!=""){
		if (valor == "FALLECIDO") {
			$("#nuevoFechaDefuncionDiv").show();
			$("#nuevoFechaDefuncion").removeAttr("readonly");
		} 
		else{
			$("#nuevoFechaDefuncionDiv").hide();
			$("#nuevoFechaDefuncion").attr("readonly","");
			$("#nuevoFechaDefuncion").val("");
			actualizarCampoFicha(id_ficha, item, "", tabla);
		}
	}
	else{
		$("#nuevoFechaDefuncionDIv").hide();		
	}
	
});

$(document).ready(function() {

	/*=============================================
	FUNCIONES PARA CAMBIAR LOS MENSAJES POR DEFECTO DEL PLUGIN DE VALIDACIÓN M@rk
	=============================================*/
	$.extend($.validator.messages, {
		required: "Este campo es obligatorio.",
		remote: "Por favor, rellena este campo.",
		email: "Por favor, escribe una dirección de correo válida",
		url: "Por favor, escribe una URL válida.",
		date: "Por favor, escribe una fecha válida.",
		dateISO: "Por favor, escribe una fecha (ISO) válida.",
		number: "Por favor, escribe un número entero válido.",
		digits: "Por favor, escribe sólo dígitos.",
		creditcard: "Por favor, escribe un número de tarjeta válido.",
		equalTo: "Por favor, escribe el mismo valor de nuevo.",
		accept: "Por favor, escribe un valor con una extensión aceptada.",
		maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
		minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
		rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
		range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
		max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
		min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
	});

	/*=============================================
	FUNCIONES CON LOS DIFERENTES PATRONES CON EXPRESIONES REGULARES PARA LA VALIDACIÓN
	=============================================*/

	$.validator.addMethod("patron_letras", function (value, element) {

	    var pattern = /^[a-zA-Z]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "El campo debe contener letras (azAZ)");

	$.validator.addMethod("patron_letras_espacios", function (value, element) {

	    var pattern = /^[a-zA-Z\s]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "El campo debe contener letras (azAZ )");

	//patron_elegir

	$.validator.addMethod("patron_elegir", function (value, element) {

	    return $(element).val() != 0;

	}, "Debe seleccionar una opcion");

	$.validator.addMethod("fecha_vacia", function (value, element) {

	    return $(element).val() != 'dd/mm/aa';

	}, "La fecha no puede estar vacia");

	$.validator.addMethod("patron_numeros", function (value, element) {

	    var pattern = /^[0-9]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "El campo debe tener un valor numérico (0-9)");
    
    $.validator.addMethod("patron_numerosLetras", function (value, element) {

	    var pattern = /^[a-zA-Z0-9-]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "El campo debe tener un valor Alfa Numérico (a-zA-Z0-9)");

	$.validator.addMethod("patron_numerosTexto", function (value, element) {

	    var pattern = /^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "Caracteres Especiales No Admitidos");

	$.validator.addMethod("patron_lugaraproximado", function (value, element) {

	    var pattern = /^[A-Za-z0-9#ñÑáéíóúÁÉÍÓÚ .-]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "Caracteres Especiales No Admitidos");

	$.validator.addMethod("patron_texto", function (value, element) {

	    var pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ .]+$/;
	    return this.optional(element) || pattern.test(value);

	}, "Caracteres Especiales No Admitidos");

	$.validator.addMethod("patron_textoEspecial", function (value, element) {

	    var pattern = /^[^"'&%${}]*$/;
	    return this.optional(element) || pattern.test(value);

	}, "Caracteres Especiales No Admitidos");

	$.validator.addMethod("patron_nro_documento", function (value, element) {

	    var pattern =  /^((([0-9]{5,10})-+([1-9]{1}[a-zA-Z-]{1})-+([a-zA-Z]{2}))|(([0-9]{5,10})-+([a-zA-Z]){2})|(NO TIENE))$/gi;
	    return this.optional(element) || pattern.test(value);

	}, "El campo debe contener letras (123458-1P-PT 1234568-PT NO TIENE)");


	/*=============================================
	FICHA EPIDEMIOLOGICA
	=============================================*/	
    
    //VALIDANDO DATOS DE FICHA EPIDEMIOLOGICA

 	$("#fichaEpidemiologicaCentro").validate({
        debug: true,
		rules: {
			// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
	     
			nuevoEstablecimiento   : {required: true},
			nuevoCodEstablecimiento: {required: true},
			nuevoConsultorio       : {required: true},
			nuevoRedSalud          : {required: true, /*patron_letras: true*/},
			nuevoDepartamento      : {required: true},
			municipio              : {required: true},
			subsector              : {required: true},
			nuevoFechaNotificacion : {required: true},
			nuevoSemEpidemiologica : {required: true, /*number: true*/},
			nuevoBusquedaActiva    : {required: true},
	
			 // 2. IDENTIFICACIÓN DEL CASO PACIENTE
	
			nuevoCodAsegurado    :{required:true},
			nuevoCodAfiliado    :{required:true},
			nuevoCodEmpleador    :{required:true},
			nuevoNombreEmpleador    :{required:true},
			nuevoPaternoPaciente    :{required:false},
			nuevoMaternoPaciente    :{required:false},
			nuevoNombrePaciente    :{required:true},
			nuevoSexoPaciente    :{required:true},
			nuevoNroDocumentoPaciente    :{required:true, patron_nro_documento: true},
			nuevoFechaNacPaciente    :{required:true},
			nuevoEdadPaciente    :{required:true},
			identificacionEtnica    :{required:false},
			paisProcedencia    :{required:true},
			residenciaActual    :{required:true},
			nuevoProvincia    :{required:true},
			nuevoMunicipio    :{required:true},
			nuevoZonaPaciente    :{required:true,  patron_numerosTexto: true},
			nuevoCallePaciente    :{required:true,  patron_numerosTexto: true},
			nuevoNroCallePaciente    :{required:true, patron_numerosTexto: true},
			nuevoTelefonoPaciente    :{required:true},
			nuevoEmailPaciente    :{required:false},
			nuevoNombreApoderado    :{required:true, patron_letras_espacios:true},
			nuevoTelefonoApoderado    :{required:true, patron_numerosTexto: true},	
	
			 // 3. ANTECEDENTES EPIDEMIOLOGICOS
	
			ocupacion   :  {required:true},
			nuevoContactoCovid   :  {
				required : true,
				patron_elegir: true
			},
			nuevoFechaContactoCovid   :  {
				required:function(){
					if($('#nuevoContactoCovid option:selected').val() == 'SI')
						return true;
					else return false;
				},
				fecha_vacia:function(){
					if($('#nuevoContactoCovid option:selected').val() == 'SI')
						return true;
					else return false;
				}				
			},
			covidPositivoAntes   :  {
				required:true,
				patron_elegir: true
			},
			covidPositivoAntesFecha   :  {
				required:function(){
					if($('#covidPositivoAntes option:selected').val() == 'SI')
						return true;
					else return false;
				},
				fecha_vacia:function(){
					if($('#covidPositivoAntes option:selected').val() == 'SI')
						return true;
					else return false;
				}
			},
			paisInfeccion   :  {required:true},
			departamentoProbableInfeccion   :  {required:true},
			provinciaProbableInfeccion   :  {
				required:function(){
					//si esta selccionado Bolivia
					if($('#paisInfeccion option:selected').val() == '1')
						return true;
					else return false;
				},
				patron_elegir:function(){
					//si esta selccionado Bolivia
					if($('#paisInfeccion option:selected').val() == '1')
						return true;
					else return false;
				}
			},
			municipioProbableInfeccion   :  {required:true},
			lugaraproximado   :  {
				required:function(){
					if($('#paisInfeccion option:selected').val() != '1')
						return true;
					else return false;
				},
				patron_lugaraproximado: true
			},
			otroOcupacion : {
				required : function(){
					if($('#ocupacion option:selected').val() == 'OTRO'){
							//console.log("OTRO SELECCIONADO");
							return true;
					}
					else return false;				
				}
			},
	
			 // 4. DATOS CLÍNICOS
	
			nuevoPasienteAsintomatico  :  {
				required: function(){
					if($('#nuevoPasienteAsintomatico').prop('checked'))
						return false;
					else if ($('#nuevoPasienteSintomatico').prop('checked'))
								return false;
						 else return true;		
				}
			},
			nuevoPasienteSintomatico  :  {
				required: function(){
					if($('#nuevoPasienteAsintomatico').prop('checked'))
						return false;
					else if ($('#nuevoPasienteSintomatico').prop('checked'))
								return false;
						 else return true;		
				}
			},
			nuevoFechaInicioSintomas  :  {required:true},
			nuevoMalestaresTos  :  {required:false},
			nuevoMalestaresFiebre  :  {required:false},
			nuevoMalestaresGeneral  :  {required:false},
			nuevoMalestaresCefalea  :  {required:false},
			nuevoMalestaresDifRespiratoria  :  {required:false},
			nuevoMalestaresMialgias  :  {required:false},
			nuevoMalestaresDolorGaraganta  :  {required:false},
			nuevoMalestaresPerdOlfato  :  {required:false},
			nuevoMalestaresOtros  :  {required:false, patron_numerosTexto: true},
			nuevoEstadoPaciente  :  {required:true},
			nuevoFechaDefuncion  :  {required:false},
			nuevoDiagnosticoClinico  :  {required:true, patron_texto: false},
	        
			 // 5. DATOS HOSPITALIZACIÓN AISLAMIENTO
	
			ambulatorio  :  {
				required: function(){
					if($('#ambulatorio').prop('checked'))
						return false;
					else if ($('#internado').prop('checked'))
								return false;
						 else return true;		
				}
			},
			internado  :  {
				required: function(){
					if($('#ambulatorio').prop('checked'))
						return false;
					else if ($('#internado').prop('checked'))
								return false;
						 else return true;		
				}
			},
			nuevoFechaAislamiento  :  {
				required: function(){
					if ($('#ambulatorio').prop('checked'))
						return true;
					else return false;
				}
			},
			nuevoFechaInternacion  :  {
				required:true
			},
			nuevoLugarAislamiento  :  {
				required: function(){
					if ($('#ambulatorio').prop('checked'))
						return true;
					else return false;
				}, 
				patron_numerosTexto: true
			},
			nuevoEstablecimientoInternacion  :  {
				required:true, patron_numerosTexto: true
			},
			nuevoVentilacionMecanica  :  {
				required : function(){
					if ($('#internado').prop('checked'))
						return true;
					else return false;
				},
				patron_elegir: function(){
					if ($('#internado').prop('checked'))
						return true;
					else return false;
				}
			},
			nuevoTerapiaIntensiva  :  {
				required : function(){
					if ($('#internado').prop('checked'))
						return true;
					else return false;
				},
				patron_elegir: function(){
					if ($('#internado').prop('checked'))
						return true;
					else return false;
				}
			},
			nuevoFechaIngresoUTI  :  {
				required: function(){
					if($('#nuevoTerapiaIntensiva option:selected').val() == 'SI')
						return true;
					else return false;
				}
			},
	
			 // 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO
	
			checkPresenta : {
				required: function(){
					if($('#checkPresenta').prop('checked'))
						return false;
					else if ($('#checkNoPresenta').prop('checked'))
								return false;
						 else return true;		
				}
			},
			checkNoPresenta : {
				required: function(){
					if($('#checkPresenta').prop('checked'))
						return false;
					else if ($('#checkNoPresenta').prop('checked'))
								return false;
						 else return true;		
				}
			},
			nuevoHipertensionArterial  : {required:false},
			nuevoObesidad  : {required:false},
			nuevoDiabetes  : {required:false},
			nuevoEmbarazo  : {required:false},
			nuevoEnfOnco  : {required:false},
			nuevoEnfCardiaca  : {required:false},
			nuevoEnfRespiratoria  : {required:false},
			nuevoEnfRenalCronica  : {required:false},
			nuevoEnfRiesgoOtros  : {required:false,  patron_numerosTexto: true},
	
	
			 // 7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO
			 
			 tablaPersonasContactos : {required:true},
			 
			 // 8. LABORATORIO
	
			 tomoMuestraLaboratorioSi  :  {required:false},
			 tomoMuestraLaboratorioNo  :  {required:false},
			 rechazoMuestra  :  {required:false},
			 nuevoTipoMuestra  :  {required:false, patron_texto: false},
			 nuevoNombreLaboratorio  :  {required:false},
			 nuevoFechaMuestra  :  {required:false},
			 nuevoFechaEnvio  :  {required:false},
			 nuevoObsMuestra  :  {required:false},
	
			 // 10. DATOS DEL PERSONAL QUE NOTIFICA
	
			 nuevoPaternoNotif  :  {required:false, patron_texto: true},
			 nuevoMaternoNotif  :  {required:false,  patron_texto: true},
			 nuevoNombreNotif  :  {required:false, patron_texto: true},
			 nuevoTelefonoNotif  :  {required:false, minlength: 7, /* patron_numeros: true */},
			 nuevoCargoNotif  :  {required:false,  patron_numerosTexto: true}
			 
		},
	
		messages: {
			// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
	
				nuevoEstablecimiento: "Elija un nuevoEstablecimiento",
				nuevoCodEstablecimiento: "Elija un nuevoCodEstablecimiento",
				nuevoConsultorio: "Elija un nuevoConsultorio",
				nuevoRedSalud       : "Elija un nuevoRedSalud       ",
				nuevoDepartamento: "Elija un nuevoDepartamento",
				municipio      : "Elija un municipio      ",
				subsector: "Elija un subsector",
				nuevoFechaNotificacion: "Elija un nuevoFechaNotificacion",
				nuevoSemEpidemiologica: "Elija un nuevoSemEpidemiologica",
				nuevoBusquedaActiva: "Elija un nuevoBusquedaActiv",
	
			   // 2. IDENTIFICACIÓN DEL CASO PACIENTE
				nuevoCodAsegurado  : "Elija un nuevoCodAsegurado",
				nuevoCodAfiliado  : "Elija un nuevoCodAfiliado",
				nuevoCodEmpleador  : "Elija un nuevoCodEmpleador",
				nuevoNombreEmpleador  : "Elija un nuevoNombreEmpleador",
				nuevoPaternoPaciente  : "Elija un nuevoPaternoPaciente",
				nuevoMaternoPaciente  : "Elija un nuevoMaternoPaciente",
				nuevoNombrePaciente  : "Elija un nuevoNombrePaciente",
				nuevoSexoPaciente  : "Elija un nuevoSexoPaciente",
				nuevoNroDocumentoPaciente  : "Elija un nuevoNroDocumentoPaciente",
				nuevoFechaNacPaciente  : "Elija un nuevoFechaNacPaciente",
				nuevoEdadPaciente  : "Elija un nuevoEdadPaciente",
				identificacionEtnica  : "Elija un identificacionEtnica",
				paisProcedencia  : "Elija un paisProcedencia",
				residenciaActual  : "Elija un residenciaActual",
				nuevoProvincia  : "Elija un nuevoProvincia",
				nuevoMunicipio  : "Elija un nuevoMunicipio",
				nuevoZonaPaciente  : {
						required: "Elija un nuevoZonaPaciente",
						patron_numerosTexto: "ingrese el patron correcto"
				},
				nuevoCallePaciente  : "Elija un nuevoCallePaciente",
				nuevoNroCallePaciente  : "Elija un nuevoNroCallePaciente",
				nuevoTelefonoPaciente  : "Elija un nuevoTelefonoPaciente",
				nuevoEmailPaciente  : "Elija un nuevoEmailPaciente",
				nuevoNombreApoderado  : "Elija un nuevoNombreApoderado",
				nuevoTelefonoApoderado  : "Elija un nuevoTelefonoApoderado",
	
			   // 3. ANTECEDENTES EPIDEMIOLOGICOS
				ocupacion :  "Elija un ocupacion",
				nuevoContactoCovid  :  "Elija un nuevoContactoCovid",
				nuevoFechaContactoCovid  :  "Elija un nuevoFechaContactoCovid",
				covidPositivoAntes  :  "Elija un covidPositivoAntes",
				covidPositivoAntesFecha  :  "Elija un covidPositivoAntesFecha",
				covidPositivoAntes  :  "Elija un covidPositivoAntes",
				covidPositivoAntesFecha  :  "Elija un covidPositivoAntesFecha",
				paisInfeccion  :  "Elija un paisInfeccion",
				departamentoProbableInfeccion  :  "Elija un departamentoProbableInfeccion",
				provinciaProbableInfeccion  :  "Elija un provinciaProbableInfeccion",
				municipioProbableInfeccion  :  "Elija un municipioProbableInfeccion",
				lugaraproximado  :  "Elija un lugaraproximado",
	
			   // 4. DATOS CLÍNICOS
	
			   nuevoPasienteAsintomatico  : "Elija una opcion",
			   nuevoPasienteSintomatico  : "",
			   nuevoFechaInicioSintomas  : "Elija un nuevoFechaInicioSintomas",
			   nuevoMalestaresTos  : "Elija un nuevoMalestaresTos",
			   nuevoMalestaresFiebre  : "Elija un nuevoMalestaresFiebre",
			   nuevoMalestaresGeneral  : "Elija un nuevoMalestaresGeneral",
			   nuevoMalestaresCefalea  : "Elija un nuevoMalestaresCefalea",
			   nuevoMalestaresDifRespiratoria  : "Elija un nuevoMalestaresDifRespiratoria",
			   nuevoMalestaresMialgias  : "Elija un nuevoMalestaresMialgias",
			   nuevoMalestaresDolorGaraganta  : "Elija un nuevoMalestaresDolorGaraganta",
			   nuevoMalestaresPerdOlfato  : "Elija un nuevoMalestaresPerdOlfato",
			   nuevoMalestaresOtros  : "Elija un nuevoMalestaresOtros",
			   nuevoEstadoPaciente  : "Elija un nuevoEstadoPaciente",
			   nuevoFechaDefuncion  : "Elija un nuevoFechaDefuncion",
			   nuevoDiagnosticoClinico  : "Elija un nuevoDiagnosticoClinico",
	
			   // 5. DATOS HOSPITALIZACIÓN AISLAMIENTO
				ambulatorio  : "Elija una opcion",
				internado  : "",
				nuevoFechaAislamiento  : "Elija un nuevoFechaAislamiento",
				nuevoFechaInternacion  : "Elija un nuevoFechaInternacion",
				nuevoLugarAislamiento  : "Elija un nuevoLugarAislamiento",
				nuevoEstablecimientoInternacion  : "Elija un nuevoEstablecimientoInternacion",
				nuevoVentilacionMecanica  : "Elija un nuevoVentilacionMecanica",
				nuevoTerapiaIntensiva  : "Elija un nuevoTerapiaIntensiva",
				nuevoFechaIngresoUTI  : "Elija un nuevoFechaIngresoUTI",
	
			   // 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO
			   checkPresenta  :  "Elija una opcion",
			   checkNoPresenta  :  "",
				nuevoHipertensionArterial  :  "Elija un nuevoHipertensionArterial",
				nuevoObesidad  :  "Elija un nuevoObesidad",
				nuevoDiabetes  :  "Elija un nuevoDiabetes",
				nuevoEmbarazo  :  "Elija un nuevoEmbarazo",
				nuevoEnfOnco  :  "Elija un nuevoEnfOnco",
				nuevoEnfCardiaca  :  "Elija un nuevoEnfCardiaca",
				nuevoEnfRespiratoria  :  "Elija un nuevoEnfRespiratoria",
				nuevoEnfRenalCronica  :  "Elija un nuevoEnfRenalCronica",
				nuevoEnfRiesgoOtros	  :  "Elija un nuevoEnfRiesgoOtros",
	
				// 7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO  
	
				tablaPersonasContactos : "Elija un tablaPersonasContactos",
	
			   // 8. LABORATORIO
			   tomoMuestraLaboratorioSi  : "Elija tomoMuestraLaboratorioSi",
			   tomoMuestraLaboratorioNo  : "Elija tomoMuestraLaboratorioNo",
			   rechazoMuestra  : "Elija rechazoMuestra",
			   nuevoTipoMuestra  : "Elija nuevoTipoMuestra",
			   nuevoNombreLaboratorio  : "Elija nuevoNombreLaboratorio",
			   nuevoFechaMuestra  : "Elija nuevoFechaMuestra",
			   nuevoFechaEnvio  : "Elija nuevoFechaEnvio",
			   nuevoObsMuestra  : "Elija nuevoObsMuestra",
	
			   // 9. RESULTADOS 
	
				pcrTiempoReal  :  "Elija un pcrTiempoReal",            
				pcrGenExpert  :  "Elija un pcrGenExpert",
				pruebaAntigenica  :  "Elija un pruebaAntigenica",
				positivo  :  "Elija un positivo",
				negativo  :  "Elija un negativo",
				nuevoFechaResultado  :  "Elija un nuevoFechaResultado",
	
			  // 10. DATOS DEL PERSONAL QUE NOTIFICA: 	
	
				nuevoPaternoNotif  : "Elija un nuevoPaternoNotif",
				nuevoMaternoNotif  : "Elija un nuevoMaternoNotif",
				nuevoNombreNotif  : "Elija un nuevoNombreNotif",
				nuevoTelefonoNotif  : "Elija un nuevoTelefonoNotif",
				nuevoCargoNotif  : "Elija un nuevoCargoNotif",
	
		},
	
		errorPlacement: function(label, element) {

			element.css('background', '#ffdddd');
			if (element.attr("name") == "nuevoPasienteAsintomatico" || element.attr("name") == "nuevoPasienteSintomatico"
			    || element.attr("name") == "ambulatorio" || element.attr("name") == "internado"
				|| element.attr("name") == "checkPresenta" || element.attr("name") == "checkNoPresenta") {

				label.addClass('errorMsq');
				element.parent().append(label)
				//element.parent().parent().append(label);
	
			} 
			else {
				//label.addClass('errorMsq');
				//element.parent().append(label);
			}
	
		},

		unhighlight: function(element){
			$(element).removeClass('error').addClass('valido');
		},

		highlight: function(element) {
			$(element).removeClass('valido').addClass('error');
		},
	});

	//GUARDANDO DATOS DE FICHA EPIDEMIOLOGICA
/*
	$("#fichaEpidemiologicaCentro").on("click", ".btnGuardar", function() {

		
		//debugger

		if ($("#fichaEpidemiologicaCentro").valid()) {
			console.log("Validado Correctamente");	
			console.log($("#fichaEpidemiologicaCentro"));
		//     1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR 
	
				var nuevoEstablecimiento     = $('#nuevoEstablecimiento').val();       
				var nuevoCodEstablecimiento  = $('#nuevoCodEstablecimiento').val();      
				var nuevoConsultorio         = $('#nuevoConsultorio').val();             
				var nuevoRedSalud            = $('#nuevoRedSalud').val();                
				var nuevoDepartamento        = $('#nuevoDepartamento').val();            
				var municipio                = $('#municipio').val();                    
				var subsector                = $('#subsector').val();                    
				var nuevoFechaNotificaciovar = $('#nuevoFechaNotificacion').val();
				var nuevoSemEpidemiologica   = $('#nuevoSemEpidemiologica').val();   
				var nuevoBusquedaActiva      = $('#nuevoBusquedaActiva').val();   
	
		//      2. IDENTIFICACION DEL CASO/PACIENTE
	
				var nuevoCodAsegurado          =	$('#nuevoCodAsegurado').val();
				var nuevoCodAfiliado   	       =	$('#nuevoCodAfiliado').val();
				var nuevoCodEmpleador          =	$('#nuevoCodEmpleador').val();
				var nuevoNombreEmpleador       =   	$('#nuevoNombreEmpleador').val();
				var nuevoPaternoPaciente       =   	$('#nuevoPaternoPaciente').val();
				var nuevoMaternoPaciente       =   	$('#nuevoMaternoPaciente').val();
				var nuevoNombrePaciente        =  	$('#nuevoNombrePaciente').val();
				var nuevoSexoPaciente          =	$('#nuevoSexoPaciente').val();
				var nuevoNroDocumentoPaciente  = 	$('#nuevoNroDocumentoPaciente').val();
				var nuevoFechaNacPaciente      =	$('#nuevoFechaNacPaciente').val();
				var nuevoEdadPaciente          =	$('#nuevoEdadPaciente').val();
				var identificacionEtnica       =   	$('#identificacionEtnica').val();
				var paisProcedencia   		   =	$('#paisProcedencia').val();
				var residenciaActual   	       =    $('#residenciaActual').val();
				var nuevoProvincia   		   =    $('#nuevoProvincia').val();
				var nuevoMunicipio   		   =    $('#nuevoMunicipio').val();
				var nuevoZonaPaciente          =	$('#nuevoZonaPaciente').val();
				var nuevoCallePaciente         = 	$('#nuevoCallePaciente').val();
				var nuevoNroCallePaciente      =	$('#nuevoNroCallePaciente').val();
				var nuevoTelefonoPaciente      =	$('#nuevoTelefonoPaciente').val();
				var nuevoEmailPaciente         = 	$('#nuevoEmailPaciente').val();
				var nuevoNombreApoderado       =   	$('#nuevoNombreApoderado').val();
				var nuevoTelefonoApoderado     =  	$('#nuevoTelefonoApoderado').val();
	
		//   	3. ANTECEDENTES EPIDEMIOLOGICO
	
				var ocupacion                      = 	$('#ocupacion').val();
				var nuevoContactoCovid             = 	$('#nuevoContactoCovid').val();
				var nuevoFechaContactoCovid        = 	$('#nuevoFechaContactoCovid').val();
				var covidPositivoAntes             = 	$('#covidPositivoAntes').val();
				var covidPositivoAntesFecha        = 	$('#covidPositivoAntesFecha').val();
				var covidPositivoAntes             = 	$('#covidPositivoAntes').val();
				var covidPositivoAntesFecha        = 	$('#covidPositivoAntesFecha').val();
				var paisInfeccion                  = 	$('#paisInfeccion').val();
				var departamentoProbableInfeccion  = 	$('#departamentoProbableInfeccion').val();
				var provinciaProbableInfeccion     = 	$('#provinciaProbableInfeccion').val();
				var municipioProbableInfeccion     = 	$('#municipioProbableInfeccion').val();
				var lugaraproximado                = 	$('#lugaraproximado').val();
	
		//   	4. DATOS CLINICOS
	
				var nuevoPasienteAsintomatico  =  $('#nuevoPasienteAsintomatico').val();
				var nuevoPasienteSintomatico  =  $('#nuevoPasienteSintomatico').val();


				var nuevoFechaInicioSintomas  =  $('#nuevoFechaInicioSintomas').val();
				var nuevoMalestaresTos  =  $('#nuevoMalestaresTos').val();
				var nuevoMalestaresFiebre  =  $('#nuevoMalestaresFiebre').val();
				var nuevoMalestaresGeneral  =  $('#nuevoMalestaresGeneral').val();
				var nuevoMalestaresCefalea  =  $('#nuevoMalestaresCefalea').val();
				var nuevoMalestaresDifRespiratoria  =  $('#nuevoMalestaresDifRespiratoria').val();
				var nuevoMalestaresMialgias  =  $('#nuevoMalestaresMialgias').val();
				var nuevoMalestaresDolorGaraganta  =  $('#nuevoMalestaresDolorGaraganta').val();
				var nuevoMalestaresPerdOlfato  =  $('#nuevoMalestaresPerdOlfato').val();
				var nuevoMalestaresOtros  =  $('#nuevoMalestaresOtros').val();
				var nuevoEstadoPaciente  =  $('#nuevoEstadoPaciente').val();
				var nuevoFechaDefuncion  =  $('#nuevoFechaDefuncion').val();
				var nuevoDiagnosticoClinico  =  $('#nuevoDiagnosticoClinico').val();
	
	
		//		5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO
	
				var ambulatorio =  $('#ambulatorio').val();                          
				var internado  =  $('#internado').val();


				var nuevoFechaAislamiento  =  $('#nuevoFechaAislamiento').val();
				var nuevoFechaInternacion  =  $('#nuevoFechaInternacion').val();
				var nuevoLugarAislamiento  =  $('#nuevoLugarAislamiento').val();
				var nuevoEstablecimientoInternacion  =  $('#nuevoEstablecimientoInternacion').val();
				var nuevoVentilacionMecanica  =  $('#nuevoVentilacionMecanica').val();
				var nuevoTerapiaIntensiva  =  $('#nuevoTerapiaIntensiva').val();
				var nuevoFechaIngresoUTI  =  $('#nuevoFechaIngresoUTI').val();
	
		//      6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO
	
				var presenta  =  $('#presenta').val();
				var noPresenta  =  $('#noPresenta').val();


				var nuevoHipertensionArterial  =  $('#nuevoHipertensionArterial').val();
				var nuevoObesidad  =  $('#nuevoObesidad').val();
				var nuevoDiabetes  =  $('#nuevoDiabetes').val();
				var nuevoEmbarazo  =  $('#nuevoEmbarazo').val();
				var nuevoEnfOnco  =  $('#nuevoEnfOnco').val();
				var nuevoEnfCardiaca  =  $('#nuevoEnfCardiaca').val();
				var nuevoEnfRespiratoria  =  $('#nuevoEnfRespiratoria').val();
				var nuevoEnfRenalCronica  =  $('#nuevoEnfRenalCronica').val();
				var nuevoEnfRiesgoOtros  =  $('#nuevoEnfRiesgoOtros').val();
	
		//      7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO (desde el inicio de los sintomas)
	
				$('#tablaPersonasContactos').val();
	
		//       8. LABORATORIO
	
				var tomoMuestraLaboratorioSi  =  $('#tomoMuestraLaboratorioSi').val();
				var tomoMuestraLaboratorioNo  =  $('#tomoMuestraLaboratorioNo').val();
				var rechazoMuestra  =  $('#rechazoMuestra').val();
				var nuevoTipoMuestra  =  $('#nuevoTipoMuestra').val();
				var nuevoNombreLaboratorio  =  $('#nuevoNombreLaboratorio').val();
				var nuevoFechaMuestra  =  $('#nuevoFechaMuestra').val();
				var nuevoFechaEnvio  =  $('#nuevoFechaEnvio').val();
				var nuevoObsMuestra  =  $('#nuevoObsMuestra').val();
	
		//      9. RESULTADOS
	
				 var pcrTiempoReal  = $('#pcrTiempoReal').val();              
				 var pcrGenExpert  = $('#pcrGenExpert').val();
				 var pruebaAntigenica  = $('#pruebaAntigenica').val();
				 var positivo  = $('#positivo').val();
				 var negativo  = $('#negativo').val();
				 var nuevoFechaResultado  = $('#nuevoFechaResultado').val();
	
		//      10. DATOS DEL PERSONAL QUE NOTIFICA
	
				var nuevoPaternoNotif  =  $('#nuevoPaternoNotif').val()
				var nuevoMaternoNotif  =  $('#nuevoMaternoNotif').val()
				var nuevoNombreNotif  =  $('#nuevoNombreNotif').val()
				var nuevoTelefonoNotif  =  $('#nuevoTelefonoNotif').val()
				var nuevoCargoNotif  =  $('#nuevoCargoNotif').val()
		//------------------------------------------------------------------------------------------------------------------  
		//      PREPARANDO TODOS LOS DATOS PARA ENVIAR AL SERVIDOR
	
				var datos = new FormData();
				datos.append("guardarFichaEpidemiologica", 'guardarFichaEpidemiologica');	
				datos.append("id_ficha", $("#idFicha").val());
			//	1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR  (todos deberian ser requeridos  )
	
				datos.append("nuevoEstablecimiento", nuevoEstablecimiento);
				datos.append("nuevoCodEstablecimiento", nuevoCodEstablecimiento);
				datos.append("nuevoConsultorio", nuevoConsultorio);
				datos.append("nuevoRedSalud", nuevoRedSalud);
				datos.append("nuevoDepartamento", nuevoDepartamento);
				datos.append("municipio", municipio);
				datos.append("subsector", subsector);
				datos.append("nuevoFechaNotificacion", nuevoFechaNotificacion);
				datos.append("nuevoSemEpidemiologica", nuevoSemEpidemiologica);
				datos.append("nuevoBusquedaActiva ", nuevoBusquedaActiva );
	
			//	2. IDENTIFICACION DEL CASO/PACIENTE
	
				datos.append("nuevoCodAsegurado", nuevoCodAsegurado);
				datos.append("nuevoCodAfiliado", nuevoCodAfiliado);
				datos.append("nuevoCodEmpleador", nuevoCodEmpleador);
				datos.append("nuevoNombreEmpleador", nuevoNombreEmpleador);
				datos.append("nuevoPaternoPaciente", nuevoPaternoPaciente);
				datos.append("nuevoMaternoPaciente", nuevoMaternoPaciente);
				datos.append("nuevoNombrePaciente", nuevoNombrePaciente);
				datos.append("nuevoSexoPaciente", nuevoSexoPaciente);
				datos.append("nuevoNroDocumentoPaciente", nuevoNroDocumentoPaciente);
				datos.append("nuevoFechaNacPaciente", nuevoFechaNacPaciente);
				datos.append("nuevoEdadPaciente", nuevoEdadPaciente);
				datos.append("identificacionEtnica", identificacionEtnica);
				datos.append("paisProcedencia", paisProcedencia);
				datos.append("residenciaActual", residenciaActual);
				datos.append("nuevoProvincia", nuevoProvincia);
				datos.append("nuevoMunicipio", nuevoMunicipio);
				datos.append("nuevoZonaPaciente", nuevoZonaPaciente);
				datos.append("nuevoCallePaciente", nuevoCallePaciente);
				datos.append("nuevoNroCallePaciente", nuevoNroCallePaciente);
				datos.append("nuevoTelefonoPaciente", nuevoTelefonoPaciente);
				datos.append("nuevoEmailPaciente", nuevoEmailPaciente);
				datos.append("nuevoNombreApoderado", nuevoNombreApoderado);
				datos.append("nuevoTelefonoApoderado", nuevoTelefonoApoderado);
	
		   //   3. ANTECEDENTES EPIDEMIOLOGICO
	
				datos.append("ocupacion",ocupacion);
				datos.append("nuevoContactoCovid",nuevoContactoCovid);
				datos.append("nuevoFechaContactoCovid",nuevoFechaContactoCovid);
				datos.append("covidPositivoAntes",covidPositivoAntes);
				datos.append("covidPositivoAntesFecha",covidPositivoAntesFecha);
				datos.append("covidPositivoAntes",covidPositivoAntes);
				datos.append("covidPositivoAntesFecha",covidPositivoAntesFecha);
				datos.append("paisInfeccion",paisInfeccion);
				datos.append("departamentoProbableInfeccion",departamentoProbableInfeccion);
				datos.append("provinciaProbableInfeccion",provinciaProbableInfeccion);
				datos.append("municipioProbableInfeccion",municipioProbableInfeccion);
				datos.append("lugaraproximado",lugaraproximado);
	
		   //	4. DATOS CLINICOS
	
			// datos.append("nuevoPasienteAsintomatico",nuevoPasienteAsintomatico);
			//	datos.append("nuevoPasienteSintomatico",nuevoPasienteSintomatico);
 
                datos.append("sintomatico_o_asintomatico","ASINTOMATICO");

				datos.append("nuevoFechaInicioSintomas",nuevoFechaInicioSintomas);
				datos.append("nuevoMalestaresTos",nuevoMalestaresTos);
				datos.append("nuevoMalestaresFiebre",nuevoMalestaresFiebre);
				datos.append("nuevoMalestaresGeneral",nuevoMalestaresGeneral);
				datos.append("nuevoMalestaresCefalea",nuevoMalestaresCefalea);
				datos.append("nuevoMalestaresDifRespiratoria",nuevoMalestaresDifRespiratoria);
				datos.append("nuevoMalestaresMialgias",nuevoMalestaresMialgias);
				datos.append("nuevoMalestaresDolorGaraganta",nuevoMalestaresDolorGaraganta);
				datos.append("nuevoMalestaresPerdOlfato",nuevoMalestaresPerdOlfato);
				datos.append("nuevoMalestaresOtros",nuevoMalestaresOtros);
				datos.append("nuevoEstadoPaciente",nuevoEstadoPaciente);
				datos.append("nuevoFechaDefuncion",nuevoFechaDefuncion);
				datos.append("nuevoDiagnosticoClinico",nuevoDiagnosticoClinico);
	
	
		   //   5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO
	
   // 				datos.append("ambulatorio",ambulatorio);
		//		datos.append("internado",internado); 

				datos.append("ambulatorio_o_internado","AMBULATORIO");


				datos.append("nuevoFechaAislamiento",nuevoFechaAislamiento);
				datos.append("nuevoFechaInternacion",nuevoFechaInternacion);
				datos.append("nuevoLugarAislamiento",nuevoLugarAislamiento);
				datos.append("nuevoEstablecimientoInternacion",nuevoEstablecimientoInternacion);
				datos.append("nuevoVentilacionMecanica",nuevoVentilacionMecanica);
				datos.append("nuevoTerapiaIntensiva",nuevoTerapiaIntensiva);
				datos.append("nuevoFechaIngresoUTI",nuevoFechaIngresoUTI);
	
		   //   6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO
	
				// datos.append("presenta",presenta);
				//datos.append("noPresenta",noPresenta); 

				datos.append("presenta_o_noPresenta","PRESENTA");


				datos.append("nuevoHipertensionArterial",nuevoHipertensionArterial);
				datos.append("nuevoObesidad",nuevoObesidad);
				datos.append("nuevoDiabetes",nuevoDiabetes);
				datos.append("nuevoEmbarazo",nuevoEmbarazo);
				datos.append("nuevoEnfOnco",nuevoEnfOnco);
				datos.append("nuevoEnfCardiaca",nuevoEnfCardiaca);
				datos.append("nuevoEnfRespiratoria",nuevoEnfRespiratoria);
				datos.append("nuevoEnfRenalCronica",nuevoEnfRenalCronica);
				datos.append("nuevoEnfRiesgoOtros",nuevoEnfRiesgoOtros);
	
		   //   7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO 
	
				datos.append("tablaPersonasContactos",tablaPersonasContactos)
	
		   //	8. LABORATORIO
	
				datos.append("tomoMuestraLaboratorioSi",tomoMuestraLaboratorioSi);
				datos.append("tomoMuestraLaboratorioNo",tomoMuestraLaboratorioNo);
				datos.append("rechazoMuestra",rechazoMuestra);
				datos.append("nuevoTipoMuestra",nuevoTipoMuestra);
				datos.append("nuevoNombreLaboratorio",nuevoNombreLaboratorio);
				datos.append("nuevoFechaMuestra",nuevoFechaMuestra);
				datos.append("nuevoFechaEnvio",nuevoFechaEnvio);
				datos.append("nuevoObsMuestra",nuevoObsMuestra);
	
			//	9. RESULTADOS
	
				datos.append("pcrTiempoReal",pcrTiempoReal);
				datos.append("pcrGenExpert",pcrGenExpert);
				datos.append("pruebaAntigenica",pruebaAntigenica);
				datos.append("positivo",positivo);
				datos.append("negativo",negativo);
				datos.append("nuevoFechaResultado",nuevoFechaResultado);
	
			//	10. DATOS DEL PERSONAL QUE NOTIFICA:
	
				datos.append("nuevoPaternoNotif",nuevoPaternoNotif);
				datos.append("nuevoMaternoNotif",nuevoMaternoNotif);
				datos.append("nuevoNombreNotif",nuevoNombreNotif);
				datos.append("nuevoTelefonoNotif",nuevoTelefonoNotif);
				datos.append("nuevoCargoNotif",nuevoCargoNotif);
	
	            //debugger
				$.ajax({
		
					url:"ajax/fichas.ajax.php",
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "html",
					success: function(respuesta) {
						console.log("respuesta", respuesta);
					
						if (respuesta == "ok") {
		
							swal.fire({
								
								icon: "success",
								title: "¡Los datos se guardaron correctamente!",
								showConfirmButton: true,
								allowOutsideClick: false,
								confirmButtonText: "Cerrar"
		
							}).then((result) => {
								  
								  if (result.value) {
		
									  window.location = "ficha-epidemiologica";
		
								}
		
							});
		
						} else {
		
							swal.fire({
									
								title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!",
								icon: "error",
								allowOutsideClick: false,
								confirmButtonText: "¡Cerrar!"
		
							});
							
						}
		
					},
					error: function(error) {
		
						console.log("No funciona");
						
					}
		
				});		
				
		}
		else {
	
			swal.fire({
								
				title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales, por favor revise el formulario!",
				icon: "error",
				allowOutsideClick: false,
				confirmButtonText: "¡Cerrar!"
	
			});
		}
	
	});
*/

	//GUARDANDO DATOS DE FICHA EPIDEMIOLOGICA DINAMICAMENTE

	$("#fichaEpidemiologicaCentro").ready(function() {
		
		var id_ficha = $ ("#idFicha").val();
		//console.log("id_ficha", id_ficha);
		var item = "";
		var valor = "";
		var tabla = "";

		// 1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR

    	$("#nuevoEstablecimiento").change(function() {
			item = "id_establecimiento";
			valor = $(this).val();
			//console.log(valor);
			tabla = "fichas";
			codigoEstablecimiento = $("#nuevoEstablecimiento option:selected").data("codestablecimiento");
			
			// ACTUALIZAMOS EL CODIGO_ESTABLECIMIENTO DE LA TABLA FICHA
			actualizarCampoFicha(id_ficha,'cod_establecimiento', codigoEstablecimiento, tabla);

			// ACTUALIZAMOS EL ID_ESTABLECIMIENTO DE LA TABLA FICHA
             
			actualizarCampoFicha(id_ficha, item, valor, tabla);

			// SI EL VALOR ELEGIDO ES DIFERENTE DE POLICLINICO 10 DE NOVIEMBRE SE BORRA EL VALOR DE CONSULTORIO

	/*		if (valor != "2") {
				alert("entro aqui");

				item = "id_consultorio";
				valor = "";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

			}*/

		});

		$("#nuevoCodEstablecimiento").change(function() {

			item = "cod_establecimiento";
			valor = $(this).val();
			tabla = "fichas";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoConsultorio").change(function() {
/* 
			item = "id_consultorio";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla) */
			
			//ACTUALIZAMOS EL ID_CONSULTORIO EN LA TABLA FICHA
			
			idConsul = $("#nuevoConsultorio option:selected").val();
			actualizarCampoFicha(id_ficha,'id_consultorio', idConsul, 'fichas');

		});

		$("#nuevoRedSalud").change(function() {
            alert("hola entro aqui");
			item = "red_salud";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoDepartamento").change(function() {

			item = "id_departamento";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoLocalidad").change(function() {

			item = "id_localidad";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaNotificacion").change(function() {

			item = "fecha_notificacion";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoSemEpidemiologica").change(function() {

			item = "semana_epidemiologica";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoBusquedaActiva").change(function() {

			item = "busqueda_activa";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoBusquedaActiva").change(function() {

			item = "busqueda_activa";
			valor = $(this).val();
			tabla = "fichas"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		// 2. IDENTIFICACION DEL CASO/PACIENTE

		$("#nuevoSexoPaciente").change(function() {
            
			item = "sexo";
			valor = $(this).val();
			tabla = "pacientes_asegurados";
			if(valor!=""){
				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
				
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}

		});

		$("#nuevoNroDocumentoPaciente").change(function() {
			item = "nro_documento";
			valor = $(this).val();
			tabla = "pacientes_asegurados";			
			var validar = /^((([0-9]{5,10})-+([1-9]{1}[a-zA-Z-]{1})-+([a-zA-Z]{2}))|(([0-9]{5,10})-+([a-zA-Z]){2})|(NO TIENE))$/gi;
			if(valor!="" && validar.test(valor)){
				actualizarCampoFicha(id_ficha, item, valor, tabla)
			}

		});	
		
	 	/* $('#nuevoNroDocumentoPaciente').keypress(function(event){
			var validar = /^((([0-9]{5,10})-+([1-9]{1}[a-zA-Z-]{1})-+([a-zA-Z]{2}))|(([0-9]{5,10})-+([a-zA-Z]){2})|(NO TIENE))$/gi;
			var letra = event.key; 
			if(!validar.test(letra)){
				event.preventDefault();
				//return false;
			}			
			
		});  */

		$("#nuevoDepartamentoPaciente").change(function() {

			item = "id_departamento_paciente";
			valor = $(this).val();
			tabla = "pacientes_asegurados";			
			if(valor!=""){
				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
				actualizarCampoFicha(id_ficha, item, valor, tabla)
			}
		});

		$("#nuevoLocalidadPaciente").change(function() {

			item = "id_localidad_paciente";
			valor = $(this).val();
			tabla = "pacientes_asegurados";			
			if(valor!=""){
				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
				actualizarCampoFicha(id_ficha, item, valor, tabla)
			}

		});

		$("#nuevoPaisPaciente").change(function() {

			item = "id_pais_paciente";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoZonaPaciente").change(function() {

			item = "zona";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoCallePaciente").change(function() {

			item = "calle";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoNroCallePaciente").change(function() {

			item = "nro_calle";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoTelefonoPaciente").change(function() {

			item = "telefono";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoEmailPaciente").change(function() {

			item = "email";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoNombreApoderado").change(function() {

			item = "nombre_apoderado";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA			
			var validar = /^[a-zA-Z\s]+$/;
			if(valor!="" && validar.test(valor)){
				actualizarCampoFicha(id_ficha, item, valor, tabla)
			}

		});

		// KEYPRESS PARA QUE EN EL CAMPO SOLO RECIBA LETRAS
		/* $('#nuevoNombreApoderado').keypress(function(event){
			var validar = /^[a-zA-Z\s]+$/;
			var letra = event.key; 
			if(!validar.test(letra)){
				event.preventDefault();
				return false;
			}			
			
		}); */

		$("#nuevoTelefonoApoderado").change(function() {

			item = "telefono_apoderado";
			valor = $(this).val();
			tabla = "pacientes_asegurados"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		// 3. ANTECEDENTES EPIDEMIOLOGICOS

		$("#ocupacion").change(function() {

			item = "ocupacion";
			//valor = $(this).val();
			valor2 = $("#ocupacion option:selected").val();
			tabla = "ant_epidemiologicos"

			if(valor2 == 'OTRO'){
				$('#otroOcupacion').removeAttr('disabled');
				$('#otroOcupacion').css('background-color', '#ffffff');
			}
			else {
				$('#otroOcupacion').attr('disabled','disabled');
				$('#otroOcupacion').css('background-color', '#e9ecef');
			}

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA		

			actualizarCampoFicha(id_ficha, item, valor2, tabla);

		});

		$("#otroOcupacion").change(function(){
			item = "ocupacion";
			//valor = $(this).val();
			valor2 = $("#otroOcupacion").val();
			tabla = "ant_epidemiologicos";
			actualizarCampoFicha($("#idFicha").val(), item, valor2, tabla);

		});




		$("#nuevoAntVacunaInfluenza").change(function() {

			item = "ant_vacuna_influenza";
			valor = $(this).val();
			tabla = "ant_epidemiologicos"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

			// SI EL VALOR ELEGIDO ES NO SE BORRA EL VALOR DE CAMPO FECHA DE VACUNACIÒN DE INFLUENZA

			if (valor == "NO") {

				item = "fecha_vacuna_influenza";
				valor = "";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)
			}

		});

		$("#nuevoFechaVacunaInfluenza").blur(function() {

			item = "fecha_vacuna_influenza";
			valor = $(this).val();
			tabla = "ant_epidemiologicos"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoViajeRiesgo").change(function() {

			item = "viaje_riesgo";
			valor = $(this).val();
			tabla = "ant_epidemiologicos"

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

			// SI EL VALOR ELEGIDO ES NO SE BORRA LOS VALORES DE LOS CAMPOS INHABILITADOS

			if (valor == "NO") {

				item = "pais_ciudad_riesgo";
				valor = "";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

				item = "fecha_retorno";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

				item = "empresa_vuelo";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

				item = "nro_vuelo";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

				item = "nro_asiento";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

			}

		});

		$("#nuevoPaisCiudadRiesgo").change(function() {

			item = "pais_ciudad_riesgo";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaRetorno").blur(function() {

			item = "fecha_retorno";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoEmpresaVuelo").change(function() {

			item = "empresa_vuelo";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoNroVuelo").change(function() {

			item = "nro_vuelo";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoNroAsiento").change(function() {

			item = "nro_asiento";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoContactoCovid").change(function() {

			item = "contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
             if(valor != 0){
				 actualizarCampoFicha(id_ficha, item, valor, tabla)
			 }
			 
			 if(valor == 0){
				 actualizarCampoFicha(id_ficha, item,'', tabla)
			 }

			// SI EL VALOR ELEGIDO ES NO SE BORRA LOS VALORES DE LOS CAMPOS INHABILITADOS
			if (valor == "SI") {
				$('#nuevoFechaContactoCovid').removeAttr('readonly');
				$('#nuevoFechaContactoCovid').css('background-color', '#ffffff');
				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				//actualizarCampoFicha(id_ficha, item, valor, tabla)
			}
			else if (valor == "NO" || valor == "0"){				
				actualizarCampoFicha(id_ficha, 'fecha_contacto_covid','', tabla);
				$('#nuevoFechaContactoCovid').attr('value','dd/mm/aa');
				$('#nuevoFechaContactoCovid').val('dd/mm/aa');
				$('#nuevoFechaContactoCovid').removeClass('valido');
				$('#nuevoFechaContactoCovid').attr('readonly','readonly');
				$('#nuevoFechaContactoCovid').css('background-color', '#e9ecef');
			}

		});

		
		//covidPositivoAntes
		$("#nuevoFechaContactoCovid").change(function() {

			item = "fecha_contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
			$('#nuevoFechaContactoCovid').attr('value', valor);
			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoNombreContactoCovid").change(function() {

			item = "nombre_contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoTelefonoContactoCovid").change(function() {

			item = "telefono_contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoPaisContactoCovid").change(function() {

			item = "pais_contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoDepartamentoContactoCovid").change(function() {

			item = "departamento_contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoLocalidadContactoCovid").change(function() {

			item = "localidad_contacto_covid";
			valor = $(this).val();
			tabla = "ant_epidemiologicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		// 4. DATOS CLINICOS

		$("#nuevoFechaInicioSintomas").change(function() {

			item = "fecha_inicio_sintomas";
			valor = $(this).val();
			tabla = "datos_clinicos";
			if($(this)!=""){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}

		});

		$("#nuevoMalestaresOtros").change(function() {
			item = "	otros";
			valor = $(this).val();
			tabla = "malestar";
			if($(this).val()!=""){
				crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
			}
			else{
				crearMalestarDatosClinicos(id_ficha,item,"",tabla);
			}

		});

		$("#nuevoEstadoPaciente").change(function() {

			item = "estado_paciente";
			valor = $(this).val();
			tabla = "datos_clinicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

			// SI EL VALOR ELEGIDO ES LEVE SE BORRA EL VALOR DE FECHA DE DEFUNCION INHABILITADOS

			if (valor == "LEVE" || valor == "GRAVE") {

				item = "fecha_defuncion";
				valor = "";

				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

				actualizarCampoFicha(id_ficha, item, valor, tabla)

			}

		});

		$("#nuevoFechaDefuncion").change(function() {

			item = "fecha_defuncion";
			valor = $(this).val();
			tabla = "datos_clinicos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoDiagnosticoClinico").change(function() {

			item = "diagnostico_clinico";
			valor = $(this).val();
			tabla = "datos_clinicos";
			if(valor!=""){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}

		});

		// 5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO (SEGUIMIENTO)

		$("#nuevoDiasNotificacion").change(function() {

			item = "dias_notificacion";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoDiasSinSintomas").change(function() {

			item = "dias_sin_sintomas";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaAislamiento").change(function() {

			item = "fecha_aislamiento";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoLugarAislamiento").change(function() {

			item = "lugar_aislamiento";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
            if(valor.length >= 8)
			 actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaInternacion").change(function() {

			item = "fecha_internacion";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoEstablecimientoInternacion").change(function() {

			item = "establecimiento_internacion";
			
			valor = $('#nuevoEstablecimientoInternacion option:selected').text();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoVentilacionMecanica").change(function() {

			item = "ventilacion_mecanica";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoTerapiaIntensiva").change(function() {

			item = "terapia_intensiva";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			if(valor == "SI"){
				$('#nuevoFechaIngresoUTI').removeAttr('disabled');
				$('#nuevoFechaIngresoUTI').css('background-color', '#ffffff');
			}
            else{
				$('#nuevoFechaIngresoUTI').attr('disabled','disabled');
                $('#nuevoFechaIngresoUTI').attr('value','dd/mm/aa');
				$('#nuevoFechaIngresoUTI').val('dd/mm/aa');
				$('#nuevoFechaIngresoUTI').css('background-color', '#e9ecef');

				actualizarCampoFicha(id_ficha,'lugar_ingreso_UTI','','hospitalizaciones_aislamientos');
			}
			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaIngresoUTI").change(function() {

			item = "fecha_ingreso_UTI";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoLugarIngresoUTI").change(function() {

			item = "lugar_ingreso_UTI";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		var tratamiento = []; 

		$('[name="nuevoTratamiento"]').change(function() {

			if ($(this).is(":checked")) {

				tratamiento.push($(this).val());

			} else {


			}

			item = "tratamiento";
			valor = tratamiento;
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)
			
		});

		$("#nuevoTratamientoOtros").change(function() {

			item = "tratamiento_otros";
			valor = $(this).val();
			tabla = "hospitalizaciones_aislamientos";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		// 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO

		$("#nuevoHipertensionArterial").change(function(){
			item = "hipertension_arterial";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoObesidad").change(function(){
			item = "obesidad";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoDiabetes").change(function(){
			item = "diabetes_general";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoEmbarazo").change(function(){
			item = "embarazo";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoEnfOnco").change(function(){
			item = "enfermedades_oncologica";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoEnfCardiaca").change(function(){
			item = "enfermedades_cardiaca";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoEnfRespiratoria").change(function(){
			item = "enfermedad_respiratoria";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoEnfRenalCronica").change(function(){
			item = "enfermedades_renal_cronica";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).prop('checked')){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});
		$("#nuevoEnfRiesgoOtros").change(function(){
			item = "otros";
			valor = $(this).val();
			tabla = "enfermedades_bases";
			if($(this).val()!=""){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}
		});

		// 8. LABORATORIOS

		$("#rechazoMuestra").change(function() {
			item = "des_no_muestra";
			valor = $(this).val();
			tabla = "laboratorios";
			if(valor!=""){
				actualizarCampoFicha(id_ficha, item, valor, tabla);
			}
			else{
				actualizarCampoFicha(id_ficha, item, "", tabla);
			}

		});


		$("#nuevoLugarMuestra").change(function() {

			item = "id_establecimiento";
			valor = $(this).val();
			tabla = "laboratorios";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoTipoMuestra").change(function() {
			item = "tipo_muestra";
			tabla = "laboratorios";
			valor = $(this).val();
			//alert(valor);
			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaMuestra").change(function() {

			item = "fecha_muestra";
			valor = $(this).val();
			tabla = "laboratorios";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoFechaEnvio").change(function() {

			item = "fecha_envio";
			valor = $(this).val();
			tabla = "laboratorios";

			if(!$('#pruebaAntigenica').prop('checked')){
				// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
				actualizarCampoFicha(id_ficha, item, valor, tabla)
			}


		});

		$("#nuevoResponsableMuestra").change(function() {

			item = "responsable_muestra";			
			//valor = $('#nuevoResponsableMuestra option:selected').text();
			valor = $('#nuevoResponsableMuestra').val();
			//alert(valor);
			tabla = "laboratorios";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
            if(valor != 'Elegir...')
			   actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		// 9. DATOS DEL PERSONAL QUE NOTIFICA:

		$("#nuevoPaternoNotif").change(function() {

			item = "paterno_notificador";
			valor = $(this).val();
			tabla = "personas_notificadores";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoMaternoNotif").change(function() {

			item = "materno_notificador";
			valor = $(this).val();
			tabla = "personas_notificadores";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoNombreNotif").change(function() {

			item = "nombre_notificador";
			valor = $(this).val();
			tabla = "personas_notificadores";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoTelefonoNotif").change(function() {

			item = "telefono_notificador";
			valor = $(this).val();
			tabla = "personas_notificadores";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});

		$("#nuevoCargoNotif").change(function() {

			item = "cargo_notificador";
			valor = $(this).val();
			tabla = "personas_notificadores";

			// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

			actualizarCampoFicha(id_ficha, item, valor, tabla)

		});
    	
    });


	
$("#fichaEpidemiologicaCentro").on('click', ".btnGuardar", function() {
	if ($("#fichaEpidemiologicaCentro").valid()) {
		swal.fire({
									
			icon: "success",
			title: "¡Los datos se guardaron correctamente!",
			showConfirmButton: true,
			allowOutsideClick: false,
			confirmButtonText: "Aceptar"
	
		}).then((result) => {			  
			  if (result.value) {
				  resetearCamposTabla($("#idFicha").val(),'estado_ficha','1','fichas');
				  clearInterval(revisarRuta);
				  removeListenerSMS();
				  window.location = "ficha-epidemiologica";
			}
	
		});
	}
	else {
	
		swal.fire({
							
			title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales, por favor revise el formulario!",
			icon: "error",
			allowOutsideClick: false,
			confirmButtonText: "¡Cerrar!"

		});
	}

});




	//VALIDANDO DATOS DE MODAL NUEVA PERSONA CONTACTO

    $("#nuevoPersonaContacto").validate({

    	rules: {
    		nuevoPaternoContacto : { patron_texto: true},
     		nuevoMaternoContacto: { patron_texto: true},
     		nuevoNombreContacto: { required: true, patron_texto: true},
     		nuevoRelacionContacto: { required: true, patron_numerosTexto: true},
     		nuevoEdadContacto: { patron_numeros: true},
     		nuevoTelefonoContacto: { minlength: 7, patron_numeros: true},
     		nuevaDireccionContacto: { patron_textoEspecial: true},
     		nuevoFechaContacto: { required: true},
     		nuevoLugarContacto: { patron_numerosTexto: true}
    	},

	});

	//GUARDANDO DATOS DE MODAL NUEVA PERSONA CONTACTO

	$("#nuevoPersonaContacto").on("click", "#guardarPersonaContacto", function() {

		if ($("#nuevoPersonaContacto").valid()) {

			$('#modalNuevoPersonaContacto').modal('toggle');

			console.log("AGREGAR PERSONA CONTACTO");

			var paterno_contacto = $('#nuevoPaternoContacto').val();
			var materno_contacto = $('#nuevoMaternoContacto').val();
			var nombre_contacto = $('#nuevoNombreContacto').val();
			var relacion_contacto = $('#nuevoRelacionContacto').val();
			var edad_contacto = $('#nuevoEdadContacto').val();
			var telefono_contacto = $('#nuevoTelefonoContacto').val();
			var direccion_contacto = $('#nuevaDireccionContacto').val();
			var fecha_contacto = $('#nuevoFechaContacto').val();
			var lugar_contacto = $('#nuevoLugarContacto').val();
			var id_ficha = $ ("#idFicha").val();

			var datos = new FormData();
			datos.append("guardarPersonasContactos", 'guardarPersonasContactos');
			datos.append("paterno_contacto", paterno_contacto);
			datos.append("materno_contacto", materno_contacto);
			datos.append("nombre_contacto", nombre_contacto);
			datos.append("relacion_contacto", relacion_contacto);
			datos.append("edad_contacto", edad_contacto);
			datos.append("telefono_contacto", telefono_contacto);
			datos.append("direccion_contacto", direccion_contacto);
			datos.append("fecha_contacto", fecha_contacto);
			datos.append("lugar_contacto", lugar_contacto);
			datos.append("id_ficha", id_ficha);

			$.ajax({

				url:"ajax/personas_contactos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "html",
				success: function(id_persona_contacto) {
					if (id_persona_contacto != "error") {

						swal.fire({
							
							icon: "success",
							title: "¡Los datos se guardaron correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Aceptar"

						}).then((result) => {
		  					
		  					if (result.value) {

		  						var datos2 = new FormData();
								datos2.append("mostrarPersonaContacto", 'mostrarPersonaContacto');
								datos2.append("id_persona_contacto", id_persona_contacto);

		  						$.ajax({

									url:"ajax/personas_contactos.ajax.php",
									method: "POST",
									data: datos2,
									cache: false,
									contentType: false,
									processData: false,
									dataType: "json",
									success: function(respuesta) {
										
										$('#nuevoPaternoContacto').val("");
										$('#nuevoMaternoContacto').val("");
										$('#nuevoNombreContacto').val("");
										$('#nuevoRelacionContacto').val("");
										$('#nuevoEdadContacto').val("");
										$('#nuevoTelefonoContacto').val("");
										$('#nuevaDireccionContacto').val("");
										$('#nuevoFechaContacto').val("");
										$('#nuevoLugarContacto').val("");

										$("#tablaPersonasContactos").append(

											'<tr>'+
												'<td>'+respuesta["paterno_contacto"]+' '+respuesta["materno_contacto"]+' '+respuesta["nombre_contacto"]+'</td>'+
												'<td>'+respuesta["relacion_contacto"]+'</td>'+
												'<td>'+respuesta["edad_contacto"]+'</td>'+
												'<td>'+respuesta["telefono_contacto"]+'</td>'+
												'<td>'+respuesta["direccion_contacto"]+'</td>'+
												'<td>'+respuesta["fecha_contacto"]+'</td>'+
												'<td>'+respuesta["lugar_contacto"]+'</td>'+
												'<td>'+
													'<div class="btn-group"><button class="btn btn-warning btnEditarPersonaContacto" idPersonaContacto="'+respuesta["id"]+'" data-toggle="modal" data-target="#modalEditarPersonaContacto" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></button><button class="btn btn-danger btnEliminarPersonaContacto" idPersonaContacto="'+respuesta["id"]+'" data-toggle="tooltip" title="Eliminar"><i class="fas fa-times"></i></button>'+
													'</div>'+
												'</td>'+
											'</tr>'		

										)	

									},
									error: function(error) {

								        console.log("No funciona2");
								        
								    }

								});
		  						
							}

						});

					} else {

						swal.fire({
								
							title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						});
						
					}

				},
				error: function(error) {

			        console.log("No funciona");
			        
			    }

			});

		}

	});

	//VALIDANDO DATOS DE LABORATORIO EN LA FICHA EPIDEMIOLOGICA

    $("#fichaEpidemiologicaLab").validate({
		debug: true,
    	rules: {
			tomoMuestraLaboratorioSi : {
				required: function(){
					if($('#tomoMuestraLaboratorioSi').prop('checked'))
						return false;
					else if ($('#tomoMuestraLaboratorioNo').prop('checked')) 
								return false;
						 else return true;		
				}
			},
			tomoMuestraLaboratorioNo : {
				required: function(){
					if($('#tomoMuestraLaboratorioSi').prop('checked'))
						return false;
					else if ($('#tomoMuestraLaboratorioNo').prop('checked'))
								return false;
						 else return true;		
				}
			}, 
    		nuevoEstadoMuestra : { required: true},
     		nuevoLugarMuestra: { required: true},
     		nuevoTipoMuestra: { required: true, patron_texto: true},
     		nuevoNombreLaboratorio: { patron_numerosTexto: true},
     		nuevoFechaMuestra: { required: true},
     		nuevoFechaEnvio: { 
				 required: function(){
					if($('#pruebaAntigenica').prop('checked'))
						return false;
					else return true;
				}
			},
     		nuevoCodLaboratorio: { required: true, patron_numerosLetras: true},
     		nuevoResponsableMuestra: { required: true, patron_numerosLetras: false},
     		nuevoObsMuestra: { patron_textoEspecial: false},
     		nuevoResultadoLaboratorio: { required: false},
     		nuevoFechaResultado: { 
				required: function(){
					if($('#positivo').prop('checked') || $('#negativo').prop('checked'))
						return true;
					else return false;
				}
			},
			responsableAnalisis:{
				required: function(){
					if($('#positivo').prop('checked') || $('#negativo').prop('checked'))
						return true;
					else return false;
				}
			}
    	},

    	messages: {
       		nuevoEstadoMuestra : "Elija una opción",
       		nuevoLugarMuestra : "Elija una opción",
       		nuevoResultadoLaboratorio : "Elija una opción",
			tomoMuestraLaboratorioSi : "Elija una opción",
			tomoMuestraLaboratorioNo : ""
		},

       	errorPlacement: function(label, element) {

       		if (element.attr("name") == "nuevoResultadoLaboratorio" ) {
            	
            	label.addClass('errorMsq');
           		element.parent().parent().append(label);

			} else {

				label.addClass('errorMsq');
				element.parent().append(label);

			}

        },

	});

	//GUARDANDO DATOS DE LABORATORIO EN LA FICHA EPIDEMIOLOGICA

	$("#fichaEpidemiologicaLab").on("click", ".btnGuardarLab", function() {

		if ($("#fichaEpidemiologicaLab").valid()) {

			clearInterval(revisarRuta);
			removeListenerSMS();

			console.log("GUARDAR LABORATORIO");
			var estado_muestra = "";

			if($('#tomoMuestraLaboratorioSi').prop('checked')){
				estado_muestra = "SI";
			}

			if($('#tomoMuestraLaboratorioNo').prop('checked')){
				estado_muestra = "NO";
			}
			//var id_establecimiento = $("#nuevoLugarMuestra").val();
			var id_establecimiento = $("#nuevoEstablecimiento").val();
			
			var tipo_muestra = $("#nuevoTipoMuestra").val();
			var nombre_laboratorio = $("#nuevoNombreLaboratorio").val();
			var fecha_muestra = $("#nuevoFechaMuestra").val();	
			var fecha_envio = $("#nuevoFechaEnvio").val();
			var cod_laboratorio = $("#nuevoCodLaboratorio").val();		
			var responsable_muestra = $("#nuevoResponsableMuestra").val();
			var observaciones_muestra = $("#nuevoObsMuestra").val();		
			var fecha_resultado = $("#nuevoFechaResultado").val();				
			var id_ficha = $ ("#idFicha").val();
			console.log("id_ficha", id_ficha);

			var cod_asegurado = $("#nuevoCodAsegurado").val();
			var cod_afiliado = $("#nuevoCodAfiliado").val();
			var cod_empleador = $("#nuevoCodEmpleador").val();
			var nombre_empleador = $("#nuevoNombreEmpleador").val();
			var paterno = $("#nuevoPaternoPaciente").val();
			var materno = $("#nuevoMaternoPaciente").val();
			var nombre = $("#nuevoNombrePaciente").val();

			//var id_departamento = $("#nuevoDepartamentoPaciente").val();
			var id_departamento = $("#residenciaActual").val();
            console.log("id_departamento: "+ id_departamento);

			var documento_ci = $("#nuevoNroDocumentoPaciente").val();
			var sexo = $("#nuevoSexoPaciente").val();
			var fecha_nacimiento = $("#nuevoFechaNacPaciente").val();
			var telefono = $("#nuevoTelefonoPaciente").val();
			var email = $ ("#nuevoEmailPaciente").val();

			//var id_localidad = $("#nuevoLocalidadPaciente").val();
			var id_localidad = 1;
			console.log("id_localidad: "+ id_localidad);



			var zona = $("#nuevoZonaPaciente").val();
			var calle = $("#nuevoCallePaciente").val();
			var nro_calle = $("#nuevoNroCallePaciente").val();
			var id_usuario = $("#idUsuario").val();
			var foto = "vistas/img/covid_resultados/default/anonymous.png";
			var responsableAnalisis = $('#responsableAnalisis').val();

			//Enviamos los datos de la seccion Resultado si es que selecciono antes de crear el covid_resultado
			var pcrTiempoReal  = ""; 
			var pcrGenExpert  = "";
			var pruebaAntigenica = "";
			if($('#pcrTiempoReal').prop('checked'))
				pcrTiempoReal = 'RT-PCR en tiempo Real';
			if($('#pcrGenExpert').prop('checked'))
				pcrGenExpert = 'RT-PCR GENEXPERT';
			if($('#pruebaAntigenica').prop('checked'))
				pruebaAntigenica = 'Prueba Antigénica';
            
			//guardando el resultado si es que lo soluciono	
			var resultado_laboratorio = $('input:radio[name="nuevoResultadoLaboratorio"]:checked').val();	
/* 			var positivo, negativo = "";
			if($('#positivo').val() == 'POSITIVO')
			  positivo = 'POSITIVO';
			if($('#negativo').val() == 'NEGATIVO')
			   negativo = 'NEGATIVO'; */
			

			
			var datos = new FormData();
			datos.append("guardarLaboratorio", 'guardarLaboratorio');
			datos.append("estado_muestra", estado_muestra);
			datos.append("id_establecimiento", id_establecimiento);
			datos.append("tipo_muestra", tipo_muestra);
			datos.append("nombre_laboratorio", nombre_laboratorio);
			datos.append("fecha_muestra", fecha_muestra);	
			datos.append("fecha_envio", fecha_envio);
			datos.append("cod_laboratorio", cod_laboratorio);	
			datos.append("responsable_muestra", responsable_muestra);
			datos.append("observaciones_muestra", observaciones_muestra);
			datos.append("resultado_laboratorio", resultado_laboratorio);
			datos.append("fecha_resultado", fecha_resultado);
			datos.append("id_ficha", id_ficha);

			datos.append("cod_asegurado", cod_asegurado);
			datos.append("cod_afiliado", cod_afiliado);
			datos.append("cod_empleador", cod_empleador);
			datos.append("nombre_empleador", nombre_empleador);
			datos.append("paterno", paterno);	
			datos.append("materno", materno);
			datos.append("nombre", nombre);	
			datos.append("id_departamento", id_departamento);
			datos.append("documento_ci", documento_ci);
			datos.append("sexo", sexo);
			datos.append("fecha_nacimiento", fecha_nacimiento);
			datos.append("telefono", telefono);
			datos.append("email", email);
			datos.append("id_localidad", id_localidad);	
			datos.append("zona", zona);
			datos.append("calle", calle);
			datos.append("nro_calle", nro_calle);
			datos.append("id_usuario", id_usuario);
			datos.append("foto", foto);
			//responsableAnalisis
			datos.append("responsableAnalisis", responsableAnalisis);
			//añadiendo la seccion resultados a la tabla covid_resultados si es que selecciono alguno en editar-ficha-epidemiologica-lab
			datos.append("pcrTiempoReal", pcrTiempoReal);
			datos.append("pcrGenExpert", pcrGenExpert);
			datos.append("pruebaAntigenica", pruebaAntigenica);
			datos.append("positivo", positivo);
			datos.append("negativo", negativo);

			$.ajax({

				url:"ajax/laboratorios.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "html",
				success: function(respuesta) {
					console.log("respuestaLAB", respuesta);
					/* debugger */
					if (respuesta == "ok") {

						swal.fire({
							
							icon: "success",
							title: "¡Los datos se guardaron correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Aceptar"

						}).then((result) => {
		  					
		  					if (result.value) {
		  						window.location = "ficha-epidemiologica-lab";
							}

						});

					} else {

						swal.fire({
								
							title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						});
						
					}

				},
				error: function(error) {

			        console.log("No funciona");
			        
			    }

			});

		}

		else {

        	swal.fire({
								
				title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales, por favor revise el formulario!",
				icon: "error",
				allowOutsideClick: false,
				confirmButtonText: "¡Cerrar!"

			});
        }

	});

	//CARGANDO DATOS AL FORMULARIO DE PERSONAS CONTACTO EN LA FICHA EPIDEMIOLOGICA

	$(document).on("click", ".btnEditarPersonaContacto", function() {

		console.log("CARGAR PERSONA CONTACTO");

		var id_persona_contacto = $(this).attr("idPersonaContacto");
		console.log("id_persona_contacto", id_persona_contacto);

		var fila = $(this).parent().parent().parent().attr("id", "fila"+id_persona_contacto);
		console.log("fila", fila);

		var datos = new FormData();
		datos.append("mostrarPersonaContacto", 'mostrarPersonaContacto');
		datos.append("id_persona_contacto", id_persona_contacto);

		$.ajax({

			url: "ajax/personas_contactos.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function(respuesta) {

				$('#editarPaternoContacto').val(respuesta["paterno_contacto"]);
				$('#editarMaternoContacto').val(respuesta["materno_contacto"]);
				$('#editarNombreContacto').val(respuesta["nombre_contacto"]);
				$('#editarRelacionContacto').val(respuesta["relacion_contacto"]);
				$('#editarEdadContacto').val(respuesta["edad_contacto"]);
				$('#editarTelefonoContacto').val(respuesta["telefono_contacto"]);
				$('#editarDireccionContacto').val(respuesta["direccion_contacto"]);
				$('#editarFechaContacto').val(respuesta["fecha_contacto"]);
				$('#editarLugarContacto').val(respuesta["lugar_contacto"]);
				$('#editarIdPersonaContacto').val(respuesta["id"]);

			},
		    error: function(error){

		      console.log("No funciona");
		        
		    }

		});

	});

	//VALIDANDO DATOS DE MODAL EDITAR PERSONA CONTACTO 

    $("#guardarEditarPersonaContacto").validate({

    	rules: {
    		editarPaternoContacto : { patron_texto: true},
     		editarMaternoContacto: { patron_texto: true},
     		editarNombreContacto: { required: true, patron_texto: true},
     		editarRelacionContacto: { required: true, patron_numerosTexto: true},
     		editarEdadContacto: { patron_numeros: true},
     		editarTelefonoContacto: { minlength: 7, patron_numeros: true},
     		nuevaDireccionContacto: { patron_textoEspecial: true},
     		editarFechaContacto: { required: true},
     		editarLugarContacto: { patron_numerosTexto: true}
    	},

	});

	//EDITANDO DE MODAL EDITAR PERSONA CONTACTO 

	$("#guardarEditarPersonaContacto").on("click", "#btnModificarPersonaContacto", function() {

		if ($("#guardarEditarPersonaContacto").valid()) {

			$('#modalEditarPersonaContacto').modal('toggle');

			console.log("EDITAR PERSONA CONTACTO");

			var id_persona_contacto = $('#editarIdPersonaContacto').val();
			var paterno_contacto = $('#editarPaternoContacto').val();
			var materno_contacto = $('#editarMaternoContacto').val();
			var nombre_contacto = $('#editarNombreContacto').val();
			var relacion_contacto = $('#editarRelacionContacto').val();
			var edad_contacto = $('#editarEdadContacto').val();
			var telefono_contacto = $('#editarTelefonoContacto').val();
			var direccion_contacto = $('#editarDireccionContacto').val();
			var fecha_contacto = $('#editarFechaContacto').val();
			var lugar_contacto = $('#editarLugarContacto').val();
			//var id_ficha = $ ("#idFicha").val();

			var datos = new FormData();
			datos.append("editarPersonasContactos", 'editarPersonasContactos');
			datos.append("id_persona_contacto", id_persona_contacto);
			datos.append("paterno_contacto", paterno_contacto);
			datos.append("materno_contacto", materno_contacto);
			datos.append("nombre_contacto", nombre_contacto);
			datos.append("relacion_contacto", relacion_contacto);
			datos.append("edad_contacto", edad_contacto);
			datos.append("telefono_contacto", telefono_contacto);
			datos.append("direccion_contacto", direccion_contacto);
			datos.append("fecha_contacto", fecha_contacto);
			datos.append("lugar_contacto", lugar_contacto);
			//datos.append("id_ficha", id_ficha);

			$.ajax({

				url:"ajax/personas_contactos.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "html",
				success: function(id_persona_contacto) {
				
					if (id_persona_contacto != "error") {

						swal.fire({
							
							icon: "success",
							title: "¡Los datos se modificaron correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Aceptar"

						}).then((result) => {
		  					
		  					if (result.value) {

		  						// Eliminamos el contenido de la fila
		  						$("#fila"+id_persona_contacto).empty();

		  						var datos2 = new FormData();
								datos2.append("mostrarPersonaContacto", 'mostrarPersonaContacto');
								datos2.append("id_persona_contacto", id_persona_contacto);

		  						$.ajax({

									url:"ajax/personas_contactos.ajax.php",
									method: "POST",
									data: datos2,
									cache: false,
									contentType: false,
									processData: false,
									dataType: "json",
									success: function(respuesta) {
										
										$('#editarPaternoContacto').val("");
										$('#editarMaternoContacto').val("");
										$('#editarNombreContacto').val("");
										$('#editarRelacionContacto').val("");
										$('#editarEdadContacto').val("");
										$('#editarTelefonoContacto').val("");
										$('#editarDireccionContacto').val("");
										$('#editarFechaContacto').val("");
										$('#editarLugarContacto').val("");

										// Agregamos el contenido editado en la fila
										$("#fila"+id_persona_contacto).append(

											// '<tr>'+
												'<td>'+respuesta["paterno_contacto"]+' '+respuesta["materno_contacto"]+' '+respuesta["nombre_contacto"]+'</td>'+
												'<td>'+respuesta["relacion_contacto"]+'</td>'+
												'<td>'+respuesta["edad_contacto"]+'</td>'+
												'<td>'+respuesta["telefono_contacto"]+'</td>'+
												'<td>'+respuesta["direccion_contacto"]+'</td>'+
												'<td>'+respuesta["fecha_contacto"]+'</td>'+
												'<td>'+respuesta["lugar_contacto"]+'</td>'+
												'<td>'+
													'<div class="btn-group"><button class="btn btn-warning btnEditarPersonaContacto" idPersonaContacto="'+respuesta["id"]+'" data-toggle="modal" data-target="#modalEditarPersonaContacto" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></button><button class="btn btn-danger btnEliminarPersonaContacto" idPersonaContacto="'+respuesta["id"]+'" data-toggle="tooltip" title="Eliminar"><i class="fas fa-times"></i></button>'+
													'</div>'+
												'</td>'
											// '</tr>'		

										)	

									},
									error: function(error) {

								        console.log("No funciona2");
								        
								    }

								});
		  						
							}

						});

					} else {

						swal.fire({
								
							title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						});
						
					}

				},
				error: function(error) {

			        console.log("No funciona");
			        
			    }

			});

		}

	});

	//ELIMINADO UNA FILA DE LA TABLA DE PERSONAS CONTACTO EN LA FICHA EPIDEMIOLOGICA

	$(document).on("click", ".btnEliminarPersonaContacto", function() {

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

				console.log("ELIMINAR PERSONA CONTACTO");

				var id_persona_contacto = $(this).attr("idPersonaContacto");
				console.log("id_persona_contacto", id_persona_contacto);

				var fila = $(this).parent().parent().parent().attr("id", "fila"+id_persona_contacto);
				console.log("fila", fila);

				var datos = new FormData();
				datos.append("eliminarPersonaContacto", 'eliminarPersonaContacto');
				datos.append("id_persona_contacto", id_persona_contacto);

				$.ajax({

					url: "ajax/personas_contactos.ajax.php",
					method: "POST",
					data: datos,
					cache: false,
					contentType: false,
					processData: false,
					dataType: "html",
					success: function(respuesta) {
						console.log("respuesta", respuesta);
					
						if (respuesta == "ok") {

							swal.fire({
								
								icon: "success",
								title: "¡Los datos se eliminaron correctamente!",
								showConfirmButton: true,
								allowOutsideClick: false,
								confirmButtonText: "Aceptar"

							}).then((result) => {
			  					
			  					if (result.value) {

			  						// Eliminamos el contenido de la fila
		  							$("#fila"+id_persona_contacto).empty();

								}

							});

						} else {

							swal.fire({
									
								title: "¡Erroe en la Transacción o conexión a la Base de Datos!",
								icon: "error",
								allowOutsideClick: false,
								confirmButtonText: "¡Cerrar!"

							});
							
						}

					},
					error: function(error) {

				        console.log("No funciona");
				        
				    }

				});

			}

		});

	});

	


	//VALIDANDO DATOS DE LABORATORIO EN LA FICHA CONTRO Y SEGUIMIENTO

    $("#fichaControlLab").validate({

    	rules: {
     		nuevoTipoMuestra: { required: true, patron_texto: true},
     		nuevoNombreLaboratorio: { patron_numerosTexto: true},
     		nuevoFechaMuestra: { required: true},
     		nuevoFechaEnvio: { required: true},
     		nuevoCodLaboratorio: { required: true, patron_numerosLetras: true},
     		nuevoResponsableMuestra: { required: true, patron_texto: true},
     		nuevoObsMuestra: { patron_textoEspecial: true},
     		nuevoResultadoLaboratorio: { required: true},
     		nuevoFechaResultado: { required: true}
    	},

    	messages: {
       		nuevoResultadoLaboratorio : "Elija una opción"
		},

       	errorPlacement: function(label, element) {

       		if (element.attr("name") == "nuevoResultadoLaboratorio" ) {
            	
            	label.addClass('errorMsq');
           		element.parent().parent().append(label);

			} else {

				label.addClass('errorMsq');
				element.parent().append(label);

			}

        },

	});


		/*=============================================
	FICHA CONTROL Y SEGUIMIENTO
	=============================================*/	
    
    //VALIDANDO DATOS DE FICHA CONTROL Y SEGUIMIENTO

    $("#fichaControlCentro").validate({

    	rules: {
    		// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
    		nuevoEstablecimiento : { required: true},
			nuevoDepartamento : { required: true},
           	nuevoLocalidad : { required: true},
			nuevoFechaNotificacion : { required: true},
     		nuevoNroControl : { required: true},

     		// 2. IDENTIFICACIÓN DEL CASO PACIENTE
     		nuevoCodAsegurado : { required: true},
			nuevoSexoPaciente : { required: true},
			nuevoNroDocumentoPaciente : { required: true, patron_numerosLetras: true},
			nuevoTelefonoPaciente : { patron_numeros: true},

     		// 3. SEGUIMIENTO
     		nuevoDiasNotificacion : { required: true},
     		nuevoDiasSinSintomas : { patron_numeros: true},
    		nuevoLugarAislamiento : { patron_numerosTexto: true},
     		nuevoEstablecimientoInternacion : { patron_numerosTexto: true},
     		nuevoLugarIngresoUTI : { patron_numerosTexto: true}, 
     		nuevoVentilacionMecanica : { required: true},
     		nuevoTratamientoOtros : { patron_numerosTexto: true},

     		// 4. LABORATORIO
     		nuevoTipoMuestra: { required: true, patron_texto: true},
     		nuevoFechaMuestra: { required: true},
     		nuevoFechaEnvio: { required: true},
     		nuevoResponsableMuestra: { required: true, patron_texto: true},

     		// DATOS DEL PERSONAL QUE NOTIFICA
     		nuevoPaternoNotif : { patron_texto: true},
     		nuevoMaternoNotif : { patron_texto: true},
     		nuevoNombreNotif : { required: true, patron_texto: true},
     		nuevoTelefonoNotif : { minlength: 7, patron_numeros: true},
     		nuevoCargoNotif : { patron_numerosTexto: true}
     		
    	},

    	messages: {
    		// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
       		nuevoEstablecimiento : "Elija un establecimiento",
           	nuevoDepartamento : "Elija un departamento",
           	nuevoLocalidad : "Elija una Localidad",
           	nuevoNroControl : "Elija un valor",

           	// 2. IDENTIFICACIÓN DEL CASO PACIENTE
           	nuevoCodAsegurado : "Elija un asegurado",
           	nuevoSexoPaciente : "Elija un sexo",

           	// 3. SEGUIMIENTO
           	nuevoDiasNotificacion : "Elija una opción",
           	nuevoVentilacionMecanica : "Elija una opción",

		},

	});

	//GUARDANDO DATOS DE LABORATORIO EN LA FICHA CONTROL Y SEGUIMIENTO

	$("#fichaControlLab").on("click", ".btnGuardarLab", function() {

		if ($("#fichaControlLab").valid()) {

			console.log("GUARDAR LABORATORIO");

			var tipo_muestra = $("#nuevoTipoMuestra").val();
			var nombre_laboratorio = $("#nuevoNombreLaboratorio").val();
			var fecha_muestra = $("#nuevoFechaMuestra").val();	
			var fecha_envio = $("#nuevoFechaEnvio").val();
			var cod_laboratorio = $("#nuevoCodLaboratorio").val();		
			var responsable_muestra = $("#nuevoResponsableMuestra").val();
			var observaciones_muestra = $("#nuevoObsMuestra").val();		
			var resultado_laboratorio = $('input:radio[name="nuevoResultadoLaboratorio"]:checked').val();
			console.log("resultado_laboratorio", resultado_laboratorio);
			var fecha_resultado = $("#nuevoFechaResultado").val();				
			var id_ficha = $ ("#idFicha").val();
			console.log("id_ficha", id_ficha);

			var id_establecimiento = $("#nuevoEstablecimiento").val();
			var cod_asegurado = $("#nuevoCodAsegurado").val();
			var cod_afiliado = $("#nuevoCodAfiliado").val();
			var cod_empleador = $("#nuevoCodEmpleador").val();
			var nombre_empleador = $("#nuevoNombreEmpleador").val();
			var paterno = $("#nuevoPaternoPaciente").val();
			var materno = $("#nuevoMaternoPaciente").val();
			var nombre = $("#nuevoNombrePaciente").val();
			var id_departamento = $("#nuevoDepartamento").val();
			var documento_ci = $("#nuevoNroDocumentoPaciente").val();
			var sexo = $("#nuevoSexoPaciente").val();
			var fecha_nacimiento = $("#nuevoFechaNacPaciente").val();
			var telefono = $("#nuevoTelefonoPaciente").val();
			var email = $("#nuevoEmailPaciente").val();
			var id_localidad = $("#nuevoLocalidad").val();
			var zona = "";
			var calle = "";
			var nro_calle = "";
			var id_usuario = $("#idUsuario").val();
			var foto = "vistas/img/covid_resultados/default/anonymous.png";

			var datos = new FormData();
			datos.append("guardarLaboratorioControl", 'guardarLaboratorioControl');
			datos.append("tipo_muestra", tipo_muestra);
			datos.append("nombre_laboratorio", nombre_laboratorio);
			datos.append("fecha_muestra", fecha_muestra);	
			datos.append("fecha_envio", fecha_envio);
			datos.append("cod_laboratorio", cod_laboratorio);	
			datos.append("responsable_muestra", responsable_muestra);
			datos.append("observaciones_muestra", observaciones_muestra);
			datos.append("resultado_laboratorio", resultado_laboratorio);
			datos.append("fecha_resultado", fecha_resultado);
			datos.append("id_ficha", id_ficha);

			datos.append("id_establecimiento", id_establecimiento);
			datos.append("cod_asegurado", cod_asegurado);
			datos.append("cod_afiliado", cod_afiliado);
			datos.append("cod_empleador", cod_empleador);
			datos.append("nombre_empleador", nombre_empleador);
			datos.append("paterno", paterno);	
			datos.append("materno", materno);
			datos.append("nombre", nombre);	
			datos.append("id_departamento", id_departamento);
			datos.append("documento_ci", documento_ci);
			datos.append("sexo", sexo);
			datos.append("fecha_nacimiento", fecha_nacimiento);
			datos.append("telefono", telefono);
			datos.append("email", email);
			datos.append("id_localidad", id_localidad);	
			datos.append("zona", zona);
			datos.append("calle", calle);
			datos.append("nro_calle", nro_calle);
			datos.append("id_usuario", id_usuario);
			datos.append("foto", foto);

			$.ajax({

				url:"ajax/laboratorios.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "html",
				success: function(respuesta) {
				
					if (respuesta == "ok") {

						swal.fire({
							
							icon: "success",
							title: "¡Los datos se guardaron correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Aceptar"

						}).then((result) => {
		  					
		  					if (result.value) {

		  						window.location = "ficha-epidemiologica";

							}

						});

					} else {

						swal.fire({
								
							title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						});
						
					}

				},
				error: function(error) {

			        console.log("No funciona");
			        
			    }

			});

		}
		else {

        	swal.fire({
								
				title: "¡Los campos obligatorios no puede ir vacio o llevar caracteres especiales, por favor revise el formulario!",
				icon: "error",
				allowOutsideClick: false,
				confirmButtonText: "¡Cerrar!"

			});
        }

	});

});

/*=============================================
FUNCIÓN PARA ACTUALIZAR UN CAMPO EDITADO DE LA FICHA EPIDEMIOLOGICA
=============================================*/

function actualizarCampoFicha(id_ficha, item, valor, tabla) {

	var datos = new FormData();

	datos.append("guardarCampoFicha", "guardarCampoFicha");
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

	    if (respuesta == "ok") {

			toastr.success('El Dato se guardó correctamente.');			

		} else {

			toastr.warning('¡Error! Falla 1 en la consulta a BD, no se modificaron.')
		}

  	},
	error: function(error) {

      	toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.')
        
    }

	});

}

/*=============================================
FUNCIÓN PARA ACTUALIZAR UN CAMPO EDITADO DE LA FICHA EPIDEMIOLOGICA
=============================================*/

function actualizarCampoFichaEnfermedades(id_ficha, item, valor, tabla) {
	var datos = new FormData();
	datos.append("guardarCampoFicha", "guardarCampoFicha");
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
	    if (respuesta == "ok") {
			//toastr.success('El Dato se guardó correctamente.');
		} else {
			toastr.warning('¡Error! Falla 1 en la consulta a BD, no se modificaron.')
		}
  	},
	error: function(error) {
      	toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.')        
    }
	});
}



/*=============================================
BOTÓN EDITAR FICHA EPIDEMIOLOGICA COVID RESULTADOS
=============================================*/

$(document).on("click", "button.btnEditarFichaEpidemiologica", function() {
	var idFicha = $(this).attr("idFicha");

	window.location = "index.php?ruta=editar-ficha-epidemiologica&idFicha="+idFicha;

});

/*=============================================
BOTÓN AGREGAR RESULTADO DE LABORATORIO EN FICHA EPIDEMIOLOGICA 
=============================================*/

$(document).on("click", "button.btnAgregarResultadoLab", function() {
	
	var idFicha = $(this).attr("idFicha");

	window.location = "index.php?ruta=editar-ficha-epidemiologica-lab&idFicha="+idFicha;

});

/*=============================================
BOTÓN EDITAR FICHA CONTROL Y SEGUIMIENTO COVID RESULTADOS
=============================================*/

$(document).on("click", "button.btnEditarFichaControl", function() {
	
	var idFicha = $(this).attr("idFicha");

	window.location = "index.php?ruta=editar-ficha-control&idFicha="+idFicha;

});

/*=============================================
BOTÓN AGREGAR RESULTADO DE LABORATORIO EN FICHA CONTROL Y SEGUIMIENTO 
=============================================*/

$(document).on("click", "button.btnAgregarResultadoControlLab", function() {
	
	var idFicha = $(this).attr("idFicha");

	window.location = "index.php?ruta=editar-ficha-control-lab&idFicha="+idFicha;

});

/*==============================================
	BOTON GENERAR PDF PARA IMPRIMIR CERTIFICADO DE CONSENTIMIENTO
================================================*/
$(document).on("click","button.btnImprimrConcentimiento",function(){
	var idFicha = $(this).attr("idFicha");
	var code = $(this).data("code");

	var datos = new FormData();
	datos.append("concentimientoPDF", "concentimientoPDF");
	datos.append("idFicha", idFicha);

	//Para mostrar alerta personalizada de loading
	swal.fire({
        text: 'Procesando...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    });

	$.ajax({

		url: "ajax/informacion_paciente.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			//Para cerrar la alerta personalizada de loading
			swal.close();

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	

			PDFObject.embed("temp/"+code+"/consentimiento-"+idFicha+".pdf", "#view_pdf");

		}

	});

});


/*=================================================================
	BOTON GENERAR PDF PARA INPRIMIR CERTIFICADO MEDICO
 ==================================================================*/
 
$(document).on("click","button.btnCertificadoMedico",function(){


	var idFicha = $(this).attr("idFicha");
	var code = $(this).data("code");
	var datos = new FormData();
	var numdias = 1;
	datos.append("certificadoMedicoPDF", "certificadoMedicoPDF");
	datos.append("idFicha", idFicha);


	Swal.fire({
		title: '<strong>Ingrese el Numero de Dias para el Certificado</strong>',
		html:
		  '<select  name="numdiasc" id="numdiasc">' +
		  '<option value="1">Un Dia</option>' + 
		  '<option value="2">Dos Dias</option>' + 
		  '<option value="3">Tres Dias</option>' +
		  '</select>',

		imageUrl: 'vistas/img/CertificadoMedico.png',
		imageHeight: 500,
		imageAlt: 'A tall image',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ingresar',
		preConfirm: () => {
			 numdias = $('#numdiasc option:selected').val();
		  }

	  }).then((result)=> {
		if (result.value) {
			swal.fire({
				text: 'Procesando...',
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false,
				onOpen: () => {
					swal.showLoading()
				}
			});

			datos.append("numdias", numdias);
            //alert("elegido "+numdias);

			$.ajax({
				url: "ajax/informacion_paciente.ajax.php",
				type: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(respuesta) {
					//Para cerrar la alerta personalizada de loading
					swal.close();
					$('#ver-pdf').modal({
						show:true,
						backdrop:'static'
					});	
					PDFObject.embed("temp/"+code+"/certificado-medico-"+idFicha+".pdf", "#view_pdf");
				}		
			}); 
		}
	});
}); 


/*
$(document).on("click","button.btnCertificadoMedico",function(){

	var idFicha = $(this).attr("idFicha");
	var code = $(this).data("code");
	var datos = new FormData();
	datos.append("certificadoMedicoPDF", "certificadoMedicoPDF");
	datos.append("idFicha", idFicha);

	//Para mostrar alerta personalizada de loading
	swal.fire({
        text: 'Procesando...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    });

	$.ajax({

		url: "ajax/informacion_paciente.ajax2.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			//Para cerrar la alerta personalizada de loading
			swal.close();

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	

			//PDFObject.embed("temp/example_014.pdf", "#view_pdf");
			PDFObject.embed("temp/"+code+"/certificado-medico-"+idFicha+".pdf", "#view_pdf");

		}

	});

});

*/
/*=================================================================
	BOTON GENERAR PDF PARA INPRIMIR CERTIFICADO DE ALTA
 ==================================================================*/
 $(document).on("click","button.btnCertificadoDeAlta",function(){

	 var idFicha = $(this).attr("idFicha");
	 var idCovidResultado = $(this).attr("idCovidResultado");
	 var code = $(this).data("code");
	var datos = new FormData();
	datos.append("certificadoDeAlta", "certificadoDeAlta");
	datos.append("idFicha", idFicha);
	datos.append("idCovidResultado",idCovidResultado);

	//Para mostrar alerta personalizada de loading
	swal.fire({
        text: 'Procesando...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    });

	$.ajax({

		url: "ajax/informacion_paciente.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			//Para cerrar la alerta personalizada de loading
			swal.close();

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	

			PDFObject.embed("temp/"+code+"/certificado-alta-"+idFicha+".pdf", "#view_pdf");

		}

	});

});


/*=================================================================
	BOTON FORMULARIO CERTIFICADO DE ALTA DESCARTADO
 ==================================================================*/
 $(document).on("click","button.btnCertificadoDeAltaDescartado",function(){

	var idFicha = $(this).attr("idFicha");
	var code = $(this).data("code");
   var datos = new FormData();
   datos.append("certificadoDeAltaDescartado", "certificadoDeAltaDescartado");
   datos.append("idFicha", idFicha);

   //Para mostrar alerta personalizada de loading
   swal.fire({
	   text: 'Procesando...',
	   allowOutsideClick: false,
	   allowEscapeKey: false,
	   allowEnterKey: false,
	   onOpen: () => {
		   swal.showLoading()
	   }
   });

   $.ajax({
	   url: "ajax/informacion_paciente.ajax.php",
	   type: "POST",
	   data: datos,
	   cache: false,
	   contentType: false,
	   processData: false,
	   success: function(respuesta) {
		   swal.close();
		   $('#ver-pdf').modal({
			   show:true,
			   backdrop:'static'			   

		   });

		   PDFObject.embed("temp/"+code+"/certificado-alta-descartado-"+idFicha+".pdf", "#view_pdf");
	   }

   });

});

/*=============================================
BOTÓN GENERERAR PDF PARA IMPRIMIR FICHA EPIDEMIOLÓGICA 
=============================================*/

$(document).on("click", "button.btnImprimirFichaEpidemiologica", function() {
	
	var idFicha = $(this).attr("idFicha");
	var code = $(this).data("code");

	var datos = new FormData();

	datos.append("fichaEpidemiologicaPDF", "fichaEpidemiologicaPDF");
	datos.append("idFicha", idFicha);

	swal.fire({
        text: 'Procesando...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    });

	$.ajax({

		url: "ajax/fichas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		//dataType: "string",
		success: function(respuesta) {

			//Para cerrar la alerta personalizada de loading
			//console.log("esta es la respuestaMark: " + (respuesta));
			//var aux = respuesta.split("<br />")[0];
			//var aux = auxliar(respuesta);
			//alert(aux);
			swal.close();

			$('#ver-pdf').modal({
				show:true,
				backdrop:'static'

			});
			console.log(respuesta);
			

			PDFObject.embed("temp/"+code+"/ficha-epidemiologica-"+idFicha+".pdf", "#view_pdf");

		}

	});

});

/*====================================================================
	BOTON PARA GENERAR PDFS DE TODAS LAS FICHAS
======================================================================*/
$("#btnGenerarPDFS").on("click",function(){
	//alert("OK");
	var datos = new FormData();
	datos.append("generadorDePDFS","generadorDePDFS");
	$.ajax({
		url: "ajax/fichas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		//dataType: "string",
		success: function(respuesta){
			console.log(respuesta);
		}
	});
});

/* function auxliar(aux){
	var a = aux.split("<br />");

	return a[0].split(")")[1].split('"')[1];
} */

/*=============================================
BOTÓN GENERERAR PDF PARA IMPRIMIR FICHA CONTROL Y SEGUIMIENTO 
=============================================*/

$(document).on("click", "button.btnImprimirFichaControl", function() {
	
	var idFicha = $(this).attr("idFicha");
	console.log("idFicha", idFicha);

	var datos = new FormData();

	datos.append("fichaControlPDF", "fichaControlPDF");
	datos.append("idFicha", idFicha);
	// datos.append("nombre_usuario", nombre_usuario);

	//Para mostrar alerta personalizada de loading
	swal.fire({
        text: 'Procesando...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        onOpen: () => {
            swal.showLoading()
        }
    });

	$.ajax({

		url: "ajax/fichas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			//Para cerrar la alerta personalizada de loading
			swal.close();

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	

			PDFObject.embed("temp/ficha-"+idFicha+".pdf", "#view_pdf");

		}
	});
});

/*==================================================
	Revisar para nueva ficha y certificado
 ===================================================*/
$(document).on("click", "#btnFichaSospechoso", function() {
	$("#modalFichaSospechoso").modal('show');
});

$(document).on("click", "#btnCertificadoSospechoso", function() {
	console.log('PAGINA EN DESARROLLO');
	$("#modalInfoDev").modal('show');
});

/*====================================================

	EVENTOS PARA LOS OPTION DEPARTAMENTO, PROVINCIA, MUNICIPIO 
	url="ajax/aseguradoDepartamento.ajax.php";
======================================================*/

$("#residenciaActual").change(function(){
	var id_ficha = $ ("#idFicha").val();
	var provincia = $("#nuevoProvincia");
	item = "id_departamento_paciente ";
	tabla= "pacientes_asegurados";
	valor=$("#residenciaActual").val();
	datos = new FormData();
	if(valor!=""){
		datos.append('idDepartamento',valor);
		$.ajax({
			url: "ajax/aseguradoDepartamento.ajax.php",
			type: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				provincia.empty();
				provincia.removeAttr('disabled');
				provincia.attr('selected', 'selected');
				var respuestas = JSON.parse(respuesta);
				$("#nuevoProvincia").append("<option value=''>Elegir</option>");
				$("#nuevoMunicipio").empty();
				$("#nuevoMunicipio").append("<option value=''>Elegir</option>");
								
				for(i = 0; i < respuestas.length; i++){
					$("#nuevoProvincia").append("<option value='"+ respuestas[i].id +"'>"+ respuestas[i].nombre_provincia +"</option>");
				}		
			}
		});
		actualizarCampoFicha(id_ficha, item, valor, tabla);
	}
});

$("#nuevoProvincia").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "id_provincia_paciente";
	tabla= "pacientes_asegurados";
	valor=$("#nuevoProvincia").val();
	if(valor!=""){
		datos = new FormData();
		datos.append('idProvincia',valor);
		$.ajax({
			url: "ajax/aseguradoDepartamento.ajax.php",
			type: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				$("#nuevoMunicipio").empty();
				$("#nuevoMunicipio").removeAttr('disabled');
				var respuestas = JSON.parse(respuesta);
				$("#nuevoMunicipio").append("<option value=''>Elegir</option>");
				for(i = 0; i < respuestas.length; i++){
					$("#nuevoMunicipio").append("<option value='"+ respuestas[i].id +"'>"+ respuestas[i].nombre_municipio +"</option>");
				}
			}
		});
		actualizarCampoFicha(id_ficha, item, valor, tabla);
	}
});

/*=====================================================================
		Actualiar dinamicamente pais, departamento, provincia, municipio
 						 begin danpinch	
=======================================================================*/

$("#identificacionEtnica").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "identificacion_etnica";	
	valor = $("#identificacionEtnica option:selected").val();
	tabla= "pacientes_asegurados";
	//debugger;
	if(valor!="Elegir"){
		actualizarCampoFicha(id_ficha, item, valor, tabla);
	}else{
		actualizarCampoFicha(id_ficha, item, "", tabla);
	}

});

$("#paisProcedencia").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "id_pais_paciente";
	tabla= "pacientes_asegurados";
	valor = $("#paisProcedencia").val();
	if(valor!=""){
		actualizarCampoFicha(id_ficha, item, valor, tabla);
	}
});

$("#nuevoMunicipio").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "id_municipio_paciente";
	tabla= "pacientes_asegurados";
	valor = $("#nuevoMunicipio").val();
	if(valor!=""){
		actualizarCampoFicha(id_ficha, item, valor, tabla);
	}
});

$("#nuevoObsMuestra").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "observaciones_muestra";
	tabla= "laboratorios";
	valor = $(this).val();
	actualizarCampoFicha(id_ficha, item, valor, tabla);
});


$("#nuevoPasienteAsintomatico").change(function(){
	var id_ficha = $ ("#idFicha").val();	
	if($(this).prop('checked')){
		$("#divSintomas").hide();
		$("#nuevoPasienteSintomatico").attr('disabled','disabled');
		actualizarCampoFicha(id_ficha, "sintoma", "asintomatico", "datos_clinicos");
	}else{
		//$("#divSintomas").hide();
		actualizarCampoFicha(id_ficha, "sintoma", "", "datos_clinicos");
		$("#nuevoPasienteSintomatico").removeAttr('disabled');
		$("nuevoPasienteSintomatico").prop('checked',true);
	}
	
});

/* 
		funcion para deshabilitar el mensaje toast 
		begin danpinch
 */
function crearMalestarDatosClinicos(id_ficha,item,valor, tabla) {
	var datos = new FormData();
	datos.append("guardarMalestar", "guardarMalestar");
	datos.append("id_ficha", id_ficha);
	datos.append("item", item);
	datos.append("valor",valor);
	datos.append("tabla",tabla);
	$.ajax({
		url:"ajax/malestar.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {
			if (respuesta == "ok") {

				toastr.success('El Dato se guardó correctamente.')
	
			} else {
	
				toastr.warning('¡Error! Falla DA en la consulta a BD, no se modificaron.')
			}
	
		  },
		error: function(error) {
	
			  toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.')
			
		}
	});

}
/**
 * 
 * @param {DATO DE ID FICHA} id_ficha 
 * @param {EL CAMPO DE LA BD} item 
 * @param {CONTENIDO DEL OBJETO} valor 
 * @param {LA TABLA DE LA BD} tabla 
 * @description {QUE PUEDE MODIFICAR EL VALOR DE UN CAMNPO DE UNA TABLA PASADA POR PARAMETRO}
 * @author Danpinch
 */
function borrarMalestarDatosClinicos(id_ficha,item,valor, tabla) {
	var datos = new FormData();
	datos.append("guardarMalestar", "guardarMalestar");
	datos.append("id_ficha", id_ficha);
	datos.append("item", item);
	datos.append("valor",valor);
	datos.append("tabla",tabla);
	$.ajax({
		url:"ajax/malestar.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {
			if (respuesta == "ok") {
				//toastr.success('El Dato se guardó correctamente.')	
			} else {	
				toastr.warning('¡Error! Falla en la consulta a BD, no se modificaron.')
			}	
		  },
		error: function(error) {	
			  toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.')			
		}
	});

}

$("#nuevoMalestaresGeneral").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "malestar_general";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
}
);
$("#nuevoMalestaresFiebre").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "fiebre";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});
$("#nuevoMalestaresTos").change(function(){	
	var id_ficha= $("#idFicha").val();
	item = "tos_seca";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});
$("#nuevoMalestaresCefalea").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "cefalea";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});
$("#nuevoMalestaresDifRespiratoria").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "dificultad_respiratoria";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});
$("#nuevoMalestaresMialgias").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "mialgias";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});
$("#nuevoMalestaresDolorGaraganta").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "dolor_garganta";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});
$("#nuevoMalestaresPerdOlfato").change(function(){
	var id_ficha= $("#idFicha").val();
	item = "perdida_olfato";
	valor = $(this).val();
	tabla = "malestar";
	if($(this).prop('checked')){
		crearMalestarDatosClinicos(id_ficha,item,valor,tabla);
	}
	else{
		crearMalestarDatosClinicos(id_ficha,item,"",tabla);
	}
});

/**
 * EVENTO SI EL PASIENTE TIENE SINTOMAS PUEDE SELECCIONAR EL MALESTAR
 * POR EL NO BORRAR TODOS LOS MALESTARES 
 */
$("#nuevoPasienteSintomatico").change(function(){
	var id_ficha = $ ("#idFicha").val();
	if($(this).prop('checked')){

	   $('#nuevoPasienteAsintomatico-error').hide();
	   $("#divSintomas").show();
	   $("#nuevoFechaInicioSintomasDiv").show();   
	   $("#divSintomasEstado").show();
	   $("#divSintomasEstado").show();
	   $("#divSintomasClinico").show();
	   $("#divSintomasClinico").show();
	   $("#nuevoPasienteAsintomatico").attr('disabled','disabled');
	   actualizarCampoFicha(id_ficha, "sintoma", "sintomatico", "datos_clinicos");
	}else{

		swal.fire({

			title: "¿Está seguro de destiquear esta opcion?",
			text: "¡se borraran todos los datos seleccionados anteriormente en la seccion!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, lo entiendo!"
		
		}).then((result)=> {
		
			if (result.value) {
				
				$('#nuevoPasienteAsintomatico-error').show();

				$("nuevoPasienteAsintomatico").prop('checked',true);
				$("#nuevoFechaInicioSintomasDiv").hide();
				$("#divSintomasEstado").hide();
				$("#divSintomasEstado").hide();
				$("#divSintomasClinico").hide();
				$("#divSintomasClinico").hide();
				$("#divSintomas").hide();
				actualizarCampoFicha(id_ficha, "sintoma", "", "datos_clinicos");
				$("#nuevoPasienteAsintomatico").removeAttr('disabled');
				$("#nuevoFechaInicioSintomas").val("");
				actualizarCampoFicha(id_ficha, "fecha_inicio_sintomas", "", "datos_clinicos");
				$("#nuevoMalestaresGeneral").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"malestar_general","","malestar");	   
				$("#nuevoMalestaresFiebre").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"fiebre","","malestar");	   
				$("#nuevoMalestaresTos").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"tos_seca","","malestar");	   
				$("#nuevoMalestaresCefalea").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"cefalea","","malestar");	   
				$("#nuevoMalestaresDifRespiratoria").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"dificultad_respiratoria","","malestar");	   
				$("#nuevoMalestaresMialgias").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"mialgias","","malestar");	   
				$("#nuevoMalestaresDolorGaraganta").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"dolor_garganta","","malestar");	   
				$("#nuevoMalestaresPerdOlfato").prop('checked',false);
				borrarMalestarDatosClinicos(id_ficha,"perdida_olfato","","malestar");
				$("#nuevoMalestaresOtros").val("");
				borrarMalestarDatosClinicos(id_ficha,"otros","","malestar");
		
				$("#nuevoEstadoPaciente").val("");
				actualizarCampoFicha(id_ficha,"estado_paciente","","datos_clinicos");
				$("#nuevoDiagnosticoClinico").val("");
				actualizarCampoFicha(id_ficha,"diagnostico_clinico","","datos_clinicos");
				$("#nuevoFechaDefuncion").val("");
				actualizarCampoFicha(id_ficha,"fecha_defuncion","","datos_clinicos");
				
			}
			else{
				$("#nuevoPasienteSintomatico").prop("checked",true);
			}
		
		});
	}
	
});

$("#tomoMuestraLaboratorioSi").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "estado_muestra";
	tabla= "laboratorios";
	if($(this).prop('checked')){

		$("#tomoMuestraLaboratorioNo-error").hide();

		$("#tomoMuestraLaboratorioNo").attr('disabled','disabled');
		$('#nuevoTipoMuestra').removeAttr('disabled','disabled');
		$("#divObservaciones").show();
		$("#divFechaEnvio").show();
		$("#divFechaMuestra").show();
		$("#divTipoMuestra").show();
		actualizarCampoFicha(id_ficha,item,"si",tabla);
	}else{

		swal.fire({

			title: "¿Está seguro de destiquear esta opcion?",
			text: "¡se borraran todos los datos introduccidos anteriormente en la seccion!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, lo entiendo!"
		
		}).then((result)=> {
		
			if (result.value) {
		
				$("#tomoMuestraLaboratorioNo-error").show();

				$("#tomoMuestraLaboratorioNo").removeAttr('disabled');
				$("#divObservaciones").hide();
				$("#divFechaEnvio").hide();
				$("#divFechaMuestra").hide();
				$("#divTipoMuestra").hide();
				$("#nuevoTipoMuestra").val("");
				actualizarCampoFicha(id_ficha,"tipo_muestra","",tabla);
				$("#nuevoFechaMuestra").val("");
				actualizarCampoFicha(id_ficha,"fecha_muestra","",tabla);
				$("#nuevoFechaEnvio").val("");
				actualizarCampoFicha(id_ficha,"fecha_envio","",tabla);
				$("#nuevoObsMuestra").val("");
				actualizarCampoFicha(id_ficha,"observaciones_muestra","",tabla);
				actualizarCampoFicha(id_ficha,item,"",tabla);
		
			}
			else{
				$("#tomoMuestraLaboratorioSi").prop('checked',true);
			}
		
		});
	}
});

$("#tomoMuestraLaboratorioNo").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "estado_muestra";
	tabla= "laboratorios";
	valor = $(this).val();
	if($(this).prop('checked')){

		$("#tomoMuestraLaboratorioSi-error").hide();

		$("#tomoMuestraLaboratorioSi").attr('disabled','disabled');
		$('#rechazoMuestra').removeAttr('disabled','disabled');

		$("#divNoTomaMuestra").show();
		actualizarCampoFicha(id_ficha,item,"no",tabla);
	}else{

		swal.fire({

			title: "¿Está seguro de destiquear esta opcion?",
			text: "¡se borraran todos los datos introduccidos anteriormente en la seccion!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, lo entiendo!"
		
		}).then((result)=> {
		
			if (result.value) {
				
				$("#tomoMuestraLaboratorioSi-error").show();
				$("#tomoMuestraLaboratorioSi").removeAttr('disabled');
				//("#tomoMuestraLaboratorioSi").
				$("#divNoTomaMuestra").hide();
				$("#rechazoMuestra").val("");
				actualizarCampoFicha(id_ficha,item,"",tabla);
				actualizarCampoFicha(id_ficha,"des_no_muestra","",tabla);	
		
			}
			else{
				$("#tomoMuestraLaboratorioNo").prop('checked',true);
			}
		
		});	
	}
});

$("#nuevaDiscapacidad").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "discapacidad";
	tabla= "pacientes_asegurados";
	valor = $(this).val();
	if(valor=="SI"){
		$("#divDatosApoderado").show();
		actualizarCampoFicha(id_ficha, item, valor, tabla);		
	}
	else if($(this).val()=="NO"){
		$("#divDatosApoderado").hide();
		actualizarCampoFicha(id_ficha, item, valor, tabla);
		actualizarCampoFicha(id_ficha, 'nombre_apoderado', '', tabla);
		actualizarCampoFicha(id_ficha, 'telefono_apoderado', '', tabla);
	}
	else{
		actualizarCampoFicha(id_ficha, item, "", tabla);
	}
	
});

$("#checkPresenta").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "enf_estado";
	tabla= "enfermedades_bases";
	valor = $(this).val();
	if($(this).prop('checked')){
		$("#divEnfermedadBase").show();
		$("#checkNoPresenta").attr('disabled','disabled');
		actualizarCampoFicha(id_ficha, item, "presenta", tabla);
	}
	else{
		swal.fire({
			title: "¿Está seguro de destiquear esta opcion?",
			text: "¡se borraran todos los datos seleccionados anteriormente en la seccion!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, lo entiendo!"
		}).then((result)=>{
			if(result.value){
				$("#checkNoPresenta").removeAttr('disabled');
				$("#divEnfermedadBase").hide();
				actualizarCampoFicha(id_ficha, item, "", tabla);
				$("#nuevoHipertensionArterial").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"hipertension_arterial","",tabla);
				$("#nuevoObesidad").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"obesidad","",tabla);
				$("#nuevoDiabetes").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"diabetes_general","",tabla);
				$("#nuevoEmbarazo").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"embarazo","",tabla);
				$("#nuevoEnfOnco").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"enfermedades_oncologica","",tabla);
				$("#nuevoEnfCardiaca").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"enfermedades_cardiaca","",tabla);
				$("#nuevoEnfRespiratoria").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"enfermedad_respiratoria","",tabla);
				$("#nuevoEnfRenalCronica").prop('checked',false);
				actualizarCampoFichaEnfermedades(id_ficha,"enfermedades_renal_cronica","",tabla);
				$("#nuevoEnfRiesgoOtros").val("");
				actualizarCampoFichaEnfermedades(id_ficha,"otros","",tabla);
			}else{
				$(this).prop('checked',true);
			}
		});
			
	}
});

$("#checkNoPresenta").change(function(){
	var id_ficha = $ ("#idFicha").val();
	item = "enf_estado";
	tabla= "enfermedades_bases";
	valor = $(this).val();
	if($(this).prop('checked')){
		$("#checkPresenta-error").hide();
		$("#checkPresenta").attr('disabled','disabled');
		actualizarCampoFicha(id_ficha, item, valor, tabla);
	}
	else{
		$("#checkPresenta-error").show();
		$("#checkPresenta").removeAttr('disabled');
		actualizarCampoFicha(id_ficha, item, "", tabla);
	}
});


/**********
* end danpinch
**********/


/****************************************************************************************************************************************
 *                            code M@rk
 *************************************************************************************************************************************/
$("#covidPositivoAntes").change(function() {
	//Este campo representara si fue diagnosticado con COVID anteriormente
	
	item = "diagnosticado_covid_anteriormente";
	valor = $("#covidPositivoAntes option:selected").val();
	tabla = "ant_epidemiologicos";

	// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA

	actualizarCampoFicha($("#idFicha").val(), item, valor, tabla)

	if (valor == "SI") {
		$('#covidPositivoAntesFecha').removeAttr('readonly');
		$('#covidPositivoAntesFecha').attr("required","required");
		$('#covidPositivoAntesFecha').css('background-color', '#ffffff');

	}
	else if (valor == "NO" || valor == "0"){		

		actualizarCampoFicha($("#idFicha").val(), 'fecha_covid_anteriormente','', 'ant_epidemiologicos');

		$('#covidPositivoAntesFecha').attr('value','dd/mm/aa');
		$('#covidPositivoAntesFecha').val('dd/mm/aa');
		$('#covidPositivoAntesFecha').removeClass('valido');
		$('#covidPositivoAntesFecha').attr('readonly','readonly');
		$('#covidPositivoAntesFecha').css('background-color', '#e9ecef');
	}

});


//covidPositivoAntes
$("#covidPositivoAntesFecha").change(function() {

	item = "fecha_covid_anteriormente";
	valor = $(this).val();
	tabla = "ant_epidemiologicos";
	id_ficha = $("#idFicha").val();

	// ACTUALIZA UN VALOR MODIFICADO DE LA FICHA
	$('#covidPositivoAntesFecha').attr('value', valor);
	actualizarCampoFicha(id_ficha, item, valor, tabla);

});

/*****************************
 *  Actualizar Paises
 *****************************/

$('#paisInfeccion').change(function(){
	nombrePais = $('#paisInfeccion option:selected').text();
	//	alert("pais: "+ nombrePais);
	if(nombrePais != 'Bolivia'){
		$('#ubicacionLugarDeInfeccion').hide();
		$('#lugaraproximado').removeAttr('disabled');
		$('#lugaraproximado').css('background-color', '#ffffff');

		resetearCamposTabla($("#idFicha").val(),'departamento_contacto_covid','', 'ant_epidemiologicos');
		resetearCamposTabla($("#idFicha").val(),'provincia_contacto_covid','', 'ant_epidemiologicos');
		resetearCamposTabla($("#idFicha").val(),'localidad_contacto_covid','', 'ant_epidemiologicos');		

		$('#departamentoProbableInfeccion option[value=0]').attr('selected','selected');
		$('#provinciaProbableInfeccion option[value=0]').attr('selected','selected');
		$('#municipioProbableInfeccion option[value=0]').attr('selected','selected');

		$('#municipioProbableInfeccion').empty();
	}

	if(nombrePais == 'Bolivia'){

		resetearCamposTabla($("#idFicha").val(),'lugar_aproximado_infeccion','', 'ant_epidemiologicos');
		departamento = $('#departamentoProbableInfeccion option:selected').text();
		provincia = $('#provinciaProbableInfeccion option:selected').text();
		if(departamento != 'Elegir...')
        	resetearCamposTabla($("#idFicha").val(),'departamento_contacto_covid', departamento, 'ant_epidemiologicos');
        if(provincia != 'Elegir...')
			resetearCamposTabla($("#idFicha").val(),'provincia_contacto_covid', provincia, 'ant_epidemiologicos');

		$('#ubicacionLugarDeInfeccion').show();
		$('#lugaraproximado').css('background-color', '#e9ecef');
		$('#lugaraproximado').attr('disabled','disabled');
		$('#lugaraproximado').val('');
		$('#departamentoProbableInfeccion').removeAttr('disabled');
	}
	actualizarCampoFicha($("#idFicha").val(),'pais_contacto_covid', nombrePais, 'ant_epidemiologicos');
});


/**
 * Actualizar Departamentos
 */

$('#departamentoProbableInfeccion').change(function(){
	nombreDepart = $('#departamentoProbableInfeccion option:selected').text();
	$('#provinciaProbableInfeccion').removeAttr('disabled');
	$('#municipioProbableInfeccion').removeAttr('disabled');

	//alert("cambio depart: "+nombreDepart);
	resetearCamposTabla($("#idFicha").val(),'departamento_contacto_covid', nombreDepart, 'ant_epidemiologicos');
	recargarProvinciasAyax();
});

/***************************************************
 *  DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO
 ***************************************************/
 $('#ambulatorio').change(function(){
	 //alert("cambio el checked");
	 if ($('#ambulatorio').prop('checked') ){
		$('#paraInternado').hide();
		$('#nuevoLugarAislamiento').removeAttr('disabled');
		$('#nuevoFechaAislamiento').removeAttr('disabled');

		$('#nuevoLugarAislamiento').css('background-color', '#ffffff');
		$('#nuevoFechaAislamiento').css('background-color', '#ffffff');

		$('#nuevoFechaInternacion').attr('disabled','disabled');

		$('#internado').attr('disabled','disabled');
		actualizarCampoFicha($("#idFicha").val(),'metodo_hospitalizacion','AMBULATORIO', 'hospitalizaciones_aislamientos');

		//puse por el validate
/* 		$('#labelAmbulatorio').css('background-color','#ffffff');		
		$('#labelInternado').css('background-color','#ffffff');
		$('#internado').removeClass('error'); */
	 }
	else {
		
			swal.fire({

				title: "¿Está seguro de destiquear esta opcion?",
				text: "¡se borraran todos los datos introduccidos anteriormente en la seccion!",
				icon: "question",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				cancelButtonText: "Cancelar",
				confirmButtonText: "¡Si, lo entiendo!"
			
			}).then((result)=> {
			
				if (result.value) {
			
					actualizarCampoFicha($("#idFicha").val(),'metodo_hospitalizacion','', 'hospitalizaciones_aislamientos');
					$('#paraInternado').show();
					$('#nuevoLugarAislamiento').attr('disabled','disabled');
					$('#nuevoFechaAislamiento').attr('disabled','disabled');
					$('#nuevoFechaAislamiento').removeClass('valido');
					$('#nuevoFechaInternacion').attr('disabled','disabled');
					$('#internado').removeAttr('disabled');
			
					//seteamos los campos
			
					idFicha = $("#idFicha").val();
			
					$('#nuevoFechaAislamiento').attr('disabled','disabled');
					$('#nuevoFechaAislamiento').attr('value','dd/mm/aa');
					$('#nuevoFechaAislamiento').val('dd/mm/aa');
					$('#nuevoFechaAislamiento').removeClass('error');
					$('#nuevoFechaAislamiento').removeClass('valido');
					resetearCamposTabla(idFicha,'fecha_aislamiento','','hospitalizaciones_aislamientos');

					$('#nuevoLugarAislamiento').css('background-color', '#e9ecef');
					$('#nuevoFechaAislamiento').css('background-color', '#e9ecef');					
			
					$('#nuevoFechaInternacion').attr('disabled','disabled');
					$('#nuevoFechaInternacion').attr('value','dd/mm/aa');
					$('#nuevoFechaInternacion').val('dd/mm/aa');
					resetearCamposTabla(idFicha,'fecha_internacion','','hospitalizaciones_aislamientos');
			
					$('#nuevoLugarAislamiento').attr('disabled','disabled');
					$('#nuevoLugarAislamiento').removeClass('valido');
					$('#nuevoLugarAislamiento').val('');
					resetearCamposTabla(idFicha,'lugar_aislamiento','','hospitalizaciones_aislamientos');

				}
				else{
					$('#ambulatorio').prop("checked",true);
				}
			
			});		
	}
	 
 });


 $('#internado').change(function(){
	//alert("cambio el checked");
	if ($('#internado').prop('checked') ) {

		$('#ambulatorio-error').hide();

		$('#ambulatorio').attr('disabled','disabled');

         //habilitamos los campos
		$('#nuevoLugarAislamiento').attr('disabled','disabled');
		$('#nuevoFechaAislamiento').attr('disabled','disabled');

		$('#nuevoFechaInternacion').removeAttr('disabled');
		$('#nuevoFechaInternacion').removeClass('valido');
        $('#nuevoFechaInternacion').css('background-color', '#ffffff');


		$('#nuevoVentilacionMecanica').removeAttr('disabled');

		$('#nuevoVentilacionMecanica option[value="0"]').prop('selected',false);
	
		$('#nuevoTerapiaIntensiva option[value="0"]').prop('selected',false);

		//$('#nuevoEstablecimientoInternacion').removeAttr('disabled');
		$('#nuevoEstablecimientoInternacion option[value="0"]').attr("selected",false);
		$('#nuevoEstablecimientoInternacion option[value="4"]').attr("selected",true);
		actualizarCampoFicha($("#idFicha").val(),'establecimiento_internacion','HOSPITAL OBRERO NRO 2', 'hospitalizaciones_aislamientos');
		//$('#nuevoEstablecimientoInternacion').attr('disabled','disabled');


		$('#nuevoTerapiaIntensiva').removeAttr('disabled');

		$('#nuevoFechaIngresoUTI').attr('disabled','disabled');

		actualizarCampoFicha($("#idFicha").val(),'metodo_hospitalizacion','INTERNADO', 'hospitalizaciones_aislamientos');

		//puse por el validate
/* 		$('#labelAmbulatorio').css('background-color','#ffffff');
		$('#labelInternado').css('background-color','#ffffff');
		$('#ambulatorio').removeClass('error'); */
	}
	else{

		swal.fire({

			title: "¿Está seguro de destiquear esta opcion?",
			text: "¡se borraran todos los datos introduccidos anteriormente en la seccion!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si, lo entiendo!"
		
		}).then((result)=> {
		
			if (result.value) {
				
				$('#ambulatorio-error').show();

				actualizarCampoFicha($("#idFicha").val(),'metodo_hospitalizacion','', 'hospitalizaciones_aislamientos');
				$('#ambulatorio').removeAttr('disabled');

				$('#nuevoLugarAislamiento').attr('disabled','disabled');
				$('#nuevoFechaAislamiento').attr('disabled','disabled');

				$('#nuevoFechaInternacion').attr('disabled','disabled');
				$('#nuevoFechaInternacion').removeClass('error');
				$('#nuevoFechaInternacion').css('background-color', '#e9ecef');

				$('#nuevoVentilacionMecanica').attr('disabled','disabled');
				//$('#nuevoEstablecimientoInternacion').attr('disabled','disabled');
				$('#nuevoTerapiaIntensiva').attr('disabled','disabled');
				//$('#nuevoTerapiaIntensiva option:[value="NO"]').attr("selected",true);

				$('#nuevoFechaIngresoUTI').attr('disabled','disabled');

				//seteamos los campos
				idFicha = $("#idFicha").val();

				$('#nuevoFechaAislamiento').attr('disabled','disabled');
				$('#nuevoFechaAislamiento').attr('value','dd/mm/aa');
				$('#nuevoFechaAislamiento').val('dd/mm/aa');
				resetearCamposTabla(idFicha,'fecha_aislamiento','','hospitalizaciones_aislamientos');

				$('#nuevoFechaInternacion').attr('disabled','disabled');
				$('#nuevoFechaInternacion').attr('value','dd/mm/aa');
				$('#nuevoFechaInternacion').val('dd/mm/aa');
				$('#nuevoFechaInternacion').removeClass('valido');
				resetearCamposTabla(idFicha,'fecha_internacion','','hospitalizaciones_aislamientos');

				$('#nuevoLugarAislamiento').attr('disabled','disabled');
				$('#nuevoLugarAislamiento').val('');
				resetearCamposTabla(idFicha,'lugar_aislamiento','','hospitalizaciones_aislamientos');


				$('#nuevoEstablecimientoInternacion option[value="4"]').attr("selected",false);
				$('#nuevoEstablecimientoInternacion option[value="0"]').attr("selected",true);
				$('#nuevoEstablecimientoInternacion').attr('disabled','disabled');
				$('#nuevoEstablecimientoInternacion').removeClass('valido');
				resetearCamposTabla(idFicha,'establecimiento_internacion','','hospitalizaciones_aislamientos');


				$('#nuevoVentilacionMecanica').attr('disabled','disabled');
				//Es para eliminar el bacground de la clase error
				$('#nuevoVentilacionMecanica').removeClass('error');
				$('#nuevoVentilacionMecanica').removeClass('valido');
				$('#nuevoVentilacionMecanica').removeAttr('style');

				$('#nuevoVentilacionMecanica option[value="0"]').prop('selected',true);
				resetearCamposTabla(idFicha,'ventilacion_mecanica','','hospitalizaciones_aislamientos');
				
				$('#nuevoTerapiaIntensiva').attr('disabled','disabled');

				//Es para eliminar el bacground de la clase error
				$('#nuevoTerapiaIntensiva').removeClass('error');
				$('#nuevoTerapiaIntensiva').removeClass('valido');
				$('#nuevoTerapiaIntensiva').removeAttr('style');

				$('#nuevoTerapiaIntensiva option[value="0"]').prop('selected',true);
				resetearCamposTabla(idFicha,'terapia_intensiva','','hospitalizaciones_aislamientos');


				$('#nuevoFechaIngresoUTI').attr('disabled','disabled');
				$('#nuevoFechaIngresoUTI').removeClass('valido');
				$('#nuevoFechaIngresoUTI').attr('value','dd/mm/aa');
				$('#nuevoFechaIngresoUTI').val('dd/mm/aa');
				$('#nuevoFechaIngresoUTI').css('background-color', '#e9ecef');
				resetearCamposTabla(idFicha,'fecha_ingreso_UTI','','hospitalizaciones_aislamientos');
			}
			else{
				$('#internado').prop("checked",true);		
			}		
		});
	}
});
 
/***************************************************
 *  ACTUALIZACION DEL CAMPO MUNICIPIO SECCION 1
 ***************************************************/
$('#municipio').change(function(){
	valor = $('#municipio option:selected').val();
	//alert("municipio "+ valor);
	actualizarCampoFicha($("#idFicha").val(),'id_municipio', valor, 'fichas');
});


/**************************************************************************************************
 * GUARDAR LOS CAMPOS DE ANTECEDENTES EPIDEMIOLOGICOS DEPARTAMENTO, PROVINCIA, MUNICIPIO
 **************************************************************************************************/
$("#provinciaProbableInfeccion").change(function() {
	$('#municipioProbableInfeccion').removeAttr('disabled');
	item = "provincia_contacto_covid";
	tabla = "ant_epidemiologicos";
	valor = $("#provinciaProbableInfeccion option:selected").text();

	$('#municipioProbableInfeccion').empty();
	if(valor == 'Elegir...')
		resetearCamposTabla($("#idFicha").val(),'localidad_contacto_covid','','ant_epidemiologicos');
		
	
	//ACTUALIZAMOS CAMPO EN TABLA ANT_EPIDEMIOLOGICOS
	if(valor != 'Elegir...')
		actualizarCampoFicha($("#idFicha").val(), item, valor, tabla);
	else resetearCamposTabla($("#idFicha").val(),'provincia_contacto_covid','','ant_epidemiologicos');	

	recargarMunicipiosAyax();
});

$("#municipioProbableInfeccion").change(function() {
	item = "localidad_contacto_covid";
	tabla = "ant_epidemiologicos";
	valor = $("#municipioProbableInfeccion option:selected").text();
	
	// ACTUALIZAMOS CAMPO EN TABLA ANT_EPIDEMIOLOGICOS
	actualizarCampoFicha($("#idFicha").val(), item, valor, tabla);
});

/***************************************************************************************
 * Recarga los dinamicamente con ajax seccion 3.ANTECEDENTES EPIDEMIOLOGICOS
 ***************************************************************************************/

function recargarMunicipiosAyax(){
	var id_ficha = $("#idFicha").val();
	valor = $("#provinciaProbableInfeccion option:selected").val();
	//alert(valor);
	datos = new FormData();

	if(valor != 0){
		datos.append('idProvincia',valor);
		 $.ajax({
			url: "ajax/aseguradoDepartamento.ajax.php",
			type: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta) {
				$("#municipioProbableInfeccion").empty();
	
					var respuestas = JSON.parse(respuesta);
					for(i = 0; i < respuestas.length; i++){
						$("#municipioProbableInfeccion").append("<option value='"+ respuestas[i].id +"'>"+ respuestas[i].nombre_municipio +"</option>");
					}
					actualizarCampoFicha($("#idFicha").val(),'localidad_contacto_covid', respuestas[0].nombre_municipio, 'ant_epidemiologicos');		
			}
		}); 
	}
}

/***************************************************************************************
 * Recarga las provincias dinamicamente con ajax seccion 3.ANTECEDENTES EPIDEMIOLOGICOS
 ***************************************************************************************/

function recargarProvinciasAyax(){
	var id_ficha = $("#idFicha").val();
	valor = $("#departamentoProbableInfeccion option:selected").val();
	//alert(valor);
	datos = new FormData();

	datos.append('idDepartamento',valor);
 	$.ajax({
		url: "ajax/aseguradoDepartamento.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {
			$("#provinciaProbableInfeccion").empty();
			//$("#municipioProbableInfeccion").removeAttr('disabled');
			var respuestas = JSON.parse(respuesta);
			if(respuestas.length > 0){
				for(i = 0; i < respuestas.length; i++){
					$("#provinciaProbableInfeccion").append("<option value='"+ respuestas[i].id +"'>"+ respuestas[i].nombre_provincia +"</option>");
				}
				actualizarCampoFicha($("#idFicha").val(),'provincia_contacto_covid', respuestas[0].nombre_provincia, 'ant_epidemiologicos');		
				recargarMunicipiosAyax();

			}
			else{
				$("#provinciaProbableInfeccion").empty();
				$("#municipioProbableInfeccion").empty();
				resetearCamposTabla($("#idFicha").val(),'provincia_contacto_covid','', 'ant_epidemiologicos');
				resetearCamposTabla($("#idFicha").val(),'localidad_contacto_covid','', 'ant_epidemiologicos');
			}
		}
	}); 
}



/********************************************************************************************************************
 * PARA RESETEAR LOS CAMPOS UN VEZ QUE ESCOJA UN PAIS DIFERENTE DE BOLIVIA EN LA SECCION ANTECEDENTES EPIDEMIOLOGICOS
 ********************************************************************************************************************/

function resetearCamposTabla(id_ficha, item, valor, tabla) {

	var datos = new FormData();

	datos.append("guardarCampoFicha", "guardarCampoFicha");
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
			console.log("Se borraron los campos exitosamente");	
		},
		error: function(error) {
			toastr.warning('¡Error! Falla 2 en la conexión a BD, no se modificaron.') 
		}
	});

}

$('#lugaraproximado').change(function(){
	valor = $('#lugaraproximado').val();
	var validar = /^[A-Za-z0-9#ñÑáéíóúÁÉÍÓÚ .-]+$/;
	if(valor.length >= 4 &&  validar.test(valor)){
		//alert("dejo del text: "+ valor);
		actualizarCampoFicha($("#idFicha").val(),'lugar_aproximado_infeccion', valor, 'ant_epidemiologicos');
	}
});

$('#nuevoCodEmpleador').change(function(){
	valor = $('#nuevoCodEmpleador').val();
	var validar = /^[A-Za-z0-9 .-]+$/;
	if(valor.length >= 3 &&  validar.test(valor)){
		//alert("dejo del text: "+ valor);
		actualizarCampoFicha($("#idFicha").val(),'cod_empleador', valor, 'pacientes_asegurados');
	}
});

$('#nuevoNombreEmpleador').change(function(){
	valor = $('#nuevoNombreEmpleador').val();
	var validar = /^[A-Za-z0-9#ñÑáéíóúÁÉÍÓÚ .-]+$/;
	if(valor.length >= 3 &&  validar.test(valor)){
		//alert("dejo del text: "+ valor);
		actualizarCampoFicha($("#idFicha").val(),'nombre_empleador', valor, 'pacientes_asegurados');
	}
});

$('#nuevoCodLaboratorio').change(function(){
	valor = $('#nuevoCodLaboratorio').val();
	var validar = /^[A-Za-z0-9 .-]+$/;
	if(valor.length >= 4 &&  validar.test(valor)){
		//alert("dejo del text: "+ valor);
		actualizarCampoFicha($("#idFicha").val(),'cod_laboratorio', valor, 'laboratorios');
	}
});

$("#btnInfoCi").on("mouseover", function(evt){
	var x = evt.pageX;
	var y = evt.pageY;
	$(".mensaje").css('left',x);
	$(".mensaje").css('top',y);
	$(".mensaje").css('visibility','visible');

});
$("#btnInfoCi").on("mouseout",function(){
	$(".mensaje").css('visibility','hidden');
});

$(document).on("click", "button.btnSeguimiento", function() {
	//alert("clil");
	var idFicha = $(this).attr("idFicha");
	window.location = "index.php?ruta=nuevo-ficha-control&idFicha="+idFicha;
}); 
	

/* Cuando cambie la fecha de nacimineto calcula la edad del paciente y lo refleja en el campo edad */
$('#nuevoFechaNacPaciente').change(function(){	
	var edad = calcularEdad($(this).val());
	$('#nuevoEdadPaciente').val(edad);
	actualizarCampoFicha($("#idFicha").val(),"edad",edad,'pacientes_asegurados');	
});

/**
 * Funcion para comparar tabla covid_resultados con tabla laboratorios, (ambas tablas deben ser identicas )
 * esta funcion nos muestra cuales son las distintas para corregir
 */

$('#btnCompararLabCovidResultados').on("click", function(){

	var datos = new FormData();
	datos.append("controlarBD", "unificarLabCovid");
	$.ajax({

		url:"ajax/datatable-fichas.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {
			console.log("Esta es la Respuesta: ");
			console.log(respuesta);
/* 			if (respuesta != "error") {

				swal.fire({					
					icon: "success",
					title: "¡FICHA EPIDEMIOLÓGICA generada correctamente!",
					showConfirmButton: true,
					allowOutsideClick: false,
					confirmButtonText: "Aceptar"

				}).then((result) => {
  					
  					if (result.value) {
					}

				});

			} else {
				
			} */

		},
		error: function(error) {

	        console.log("No funciona");
	        
	    }

	});
});

/**
 * Funcion que Eliminara una ficha epidemiologica de raiz con todos sus dependientes
 * Precaucion al eliminar porque lo borra de todas las tablas
 */

 
$(document).on("click","button.btnEliminarFicha",function(){

	swal.fire({

		title: "¿Está seguro? Esta acción no se puede deshacer",
		text: "¡Se borrará completamente con todas sus dependencias!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "¡Si, borrar!"

	}).then((result)=> {

		if (result.value) {

			var idFicha = $(this).attr("idFicha");
			
 			var datos = new FormData();
			datos.append("eliminarFichaX", 'eliminarFichaX');
			datos.append("idFicha", idFicha);

			$.ajax({
				url: "ajax/fichas.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "html",
				success: function(respuesta) {
					console.log(respuesta);
				
					if (respuesta == "ok") {
						swal.fire({							
							icon: "success",
							title: "¡Los datos se eliminaron correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Aceptar"

						}).then((result) => {							  
							  if (result.value) {
								table.ajax.reload( null, false );
							}
						});

					} else {

						swal.fire({
								
							title: "¡Error en la Transacción o conexión a la Base de Datos!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						});
						
					}

				},
				error: function(error) {

					console.log("No funciona");
					
				}

			});

		}

	});
});

/**
 * Funcion que eliminara todas las fichas incompletas o todas las que 
 * estan pintadas con color rojo 
 */

 $(document).on("click","button#btnBorrarFichasMalasAll",function(){

	swal.fire({

		title: "¿Está seguro? Esta acción no se puede deshacer",
		text: "¡Se borraran todas las fichas Incompletas!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		cancelButtonText: "Cancelar",
		confirmButtonText: "¡Si, borrar!"

	}).then((result)=> {
	
		if (result.value) {

			swal.fire({
				text: 'Procesando...',
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false,
				onOpen: () => {
					swal.showLoading()
				}
			});

 			var datos = new FormData();
			datos.append("eliminarFichaAll", 'eliminarFichaAll');

			$.ajax({
				url: "ajax/fichas.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "html",
				success: function(respuesta) {
					//console.log(respuesta);
					swal.close();
					if (respuesta == "ok") {
						swal.fire({							
							icon: "success",
							title: "¡Todas las fichas Incompletas se eliminaron correctamente!",
							showConfirmButton: true,
							allowOutsideClick: false,
							confirmButtonText: "Aceptar"

						}).then((result) => {							  
							  if (result.value) {
								table.ajax.reload( null, false );
							}
						});

					} else {

						swal.fire({
								
							title: "¡Error en la Transacción o conexión a la Base de Datos!",
							icon: "error",
							allowOutsideClick: false,
							confirmButtonText: "¡Cerrar!"

						});
						
					}

				},
				error: function(error) {

					console.log("No funciona");
					
				}

			}); 

		}

	});
});

/*******************************************************************
 * Funciones que verifican el recargado de pagina segun las url M@rk
 *******************************************************************/

function addListenerSMS(){
	$("body").attr('onbeforeunload', 'return myFunction()');
}

function removeListenerSMS(){
  document.body.removeAttribute('onbeforeunload');
  window.onbeforeunload = null;
}

function myFunction() {
  //return "are you sure leave the current page";
  return '';
}

function revisarURL(){
  //console.log(window.location.href);
  var ruta = window.location.href;
  var nuevaFicha  = "nuevo-ficha-epidemiologica";
  var editarFicha = "editar-ficha-epidemiologica";
  let posNuevo = ruta.indexOf(nuevaFicha);
  let posEditar = ruta.indexOf(editarFicha);

  if (posNuevo !== -1 || posEditar !== -1){
		  addListenerSMS();
		  //console.log("se activo sms: 1");
  }
  else{
	  //console.log("se desactivo sms: desconocido2");
	  removeListenerSMS();
  }
}

var revisarRuta = setInterval(revisarURL, 2000);

/*******************************************************************
 * Funciones Generica que revisala a URL en la que te encuentras M@rk
 *******************************************************************/
function revisarURLGeneric(rutaAprobar){
	var ruta = window.location.href;
	let posNuevo = ruta.indexOf(rutaAprobar);
	if (posNuevo !== -1 ){
			return true;
	}
	else{
		return false;
	}
}
