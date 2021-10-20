<?php

// require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/pacientes_asegurados.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/departamentos.controlador.php";
require_once "../modelos/departamentos.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";

require_once "../controladores/paises.controlador.php";
require_once "../modelos/paises.modelo.php";


class AjaxPacientesAsegurados {
	
	/*=============================================
	CREAR DATOS DE PACIENTE ASEGURADO
	=============================================*/
	
	public $cod_asegurado; 
	public $cod_afiliado; 
	public $cod_empleador; 
	public $nombre_empleador; 
	public $paterno; 
	public $materno; 
	public $nombre; 
	public $sexo; 
	public $nro_documento; 
	public $fecha_nacimiento; 
	public $edad; 
	public $id_departamento; 
	public $id_localidad; 
	public $id_pais; 
	public $zona; 
	public $calle; 
	public $nro_calle; 
	public $telefono; 
	public $nombre_apoderado; 
	public $telefono_apoderado; 
	public $id_ficha; 

	public function ajaxCrearPacienteAsegurado()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "pacientes_asegurados";

		$datos = array( "cod_asegurado"		  	=> $this->cod_asegurado, 
						"cod_afiliado"	      	=> $this->cod_afiliado, 
						"cod_empleador"    		=> $this->cod_empleador,
						"nombre_empleador"    	=> $this->nombre_empleador,
						"paterno"     	      	=> $this->paterno,
						"materno"     	      	=> $this->materno,
						"nombre"     	      	=> $this->nombre,
						"sexo"     	          	=> $this->sexo,
						"nro_documento"    		=> $this->nro_documento,
						"fecha_nacimiento"    	=> date("Y-m-d", strtotime($this->fecha_nacimiento)),
						"edad"     	          	=> $this->edad,
						"id_departamento"    	=> $this->id_departamento,
						"id_localidad"  		=> $this->id_localidad,
						"id_pais"     	      	=> $this->id_pais,
						"zona"   	          	=> strtoupper($this->zona),
						"calle"   	          	=> strtoupper($this->calle),
						"nro_calle"   	      	=> $this->nro_calle,
						"telefono"   	      	=> $this->telefono,
						"nombre_apoderado"  	=> strtoupper($this->nombre_apoderado),
						"telefono_apoderado"  	=> $this->telefono_apoderado,
						"id_ficha"  			=> $this->id_ficha,
						);	

		$respuesta = ModeloPacientesAsegurados::mdlIngresarPacienteAsegurado($tabla, $datos);

		//var_dump($datos);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS DE PACIENTE ASEGURADO
=============================================*/

if (isset($_POST["guardarDatosPaciente"])) {

	$guardarPacienteAsegurado = new AjaxPacientesAsegurados();
	$guardarPacienteAsegurado -> cod_asegurado = $_POST["cod_asegurado"];
	$guardarPacienteAsegurado -> cod_afiliado = $_POST["cod_afiliado"];
	$guardarPacienteAsegurado -> cod_empleador = $_POST["cod_empleador"];
	$guardarPacienteAsegurado -> nombre_empleador = $_POST["nombre_empleador"];
	$guardarPacienteAsegurado -> paterno = $_POST["paterno"];
	$guardarPacienteAsegurado -> materno = $_POST["materno"];
	$guardarPacienteAsegurado -> nombre = $_POST["nombre"];
	$guardarPacienteAsegurado -> sexo = $_POST["sexo"];
	$guardarPacienteAsegurado -> nro_documento = $_POST["nro_documento"];
	$guardarPacienteAsegurado -> fecha_nacimiento = $_POST["fecha_nacimiento"];
	$guardarPacienteAsegurado -> edad = $_POST["edad"];
	$guardarPacienteAsegurado -> id_departamento = $_POST["id_departamento"];
	$guardarPacienteAsegurado -> id_localidad = $_POST["id_localidad"];
	$guardarPacienteAsegurado -> id_pais = $_POST["id_pais"];
	$guardarPacienteAsegurado -> zona = $_POST["zona"];
	$guardarPacienteAsegurado -> calle = $_POST["calle"];
	$guardarPacienteAsegurado -> nro_calle = $_POST["nro_calle"];
	$guardarPacienteAsegurado -> telefono = $_POST["telefono"];
	$guardarPacienteAsegurado -> nombre_apoderado = $_POST["nombre_apoderado"];
	$guardarPacienteAsegurado -> telefono_apoderado = $_POST["telefono_apoderado"];
	$guardarPacienteAsegurado -> id_ficha = $_POST["id_ficha"];
	$guardarPacienteAsegurado -> ajaxCrearPacienteAsegurado();

}
