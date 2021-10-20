/*=============================================
CARGAR LA TABLA DINÁMICA DE BENEFICIARIO AFIALIADO POR IDEMPLRESA DE LAS BD SIAIS
=============================================*/

var perfilOculto = $("#perfilOculto").val();

var idEmpleador = $("#idEmpleador").val();

$('#tablaAfiliadosEmpleadorSIAIS').DataTable({

	"ajax": "ajax/datatable-afiliadosSIAIS.ajax.php?perfilOculto="+perfilOculto+"&idEmpleador="+idEmpleador,

	"deferRender" : true,

	"retrieve" : true,

	"processing" : true,

	"pageLength" : 25,

	"language" : {

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

	"lengthChange": false

}); 

/*=============================================
BOTÓN SELECCIONAR BENEFICIARIO POR EL CRITERIO DE EMPRESAS
=============================================*/

$("#tablaAfiliadosEmpleadorSIAIS tbody").on("click", "button.btnRegistrarResultadosCovid", function() {
	
	var idAfiliado = $(this).attr("idAfiliado");

	window.location = "index.php?ruta=nuevo-covid-resultado&idAfiliado="+idAfiliado;

});


/*=============================================
BUSQUEDA DE AFILIADO A PARTIR DEL NOMBRE O COD ASEGURADO POR EL BOTON BUSCAR
=============================================*/

$(document).on("click", ".btnBuscarAfiliado", function() {

	var afiliado = $("#buscardorAfiliados").val();

	if (afiliado != "") {

		var datos = new FormData();
		datos.append("afiliado", afiliado);
		console.log(datos);
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

				$('#tablaAfiliadosSIAIS').remove();
				$('#tablaAfiliadosSIAIS_wrapper').remove();

				$("#tblAfiliadosSIAIS").append(

				  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAIS" width="100%">'+
	                
	                '<thead>'+
	                  
	                  '<tr>'+
	                    '<th>COD. ASEGURADO</th>'+
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

				var t = $('#tablaAfiliadosSIAIS').DataTable({

					"data": respuesta,

					"columns": [
			            { data: "cod_asegurado" },
			            { data: "cod_beneficiario" },
			            { data: "nombre_completo" },
			            { render: function (data, type, row) {
							var date = new Date(row.fecha_nacimiento);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD/MM/YYYY"));
						}},
			            { data: "cod_empleador" },
			            { data: "nombre_empleador" },
			            { render: function(data, type, row) {
			            	return "<div class='btn-group'><button class='btn btn-info btnAfiliadoRegistrarResultadosCovid' idAfiliado='"+row.idafiliacion+"' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>"
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
	        		
	        		"info": true 

				});

			},
		    error: function(error){

		      console.log("No funciona");
		        
		    }

		});

	} else {

		
		$('#tablaAfiliadosSIAIS').remove();
		$('#tablaAfiliadosSIAIS_wrapper').remove();

	}

});


/*=============================================
BUSQUEDA DE AFILIADO A PARTIR DEL NOMBRE O COD ASEGURADO POR EL BOTON BUSCAR PARA FICHA CASO SOSPECHOSO @DANPINCH
=============================================*/

$(document).on("click", "#btnBuscaAfiliadoFichaSospechoso", function() {
	var afiliado = $("#buscardorAfiliadosFichaSospechoso").val();
	if (afiliado != "") {
		var datos = new FormData();
		datos.append("afiliado", afiliado);
		console.log(datos);
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
				$('#tablaAfiliadosSIAIS').remove();
				$('#tablaAfiliadosSIAIS_wrapper').remove();
				$("#tblAfiliadosSIAIS").append(
				  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAIS" width="100%">'+	                
	                '<thead>'+	                  
	                  '<tr>'+
	                    '<th>COD. ASEGURADO</th>'+
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
				var t = $('#tablaAfiliadosSIAIS').DataTable({
					"data": respuesta,
					"columns": [
			            { data: "cod_asegurado" },
			            { data: "cod_beneficiario" },
			            { data: "nombre_completo" },
			            { render: function (data, type, row) {
							var date = new Date(row.fecha_nacimiento);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD/MM/YYYY"));
						}},
			            { data: "cod_empleador" },
			            { data: "nombre_empleador" },
			            { render: function(data, type, row) {
			            	return "<div class='btn-group'><button class='btn btn-info' id='btnAfiliadoFichaSospechoso' idAfiliado='"+row.idafiliacion+"' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>"
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
	        		"info": true
				});
			},
		    error: function(error){
		      console.log("No funciona");		        
		    }
		});
	} else {		
		$('#tablaAfiliadosSIAIS').remove();
		$('#tablaAfiliadosSIAIS_wrapper').remove();
	}
});

/*===============================================================
	btnAfiliadoFichaSospechoso
 ================================================================*/

 $(document).on("click","#btnAfiliadoFichaSospechoso",function(){
	window.location = "index.php?ruta=ficha-caso-sospechoso-covid19";
 });

/*=============================================
BUSQUEDA DE AFILIADO A PARTIR DEL NOMBRE O COD ASEGURADO POR EL BOTON BUSCAR FORMULARIO BAJAS @DANPINCH
=============================================*/

$(document).on("click", ".btnBuscarAfiliadoBajas", function() {

	var afiliado = $("#buscardorAfiliadosBaja").val();
	if(afiliado != " ") //Solo para nuestras busquedas con vacio
		afiliado = afiliado.trim();

	if (afiliado != "") {

		var datos = new FormData();
		datos.append("afiliado", afiliado);
		//datos.append("buscarLocal",false);
		datos.append("buscadorBajas",true)
		//console.log(datos);
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

				//console.log(respuesta);
				var bandera = respuesta.pop();
				console.log(bandera);
				//Para cerrar la alerta personalizada de loading
				swal.close();			

				$('#tablaAfiliadosSIAIS').remove();
				$('#tablaAfiliadosSIAIS_wrapper').remove();

				$("#tblAfiliadosSIAIS").append(

				  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAIS" width="100%">'+
	                
	                '<thead>'+
	                  
	                  '<tr>'+
	                    '<th>COD. ASEGURADO</th>'+
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

				if(bandera.buscadorBajas && bandera.tipoPaciente=='A'){ // ingresa a esta seccion si encontro al paciente en la BD local
					console.log(respuesta);
					 var t = $('#tablaAfiliadosSIAIS').DataTable({
						"scrollY":  "400px",
						"scrollCollapse": true,
						"data": respuesta,
	
						"columns": [
							{ data: "cod_asegurado"}, //estos son los atributos de respuesta
							{ data: "cod_afiliado" },
							{ data: "nombre_completo" },
							{ data: "fecha_nacimiento"},
							{ data: "cod_empleador" },
							{ data: "nombre_empleador" },
							{ render: function(data, type, row) {							
								var retorno
								retorno ="<div class='btn-group'>"								
								retorno +=" <button class='btn btn-danger btnBusquedaBajaActiva' codAegurado='"+
										row.cod_asegurado+"'  codafiliado='"+
										row.cod_afiliado+"' nombrecompleto='"+
										row.nombre_completo+"' fechaini='"+
										row.fecha_ini+"' fechafin='"+
										row.fecha_fin+"' observacion='"+
										row.observacion_baja+"'diasincapacidad='"+
										row.dias_incapacidad+"'data-toggle='tooltip' title='Ver Baja Activa'><i class='fas fa-eye'></i></button>"
								retorno += "</div>"
								return retorno;
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
						
						"info": true 
	
					}); 
				}
				else if(bandera.buscadorBajas && bandera.tipoPaciente=='S'){
					//console.log(respuesta);
					 var t = $('#tablaAfiliadosSIAIS').DataTable({
						"scrollY":  "400px",
						"scrollCollapse": true,	
						"data": respuesta,
	
						"columns": [
							{ data: "cod_asegurado"}, //estos son los atributos de respuesta
							{ data: "cod_afiliado" },
							{ data: "nombre_completo" },
							{ data: "fecha_nacimiento"},
							{ data: "cod_empleador" },
							{ data: "nombre_empleador" },
							{ render: function(data, type, row) {															
								var retorno ="<div class='btn-group'>"								
								retorno +="<button class='btn btn-warning btnBusquedaBajaSospechosoActiva'"
												+"id='"+String(row.id_baja).trim()+"'"
												+"codAegurado='"+String(row.cod_asegurado).trim()+"'"
												+"codAfiliado='"+String(row.cod_afiliado).trim()+"'" 
												+"nombrecompleto='"+String(row.nombre_completo).trim()+"'"
												+"fechaini='"+String(row.fecha_ini).trim()+"'"
												+"fechafin='"+String(row.fecha_fin).trim()+"'"
												+"observacion='"+String(row.observacion_baja).trim()+"'"												
												+"diasincapacidad='"+String(row.dias_incapacidad).trim()+"'"
												+"data-toggle='tooltip' title='Ver Baja por Sospecha "+row.dias_incapacidad+"'>"
											+"<i class='fas fa-eye'></i>"
											+"</button>";
								retorno += "</div>"
								return retorno;
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
						
						"info": true 
	
					});
				}
				else if(bandera.buscadorBajas && bandera.tipoPaciente=='L'){
					console.log(respuesta);
					 var t = $('#tablaAfiliadosSIAIS').DataTable({
	
						"data": respuesta,
	
						"columns": [
							{ data: "cod_asegurado"}, //estos son los atributos de respuesta
							{ data: "cod_afiliado" },
							{ data: "nombre_completo" },
							{ data: "fecha_nacimiento"},
							{ data: "cod_empleador" },
							{ data: "nombre_empleador" },
							{ render: function(data, type, row) {							
								var retorno
								retorno ="<div class='btn-group'>"								
								retorno +=" <button class='btn btn-success' id='btnAfiliadoRegistrarNuevoFormulario' idAfiliado='-1'"+
									"idPaciente='"+row.id_paciente+"'"+
									"codAegurado='"+row.cod_asegurado+"'"+
									"codAfiliado='"+row.cod_afiliado+"'"+
									"data-toggle='tooltip' title='Crear Baja'><i class='fas fa-check'></i></button>"
								retorno += "</div>"
								return retorno;
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
						"info": true	
					});
				}
				else{ // Ingresa a esta seccion si no encontro al paciente en la BD local y lo encontro en la BD SIAIS
					var t = $('#tablaAfiliadosSIAIS').DataTable({
	
						"data": respuesta,
	
						"columns": [
							{ data: "cod_asegurado" },
							{ data: "cod_beneficiario" },
							{ data: "nombre_completo" },
							{ render: function (data, type, row) {
								var date = new Date(row.fecha_nacimiento);
								date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
								return (moment(date).format("DD/MM/YYYY"));
							}},
							{ data: "cod_empleador" },
							{ data: "nombre_empleador" },
							{ render: function(data, type, row) {
								return "<div class='btn-group'><button class='btn btn-info' id='btnAfiliadoRegistrarNuevoFormulario' idAfiliado='"+row.idafiliacion+"' idPaciente='-1' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>"
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
						
						"info": true 
	
					});
				}

			},
		    error: function(error){
		      console.log("No funciona");		        
		    }

		});

	} else {

		
		$('#tablaAfiliadosSIAIS').remove();
		$('#tablaAfiliadosSIAIS_wrapper').remove();

	}

});


/*=============================================
	BUSQUEDA CON ENTER danpinch
==============================================*/

$(document).on("keypress", "#buscardorAfiliadosBaja", function(e) {
	if (e.which == 13) {
		$(".btnBuscarAfiliadoBajas").click()		
	}
})
/*=============================================
BUSQUEDA DE AFILIADO A PARTIR DEL NOMBRE O COD ASEGURADO POR LA TECLA ENTER
=============================================*/

$(document).on("keypress", "#buscardorAfiliados", function(e) {

	if (e.which == 13) {

		var afiliado = $("#buscardorAfiliados").val();

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

					$('#tablaAfiliadosSIAIS').remove();
					$('#tablaAfiliadosSIAIS_wrapper').remove();

					$("#tblAfiliadosSIAIS").append(

					  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAIS" width="100%">'+
		                
		                '<thead>'+
		                  
		                  '<tr>'+
		                    '<th>COD. ASEGURADO</th>'+
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

					var t = $('#tablaAfiliadosSIAIS').DataTable({

						"data": respuesta,

						"columns": [
				            { data: "cod_asegurado" },
				            { data: "cod_beneficiario" },
							{ data: "nombre_completo" },							
				            { render: function (data, type, row) {
								var date = new Date(row.fecha_nacimiento);
								date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
								return (moment(date).format("DD/MM/YYYY"));
							}},
				            { data: "cod_empleador" },
				            { data: "nombre_empleador" },
				            { render: function(data, type, row) {
				            	return "<div class='btn-group'><button class='btn btn-info btnAfiliadoRegistrarResultadosCovid' idAfiliado='"+row.idafiliacion+"' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>"
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
		        		
		        		"info": true 

					});

				},
			    error: function(error){

			      console.log("No funciona");
			        
			    }

			});

		} else {

			
			$('#tablaAfiliadosSIAIS').remove();
			$('#tablaAfiliadosSIAIS_wrapper').remove();

		}
	}
});

/*=============================================
BOTÓN SELECCIONAR BENEFICIARIO POR EL CRITERIO DE AFILIADOS
=============================================*/

$(document).on("click", ".btnAfiliadoRegistrarResultadosCovid", function() {
	var idAfiliado = $(this).attr("idAfiliado");
	window.location = "index.php?ruta=nuevo-covid-resultado&idAfiliado="+idAfiliado;
	
});


/*===========================================================================================
BOTÓN SELECCIONAR BENEFICIARIO POR EL CRITERIO DE AFILIADOS NUEVO FORMULARIO BAJAS @DANPINCH
=============================================================================================*/

$(document).on("click", "#btnAfiliadoRegistrarNuevoFormulario", function() {

	var idAfiliado = $(this).attr("idAfiliado");
	var idPaciente = $(this).attr("idPaciente");
	if(idPaciente == -1 && idAfiliado != -1){ // Paciente encontrado en BD SIAIS
		window.location = "index.php?ruta=nuevo-formulario-baja-asegurado&idAfiliado="+idAfiliado;
	} else if(idPaciente != -1 && idAfiliado == -1){ // Paciente encontrado en BD local
		window.location = "index.php?ruta=nuevo-formulario-baja-asegurado&idPaciente="+idPaciente;
	} else alert("No existe el paciente");
	
});

/*===========================================================================================
SCRIPTS PARA CERTIFICADO DE ALTA MANUAL @Mark
=============================================================================================*/

$(document).on("click", "#btnNuevoCertificadoAlta", function() {
	$("#modalCertificadoAlta").modal('show');
});

$(document).on("click", ".btnBuscarAfiliadosParaAltaManual", function() {

	var afiliado = $("#buscardorAfiliadosAlta").val();

	if (afiliado != "") {

		var datos = new FormData();
		datos.append("afiliadoAltaManual", afiliado);
		//console.log(datos);
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

				//console.log(respuesta);

				//Para cerrar la alerta personalizada de loading
				swal.close();			

				$('#tablaAfiliadosSIAIS').remove();
				$('#tablaAfiliadosSIAIS_wrapper').remove();

				$("#tblAfiliadosSIAIS").append(

				  '<table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosSIAIS" width="100%">'+
	                
	                '<thead>'+
	                  
	                  '<tr>'+
	                    '<th>COD. ASEGURADO</th>'+
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

				var t = $('#tablaAfiliadosSIAIS').DataTable({

					"data": respuesta,

					"columns": [
			            { data: "cod_asegurado" },
			            { data: "cod_beneficiario" },
			            { data: "nombre_completo" },
			            { render: function (data, type, row) {
							var date = new Date(row.fecha_nacimiento);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD/MM/YYYY"));
						}},
			            { data: "cod_empleador" },
			            { data: "nombre_empleador" },
			            { render: function(data, type, row) {
							//console.log(row);
			            	return "<div class='btn-group'>"+
							       "<button class='btn btn-info' id='btnAfiliadoRegistrarCertificadoAlta'"+
								      "idAfiliado='"+ row.cod_beneficiario +
									  "' nombreCompleto='"+ row.nombre_completo +
									  "' nombre='"+ row.pac_nombre +
									  "' primerApellido='"+ row.pac_primer_apellido +
									  "' segundoApellido='"+ row.pac_segundo_apellido +
									  "' ci='"+ row.pac_documento_id +
									  "' zona='"+ row.emp_zona+
									  "' calle='"+ row.emp_calle +
									  "' sexo='"+ row.idsexo +
									  "' matricula='"+ row.cod_asegurado +
									  "' empleador='"+ row.nombre_empleador +
									  "' codempleador='"+ row.cod_empleador +
									  "' fechaNacimiento='"+ row.fecha_nacimiento +
									  "' nro='"+ row.emp_nro +
									  "' telefono='"+ row.emp_telefono +
									  "' departamento='"+ row.iddepartamentonac +
									  "' localidad='"+ row.idlocalidadnac +
									  "' municipio='"+ row.idmunicipionac +
									  "' provincia='"+ row.idprovincianac +
									  "' idNum='"+ row.idafiliacion +
									  "' data-toggle='tooltip' title='Seleccionar Afiliado'><i class='fas fa-check'></i></button></div>"
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
	        		
	        		"info": true 

				});

			},
		    error: function(error){

		      console.log("No funciona");
		        
		    }

		});

	} else {
		$('#tablaAfiliadosSIAIS').remove();
		$('#tablaAfiliadosSIAIS_wrapper').remove();
	}

});

/*=============================================
	BUSQUEDA CON ENTER danpinch
==============================================*/

$(document).on("keypress", "#buscardorAfiliadosAlta", function(e) {
	if (e.which == 13) {
		$(".btnBuscarAfiliadosParaAltaManual").click()		
	}
})

 $(document).on("click", "#btnAfiliadoRegistrarCertificadoAlta", function() {
	 
	var idAfiliado = $(this).attr("idAfiliado");
	var nombrecompleto = $(this).attr("nombrecompleto");
	var ci = $(this).attr("ci");
	var zona = $(this).attr("zona");
	var calle = $(this).attr("calle");

	var definirsexo = $(this).attr("sexo");
	//debugger
	if(definirsexo == "1")
		sexo = "M";
	else sexo = "F";

	var matricula = $(this).attr("matricula");
	var empleador = $(this).attr("empleador");
	var fechanacimiento = $(this).attr("fechanacimiento");
	var nro = $(this).attr("nro");
	var telefono = $(this).attr("telefono");

	var nombre = $(this).attr("nombre");
	var primerapellido = $(this).attr("primerapellido");
	var segundoapellido = $(this).attr("segundoapellido");
	var departamento = $(this).attr("departamento");
	var localidad = $(this).attr("localidad");
	var municipio = $(this).attr("municipio");
	var provincia = $(this).attr("provincia");
	var codempleador = $(this).attr("codempleador");

	$("#modalCertificadoAlta").modal('hide');
	
	var datos = new FormData();
	datos.append("certificadoDeAltaManual", 'certificadoDeAltaManual');
	datos.append("idAfiliado", idAfiliado);
	datos.append("nombrecompleto", nombrecompleto);
	datos.append("ci", ci);
	datos.append("zona", zona);
	datos.append("calle", calle);
	datos.append("sexo", sexo);
	datos.append("matricula", matricula);
	datos.append("empleador", empleador);
	datos.append("fechanacimiento", fechanacimiento);
	datos.append("nro", nro);
	datos.append("telefono", telefono);

	datos.append("nombre", nombre);
	datos.append("primerapellido", primerapellido);
	datos.append("segundoapellido", segundoapellido);
	datos.append("departamento", departamento);
	datos.append("localidad", localidad);
	datos.append("municipio", municipio);
	datos.append("provincia", provincia);	
	datos.append("codempleador", codempleador);

	$.ajax({
		url: "ajax/informacion_paciente.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'html',
		success: function(respuesta) {
			if(respuesta != 'sinBaja'){
				$("#modalFormularioAltaManual").modal('show');
				$("#cuerpoCertificadoAltaManual").html(respuesta);
			}
			else{
				Swal.fire({
					title: 'Ups',
					text: "¡No puede crear un Alta sin antes crear una baja!",
					icon: 'warning',
					confirmButtonColor: '#3085d6',
					confirmButtonText: 'Crear baja'
				  });
			}	
		},
		done: function (data) {
			$("#cuerpoCertificadoAltaManual").html(respuesta);
          },
	    error: function(error){
	      console.log("error", error);	        
	    }

	});
}); 

$(document).on("click", ".generarAltaManualPDF", function() {
	var idafiliado = $('#backupIdAfiliado').val();
	var zona = $('#zona').val();
	var calle = $('#calle').val();
	var nro = $('#nro').val();
	var empleador = $('#empleador').val();
	var tipoMuestra = $('#tipoMuestra').val();
	var resultado = $('#selectResultado option:selected').val(); 
	var fechaAlta = $('#fechaAlta').val();
	var centro = $('#centros').val();
	var diasBaja = $('#diasBaja').val();
	var fechaAltaini = $('#fechaAltaini').val();
	var fechaAltafin = $('#fechaAltafin').val();
	var selectcentro = $('#selectcentro').val();

	var ciAsegurado = $('#txtCi').val();
	var matriculaAsegurado = $('#matriculaAsegurado').text();

	var id_personas_notificadores = $('#backupSesion').val();
	var prueba_diagnostica = tipoMuestra;
	var fecha_resultado = fechaAlta;
	var establecimiento_resultado = centro;
	var dias_baja = diasBaja;
	var fecha_ini = fechaAltaini;
	var fecha_fin = fechaAltafin;

	var nombre = $('#txtnombre').val();
	var primerapellido = $('#txtapellidopaterno').val();
	var segundoapellido = $('#txtapellidomaterno').val();
	var departamento = $('#departamento').val();
	var localidad = $('#localidad').val();
	var municipio = $('#municipio').val();
	var provincia = $('#provincia').val();
	var fechanacimiento =  $('#fechanacimiento').val();
	var sexo =  $('#sexo').val();
	var codempleador =  $('#codEmpleador').val();

	/*console.log(nombre);
	console.log(primerapellido);
	console.log(segundoapellido);
	console.log(departamento);
	console.log(fechanacimiento);
	console.log(sexo);
	console.log(localidad);
	console.log(codempleador);
	*/

	if(zona != "" && calle != "" && nro != "" && (empleador != "Sin Empleador" || empleador != "") && tipoMuestra != "" && 
	   resultado != "" && fechaAlta != "" && centro != "" && diasBaja != "" && 
	   fechaAltaini != "" && fechaAltafin != "" && selectcentro != "seleccione" && codempleador!="" &&
	   primerapellido !="" && segundoapellido !="" && nombre!="")
	{
		swal.fire({

			title: "¿Está seguro de generar el PDF?",
			text: "¡Si esta seguro de que todos los datos son correctos prosiga!",
			icon: "question",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Cancelar",
			confirmButtonText: "¡Si estoy Seguro!"
		
		}).then((result)=> {
		
			if (result.value) {
		
				console.log("El formulario es valido");
				$("#modalFormularioAltaManual").modal('hide');
				var datos = new FormData();
		
				datos.append("generarAltaManualPDF", "generarAltaManualPDF");
				datos.append("idafiliado", idafiliado);
				datos.append("zona", zona);
				datos.append("calle", calle);
				datos.append("nro", nro);
				datos.append("codempleador", codempleador);
				datos.append("empleador", empleador);
				datos.append("tipoMuestra", tipoMuestra);
				datos.append("resultado", resultado);
				datos.append("fechaAlta", fechaAlta);
				datos.append("centro", centro);
				datos.append("diasBaja", diasBaja);
				datos.append("fechaAltaini", fechaAltaini);
				datos.append("fechaAltafin", fechaAltafin);
				datos.append("selectcentro", selectcentro);
		
				datos.append("ciAsegurado", ciAsegurado);
				datos.append("matriculaAsegurado", matriculaAsegurado);	

				datos.append("id_personas_notificadores", id_personas_notificadores);
				datos.append("prueba_diagnostica", prueba_diagnostica);
				datos.append("fecha_resultado", fecha_resultado);	
				datos.append("establecimiento_resultado", establecimiento_resultado);
				datos.append("dias_baja", dias_baja);
				datos.append("fecha_ini", fecha_ini);	
				datos.append("fecha_fin", fecha_fin);

				datos.append("nombre", nombre);
				datos.append("primerapellido", primerapellido);
				datos.append("segundoapellido", segundoapellido);
				datos.append("departamento", departamento);
				datos.append("localidad", localidad);
				datos.append("municipio", municipio);
				datos.append("provincia", provincia);
				datos.append("fechanacimiento", fechanacimiento);
				datos.append("sexo", sexo);
			
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
					/* dataType: "html", */ 
					success: function(respuesta) {
						//debugger				
						swal.close();
						
						if(respuesta != "errorBDManual"){
							$('#ver-pdf').modal({
								show:true,
								backdrop:'static'
							});
							//console.log(respuesta);
							
							PDFObject.embed("temp/"+idafiliado+"/certificado-alta-descartado-"+idafiliado+".pdf", "#view_pdf");
						}
						else{
							swal.fire({
								title: "Error de Base de Datos",
								text: "¡Error en la consulta a la Base de Datos!",
								icon: "error",
								allowOutsideClick: false,
								confirmButtonText: "¡Cerrar!"
							}).then((result) => {		  					
									if (result.value) {
									//window.location = "index.php?ruta=formulario-bajas";
								}
							});
						} 

					}
		
				});
			}
		});
	}
	else {
		camposRequeridos();
		Swal.fire({
			title: 'Ups',
			text: "¡Revise los datos, todos son requeridos",
			icon: 'warning',
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Revisar'
		  });
	}
});

function camposRequeridos(){
	if($('#txtnombre').val() == "")
		$('#txtnombre').css('border-color', 'red');
	else $('#txtnombre').css('border-color', 'initial');

	if($('#txtapellidomaterno').val() == "")
		$('#txtapellidomaterno').css('border-color', 'red');
	else $('#txtapellidomaterno').css('border-color', 'initial');

	if($('#txtCi').val() == "")
		$('#txtCi').css('border-color', 'red');
	else $('#txtCi').css('border-color', 'initial');

	if($('#zona').val() == "")
		$('#zona').css('border-color', 'red');
	else $('#zona').css('border-color', 'initial');

    if($('#calle').val() == "")	
		$('#calle').css('border-color', 'red');
	else  $('#calle').css('border-color', 'initial');

	if($('#nro').val() == "")			
		$('#nro').css('border-color', 'red');
	else  $('#nro').css('border-color', 'initial');

	if($('#empleador').val() == "")
		$('#empleador').css('border-color', 'red');
	else  $('#empleador').css('border-color', 'initial');

	if($('#fechaAlta').val() == "")
		$('#fechaAlta').css('border-color', 'red');
	else  $('#fechaAlta').css('border-color', 'initial');

	if($('#centros').val() == "")		
		$('#centros').css('border-color', 'red');
	else  $('#centros').css('border-color', 'initial');

	if($('#fechaAltaini').val() == "")		
		$('#fechaAltaini').css('border-color', 'red');
	else  $('#fechaAltaini').css('border-color', 'initial');

	if($('#fechaAltafin').val() == "")	
		$('#fechaAltafin').css('border-color', 'red');
	else  $('#fechaAltafin').css('border-color', 'initial');

	if(($('#codEmpleador').val() == "")||($('#codEmpleador').val() == 0))	
		$('#codEmpleador').css('border-color', 'red');
	else  $('#codEmpleador').css('border-color', 'initial');

	if(($('#empleador').val() == "Sin Empleador") || $('#empleador').val() == "")
		$('#empleador').css('border-color', 'red');
	else  $('#empleador').css('border-color', 'initial'); 

	if($('#selectcentro').val() == "seleccione")	
		$('#selectcentro').css('border-color', 'red');
	else  $('#selectcentro').css('border-color', 'initial');

}

function verificarFechaIni() {

	console.log("camvbiofechaIni");

 	var fecha1 = $("#fechaAltaini").val();
	var fecha2 = $("#fechaAltafin").val();
	$("#fechaAltafin").attr('min',$("#fechaAltaini").val());	

	var fecha = new Date($("#fechaAltaini").val());
	var dias = 2; // Número de días a agregar
	fecha.setDate(fecha.getDate() + dias);
	//var nuevafecha =  fecha.getFullYear() + '-' +  (fecha.getMonth() + 1) + '-' + fecha.getDate();

	//$("#fechaAltafin").attr('max','2021-04-15');
	$("#fechaAltafin").attr('max',fecha.toISOString().substring(0,10));
	$("#fechaAltafin").val($("#fechaAltaini").val());

	var diasImpedimento = restaFechas($("#fechaAltaini").val(),$("#fechaAltafin").val())+1;
	console.log(diasImpedimento);

	$('#diasBaja').val(diasImpedimento);
}

function verificarFechaFin() {

	var fecha1 = $("#fechaAltaini").val();
	var fecha2 = $("#fechaAltafin").val();
	var diasImpedimento = restaFechas(fecha1,fecha2)+1;
	$('#diasBaja').val(diasImpedimento);
}



$(document).on("click", ".btnBusquedaBajaSospechosoActiva", function() {

	$('#modalBajasActivas').modal({
		show:true,
		backdrop:'static'
	});

	nombrecompleto = $(this).attr("nombrecompleto")
	fechaini = $(this).attr("fechaini")
	fechafin = $(this).attr("fechafin")
	observacion = $(this).attr("observacion")
	diasincapacidad = $(this).attr("diasincapacidad")

	$("#detalleBajas").html("Apellidos Nombre<h6>"+nombrecompleto+"</h6>"
							+"fecha Inicio<h6>"+fechaini+"</h6>"
							+"Fecha Fin<h6>"+fechafin+"</h6>"
							+"dias Incapacidad<h6>"+diasincapacidad+"</h6>"
							+"Observacion<h6>"+observacion+"</h6>")
	
});

$(document).on("click",".btnBusquedaBajaActiva",function(){

	$('#modalBajasActivas').modal({
		show:true,
		backdrop:'static'
	});

	var nombrecompleto = $(this).attr("nombrecompleto")
	var fechaini = $(this).attr("fechaini")
	var fechafin = $(this).attr("fechafin")
	var observacion = $(this).attr("observacion")
	var diasincapacidad = $(this).attr("diasincapacidad")

	$("#detalleBajas").html("Apellidos Nombre<h6>"+nombrecompleto+"</h6>"
							+"fecha Inicio<h6>"+fechaini+"</h6>"
							+"Fecha Fin<h6>"+fechafin+"</h6>"
							+"dias Incapacidad<h6>"+diasincapacidad+"</h6>"
							+"Observacion<h6>"+observacion+"</h6>")							
})
