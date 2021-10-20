<?php

require_once "conexion.db.php";

class ModeloReportesFicha {

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA BUSQUEDA ACTIVA SI
	=============================================*/
	
	static public function mdlContarBusquedaActiva($valor1, $valor2, $valor3) {

		// devuelve los campos que coincidan con el rango de fechas

/* 		$sql = "SELECT COUNT(f.busqueda_activa) AS busqueda_activa 
			    FROM fichas f, laboratorios l 
			    WHERE f.id_ficha = l.id_ficha 
				AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND f.busqueda_activa = :busqueda_activa 
				AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin"; */

        $sql = "SELECT COUNT(busqueda_activa) AS busqueda_activa 
			    FROM fichas 
			    WHERE tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND busqueda_activa = :busqueda_activa 
				AND fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":busqueda_activa", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA SEXO PACIENTE
	=============================================*/
	
	static public function mdlContarSexoPaciente($valor1, $valor2, $valor3) {
		$sql = "SELECT COUNT(pa.sexo) AS sexo 
		        FROM fichas f, pacientes_asegurados pa, laboratorios l 
				WHERE f.id_ficha = l.id_ficha 
				AND f.id_ficha = pa.id_ficha 
				AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND pa.sexo = :sexo
				AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin
				/* AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin */";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OCUPACION
	=============================================*/
	
	static public function mdlContarOcupacion($valor1, $valor2, $valor3) {
		$sql = "SELECT COUNT(ae.ocupacion) AS ocupacion 
		        FROM fichas f, ant_epidemiologicos ae, laboratorios l 
				WHERE f.id_ficha = l.id_ficha 
				AND f.id_ficha = ae.id_ficha 
				AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND ae.ocupacion = :ocupacion 
				AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":ocupacion", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OTRA OCUPACIÓN
	=============================================*/
	
	static public function mdlContarOtraOcupacion($valor1, $valor2) {
		$sql = "SELECT COUNT(ae.ocupacion) AS ocupacion 
		FROM fichas f, ant_epidemiologicos ae, laboratorios l 
		WHERE f.id_ficha = l.id_ficha 
		AND f.id_ficha = ae.id_ficha 
		AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
		AND ae.ocupacion <> 'PERSONAL DE SALUD' 
		AND ae.ocupacion <> 'PERSONAL DE LABORATORIO' 
		AND ae.ocupacion <> 'TRABAJADOR PRENSA' 
		AND ae.ocupacion <> 'FF.AA.' 
		AND ae.ocupacion <> 'POLICIA' 
		AND ae.ocupacion <> '' 
		AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA ANTECEDENTES DE VACUNACIÓN INFLUENZA
	=============================================*/
	
	static public function mdlContarVacunaInfluenza($valor1, $valor2, $valor3) {
		$sql = "SELECT COUNT(ae.ant_vacuna_influenza) AS ant_vacuna_influenza FROM fichas f, ant_epidemiologicos ae, laboratorios l WHERE f.id_ficha = l.id_ficha AND f.id_ficha = ae.id_ficha AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' AND ae.ant_vacuna_influenza = :ant_vacuna_influenza AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":ant_vacuna_influenza", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA VIAJE DE RIESGO
	=============================================*/
	
	static public function mdlContarViajeRiesgo($valor1, $valor2, $valor3) {
		$sql = "SELECT COUNT(ae.viaje_riesgo) AS viaje_riesgo FROM fichas f, ant_epidemiologicos ae, laboratorios l WHERE f.id_ficha = l.id_ficha AND f.id_ficha = ae.id_ficha AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' AND ae.viaje_riesgo = :viaje_riesgo AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":viaje_riesgo", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA CONTACTO COVID
	=============================================*/
	
	static public function mdlContarContactoCovid($valor1, $valor2, $valor3) {
		$sql = "SELECT COUNT(ae.contacto_covid) AS contacto_covid 
		        FROM fichas f, ant_epidemiologicos ae, laboratorios l 
				WHERE f.id_ficha = l.id_ficha 
				AND f.id_ficha = ae.id_ficha 
				AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND ae.contacto_covid = :contacto_covid 
				AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":contacto_covid", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA MALESTARES
	=============================================*/
	
	static public function mdlContarMalestar($valor1, $valor2, $valor3) {
			$filtro = "otros";	
			switch($valor3){
				case "TOS SECA": $filtro = 'tos_seca'; break;
				case "FIEBRE": $filtro = 'fiebre'; break;
				case "MALESTAR GENERAL": $filtro = 'malestar_general'; break;
				case "CEFALEA": $filtro = 'cefalea'; break;
				case "DIFICULTAD RESPIRATORIA": $filtro = 'dificultad_respiratoria'; break;
				case "MIALGIAS": $filtro = 'mialgias'; break;
				case "DOLOR DE GARGANTA": $filtro = 'dolor_garganta'; break;
				case "PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO": $filtro = 'perdida_olfato'; break;
				default: $filtro = 'otros'; break;
			}

		if($filtro != "otros")
		{
			$sql = "SELECT count(m.$filtro) AS $filtro
					FROM fichas f, datos_clinicos dc, malestar m 
					WHERE f.id_ficha = dc.id_ficha 
					AND dc.id = m.id_datos_clinicos
					AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA'
					AND m.$filtro = :malestar 
					AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";	
					
			$stmt = Conexion::conectarBDFicha()->prepare($sql);

			$stmt->bindParam(":malestar", $valor3, PDO::PARAM_STR);
			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();		
		}
		else{
			$sql = "SELECT count(m.otros) AS otros
			FROM fichas f, datos_clinicos dc, malestar m 
			WHERE f.id_ficha = dc.id_ficha 
			AND dc.id = m.id_datos_clinicos
			AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA'
			AND (m.otros <> '' OR m.otros <> null)
			AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

			$stmt = Conexion::conectarBDFicha()->prepare($sql);

			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();
		}	


		/* $sql = "SELECT dc.malestares 
		FROM fichas f, datos_clinicos dc, laboratorios l 
		WHERE f.id_ficha = l.id_ficha 
		AND f.id_ficha = dc.id_ficha 
		AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
		AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin"; */

	}

	/*=============================================
	TABULANDO LOS DATOS DE DATOS CLINICOS ASINTOMATICO SINTOMATICO
	=============================================*/

	static public function mdlContarSintomaticoAsintomatico($valor1, $valor2, $valor3){

		$sql = "SELECT COUNT(dc.sintoma) AS sintoAsinto
		FROM fichas f, datos_clinicos dc
		WHERE f.id_ficha = dc.id_ficha 
		AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
		AND dc.sintoma = :sintoma 
		AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);
	
		$stmt->bindParam(":sintoma", $valor3, PDO::PARAM_STR);
		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}
	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OTRO MALESTAR
	=============================================*/
	
	static public function mdlContarOtroMalestar($valor1, $valor2) {
		$sql = "SELECT COUNT(dc.malestares_otros) AS malestares_otros 
		        FROM fichas f, datos_clinicos dc, laboratorios l 
				WHERE f.id_ficha = l.id_ficha 
				AND f.id_ficha = dc.id_ficha 
				AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND dc.malestares_otros <> '' 
				AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA CONTACTO COVID
	=============================================*/
	
	static public function mdlContarEstadoPaciente($valor1, $valor2, $valor3) {
		$sql = "SELECT COUNT(dc.estado_paciente) AS estado_paciente 
		        FROM fichas f, datos_clinicos dc
				WHERE f.id_ficha = dc.id_ficha
				AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' 
				AND dc.estado_paciente = :estado_paciente
				AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
		$stmt->bindParam(":estado_paciente", $valor3, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();
	}


	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA DIAGNOSTICO CLINICO
	=============================================*/
	
	static public function mdlContarDiagnostico($valor1, $valor2, $valor3) {

        if($valor3 == "GRIPAL/IRA/BRONQUITIS"){

			$sql = "SELECT COUNT(dc.diagnostico_clinico) AS diagnostico_clinico 
					FROM fichas f, datos_clinicos dc
					WHERE f.id_ficha = dc.id_ficha 
					AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA'
					AND (dc.diagnostico_clinico like :diagnostico_clinico OR dc.diagnostico_clinico = 'IRA' )
					AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";
	
			$stmt = Conexion::conectarBDFicha()->prepare($sql);
	
			$valorMod = "%".$valor3."%";
			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
			$stmt->bindParam(":diagnostico_clinico", $valorMod, PDO::PARAM_STR);
	
			$stmt->execute(); 
	
			return $stmt->fetch();
		}
		else{

			$sql = "SELECT COUNT(dc.diagnostico_clinico) AS diagnostico_clinico 
			FROM fichas f, datos_clinicos dc
			WHERE f.id_ficha = dc.id_ficha 
			AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA'
			AND dc.diagnostico_clinico like :diagnostico_clinico
			AND f.fecha_notificacion BETWEEN :fechaInicio AND :fechaFin";

			$stmt = Conexion::conectarBDFicha()->prepare($sql);

			$valorMod = "%".$valor3."%";
			$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);
			$stmt->bindParam(":diagnostico_clinico", $valorMod, PDO::PARAM_STR);

			$stmt->execute(); 

			return $stmt->fetch();
		}
	}

	/*=============================================
	TABULANDO LOS DATOS DE FICHA EPIDEMIOLÓGICA OTRO DIAGNOSTICO CLINICO
	=============================================*/
	
	static public function mdlContarOtroDiagnostico($valor1, $valor2) {
		$sql = "SELECT COUNT(dc.diagnostico_clinico) AS diagnostico_clinico FROM fichas f, datos_clinicos dc, laboratorios l WHERE f.id_ficha = l.id_ficha AND f.id_ficha = dc.id_ficha AND f.tipo_ficha = 'FICHA EPIDEMIOLOGICA' AND dc.diagnostico_clinico <> 'IRA' AND dc.diagnostico_clinico <> 'IRAG' AND dc.diagnostico_clinico <> 'NEUMONIA' AND dc.diagnostico_clinico <> '' AND l.fecha_muestra BETWEEN :fechaInicio AND :fechaFin";

		$stmt = Conexion::conectarBDFicha()->prepare($sql);

		$stmt->bindParam(":fechaInicio", $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $valor2, PDO::PARAM_STR);

		$stmt->execute(); 

		return $stmt->fetch();

	}

}