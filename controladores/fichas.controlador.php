<?php 

class ControladorFichas {

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA FICHAS (LABORATORIO)
	=============================================*/
	
	static public function ctrContarFichasLab() {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlContarFichasLab($tabla);

		return $respuesta;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA FICHAS FILTRADO (LABORATORIO)
	=============================================*/
	
	static public function ctrContarFiltradoFichasLab($sql) {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlContarFiltradoFichasLab($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	MOSTAR LOS REGISTROS QUE EXISTE EN LA TABLA FICHAS (LABORATORIO)
	=============================================*/
	
	static public function ctrMostrarFichasLab($sql) {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlMostrarFichasLab($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (CENTRO COVID)
	=============================================*/
	
	static public function ctrContarFichasCentro() {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlContarFichasCentro($tabla);

		return $respuesta;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS DE LA TABLA VISTA_FICHAS
	=============================================*/
	
	static public function ctrContarFichasSeguimiento() {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlContarFichasSeguimiento($tabla);

		return $respuesta;

	}


	static public function ctrContarFichasSeguimientoTableSeguimientos() {

		$tabla = "vista_seguimientos";

		$respuesta = ModeloFichas::mdlContarFichasSeguimientoTablaSeguimiento($tabla);

		return $respuesta;

	}


	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (CENTRO COVID)
	=============================================*/
	
	static public function ctrContarFiltradoFichasCentro($sql) {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlContarFiltradoFichasCentro($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	CONTAR EL NUMERO DE REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS FILTRADO (CENTRO COVID)
	=============================================*/
	
	static public function ctrContarFiltradoFichasSeguimiento($sql) {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlContarFiltradoFichasSeguimiento($tabla, $sql);

		return $respuesta;

	}


	static public function ctrContarFiltradoFichasSeguimientoTableSeguimiento($sql) {

		$tabla = "vista_seguimientos";

		$respuesta = ModeloFichas::mdlContarFiltradoFichasSeguimientoTableSeguimiento($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LOS REGISTROS QUE EXISTE EN LA TABLA COVID RESULTADOS (CENTRO COVID)
	=============================================*/
	
	static public function ctrMostrarFichasCentro($sql) {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlMostrarFichasCentro($tabla, $sql);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LOS REGISTROS QUE EXISTE EN LA TABLA VISTA_FICHAS
	=============================================*/
	
	static public function ctrMostrarFichasSeguimiento($sql) {

		$tabla = "vista_fichas";

		$respuesta = ModeloFichas::mdlMostrarFichasSeguimiento($tabla, $sql);

		return $respuesta;

	}


	static public function ctrMostrarFichasSeguimientoTableSeguimiento($sql) {

		$tabla = "vista_seguimientos";

		$respuesta = ModeloFichas::mdlMostrarFichasSeguimientoTableSeguimiento($tabla, $sql);

		return $respuesta;

	}
	
	/*=============================================
	MOSTRAR LOS DATOS DE FICHAS COVID-19
	=============================================*/
	
	static public function ctrMostrarFichas($item, $valor, $duplicidad = false) {

		$tabla = "fichas";

		$respuesta = ModeloFichas::mdlMostrarFichas($tabla, $item, $valor, $duplicidad);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR LOS DE FICHA COVID-19 DE ACUERDO A LA FECHA
	=============================================*/
	
	static public function ctrMostrarFichasFecha($item, $valor) {

		$tabla = "fichas";

		$respuesta = ModeloFichas::mdlMostrarFichasFecha($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR DATOS DE UNA FICHA COVID 19
	=============================================*/
	
	static public function ctrMostrarDatosFicha($item, $valor) {

		$tabla = "fichas";

		$respuesta = ModeloFichas::mdlMostrarDatosFicha($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR UNA NUEVA FICHA
	=============================================*/
	
	static public function ctrCrearFicha($datos, $request) {

		$tabla = "fichas";

		$respuesta = ModeloFichas::mdlCrearFicha($tabla, $datos, $request);

		return $respuesta;

	}

	/*=============================================
	GUARDANDO DATOS DE FICHA EPIDEMIOLÓGICA
	=============================================*/
	
	static public function ctrGuardarFichaEpidemiologica($datos) {

		$tabla = "fichas";

		$respuesta = ModeloFichas::mdlGuardarFichaEpidemiologica($tabla, $datos);

		return $respuesta;

	}

	/*=============================================
	GUARDANDO DATOS DE FICHA CONTROL Y SEGUIMIENTO
	=============================================*/
	
	static public function ctrGuardarFichaControl($datos) {

		$tabla = "fichas";

		$respuesta = ModeloFichas::mdlGuardarFichaControl($tabla, $datos);

		echo $respuesta;

	}

	/*=============================================
	GUARDANDO DATO DE UN CAMPO EN FICHA EPIDEMIOLÓGICA DINAMICAMENTE
	=============================================*/
	
	static public function ctrGuardarCampoFichaEpidemiologica($id_ficha, $item, $valor, $tabla) {

		$respuesta = ModeloFichas::mdlGuardarCampoFichaEpidemiologica($id_ficha, $item, $valor, $tabla);

		echo $respuesta;

	}

	/*=============================================
	GUARDANDO DATOS AFILIADO EN FICHA EPIDEMIOLÓGICA DINAMICAMENTE
	=============================================*/
	
	static public function ctrGuardarAfiliadoFicha($id_ficha, $datos) {

		$tabla = "pacientes_asegurados";

		$respuesta = ModeloFichas::mdlGuardarAfiliadoFicha($id_ficha, $datos, $tabla);

		echo $respuesta;

	}

}