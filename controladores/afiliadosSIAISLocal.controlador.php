<?php 
/*
	@Author: Daniel Villegas Veliz
	@version: 1.0
	@description: 
 */


class ControladorAfiliadosSIAISLocal {

	/*=============================================
	LISTADO DE AFILIADOS DE LA BASE DE DATOS LOCAL
	=============================================*/
	
	static public function ctrMostrarAfiliadosSIAISLocal($valor) {
		$vista = "vista_busquedaafiliadosiaislocal";
		$respuesta = ModeloAfiliadosSIAISLaboratorio::mdlMostrarAfiliadosSIAISLocal($valor, $vista);
		return $respuesta;
	}

}