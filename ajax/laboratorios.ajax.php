<?php

// require_once "../controladores/fichas.controlador.php";
require_once "../modelos/laboratorios.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxLaboratorios {
	
	public $estado_muestra;
	public $id_establecimiento;
	public $tipo_muestra;
	public $nombre_laboratorio;
	public $fecha_muestra;
	public $fecha_envio;
	public $cod_laboratorio;
	public $responsable_muestra;
	public $observaciones_muestra;
	public $resultado_laboratorio;
	public $fecha_resultado;
	public $id_ficha;

	public $cod_asegurado;
	public $cod_afiliado;
	public $cod_empleador;
	public $nombre_empleador;
	public $paterno;
	public $materno;
	public $nombre;
	public $id_departamento;
	public $documento_ci;
	public $sexo;
	public $fecha_nacimiento;
	public $telefono;
	public $email;
	public $id_localidad;
	public $zona;
	public $calle;
	public $nro_calle;
	public $id_usuario;
	public $foto;
	public $responsableAnalisis;

	//añandiendo los campos de la seccion Resultados por si selecciono alguno en editar-ficha-epidemiologica-lab

	public $pcrTiempoReal; 
	public $pcrGenExpert; 
	public $pruebaAntigenica; 

	/*=============================================
	CREAR DATOS DE LABORATORIO DE LA FICHA EPIDEMIOLÓGICA
	=============================================*/

	public function ajaxGuardarLaboratorio()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "Laboratorios";

		$datos = array( "estado_muestra"		 => $this->estado_muestra, 
						"id_establecimiento"	 => $this->id_establecimiento, 
						"tipo_muestra"     	     => mb_strtoupper($this->tipo_muestra,'utf-8'),
						"nombre_laboratorio"     => mb_strtoupper($this->nombre_laboratorio,'utf-8'),
						"fecha_muestra"  		 => $this->fecha_muestra,
						"fecha_envio"     	     => $this->fecha_envio,
						"cod_laboratorio"   	 => $this->cod_laboratorio,
						"responsable_muestra" 	 => mb_strtoupper($this->responsable_muestra),
						"observaciones_muestra"  => mb_strtoupper($this->observaciones_muestra),
						"resultado_laboratorio"  => $this->resultado_laboratorio,
						"fecha_resultado"   	 => $this->fecha_resultado,
						"id_ficha"   	         => $this->id_ficha,

						"muestra_control" 	     => "NO",
						"cod_asegurado" 	     => $this->cod_asegurado,
						"cod_afiliado"		     => $this->cod_afiliado,
						"cod_empleador"	         => $this->cod_empleador,
						"nombre_empleador"       => $this->nombre_empleador,
						"paterno"			     => $this->paterno,
						"materno"			     => $this->materno,
						"nombre"			     => $this->nombre,
						"id_departamento"	     => $this->id_departamento,
						"documento_ci"		     => $this->documento_ci,
						"sexo"				     => $this->sexo,
						"fecha_nacimiento"	     => $this->fecha_nacimiento,
						"telefono"			     => $this->telefono,
						"email"			         => $this->email,
						"id_localidad"	         => $this->id_localidad,
						"zona"			         => $this->zona,
						"calle"			         => $this->calle,
						"nro_calle"		         => $this->nro_calle,
						"id_usuario"	         => $this->id_usuario,
						"foto"			         => $this->foto,
						"responsableAnalisis"    => $this->responsableAnalisis,
						"pcrTiempoReal"          => $this->pcrTiempoReal,
						"pcrGenExpert"           => $this->pcrGenExpert,
						"pruebaAntigenica"       => $this->pruebaAntigenica
						);	

		// var_dump($datos);

		$respuesta = ModeloLaboratorios::mdlGuardarLaboratorio($tabla, $datos);

		echo $respuesta;

	}

	/*=============================================
	CREAR DATOS DE LABORATORIO DE LA FICHA CONTROL Y SEGUIMIENTO
	=============================================*/

	public function ajaxGuardarLaboratorioControl()	{

		/*=============================================
		ALMACENANDO LOS DATOS EN LA BD
		=============================================*/

		$tabla = "Laboratorios";

		$datos = array( "tipo_muestra"     	     => mb_strtoupper($this->tipo_muestra,'utf-8'),
						"nombre_laboratorio"     => mb_strtoupper($this->nombre_laboratorio,'utf-8'),
						"fecha_muestra"  		 => $this->fecha_muestra,
						"fecha_envio"     	     => $this->fecha_envio,
						"cod_laboratorio"   	 => $this->cod_laboratorio,
						"responsable_muestra" 	 => mb_strtoupper($this->responsable_muestra),
						"observaciones_muestra"  => mb_strtoupper($this->observaciones_muestra),
						"resultado_laboratorio"  => $this->resultado_laboratorio,
						"fecha_resultado"   	 => $this->fecha_resultado,
						"id_ficha"   	         => $this->id_ficha,

						"id_establecimiento"	 => $this->id_establecimiento, 
						"muestra_control" 	     => "SI",
						"cod_asegurado" 	     => $this->cod_asegurado,
						"cod_afiliado"		     => $this->cod_afiliado,
						"cod_empleador"	         => $this->cod_empleador,
						"nombre_empleador"       => $this->nombre_empleador,
						"paterno"			     => $this->paterno,
						"materno"			     => $this->materno,
						"nombre"			     => $this->nombre,
						"id_departamento"	     => $this->id_departamento,
						"documento_ci"		     => $this->documento_ci,
						"sexo"				     => $this->sexo,
						"fecha_nacimiento"	     => $this->fecha_nacimiento,
						"telefono"			     => $this->telefono,
						"email"			         => $this->email,
						"id_localidad"	         => $this->id_localidad,
						"zona"			         => $this->zona,
						"calle"			         => $this->calle,
						"nro_calle"		         => $this->nro_calle,
						"id_usuario"	         => $this->id_usuario,
						"foto"			         => $this->foto,
						);

		// var_dump($datos);

		$respuesta = ModeloLaboratorios::mdlGuardarLaboratorioControl($tabla, $datos);

		echo $respuesta;

	}

}

/*=============================================
CREAR DATOS DE LABORATORIO DE LA FICHA EPIDEMIOLÓGICA
=============================================*/

if (isset($_POST["guardarLaboratorio"])) {

	$guardarLaboratorio = new AjaxLaboratorios();
	$guardarLaboratorio -> estado_muestra = $_POST["estado_muestra"];
	$guardarLaboratorio -> id_establecimiento = $_POST["id_establecimiento"];
	$guardarLaboratorio -> tipo_muestra = $_POST["tipo_muestra"];
	$guardarLaboratorio -> nombre_laboratorio = $_POST["nombre_laboratorio"];
	$guardarLaboratorio -> fecha_muestra = $_POST["fecha_muestra"];
	$guardarLaboratorio -> fecha_envio = $_POST["fecha_envio"];
	$guardarLaboratorio -> cod_laboratorio = $_POST["cod_laboratorio"];
	$guardarLaboratorio -> responsable_muestra = $_POST["responsable_muestra"];
	$guardarLaboratorio -> observaciones_muestra = $_POST["observaciones_muestra"];
	$guardarLaboratorio -> resultado_laboratorio = $_POST["resultado_laboratorio"];
	$guardarLaboratorio -> fecha_resultado = $_POST["fecha_resultado"];
	$guardarLaboratorio -> id_ficha = $_POST["id_ficha"];

	$guardarLaboratorio -> cod_asegurado = $_POST["cod_asegurado"];
	$guardarLaboratorio -> cod_afiliado = $_POST["cod_afiliado"];
	$guardarLaboratorio -> cod_empleador = $_POST["cod_empleador"];
	$guardarLaboratorio -> nombre_empleador = $_POST["nombre_empleador"];
	$guardarLaboratorio -> paterno = $_POST["paterno"];
	$guardarLaboratorio -> materno = $_POST["materno"];
	$guardarLaboratorio -> nombre = $_POST["nombre"];
	$guardarLaboratorio -> id_departamento = $_POST["id_departamento"];
	$guardarLaboratorio -> documento_ci = $_POST["documento_ci"];
	$guardarLaboratorio -> sexo = substr($_POST["sexo"], 0, 1);
	$guardarLaboratorio -> fecha_nacimiento = $_POST["fecha_nacimiento"];
	$guardarLaboratorio -> telefono = $_POST["telefono"];
	$guardarLaboratorio -> email = $_POST["email"];
	$guardarLaboratorio -> id_localidad = $_POST["id_localidad"];
	$guardarLaboratorio -> zona = $_POST["zona"];
	$guardarLaboratorio -> calle = $_POST["calle"];
	$guardarLaboratorio -> nro_calle = $_POST["nro_calle"];
	$guardarLaboratorio -> id_usuario = $_POST["id_usuario"];
	$guardarLaboratorio -> foto = $_POST["foto"];
	$guardarLaboratorio -> responsableAnalisis = $_POST["responsableAnalisis"];
	$guardarLaboratorio -> pcrTiempoReal = $_POST["pcrTiempoReal"];
	$guardarLaboratorio -> pcrGenExpert = $_POST["pcrGenExpert"];
	$guardarLaboratorio -> pruebaAntigenica = $_POST["pruebaAntigenica"];
	$guardarLaboratorio -> ajaxGuardarLaboratorio();

}

/*=============================================
CREAR DATOS DE LABORATORIO DE LA FICHA CONTROL Y SEGUIMIENTO
=============================================*/

if (isset($_POST["guardarLaboratorioControl"])) {

	$guardarLaboratorio = new AjaxLaboratorios();
	$guardarLaboratorio -> tipo_muestra = $_POST["tipo_muestra"];
	$guardarLaboratorio -> nombre_laboratorio = $_POST["nombre_laboratorio"];
	$guardarLaboratorio -> fecha_muestra = $_POST["fecha_muestra"];
	$guardarLaboratorio -> fecha_envio = $_POST["fecha_envio"];
	$guardarLaboratorio -> cod_laboratorio = $_POST["cod_laboratorio"];
	$guardarLaboratorio -> responsable_muestra = $_POST["responsable_muestra"];
	$guardarLaboratorio -> observaciones_muestra = $_POST["observaciones_muestra"];
	$guardarLaboratorio -> resultado_laboratorio = $_POST["resultado_laboratorio"];
	$guardarLaboratorio -> fecha_resultado = $_POST["fecha_resultado"];
	$guardarLaboratorio -> id_ficha = $_POST["id_ficha"];

	$guardarLaboratorio -> id_establecimiento = $_POST["id_establecimiento"];
	$guardarLaboratorio -> cod_asegurado = $_POST["cod_asegurado"];
	$guardarLaboratorio -> cod_afiliado = $_POST["cod_afiliado"];
	$guardarLaboratorio -> cod_empleador = $_POST["cod_empleador"];
	$guardarLaboratorio -> nombre_empleador = $_POST["nombre_empleador"];
	$guardarLaboratorio -> paterno = $_POST["paterno"];
	$guardarLaboratorio -> materno = $_POST["materno"];
	$guardarLaboratorio -> nombre = $_POST["nombre"];
	$guardarLaboratorio -> id_departamento = $_POST["id_departamento"];
	$guardarLaboratorio -> documento_ci = $_POST["documento_ci"];
	$guardarLaboratorio -> sexo = substr($_POST["sexo"], 0, 1);
	$guardarLaboratorio -> fecha_nacimiento = $_POST["fecha_nacimiento"];
	$guardarLaboratorio -> telefono = $_POST["telefono"];
	$guardarLaboratorio -> email = $_POST["email"];
	$guardarLaboratorio -> id_localidad = $_POST["id_localidad"];
	$guardarLaboratorio -> zona = $_POST["zona"];
	$guardarLaboratorio -> calle = $_POST["calle"];
	$guardarLaboratorio -> nro_calle = $_POST["nro_calle"];
	$guardarLaboratorio -> id_usuario = $_POST["id_usuario"];
	$guardarLaboratorio -> foto = $_POST["foto"];
	$guardarLaboratorio -> ajaxGuardarLaboratorioControl();

}

if (isset($_POST["guardarLaboratorioControl2"])) {

}

