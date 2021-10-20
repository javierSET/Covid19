<?php 

class ControladorBajasExterno {
	
	static public function ctrMostrarFormularioBajaExterno($item, $valor){
		$tabla = "formulario_bajas_externo";
		$respuesta = ModeloFormularioBajasExterno::mdlMostrarFormularioBajasExterno($tabla,$item,$valor);
		return $respuesta;		
	}

	static public function ctrEliminarFormularioBajaExterno($item, $valor){
		$tabla = "formulario_bajas_externo";
		$respuesta = ModeloFormularioBajasExterno::mdlEliminarFormularioBajaExterno($tabla,$item,$valor);
		return $respuesta;
	}

	static public function mdlIngresarFormularioBajaSospechoso($datos){
		$tabla = "formulario_bajas_externo";
		$respuesta = ModeloFormularioBajasExterno::mdlIngresarFormularioBajaSospechoso($tabla,$datos);
		return $respuesta;
	}
	
}
?>