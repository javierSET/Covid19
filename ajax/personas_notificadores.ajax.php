<?php

// require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/personas_notificadores.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxPersonasNotificadores {
	
	/*=============================================
	CREAR DATOS DE PERSONA NOTIFICADOR EN LA FICHA EPIDEMIOLOGICA
	=============================================*/
	
	public $paterno; 
	public $materno;
	public $nombre; 
	public $telefono; 
	public $cargo; 
	public $id_ficha; 

	public function ajaxCrearPersonaNotificador()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "personas_notificadores";

		$datos = array( "paterno"	=> mb_strtoupper($this->paterno,'utf-8'), 
						"materno"   => mb_strtoupper($this->materno,'utf-8'),
						"nombre"    => mb_strtoupper($this->nombre,'utf-8'),
						"telefono"  => $this->telefono,
						"cargo"     => mb_strtoupper($this->cargo,'utf-8'),
						"id_ficha"  		=> $this->id_ficha,
						);	

		$respuesta = ModeloPersonasNotificadores::mdlIngresarPersonaNotificador($tabla, $datos);

		// var_dump($datos);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS DE PERSONA NOTIFICADOR EN LA FICHA EPIDEMIOLOGICA
=============================================*/

if (isset($_POST["guardarPersonasNotificadores"])) {

	$guardarPersonasNotificadores = new AjaxPersonasNotificadores();
	$guardarPersonasNotificadores -> paterno = $_POST["paterno"];
	$guardarPersonasNotificadores -> materno = $_POST["materno"];
	$guardarPersonasNotificadores -> nombre = $_POST["nombre"];
	$guardarPersonasNotificadores -> telefono = $_POST["telefono"];
	$guardarPersonasNotificadores -> cargo = $_POST["cargo"];
	$guardarPersonasNotificadores -> id_ficha = $_POST["id_ficha"];
	$guardarPersonasNotificadores -> ajaxCrearPersonaNotificador();

}
