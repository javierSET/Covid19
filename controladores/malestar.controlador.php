<?php 

class ControladorMalestar {

	
	/*=============================================
		CREAR UN NUEVO MALESTAR
	=============================================*/
	
	static public function ctrCrearMalestar($id_ficha, $item, $valor, $tabla) {

		$respuesta = ModeloMalestar::mdlIngresarMalestar($id_ficha, $item, $valor, $tabla);
		return $respuesta;

	}

	static public function ctrMostrarMalestar($id_ficha) {
		$respuesta = ModeloMalestar::mldMostrarMalesarId_ficha($id_ficha);
		return $respuesta;

	}

}