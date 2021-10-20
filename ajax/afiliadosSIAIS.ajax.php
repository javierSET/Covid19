<?php

require_once "../controladores/afiliadosSIAIS.controlador.php";
require_once "../modelos/afiliadosSIAIS.modelo.php";

require_once "../controladores/fichas.controlador.php";
require_once "../modelos/fichas.modelo.php";

class AjaxAfiliadosSIAIS {
	
	/*=============================================
	MOSTRAR DATOS AFILIADO SIAIS
	=============================================*/
	
	public $idAfiliado;

	public function ajaxMostrarAfiliadoSIAIS() {
	
    	$item1 = null;
        $item2 = "idafiliacion";
        $valor = $this->idAfiliado;

        $respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);

        /*=============================================
        ELIMINANDO ESPACIOS EN BLANCO Y FORMATEANDO ALGUNOS REGISTROS
        =============================================*/       

        $respuesta['pac_numero_historia'] = rtrim($respuesta["pac_numero_historia"]);

        $respuesta['pac_codigo'] = rtrim($respuesta["pac_codigo"]);

        $respuesta['emp_nombre'] = rtrim($respuesta["emp_nombre"]);

        $respuesta['pac_primer_apellido'] = rtrim($respuesta["pac_primer_apellido"]);

        $respuesta['pac_segundo_apellido'] = rtrim($respuesta["pac_segundo_apellido"]);

        $respuesta['pac_nombre'] = rtrim($respuesta["pac_nombre"]);

        // $respuesta['pac_fecha_nac'] = date("d/m/Y", strtotime($respuesta['pac_fecha_nac']));
        $respuesta['pac_documento_id'] = rtrim($respuesta["pac_documento_id"]); // AGREGADO

        $respuesta['pac_fecha_nac'] = $respuesta['pac_fecha_nac'];

        echo json_encode($respuesta);

	}

    public $idFicha;

    public function ajaxMostrarAfiliadoSIAISFicha() {
            
        $item1 = null;
        $item2 = "idafiliacion";
        $valor = $this->idAfiliado;

        $respuesta = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);

        /*=============================================
        ELIMINANDO ESPACIOS EN BLANCO Y FORMATEANDO ALGUNOS REGISTROS
        =============================================*/       

        $respuesta['pac_numero_historia'] = rtrim($respuesta["pac_numero_historia"]);

        $respuesta['pac_codigo'] = rtrim($respuesta["pac_codigo"]);

        $respuesta['emp_nombre'] = rtrim($respuesta["emp_nombre"]);

        $respuesta['pac_primer_apellido'] = rtrim($respuesta["pac_primer_apellido"]);

        $respuesta['pac_segundo_apellido'] = rtrim($respuesta["pac_segundo_apellido"]);

        $respuesta['pac_nombre'] = rtrim($respuesta["pac_nombre"]);

        $respuesta['pac_documento_id'] = rtrim($respuesta["pac_documento_id"]); // AGREGADO

        $respuesta['pac_fecha_nac'] = $respuesta['pac_fecha_nac'];

        $id_ficha = $this->idFicha;

        ControladorFichas::ctrGuardarAfiliadoFicha($id_ficha, $respuesta);

        echo json_encode($respuesta);    

    }

}
	
/*=============================================
MOSTRAR DATOS AFILIADO SIAIS
=============================================*/

if (isset($_POST["mostrarAfiliado"])) {

	$seleccionarAfiliado = new AjaxAfiliadosSIAIS();
	$seleccionarAfiliado -> idAfiliado = $_POST["idAfiliado"];
	$seleccionarAfiliado -> ajaxMostrarAfiliadoSIAIS();

}

/*=============================================
MOSTRAR Y GUARDAR DATOS AFILIADO SIAIS EN FICHA 
=============================================*/

if (isset($_POST["guardarAfiliadoFicha"])) {

    $seleccionarAfiliado = new AjaxAfiliadosSIAIS();
    $seleccionarAfiliado -> idAfiliado = $_POST["idAfiliado"];
    $seleccionarAfiliado -> idFicha = $_POST["idFicha"];
    $seleccionarAfiliado -> ajaxMostrarAfiliadoSIAISFicha();

}