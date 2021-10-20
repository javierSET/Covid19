<?php
// namespace Dompdf;
require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";

require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/pacientes_asegurados.modelo.php";

require_once "../controladores/ant_epidemiologicos.controlador.php";
require_once "../modelos/ant_epidemiologicos.modelo.php";

require_once "../controladores/datos_clinicos.controlador.php";
require_once "../modelos/datos_clinicos.modelo.php";

require_once "../controladores/hospitalizaciones_aislamientos.controlador.php";
require_once "../modelos/hospitalizaciones_aislamientos.modelo.php";

require_once "../controladores/enfermedades_bases.controlador.php";
require_once "../modelos/enfermedades_bases.modelo.php";

require_once "../controladores/personas_contactos.controlador.php";
require_once "../modelos/personas_contactos.modelo.php";

require_once "../controladores/laboratorios.controlador.php";
require_once "../modelos/laboratorios.modelo.php";

require_once "../controladores/personas_notificadores.controlador.php";
require_once "../modelos/personas_notificadores.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/departamentos.controlador.php";
require_once "../modelos/departamentos.modelo.php";

require_once "../controladores/establecimientos.controlador.php";
require_once "../modelos/establecimientos.modelo.php";

require_once "../controladores/consultorios.controlador.php";
require_once "../modelos/consultorios.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";

require_once "../controladores/paises.controlador.php";
require_once "../modelos/paises.modelo.php";


require_once "../controladores/covid_resultados.controlador.php";
require_once "../modelos/covid_resultados.modelo.php";
require_once "../modelos/conexion.db.php";

require_once "../controladores/provincia.controlador.php";
require_once "../modelos/municipio.modelo.php";

require_once "../controladores/municipio.controlador.php";
require_once "../modelos/municipio.modelo.php";

require_once "../controladores/malestar.controlador.php";
require_once "../modelos/malestar.modelo.php";

require_once "../ajax/informacion_paciente.ajax.php";

require_once "../extensiones/tcpdf/tcpdf.php";
require_once "../extensiones/phpqrcode/qrlib.php";


class AjaxFichas {

	public $paterno_notificador; 
	public $materno_notificador;
	public $nombre_notificador; 
	public $telefono_notificador; 
	public $cargo_notificador;

	public $eliminarFicha;
	
	/*=============================================
	CREAR UNA NUEVA FICHA EPIDEMIOLÓGICA
	=============================================*/

	public function ajaxCrearFichaEpidemiologica($request)	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$datos = array( "id_establecimiento"	=> "", 
						"cod_establecimiento"	=> "", 
						"red_salud"     	    => "",
						"id_departamento"     	=> "",						
						"fecha_notificacion"    => "",
						"semana_epidemiologica" => "",
						"busqueda_activa"   	=> "",
						"paterno_notificador"   => $this->paterno_notificador,
						"materno_notificador"   => $this->materno_notificador,
						"nombre_notificador"   	=> $this->nombre_notificador,
						"cargo_notificador"   	=> $this->cargo_notificador,
						"tipo_ficha"   	     	=> "FICHA EPIDEMIOLOGICA"
						);	

		$respuesta = ControladorFichas::ctrCrearFicha($datos, $request);

		echo $respuesta;

	}

	/**==========================================
	 * Elimina un ficha X dato el id de la ficha
	 ==========================================*/
	public function ajaxEliminarFichaX($request){
		
		$pdo = Conexion::conectar();
		$idficha =  $request["idFicha"];
		
		$sql = "DELETE fb
		FROM formulario_bajas fb
		WHERE fb.id_covid_resultado = $idficha;
		DELETE cr
		FROM covid_resultados cr 
		WHERE cr.id_ficha = $idficha;";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute()) {

			$pdo = Conexion::conectarBDFicha();
			
			$sql = "DELETE aep
			FROM ant_epidemiologicos aep 
			WHERE aep.id_ficha = $idficha;
		
			DELETE eb
				FROM enfermedades_bases eb 
				WHERE eb.id_ficha = $idficha;
			
			DELETE ha
				FROM hospitalizaciones_aislamientos ha 
				WHERE ha.id_ficha = $idficha;
			
			DELETE l
				FROM laboratorios l 
				WHERE l.id_ficha = $idficha; 
			
			DELETE pa
				FROM pacientes_asegurados pa
				WHERE pa.id_ficha = $idficha;
			
			DELETE pc
				FROM personas_contactos pc
				WHERE pc.id_ficha = $idficha;
			
			DELETE pn
				FROM personas_notificadores pn
				WHERE pn.id_ficha = $idficha;

			SET FOREIGN_KEY_CHECKS = 0;

			DELETE dc, m
			FROM datos_clinicos dc
			LEFT JOIN malestar m
				ON m.id_datos_clinicos = dc.id
			WHERE dc.id_ficha = $idficha;

			SET FOREIGN_KEY_CHECKS = 1;

			DELETE f
			FROM fichas f
			WHERE f.id_ficha = $idficha;
			";
		
			$stmt = $pdo->prepare($sql);

			if ($stmt->execute()) {
				//para reutilizar este metodo se hace la verificacion
				if($this->eliminarFicha == "eliminarFichaAll")
					return "ok";
				else echo "ok";	
			}
			else{
				print_r($stmt->errorInfo());
				echo "error";
			}
					
		} else {
				print_r($stmt->errorInfo());
				echo "error";
		}
	}

	/**==========================================
	 * Eliminar todas las fichas incompletas
	 ==========================================*/
	public function ajaxEliminarfichasAll(){

		$pdo = Conexion::conectarBDFicha();
		
		$sql = "SELECT id_ficha FROM fichas WHERE estado_ficha = 0";

		$stmt = $pdo->prepare($sql);

		$success = false;
		if ($stmt->execute()) {
			$fichasIncompletas =  $stmt->fetchAll();
			foreach($fichasIncompletas as $key => $value ){
				$fichas = array();
				$fichas['idFicha'] = $value['id_ficha'];
				if($this->ajaxEliminarFichaX($fichas) == 'ok')
					$success = true;
				else $success = false;
			}

			if($success)
				echo "ok";
			else echo "error";
		}
		else{
			print_r($stmt->errorInfo());
			echo "error";
		}
	}

	/*=============================================
	CREAR UNA NUEVA FICHA DE CONTROL Y SEGUIMIENTO
	=============================================*/

	public function ajaxCrearFichaControl()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$datos = array( "id_establecimiento"	=> "", 
						"cod_establecimiento"	=> "", 
						"red_salud"     	    => "",
						"id_departamento"     	=> "",
						"id_localidad"  		=> "",
						"fecha_notificacion"    => "",
						"semana_epidemiologica" => "",
						"busqueda_activa"   	=> "",
						"nro_control" 		  	=> "",
						"paterno_notificador"   => $this->paterno_notificador,
						"materno_notificador"   => $this->materno_notificador,
						"nombre_notificador"   	=> $this->nombre_notificador,
						"cargo_notificador"   	=> $this->cargo_notificador,
						"tipo_ficha"   	     	=> "FICHA CONTROL Y SEGUIMIENTO",
						);	

		$respuesta = ControladorFichas::ctrCrearFicha($datos);

		echo $respuesta;

	}

	// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
	
	public $id_ficha;
	public $tipo_ficha;
	public $fecha_creacion;
	public $cod_ficha;
	public $fecha_notificacion;
	public $semana_epidemiologica;
	public $busqueda_activa;
	public $nro_control;
	public $id_establecimiento;
	public $cod_establecimiento;
	public $id_consultorio;
	public $red_salud;
	public $id_departamento;
	public $id_localidad;
	public $estado_ficha;
	public $sub_sector;
	public $id_municipio;


	// 2. IDENTIFICACIÓN DEL CASO PACIENTE

	public $paterno;
	public $materno;
	public $nombre;
	public $cod_asegurado;
	public $cod_afiliado;
	public $cod_empleador;
	public $nombre_empleador;
	public $nro_documento;
	public $sexo;
	public $fecha_nacimiento;
	public $edad;
	public $id_departamento_paciente;
	public $id_provincia_paciente;
	public $id_municipio_paciente;
	public $id_pais_paciente;
	public $zona;
	public $calle;
	public $nro_calle;
	public $telefono;
	public $email;
	public $nombre_apoderado;
	public $telefono_apoderado;
	public $identificacion_etnica;
	public $discapacidad;

	// 3. ANTECEDENTES EPIDEMIOLOGICOS


	public $ocupacion;
	public $ant_vacuna_influenza;
	public $fecha_vacuna_influenza;
	public $viaje_riesgo;
	public $pais_ciudad_riesgo;
	public $fecha_retorno;
	public $empresa_vuelo;
	public $nro_vuelo;
	public $nro_asiento;
	public $contacto_covid;
	public $fecha_contacto_covid;
	public $nombre_contacto_covid;
	public $telefono_contacto_covid;
	public $pais_contacto_covid;
	public $lugar_aproximado_infeccion;
	public $departamento_contacto_covid;
	public $provincia_contacto_covid;
	public $localidad_contacto_covid;
	public $diagnosticado_covid_anteriormente;
	public $fecha_covid_anteriormente;

	

	// 4. DATOS CLÍNICOS


	public $fecha_inicio_sintomas;
	public $malestares;
	public $malestares_otros;
	public $estado_paciente;
	public $fecha_defuncion;
	public $diagnostico_clinico;
	
	public $sintoma;
	

	// 5. DATOS HOSPITALIZACIÓN AISLAMIENTO


	public $dias_notificacion;
	public $dias_sin_sintomas;
	public $fecha_aislamiento;
	public $lugar_aislamiento;
	public $fecha_internacion;
	public $establecimiento_internacion;
	public $ventilacion_mecanica;
	public $terapia_intensiva;
	public $fecha_ingreso_UTI;
	public $lugar_ingreso_UTI;
	public $tratamiento;
	public $tratamiento_otros;
	public $metodo_hospitalizacion;

	

	// 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO


	public $enf_estado;
	public $enf_riesgo;

	public $hipertension_arterial;
	public $obesidad;
	public $diabetes_general;
	public $embarazo;
	public $enfermedades_oncologica;
	public $enfermedades_cardiaca;
	public $enfermedad_respiratoria;
	public $enfermedades_renal_cronica;
	public $otros;

	// 8. LABORATORIOS


	public $estado_muestra;

	public $tipo_muestra;
	public $nombre_laboratorio;
	public $cod_laboratorio;
	public $fecha_muestra;
	public $fecha_envio;
	public $responsable_muestra;
	public $observaciones_muestra;
	public $resultado_laboratorio;
	public $fecha_resultado;

	public $des_no_muestra;
	public $cod_laboratorio_muestra;
	public $cod_laboratorio_muestra2;
	

	/*=============================================
	GUARDANDO DATOS EN LA FICHA EPIDEMIOLÓGICA
	=============================================*/

	public function ajaxGuardarFichaEpidemiologica()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$datos = array( "id_ficha"              =>     $this-> id_ficha,
						"tipo_ficha"            =>     "FICHA EPIDEMIOLOGICA",
						"fecha_creacion"        =>     $this-> fecha_creacion,
						"cod_ficha"             =>     $this-> cod_ficha,
						"fecha_notificacion"    =>     $this-> fecha_notificacion,
						"semana_epidemiologica" =>     $this-> semana_epidemiologica,
						"busqueda_activa"       =>     $this-> busqueda_activa,
						"nro_control"           =>     $this-> nro_control,
						"id_establecimiento"    =>     $this-> id_establecimiento,
						"cod_establecimiento"   =>     $this-> cod_establecimiento,
						"id_consultorio"        =>     $this-> id_consultorio,
						"red_salud"             =>     mb_strtoupper($this-> red_salud),
						"id_departamento"       =>     $this-> id_departamento,
						"id_localidad"          =>     $this-> id_localidad,
						"estado_ficha"          =>     "1",
						"sub_sector"            =>     $this-> sub_sector,
						"id_municipio"          =>     $this-> id_municipio,

               
						
						"paterno"               =>  $this->paterno,
						"materno"               =>  $this->materno,
						"nombre"                =>  $this->nombre,
						"cod_asegurado"         =>  $this->cod_asegurado,
						"cod_afiliado"          =>  $this->cod_afiliado,
						"cod_empleador"         =>  $this->cod_empleador,
						"nombre_empleador"      =>  $this->nombre_empleador,
						"nro_documento"         =>  $this->nro_documento,
						"sexo"                  =>  $this->sexo,
						"fecha_nacimiento"      =>  $this->fecha_nacimiento,
						"edad"                  =>  $this->edad,
						"id_departamento_paciente"  =>  $this->id_departamento_paciente,
						"id_provincia_paciente"     =>  $this->id_provincia_paciente,
						"id_municipio_paciente"     =>  $this->id_municipio_paciente,
						"id_pais_paciente"          =>  $this->id_pais_paciente,
						"zona"                      =>  mb_strtoupper($this->zona,'utf-8'),
						"calle"                     =>  mb_strtoupper($this->calle,'utf-8'),
						"nro_calle"                 =>  $this->nro_calle,
						"telefono"                  =>  $this->telefono,
						"email"                     =>  $this->email,
						"nombre_apoderado"          => mb_strtoupper($this->nombre_apoderado,'utf-8'),
						"telefono_apoderado"        =>  $this->telefono_apoderado,
						
						"identificacion_etnica"     =>  $this->identificacion_etnica,
						"discapacidad"              =>  $this->discapacidad,						


						
						"ocupacion"  =>  mb_strtoupper($this->ocupacion,'utf-8'),
						"ant_vacuna_influenza"  =>  $this->ant_vacuna_influenza,
						"fecha_vacuna_influenza"  =>  $this->fecha_vacuna_influenza,
						"viaje_riesgo"  =>  $this->viaje_riesgo,
						"pais_ciudad_riesgo"  =>  $this->pais_ciudad_riesgo,
						"fecha_retorno"  =>  $this->fecha_retorno,
						"empresa_vuelo"  =>  $this->empresa_vuelo,
						"nro_vuelo"  =>  $this->nro_vuelo,
						"nro_asiento"  =>  $this->nro_asiento,
						"contacto_covid"  =>  $this->contacto_covid,
						"fecha_contacto_covid"  =>  $this->fecha_contacto_covid,
						"nombre_contacto_covid"  =>  mb_strtoupper($this->nombre_contacto_covid,'utf-8'),
						"telefono_contacto_covid"  =>  $this->telefono_contacto_covid,
						"pais_contacto_covid"  => mb_strtoupper($this->pais_contacto_covid,'utf-8'),
						"lugar_aproximado_infeccion"  =>  $this->lugar_aproximado_infeccion,
						"departamento_contacto_covid"  =>   mb_strtoupper($this->departamento_contacto_covid,'utf-8'),
						"provincia_contacto_covid"  =>  $this->provincia_contacto_covid,
						"localidad_contacto_covid"  =>  mb_strtoupper($this->localidad_contacto_covid,'utf-8'),
						"diagnosticado_covid_anteriormente"  =>  $this->diagnosticado_covid_anteriormente,
						"fecha_covid_anteriormente"  =>  $this->fecha_covid_anteriormente,
						
						

						"fecha_inicio_sintomas"	           => $this->fecha_inicio_sintomas, 
						"paciente_estado"                  => mb_strtoupper($this->paciente_estado),
						"fecha_defuncion"    	           => $this->fecha_defuncion,
						"diagnostico_clinico"              => mb_strtoupper($this->diagnostico_clinico,'utf-8'),
						"paciente_asintomatico"	           => mb_strtoupper($this->paciente_asintomatico),												
						/* "malestar_tos"    	           	   => mb_strtoupper($this->malestar_tos,'utf-8'),
						"malestar_fiebre"    	           => mb_strtoupper($this->malestar_fiebre,'utf-8'),
						"malestar_general"    	           => mb_strtoupper($this->malestar_general,'utf-8'),
						"malestar_cefalea"    	           => mb_strtoupper($this->malestar_cefalea,'utf-8'),
						"malestar_dif_respira"    	       => mb_strtoupper($this->malestar_dif_respira,'utf-8'),
						"malestar_mialgias"    	           => mb_strtoupper($this->malestar_mialgias,'utf-8'),
						"malestar_dolor_garganta"    	   => mb_strtoupper($this->malestar_dolor_garganta,'utf-8'),
						"malestar_perdida_olfato"    	   => mb_strtoupper($this->malestar_perdida_olfato,'utf-8'),
						"malestar_otros"    	   		   => mb_strtoupper($this->malestar_otros,'utf-8'), */
						


						
						"fecha_inicio_sintomas"  =>  $this->fecha_inicio_sintomas,
						"malestares"  =>  $this->malestares,
						"malestares_otros"  =>  mb_strtoupper($this->malestares_otros,'utf-8'),
						"estado_paciente"  =>  $this->estado_paciente,
						"fecha_defuncion"  =>  $this->fecha_defuncion,
						"diagnostico_clinico"  =>  mb_strtoupper($this->diagnostico_clinico,'utf-8'),
						
						"sintoma"  =>  $this->sintoma,


						
						"dias_notificacion"  =>  $this->dias_notificacion,
						"dias_sin_sintomas"  =>  $this->dias_sin_sintomas,
						"fecha_aislamiento"  =>  $this->fecha_aislamiento,
						"lugar_aislamiento"  =>  mb_strtoupper($this->lugar_aislamiento,'utf-8'),
						"fecha_internacion"  =>  $this->fecha_internacion,
						"establecimiento_internacion"  =>  mb_strtoupper($this->establecimiento_internacion,'utf-8'),
						"ventilacion_mecanica"  =>  $this->ventilacion_mecanica,
						"terapia_intensiva"  =>  $this->terapia_intensiva,
						"fecha_ingreso_UTI"  =>  $this->fecha_ingreso_UTI,
						"lugar_ingreso_UTI"  =>  $this->lugar_ingreso_UTI,
						"tratamiento"  =>  $this->tratamiento,
						"tratamiento_otros"  =>  $this->tratamiento_otros,
						"metodo_hospitalizacion"  =>  $this->metodo_hospitalizacion,
						
						

						
						"enf_estado"  =>  $this->enf_estado,
						"enf_riesgo"  =>  $this->enf_riesgo,
						"id_ficha"  =>  $this->id_ficha,
						"hipertension_arterial"  =>  $this->hipertension_arterial,
						"obesidad"  =>  $this->obesidad,
						"diabetes_general"  =>  $this->diabetes_general,
						"embarazo"  =>  $this->embarazo,
						"enfermedades_oncologica"  =>  $this->enfermedades_oncologica,
						"enfermedades_cardiaca"  =>  $this->enfermedades_cardiaca,
						"enfermedad_respiratoria"  =>  $this->enfermedad_respiratoria,
						"enfermedades_renal_cronica"  =>  $this->enfermedades_renal_cronica,
						"otros"  =>  mb_strtoupper($this->otros),
						

						
						"estado_muestra"  =>  $this->estado_muestra,
						"id_establecimiento"  =>  $this->id_establecimiento,
						"tipo_muestra"  =>  $this->tipo_muestra,
						"nombre_laboratorio"  =>  $this->nombre_laboratorio,
						"cod_laboratorio"  =>  $this->cod_laboratorio,
						"fecha_muestra"  =>  $this->fecha_muestra,
						"fecha_envio"  =>  $this->fecha_envio,
						"responsable_muestra"  =>  $this->responsable_muestra,
						"observaciones_muestra"  =>  $this->observaciones_muestra,
						"resultado_laboratorio"  =>  $this->resultado_laboratorio,
						"fecha_resultado"  =>  $this->fecha_resultado,
						
						"des_no_muestra"  =>  $this->des_no_muestra,
						"cod_laboratorio_muestra"  =>  $this->cod_laboratorio_muestra,
						"cod_laboratorio_muestra2"  =>  $this->cod_laboratorio_muestra2,
						

						"paterno_notificador"	           => mb_strtoupper($this->paterno_notificador,'utf-8'), 
						"materno_notificador"              => mb_strtoupper($this->materno_notificador,'utf-8'),
						"nombre_notificador"               => mb_strtoupper($this->nombre_notificador,'utf-8'),
						"telefono_notificador"             => $this->telefono_notificador,
						"cargo_notificador"                => mb_strtoupper($this->cargo_notificador,'utf-8')

						);	

		// var_dump($datos);

		$respuesta = ControladorFichas::ctrGuardarFichaEpidemiologica($datos);

		return $respuesta;

	}

	/*=============================================
	GUARDANDO DATOS EN LA FICHA DE CONTROL Y SEGUIMIENTO
	=============================================*/

	public function ajaxGuardarFichaControl()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$datos = array( "id_ficha"  				       => $this->id_ficha,
						"id_establecimiento"		       => $this->id_establecimiento, 
						"id_consultorio"		       	   => $this->id_consultorio,
						"id_departamento_paciente"         => $this->id_departamento_paciente,
						"identificacion_etnica"	           => $this->identificacion_etnica,
						"id_pais_paciente"			       => $this->id_pais_paciente,
						"id_provincia_paciente"			   => $this->id_provincia_paciente,
						"id_municipio_paciente"			   => $this->id_municipio_paciente,
						"fecha_notificacion"     	       => $this->fecha_notificacion,
						"nro_control"   		           => $this->nro_control,
						"tipo_ficha"   	     		       => "FICHA CONTROL Y SEGUIMIENTO",
						"estado_ficha"   	     		   => "1",

						"cod_asegurado"		  	           => $this->cod_asegurado, 
						"cod_afiliado"	      	           => $this->cod_afiliado, 
						"cod_empleador"    		           => $this->cod_empleador,
						"nombre_empleador"    	           => $this->nombre_empleador,
						"paterno"     	      	           => $this->paterno,
						"materno"     	      	           => $this->materno,
						"nombre"     	      	           => $this->nombre,
						"sexo"     	          	           => $this->sexo,
						"nro_documento"    		           => $this->nro_documento,
						"fecha_nacimiento"    	           => $this->fecha_nacimiento,
						"edad"     	          	           => $this->edad,
						"telefono"     	          	       => $this->telefono,
						"email"     	          	       => $this->email,
					
						"dias_notificacion"	               => $this->dias_notificacion, 
						"dias_sin_sintomas"	               => $this->dias_sin_sintomas, 
						"fecha_aislamiento"	               => $this->fecha_aislamiento, 
						"lugar_aislamiento"     	       => mb_strtoupper($this->lugar_aislamiento,'utf-8'),
						"fecha_internacion"    	           => $this->fecha_internacion,
						"establecimiento_internacion"      => mb_strtoupper($this->establecimiento_internacion,'utf-8'),
						"fecha_ingreso_UTI"   	           => $this->fecha_ingreso_UTI,
						"lugar_ingreso_UTI"   	           => $this->lugar_ingreso_UTI,
						"ventilacion_mecanica"             => $this->ventilacion_mecanica,
						"tratamiento"       		       => $this->tratamiento,
						"tratamiento_otros"         	   => mb_strtoupper($this->tratamiento_otros,'utf-8'),

						"tipo_muestra"     	               => mb_strtoupper($this->tipo_muestra,'utf-8'),
						"fecha_muestra"  		           => $this->fecha_muestra,
						"fecha_envio"     	               => $this->fecha_envio,
						"responsable_muestra" 	           => mb_strtoupper($this->responsable_muestra),

						"paterno_notificador"	           => mb_strtoupper($this->paterno_notificador,'utf-8'), 
						"materno_notificador"              => mb_strtoupper($this->materno_notificador,'utf-8'),
						"nombre_notificador"               => mb_strtoupper($this->nombre_notificador,'utf-8'),
						"telefono_notificador"             => $this->telefono_notificador,
						"cargo_notificador"                => mb_strtoupper($this->cargo_notificador,'utf-8'),

						);	

		$respuesta = ControladorFichas::ctrGuardarFichaControl($datos);

		echo $respuesta;
	}

	public $item; 
	public $valor;
	public $tabla;

	public function ajaxGuardarCampoFicha()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$id_ficha = $this->id_ficha;
		$item = $this->item;
		$valor = mb_strtoupper($this->valor,'utf-8');
		$tabla = $this->tabla; 	

		$respuesta = ControladorFichas::ctrGuardarCampoFichaEpidemiologica($id_ficha, $item, $valor, $tabla);

		echo $respuesta;

	}

	/*=============================================
	MOSTRAR EN PDF FICHA EPIDEMIOLÓGICA
	=============================================*/

	public function ajaxMostrarFichaEpidemiologicaPDF()	{

		/*=============================================
	    DATOS SECCION 1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR
	    =============================================*/
		
		$item = "id_ficha";
		$valor = $this->idFicha;

		$ficha = ControladorFichas::ctrMostrarDatosFicha($item, $valor);

	    //TRAEMOS LOS DATOS DE DEPARTAMENTO

	    $item = "id";
	    $valor = $ficha["id_departamento"];
	    $departamento = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

	    //TRAEMOS LOS DATOS DE ESTABLECIMIENTO

	    $valor = $ficha["id_establecimiento"];
	    $establecimiento = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

	    //TRAEMOS LOS CONSULTORIOS

	    $valor = $ficha["id_consultorio"];
	    $consultorio = ControladorConsultorios::ctrMostrarConsultorios($item, $valor);

	    //TRAEMOS LOS DATOS DE LOCALIDAD

	    $valor = $ficha["id_localidad"];
		$localidad = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);
		

		//TRAEMOS EL MUNICIPIO
		$municipio =  ControladorMunicipio::ctrMostrarMunicipioDadoUnIdMunicipio($ficha['id_municipio']);
		$nombre = $municipio[0]["nombre_municipio"];
		//var_dump($municipio);

	    /*=============================================
	    DATOS SECCION 2. IDENTIFICACION DEL CASO/PACIENTE
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $pacienteAsegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item, $valor);

		if(!$pacienteAsegurado){ // Se modifico por la duplicidad
			$ficha = ControladorFichas::ctrMostrarFichas('id_ficha', $valor);
			$pacienteAsegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $ficha['id_paciente']);
		}


		//TRAEMOS LOS DATOS DE DEPARTAMENTO
	    $item = "id";
	    $valor_depto = $pacienteAsegurado["id_departamento_paciente"];
	    $departamento_paciente = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor_depto);

	    // TRAEMOS LOS DATOS DE PROVINCIA		
		
		// TRAEMOS LOS DATOS MUNICIPIO
		$id_municipio = $pacienteAsegurado["id_municipio_paciente"];
		$municipio_paciente = ControladorMunicipio::ctrMostrarMunicipio($item,$id_municipio);
	    



	    //TRAEMOS LOS DATOS DE PAIS

	    $valor_pais = $pacienteAsegurado["id_pais_paciente"];

	    $pais_paciente = ControladorPaises::ctrMostrarPaises($item, $valor_pais);

	    /*=============================================
	    DATOS SECCION 3. ANTECEDENTES EPIDEMIOLOGICOS
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $ant_epidemiologicos = ControladorAntEpidemiologicos::ctrMostrarAntEpidemiologicos($item, $valor);

	    /*=============================================
	    DATOS SECCION 4. DATOS CLINICOS
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;
	    $datos_clinicos = ControladorDatosClinicos::ctrMostrarDatosClinicos($item, $valor);
		$malestar = ControladorMalestar::ctrMostrarMalestar($valor);


	    /*=============================================
	    DATOS SECCION 5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $hospitalizaciones_aislamientos = ControladorHospitalizacionesAislamientos::ctrMostrarHospitalizacionesAislamientos($item, $valor);

	    /*=============================================
	    DATOS SECCION 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $enfermedades_bases = ControladorEnfermedadesBases::ctrMostrarEnfermedadesBases($item, $valor);

	    /*=============================================
	    DATOS SECCION 8. LABORATORIO
	    =============================================*/
        //PRIMETA PARTE

			$item = "id_ficha";
			$valor = $this->idFicha;

			$laboratorios = ControladorLaboratorios::ctrMostrarLaboratorios($item, $valor);

			// TRAEMOS LOS DATOS DE ESTABLECIMIENTO PARA LABORATORIO

			$item = "id";
			$valor = $laboratorios["id_establecimiento"];

			$establecimiento_lab = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

        //SEGUNDA PARTE 
		 
		$covidResultados = ModeloCovidResultados::getCovidResultados('covid_resultados','id_ficha',$this->idFicha);
		if(count($covidResultados) > 0){ // Se modifico por la duplicidad
			$covidResultados = $covidResultados[0];
		}
		else $covidResultados = array('resultado' => 'NINGUNO');

	    /*=============================================
	    9. DATOS SECCION PERSONAL QUE NOTIFICA
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item, $valor);

		// Extend the TCPDF class to create custom Header and Footer

		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('ficha-'.$valor);
		$pdf->SetSubject('Ficha Epidemiologica Covid-19 CNS');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, Ficha Epidemiologica,Covid-19');

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, 5, 5, 0);
		$pdf->SetAutoPageBreak(true, 5); 
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('Helvetica', '', 8);

		// add a page
		$pdf->AddPage();

		$content = '';

		  $content .= '

		  <html lang="es">
				<head>
					<style>
						@page {
							margin: 0cm 0cm;
						}

						body {
							font-size: 21px;
							margin: 0;
							padding: 0;
						}

						.header {
							position: fixed;
							top: 0cm;
							left: 0cm;
							right: 0cm;
							height: 0cm;
						}

						.content div{

							line-height: 0px;

						}

						.bg-dark {

							background-color: #444;
							color: #fff;
							text-align: center;
							line-height: 0px;
						
						}

						.bg-dark span {

							line-height: 7px;
							font-weight: bold;

						}

						.bg-dark1 {

							background-color: #777;
							color: #fff;
							text-align: center;
							line-height: 0px;
						
						}

						.bg-dark1 span {

							line-height: 4px;
							font-weight: bold;

						}						

						.font-weight-bold {

							font-weight: bold;

						}

						.titulo {

							text-align: center;
							line-height: 4px;

						}

						.cod_ficha {

							margin-top: 0px;
							text-align: right;
							
						}

						table {

						  line-height: 6px;

						}

						.personas_contactos {

							line-height: 0px;

						}

						td {

						  margin-top: 0px;

						}

						th {

						  text-align: center;

						}

						.mensaje {

							text-align: center;
							line-height: 7px;

						}

						.laboratorios .mensaje {

							margin-top: 0px;
							text-align: center;
							line-height: 0px;

						}
						.content input[type="checkbox"]{
							color: red;
							box-shadow: 0px 0px 4px 4px blue;
							border-radius: 50%;
						}

					</style>
					
				</head>

				<body>
					<header>
						<table border="0" cellpadding="2">
							<tr>
								<td width="8%" align="center">
									<img src="../vistas/img/cns/cns-logo-simple.png" height="55px" style="margin: 0 auto;"/>
								</td>
								<td width="84%" style="text-align:justify;">
									<h1>FICHA EPIDEMIOLÓGICA Y SOLICITUD DE ESTUDIOS DE LABORATORIO COVID-19</h1>
								</td>
								<td width="8%">';
									$dir ="../temp/cod_qr/";
									if (!file_exists($dir))
										mkdir($dir);
									$filename = $dir.'fichaEpidemiologica.png';
									$tamaño = 10; //Tamaño de Pixel
									$level = 'H'; //Precisión alta
									$framSize = 3; //Tamaño en blanco										
									$contenido = 'COD. FICHA: '.$this->idFicha."\n"; // texto
										//Enviamos los parametros a la Función para generar código QR 
									QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
										//Mostramos la imagen generada
									$content .=									
									'<img src="'.$dir.basename($filename).'" />										
								</td>
							</tr>
							<tr>
								<td width="10%">
									<label>Ficha Nº: '.$this->idFicha.'</label>
								</td>
								<td width="20%">
									<label><strong>Matricula:  '.$pacienteAsegurado['cod_afiliado'].'</strong></label>
								</td>
								<td width="20%">
									<label>Cod Empleador:<strong>  '.$pacienteAsegurado['cod_empleador'].'</strong></label>
								</td>
								<td colspan="3" width="50%">
									<label>Nombre Empleador:<strong>  '.$pacienteAsegurado['nombre_empleador'].'</strong></label>
								</td>								
							</tr>
						</table>
					</header>				

					<div class="content" border="0">
							
						<div class="datos_establecimiento">
					      
					    <div class="bg-dark">

					      <span>1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR</span>
					      
					    </div>

							<table>
								
								<tr>
									<td width="300px">
										<label class="font-weight-bold">Establecimiento de Salud: </label> '.$establecimiento["nombre_establecimiento"].'
									</td>
									<td width="150px">
										<label class="font-weight-bold">Cod. Estab: </label> '.$ficha["cod_establecimiento"].'
									</td>
									<td width="150px">
										<label class="font-weight-bold">Red de Salud:</label> '.$ficha["red_salud"].'
									</td>
								</tr>

							</table>

							<table>

								<tr>
									<td width="200px">
										<label class="font-weight-bold">Departamento:</label> '.$departamento["nombre_depto"].'
									</td>
									<td width="200px">
										<label class="font-weight-bold">Municipio:</label> '.$municipio[0]["nombre_municipio"].'
									</td>
								</tr>

							</table>

							<table>
							  <tr>
								<td>
								  <label class="font-weight-bold">Sub Sector:</label> 
								</td>
								'; 

								switch ($ficha["sub_sector"]) {
								
									case "PUBLICO":
										$content .=
											'
											
											<td>
												<label class="font-weight-bold">PUBLICO</label>
												<input type="checkbox"  name ="publico" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">SEGURIDAD SOCIAL CNS</label>
												<input type="checkbox"  name ="segusocial" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">PRIVADO</label>
												<input type="checkbox"  name ="privado" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">OTRO</label>
												<input type="checkbox"  name ="otro" class="checkboxpdf" disabled="disabled">
											</td>
								
											';
									
										break;
										
									case "SEGURIDAD SOCIAL CNS":
										$content .=
											'
											
											<td>
												<label class="font-weight-bold">PUBLICO</label>
												<input type="checkbox"  name ="publico" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">SEGURIDAD SOCIAL CNS</label>
												<input type="checkbox"  name ="segusocial" class="checkboxpdf labelpdf"  checked="checked" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">PRIVADO</label>
												<input type="checkbox"  name ="privado" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">OTRO</label>
												<input type="checkbox"  name ="otro" class="checkboxpdf" disabled="disabled">
											</td>
								
											';
									
										break;
								
									case "PRIVADO":
										$content .=
											'
											
											<td>
												<label class="font-weight-bold">PUBLICO</label>
												<input type="checkbox"  name ="publico" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">SEGURIDAD SOCIAL CNS</label>
												<input type="checkbox"  name ="segusocial" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">PRIVADO</label>
												<input type="checkbox"  name ="privado" class="checkboxpdf labelpdf"  checked="checked" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">OTRO</label>
												<input type="checkbox"  name ="otro" class="checkboxpdf" disabled="disabled">
											</td>
								
											';
									
										break;	
								
									case "OTRO":
										$content .=
											'
											
											<td>
												<label class="font-weight-bold">PUBLICO</label>
												<input type="checkbox"  name ="publico" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">SEGURIDAD SOCIAL CNS</label>
												<input type="checkbox"  name ="segusocial" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">PRIVADO</label>
												<input type="checkbox"  name ="privado" class="checkboxpdf" disabled="disabled">
											</td>
											<td>
												<label class="font-weight-bold">OTRO</label>
												<input type="checkbox"  name ="otro" class="checkboxpdf labelpdf"  checked="checked" disabled="disabled">
											</td>
								
											';
									
										break;					
									
									default: 
										$content .=
										'
										<label class="font-weight-bold">DEFAULT</label>
									
										';
										break;
									}
									$content .= 
								
								'

							  </tr>
							</table>
							<table>  
							  <tr>

								<td width="300px">';

									if ($ficha["fecha_notificacion"] == "0000-00-00") {
										
										$content .= 
										'<label class="font-weight-bold">Fecha de Notificación:</label>';

									} else {

										$content .= 
										'<label class="font-weight-bold">Fecha de Notificación:</label> '.date("d/m/Y", strtotime($ficha["fecha_notificacion"]));

									}

									$content .=
								'</td>

								<td width="100px">';

									if ($ficha["semana_epidemiologica"] == "0") {
										
										$content .= 
										'<label class="font-weight-bold">Sem. Epidemiológica:</label>';

									} else {

										$content .= 
										'<label class="font-weight-bold">Sem. Epidemiológica:</label> '.$ficha["semana_epidemiologica"];

									}

									$content .=
								'</td>

								<td width="250px">

									<label class="font-weight-bold">Caso identificado por búsqueda activa:</label>'; 

									switch ($ficha["busqueda_activa"]) {

										case "SI":
											$content .=
												'
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  class="checkboxpdf" name="checkno" disabled="disabled">
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="checksi" checked="checked" disabled="disabled">

												';
										
											break;
										
										case "NO":
											$content .=
												'
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="checkno" checked="checked" disabled="disabled">
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  class="checkboxpdf" name="checksi" disabled="disabled">
												
												';
											break;
										
										default: 
											$content .=
											'
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="checksi" disabled="disabled">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox"  class="checkboxpdf" name="checkno" disabled="disabled">
										
											';
											break;
										}
										$content .= 

								'									 	
								</td>							  
							  </tr>	
							</table>
							
					  </div>

					  <div class="paciente">					      
					    <div class="bg-dark py-1 text-center text-white">
					      <span>2. IDENTIFICACIÓN DEL CASO/PACIENTE</span>					      
					    </div>

					    <table border"0">					    	
					    	<tr>
								<td width="40%">
					    			<label class="font-weight-bold">N° Carnet de Indentidad/Cedula de extranjero/Pasaporte :</label> '.$pacienteAsegurado['nro_documento'].'
					    		</td>					    		
					    		<td width="40%">';
									if ($pacienteAsegurado['fecha_nacimiento'] == "0000-00-00") {										
										$content .= 
										'<label class="font-weight-bold">Fecha de Nacimiento:   __/__/__  </label>';
									} else {
										$content .= 
										'<label class="font-weight-bold">Fecha de Nacimiento:</label> '.date("d/m/Y", strtotime($pacienteAsegurado['fecha_nacimiento']));

									}
									$content .=
					    		'</td>
					    		<td width="20%">
					    			<label class="font-weight-bold">Edad:</label> '.$pacienteAsegurado['edad'].'
					    		</td>
					    	</tr>
					    </table>
					     <table border="0">
					    	<tr>
					    		<td width="50%">
					    			<label class="font-weight-bold">Nombre y Apellidos:</label> '.$pacienteAsegurado['nombre'].' '.$pacienteAsegurado['paterno'].' '.$pacienteAsegurado['materno'].'					    			
					    		</td>
								<td width="25%">
									<label class="font-weight-bold">Sexo: </label>';
									if($pacienteAsegurado['sexo']=="F"){
										$content .= 
											'<label class="font-weight-bold">F </label>
											<input type="checkbox" name="sexoF" value="" checked="checked">
											<label class="font-weight-bold">M</label>
											<input type="checkbox" name="sexoM" value="0">
										';
									}
									else if($pacienteAsegurado['sexo']=="M"){
										$content .=
											'<label class="font-weight-bold">F</label>
											<input type="checkbox" name="sexoF" value="">
											<label class="font-weight-bold">M</label>
											<input type="checkbox" name="sexoM" value="0" checked="checked">
										';

									}
									$content .=					    			
					    		'</td>
								<td width="25%">
					    			<label class="font-weight-bold">Identificacion Etnica :</label> '.$pacienteAsegurado['identificacion_etnica'].'					    			
					    		</td>
					    	</tr>
					    </table>

					    <table border="0">
					    	<tr>
					    		<td width="40%">
					    			<label class="font-weight-bold">Pais de procedencia:  '.$pais_paciente['nombre_pais'].'</label>
					    		</td>
					    		<td width="40%">
					    			<label class="font-weight-bold">Resicencia actual Departamento:  '.$departamento_paciente['nombre_depto'].'</label>
					    		</td>
								<td width="20%">
									<label class="font-weight-bold">Municipio:  '.$municipio_paciente['nombre_municipio'].'</label>
								</td>
					    	</tr>
					    </table>

					    <table border="0">
					    	<tr>					    		
					    		<td width="40%">
									<label class="font-weight-bold">Calle:  '.$pacienteAsegurado["calle"].'</label>
					    		</td>								
					    		<td width="20%">
					    			<label class="font-weight-bold">Zona: '.$pacienteAsegurado["zona"].'</label>
					    		</td>
								<td width="20%">
									<label class="font-weight-bold">Nº: '.$pacienteAsegurado["nro_calle"].'</label>
							    </td>
								<td width="20%">
									<label class="font-weight-bold">Telefono: '.$pacienteAsegurado["telefono"].'</label>
							    </td>
					    	</tr>
					    </table>

					    <table border="0">
					    	<tr>
					    		<td width="78%">
					    			<label class="font-weight-bold">Si es menor de edad Nombre del Padre/Madre o apoderado: '.$pacienteAsegurado["nombre_apoderado"].'</label>
					    		</td>
					    		<td width="22%">
					    			<label class="font-weight-bold">Telefono Apoderado:'.$pacienteAsegurado["telefono_apoderado"].'</label>
					    		</td>
					    	</tr>
					    </table>
					  </div>

					  <div class="antecedentes_epidemiologicos">
					      
					    <div class="bg-dark py-1 text-center text-white">

					      <span>3. ANTECEDENTES EPIDEMIOLOGICOS</span>
					      
					    </div>

					    <table>
					    	
					    	<tr>
					    		<td  width="70px">
					    			<label class="font-weight-bold">Ocupación: </label> 
					    		</td>
								'; 

									switch ($ant_epidemiologicos['ocupacion']) {

										case "PERSONAL DE SALUD":
											$content .=
												'
												<td  width="100px">
													<label class="font-weight-bold">PERSONAL DE SALUD</label>
													<input type="checkbox"   name="persalud" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="150px">
													<label class="font-weight-bold">PERSONAL DE LABORATORIO</label>
													<input type="checkbox"  name="perlab" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="120px">
													<label class="font-weight-bold">TRABAJADOR PRENSA</label>
													<input type="checkbox"  name="trabaprensa" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="70px">
													<label class="font-weight-bold">FF.AA.</label>
													<input type="checkbox"   name="fuerzas" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="70px">
													<label class="font-weight-bold">POLICIA</label>
													<input type="checkbox"   name="policia" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"   name="otroaep" class="checkboxpdf" disabled="disabled">
												</td>														

												';
										
											break;
										
										case "PERSONAL DE LABORATORIO":
											$content .=
												'
												<td  width="100px">
													<label class="font-weight-bold">PERSONAL DE SALUD</label>
													<input type="checkbox"   name="persalud" class="checkboxpdf"  disabled="disabled">
												</td>
												<td width="150px">
													<label class="font-weight-bold">PERSONAL DE LABORATORIO</label>
													<input type="checkbox"  name="perlab" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="120px">
													<label class="font-weight-bold">TRABAJADOR PRENSA</label>
													<input type="checkbox"  name="trabaprensa" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="70px">
													<label class="font-weight-bold">FF.AA.</label>
													<input type="checkbox"   name="fuerzas" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="70px">
													<label class="font-weight-bold">POLICIA</label>
													<input type="checkbox"   name="policia" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"   name="otroaep" class="checkboxpdf" disabled="disabled">
												</td>													

												';
											break;

										case "TRABAJADOR PRENSA":
											$content .=
												'
												<td  width="100px">
													<label class="font-weight-bold">PERSONAL DE SALUD</label>
													<input type="checkbox"   name="persalud" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="150px">
													<label class="font-weight-bold">PERSONAL DE LABORATORIO</label>
													<input type="checkbox"  name="perlab" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="120px">
													<label class="font-weight-bold">TRABAJADOR PRENSA</label>
													<input type="checkbox"  name="trabaprensa" class="checkboxpdf labelpdf"  checked="checked" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">FF.AA.</label>
													<input type="checkbox"   name="fuerzas" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">POLICIA</label>
													<input type="checkbox"   name="policia" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"   name="otroaep" class="checkboxpdf" disabled="disabled">
												</td>													

												';
											break;

										case "FF.AA.":
											$content .=
												'
												<td  width="100px">
													<label class="font-weight-bold">PERSONAL DE SALUD</label>
													<input type="checkbox"   name="persalud" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="150px">
													<label class="font-weight-bold">PERSONAL DE LABORATORIO</label>
													<input type="checkbox"  name="perlab" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="120px">
													<label class="font-weight-bold">TRABAJADOR PRENSA</label>
													<input type="checkbox"  name="trabaprensa" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">FF.AA.</label>
													<input type="checkbox"   name="fuerzas" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">POLICIA</label>
													<input type="checkbox"   name="policia" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"   name="otroaep" class="checkboxpdf" disabled="disabled">
											    </td>	

												';
											break;

										case "POLICIA":
											$content .=
												'
												<td  width="100px">
													<label class="font-weight-bold">PERSONAL DE SALUD</label>
													<input type="checkbox"   name="persalud" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="150px">
													<label class="font-weight-bold">PERSONAL DE LABORATORIO</label>
													<input type="checkbox"  name="perlab" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="120px">
													<label class="font-weight-bold">TRABAJADOR PRENSA</label>
													<input type="checkbox"  name="trabaprensa" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">FF.AA.</label>
													<input type="checkbox"   name="fuerzas" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">POLICIA</label>
													<input type="checkbox"   name="policia" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"   name="otroaep" class="checkboxpdf" disabled="disabled">
											    </td>

												';
											break;										
												
										
										default: 
											$content .=
											'
											    <td  width="100px">
													<label class="font-weight-bold">PERSONAL DE SALUD</label>
													<input type="checkbox"   name="persalud" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="150px">
													<label class="font-weight-bold">PERSONAL DE LABORATORIO</label>
													<input type="checkbox"  name="perlab" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="120px">
													<label class="font-weight-bold">TRABAJADOR PRENSA</label>
													<input type="checkbox"  name="trabaprensa" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">FF.AA.</label>
													<input type="checkbox"   name="fuerzas" class="checkboxpdf" disabled="disabled">
												</td>
												<td  width="70px">
													<label class="font-weight-bold">POLICIA</label>
													<input type="checkbox"   name="policia" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="40px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"   name="otroaep" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
											    </td>

												<td width="60px">
													<label>'. $ant_epidemiologicos['ocupacion']. '</label>													
											    </td>
										
											';
											break;
										}
										$content .= 

					    		'
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">
					    			<label class="font-weight-bold">¿Tuvo contacto con un caso de COVID-19:</label>
					    		</td>
								';
								switch ($ant_epidemiologicos['contacto_covid']) {
			
								case "SI":
									$content .=
										'
										<td  width="50px">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox" class="checkboxpdf"name="contactno"  disabled="disabled">
									    </td>
										<td  width="50px">
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf labelpdf" name="contactsi" checked="checked" disabled="disabled">
										</td>
			
										';
			
									break;
			
								case "NO":
									$content .=
										'
										<td  width="50px">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox" class="checkboxpdf labelpdf"name="contactno" checked="checked" disabled="disabled">
									    </td>
										<td  width="50px">
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="contactsi"  disabled="disabled">
										</td>
										';
									break;
			
								default: 
									$content .=
									'
										<td  width="50px">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox" class="checkboxpdf labelpdf"name="contactno" disabled="disabled">
									    </td>
										<td  width="50px">
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="contactsi"  disabled="disabled">
										</td>
		
									';
									break;
								}
			
								$content .= 
			
			          '		
					    		<td width="150px">';

					    		if ($ant_epidemiologicos['fecha_contacto_covid'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">Fecha de Contacto:</label>
									<label class="font-weight-bold">...../....../......</label>
									';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">Fecha de Contacto:</label> '.date("d/m/Y", strtotime($ant_epidemiologicos['fecha_contacto_covid']));					    			

					    		}

									$content .=
					    		'</td>
					    	</tr>

					    </table>

						<table>

							<tr>
								<td width="200px">
									<label class="font-weight-bold"> Fue Diagnosticado por COVID-19 anteriormente?:</label>
								</td>
								';
								switch ($ant_epidemiologicos['diagnosticado_covid_anteriormente']) {
			
								case "SI":
									$content .=
										'
										<td  width="50px">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox" class="checkboxpdf"name="covidantno"  disabled="disabled">
										</td>										
										<td  width="50px">
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf labelpdf" name="covidantsi" checked="checked" disabled="disabled">
										</td>
			
										';
			
									break;
			
								case "NO":
									$content .=
										'
										<td  width="50px">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox" class="checkboxpdf labelpdf"name="covidantno" checked="checked" disabled="disabled">
										</td>										
										<td  width="50px">
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="covidantsi"  disabled="disabled">
										</td>
										';
									break;
			
								default: 
									$content .=
									'
										<td  width="50px">
											<label class="font-weight-bold">NO</label>
											<input type="checkbox" class="checkboxpdf labelpdf"name="covidantno" disabled="disabled">
									    </td>									
										<td  width="50px">
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="covidantsi"  disabled="disabled">
										</td>
			
									';
									break;
								}
			
								$content .=
								'<td width="150px">';

									if ($ant_epidemiologicos['fecha_covid_anteriormente'] == "0000-00-00") {
										$content .= 
										'<label class="font-weight-bold">Fecha de Contacto:</label>
										<label class="font-weight-bold">...../....../......</label>
										';

									} else {

											$content .= 
										'<label class="font-weight-bold">Fecha:</label> '.date("d/m/Y", strtotime($ant_epidemiologicos['fecha_covid_anteriormente']));					    			

									}
									$content .=
								'</td>
							</tr>

					   </table>


					    <table>

					    	<tr>
					    		<td colspan="3" width="300px">
					    			<label class="font-weight-bold">Lugar Probable de Infeccion:</label>
					    		</td>
					    	</tr>
					    	<tr>
					    		<td width="150px">
					    			<label class="font-weight-bold">País: </label>';

									if ($ant_epidemiologicos['pais_contacto_covid'] == "") {
										$content .= 
										'
										 <label class="font-weight-bold">.................</label>
										';

									} else {

											$content .= $ant_epidemiologicos['pais_contacto_covid'];

									}
									$content .=
								'			
					    		</td>	    	
					    		<td width="150px">
					    			<label class="font-weight-bold">Departamento/Estado: </label>';

									if ($ant_epidemiologicos['departamento_contacto_covid'] == "") {
										$content .= 
										'
										 <label class="font-weight-bold">.................</label>
										';

									} else {

											$content .= $ant_epidemiologicos['departamento_contacto_covid'];

									}
									$content .=
								'			
					    		</td>
								<td width="150px">
								   <label class="font-weight-bold">Provincia: </label>';

								   if ($ant_epidemiologicos['provincia_contacto_covid'] == "") {
									   $content .= 
									   '
										<label class="font-weight-bold">.................</label>
									   ';

								   } else {

										   $content .= $ant_epidemiologicos['provincia_contacto_covid'];

								   }
								   $content .=
							   '	
							     </td>
					    		<td width="150px">
					    			<label class="font-weight-bold">Localidad/Municipio: </label>';

									if ($ant_epidemiologicos['localidad_contacto_covid'] == "") {
										$content .= 
										'
										 <label class="font-weight-bold">.................</label>
										';
 
									} else {
 
											$content .= $ant_epidemiologicos['localidad_contacto_covid'];
 
									}
									$content .=
								'
					    		</td>
					    	</tr>

					    </table>

					  </div>

					  <div class="datos_clinicos">					      
					    <div class="bg-dark py-1 text-center text-white">
					      <span>4. DATOS CLINICOS</span>					      
					    </div>
					    <table border="0">				    	
					    	<tr>								
								<td width="70%">';
									switch ($datos_clinicos['sintoma']) {
										case "ASINTOMATICO":
											$content .=
												'<label class="font-weight-bold">ASINTOMATICO</label>
												<input type="checkbox" name="asintomatico" value=""  checked="checked" disabled="disabled">
												<label class="font-weight-bold">SINTOMATICO</label>
												<input type="checkbox"  name="sintomatico" value="">
												';
										
											break;
										
										case "SINTOMATICO":
											$content .=
												'<label class="font-weight-bold">ASINTOMATICO</label>
												<input type="checkbox" name="asintomatico" value="">
												<label class="font-weight-bold">SINTOMATICO</label>
												<input type="checkbox" name="sintomatico" value="" checked="checked" disabled="disabled">
												';
											break;
										
										default: 
											$content .=
											'<label class="font-weight-bold">ASINTOMATICO</label>
											<input type="checkbox" name="asintomatico" value="">
											<label class="font-weight-bold">SINTOMATICO</label>
											<input type="checkbox" name="sintomatico" value="">
											';
											break;
										}																			
									$content.= '
									</td>
					    		<td width="30%">';
									$aux = date("d/m/Y", strtotime($datos_clinicos['fecha_inicio_sintomas']));
									if($datos_clinicos['fecha_inicio_sintomas']==""){
										$content .=
					    				'<label class="font-weight-bold">Fecha de inicio de síntomas:  __/__/____</label>';
									}
									else{
										if($aux=="30/11/-0001"){
											$content .=
												'<label class="font-weight-bold">Fecha de inicio de síntomas:  __/__/____</label>';
										}else{
											$content .= '<label class="font-weight-bold">Fecha de inicio de síntomas:'.$aux.'</label>';
										}										
									}
									$content .=
					    		'</td>
					    	</tr>
						</table>
						<table border="0">
					    	<tr>
								<td width="10%">';
									if($malestar['tos_seca']=="TOS SECA"){
										$content .=
											'<label class="font-weight-bold">TOS SECA</label>
											<input type="checkbox" name="tos_seca" value="" checked="checked">
											';
									}
									else{
										$content .= 
											'<label class="font-weight-bold">TOS SECA</label>
											<input type="checkbox" name="tos_seca" value="">
											';
									}
									$content .=
								'</td>
								<td width="10%">';
									if($malestar['fiebre']=="FIEBRE"){
										$content .=
											'<label class="font-weight-bold">FIEBRE</label>
											<input type="checkbox" name="fiebre" value="" checked="checked">
											';
									}else{
										$content .=
											'<label class="font-weight-bold">FIEBRE</label>
											<input type="checkbox" name="fiebre" value="">
											';
									}
									$content .=
								'</td>
								<td width="20%">';
									if($malestar['malestar_general']=="MALESTAR GENERAL"){
										$content .=
										'<label class="font-weight-bold">MALESTAR GENERAL</label>
										<input type="checkbox" name="malestar_general" value="" checked="checked">
										';
									}else{
										$content .=
										'<label class="font-weight-bold">MALESTAR GENERAL</label>
										<input type="checkbox" name="malestar_general" value="">
										';
									}
									$content .=
								'</td>
								<td width="10%">';
									if($malestar['cefalea']=="CEFALEA"){
										$content .=
											'<label class="font-weight-bold">CEFALEA</label>
											<input type="checkbox" name="cefalea" value="" checked="checked">
											';
									}
									else{
										$content .=
											'<label class="font-weight-bold">CEFALEA</label>
											<input type="checkbox" name="cefalea" value="">
											';
									}
									$content .=
								'</td>
								<td width="20%">';
									if($malestar['dificultad_respiratoria']=="DIFICULTAD RESPIRATORIA"){
										$content .=
											'<label class="font-weight-bold">DIFICULTAD RESPIRATORIA</label>
											<input type="checkbox" name="dificultad_respiratoria" value="" checked="checked">
											';
									}
									else{
										$content .=
											'<label class="font-weight-bold">DIFICULTAD RESPIRATORIA</label>
											<input type="checkbox" name="dificultad_respiratoria" value="">
											';
									
									}
									$content .=
								'</td>
								<td width="10%">';
									if($malestar['mialgias']=="MIALGIAS"){
										$content .=
											'<label class="font-weight-bold">MIALGIAS</label>
											<input type="checkbox" name="mialgias" value="" checked="checked">
											';
									}
									else{
										$content .= 
										'<label class="font-weight-bold">MIALGIAS</label>
										<input type="checkbox" name="mialgias" value="">
										';
									
									}
									$content .=
								'</td>
								<td width="20%">';
									if($malestar['dolor_garganta']=="DOLOR DE GARGANTA"){
										$content .=
										'<label class="font-weight-bold">DOLOR DE GARGANTA</label>
										<input type="checkbox" name="dolor_garganta" value="" checked="checked">
										';
									}
									else{
										$content .=
										'<label class="font-weight-bold">DOLOR DE GARGANTA</label>
										<input type="checkbox" name="dolor_garganta" value="">
										';
									}
									$content .=
								'</td>

							</tr>
							<tr>
								<td colspan="3">';
									if($malestar['perdida_olfato']=="PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO"){
										$content .=
											'<label class="font-weight-bold">PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO</label>
											<input type="checkbox" name="perdida_olfato" value="" checked="checked">
											';

									}
									else{
										$content .=
											'<label class="font-weight-bold">PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO</label>
											<input type="checkbox" name="perdida_olfato" value="">											
											';
									}
									$content .=																																	
								'</td>
								<td colspan="4">
									<label class="font-weight-bold">OTROS: '.$malestar['otros'].'</label>																					
								</td>
							</tr>
						</table>
					    <table border="0">
					    	<tr>
								<td>
									<label class="font-weight-bold">Estado actual del paciente (al momento de la notificacion):     </label>';
										switch ($datos_clinicos['estado_paciente']) {
											case "LEVE":
												$content .=
													'<label class="font-weight-bold">Leve</label>
													<input type="checkbox"  name="leve" value=""  checked="checked" disabled="disabled">
													<label class="font-weight-bold">Grave</label>
													<input type="checkbox" name="grave" value="">
													<label class="font-weight-bold">Fallecido</label>
													<input type="checkbox" name="fallecido" value="">
													<label class="font-weight-bold">Fecha de defuncion:         __/__/__ </label>
													';
												break;
											
											case "GRAVE":
												$content .=										
													'<label class="font-weight-bold">Leve</label>
													<input type="checkbox"  name="leve" value="">
													<label class="font-weight-bold">Grave</label>
													<input type="checkbox" name="grave" value="" checked="checked" disabled="disabled">
													<label class="font-weight-bold">Fallecido</label>
													<input type="checkbox" name="fallecido" value="">
													<label class="font-weight-bold">Fecha de defuncion:         __/__/__ </label>
													';
												break;
											
											case "FALLECIDO": 
												$content .=										
													'<label class="font-weight-bold">Leve</label>
													<input type="checkbox"  name="leve" value="0">
													<label class="font-weight-bold">Grave</label>
													<input type="checkbox" name="grave" value="0">
													<label class="font-weight-bold">Fallecido</label>
													<input type="checkbox" name="fallecido" value="" checked="checked" disabled="disabled">
													<label class="font-weight-bold">Fecha de defuncion:           '.date("d/m/Y", strtotime($datos_clinicos['fecha_defuncion'])).'</label>
													';
												break;
											}
										$content.=
								'</td>								
					    	</tr>
							<tr>
								<td>
									<label class="font-weight-bold">Diagnostico clínico:  </label>';
									switch ($datos_clinicos['diagnostico_clinico']) {
										case "GRIPAL/IRA/BRONQUITIS":
											$content .=
												'<label class="font-weight-bold">Sindrome GRIPAL/IRA/BRONQUITIS</label>
												<input type="checkbox"  name="gripal" value="" checked="checked" disabled="disabled">
												<label class="font-weight-bold">IRAG/NEUMONIA</label>
												<input type="checkbox" name="neumonia" value="" >
												<label class="font-weight-bold">Otros especificar: </label>
												<input type="checkbox" name="otros" value="">												
												';
										
											break;										
										case "IRAG/NEUMONIA":
											$content .=
												'<label class="font-weight-bold">Sindrome GRIPAL/IRA/BRONQUITIS</label>
												<input type="checkbox"  name="gripal" value="" >
												<label class="font-weight-bold">IRAG/NEUMONIA</label>
												<input type="checkbox" name="neumonia" value="" checked="checked" disabled="disabled">
												<label class="font-weight-bold">Otros especificar: </label>
												<input type="checkbox" name="otros" value="">												
												';
											break;										
										default: 
											$content .=
												'<label class="font-weight-bold">Sindrome GRIPAL/IRA/BRONQUITIS</label>
												<input type="checkbox"  name="gripal" value="">
												<label class="font-weight-bold">IRAG/NEUMONIA</label>
												<input type="checkbox" name="neumonia" value="" >
												<label class="font-weight-bold">Otros especificar: </label>';
												if($datos_clinicos['diagnostico_clinico']!=""){
													$content .=
														'<input type="checkbox" name="otros" value="" checked="checked" disabled="disabled">
														<label class="font-weight-bold">'.$datos_clinicos['diagnostico_clinico'].'</label>
													';
												}													
											break;
										}								
								$content .=
								'</td>
							</tr>
						</table>

					  </div>
					 
					  <div class="hospitalizacion_aislamiento">
					      
					    <div class="bg-dark py-1 text-center text-white">

					      <span>5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO</span>
					      
					    </div>

						<table>
					    	
							<tr>
								<td width="200px">';

									switch ($hospitalizaciones_aislamientos['metodo_hospitalizacion']) {

										case "AMBULATORIO":
											$content .=
												'<label class="font-weight-bold">AMBULATORIO</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="ambulatorio" value="0"  checked="checked" disabled="disabled">
												<label class="font-weight-bold">INTERNADO</label>
												<input type="checkbox" class="checkboxpdf" name="internado" value="0">
												';
								
											break;

										case "INTERNADO":
											$content .=
												'<label class="font-weight-bold">AMBULATORIO</label>
												<input type="checkbox" class="checkboxpdf" name="ambulatorio" value="0">
												<label class="font-weight-bold">INTERNADO</label>
												<input type="checkbox" class="checkboxpdf labelpdf" name="internado" value="0" checked="checked" disabled="disabled">
												';
											break;

										default: 
											$content .=
											'<label class="font-weight-bold">AMBULATORIO</label>
											<input type="checkbox" class="checkboxpdf" name="ambulatorio" value="0">
											<label class="font-weight-bold">INTERNADO</label>
											<input type="checkbox" class="checkboxpdf" name="internado" value="0">
											';
											break;
									}

									$content .=  
								'</td>
								<td width="300px">
									<label class="font-weight-bold">Lugar de Aislamiento: </label>';

									if ($hospitalizaciones_aislamientos['lugar_aislamiento'] == "") {
										$content .= 
										'
										 <label class="font-weight-bold">.................................</label>
										';

									} else {

											$content .= $hospitalizaciones_aislamientos['lugar_aislamiento'];
										

									}
									$content .=
								'
								</td>
								<td width="200px">';

								if ($hospitalizaciones_aislamientos['fecha_aislamiento'] == "0000-00-00") {
									$content .= 
									'<label class="font-weight-bold">Fecha de Aislamiento:</label>
									 <label class="font-weight-bold"> __/__/____</label>
									
									';

								} else {

										$content .= 
									'<label class="font-weight-bold">Fecha de Aislamiento:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['fecha_aislamiento']));					    			
								}

									$content .=  
								'</td>
							</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">';

					    		if ($hospitalizaciones_aislamientos['fecha_internacion'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">Fecha de Internación:</label>
									 <label class="font-weight-bold"> __/__/____</label>
									';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">Fecha de Internación:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['fecha_internacion']));	

					    		}

									$content .=  
					    		'</td>
					    		<td width="400px">
					    			<label class="font-weight-bold">Establecimiento de salud de Internación:</label> '.$hospitalizaciones_aislamientos['establecimiento_internacion'].'   			
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">
					    			<label class="font-weight-bold">Ventilación mecánica:</label>'; 

									switch ($hospitalizaciones_aislamientos['ventilacion_mecanica']) {

										case "SI":
											$content .=
												'
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  class="checkboxpdf" name="mecanicano" disabled="disabled">												
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="mecanicasi" checked="checked" disabled="disabled">
												';
										
											break;
										
										case "NO":
											$content .=
												'
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="mecanicano" checked="checked" disabled="disabled">												
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  class="checkboxpdf" name="mecanicasi" disabled="disabled">
												';
											break;
										
										default: 
											$content .=
											'
											<label class="font-weight-bold">NO</label>
											<input type="checkbox"  class="checkboxpdf" name="mecanicano" disabled="disabled">											
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="mecanicasi" disabled="disabled">
										
											';
											break;
										}
										$content .= 

					    		'</td>
								
					    		<td width="200px">
					    			<label class="font-weight-bold">Terapia intensiva:</label>'; 

									switch ($hospitalizaciones_aislamientos['terapia_intensiva']) {

										case "SI":
											$content .=
												'
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  class="checkboxpdf" name="aislano" disabled="disabled">												
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="aislasi" checked="checked" disabled="disabled">
												';
										
											break;
										
										case "NO":
											$content .=
												'
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  class="checkboxpdf labelpdf" name="aislano" checked="checked" disabled="disabled">
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  class="checkboxpdf" name="aislasi" disabled="disabled">
												';
											break;
										
										default: 
											$content .=
											'
											<label class="font-weight-bold">NO</label>
											<input type="checkbox"  class="checkboxpdf" name="aislano" disabled="disabled">											
											<label class="font-weight-bold">SI</label>
											<input type="checkbox"  class="checkboxpdf" name="aislasi" disabled="disabled">									
											';
											break;
										}
										$content .= 

					    		' 
					    		</td>

					    		<td width="200px">';

					    		if ($hospitalizaciones_aislamientos['fecha_ingreso_UTI'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">Fecha Ingreso UTI:</label>
									<label class="font-weight-bold"> __/__/____</label>
									';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">Fecha Ingreso UTI:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['fecha_ingreso_UTI']));	

					    		}

									$content .=  
					    		'</td>
					    	</tr>

					    </table>

					  </div>

					  <div class="enfermedades_base">					      
					    <div class="bg-dark py-1 text-center text-white">
					      <span>6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO</span>					      
					    </div>

					    <table border="0">					    	
					    	<tr>
					    		<td>';
									switch ($enfermedades_bases['enf_estado']) {
										case "PRESENTA":
											$content .=
												'<label class="font-weight-bold">PRESENTA</label>
												<input type="checkbox"  name="presenta" value="0"  checked="checked" disabled="disabled">
												<label class="font-weight-bold">NO PRESENTA</label>
												<input type="checkbox" name="nopresenta" value="0">
												';
										
											break;
										
										case "NO PRESENTA":
											$content .=
												'<label class="font-weight-bold">PRESENTA</label>
												<input type="checkbox" name="presenta" value="0">
												<label class="font-weight-bold">NO PRESENTA</label>
												<input type="checkbox" name="nopresenta" value="0" checked="checked" disabled="disabled">
												';
											break;
										
										default: 
											$content .=
											'<label class="font-weight-bold">PRESENTA</label>
											<input type="checkbox" name="presenta" value="0">
											<label class="font-weight-bold">NO PRESENTA</label>
											<input type="checkbox" name="nopresenta" value="0">
											';
											break;
										}																			
									$content.= '					    			
					    		</td>
					    	</tr>
					    	<tr>						
					    		<td>';									
									if($enfermedades_bases['hipertension_arterial']=="HIPERTENSIÓN ARTERIAL"){
										$content .=
											'<label class="font-weight-bold">HIPERTENSIÓN ARTERIAL</label>
											<input type="checkbox" name="hipertension_arterial" value="" checked="checked">
											';
									}
									else{
										$content .= 
											'<label class="font-weight-bold">HIPERTENSIÓN ARTERIAL</label>
											<input type="checkbox" name="hipertension_arterial" value="">
											';
									}
									if($enfermedades_bases['obesidad']=="OBESIDAD"){
										$content .=
											'<label class="font-weight-bold">OBESIDAD</label>
											<input type="checkbox" name="obesidad" value="" checked="checked">
											';
									}else{
										$content .=
											'<label class="font-weight-bold">OBESIDAD</label>
											<input type="checkbox" name="obesidad" value="">
											';
									}
									if($enfermedades_bases['diabetes_general']=="DIABETES GENERAL"){
										$content .=
										'<label class="font-weight-bold">DIABETES GENERAL</label>
										<input type="checkbox" name="diabetes_general" value="" checked="checked">
										';
									}else{
										$content .=
										'<label class="font-weight-bold">DIABETES GENERAL</label>
										<input type="checkbox" name="diabetes_general" value="">
										';
									}
									if($enfermedades_bases['embarazo']=="EMBARAZO"){
										$content .=
											'<label class="font-weight-bold">EMBARAZO</label>
											<input type="checkbox" name="embarazo" value="" checked="checked">
											';
									}
									else{
										$content .=
											'<label class="font-weight-bold">EMBARAZO</label>
											<input type="checkbox" name="embarazo" value="">
											';
									}
									if($enfermedades_bases['enfermedades_oncologica']=="ENFERMEDADES ONCOLOGICA"){
										$content .=
											'<label class="font-weight-bold">ENFERMEDADES ONCOLOGICA</label>
											<input type="checkbox" name="enfermedades_oncologica" value="" checked="checked">
											';
									}
									else{
										$content .=
											'<label class="font-weight-bold">ENFERMEDADES ONCOLOGICA</label>
											<input type="checkbox" name="enfermedades_oncologica" value="">
											';

									}
									if($enfermedades_bases['enfermedades_cardiaca']=="ENFERMEDADES CARDIACA"){
										$content .=
											'<label class="font-weight-bold">ENFERMEDADES CARDIACA</label>
											<input type="checkbox" name="enfermedades_cardiaca" value="" checked="checked">
											';
									}
									else{
										$content .= 
										'<label class="font-weight-bold">ENFERMEDADES CARDIACA</label>
										<input type="checkbox" name="enfermedades_cardiaca" value="">
										';

									}
									if($enfermedades_bases['enfermedad_respiratoria']=="ENFERMEDAD RESPIRATORIA"){
										$content .=
										'<label class="font-weight-bold">ENFERMEDAD RESPIRATORIA</label>
										<input type="checkbox" name="enfermedad_respiratoria" value="" checked="checked">
										';
									}
									else{
										$content .=
										'<label class="font-weight-bold">ENFERMEDAD RESPIRATORIA</label>
										<input type="checkbox" name="enfermedad_respiratoria" value="">
										';
									}
									if($enfermedades_bases['enfermedades_renal_cronica']=="ENFERMEDADES RENAL CRÓNICA"){
										$content .=
										'<label class="font-weight-bold">ENFERMEDADES RENAL CRÓNICA</label>
										<input type="checkbox" name="enfermedades_renal_cronica" value="" checked="checked">
										';
									}
									else{
										$content .=
										'<label class="font-weight-bold">ENFERMEDADES RENAL CRÓNICA</label>
										<input type="checkbox" name="enfermedades_renal_cronica" value="">
										';
									}
									$content .=
									'<label class="font-weight-bold">OTROS : '.$enfermedades_bases['otros'].'</label>									
								</td>
					    	</tr>
					    </table>

					  </div>

					  <div class="personas_contactos">
					      
					    <div class="bg-dark">

					      <span>7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO (desde el inicio de los sintomas)</span>
					      
					    </div>

					    <table border="1">					    	
					    		<tr class="font-weight-bold">
									<th width="25%">Nombre y Apellidos</th>
									<th width="10%">Relación</th>
									<th width="6%">Edad</th>
									<th width="8%">Teléfono</th>
									<th width="21%">Dirección</th>
									<th width="14%">Fecha de Contacto</th>
									<th width="16%">Lugar de Contacto</th>
								</tr>				          
				        	';
									/*=============================================
									DATOS SECCION 7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO
									=============================================*/
								$item = "id_ficha";
								$valor = $this->idFicha;
								$personas_contactos = ControladorPersonasContactos::ctrMostrarPersonasContactos($item, $valor);	;								
								foreach ($personas_contactos as $value) {
									$content .= 
									'<tr>
										<td>'.$value["paterno_contacto"].' '.$value["materno_contacto"].'  '.$value["nombre_contacto"].'</td>
										<td>'.$value["relacion_contacto"].'</td>
										<td>'.$value["edad_contacto"].'</td>
										<td>'.$value["telefono_contacto"].'</td>
										<td>'.$value["direccion_contacto"].'</td>
										<td>'.date("d/m/Y", strtotime($value["fecha_contacto"])).'</td>
										<td>'.$value["lugar_contacto"].'</td>
									</tr>
									';
								}
								$content .= 							
					    '</table>

					  </div>

					  <div class="laboratorios">
					      
					    <div class="bg-dark py-1 text-center text-white">
					      <span>8. LABORATORIOS</span>					      
					    </div>

						<div class="primeraparte">
							<table>
								
								<tr>
									<td width="140px">
										<label class="font-weight-bold">Se tomó muestra para Laboratorio: </label>
									</td>
									'; 

									switch ($laboratorios['estado_muestra']) {

										case "SI":
											$content .=
												'
												<td width="30px">
													<label class="font-weight-bold">NO</label>
													<input type="checkbox"  name ="tomosi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="30px">
													<label class="font-weight-bold">SI</label>
													<input type="checkbox"  name ="tomono" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												';
										
											break;
											
										case "NO":
											$content .=
												'
												<td width="30px">
													<label class="font-weight-bold">NO</label>
													<input type="checkbox"  name ="tomosi" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="30px">
													<label class="font-weight-bold">SI</label>
													<input type="checkbox"  name ="tomono" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;

										default: 
											$content .=
											'
											<td width="30px">
												<label class="font-weight-bold">NO</label>
												<input type="checkbox"  name ="tomosi" class="checkboxpdf" disabled="disabled">
											</td>
											<td width="30px">
												<label class="font-weight-bold">SI</label>
												<input type="checkbox"  name ="tomono" class="checkboxpdf" disabled="disabled">
											</td>
										
											';
											break;
										}
										$content .= 

									'
									<td width="140px">
										<label class="font-weight-bold">¿Por qué NO se tomo la muestra?: </label>
								    </td>
									'; 

									switch ($laboratorios['des_no_muestra']) {

										case "RECHAZO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">RECHAZO</label>
													<input type="checkbox"  name ="rechazo" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">FALTA DE INSUMOS /EPP</label>
													<input type="checkbox"  name ="faltainsumo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">FALLECIDO</label>
													<input type="checkbox"  name ="fallecido" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrodesno" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;
											
										case "FALTA DE INSUMOS /EPP":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">RECHAZO</label>
													<input type="checkbox"  name ="rechazo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">FALTA DE INSUMOS /EPP</label>
													<input type="checkbox"  name ="faltainsumo" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">FALLECIDO</label>
													<input type="checkbox"  name ="fallecido" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrodesno" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;

										case "FALLECIDO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">RECHAZO</label>
													<input type="checkbox"  name ="rechazo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">FALTA DE INSUMOS /EPP</label>
													<input type="checkbox"  name ="faltainsumo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">FALLECIDO</label>
													<input type="checkbox"  name ="fallecido" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrodesno" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;

										case "OTRO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">RECHAZO</label>
													<input type="checkbox"  name ="rechazo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">FALTA DE INSUMOS /EPP</label>
													<input type="checkbox"  name ="faltainsumo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">FALLECIDO</label>
													<input type="checkbox"  name ="fallecido" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrodesno" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												';
										
											break;				

										default: 
											$content .=
											'
											<td width="60px">
													<label class="font-weight-bold">RECHAZO</label>
													<input type="checkbox"  name ="rechazo" class="checkboxpdf" disabled="disabled">
											</td>
											<td width="130px">
												<label class="font-weight-bold">FALTA DE INSUMOS /EPP</label>
												<input type="checkbox"  name ="faltainsumo" class="checkboxpdf" disabled="disabled">
											</td>
											<td width="60px">
												<label class="font-weight-bold">FALLECIDO</label>
												<input type="checkbox"  name ="fallecido" class="checkboxpdf" disabled="disabled">
											</td>
											<td width="60px">
												<label class="font-weight-bold">OTRO</label>
												<input type="checkbox"  name ="otrodesno" class="checkboxpdf" disabled="disabled">
											</td>
										
											';
											break;
										}
										$content .= 

									'
								</tr>

							</table>

							<table>
								<tr>
									<td width="80px">
										<label class="font-weight-bold">Tipo de Muestra: </label>
									</td>

									'; 

									switch ($laboratorios['tipo_muestra']) {
									
										case "ASPIRADO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;
											
										case "ESPUTO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;
									
										case "LAVADO BRONCO ALVELAR":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;
									
										case "HISOPADO NASOFARINGEO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;
									
										case "HISOPADO COMBINADO":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf"  disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf" disabled="disabled">
												</td>
												';
										
											break;
									
										case "OTRA":
											$content .=
												'
												<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
												</td>
												';
										
											break;								
									
										default: 
											$content .=
											'
											<td width="60px">
													<label class="font-weight-bold">ASPIRADO</label>
													<input type="checkbox"  name ="aspirado" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">ESPUTO</label>
													<input type="checkbox"  name ="esputo" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">LAVADO BRONCO ALVELAR</label>
													<input type="checkbox"  name ="lavadoalvear" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="130px">
													<label class="font-weight-bold">HISOPADO NASOFARINGEO</label>
													<input type="checkbox"  name ="hisonaso" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="100px">
													<label class="font-weight-bold">HISOPADO COMBINADO</label>
													<input type="checkbox"  name ="hisocombi" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="60px">
													<label class="font-weight-bold">OTRO</label>
													<input type="checkbox"  name ="otrotipomu" class="checkboxpdf" disabled="disabled">
												</td>
										
											';
											break;
										}
										$content .= 
									
									'										

								</tr>
							</table>

							<table>

								<tr>
									<td width="250px">
										<label class="font-weight-bold">Nombre de Lab. que procesara la muestra:</label> '.$laboratorios['nombre_laboratorio'].'
									</td>
									<td width="150px">';

									if ($laboratorios['fecha_muestra'] == "0000-00-00") {
										$content .= 
										'<label class="font-weight-bold">Fecha de toma de muestra:</label>
										 <label class="font-weight-bold">...../...../.....</label>
										';

									} else {

											$content .= 
										'<label class="font-weight-bold">Fecha de toma de muestra:</label> '.date("d/m/Y", strtotime($laboratorios['fecha_muestra']));	

									}

										$content .=  
									'</td>
									<td width="150px">';

									if ($laboratorios['fecha_envio'] == "0000-00-00") {
										$content .= 
										'<label class="font-weight-bold">Fecha de Envío:</label>
										 <label class="font-weight-bold">...../...../.....</label>
										';

									} else {

											$content .= 
										'<label class="font-weight-bold">Fecha de Envío:</label> '.date("d/m/Y", strtotime($laboratorios['fecha_envio']));	

									}

										$content .=  
									'</td>
								</tr>

							</table>

							<table>
								<tr>
									<td colspan="2" width="700px">
										<label class="my-0 font-weight-bold">Observaciones:</label> '.$laboratorios['observaciones_muestra'].'
									</td>
								</tr>
							</table>
						</div>
						
						<div class="segundaparte">
							<div class="bg-dark1 py-1 text-center text-white">
								<span>RESULTADO</span>
							</div>

							<table>
								<tr>
									<td width="200px">
										<label class="font-weight-bold">Método de Diagnostico: </label> 
									</td>
									';

									if($laboratorios['metodo_diagnostico_pcr_tiempo_real']){
										$content .=
										'
										<td>
											<label class="font-weight-bold">RT-PCR en tiempo Real</label>
											<input type="checkbox"  name ="mdpcreal" class="checkboxpdf labelpdf" checked = "checked" disabled="disabled">
										</td>

										';

									}
									else{
										$content .=
										'
										<td>
											<label class="font-weight-bold">RT-PCR en tiempo Real</label>
											<input type="checkbox"  name ="mdpcreal" class="checkboxpdf" disabled="disabled">
										</td>

										';

									}

									if($laboratorios['metodo_diagnostico_pcr_genexpert']){
										$content .=
										'
										<td>
											<label class="font-weight-bold">RT-PCR GENEXPERT</label>
											<input type="checkbox"  name ="mdpexpert" class="checkboxpdf labelpdf" checked = "checked" disabled="disabled">
										</td>

										';

									}
									else{
										$content .=
										'
										<td>
											<label class="font-weight-bold">RT-PCR GENEXPERT</label>
											<input type="checkbox"  name ="mdpexpert" class="checkboxpdf" disabled="disabled">
										</td>

										';
										
									}

									if($laboratorios['metodo_diagnostico_prueba_antigenica']){
										$content .=
										'
										<td>
											<label class="font-weight-bold">Prueba Antigénica</label>
											<input type="checkbox"  name ="mdpantigena" class="checkboxpdf labelpdf" checked = "checked" disabled="disabled">
										</td>

										';
									}
									else{
										$content .=
										'
										<td>
											<label class="font-weight-bold">Prueba Antigénica</label>
											<input type="checkbox"  name ="mdpantigena" class="checkboxpdf"  disabled="disabled">
										</td>

										';
										
									}

									$content .=

								'
								</tr>
						   </table> 
						   <table>
								<tr>
									<td width="200px">
										<label class="font-weight-bold">Resultado de Laboratorio: </label>
									</td>';
										switch ($covidResultados['resultado']) {

											case "POSITIVO":
												$content .=
													'
													<td width="100px">
														<label class="font-weight-bold">POSITIVO</label>
														<input type="checkbox"  name ="pos" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
													</td>
													<td width="100px">
														<label class="font-weight-bold">NEGATIVO</label>
														<input type="checkbox"  name ="neg" class="checkboxpdf" disabled="disabled">
													</td>
													';
											
												break;
												
											case "NEGATIVO":
												$content .=
													'
													<td width="100px">
														<label class="font-weight-bold">POSITIVO</label>
														<input type="checkbox"  name ="pos" class="checkboxpdf" disabled="disabled">
													</td>
													<td width="100px">
														<label class="font-weight-bold">NEGATIVO</label>
														<input type="checkbox"  name ="neg" class="checkboxpdf labelpdf" checked="checked" disabled="disabled">
													</td>
													';
											
												break;

											default: 
												$content .=
												'
												<td width="150px">
													<label class="font-weight-bold">POSITIVO</label>
													<input type="checkbox"  name ="pos" class="checkboxpdf" disabled="disabled">
												</td>
												<td width="150px">
													<label class="font-weight-bold">NEGATIVO</label>
													<input type="checkbox"  name ="neg" class="checkboxpdf labelpdf" disabled="disabled">
												</td>
											
												';
												break;
											}
											$content .=
									'</tr>
					  	   </table>
						</div>	
					  </div>

					  <div class="personalnotifica">

						<div class="bg-dark py-1 text-center text-white">
							<span style="line-height: 5px;">9. DATOS DEL PERSONAL QUE NOTIFICA</span>
						</div>

					  
						<table>
							<tr>
								<td width="70%" height="20">
									<label class="font-weight-bold">Nombre y Apellido:</label> '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].' '.$persona_notificador['nombre_notificador'].'
								</td>
								<td width="30%">
									<label class="font-weight-bold">Tel. cel.:</label> '.$persona_notificador['telefono_notificador'].'
								</td>
							</tr>

						</table>

						<table border="0">
							<tr>
								<td width="35%">
								</td>
								<td width="35%">
								</td>
								<td  rowspan="6" width="30%">
								<span class="mensaje font-weight-bold" style="text-align:justify;">Este formulario tiene el carácter de declaración jurada que realiza el equipo de salud, contiene información sujeta a vigilancia epidemiológica, por esta razón debe ser llenada correctamente en las secciones necesarias y enviadas oprotunamente</span>
								</td>
							</tr>
							<tr>
								<td>
								</td>
								<td>
								</td>
							</tr>
							<tr>
								<td>
								</td>
								<td>
								</td>						
							</tr>
							<tr>
								<td>
								</td>
								<td>
								</td>						
							</tr>
							<tr>
								<td>
								</td>
								<td>
								</td>						
							</tr>
							<tr>
								<td>
									<label class="mensaje font-weight-bold" style="vertical-align:middle;">Firma y Sello</label>
								</td>
								<td>
									<label class="mensaje font-weight-bold" style="vertical-align:middle;">Sello del EESS</label>
								</td>
							</tr>							
							
						</table>

					  </div>

					</div>
					
				</body>

			</html>';
			
		// Reconociendo la estructura HTML
		$pdf->writeHTML($content, false, 0, false, false,"L");

		//$pacienteAsegurado['cod_afiliado']    
		$direc ="../temp/".$pacienteAsegurado['cod_afiliado']."/";
		if (!file_exists($direc)){
			mkdir($direc);
		}
		$pdf->output($direc.'ficha-epidemiologica-'.$valor.'.pdf', 'F');

		$data = array();
		$data['code'] = $pacienteAsegurado['cod_afiliado'];

		echo json_encode($data);

	}

	/*=============================================
	MOSTRAR EN PDF FICHA CONTROL Y SEGUIMIENTO
	=============================================*/

	public function ajaxMostrarFichaControlPDF()	{

		/*=============================================
	    DATOS SECCION 1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR
	    =============================================*/
			
		$item = "id_ficha";
		$valor = $this->idFicha;

		$ficha = ControladorFichas::ctrMostrarDatosFicha($item, $valor);

	    //TRAEMOS LOS DATOS DE DEPARTAMENTO

	    $item = "id";
	    $valor = $ficha["id_departamento"];
	    $departamento = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

	    //TRAEMOS LOS DATOS DE ESTABLECIMIENTO

	    $valor = $ficha["id_establecimiento"];
	    $establecimiento = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

	    //TRAEMOS LOS CONSULTORIOS

	    $valor = $ficha["id_consultorio"];
	    $consultorio = ControladorConsultorios::ctrMostrarConsultorios($item, $valor);

	    //TRAEMOS LOS DATOS DE LOCALIDAD

	    $valor = $ficha["id_localidad"];
		$localidad = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);
   

	    /*=============================================
	    DATOS SECCION 2. IDENTIFICACION DEL CASO/PACIENTE
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $pacienteAsegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item, $valor);
			//TRAEMOS LOS DATOS DE DEPARTAMENTO
	    $item = "id";
	    $valor_depto = $pacienteAsegurado["id_departamento_paciente"];
	    $departamento_paciente = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor_depto);	    

	    //TRAEMOS LOS DATOS DE PROVINCIA

	    $valor_provincia = $pacienteAsegurado["id_provincia_paciente"];
	    $provincia_paciente = ControladorProvincia::ctrMostrarProvincia($item, $valor_provincia);

		//TRAEMOS LOS DATOS DE MUNICIPIO

		$valor_municipio = $pacienteAsegurado["id_municipio_paciente"];
		$municipio_paciente = ControladorMunicipio::ctrMostrarMunicipio($item,$valor_municipio);

	    //TRAEMOS LOS DATOS DE PAIS

	    $valor_pais = $pacienteAsegurado["id_pais_paciente"];

	    $pais_procedencia = ControladorPaises::ctrMostrarPaises($item, $valor_pais);

	    /*=============================================
	    DATOS SECCION 5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $hospitalizaciones_aislamientos = ControladorHospitalizacionesAislamientos::ctrMostrarHospitalizacionesAislamientos($item, $valor);

	    /*=============================================
	    DATOS SECCION 8. LABORATORIO
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $laboratorios = ControladorLaboratorios::ctrMostrarLaboratorios($item, $valor);

	    // TRAEMOS LOS DATOS DE ESTABLECIMIENTO PARA LABORATORIO

	    $item = "id";
	    $valor = $laboratorios["id_establecimiento"];

	    $establecimiento_lab = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

	    /*=============================================
	    DATOS SECCION PERSONAL QUE NOTIFICA
	    =============================================*/

	    $item = "id_ficha";
	    $valor = $this->idFicha;

	    $persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item, $valor);

		// Extend the TCPDF class to create custom Header and Footer

		$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CNS Cochabamba');
		$pdf->SetTitle('ficha-'.$valor);
		$pdf->SetSubject('Ficha Control y Seguimiento Covid-19 CNS');
		$pdf->SetKeywords('TCPDF, PDF, CNS, Reporte, Ficha Control Seguimiento,Covid-19');

		$pdf->setPrintHeader(false); 
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(5, 5, 5, 0);
		$pdf->SetAutoPageBreak(true, 5); 
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(5);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('Helvetica', '', 8);

		$pdf->SetPrintFooter(false);

		// add a page
		$pdf->AddPage();

		$content = '';

		  $content .= '

		  <html lang="es">
				<head>

					<style>
						
						body {
							font-size: 21px;
							margin: 0;
							padding: 0;
						}

						.content div{

							line-height: 0px;

						}

						.bg-dark {

							background-color: #444;
							color: #fff;
							text-align: center;
							line-height: 0px;
						
						}

						.bg-dark span {

							line-height: 7px;
							font-weight: bold;

						}

						.font-weight-bold {

							font-weight: bold;

						}

						.titulo {

							text-align: center;
							line-height: 3px;

						}

						.cod_ficha {

							margin-top: 0px;
							text-align: right;
							
						}

						table {

						  line-height: 6px;

						}

						.personas_contactos {

							line-height: 0px;

						}

						td {

						  margin-top: 0px;

						}

						th {

						  text-align: center;

						}

						.mensaje {

							text-align: center;
							line-height: 7px;

						}

						.laboratorios .mensaje {

							margin-top: 0px;
							text-align: center;
							line-height: 0px;

						}

					</style>

				</head>

				<body>

					<div class="content" border="1">

						<div style="line-height: 0px;">
						
							<h3 class="titulo" style="line-height: 4px;">FICHA DE CONTROL Y SEGUIMIENTO<br>SOLICITUD DE ESTUDIOS DE LABORATORIO COVID-19</h3>

							<h4 class="cod_ficha"></h4>

						</div>

						<div class="datos_establecimiento">
					      
					    <div class="bg-dark">

					      <span>1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR</span>
					      
					    </div>

					    <table>
					    	
					    	<tr>
					    		<td width="400px">
					    			<label class="font-weight-bold">Establecimiento de Salud/Centro de Aislamiento:</label> '.$establecimiento["nombre_establecimiento"].'
					    		</td>
					    		<td width="150px">
					    			<label class="font-weight-bold">Consultorio: </label> '.$consultorio["nombre_consultorio"].'
					    		</td>			    		
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">
					    			<label class="font-weight-bold">Departamento:</label> '.$departamento["nombre_depto"].'
					    		</td>
					    		<td width="200px">
					    			<label class="font-weight-bold">Municipio:</label> '."AQUI VA EL NOMBRE DEL MUNICIPIO".'
					    		</td>					    		
					    		<td width="200px">';

					    		if ($ficha["fecha_notificacion"] == "0000-00-00") {
					    			
					    			$content .=
					    			'<label class="font-weight-bold">  Fecha de Notificación:</label>';

					    		} else {

					    			$content .=
					    			'<label class="font-weight-bold">  Fecha de Notificación:</label> '.date("d/m/Y", strtotime($ficha["fecha_notificacion"]));

					    		}

					    		$content .=
					    		'</td>
					    		<td width="150px">
					    			<label class="font-weight-bold">Control:</label> '.$ficha["nro_control"].' CONTROL
					    		</td>
					    	</tr>

					    </table>

					  </div>

					  <div class="paciente">
					      
					    <div class="bg-dark py-1 text-center text-white">

					      <span>2. IDENTIFICACIÓN DEL CASO/PACIENTE</span>
					      
					    </div>

					    <table>
					    	
					    	<tr>
								<td width="250px">
									<label class="font-weight-bold">N° Carnet de Indentidad/ Cedula de extranjero/Pasaporte: </label> '.$pacienteAsegurado['nro_documento'].'
								</td>
					    		<td width="250px">
					    			<label class="font-weight-bold">Cod. Asegurado:</label> '.$pacienteAsegurado['cod_asegurado'].'
					    		</td>
					    		<td width="250px">
					    			<label class="font-weight-bold">Cod. Afiliado:</label> '.$pacienteAsegurado['cod_afiliado'].'
					    		</td>
					    		<td width="250px">
					    			<label class="font-weight-bold">Cod. Empleador:</label> '.$pacienteAsegurado['cod_empleador'].'
					    		</td>
					    	</tr>

					    </table>

					     <table>

					    	<tr>
					    		<td width="800px">

					    			<label class="font-weight-bold">Nombre Empleador:</label> '.$pacienteAsegurado['nombre_empleador'].'
					    			
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="350px">
					    			<label class="font-weight-bold">Apellido(s) y Nombre(s):</label> '.$pacienteAsegurado['paterno'].' '.$pacienteAsegurado['materno'].' '.$pacienteAsegurado['nombre'].'
					    		</td>
					    		<td width="150px">
					    			<label class="font-weight-bold">Sexo:</label> '.$pacienteAsegurado['sexo'].'
					    		</td>
					    		
					    	</tr>

					    </table>

					    <table>

					    	<tr>					    		
					    		<td width="250px">
					    			<label class="font-weight-bold">Fecha de Nacimiento:</label> '.date("d/m/Y", strtotime($pacienteAsegurado['fecha_nacimiento'])).'
					    		</td>
					    		<td width="100px">
					    			<label class="font-weight-bold">Edad:</label> '.$pacienteAsegurado['edad'].'
					    		</td>
					    		<td width="250px">
					    			<label class="font-weight-bold">Teléfono:</label> '.$pacienteAsegurado['telefono'].'
					    		</td>
					    	</tr>

					    </table>

					  </div>

					  <div class="hospitalizacion_aislamiento">
					      
					    <div class="bg-dark py-1 text-center text-white">

					      <span>3. SEGUIMIENTO</span>
					      
					    </div>

					    <table>
					    	
					    	<tr>
					    		<td width="200px">
					    			<label class="font-weight-bold">¿Han pasado 14 días desde la notificación?:</label> '.$hospitalizaciones_aislamientos['dias_notificacion'].'
					    		</td>
					    		<td width="200px">';

					    		if ($hospitalizaciones_aislamientos['dias_sin_sintomas'] == "0") {
					    			$content .= 
					    			'<label class="font-weight-bold">  N° de días SIN sintomas:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">  N° de días SIN sintomas:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['dias_sin_sintomas']));					    			
					    		}

									$content .= 
					    		'</td>
					    	</tr>

					    </table>

					    <table>
					    	
					    	<tr>
					    		<td width="200px">';

					    		if ($hospitalizaciones_aislamientos['fecha_aislamiento'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">  Fecha de Aislamiento:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">  Fecha de Aislamiento:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['fecha_aislamiento']));					    			
					    		}

									$content .=  
					    		'</td>
					    		<td width="300px">
					    			<label class="font-weight-bold">Lugar de Aislamiento: </label> '.$hospitalizaciones_aislamientos['lugar_aislamiento'].'
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">';

					    		if ($hospitalizaciones_aislamientos['fecha_internacion'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">  Fecha de Internación:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">  Fecha de Internación:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['fecha_internacion']));	

					    		}

									$content .=  
					    		'</td>
					    		<td width="400px">
					    			<label class="font-weight-bold">Establecimiento de salud de Internación:</label> '.$hospitalizaciones_aislamientos['establecimiento_internacion'].'   			
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">';

					    		if ($hospitalizaciones_aislamientos['fecha_ingreso_UTI'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">  Fecha de Ingreso a UTI:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">  Fecha de Ingreso a UTI:</label> '.date("d/m/Y", strtotime($hospitalizaciones_aislamientos['fecha_ingreso_UTI']));	

					    		}

									$content .=  
					    		'</td>
					    		<td width="400px">
					    			<label class="font-weight-bold">Lugar de UTI:</label> '.$hospitalizaciones_aislamientos['lugar_ingreso_UTI'].'   			
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="200px">
					    			<label class="font-weight-bold">Ventilación mecánica</label> '.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="650px">
					    			<label class="font-weight-bold">Tratamiento:</label> '.$hospitalizaciones_aislamientos['tratamiento'].','.$hospitalizaciones_aislamientos['tratamiento_otros'].' 
					    		</td>
					    	</tr>

					    </table>

					  </div>

					  <div class="laboratorios">
					      
					    <div class="bg-dark py-1 text-center text-white">

					      <span>4. LABORATORIOS</span>
					      
					    </div>

					    <table>
					    	
					    	<tr>
					    		<td width="250px">
					    			<label class="font-weight-bold">Tipo de muestra tomada:</label> '.$laboratorios['tipo_muestra'].'
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="450px">
					    			<label class="font-weight-bold">Nombre de Lab. que procesara la muestra:</label> '.$laboratorios['nombre_laboratorio'].'
					    		</td>
					    		<td width="150px">';

					    		if ($laboratorios['fecha_muestra'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">Fecha de toma de muestra:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">Fecha de toma de muestra:</label> '.date("d/m/Y", strtotime($laboratorios['fecha_muestra']));	

					    		}

									$content .=  
					    		'</td>
					    		<td width="150px">';

					    		if ($laboratorios['fecha_envio'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">Fecha de Envío:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">Fecha de Envío:</label> '.date("d/m/Y", strtotime($laboratorios['fecha_envio']));	

					    		}

									$content .=  
					    		'</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td width="300px">
					    			<label class="font-weight-bold" style="line-height: 18px; margin-bottom: 0px;">Responsable de Toma de Muestra:</label> '.$laboratorios['responsable_muestra'].'
					    		</td>
					    		<td width="350px">
					    			<label class="font-weight-bold" style="line-height: 18px; margin-bottom: 0px;">Firma y Sello</label>
					    		</td>
					    	</tr>

					    </table>

					    <table>

					    	<tr>
					    		<td colspan="2" width="700px">
					    			<label class="my-0 font-weight-bold">Observaciones:</label> '.$laboratorios['observaciones_muestra'].'
					    		</td>
					    	</tr>
					    	<tr>
					    		<td width="300px">
					    			<label class="my-0 font-weight-bold">Resultado:</label> '.$laboratorios['resultado_laboratorio'].'
					    		</td>
					    		<td width="250px">';

					    		if ($laboratorios['fecha_resultado'] == "0000-00-00") {
					    			$content .= 
					    			'<label class="font-weight-bold">Fecha de Resultado:</label>';

					    		} else {

										$content .= 
					    			'<label class="font-weight-bold">Fecha de Resultado:</label> '.date("d/m/Y", strtotime($laboratorios['fecha_resultado']));	

					    		}

									$content .=  
					    		'</td>
					    		<td width="150px">
					    			<h2 style="line-height: 0px;">Cod Laboratorio '.$laboratorios['cod_laboratorio'].'</h2>
					    		</td>
					    	</tr>
					    </table>

					    <hr>

					    <table>

					    	<tr>
					    		<td colspan="2" width="700px">
					    			<label class="font-weight-bold">DATOS DEL PERSONAL QUE NOTIFICA</label>
					    		</td>
					    	</tr>
					    	<tr>
					    		<td width="350px">
					    			<label class="font-weight-bold">APELLIDO(S) Y NOMBRE(S):</label> '.$persona_notificador['paterno_notificador'].' '.$persona_notificador['materno_notificador'].' '.$persona_notificador['nombre_notificador'].'
					    		</td>
					    		<td width="350px">
					    			<label class="font-weight-bold">Teléfono:</label> '.$persona_notificador['telefono_notificador'].'
					    		</td>
					    	</tr>

					    </table>

					    <table>
					    	
					    	<tr>
					    		<td width="350px">
					    			<label class="font-weight-bold" style="line-height: 18px;">Firma y Sello</label>
					    		</td>
					    		<td width="350px">
					    			<label class="font-weight-bold" style="line-height: 18px;">Sello del EESS</label>
					    		</td>
					    	</tr>

					    </table>

					    <table border="1">

					    	<tr>
					    		<td width="714px">
					    			<span class="mensaje font-weight-bold">Este formulario tiene el carácter de declaración jurada que realiza el equipo de salud, contiene información sujeta a vigilancia epidemiológica, por esta razón debe ser llenada correctamente en las secciones necesarias y enviadas oprotunamente</span>
					    		</td>
					    	</tr>

					    </table>

					  </div>

					</div>
					
				</body>

			</html>';
			
		// Reconociendo la estructura HTML
		$pdf->writeHTML($content, true, 0, true, true);

		// Insertando el Logo
		$image_file = K_PATH_IMAGES.'cns-logo-simple.png';

		$pdf->Image($image_file, 13, 9, 13, '', 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);

		// Estilos necesarios para el Codigo QR
		$style = array(
		    'border' => 0,
		    'vpadding' => 'auto',
		    'hpadding' => 'auto',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255)
		    'module_width' => 1, // width of a single module in points
		    'module_height' => 1 // height of a single module in points
		);

		//	Datos a mostrar en el código QR
		$codeContents = 'COD. FICHA: '.$this->idFicha."\n";

		// insertando el código QR
		$pdf->write2DBarcode($codeContents, 'QRCODE,L', 190, 8 + $n, 15, 15, $style, 'N');	

		$pdf->lastPage();

		$pdf->output('../temp/ficha-'.$valor.'.pdf', 'F');
	}
}

class AjaxFichasLaboratorio{
	public $id_ficha;
	public $item;
	public $valor;	
	public function ajaxActualizarCampoTransferenciaHospitalLaboratorio(){
		$respuesta= ControladorLaboratorios::ctrActualizarCamposLaboratorio($this->item,$this->valor,$this->id_ficha);
		return $respuesta;
	}
}
/*=============================================
CREAR UNA NUEVA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["crearFichaEpidemiologica"])) {

	$crearFicha = new AjaxFichas();
	$crearFicha -> paterno_notificador = $_POST["paterno_notificador"];
	$crearFicha -> materno_notificador = $_POST["materno_notificador"];
	$crearFicha -> nombre_notificador = $_POST["nombre_notificador"];
	$crearFicha -> cargo_notificador = $_POST["cargo_notificador"];
	$crearFicha -> ajaxCrearFichaEpidemiologica($_POST);

}

/*=============================================
CREAR UNA NUEVA FICHA DE CONTROL Y SEGUIMIENTO
=============================================*/

if (isset($_POST["crearFichaControl"])) {

	$crearFicha = new AjaxFichas();
	$crearFicha -> paterno_notificador = $_POST["paterno_notificador"];
	$crearFicha -> materno_notificador = $_POST["materno_notificador"];
	$crearFicha -> nombre_notificador = $_POST["nombre_notificador"];
	$crearFicha -> cargo_notificador = $_POST["cargo_notificador"];
	$crearFicha -> ajaxCrearFichaControl();

}

/*=============================================
GUARDAR NUEVA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["guardarFichaEpidemiologica"])) {

	//print_r($_POST);
	$guardarFichaEpidemiologica = new AjaxFichas();
	// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
     
	$guardarFichaEpidemiologica -> id_ficha = $_POST["id_ficha"];
	$guardarFichaEpidemiologica -> fecha_notificacion = $_POST["nuevoFechaNotificacion"];
	$guardarFichaEpidemiologica -> semana_epidemiologica = $_POST["nuevoSemEpidemiologica"];
	//$guardarFichaEpidemiologica -> busqueda_activa = $_POST["nuevoBusquedaActiva"]; 

	$guardarFichaEpidemiologica -> id_establecimiento = $_POST["nuevoEstablecimiento"];
	$guardarFichaEpidemiologica -> cod_establecimiento = $_POST["nuevoCodEstablecimiento"];
	$guardarFichaEpidemiologica -> id_consultorio = $_POST["nuevoConsultorio"];
	$guardarFichaEpidemiologica -> red_salud = $_POST["nuevoRedSalud"];
	$guardarFichaEpidemiologica -> id_departamento = $_POST["nuevoDepartamento"];

	$guardarFichaEpidemiologica -> sub_sector = $_POST["subsector"];
	$guardarFichaEpidemiologica -> id_municipio = $_POST["municipio"];


	// 2. IDENTIFICACIÓN DEL CASO PACIENTE


	$guardarFichaEpidemiologica -> paterno  = $_POST["nuevoPaternoPaciente"];
	$guardarFichaEpidemiologica -> materno  = $_POST["nuevoMaternoPaciente"];
	$guardarFichaEpidemiologica -> nombre  = $_POST["nuevoNombrePaciente"];
	$guardarFichaEpidemiologica -> cod_asegurado  = $_POST["nuevoCodAsegurado"];
	$guardarFichaEpidemiologica -> cod_afiliado  = $_POST["nuevoCodAfiliado"];
	$guardarFichaEpidemiologica -> cod_empleador  = $_POST["nuevoCodEmpleador"];
	$guardarFichaEpidemiologica -> nombre_empleador  = $_POST["nuevoNombreEmpleador"];
	$guardarFichaEpidemiologica -> nro_documento  = $_POST["nuevoNroDocumentoPaciente"];
	$guardarFichaEpidemiologica -> sexo  = $_POST["nuevoSexoPaciente"];
	$guardarFichaEpidemiologica -> fecha_nacimiento  = $_POST["nuevoFechaNacPaciente"];
	$guardarFichaEpidemiologica -> edad  = $_POST["nuevoEdadPaciente"];
	$guardarFichaEpidemiologica -> id_departamento_paciente  = $_POST["residenciaActual"];
	$guardarFichaEpidemiologica -> id_provincia_paciente  = $_POST["nuevoProvincia"];
	$guardarFichaEpidemiologica -> id_municipio_paciente  = $_POST["nuevoMunicipio"];
	$guardarFichaEpidemiologica -> id_pais_paciente  = $_POST["paisProcedencia"];
	$guardarFichaEpidemiologica -> zona  = $_POST["nuevoZonaPaciente"];
	$guardarFichaEpidemiologica -> calle  = $_POST["nuevoCallePaciente"];
	$guardarFichaEpidemiologica -> nro_calle  = $_POST["nuevoNroCallePaciente"];
	$guardarFichaEpidemiologica -> telefono  = $_POST["nuevoTelefonoPaciente"];
	$guardarFichaEpidemiologica -> email  = $_POST["nuevoEmailPaciente"];
	$guardarFichaEpidemiologica -> nombre_apoderado  = $_POST["nuevoNombreApoderado"];
	$guardarFichaEpidemiologica -> telefono_apoderado  = $_POST["nuevoTelefonoApoderado"];
	$guardarFichaEpidemiologica -> identificacion_etnica  = $_POST["identificacionEtnica"];





	// 3. ANTECEDENTES EPIDEMIOLOGICOS

	$guardarFichaEpidemiologica -> ocupacion   =   $_POST["ocupacion"];

	$guardarFichaEpidemiologica -> contacto_covid   =   $_POST["nuevoContactoCovid"];
	$guardarFichaEpidemiologica -> fecha_contacto_covid   =   $_POST["nuevoFechaContactoCovid"];
	$guardarFichaEpidemiologica -> pais_contacto_covid   =   $_POST["paisInfeccion"];
	$guardarFichaEpidemiologica -> lugar_aproximado_infeccion   =   $_POST["lugaraproximado"];
	$guardarFichaEpidemiologica -> departamento_contacto_covid   =   $_POST["departamentoProbableInfeccion"];
	$guardarFichaEpidemiologica -> provincia_contacto_covid   =   $_POST["provinciaProbableInfeccion"];
	$guardarFichaEpidemiologica -> localidad_contacto_covid   =   $_POST["municipioProbableInfeccion"];
	$guardarFichaEpidemiologica -> diagnosticado_covid_anteriormente   =   $_POST["covidPositivoAntes"];
	$guardarFichaEpidemiologica -> fecha_covid_anteriormente   =   $_POST["covidPositivoAntesFecha"];

	


	// 4. DATOS CLÍNICOS
	$guardarFichaEpidemiologica -> fecha_inicio_sintomas = $_POST["nuevoFechaInicioSintomas"];

	$guardarFichaEpidemiologica -> malestares_otros = $_POST["nuevoMalestaresOtros"];
	$guardarFichaEpidemiologica -> estado_paciente = $_POST["nuevoEstadoPaciente"];
	$guardarFichaEpidemiologica -> fecha_defuncion = $_POST["nuevoFechaDefuncion"];
	$guardarFichaEpidemiologica -> diagnostico_clinico = $_POST["nuevoDiagnosticoClinico"];



	 $guardarFichaEpidemiologica ->  fecha_inicio_sintomas   =   $_POST["nuevoFechaInicioSintomas"];

	 $guardarFichaEpidemiologica ->  estado_paciente   =   $_POST["nuevoEstadoPaciente"];
	 $guardarFichaEpidemiologica ->  fecha_defuncion   =   $_POST["nuevoFechaDefuncion"];
	 $guardarFichaEpidemiologica ->  diagnostico_clinico   =   $_POST["nuevoDiagnosticoClinico"];
	 $guardarFichaEpidemiologica ->  sintoma   =   $_POST["sintomatico_o_asintomatico"];
	


	// 5. DATOS HOSPITALIZACIÓN AISLAMIENTO


	$guardarFichaEpidemiologica  ->  fecha_aislamiento  =  $_POST["nuevoFechaAislamiento"];
	$guardarFichaEpidemiologica  ->  lugar_aislamiento  =  $_POST["nuevoLugarAislamiento"];
	$guardarFichaEpidemiologica  ->  fecha_internacion  =  $_POST["nuevoFechaInternacion"];
	$guardarFichaEpidemiologica  ->  establecimiento_internacion  =  $_POST["nuevoEstablecimientoInternacion"];
	$guardarFichaEpidemiologica  ->  ventilacion_mecanica  =  $_POST["nuevoVentilacionMecanica"];
	$guardarFichaEpidemiologica  ->  terapia_intensiva  =  $_POST["nuevoTerapiaIntensiva"];
	$guardarFichaEpidemiologica  ->  fecha_ingreso_UTI  =  $_POST["nuevoFechaIngresoUTI"];
	$guardarFichaEpidemiologica  ->  metodo_hospitalizacion  =  $_POST["ambulatorio_o_internado"];

	


	// 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO

	$guardarFichaEpidemiologica ->  enf_estado   =   $_POST["presenta_o_noPresenta"];

	$guardarFichaEpidemiologica ->  hipertension_arterial   =   $_POST["nuevoHipertensionArterial"];
	$guardarFichaEpidemiologica ->  obesidad   =   $_POST["nuevoObesidad"];
	$guardarFichaEpidemiologica ->  diabetes_general   =   $_POST["nuevoDiabetes"];
	$guardarFichaEpidemiologica ->  embarazo   =   $_POST["nuevoEmbarazo"];
	$guardarFichaEpidemiologica ->  enfermedades_oncologica   =   $_POST["nuevoEnfOnco"];
	$guardarFichaEpidemiologica ->  enfermedades_cardiaca   =   $_POST["nuevoEnfCardiaca"];
	$guardarFichaEpidemiologica ->  enfermedad_respiratoria   =   $_POST["nuevoEnfRespiratoria"];
	$guardarFichaEpidemiologica ->  enfermedades_renal_cronica   =   $_POST["nuevoEnfRenalCronica"];
	$guardarFichaEpidemiologica ->  otros   =   $_POST["nuevoEnfRiesgoOtros"];


	// 8. LABORATORIOS




  // 10 . DATOS DEL PERSONAL QUE NOTIFICA

 
 $guardarFichaEpidemiologica ->  paterno_notificador  =  $_POST["nuevoPaternoNotif"];
 $guardarFichaEpidemiologica ->  materno_notificador  =  $_POST["nuevoMaternoNotif"];
 $guardarFichaEpidemiologica ->  nombre_notificador  =  $_POST["nuevoNombreNotif"];
 $guardarFichaEpidemiologica ->  cargo_notificador  =  $_POST["nuevoCargoNotif"];

	
	$guardarFichaEpidemiologica -> ajaxGuardarFichaEpidemiologica();

}

/*=============================================
GUARDAR NUEVA FICHA CONTROL Y SEGUIMIENTO
=============================================*/

if (isset($_POST["guardarFichaControl"])) {

	$guardarFichaControl = new AjaxFichas();
	// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
	$guardarFichaControl -> id_ficha = $_POST["id_ficha"];
	$guardarFichaControl -> id_establecimiento = $_POST["id_establecimiento"];
	$guardarFichaControl -> id_consultorio = $_POST["id_consultorio"];
	$guardarFichaControl -> id_departamento = $_POST["id_departamento"];
	$guardarFichaControl -> id_localidad = $_POST["id_localidad"];
	$guardarFichaControl -> fecha_notificacion = $_POST["fecha_notificacion"];
	$guardarFichaControl -> nro_control = $_POST["nro_control"];

	// 2. IDENTIFICACIÓN DEL CASO PACIENTE
	$guardarFichaControl -> cod_asegurado = $_POST["cod_asegurado"];
	$guardarFichaControl -> cod_afiliado = $_POST["cod_afiliado"];
	$guardarFichaControl -> cod_empleador = $_POST["cod_empleador"];
	$guardarFichaControl -> nombre_empleador = $_POST["nombre_empleador"];
	$guardarFichaControl -> paterno = $_POST["paterno"];	
	$guardarFichaControl -> materno = $_POST["materno"];	
	$guardarFichaControl -> nombre = $_POST["nombre"];	
	$guardarFichaControl -> sexo = $_POST["sexo"];
	$guardarFichaControl -> nro_documento = $_POST["nro_documento"];
	$guardarFichaControl -> fecha_nacimiento = $_POST["fecha_nacimiento"];
	$guardarFichaControl -> edad = $_POST["edad"];
	$guardarFichaControl -> telefono = $_POST["telefono"];

	// 3. SEGUIMIENTO
	$guardarFichaControl -> dias_notificacion = $_POST["dias_notificacion"];
	$guardarFichaControl -> dias_sin_sintomas = $_POST["dias_sin_sintomas"];
	$guardarFichaControl -> fecha_aislamiento = $_POST["fecha_aislamiento"];
	$guardarFichaControl -> lugar_aislamiento = $_POST["lugar_aislamiento"];
	$guardarFichaControl -> fecha_internacion = $_POST["fecha_internacion"];
	$guardarFichaControl -> establecimiento_internacion = $_POST["establecimiento_internacion"];
	$guardarFichaControl -> fecha_ingreso_UTI = $_POST["fecha_ingreso_UTI"];
	$guardarFichaControl -> lugar_ingreso_UTI = $_POST["lugar_ingreso_UTI"];
	$guardarFichaControl -> ventilacion_mecanica = $_POST["ventilacion_mecanica"];
	$guardarFichaControl -> tratamiento = $_POST["tratamiento"];
	$guardarFichaControl -> tratamiento_otros = $_POST["tratamiento_otros"];

	// 4. LABORATORIOS
	$guardarFichaControl -> estado_muestra = $_POST["estado_muestra"];
	$guardarFichaControl -> tipo_muestra = $_POST["tipo_muestra"];
	$guardarFichaControl -> fecha_muestra = $_POST["fecha_muestra"];
	$guardarFichaControl -> fecha_envio = $_POST["fecha_envio"];
	$guardarFichaControl -> observaciones_muestra = $_POST["observaciones_muestra"];
	$guardarFichaControl -> des_no_muestra = $_POST["des_no_muestra"];

	// DATOS DEL PERSONAL QUE NOTIFICA
	$guardarFichaControl -> paterno_notificador = $_POST["paterno_notificador"];
	$guardarFichaControl -> materno_notificador = $_POST["materno_notificador"];
	$guardarFichaControl -> nombre_notificador = $_POST["nombre_notificador"];
	$guardarFichaControl -> telefono_notificador = $_POST["telefono_notificador"];
	$guardarFichaControl -> cargo_notificador = $_POST["cargo_notificador"];	
	$guardarFichaControl -> ajaxGuardarFichaControl();

}

/*=============================================
GUARDAR NUEVO ESTABLECIMIENTO DINAMICAMENTE
=============================================*/

if (isset($_POST["guardarCampoFicha"])) {

	$guardarFichaEpidemiologica = new AjaxFichas();
	// 1. DATOS ESTABLECIMIENTO NOTIFICADOR
	$guardarFichaEpidemiologica -> id_ficha = $_POST["id_ficha"];
	$guardarFichaEpidemiologica -> item = $_POST["item"];
	$guardarFichaEpidemiologica -> valor = $_POST["valor"];
	$guardarFichaEpidemiologica -> tabla = $_POST["tabla"];	
	$guardarFichaEpidemiologica -> ajaxGuardarCampoFicha();

}


/*=============================================
MOSTRAR EN PDF FICHA EPIDEMIOLÓGICA
=============================================*/

if (isset($_POST["fichaEpidemiologicaPDF"])) {

	$fichaEpidemiologicaPDF = new AjaxFichas();
	$fichaEpidemiologicaPDF -> idFicha = $_POST["idFicha"];
	$fichaEpidemiologicaPDF -> ajaxMostrarFichaEpidemiologicaPDF();

}

/*=========================================================
		GENERAR TODOS LOS PDFS DE FICHA Begin @danpinch
===========================================================*/

if(isset($_POST["generadorDePDFS"])){
	set_time_limit(0);
	$aux=generarPDFFichaEpdidemiologicaDinamicamente();
	$fichaEpidemiologicaPDF = new AjaxFichas();		
	$mostrarConcentimiento = new AjaxConcentimiento();
	$mostrarCertificadoMedico = new AjaxCertificadoMEdico();
	$mostrarCertificadoAlta = new AjaxCertificadoDeAlta();
	$count=0;
	do{
		$ficha = $aux[$count]['id_ficha'];
		$fichaEpidemiologicaPDF -> idFicha = $ficha;
		$fichaEpidemiologicaPDF -> ajaxMostrarFichaEpidemiologicaPDF();
		$mostrarConcentimiento->id_ficha = $ficha;
		$mostrarConcentimiento->ajaxMostarInformacionPaciente();
		$mostrarCertificadoMedico->id_ficha = $ficha;
		$mostrarCertificadoMedico->ajaxMostarCertificadoMedico();
		$mostrarCertificadoAlta->id_ficha = $ficha;
		$mostrarCertificadoAlta->ajaxMostarCertificadoDeAltaPDF();
		$count++;
	}while(next($aux));	
}

function generarPDFFichaEpdidemiologicaDinamicamente(){	
	$sql = "SELECT f.id_ficha
			FROM fichas f
			WHERE f.id_ficha IN (SELECT pa.id_ficha
								FROM pacientes_asegurados pa
								WHERE pa.cod_asegurado != ''
	)";
	$pdo = Conexion::conectarBDFicha();
	$stmt = $pdo->prepare($sql);
	if($stmt->execute()){
		return $stmt->fetchAll();
	}
	else{
		print_r($stmt->errorInfo());
	}
}
/*=====================End @danpinch ======================= */

/*=============================================
MOSTRAR EN PDF FICHA CONTROL Y SEGUIMIENTO
=============================================*/

if (isset($_POST["fichaControlPDF"])) {
	$fichaControlPDF = new AjaxFichas();
	$fichaControlPDF -> idFicha = $_POST["idFicha"];
	$fichaControlPDF -> ajaxMostrarFichaControlPDF();

}

/*=====================================================================================================================================
CODE M@rk GUARDAR O ACTUALIZAR UN CAMPO EN LA TABLA COVID RESULTADOS
=======================================================================================================================================*/
if (isset($_POST["guardarCampoCovidResultados"])) {

	$datos = array( "id_ficha"	=>  $_POST["id_ficha"], 
					"item"	    =>  $_POST["item"], 
					"valor"     =>  $_POST["valor"],
					"tabla"     =>  $_POST["tabla"]
					);
	$pdo = Conexion::conectar();
    $itemC =  $_POST["item"];
	//$sql = "UPDATE $tabla SET $item = :valor WHERE id_ficha = :id_ficha";
	$sql = "UPDATE covid_resultados SET $itemC  = :valor WHERE id_ficha = :id_ficha";

	$stmt = $pdo->prepare($sql);

	$stmt->bindParam(":valor", $datos['valor'], PDO::PARAM_STR);
	$stmt->bindParam(":id_ficha", $datos['id_ficha'], PDO::PARAM_INT);

	if ($stmt->execute()) {

		return "ok";
			
	} else {
		print_r($stmt->errorInfo());

		return "error";

	}
	$stmt->close();
	$stmt = null;
	
}

if (isset($_POST["guardarCampoLaboratorios"])) {

	$datos = array( "id_ficha"	=>  $_POST["id_ficha"], 
					"item"	    =>  $_POST["item"], 
					"valor"     =>  $_POST["valor"],
					"tabla"     =>  $_POST["tabla"]
					);
	$pdo = Conexion::conectarBDFicha();
    $itemC =  $_POST["item"];
	$tabla =  $_POST["tabla"];
	
	$sql = "UPDATE $tabla SET $itemC  = :valor WHERE id_ficha = :id_ficha";

	$stmt = $pdo->prepare($sql);

	$stmt->bindParam(":valor", $datos['valor'], PDO::PARAM_STR);
	$stmt->bindParam(":id_ficha", $datos['id_ficha'], PDO::PARAM_INT);

	if ($stmt->execute()) {

		return "ok";
			
	} else {
		print_r($stmt->errorInfo());

		return "error";

	}
	$stmt->close();
	$stmt = null;
	
}

if (isset($_POST["eliminarFichaX"])){

	$fichaControlPDF = new AjaxFichas();
	$fichaControlPDF -> eliminarFicha = "";
	$fichaControlPDF -> ajaxEliminarfichaX($_POST);
}

if (isset($_POST["eliminarFichaAll"])){
	$fichaControlPDF = new AjaxFichas();
	$fichaControlPDF -> eliminarFicha = "eliminarFichaAll";
	$fichaControlPDF -> ajaxEliminarfichasAll();
}

if(isset($_POST["actualizarTransferencia"])){
	$actualizarTranferencia = new AjaxFichasLaboratorio();
	$actualizarTranferencia->id_ficha = $_POST["id_ficha"];
	$actualizarTranferencia->item = $_POST["item"];
	$actualizarTranferencia->valor = $_POST["valor"];
	$actualizarTranferencia-> ajaxActualizarCampoTransferenciaHospitalLaboratorio();
}

