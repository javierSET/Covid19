<?php 

class ControladorPacientesAsegurados {
	
	/*=====================================================================
	MOSTRAR LOS DATOS DE PACIENTE ASEGURADO EN LA FICHA EPIDEMIOLOGICA
	=======================================================================*/
	
	static public function ctrMostrarPacientesAsegurados($item, $valor) {

		$tabla = "pacientes_asegurados";

		$respuesta = ModeloPacientesAsegurados::mdlMostrarPacientesAsegurados($tabla, $item, $valor);

		return $respuesta;

	}

	/*=====================================================================
	MUESTRA TODAS LAS BAJAS DADO UN ID DE UN PACIENTE X M@RK
	=======================================================================*/
	
	static public function ctrMostrarBajas($cod_asegurado) {

		$respuesta = ModeloPacientesAsegurados::ctrMostrarBajas($cod_asegurado);

		return $respuesta;

	}

	/*=======================================================================================
	BUSCAR EL PACIENTES EN LA TABLA PACIENTES_ASEGURADOS ANTES DE BUSCAR EN SIAIS M@rk
	=======================================================================================*/
	
	static public function ctrMostrarPacientesAseguradosSIAIS($valor){

		$tabla = "vista_pacientes";

		$respuesta = ModeloPacientesAsegurados::mdlMostrarPacientesAseguradosSIAIS($tabla, $valor);

		return $respuesta;

	}
	
	/*================================================================
					ELIMINAR PACIENTE ASEGURADO
	==================================================================*/
	static public function ctrEliminarPacientesAsegurados($item, $valor) {
		$tabla = "pacientes_asegurados";
		$respuesta = ModeloPacientesAsegurados::mdlEliminarPacienteAsegurado($tabla, $item, $valor);
		return $respuesta;
	}


	/*================================================================
			MODIFICAR nombre_emplador cod_empleador
	==================================================================*/

	static public function ctrEditarPacineteAseguradoNombreEmpleador($item, $datos){
		$tabla = "pacientes_asegurados";
		$respuesta = ModeloPacientesAsegurados::mdlEditarPacienteAseguradoNombreEmpleador($tabla,$item,$datos);
		return $respuesta;
	}

	/*================================================================
			MODIFICAR nombre_emplador cod_empleador copia arriba para k no cause crash
	==================================================================*/

	static public function ctrEditarPacineteAseguradoNombreEmpleador2($item, $datos){
		$tabla = "pacientes_asegurados";
		$respuesta = ModeloPacientesAsegurados::mdlEditarPacienteAseguradoNombreEmpleador2($tabla,$item,$datos);
		return $respuesta;
	}

	/*================================================================
			MODIFICAR codEmpleador,nombreEmpleador, nombreAsegurado, paterno,materno, ci, calle,zona,nro
	==================================================================*/

	static public function ctrEditarPacineteAsegurado($item, $datos){
		$tabla = "pacientes_asegurados";
		$respuesta = ModeloPacientesAsegurados::mdlEditarPacienteAsegurado($tabla,$item,$datos);
		return $respuesta;
	}

	/*=======================================================================================
	BUSCAR EL PACIENTES EN LA TABLA PACIENTES_ASEGURADOS ANTES DE BUSCAR EN SIAIS danpinch
	=======================================================================================*/
	
	static public function ctrBusquedaPacienteBajaSospechosoActiva($codAsegurado,$hoy){

		$respuesta = ModeloPacientesAsegurados::mldBusquedaPacienteBajaSospechosoActiva($codAsegurado,$hoy);

		return $respuesta;

	}

	/*=======================================================================================
	BUSCAR EL PACIENTES EN LA TABLA PACIENTES_ASEGURADOS ANTES DE BUSCAR EN SIAIS danpinch
	=======================================================================================*/
	
	static public function ctrBusquedaPacienteBajaPositivoActiva($codAsegurado,$hoy){

		$respuesta = ModeloPacientesAsegurados::mldBusquedaPacienteBajaPositivoActiva($codAsegurado,$hoy);

		return $respuesta;

	}

	/*=======================================================================================
	BUSCAR EL PACIENTES EN LA TABLA PACIENTES_ASEGURADOS ANTES DE BUSCAR EN SIAIS danpinch
	=======================================================================================*/
	
	static public function ctrMostrarPacientesAseguradosSIAISBajas($valor){		

		$respuesta = ModeloPacientesAsegurados::mdlMostrarPacientesAseguradosSIAISBajas($valor);

		return $respuesta;

	}
	

}