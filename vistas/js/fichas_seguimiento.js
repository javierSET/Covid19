/*=============================================
	FICHA CONTROL Y SEGUIMIENTO
	=============================================*/	

$("#nuevoNroControl").change(function() {
	item = "nro_control";
	valor = $(this).val();
	tabla = "seguimientos";
});

$('#btnGuardarSeguimiento').click(function(){
	if($('#fichaControlCentro').validate()){

		//1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR

		var nuevoEstablecimiento = $('#nuevoEstablecimientoSeguimiento').val();
		var nuevoConsultorio = $('#nuevoConsultorioSeguimiento').val();
		var nuevoDepartamento = $('#nuevoDepartamentoSeguimiento').val();
		var nuevoLocalidad = $('#nuevoLocalidadSeguimiento').val();
		var nuevoFechaNotificacion = $('#nuevoFechaNotificacionSeguimiento').val();
		var nuevoNroControl = $('#nuevoNroControlSeguimiento').val();
		
		console.log("==|ESTABLECIMIENTO|==");
		console.log(nuevoEstablecimiento+'\n'+nuevoConsultorio+'\n'+nuevoDepartamento+'\n'+nuevoLocalidad+'\n'
		+nuevoFechaNotificacion+'\n'+nuevoNroControl);
		
		//2. IDENTIFICACION DEL CASO/PACIENTE
		var nuevoCodAsegurado = $('#nuevoCodAseguradoSeguimiento').val();
		var nuevoCodAfiliado = $('#nuevoCodAfiliadoSeguimiento').val();
		var nuevoCodEmpleador = $('#nuevoCodEmpleadorSeguimiento').val();
		var nuevoNombreEmpleador = $('#nuevoNombreEmpleadorSeguimiento').val();
		var nuevoPaternoPaciente = $('#nuevoPaternoPacienteSeguimiento').val();
		var nuevoMaternoPaciente = $('#nuevoMaternoPacienteSeguimiento').val();
		var nuevoNombrePaciente = $('#nuevoNombrePacienteSeguimiento').val();
		var nuevoSexoPaciente = $('#nuevoSexoPacienteSeguimiento').val();
		var nuevoNroDocumentoPaciente = $('#nuevoNroDocumentoPacienteSeguimiento').val();
		var nuevoFechaNacPaciente = $('#nuevoFechaNacPacienteSeguimiento').val();
		var nuevoEdadPaciente = $('#nuevoEdadPacienteSeguimiento').val();
		var nuevoTelefonoPaciente = $('#nuevoTelefonoPacienteSeguimiento').val();

		console.log("==| CASO PACIENTE |==");
		console.log(nuevoCodAsegurado+'\n'+nuevoCodAfiliado+'\n'+nuevoCodEmpleador+'\n'+nuevoNombreEmpleador+'\n'
		+nuevoPaternoPaciente+'\n'+nuevoMaternoPaciente);
		console.log(nuevoNombrePaciente+'\n'+nuevoSexoPaciente+'\n'+nuevoNroDocumentoPaciente+'\n'+nuevoFechaNacPaciente+'\n'
		+nuevoEdadPaciente+'\n'+nuevoTelefonoPaciente);

		// 3. SEGUIMIENTO
		var nuevoDiasNotificacion = $('#nuevoDiasNotificacionSeguimiento').val();
		var nuevoDiasSinSintomas = $('#nuevoDiasSinSintomasSeguimiento').val();
		var nuevoFechaAislamiento = $('#nuevoFechaAislamientoSeguimiento').val();
		var nuevoLugarAislamiento = $('#nuevoLugarAislamientoSeguimiento').val();
		var nuevoFechaInternacion = $('#nuevoFechaInternacionSeguimiento').val();
		var nuevoEstablecimientoInternacion = $('#nuevoEstablecimientoInternacionSeguimiento').val();
		var nuevoFechaIngresoUTI = $('#nuevoFechaIngresoUTISeguimiento').val();
		var nuevoLugarIngresoUTI = $('#nuevoLugarIngresoUTISeguimiento').val();
		var nuevoVentilacionMecanica = $('#nuevoVentilacionMecanicaSeguimiento').val();
		var nuevoAntiviral = $('#nuevoAntiviralSeguimiento').prop('checked');
		var nuevoAntibiotico = $('#nuevoAntibioticoSeguimiento').prop('checked');
		var nuevoAntiparasitario = $('#nuevoAntiparasitarioSeguimiento').prop('checked');
		var nuevoAntiflamatorio = $('#nuevoAntiflamatorioSeguimiento').prop('checked');
		var nuevoTratamientoOtros = $('#nuevoTratamientoOtrosSeguimiento').val();
		
		console.log("==| SEGUIMIENTO |==");
		console.log(nuevoDiasNotificacion+'\n'+nuevoDiasSinSintomas+'\n'+nuevoFechaAislamiento+'\n'+nuevoLugarAislamiento+'\n'
		+nuevoFechaInternacion+'\n'+nuevoEstablecimientoInternacion);
		console.log(nuevoFechaIngresoUTI+'\n'+nuevoLugarIngresoUTI+'\n'+nuevoVentilacionMecanica+'\n'+nuevoAntiviral+'\n'
		+nuevoAntibiotico+'\n'+nuevoAntiparasitario+'\n'+nuevoAntiflamatorio+'\n'+nuevoTratamientoOtros);


		// 4. LABORATORIO

		var nuevoTipoMuestra = $('#nuevoTipoMuestraSeguimiento').val();
		var nuevoNombreLaboratorio = $('#nuevoNombreLaboratorioSeguimiento').val();
		var nuevoFechaMuestra = $('#nuevoFechaMuestraSeguimiento').val();
		var nuevoFechaEnvio = $('#nuevoFechaEnvioSeguimiento').val();
		var nuevoCodLaboratorio = $('#nuevoCodLaboratorioSeguimiento').val();
		var nuevoResponsableMuestra = $('#nuevoResponsableMuestraSeguimiento').val();
		var nuevoObsMuestra = $('#nuevoObsMuestraSeguimiento').val();
		var positivo = $('#positivoSeguimiento').prop('checked');
		var negativo = $('#negativoSeguimiento').prop('checked');
		var nuevoFechaResultado = $('#nuevoFechaResultadoSeguimiento').val();		
		
		console.log("==| SEGUIMIENTO |==");
		console.log(nuevoTipoMuestra+'\n'+nuevoNombreLaboratorio+'\n'+nuevoFechaMuestra+'\n'+nuevoFechaEnvio+'\n'
		+nuevoCodLaboratorio+'\n'+nuevoResponsableMuestra);
		console.log(nuevoObsMuestra+'\n'+positivo+'\n'+negativo+'\n'+nuevoFechaResultado+'\n');

		var datos = new FormData();
		

	}
	
});
    
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

	//GUARDANDO DATOS DE FICHA CONTROL Y SEGUIMIENTO