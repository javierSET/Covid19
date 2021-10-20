<?php 

class ControladorEmpleadoresSIAIS {

	/*=============================================
	LISTADO DE EMPLEADORES DE LA BASE DE DATOS SIAIS
	=============================================*/
	
	static public function ctrMostrarEmpleadoresSIAIS($item, $valor) {

		$respuesta = ModeloEmpleadoresSIAIS::mdlMostrarEmpleadoresSIAIS($item, $valor);

		return $respuesta;

	}

}