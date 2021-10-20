<?php

require_once "../controladores/grafico.controlador.php";

require_once "../modelos/grafico.modelo.php";

class AjaxGraficoReporte{

    public $fechaIni;
    public $fechaFin;
    public $resultado;
    public function ajaxBusquedaPacientes($resultado,$fechaIni,$fechaFin){

        $respuesta=[(int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,0,1,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,2,4,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,5,9,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,10,19,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,20,29,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,30,39,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,40,49,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,50,59,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,60,69,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,70,79,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("M",$resultado,80,120,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,0,1,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,2,4,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,5,9,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,10,19,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,20,29,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,30,39,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,40,49,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,50,59,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,60,69,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,70,79,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesResultadoPorSexoEdad("F",$resultado,80,120,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","POLICIA",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","PERSONAL DE SALUD",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","PERSONAL DE LABORATORIO",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","TRABAJADOR PRENSA",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","FF.AA.",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("M","ocupacion","POLICIAs",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","POLICIA",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","PERSONAL DE SALUD",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","PERSONAL DE LABORATORIO",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","TRABAJADOR PRENSA",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","FF.AA.",$resultado,$fechaIni,$fechaFin)[0],
                    (int)ControladorGrafico::ctrBuscarPacientesSexoValorResultadoFechas("F","ocupacion","POLICIAs",$resultado,$fechaIni,$fechaFin)[0]
                ];
        echo json_encode($respuesta); 
    }    
}


if(isset($_POST["busquedaPacientes"])){

    $busquedaPacientes = new AjaxGraficoReporte();
    $busquedaPacientes->ajaxBusquedaPacientes($_POST["resultadoRadio"],$_POST["fechaIni"],$_POST["fechaFin"]);

}

?>