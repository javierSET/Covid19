<?php

require_once "../controladores/empleadores.controlador.php";
require_once "../modelos/empleadores.modelo.php";

class TablaEmpleadores {

	/*=============================================
	MOSTRAR LA TABLA DE EMPLEADORES
	=============================================*/
		
	public function mostrarTablaEmpleadores() {

		$item = null;
		$valor = null;

		$empleadores = ControladorEmpleadores::ctrMostrarEmpleadores($item, $valor);

		if ($empleadores == null) {
			
			$datosJson = '{
				"data": []
			}';

		} else {

			$datosJson = '{
				"data": [';

				for ($i = 0; $i < count($empleadores); $i++) { 

					/*=============================================
					TRAEMOS LAS ACCIONES
					=============================================*/

					$botones1 = "<div class='btn-group'><button class='btn btn-info btnAgregarAsegurado' idEmpleador='".$empleadores[$i]["id"]."' data-toggle='tooltip' title='Agregar Asegurado'><i class='fas fa-check'></i></button></div>";

					$botones2 = "<div class='btn-group'><button class='btn btn-warning btnEditarEmpleador' idEmpleador='".$empleadores[$i]["id"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button><button class='btn btn-danger btnEliminarEmpleador' idEmpleador='".$empleadores[$i]["id"]."' data-toggle='tooltip' title='Eliminar'><i class='fas fa-times'></i></button></div>";

					
					$datosJson .='[
						"'.$botones1.'",					
						"'.$empleadores[$i]['nro_patronal'].'",
						"'.$empleadores[$i]['nit'].'",
						"'.str_replace('"','\\"',$empleadores[$i]['razon_social']).'",
						"'.$empleadores[$i]['fecha'].'",
						"'.$empleadores[$i]['estado'].'",
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
ACTIVAR TABLA EMPLEADORES
=============================================*/

$activarEmpleadores = new TablaEmpleadores();
$activarEmpleadores -> mostrarTablaEmpleadores();