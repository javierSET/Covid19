<?php

require_once "../controladores/asegurados.controlador.php";
require_once "../modelos/asegurados.modelo.php";

require_once "../controladores/empleadores.controlador.php";
require_once "../modelos/empleadores.modelo.php";

require_once "../controladores/seguros.controlador.php";
require_once "../modelos/seguros.modelo.php";

require_once "../controladores/localidades.controlador.php";
require_once "../modelos/localidades.modelo.php";

require_once "../controladores/ocupaciones.controlador.php";
require_once "../modelos/ocupaciones.modelo.php";

class TablaAsegurados {

	/*=============================================
	MOSTRAR LA TABLA DE ASEGURADOS
	=============================================*/
		
	public function mostrarTablaAsegurados() {

		$item = null;
		$valor = null;

		$asegurados = ControladorAsegurados::ctrMostrarAsegurados($item, $valor);

		if ($asegurados == null) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
			"data": [';

			for ($i = 0; $i < count($asegurados); $i++) { 

				/*=============================================
				TRAEMOS LA EMPRESA
				=============================================*/

				$itemEmpleador = "id";
				$valorEmpleador = $asegurados[$i]["id_empleador"];

				$Empleadores = ControladorEmpleadores::ctrMostrarEmpleadores($itemEmpleadore, $valorEmpresa);

				/*=============================================
				TRAEMOS EL TIPO DE SEGURO
				=============================================*/

				$itemSeguro = "id";
				$valorSeguro = $asegurados[$i]["id_seguro"];

				$seguros = ControladorSeguros::ctrMostrarSeguros($itemSeguro, $valorSeguro);

				/*=============================================
				TRAEMOS LAS LOCALIDADES
				=============================================*/

				$itemLocalidad = "id";
				$valorLocalidad = $asegurados[$i]["id_localidad"];

				$localidades = ControladorLocalidades::ctrMostrarLocalidades($itemLocalidad, $valorLocalidad);	

				/*=============================================
				TRAEMOS LAS OCUPACIONES
				=============================================*/

				$itemOcupacion = "id";
				$valorOcupacion = $asegurados[$i]["id_ocupacion"];

				$ocupaciones = ControladorOcupaciones::ctrMostrarOcupaciones($itemOcupacion, $valorOcupacion);				

				/*=============================================
				TRAEMOS LAS ACCIONES
				=============================================*/

				$botones1 = "<div class='btn-group'><button class='btn btn-info btnAgregarBeneficiario' idAsegurado='".$asegurados[$i]["id"]."' data-toggle='tooltip' title='Agregar Beneficiario'><i class='fas fa-check'></i></button></div>";

				$botones2 = "<div class='btn-group'><button class='btn btn-warning btnEditarEmpleador' idAsegurado='".$asegurados[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btnEliminarAsegurado' idAsegurado='".$asegurados[$i]["id"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-times'></i></button></div>";

				$datosJson .='[
					"'.$botones1.'",	
					"'.$empleadores["razon_social"].'",			
					"'.$seguros["tipo_seguro"].'",	
					"'.$asegurados[$i]["matricula"].'",
					"'.$asegurados[$i]["documento_ci"].'",
					"'.$asegurados[$i]["paterno"].' '.$asegurados[$i]["materno"].' '.$asegurados[$i]["nombre"].'",
					"'.$asegurados[$i]["sexo"].'",
					"'.$asegurados[$i]["fecha_nacimiento"].'",
					"'.$Localidades["nombre_localidad"].'",
					"'.$asegurados[$i]["zona"].'",
					"'.$asegurados[$i]["calle"].' '.$asegurados[$i]["nro_calle"].'",
					"'.$asegurados[$i]["salario"].'",
					"'.$ocupaciones["nombre_ocupacion"].'",
					"'.$asegurados[$i]["fecha_ingreso"].'",
					"'.$asegurados[$i]["estado"].'",
					"'.$botones2.'"
				],';
			}

			$datosJson = substr($datosJson, 0, -1);

			$datosJson .= ']
			}';	

		}

		echo $datosJson;
	
	}

}

/*=============================================
ACTIVAR TABLA DE ASEGURADOS
=============================================*/

$activarAsegurados = new TablaAsegurados();
$activarAsegurados -> mostrarTablaAsegurados();