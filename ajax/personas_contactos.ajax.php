<?php

require_once "../controladores/personas_contactos.controlador.php";
require_once "../modelos/personas_contactos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxPersonasContactos {

	/*=============================================
	MOSTRAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	 
	public $id; 

	public function ajaxMostrarPersonaContacto()	{

		$item = "id";
		$valor = $this->id;

		$respuesta = ControladorPersonasContactos::ctrMostrarPersonaContacto($item, $valor);

		echo json_encode($respuesta);

	}
	
	/*=============================================
	CREAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	public $paterno_contacto; 
	public $materno_contacto;
	public $nombre_contacto; 
	public $relacion_contacto; 
	public $edad_contacto; 
	public $telefono_contacto; 
	public $direccion_contacto; 
	public $fecha_contacto; 
	public $lugar_contacto; 
	public $id_ficha; 

	public function ajaxCrearPersonaContacto()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "personas_contactos";

		$datos = array( "paterno_contacto"	 => mb_strtoupper($this->paterno_contacto,'utf-8'), 
						"materno_contacto"   => mb_strtoupper($this->materno_contacto,'utf-8'),
						"nombre_contacto"    => mb_strtoupper($this->nombre_contacto,'utf-8'),
						"relacion_contacto"  => mb_strtoupper($this->relacion_contacto),
						"edad_contacto"      => $this->edad_contacto,
						"telefono_contacto"  => $this->telefono_contacto,
						"direccion_contacto" => mb_strtoupper($this->direccion_contacto,'utf-8'),
						"fecha_contacto"     => $this->fecha_contacto,
						"lugar_contacto"     => mb_strtoupper($this->lugar_contacto,'utf-8'),
						"id_ficha"  		 => $this->id_ficha,
						);	

		$respuesta = ModeloPersonasContactos::mdlIngresarPersonaContacto($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}

	/*=============================================
	EDITAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	public function ajaxEditarPersonaContacto()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "personas_contactos";

		$datos = array( "id"  		 		 => $this->id,
						"paterno_contacto"	 => mb_strtoupper($this->paterno_contacto,'utf-8'), 
						"materno_contacto"   => mb_strtoupper($this->materno_contacto,'utf-8'),
						"nombre_contacto"    => mb_strtoupper($this->nombre_contacto,'utf-8'),
						"relacion_contacto"  => mb_strtoupper($this->relacion_contacto),
						"edad_contacto"      => $this->edad_contacto,
						"telefono_contacto"  => $this->telefono_contacto,
						"direccion_contacto" => mb_strtoupper($this->direccion_contacto,'utf-8'),
						"fecha_contacto"     => date("Y-m-d", strtotime($this->fecha_contacto)),
						"lugar_contacto"     => mb_strtoupper($this->lugar_contacto,'utf-8'),
						);	

		$respuesta = ModeloPersonasContactos::mdlEditarPersonaContacto($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}

	/*=============================================
	ELIMINAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
	=============================================*/

	public function ajaxEliminarPersonaContacto()	{

		$tabla = "personas_contactos";
		$datos = $this->id;

		$respuesta = ModeloPersonasContactos::mdlEliminarPersonaContacto($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}


}

/*=============================================
MOSTRAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["mostrarPersonaContacto"])) {

	$mostrarPersonasContactos = new AjaxPersonasContactos();
	$mostrarPersonasContactos -> id = $_POST["id_persona_contacto"];
	$mostrarPersonasContactos -> ajaxMostrarPersonaContacto();

}

/*=============================================
CREAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["guardarPersonasContactos"])) {

	$guardarPersonasContactos = new AjaxPersonasContactos();
	$guardarPersonasContactos -> paterno_contacto = $_POST["paterno_contacto"];
	$guardarPersonasContactos -> materno_contacto = $_POST["materno_contacto"];
	$guardarPersonasContactos -> nombre_contacto = $_POST["nombre_contacto"];
	$guardarPersonasContactos -> relacion_contacto = $_POST["relacion_contacto"];
	$guardarPersonasContactos -> edad_contacto = $_POST["edad_contacto"];
	$guardarPersonasContactos -> telefono_contacto = $_POST["telefono_contacto"];
	$guardarPersonasContactos -> direccion_contacto = $_POST["direccion_contacto"];
	$guardarPersonasContactos -> fecha_contacto = $_POST["fecha_contacto"];
	$guardarPersonasContactos -> lugar_contacto = $_POST["lugar_contacto"];
	$guardarPersonasContactos -> id_ficha = $_POST["id_ficha"];
	$guardarPersonasContactos -> ajaxCrearPersonaContacto();

}

/*=============================================
CREAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["editarPersonasContactos"])) {

	$guardarPersonasContactos = new AjaxPersonasContactos();
	$guardarPersonasContactos -> id = $_POST["id_persona_contacto"];
	$guardarPersonasContactos -> paterno_contacto = $_POST["paterno_contacto"];
	$guardarPersonasContactos -> materno_contacto = $_POST["materno_contacto"];
	$guardarPersonasContactos -> nombre_contacto = $_POST["nombre_contacto"];
	$guardarPersonasContactos -> relacion_contacto = $_POST["relacion_contacto"];
	$guardarPersonasContactos -> edad_contacto = $_POST["edad_contacto"];
	$guardarPersonasContactos -> telefono_contacto = $_POST["telefono_contacto"];
	$guardarPersonasContactos -> direccion_contacto = $_POST["direccion_contacto"];
	$guardarPersonasContactos -> fecha_contacto = $_POST["fecha_contacto"];
	$guardarPersonasContactos -> lugar_contacto = $_POST["lugar_contacto"];
	$guardarPersonasContactos -> ajaxEditarPersonaContacto();

}

/*=============================================
ELIMINAR DATOS DE PERSONA CONTACTO EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["eliminarPersonaContacto"])) {

	$eliminarPersonasContactos = new AjaxPersonasContactos();
	$eliminarPersonasContactos -> id = $_POST["id_persona_contacto"];
	$eliminarPersonasContactos -> ajaxEliminarPersonaContacto();

}