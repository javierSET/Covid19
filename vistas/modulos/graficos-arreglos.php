<?php

/* BUSQUEDA DE PACIENTES POR SEXO MASCULINO Y RANGO DE EDADES*/
$fechaIni="2021-02-16";
$fechaFin=date("Y-m-d");
$sexoEdadM = json_encode([(int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",0,10,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",11,20,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",21,30,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",31,40,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",41,50,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",51,60,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",61,70,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",71,80,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",81,120,$fechaIni,$fechaFin)[0]
            ]);
/* BUSQUEDA DE PACIENTES POR SEXO MASCULINO Y RANGO DE EDADES*/
$sexoEdadF = json_encode([(int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",0,10,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",11,20,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",21,30,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",31,40,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",41,50,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",51,60,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",61,70,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",71,80,$fechaIni,$fechaFin)[0],
                (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",81,120,$fechaIni,$fechaFin)[0]
            ]);

$sexoOcupacionPoliciaM = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","POLICIA","POSITIVO",$fechaIni,$fechaFin)[0];
$sexoOcupacionPoliciaF = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","POLICIA","POSITIVO",$fechaIni,$fechaFin)[0];

$sexoOcupacionPSM = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","PERSONAL DE SALUD","POSITIVO",$fechaIni,$fechaFin)[0];
$sexoOcupacionPSF = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","PERSONAL DE SALUD","POSITIVO",$fechaIni,$fechaFin)[0];

$sexoOcupacionPLM = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","PERSONAL DE LABORATORIO","POSITIVO",$fechaIni,$fechaFin)[0];
$sexoOcupacionPLF = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","PERSONAL DE LABORATORIO","POSITIVO",$fechaIni,$fechaFin)[0];

$sexoOcupacionTPM = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","TRABAJADOR PRENSA","POSITIVO",$fechaIni,$fechaFin)[0];
$sexoOcupacionTPF = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","TRABAJADOR PRENSA","POSITIVO",$fechaIni,$fechaFin)[0];

$sexoOcupacionFAM = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","FF.AA.","POSITIVO",$fechaIni,$fechaFin)[0];
$sexoOcupacionFAF = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","FF.AA.","POSITIVO",$fechaIni,$fechaFin)[0];

$sexoOcupacionOtroM = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","POLICIAs","POSITIVO",$fechaIni,$fechaFin)[0];
$sexoOcupacionOtroF = (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","POLICIAs","POSITIVO",$fechaIni,$fechaFin)[0];

$nuevosPacientesPositivos = (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",0,120,date("Y-m-d"),date("Y-m-d"))[0] + (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",0,120,date("Y-m-d"),date("Y-m-d"))[0];

$todosPacientesPositivos = (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","POSITIVO",0,120,$fechaIni,date("Y-m-d"))[0] + (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","POSITIVO",0,120,$fechaIni,date("Y-m-d"))[0];
$todosPacientesNegativos = (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M","NEGATIVO",0,120,$fechaIni,date("Y-m-d"))[0] + (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F","NEGATIVO",0,120,$fechaIni,date("Y-m-d"))[0];

$pacientesSospechosos = (int)ControladorGrafico::ctrBuscarPacienteNoResultados()[0];

$pacientesFallecidos = (int)ControladorGrafico::ctrBuscarPacienteFallecidos()[0];

?> 