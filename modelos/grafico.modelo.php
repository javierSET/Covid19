<?php

require_once "conexion.db.php";

class ModeloGrafico{

    /**
     * @method mdlBuscarGraficosPorSexo
     * @param string $sexo
     * @param string $resultado
     * @param int $edadIni
     * @param int $edadFin
     * @param date $fechaIni
     * @param date $fechaFin
     * @return array $respuesta
     */
    static public function mdlBuscarPacientesResultadoPorSexoEdad($sexo, $resultado, $edadIni, $edadFin, $fechaIni, $fechaFin){
        if($resultado!="TODO"){
            $stmt = Conexion::conectarBDFicha()->prepare("SELECT COUNT(cr.id_ficha)
                                                            FROM 	bdfichaepidemiologicacnscb.pacientes_asegurados pa,
                                                                    bdcovid19cnscb.covid_resultados cr        
                                                            WHERE 	pa.id_ficha=cr.id_ficha AND
                                                                    cr.sexo=:sexo AND
                                                                    cr.resultado =:resultado AND 
                                                                    pa.edad BETWEEN :edadIni AND :edadFin
                                                                    AND cr.fecha_resultado BETWEEN :fechaIni AND :fechaFin;
                                                        ");
            $stmt->bindParam(":sexo",$sexo,PDO::PARAM_STR);
            $stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
            $stmt->bindParam(":edadIni",$edadIni,PDO::PARAM_INT);
            $stmt->bindParam(":edadFin",$edadFin,PDO::PARAM_INT);
            $stmt->bindParam(":fechaIni",$fechaIni,PDO::PARAM_STR);
            $stmt->bindParam(":fechaFin",$fechaFin,PDO::PARAM_STR);
            if($stmt->execute()){
                $respuesta = $stmt->fetch();
            }else{
                $respuesta = $stmt->errorInfo();
            }
        }
        else{
            $stmt = Conexion::conectarBDFicha()->prepare("SELECT COUNT(cr.id_ficha)
                                                            FROM 	bdfichaepidemiologicacnscb.pacientes_asegurados pa,
                                                                    bdcovid19cnscb.covid_resultados cr        
                                                            WHERE 	pa.id_ficha=cr.id_ficha AND
                                                                    cr.sexo=:sexo AND
                                                                    (cr.resultado ='POSITIVO' OR cr.resultado ='NEGATIVO') AND
                                                                    pa.edad BETWEEN :edadIni AND :edadFin
                                                                    AND cr.fecha_resultado BETWEEN :fechaIni AND :fechaFin;
                                                        ");
            $stmt->bindParam(":sexo",$sexo,PDO::PARAM_STR);
            // $stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
            $stmt->bindParam(":edadIni",$edadIni,PDO::PARAM_INT);
            $stmt->bindParam(":edadFin",$edadFin,PDO::PARAM_INT);
            $stmt->bindParam(":fechaIni",$fechaIni,PDO::PARAM_STR);
            $stmt->bindParam(":fechaFin",$fechaFin,PDO::PARAM_STR);
            if($stmt->execute()){
                $respuesta = $stmt->fetch();
            }else{
                $respuesta = $stmt->errorInfo();
            }
        }
        return $respuesta;
    }   
    
    /**
     * @method mdlBuscarPacientesSexoValorResultadoFechas
     * @param string $sexo
     * @param string $item
     * @param string $valor
     * @param string $resultado
     * @param date $fechaIni
     * @param date $fechaFin
     * @return array $respuesta
     */
    static public function mdlBuscarPacientesSexoValorResultadoFechas($sexo,$item,$valor,$resultado,$fechaIni,$fechaFin){
        if($resultado!="TODO"){
            if($valor=="POLICIA" || $valor=="PERSONAL DE SALUD" || $valor=="PERSONAL DE LABORATORIO" || $valor=="TRABAJADOR PRENSA" || $valor=="FF.AA."){
                $stmt = Conexion::conectarBDFicha()->prepare("SELECT  COUNT(cr.id_ficha)
                                                                FROM 	bdcovid19cnscb.covid_resultados cr,
                                                                        bdfichaepidemiologicacnscb.ant_epidemiologicos ae
                                                                WHERE	cr.id_ficha=ae.id_ficha AND
                                                                        cr.sexo=:sexo AND 
                                                                        cr.resultado=:resultado AND
                                                                        ae.$item=:$item AND
                                                                        cr.fecha_resultado BETWEEN :fechaIni AND :fechaFin;
                                                            ");
                $stmt->bindParam(":sexo",$sexo,PDO::PARAM_STR);
                $stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
                $stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
                $stmt->bindParam(":fechaIni",$fechaIni,PDO::PARAM_STR);
                $stmt->bindParam(":fechaFin",$fechaFin,PDO::PARAM_STR);        
                if($stmt->execute()){
                    $respuesta = $stmt->fetch();
                }else{
                    $respuesta = $stmt->errorInfo();
                }
            }
            else{
                $stmt = Conexion::conectarBDFicha()->prepare("SELECT  COUNT(cr.id_ficha)
                                                                FROM 	bdcovid19cnscb.covid_resultados cr,
                                                                        bdfichaepidemiologicacnscb.ant_epidemiologicos ae
                                                                WHERE	cr.id_ficha=ae.id_ficha AND
                                                                        cr.sexo=:sexo AND 
                                                                        cr.resultado=:resultado AND
                                                                        (ae.$item<>'POLICIA' AND ae.$item<>'PERSONAL DE SALUD' AND ae.$item<>'PERSONAL DE LABORATORIO'
                                                                            AND ae.$item<>'TRABAJADOR PRENSA' AND ae.$item<>'FF.AA.' ) AND
                                                                            cr.fecha_resultado BETWEEN :fechaIni AND :fechaFin;
                                                            ");
                $stmt->bindParam(":sexo",$sexo,PDO::PARAM_STR);
                //$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
                $stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
                $stmt->bindParam(":fechaIni",$fechaIni,PDO::PARAM_STR);
                $stmt->bindParam(":fechaFin",$fechaFin,PDO::PARAM_STR);        
                if($stmt->execute()){
                    $respuesta = $stmt->fetch();
                }else{
                    $respuesta = $stmt->errorInfo();
                }
            }
        }
        else{
            if($valor=="POLICIA" || $valor=="PERSONAL DE SALUD" || $valor=="PERSONAL DE LABORATORIO" || $valor=="TRABAJADOR PRENSA" || $valor=="FF.AA."){
                $stmt = Conexion::conectarBDFicha()->prepare("SELECT  COUNT(cr.id_ficha)
                                                                FROM 	bdcovid19cnscb.covid_resultados cr,
                                                                        bdfichaepidemiologicacnscb.ant_epidemiologicos ae
                                                                WHERE	cr.id_ficha=ae.id_ficha AND
                                                                        cr.sexo=:sexo AND 
                                                                        (cr.resultado='POSITIVO' OR cr.resultado='NEGATIVO' ) AND
                                                                        ae.$item=:$item AND
                                                                        cr.fecha_resultado BETWEEN :fechaIni AND :fechaFin;
                                                            ");
                $stmt->bindParam(":sexo",$sexo,PDO::PARAM_STR);
                $stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
                //$stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
                $stmt->bindParam(":fechaIni",$fechaIni,PDO::PARAM_STR);
                $stmt->bindParam(":fechaFin",$fechaFin,PDO::PARAM_STR);        
                if($stmt->execute()){
                    $respuesta = $stmt->fetch();
                }else{
                    $respuesta = $stmt->errorInfo();
                }
            }
            else{
                $stmt = Conexion::conectarBDFicha()->prepare("SELECT  COUNT(cr.id_ficha)
                                                                FROM 	bdcovid19cnscb.covid_resultados cr,
                                                                        bdfichaepidemiologicacnscb.ant_epidemiologicos ae
                                                                WHERE	cr.id_ficha=ae.id_ficha AND
                                                                        cr.sexo=:sexo AND 
                                                                        (cr.resultado='POSITIVO' OR cr.resultado='NEGATIVO' ) AND
                                                                        (ae.$item<>'POLICIA' AND ae.$item<>'PERSONAL DE SALUD' AND ae.$item<>'PERSONAL DE LABORATORIO' AND
                                                                        ae.$item<>'TRABAJADOR PRENSA' AND ae.$item<>'FF.AA.' ) AND
                                                                        cr.fecha_resultado BETWEEN :fechaIni AND :fechaFin;
                                                            ");
                $stmt->bindParam(":sexo",$sexo,PDO::PARAM_STR);
                //$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
                //$stmt->bindParam(":resultado",$resultado,PDO::PARAM_STR);
                $stmt->bindParam(":fechaIni",$fechaIni,PDO::PARAM_STR);
                $stmt->bindParam(":fechaFin",$fechaFin,PDO::PARAM_STR);        
                if($stmt->execute()){
                    $respuesta = $stmt->fetch();
                }else{
                    $respuesta = $stmt->errorInfo();
                }
            }            
        }        
        
        return $respuesta;
    }

    static public function mdlBuscarPacienteNoResultados(){
        $stmt = Conexion::conectarBDFicha()->prepare("SELECT  COUNT(cr.id_ficha)
                                                        FROM 	bdcovid19cnscb.covid_resultados cr,
                                                                bdfichaepidemiologicacnscb.laboratorios l
                                                        WHERE	cr.id_ficha = l.id_ficha AND
                                                                cr.resultado <> 'POSITIVO' AND cr.resultado <> 'NEGATIVO' AND
                                                                l.resultado_laboratorio <> 'POSITIVO' AND l.resultado_laboratorio <> 'NEGATIVO';
                                                            ");
        if($stmt->execute()){
            $respuesta = $stmt->fetch();
        }else{
            $respuesta = $stmt->errorInfo();
        }
        return $respuesta;
    }


    static public function mdlBuscarPacienteFallecidos(){
        $stmt = Conexion::conectarBDFicha()->prepare("SELECT COUNT(*)
                                                        FROM 	datos_clinicos dc, pacientes_asegurados pa
                                                        WHERE 	dc.id_ficha=pa.id_ficha AND
                                                                pa.cod_asegurado<>'' AND
                                                                dc.estado_paciente = 'FALLECIDO';
                                                            ");
        if($stmt->execute()){
            $respuesta = $stmt->fetch();
        }else{
            $respuesta = $stmt->errorInfo();
        }
        return $respuesta;
    }
}


?>