<?php

class ControladorGrafico{

    /**
     * @author dan
     * @version 1.0
     * @param string $sexo
     * @param string $resultado
     * @param int $edadIni
     * @param int $edadFin
     * @param date $fechaIni
     * @param date $fechaFin
     * @method Busqueda de pacientes positivos por sexo y un rango de edad
     * @return array respuesta
    */
    static public function ctrBuscarPacientesResultadoPorSexoEdad($sexo, $resultado, $edadIni, $edadFin, $fechaIni, $fechaFin){        
        $repuesta = ModeloGrafico::mdlBuscarPacientesResultadoPorSexoEdad($sexo,$resultado,$edadIni,$edadFin,$fechaIni,$fechaFin);
        return $repuesta;        
    }

    /**
     * @author dan
     * @version 1.0
     * @param string $sexo
     * @param string $item
     * @param string $valor
     * @param date $fechaIni
     * @param date $fechaFin
     * @method Busqueda de todos los pacientes con resultados (positivo/negativo) por un item y valor en un rango de fechas
     * @return array respuesta
    */

    static public function ctrBuscarPacientesSexoValorResultadoFechas($sexo, $item, $valor, $ocupacion, $fechaIni, $fechaFin){        
        $repuesta = ModeloGrafico::mdlBuscarPacientesSexoValorResultadoFechas($sexo, $item, $valor, $ocupacion, $fechaIni, $fechaFin);
        return $repuesta;        
    }
    //PERSONAL DE SALUD, PERSONAL DE LABORATORIO, TRABAJADOR PRENSA, FF.AA., POLICIA, OTRO

    /**
     * @author dan
     * 
     */

    static public function ctrBuscarPacienteNoResultados(){
        $repuesta = ModeloGrafico::mdlBuscarPacienteNoResultados();
        return $repuesta;
    }

    static public function ctrBuscarPacienteFallecidos(){
        $repuesta = ModeloGrafico::mdlBuscarPacienteFallecidos();
        return $repuesta;
    }
}

?>