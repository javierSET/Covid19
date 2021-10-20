/*=============================================
BOTON QUE GENERA LOS REPORTES DE FICHA EPIDEMIOLÓGICA POR FECHAS DE TOMA DE MUESTRA
=============================================*/

$(document).on("click", ".btnFichaEpidemiologicaReporte", function() {

	$('#tablaFichaEpidemiologicaReporte').remove();
	$('#tablaFichaEpidemiologicaReporte_wrapper').remove();

	var fechaInicio = $("#reporteFechaInicio").val();
	var fechaFin = $("#reporteFechaFin").val();

	var datos = new FormData();
	datos.append("reporte", 'reporte');
	datos.append("fechaInicio", fechaInicio);
	datos.append("fechaFin", fechaFin);
	datos.append("exportar", "false");

	$.ajax({

		url: "ajax/reportes_ficha.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta) {
			console.log("respuesta", respuesta);
			$("#reporteFicha").empty();
			$("#reporteFicha").append(

            '<div class="flex-container">' +
				'<div class="flex-childrem">'+		
					'<table class="table table-bordered">'+					
						'<tr>'+
							'<th colspan="2" class="textReportes">Caso identificado por búsqueda activa</th>'+
						'</tr>'+
						'<tr>'+
							'<th>SI</th>'+
							'<th>NO</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][0]+'</td>'+
							'<td>'+respuesta["data"][1]+'</td>'+
						'</tr>'+                
					'</table>' +  
				'</div>' +

				'<div class="flex-childrem">'+		
					'<table class="table table-bordered">'+					
						'<tr>'+
						'<th colspan="2" class="textReportes">Sexo paciente</th>'+
						'</tr>'+
						'<tr>'+
							'<th>F</th>'+
							'<th>M</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][2]+'</td>'+
							'<td>'+respuesta["data"][3]+'</td>'+
						'</tr>'+              
					'</table>' +  
				'</div>' +


				'<div class="flex-childrem">'+
					'<table class="table table-bordered">'+		
						'<tr>'+
							'<th colspan="6" class="textReportes">Ocupación</th>'+
						'</tr>'+
						'<tr>'+
							'<th>PERSONAL DE SALUD</th>'+
							'<th>PERSONAL DE LABORATORIO</th>'+
							'<th>TRABAJADOR PRENSA</th>'+
							'<th>FF.AA.</th>'+
							'<th>POLICIA</th>'+
							'<th>OTROS</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][4]+'</td>'+
							'<td>'+respuesta["data"][5]+'</td>'+
							'<td>'+respuesta["data"][6]+'</td>'+
							'<td>'+respuesta["data"][7]+'</td>'+
							'<td>'+respuesta["data"][8]+'</td>'+
							'<td>'+respuesta["data"][9]+'</td>'+
						'</tr>'+ 
					'</table>' + 	
				'</div>' +

				'<div class="flex-childrem">'+		
					'<table class="table table-bordered">'+					
						'<tr>'+
							'<th colspan="2" class="textReportes">¿Tuvo contacto con un caso de COVID-19?</th>'+
						'</tr>'+
						'<tr>'+
							'<th>SI</th>'+
							'<th>NO</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][10]+'</td>'+
							'<td>'+respuesta["data"][11]+'</td>'+
						'</tr>'+         
					'</table>' +  
				'</div>' +


				'<div class="flex-childrem">'+
					'<table class="table table-bordered">'+		
						'<tr>'+
							'<th colspan="11" class="textReportes">Sintomas</th>'+
						'</tr>'+
						'<tr>'+
							'<th>TOS SECA</th>'+
							'<th>FIEBRE</th>'+
							'<th>MALESTAR GENERAL</th>'+
							'<th>CEFALEA</th>'+
							'<th>DIFICULTAD RESPIRATORIA</th>'+
							'<th>MIALGIAS</th>'+
							'<th>DOLOR DE GARGANTA</th>'+
							'<th>PÉRDIDA Y/O DISMINUCIÓN DEL SENTIDO DEL OLFATO</th>'+
							'<th>SINTOMÁTICO</th>'+
							'<th>ASINTOMÁTICO</th>'+
							'<th>OTROS</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][12]+'</td>'+
							'<td>'+respuesta["data"][13]+'</td>'+
							'<td>'+respuesta["data"][14]+'</td>'+
							'<td>'+respuesta["data"][15]+'</td>'+
							'<td>'+respuesta["data"][16]+'</td>'+
							'<td>'+respuesta["data"][17]+'</td>'+
							'<td>'+respuesta["data"][18]+'</td>'+
							'<td>'+respuesta["data"][19]+'</td>'+
							'<td>'+respuesta["data"][20]+'</td>'+								
							'<td>'+respuesta["data"][21]+'</td>'+
							'<td>'+respuesta["data"][22]+'</td>'+
						'</tr>'+
					'</table>' + 	
				'</div>' +

				'<div class="flex-childrem">'+		
					'<table class="table table-bordered">'+					
						'<tr>'+
							'<th colspan="3" class="textReportes">Estado actual del paciente (al momento de la notificación)</th>'+
						'</tr>'+
						'<tr>'+
							'<th>LEVE</th>'+
							'<th>GRAVE</th>'+
							'<th>FALLECIDO</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][23]+'</td>'+
							'<td>'+respuesta["data"][24]+'</td>'+
							'<td>'+respuesta["data"][25]+'</td>'+
						'</tr>'+         
					'</table>' +  
				'</div>' +

				'<div class="flex-childrem">'+		
					'<table class="table table-bordered">'+					
						'<tr>'+
							'<th colspan="4" class="textReportes">Diagnostico clínico</th>'+
						'</tr>'+
						'<tr>'+
							'<th>IRA</th>'+
							'<th>IRAG</th>'+
							'<th>NEUMONIA</th>'+
							'<th>OTROS</th>'+
						'</tr>'+
						'<tr>'+
							'<td>'+respuesta["data"][26]+'</td>'+
							'<td>'+respuesta["data"][27]+'</td>'+
							'<td>'+respuesta["data"][28]+'</td>'+
							'<td>'+respuesta["data"][29]+'</td>'+
						'</tr>'+               
					'</table>' +  
				'</div>' +

			'</div>'			
            );

		},
	    error: function(error){

	      console.log("No funciona");
	        
	    }

	});

});


$(document).on("click", "#btnFichaEpidemiologicaPDF", function(){
	console.log("exportando a pdf");

	var fechaInicio = $("#reporteFechaInicio").val();
	var fechaFin = $("#reporteFechaFin").val();

	//ReporteFEpimpresionPDF

	var datos = new FormData();

	datos.append("ReporteFEpimpresionPDF", "ReporteFEpimpresionPDF");
	datos.append("fechaInicio", fechaInicio);
	datos.append("fechaFin", fechaFin);

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

		url: "ajax/reportes_covid.ajax.php",
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		//dataType: "string",
		success: function(respuesta) {

			swal.close();

			$('#ver-pdf').modal({
				show:true,
				backdrop:'static'

			});
			console.log(respuesta);
		
			//PDFObject.embed("temp/"+code+"/ficha-epidemiologica-"+idFicha+".pdf", "#view_pdf");
			PDFObject.embed("temp/reporte-FE.pdf", "#view_pdf");

		}
    });
});
