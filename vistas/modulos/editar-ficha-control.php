<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            FICHA CONTROL Y SEGUIMIENTO <br> SOLICITUD DE ESTUDIOS DE LABORATORIO COVID-19

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Editar Ficha Control COVID-19</li>

          </ol>

        </div>

      </div>

    </div>

  </div>
  
  <section class="content">

    <form id="fichaControlCentro">

      <div class="form-row">

        <div class="form-inline col-md-10">

          Todos los campos con <span class="text-danger mx-2 font-weight-bold"> * </span> son obligatorios

        </div>

      </div>

      <!--=============================================
      SECCION 1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR
      =============================================-->  

      <?php

        $item = "id_ficha";
        $valor = $_GET["idFicha"];

        $ficha = ControladorFichas::ctrMostrarFichas($item, $valor);

        /*=============================================
        TRAEMOS LOS DATOS DE ESTABLECIMIENTO
        =============================================*/

        $item = "id";
        $valor = $ficha["id_establecimiento"];

        $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

        /*=============================================
        TRAEMOS LOS DATOS DE CONSULTORIO
        =============================================*/

        $item = "id";
        $valor = $ficha["id_consultorio"];

        $consultorios = ControladorConsultorios::ctrMostrarConsultorios($item, $valor);

       /*=============================================
        TRAEMOS LOS DATOS DE DEPARTAMENTO
        =============================================*/

        $item = "id";
        $valor = $ficha["id_departamento"];

        $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

        /*=============================================
        TRAEMOS LOS DATOS DE LOCALIDAD
        =============================================*/

        $item = "id";
        $valor = $ficha["id_localidad"];

        $localidades = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);

      ?>

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>1. DATOS DEL ESTABLECIMIENTO NOTIFICADOR</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">

            <div class="col-md-10">

            </div>

            <div class="form-inline col-md-2">

              <h5 class="text-dark">COD. FICHA: <?= $_GET["idFicha"] ?></h5>

            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">

              <label class="m-0 font-weight-normal" for="nuevoEstablecimiento">Establecimiento de Salud / Centro Aislamiento<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoEstablecimiento" id="nuevoEstablecimiento">
                <option value="<?= $establecimientos['id']?>"><?= $establecimientos["nombre_establecimiento"]?></option>
                <?php 

                  $item = null;
                  $valor = null;

                  $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

                  foreach ($establecimientos as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre_establecimiento"].'</option>';
                  } 

                ?>
              </select>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoConsultorio">Consultorio</label>
              <select class="form-control form-control-sm" name="nuevoConsultorio" id="nuevoConsultorio" disabled>
                <option value="<?= $consultorios['id']?>"><?= $consultorios["nombre_consultorio"]?></option>
                <?php 

                  $item = null;
                  $valor = null;

                  $consultorios = ControladorConsultorios::ctrMostrarConsultorios($item, $valor);

                  foreach ($consultorios as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre_consultorio"].'</option>';
                  } 

                ?>
              </select>

            </div>            
            
          </div>

          <div class="form-row">

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoDepartamento">Departamento<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoDepartamento" id="nuevoDepartamento">
                <option value="<?= $departamentos['id']?>"><?= $departamentos["nombre_depto"]?></option>
                <?php 

                  $item = null;
                  $valor = null;

                  $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

                  foreach ($departamentos as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre_depto"].'</option>';
                  }
                   
                ?>
              </select>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoLocalidad">Localidad<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoLocalidad" id="nuevoLocalidad" required>
                <option value="<?= $localidades['id']?>"><?= $localidades["nombre_localidad"]?></option>
                <?php 

                  $item = null;
                  $valor = null;

                  $localidades = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);

                  foreach ($localidades as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["nombre_localidad"].'</option>';
                  } 
                ?>
              </select>

            </div> 

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoFechaNotificacion">Fecha de Notificación<span class="text-danger font-weight-bold"> *</span></label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaNotificacion" id="nuevoFechaNotificacion" value="<?= $ficha['fecha_notificacion'] ?>">

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoNroControl">Control<span class="text-danger"> *</span></label>
              <select class="form-control form-control-sm col-md-6" name="nuevoNroControl" id="nuevoNroControl">
                <option value="<?= $ficha['nro_control'] ?>"><?= $ficha['nro_control'] ?></option>
                <?php 

                  if ($ficha['nro_control'] == "1°") {

                    echo 
                    '<option value="2°">2°</option>
                    <option value="3°">3°</option>
                    <option value="4°">4°</option>';
                    
                  } else if ($ficha['nro_control'] == "2°") {
                    
                    echo 
                    '<option value="1°">1°</option>
                    <option value="3°">3°</option>
                    <option value="4°">4°</option>';

                  } else if ($ficha['nro_control'] == "3°") {
                    
                    echo 
                    '<option value="1°">1°</option>
                    <option value="2°">2°</option>
                    <option value="4°">4°</option>';

                  } else {
                    
                    echo 
                    '<option value="1°">1°</option>
                    <option value="2°">2°</option>
                    <option value="3°">3°</option>
                    <option value="4°">4°</option>';

                  }

                ?>    
              </select>

            </div>
            
          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 2. IDENTIFICACION DEL CASO/PACIENTE
      =============================================--> 

      <?php

        $item = "id_ficha";
        $valor = $_GET["idFicha"];

        $pacienteAsegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados($item, $valor);

      ?>

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>2. IDENTIFICACION DEL CASO/PACIENTE</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">
            
            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoCodAsegurado">Cod. Asegurado<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" id="nuevoCodAsegurado" name="nuevoCodAsegurado" data-toggle="modal" data-target="#modalCodAsegurado" data-dismiss="modal">

                <option value="<?php echo $pacienteAsegurado['cod_asegurado']?>"><?php echo $pacienteAsegurado['cod_asegurado']?></option>

              </select>

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoCodAfiliado">Cod. Afiliado</label>
              <input type="text" class="form-control form-control-sm" name="nuevoCodAfiliado" id="nuevoCodAfiliado" value="<?= $pacienteAsegurado['cod_afiliado'] ?>" readonly>

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoCodEmpleador">Cod. Empleador</label>
              <input type="text" class="form-control form-control-sm" name="nuevoCodEmpleador" id="nuevoCodEmpleador" value="<?= $pacienteAsegurado['cod_empleador'] ?>" readonly>

            </div>

            <div class="form-group col-md-6">

              <label class="m-0 font-weight-normal" for="nuevoNombreEmpleador">Nombre Empleador(s)</label>
              <input type="text" class="form-control form-control-sm" name="nuevoNombreEmpleador" id="nuevoNombreEmpleador" value="<?= $pacienteAsegurado['nombre_empleador'] ?>" readonly>

            </div>

          </div>

          <div class="form-row">
            
            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoPaternoPaciente">Ap. Paterno</label>
              <input type="text" class="form-control form-control-sm" name="nuevoPaternoPaciente" id="nuevoPaternoPaciente" value="<?= $pacienteAsegurado['paterno'] ?>" readonly>

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoMaternoPaciente">Ap. Materno</label>
              <input type="text" class="form-control form-control-sm" name="nuevoMaternoPaciente" id="nuevoMaternoPaciente" value="<?= $pacienteAsegurado['materno'] ?>" readonly>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoNombrePaciente">Nombre(s)</label>
              <input type="text" class="form-control form-control-sm" name="nuevoNombrePaciente" id="nuevoNombrePaciente" value="<?= $pacienteAsegurado['nombre'] ?>" readonly>

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoSexoPaciente">Sexo<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoSexoPaciente" id="nuevoSexoPaciente">
              <?php 

                if ($pacienteAsegurado['sexo'] == "F") {

                  echo '
                  <option value="F">FEMENINO</option>
                  <option value="M">MASCULINO</option>';
                  
                } else {
                  
                  echo '
                  <option value="M">MASCULINO</option>
                  <option value="F">FEMENINO</option>';

                }

              ?>   
              </select>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoNroDocumentoPaciente">Nro. Documento<span class="text-danger font-weight-bold"> *</span></label>
              <input class="form-control form-control-sm" name="nuevoNroDocumentoPaciente" id="nuevoNroDocumentoPaciente" value="<?= $pacienteAsegurado['nro_documento'] ?>">

            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoFechaNacPaciente">Fecha de Nacimiento</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaNacPaciente" id="nuevoFechaNacPaciente" value="<?= $pacienteAsegurado['fecha_nacimiento'] ?>" readonly>

            </div>

            <div class="form-group col-md-1">

              <label class="m-0 font-weight-normal" for="nuevoEdadPaciente">Edad</label>
              <input type="text" class="form-control form-control-sm" name="nuevoEdadPaciente" id="nuevoEdadPaciente" value="<?= $pacienteAsegurado['edad'] ?>" readonly>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoTelefonoPaciente">Teléfono</label>
              <input type="text" class="form-control form-control-sm" name="nuevoTelefonoPaciente" id="nuevoTelefonoPaciente" data-inputmask="'mask': '9{7,8}'" value="<?= $pacienteAsegurado['telefono'] ?>">

            </div>

          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 3. SEGUIMIENTO
      =============================================-->  

      <?php

        $item = "id_ficha";
        $valor = $_GET["idFicha"];

        $hospitalizaciones_aislamientos = ControladorHospitalizacionesAislamientos::ctrMostrarHospitalizacionesAislamientos($item, $valor);

      ?>  

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>3. SEGUIMIENTO</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">
            
            <div class="form-group col-md-5">

              <label class="m-0" for="nuevoDiasNotificacion">¿Han pasado 14 días desde la notificación?<span class="text-danger"> *</span></label>
              <select class="form-control form-control-sm col-md-4" name="nuevoDiasNotificacion" id="nuevoDiasNotificacion">
                <?php 

                if ($hospitalizaciones_aislamientos['dias_notificacion'] == "SI") {

                  echo 
                  '<option value="'.$hospitalizaciones_aislamientos['dias_notificacion'].'">'.$hospitalizaciones_aislamientos['dias_notificacion'].'</option>
                  <option value="NO">NO</option>';
                  
                } else if ($hospitalizaciones_aislamientos['dias_notificacion'] == "NO") {
                  
                  echo 
                  '<option value="'.$hospitalizaciones_aislamientos['dias_notificacion'].'">'.$hospitalizaciones_aislamientos['dias_notificacion'].'</option>
                  <option value="SI">SI</option>';

                } else {

                  echo 
                  '<option value="">Elegir...</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>';

                }

                ?>  
              </select>

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoDiasSinSintomas">N° de días SIN sintomas</label>
              <input type="number" class="form-control form-control-sm mayuscula" name="nuevoDiasSinSintomas" id="nuevoDiasSinSintomas" value="<?= $hospitalizaciones_aislamientos['dias_sin_sintomas'] ?>">

            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoFechaAislamiento">Fecha de Aislamiento</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaAislamiento" id="nuevoFechaAislamiento" value="<?= $hospitalizaciones_aislamientos['fecha_aislamiento'] ?>">

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoLugarAislamiento">Lugar de Aislamiento</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoLugarAislamiento" id="nuevoLugarAislamiento" value="<?= $hospitalizaciones_aislamientos['lugar_aislamiento'] ?>">

            </div>

            <div class="form-group col-md-2">
              
            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoFechaInternacion">Fecha de Internación</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaInternacion" id="nuevoFechaInternacion" value="<?= $hospitalizaciones_aislamientos['fecha_internacion'] ?>">

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoEstablecimientoInternacion">Establecimiento de salud de internación</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoEstablecimientoInternacion" id="nuevoEstablecimientoInternacion" value="<?= $hospitalizaciones_aislamientos['establecimiento_internacion'] ?>">

            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoFechaIngresoUTI">Fecha de Ingreso a UTI</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaIngresoUTI" id="nuevoFechaIngresoUTI" value="<?= $hospitalizaciones_aislamientos['fecha_ingreso_UTI'] ?>">

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoLugarIngresoUTI">Lugar de UTI</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoLugarIngresoUTI" id="nuevoLugarIngresoUTI" value="<?= $hospitalizaciones_aislamientos['lugar_ingreso_UTI'] ?>">

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoVentilacionMecanica">Ventilación mecánica<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm col-md-6" name="nuevoVentilacionMecanica" id="nuevoVentilacionMecanica">
          
                <?php 

                if ($hospitalizaciones_aislamientos['ventilacion_mecanica'] == "SI") {

                  echo 
                  '<option value="'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'">'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'</option>
                  <option value="NO">NO</option>';
                  
                } else if ($hospitalizaciones_aislamientos['ventilacion_mecanica'] == "NO") {
                  
                  echo 
                  '<option value="'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'">'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'</option>
                  <option value="SI">SI</option>';

                } else {

                  echo 
                  '<option value="">Elegir...</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>';

                }

                ?>   
              </select>

            </div>

          </div>

          <div class="form-row">

          <?php

            // Descomponiendo el string de malestares
            $tratamiento = explode(",", $hospitalizaciones_aislamientos['tratamiento']);
            // var_dump($tratamiento);
            // var_dump(count($tratamiento));
          ?>

            <div class="icheck-silver mr-5">

              <label class="font-weight">Tratamiento</label>

            </div>

            <div class="icheck-silver mr-5">

            <?php 
              $j = 0;
              for($i = 0; $i < count($tratamiento); $i++) {
                
                if ($tratamiento[$i] == "ANTIVIRAL") {

                  echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIVIRAL" id="nuevoAntiviral" checked>';

                  break;

                } else {

                  $j++;

                  if ($j == count($tratamiento)) {

                    echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIVIRAL" id="nuevoAntiviral">';

                  }

                }

              }
            ?>
              
              <label class="font-weight-normal" for="nuevoAntiviral">Antiviral</label>

            </div>

            <div class="icheck-silver mr-5">

            <?php 
              $j = 0;
              for($i = 0; $i < count($tratamiento); $i++) {
                
                if ($tratamiento[$i] == "ANTIBIÓTICO") {

                  echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIBIÓTICO" id="nuevoAntibiotico" checked>';

                  break;

                } else {

                  $j++;

                  if ($j == count($tratamiento)) {

                    echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIBIÓTICO" id="nuevoAntibiotico">';

                  }

                }

              }
            ?>
              
              <label class="font-weight-normal" for="nuevoAntibiotico">Antibiótico</label>

            </div>

            <div class="icheck-silver mr-5">

            <?php 
              $j = 0;
              for($i = 0; $i < count($tratamiento); $i++) {
                
                if ($tratamiento[$i] == "ANTIPARASITARIO") {

                  echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIPARASITARIO" id="nuevoAntiparasitario" checked>';

                  break;

                } else {

                  $j++;

                  if ($j == count($tratamiento)) {

                    echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIPARASITARIO" id="nuevoAntiparasitario">';

                  }

                }

              }
            ?>
              
              <label class="font-weight-normal" for="nuevoAntiparasitario">Antiparasitario</label>

            </div>

            <div class="icheck-silver mr-5">

            <?php 
              $j = 0;
              for($i = 0; $i < count($tratamiento); $i++) {
                
                if ($tratamiento[$i] == "ANTIFLAMATORIO") {

                  echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIFLAMATORIO" id="nuevoAntiflamatorio" checked>';

                  break;

                } else {

                  $j++;

                  if ($j == count($tratamiento)) {

                    echo '<input type="checkbox" name="nuevoTratamiento" value="ANTIFLAMATORIO" id="nuevoAntiflamatorio">';

                  }

                }

              }
            ?>
              
              <label class="font-weight-normal" for="nuevoAntiflamatorio">Antiflamatorio</label>

            </div>

            <div class="form-inline col-md-3">

              <label class="my-0 mr-2 font-weight-normal" for="nuevoTratamientoOtros">Otros</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoTratamientoOtros" name="nuevoTratamientoOtros" value="<?= $hospitalizaciones_aislamientos['tratamiento_otros'] ?>"> 

            </div>

          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 4. LABORATORIO
      =============================================-->  

      <?php

        $item = "id_ficha";
        $valor = $_GET["idFicha"];

        $laboratorios = ControladorLaboratorios::ctrMostrarLaboratorios($item, $valor);

      ?>  

      <div class="card mb-0 fichaControlLaboratorio">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>8. LABORATORIO</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">

            <div class="form-group col-md-3">
            
              <label class="m-0" for="nuevoTipoMuestra">Tipo de muestra tomada<span class="text-danger font-weight-bold"> *</span></label> 
              <input list="tipoMuestra" class="form-control form-control-sm mayuscula" id="nuevoTipoMuestra" name="nuevoTipoMuestra" value="<?= $laboratorios['tipo_muestra'] ?>">
              <datalist id="tipoMuestra">
                <option value="ASPIRADO"></option>
                <option value="LAVADO BRONCO ALVELAR"></option>
                <option value="HISOPADO NASOFARÍNGEO"></option>
                <option value="HISOPADO COMBINADO"></option>
              </datalist>              

            </div>

            <div class="form-group col-md-3">

              <label class="my-0 mr-2 font-weight-normal" for="nuevoNombreLaboratorio">Nombre de Lab. que procesara la muestra</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoNombreLaboratorio" name="nuevoNombreLaboratorio" value="<?= $laboratorios['nombre_laboratorio'] ?>" readonly> 

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoFechaMuestra">Fecha de toma de muestra<span class="text-danger font-weight-bold"> *</span></label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaMuestra" id="nuevoFechaMuestra" value="<?= $laboratorios['fecha_muestra'] ?>">

            </div>

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoFechaEnvio">Fecha de Envío<span class="text-danger"> *</span></label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaEnvio" id="nuevoFechaEnvio" value="<?= $laboratorios['fecha_envio'] ?>">

            </div>
            
          </div>

          <div class="form-row">

            <div class="form-group col-md-2">

              <label class="m-0 font-weight-normal" for="nuevoCodLaboratorio">Cod. Laboratorio<span class="text-danger font-weight-bold"> *</span></label>
              <input type="text" class="form-control form-control-sm" name="nuevoCodLaboratorio" id="nuevoCodLaboratorio" value="<?= $laboratorios['cod_laboratorio'] ?>" readonly>

            </div>

            <div class="form-group col-md-4">

              <label class="my-0 mr-2 font-weight-normal" for="nuevoResponsableMuestra">Responsable de Toma de Muestra<span class="text-danger font-weight-bold"> *</span></label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoResponsableMuestra" id="nuevoResponsableMuestra" value="<?= $laboratorios['responsable_muestra'] ?>">

              <!-- <select class="form-control form-control-sm" name="nuevoResponsableMuestra" id="nuevoResponsableMuestra">
              <option value="">Elegir...</option>
              <?php 

                // $item = null;
                // $valor = null;

                // $paises = ControladorResponsablesMuestras::ctrMostrarResponsablesMuestras($item, $valor);

                // foreach ($paises as $key => $value) {
                  
                //   echo '<option value="'.$value["id"].'">'.$value["paterno_responsable"].' '.$value["materno_responsable"].' '.$value["nombre_responsable"].'</option>';
                // } 
              ?>
              </select> -->

            </div>

            <div class="form-group col-md-6">

              <label class="my-0 mr-2 font-weight-normal" for="nuevoObsMuestra">Observaciones</label>
              <input type="text" class="form-control form-control-sm" id="nuevoObsMuestra" name="nuevoObsMuestra" value="<?= $laboratorios['observaciones_muestra'] ?>" readonly> 

            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">

              <label class="my-0 mr-2 font-weight-normal" for="nuevoResultadoLaboratorio">Resultados Laboratorio<span class="text-danger font-weight-bold"> *</span></label>
            
              <?php

              if ($laboratorios['resultado_laboratorio'] == "POSITIVO") {

              echo '
              <div class="icheck-danger icheck">
                <input type="radio" name="nuevoResultadoLaboratorio" id="positivo" value="POSITIVO" checked disabled>
                <label for="positivo">
                  POSITIVO
                </label>
              </div>
              <div class="icheck-success icheck-inline">
                <input type="radio" name="nuevoResultadoLaboratorio" id="negativo" value="NEGATIVO" disabled>
                <label for="negativo">
                  NEGATIVO
                </label>
              </div>';

              } else if ($laboratorios['resultado_laboratorio'] == "NEGATIVO") {

              echo '
              <div class="icheck-danger icheck">
                <input type="radio" name="nuevoResultadoLaboratorio" id="positivo" value="POSITIVO" disabled>
                <label for="positivo">
                  POSITIVO
                </label>
              </div>
              <div class="icheck-success icheck-inline">
                <input type="radio" name="nuevoResultadoLaboratorio" id="negativo" value="NEGATIVO" checked disabled>
                <label for="negativo">
                  NEGATIVO
                </label>
              </div>';

              } else {

                echo 
                '<div class="icheck-danger icheck">
                  <input type="radio" name="nuevoResultadoLaboratorio" id="positivo" value="POSITIVO" disabled>
                  <label for="positivo">
                    POSITIVO
                  </label>
                </div>
                <div class="icheck-success icheck-inline">
                  <input type="radio" name="nuevoResultadoLaboratorio" id="negativo" value="NEGATIVO" disabled>
                  <label for="negativo">
                    NEGATIVO
                  </label>
                </div>';

              }

              ?>      

            </div>

            <div class="form-group col-md-3">

              <label class="my-0 mr-2 font-weight-normal" for="nuevoFechaResultado">Fecha de Resultado<span class="text-danger font-weight-bold"> *</span></label>
              <input type="date" class="form-control form-control-sm" id="nuevoFechaResultado" name="nuevoFechaResultado" value="<?= $laboratorios['fecha_resultado'] ?>"  readonly> 

            </div>

          </div>        

        </div>

      </div>

      <!--=============================================
      SECCION PERSONAL QUE NOTIFICA
      =============================================-->  

      <?php

        $item = "id_ficha";
        $valor = $_GET["idFicha"];

        $persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item, $valor);

      ?>  

      <div class="card mb-0">

        <div class="card-body">

          <div class="form-row">
            
            <label class="my-0 mr-2 font-weight-normal">DATOS DEL PERSONAL QUE NOTIFICA:</label>

          </div>

          <div class="form-row">

            <div class="form-group col-md-2">
            
              <label class="my-0 mr-2 font-weight-normal" for="nuevoPaternoNotif">Ap. Paterno</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoPaternoNotif" name="nuevoPaternoNotif" value="<?= $persona_notificador['paterno_notificador'] ?>"> 

            </div>

            <div class="form-group col-md-2">
            
              <label class="my-0 mr-2 font-weight-normal" for="nuevoMaternoNotif">Ap. Materno</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoMaternoNotif" name="nuevoMaternoNotif" value="<?= $persona_notificador['materno_notificador'] ?>"> 

            </div>

            <div class="form-group col-md-3">
            
              <label class="my-0 mr-2 font-weight-normal" for="nuevoNombreNotif">Ap. Nombre(s)<span class="text-danger font-weight-bold"> *</span></label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoNombreNotif" name="nuevoNombreNotif" value="<?= $persona_notificador['nombre_notificador'] ?>"> 

            </div>

            <div class="form-group col-md-2">
            
              <label class="my-0 mr-2 font-weight-normal" for="nuevoTelefonoNotif">Tel. cel</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoTelefonoNotif" name="nuevoTelefonoNotif" data-inputmask="'mask': '9{7,8}'" value="<?= $persona_notificador['telefono_notificador'] ?>"> 

            </div>

            <div class="form-group col-md-3">
            
              <label class="my-0 mr-2 font-weight-normal" for="nuevoCargoNotif">Cargo</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoCargoNotif" name="nuevoCargoNotif" value="<?= $persona_notificador['cargo_notificador'] ?>"> 

            </div>

          </div>
          
        </div>

        <div class="card-footer">

          <div class="float-right">

            <input type="hidden" id="idFicha" value="<?= $_GET["idFicha"] ?>">

            <button type="button" class="btn btn-primary btnGuardar">

              <i class="fas fa-save"></i>
              Guardar

            </button>

          </div>
          
        </div>

      </div>

    </form>

  </section>
  
</div>


<!--=====================================
MODAL SELECCIONAR ASEGURADO
======================================-->

<div id="modalCodAsegurado" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="CodAsegurado" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->

      <div class="modal-header bg-gradient-info">

        <h5 class="modal-title" id="modificarUsuario">Buscar Asegurado</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

      </div>

      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->

      <div class="modal-body">

        <div class="form-row">

          <div class="input-group col-md-3"></div>
          
          <div class="input-group col-md-9">

            <span class="mt-2 mr-2">Buscar:</span>
            
            <input type="text" class="form-control mr-2" id="buscardorAfiliadosFichas" placeholder="Ingrese Apellidos o Nombre(s) o Codigo Asegurado.">

            <button type="button" class="btn btn-primary px-2 btnBuscarAfiliadoFichas">
          
              <i class="fas fa-search"></i> Buscar
            
            </button>  

          </div>     

        </div>
 
        <!--=====================================
        SE MUESTRA LAS TABLAS GENERADAS
        ======================================-->            

        <div id="tblAfiliadosSIAISFichas" class="mt-4">   

                  
        </div>

      </div>

    </div>

  </div>

</div>
