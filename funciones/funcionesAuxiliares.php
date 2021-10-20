<?php
    /*===============================================================
        funcion para convertir una fecha dd-mm-yyy a su literal 
        ejemplo 18-02-2021 ->  Jueves, 18 de febrero del 2021
        $hoy =  obtenerFechaEnLetra(date('d-m-Y'));
    =================================================================*/
    function obtenerFechaEnLetra($fecha){
        
        $dia=conocerDiaSemanaFecha($fecha);
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha))*1)-1];
        return $dia.', '.$num.' de '.$mes.' del '.$anno;
    }
    function conocerDiaSemanaFecha($fecha) {
        $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $dia = $dias[date('w', strtotime($fecha))];
        return $dia;
    }

    	/*=============================================
	    	FUNCION PARA CALCULAR LA EDAD
		=============================================*/

	function calculaedad($fechanacimiento){
		list($ano,$mes,$dia) = explode("-",$fechanacimiento);
		$ano_diferencia  = date("Y") - $ano;
		$mes_diferencia = date("m") - $mes;
		$dia_diferencia   = date("d") - $dia;
		if ($dia_diferencia < 0 || $mes_diferencia < 0)
		  $ano_diferencia--;
		return $ano_diferencia;
	  }
?>