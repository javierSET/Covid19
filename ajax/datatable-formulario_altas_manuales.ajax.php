<?php

require_once "../controladores/formulario_alta_manual.controlador.php";
require_once "../modelos/formulario_altas_manual.modelo.php";

require_once "../controladores/pacientes_asegurados.controlador.php";
require_once "../modelos/pacientes_asegurados.modelo.php";

class TablaFormularioAltasManuales {

	public $request;

	/*=============================================
	MOSTRAR LA TABLA DE DE AFILIADOS CON RESULTADOS DE LABORATORIO COVID
	=============================================*/
		
	public function mostrarTablaFormularioAltasManuales() {

		session_start();

		$col = array(
			0 => 'cod_asegurado',
			1 => 'nombre_completo',
			2 => 'nro_documento'
		);
		
		$sql="";
		if(!empty($request['search']['value'])){
			$sql .= "AND (cod_asegurado like '".$request['search']['value']."%' ";
			$sql .= "OR nombre_completo like".$request['search']['value']."%' ";
			$sql .= "OR nro_documento like".$request['search']['value']."%' ";
		}

		$formularioAltasManuales = ControladorFormularioAltasManual::ctrMostrarFormularioAltaManual(null, null);

		$datosJson = array();
		for ($i = 0; $i < count($formularioAltasManuales); $i++) {

			$pacienteAsegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados("id",$formularioAltasManuales[$i]["id_pacientes_asegurados"]);			
			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/
			$botonImprimir = "<button class='btn btn-info btnImprimirFormularioAltaManual' idFormularioAltaManual='".$formularioAltasManuales[$i]["id"]."' idPacienteAsegurado='".$pacienteAsegurado["id"]."' nombreAsegurado='".$pacienteAsegurado["nombre"]."' apellidoPaterno='".$pacienteAsegurado["paterno"]."' apellidoMaterno='".$pacienteAsegurado["materno"]."' ciAsegurado='".$pacienteAsegurado["nro_documento"]."' zona='".$pacienteAsegurado["zona"]."' calle='".$pacienteAsegurado["calle"]."' nro_calle='".$pacienteAsegurado["nro_calle"]."' codEmpleador='".$pacienteAsegurado["cod_empleador"]."' nombreEmpleador='".$pacienteAsegurado["nombre_empleador"]."' codAfiliado='".$pacienteAsegurado["cod_afiliado"]."' matriculaAsegurado='".$pacienteAsegurado["cod_asegurado"]."' tipoMuestra='".$formularioAltasManuales[$i]["prueba_diagnostica"]."' fecha_resultado='".$formularioAltasManuales[$i]["fecha_resultado"]."' establecimiento_resultado='".$formularioAltasManuales[$i]["establecimiento_resultado"]."' dias='".$formularioAltasManuales[$i]["dias_baja"]."' fecha_ini='".$formularioAltasManuales[$i]["fecha_ini"]."' fecha_fin='".$formularioAltasManuales[$i]["fecha_fin"]."' resultado='".$formularioAltasManuales[$i]["resultado"]."' establecimiento_notificador ='".$formularioAltasManuales[$i]["establecimiento_notificador"]."'><i class='fas fa-print'></i></button>";
			$botonEditar = "<button class='btn btn-warning btnEditarFormularioAltaManual' idFormularioAltaManual='".$formularioAltasManuales[$i]["id"]."' idPacienteAsegurado='".$pacienteAsegurado["id"]."' nombreAsegurado='".$pacienteAsegurado["nombre"]."' apellidoPaterno='".$pacienteAsegurado["paterno"]."' apellidoMaterno='".$pacienteAsegurado["materno"]."' ciAsegurado='".$pacienteAsegurado["nro_documento"]."' zona='".$pacienteAsegurado["zona"]."' calle='".$pacienteAsegurado["calle"]."' nro_calle='".$pacienteAsegurado["nro_calle"]."' codEmpleador='".$pacienteAsegurado["cod_empleador"]."' nombreEmpleador='".$pacienteAsegurado["nombre_empleador"]."' tipoMuestra='".$formularioAltasManuales[$i]["prueba_diagnostica"]."' fecha_resultado='".$formularioAltasManuales[$i]["fecha_resultado"]."' establecimiento_resultado='".$formularioAltasManuales[$i]["establecimiento_resultado"]."' dias='".$formularioAltasManuales[$i]["dias_baja"]."' fecha_ini='".$formularioAltasManuales[$i]["fecha_ini"]."' fecha_fin='".$formularioAltasManuales[$i]["fecha_fin"]."' establecimiento_notificador ='".$formularioAltasManuales[$i]["establecimiento_notificador"]."' data-toggle='tooltip' title='Editar'><i class='fas fa-pencil-alt'></i></button>";
			$botonEliminar ="<button class='btn btn-danger btnEliminarFormularioAltaManual' idFormularioAltaManual='".$formularioAltasManuales[$i]["id"]."' imagen='' data-toggle='tooltip' title='Eliminar' data-code ='".$formularioAltasManuales[$i]["id_pacientes_asegurados"]."'><i class='fas fa-trash-alt'></i></button>";
			
			if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM" ) {
				$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar.$botonEliminar."</div>";
			}
			else if($_SESSION['perfilUsuarioCOVID'] == "MEDICO" ){
				$botones = "<div class='btn-group'>".$botonImprimir.$botonEditar."</div>";						
			} else {
				$botones = "<div class='btn-group'>".$botonImprimir."</div>";
			}
			$dataAlta = array();			
			$dataAlta[] = $pacienteAsegurado["cod_asegurado"];
			$dataAlta[] = $pacienteAsegurado["nombre"].' '.$pacienteAsegurado["paterno"].' '.$pacienteAsegurado["materno"];
			$dataAlta[] = $pacienteAsegurado["nombre_empleador"];
			$dataAlta[] = $pacienteAsegurado["cod_empleador"];
			$dataAlta[] = $formularioAltasManuales[$i]["resultado"];
			$dataAlta[] = $formularioAltasManuales[$i]["fecha_resultado"];
			$dataAlta[] = $formularioAltasManuales[$i]["establecimiento_resultado"];
			$dataAlta[] = $botones;
			array_push($datosJson,$dataAlta);		

		}

		$json_data = array(
		    "data"  =>  $datosJson
		);

		echo json_encode($json_data,JSON_UNESCAPED_UNICODE);
	}

}

/*=============================================
ACTIVAR TABLA DE FORMULARIOS DE BAJAS MANUALES
=============================================*/

$activarFormularioAltasManuales = new TablaFormularioAltasManuales();
$activarFormularioAltasManuales -> mostrarTablaFormularioAltasManuales();

/* REVISAR PARA OPTIMIZAR LA VISTA DE ALTAS MANUALES
SELECT ca.id,
		pa.cod_asegurado,
        pa.nombre,
        pa.paterno,
        pa.materno,
        pa.cod_empleador,pa.nombre_empleador,
        ca.resultado,ca.fecha_resultado,ca.establecimiento_resultado
FROM bdcovid19cnscb.certificado_alta_manual ca,
	bdfichaepidemiologicacnscb.pacientes_asegurados pa
WHERE ca.id_pacientes_asegurados = pa.id
ORDER BY ca.id DESC;

 */