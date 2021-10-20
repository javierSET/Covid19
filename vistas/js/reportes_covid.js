/*=============================================
BOTON QUE GENERA LOS RESULTADOS COVID POR FILTRADO DE FECHAS Y RESULTADO
=============================================*/

$(document).on("click", ".btnCovidResultadosReporte", function() {

	$('#tablaCovidResultadosReporte').remove();
	$('#tablaCovidResultadosReporte_wrapper').remove();

	var fechaInicio = $("#reporteFechaInicio").val();
	var fechaFin = $("#reporteFechaFin").val();
	var resultado = $('input:radio[name=reporteResultado]:checked').val();

	var datos = new FormData();
	datos.append("reporte", 'reporte');
	datos.append("fechaInicio", fechaInicio);
	datos.append("fechaFin", fechaFin);
	datos.append("resultado", resultado);

	$.ajax({

		url: "ajax/reportes_covid.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {
			//console.log(respuesta);
			$("#reporteCovid").append(

			  '<table class="table table-bordered table-striped dt-responsive table-hover" id="tablaCovidResultadosReporte" width="100%">'+
                
                '<thead>'+
                  
                  '<tr>'+
                    '<th>COD. LAB.</th>'+
                    '<th>COD. ASEGURADO</th>'+
                    '<th>APELLIDOS Y NOMBRES</th>'+
                    '<th>CI</th>'+
                    '<th>NOMBRE EMPLEADOR</th>'+
                    '<th>FECHA MUESTRA</th>'+
                    '<th>FECHA RECEPCIÓN</th>'+
                    '<th>MUESTRA CONTROL</th>'+
                    '<th>DEPARTAMENTO</th>'+
                    '<th>EST.</th>'+
                    '<th>SEXO</th>'+
                    '<th>EDAD</th>'+
                    '<th>TEL/CEL</th>'+
                    '<th>FECHA RESULTADO</th>'+
                    '<th>RESULTADO</th>'+
                    '<th>OBSERVACIONES</th>'+
                    '<th>ACCIONES</th>'+
                  '</tr>'+

                '</thead>'+
                
              '</table>'  

            ); 			

			var t = $('#tablaCovidResultadosReporte').DataTable({

				"data": respuesta,

				"columns": [
					{ data: "cod_laboratorio" },
		            { data: "cod_asegurado" },
		            { data: "nombre_completo" },
		            { data: "documento_ci" },
		            { data: "nombre_empleador" },
		            { render: function (data, type, row) {
							var date = new Date(row.fecha_muestra);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD/MM/YYYY"));
					}},
					{ render: function (data, type, row) {
						  if(row.fecha_recepcion == "0000-00-00"){
							var date = new Date(row.fecha_muestra);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD/MM/YYYY"));
						  }
						  else{
							  var date = new Date(row.fecha_recepcion);
							  date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							  return (moment(date).format("DD/MM/YYYY"));
						  }
					}},
		            { data: "muestra_control" },
		            { data: "nombre_depto" },
		            { data: "abreviatura_establecimiento" },
		            { data: "sexo" },
		            { data: "edad" },
		            { data: "telefono" },
		            { render: function (data, type, row) {
							var date = new Date(row.fecha_resultado);
							date.setMinutes(date.getMinutes() + date.getTimezoneOffset())
							return (moment(date).format("DD/MM/YYYY"));
					}},
		            { data: "resultado" },
		            { data: "observaciones" },
		            { render: function(data, type, row) {
			            	return "<div class='btn-group'><button class='btn btn-danger btnReportePersonalPDF' idCovidResultado='"+row.id+"' data-toggle='tooltip' title='Generar PDF'><i class='fas fa-file-pdf'></i></button></div>"
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

				"ordering": false, 
        		
        		"info":     true,

        		//para usar los botones   
		        "responsive": true,

		        "dom": 'Bfrtilp',       
		        
		        "buttons":[

/* 						'copyHtml5',
						'excelHtml5',
						'csvHtml5',
						'pdfHtml5' */
					{
						extend:    'excelHtml5',
						title: 	   'Reporte '+fechaInicio+' '+fechaFin+' '+resultado,
						text:      '<i class="fas fa-file-excel"></i> Generar EXCEL',
						titleAttr: 'Exportar a Excel',
						className: 'btn btn-success m-1',
						
					},
					 {
					 	extend:    'pdfHtml5',
					 	text:      '<i class="fas fa-file-pdf"></i> Generar PDF',
						titleAttr: 'Exportar a PDF',
						className: 'btn btn-danger m-1',
 						action: function ( e, dt, node, config ) {
							toastr.info("Espere un momento mientras generamos el PDF...");
							var archivoPdf = $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
/* 							setTimeout(function(){																
							}, 1000); */
						},
						//orientation: 'landscape',
						orientation: 'portrait',						
						customize: function ( doc ) {

							doc.content.splice(0, 0, {

								columns: [
									{
										/* margin: [ 0, 0, 0, 12], */
										alignment: 'left',
										image: images.logoCNS,
										//image: require('../img/cns/cns-logo.png'),
										width: 20,
										opacity: 0.5,
									},
									{
										alignment: 'right',
										top:0,
										qr: 'Reportes-covid19 de: '+ resultado + ' generado por: '+ $('#nombreUsuarioOculto').val() +' en fecha:' + Date(),
										fit: 50,
										style: 'qrm'
									}
								]
							} );

							doc.styles.qrm = {							
								opacity: 0.5,
								float: 'left',
								backgroundColor: 'red'
							};
							
							doc.content[1].text = 'Reportes Covid-19 de '+ resultado /* + ' | '  +fechaInicio+' a '+fechaFin */;
							doc.defaultStyle.fontSize = 5;
							doc.styles.tableHeader.fontSize = 5;
							
							doc.pageMargins =  [ 20, 20, 20, 20 ];

							console.log("Este es el documento:");
							console.log(doc);
						},
						exportOptions: {
							columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
						},
						title: 'Reporte- '  +fechaInicio+ '-' + fechaFin + ' '+ resultado,
						/* download: 'open'  */
					 },
					 {
						extend:    'csvHtml5',
						text:      '<i class="fas fa-file-csv"></i> Generar CSV',
					    titleAttr: 'Exportar a CSV',
					    className: 'btn btn-warning m-1',
					    title: 'Reporte- '  +fechaInicio+ '-' + fechaFin + ' '+ resultado,
					},
					{
						extend:    'copyHtml5',
						text:      '<i class="fas fa-copy"></i> Copiar',
					   titleAttr: 'Copiar',
					   className: 'btn btn-secondary m-1'
					},
					 {
					 	extend:    'print',
					 	text:      '<i class="fa fa-print"></i> Imprimir',
					 	titleAttr: 'Imprimir',
					 	className: 'btn btn-info m-1',
						messageTop: 'Generado por: '+ $('#nombreUsuarioOculto').val(),
						customize: function ( win ) {
							$(win.document.body)
								.css( 'font-size', '8pt' )
								.prepend(
									'<img src="../img/cns/cns-logo.png" style="position:absolute; top:0; left:0;" />'
								);
			
							$(win.document.body).find( 'table' )
								.addClass( 'compact' )
								.css( 'font-size', 'inherit' );

							$(win.document.body).find('tr:nth-child(odd) td').each(function(index){
								$(this).css('background-color','#D0D0D0');
							});

							$(win.document.body).find('tr td').each(function(index){
								$(this).css('border','solid 1px #D0D0D0');
							});

							$(win.document.body).find('tr th').each(function(index){
								$(this).css('border','solid 1px #D0D0D0');
							});

							$(win.document.body).find('h1').css('text-align','center');
							//console.log(win);
						},
						exportOptions: {
							columns: [1, 2, 3, 5, 8, 10, 11, 12, 13, 14],
						},
						title: 'Reporte- '  +fechaInicio+ '-' + fechaFin + ' '+ resultado,				
					 },
				]	        

			});

		},
	    error: function(error){

	      console.log("No funciona");
	        
	    }

	});

});


/*=============================================
BOTON QUE GENERA EL PDF DE LOS RESULTADOS COVID POR FILTRADO DE FECHAS Y RESULTADO
=============================================*/

$(document).on("click", ".btnCovidResultadosPDF", function() {

	var fechaInicio = $("#reporteFechaInicio").val();
	console.log("fechaInicio", fechaInicio);
	var fechaFin = $("#reporteFechaFin").val();
	console.log("fechaFin", fechaFin);
	var resultado = $('input:radio[name=reporteResultado]:checked').val();

	var nombre_usuario = $("#nombreUsuarioOculto").val();

	var datos = new FormData();

	datos.append("reportePDF", "reportePDF");
	datos.append("fechaInicio", fechaInicio);
	datos.append("fechaFin", fechaFin);
	datos.append("resultado", resultado);
	datos.append("nombre_usuario", nombre_usuario);

	$('.cargando').removeClass('hide');

	$.ajax({

		url: "ajax/reportes_covid.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			$('.cargando').addClass('hide');

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	
			//daniel
			PDFObject.embed("temp/reporte-"+fechaInicio+"-"+fechaFin+"-"+resultado+".pdf", "#view_pdf");

		}

	});

});


/*=============================================
BOTON QUE PARA CERRAR LA VENTANA MODAL DEL REPORTE PDF Y ELIMINA EL ARCHIVO TEMPORAL
=============================================*/

$("#ver-pdf").on("click", ".btnCerrarReporte", function() {

	var url = $(this).parent().parent().children(".modal-body").children().children().attr("src");

	var datos = new FormData();

	datos.append("eliminarPDF", "eliminarPDF");
	datos.append("url", url);

	//elimina el pdf

/* 	$.ajax({

		url: "ajax/reportes_covid.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {
		
		}

	}); */

});

/*=============================================
BOTON QUE GENERA EL PDF DE LOS RESULTADOS COVID PERSONAL
=============================================*/

$(document).on("click", ".btnReportePersonalPDF", function() {

	var idCovidResultado = $(this).attr("idCovidResultado");

	var nombre_usuario = $("#nombreUsuarioOculto").val();
	
	var datos = new FormData();

	datos.append("reportePersonalPDF", "reportePersonalPDF");
	datos.append("idCovidResultado", idCovidResultado);
	datos.append("nombre_usuario", nombre_usuario);

	$('.cargando').removeClass('hide');

	$.ajax({

		url: "ajax/reportes_covid.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			$('.cargando').addClass('hide');

			$('#ver-pdf').modal({

				show:true,
				backdrop:'static'

			});	

			PDFObject.embed("temp/reporte-"+idCovidResultado+".pdf", "#view_pdf");

		}

	});

});

/*=============================================================
	BOTON QUE GENERA EL PDF DE LOS RESULTADOS COVID PERSONAL
===============================================================*/

$(document).on("click", ".btnImprimirCovidResultadoLab", function() {
	
	var idFicha = $(this).attr("idFicha");
	var code = $(this).data("code");
	var datos = new FormData();

	datos.append("fichaCovidResultado", "fichaCovidResultado");
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

		url: "ajax/reportes_covid_lab.ajax.php",
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

			PDFObject.embed("temp/"+code+"/resultado-laboratorio-"+idFicha+".pdf", "#view_pdf");

		}

	});

});

var images = {
	logoCNS : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEoAAABuCAYAAACA7YVRAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyppVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iV2luZG93cyBQaG90byBFZGl0b3IgMTAuMC4xMDAxMS4xNjM4NCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGRjFGNjRERUE5ODQxMUVBOTFGMEZBMTlFQzkzRkY2MiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGRjFGNjRERkE5ODQxMUVBOTFGMEZBMTlFQzkzRkY2MiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkZGMUY2NERDQTk4NDExRUE5MUYwRkExOUVDOTNGRjYyIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkZGMUY2NEREQTk4NDExRUE5MUYwRkExOUVDOTNGRjYyIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8++mfZSwAAO1FJREFU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',
}