<?php

require_once "../controladores/empleadoresSIAIS.controlador.php";
require_once "../modelos/empleadoresSIAIS.modelo.php";

class TablaEmpleadoresSIAIS {

	/*=============================================
	MOSTRAR LA TABLA DE EMPLEADORES DE LA BASE DE DATOS SIAIS
	=============================================*/
		
	public function mostrarTablaEmpleadoresSIAIS() {

		$item = null;
		$valor = null;

		$empleadores = ControladorEmpleadoresSIAIS::ctrMostrarEmpleadoresSIAIS($item, $valor);

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

					$botones = "<div class='btn-group'><button class='btn btn-info btnMostrarAfiliadosSIAIS' idEmpleador='".$empleadores[$i]["idempleador"]."' data-toggle='tooltip' title='Seleccionar Empleador'><i class='fas fa-check'></i></button></div>";
					
					$datosJson .='[
						"'.($i+1).'",					
						"'.$empleadores[$i]['emp_nro_empleador'].'",
						"'.$empleadores[$i]['emp_nro_padron'].'",
						"'.str_replace('"','\\"',$empleadores[$i]['emp_nombre']).'",
						"'.$empleadores[$i]['emp_telefono'].'",
						"'.$empleadores[$i]['act_nombre'].'",
						"'.date("d/m/Y", strtotime($empleadores[$i]['emp_fecha_iniciacion'])).'",
						"'.$botones.'"
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

$activarEmpleadoresSIAIS = new TablaEmpleadoresSIAIS();
$activarEmpleadoresSIAIS -> mostrarTablaEmpleadoresSIAIS();