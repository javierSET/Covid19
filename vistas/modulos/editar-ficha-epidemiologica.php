<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            FICHA EPIDEMIOLÓGICA Y SOLICITUD DE ESTUDIOS DE LABORATORIO COVID-19

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Editar Ficha Epidemiológica COVID-19</li>

          </ol>

        </div>

      </div>

    </div>

  </div>
  
  <section class="content">

    <form id="fichaEpidemiologicaCentro">

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
        $fichaBackup = $ficha;
        /*=============================================
        TRAEMOS LOS DATOS DE ESTABLECIMIENTO
        =============================================*/

        $item = "id";
        $valor = $ficha["id_establecimiento"];

        $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);
        $establecBackup = $establecimientos;

        /*=============================================
        TRAEMOS LOS DATOS DE CONSULTORIO
        =============================================*/

        $valor = $ficha["id_consultorio"];

        $consultorios = ControladorConsultorios::ctrMostrarConsultorios($item, $valor);
        $consultoriosBackup = $consultorios;
        /* echo "Estos son sus consultoriossssss:  ";
        var_dump($consultorios); retorna vacio */

        /*=============================================
        TRAEMOS LOS DATOS DEL CONSULTORIO M@RK
        =============================================*/
          
        $consultoriosDeFichaX = ControladorConsultorios::consultoriosDadoUnEstablecimiento("id_establecimiento", $establecBackup['id']);

       /*=============================================
        TRAEMOS LOS DATOS DE DEPARTAMENTO
        =============================================*/
        
        $valor = $ficha["id_departamento"];

        $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

        /*=============================================
        TRAEMOS LOS DATOS DE LOCALIDAD
        =============================================*/

        $item = $establecimientos["id"];        
        $valor = $ficha["id_ficha"];
        $localidades = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);
//        var_dump($localidades);
        
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

              <label class="m-0 font-weight-normal" for="nuevoEstablecimiento">Establecimiento de Salud<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoEstablecimiento" id="nuevoEstablecimiento"  >
              
                <?php 

                  $item = null;
                  $valor = null;

                  $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

                  foreach ($establecimientos as $key => $value) {
                    $consulPorEstablecimiento = ControladorConsultorios::consultoriosDadoUnEstablecimiento('id_establecimiento', $value["id"]);

                    //$data = json_encode($consulPorEstablecimiento);
                    //$data = $consulPorEstablecimiento;
                   // $data = "{'id_establecimiento':'1'}, {'nombre_consultorio':'Consultorio 2 E2'}";
                    $data2 = "";
                    foreach ($consulPorEstablecimiento as $index => $consultorio){
                             $data2 =  $data2."{'".$consultorio['id_establecimiento']."':'".$consultorio['nombre_consultorio']."'},";
                    }
                    //echo "MAR".$data2;
                    
                    if($fichaBackup['id_establecimiento'] == $value["id"]){
                        echo  '<option value="'.$value["id"].'" 
                                      data-codestablecimiento="'.$value["codigo_establecimiento"].'" 
                                      data-objectEstablecimiento="'.$data2.'"
                                      data-redsalud="'.$value["red_de_salud"].'"
                                      selected = "selected"

                              >'
                                      .$value["nombre_establecimiento"].
                            '</option>';
                            
                        $data2 = "";
                        $consulPorEstablecimiento = null;
                    }
                    else{

                        echo  '<option value="'.$value["id"].'" 
                              data-codestablecimiento="'.$value["codigo_establecimiento"].'" 
                              data-objectEstablecimiento="'.$data2.'"
                              data-redsalud="'.$value["red_de_salud"].'"
                              >'
                                      .$value["nombre_establecimiento"].
                            '</option>';
                            
                        $data2 = "";
                        $consulPorEstablecimiento = null;

                    }     
                    
                  } 

                ?>
              </select>

            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodEstablecimiento">Cod. Estab</label>
              <?php 
                  $codigoE = $establecBackup['codigo_establecimiento'];
                  if($codigoE == null){
                     $codigoE = "20300018";
                  }
                  
              ?>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoCodEstablecimiento" id="nuevoCodEstablecimiento" value="<?= $codigoE ?>" disabled>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoConsultorio">Consultorio</label>
              <select class="form-control form-control-sm" name="nuevoConsultorio" id="nuevoConsultorio">
                <?php
                   
                 // print_r($consultoriosDeFichaX);
                 
                 if(empty($consultoriosDeFichaX)){
                    $consultoriosDeFichaX = ControladorConsultorios::consultoriosDadoUnEstablecimiento("id_establecimiento", 1);
                 }
                 foreach ($consultoriosDeFichaX as $key => $value) {
                    
                    if($fichaBackup['id_establecimiento']  == $value['id_establecimiento'])
                      echo '<option value="'.$value['id'].'" selected="selected">'.$value['nombre_consultorio'].'</option>';
                    
                    else echo '<option value="'.$value['id'].'">'.$value['nombre_consultorio'].'</option>';
                      
                 }

                ?>
              </select>

            </div>

            <div class="form-group col-md-3">

              <label class="m-0 font-weight-normal" for="nuevoRedSalud">Red de Salud<span class="text-danger font-weight-bold"> *</span></label>
              <?php
                $redsalud= "CERCADO"; 
                
                if($fichaBackup['red_salud']){
                   $redsalud = $ficha['red_salud'];
                }
 
              ?>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoRedSalud" id="nuevoRedSalud" value="<?= $redsalud ?>" disabled>

            </div>
            
          </div>

          <div class="form-row">

              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="nuevoDepartamento">Departamento<span class="text-danger font-weight-bold"> *</span></label>
                <select class="form-control form-control-sm" name="nuevoDepartamento" id="nuevoDepartamento" disabled>
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

             <!--begin code M@rk-->
              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="municipio" >Municipio<span class="text-danger font-weight-bold"> *</span></label>
                <select class="form-control form-control-sm" name="municipio" id="municipio" required>
                <?php 

                   $item = null;
                   $valor = null;

                   $municipios = ControladorMunicipio::ctrMostrarMunicipio($item, $valor);

                   foreach ($municipios as $key => $value) {
                      if($fichaBackup["id_municipio"] == $value['id'])
                        echo '<option value="'.$value["id"].'" selected>'.$value["nombre_municipio"].'</option>';
                      else
                        echo '<option value="'.$value["id"].'">'.$value["nombre_municipio"].'</option>';
                   }
 
                ?>

                  <option value="1">COLCAPIRHUA</option>
                </select>

              </div>

              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="subsector" >SubSector<span class="text-danger font-weight-bold"> *</span></label>
                <select class="form-control form-control-sm" name="subsector" id="subsector" required disabled>
                       <option value="1">SEGURIDAD SOCIAL CNS</option>
                       <option value="2">PUBLICO</option>
                       <option value="3">PRIVADO</option>
                       <option value="4">OTRO</option>
                </select>

              </div>
             <!--end code M@rk-->               

          </div>

          <div class="form-row">

              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="nuevoFechaNotificacion">Fecha de Notificación<span class="text-danger font-weight-bold"> *</span></label>
                <input type="date" class="form-control form-control-sm" name="nuevoFechaNotificacion" id="nuevoFechaNotificacion" value="<?php echo date('Y-m-d',strtotime($fichaBackup['fecha_notificacion'])) ?>">

              </div>

              <div class="form-group col-md-2">

                <label class="m-0 font-weight-normal" for="nuevoSemEpidemiologica">Sem. Epidemiológica</label>
                <!--<input type="number" class="form-control form-control-sm" name="nuevoSemEpidemiologica" id="nuevoSemEpidemiologica" value="">-->
                <?php   $semana = $ficha['semana_epidemiologica'];   ?>
                <input type="number" class="form-control form-control-sm" name="nuevoSemEpidemiologica" id="nuevoSemEpidemiologica" value="<?= $semana ?>" readonly>

              </div>    

              <div class="form-group col-md-4">

                <label class="m-0 font-weight-normal " for="nuevoBusquedaActiva">Caso identificado por búsqueda activa<span class="text-danger font-weight-bold"> *</span></label> 
                <select class="form-control form-control-sm" name="nuevoBusquedaActiva" id="nuevoBusquedaActiva">
                <?php 

                  if ($ficha['busqueda_activa'] == "SI") {

                    echo '<option value="'.$ficha['busqueda_activa'].'">'.$ficha['busqueda_activa'].'</option>
                    <option value="NO">NO</option>';
                    
                  } else if ($ficha['busqueda_activa'] == "NO") {
                    
                    echo 
                    '<option value="'.$ficha['busqueda_activa'].'">'.$ficha['busqueda_activa'].'</option>
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

        if(!$pacienteAsegurado){
          $fichaP = ControladorFichas::ctrMostrarFichas('id_ficha',$valor);
          $pacienteAsegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id', $fichaP['id_paciente']);
        }

        /*=============================================
        TRAEMOS LOS DATOS DE DEPARTAMENTO
        =============================================*/

        $item = "id";
        $valor = $pacienteAsegurado["id_departamento_paciente"];

        $departamentos_paciente = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

        /*=============================================
        TRAEMOS LOS DATOS DE MUNICIPIO
        =============================================*/

        $valor = $pacienteAsegurado["id_municipio_paciente"];

        $localidades_paciente = ControladorMunicipio::ctrMostrarMunicipio($item, $valor);

        /*=============================================
        TRAEMOS LOS DATOS DE PAIS
        =============================================*/

        $valor = $pacienteAsegurado["id_pais_paciente"];

        $paises_paciente = ControladorPaises::ctrMostrarPaises($item, $valor);
      ?>

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>2. IDENTIFICACION DEL CASO/PACIENTE</span>
          
        </div>

        <div class="card-body">
          <div class="form-row">

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodAsegurado">Cod. Asegurado<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" id="nuevoCodAsegurado" name="nuevoCodAsegurado" data-toggle="modal" data-target="#modalCodAsegurado" data-dismiss="modal" disabled>
                <option value="<?= $pacienteAsegurado['cod_asegurado']?>"><?= $pacienteAsegurado['cod_asegurado']?></option>
              </select>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodAfiliado">Cod. Afiliado</label>
              <input type="text" class="form-control form-control-sm" name="nuevoCodAfiliado" id="nuevoCodAfiliado" value="<?= $pacienteAsegurado['cod_afiliado'] ?>" disabled>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodEmpleador">Cod. Empleador</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoCodEmpleador" id="nuevoCodEmpleador" value="<?= $pacienteAsegurado['cod_empleador'] ?>">
            </div>

            <div class="form-group col-md-5">
              <label class="m-0 font-weight-normal" for="nuevoNombreEmpleador">Nombre Empleador</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoNombreEmpleador" id="nuevoNombreEmpleador" value="<?= $pacienteAsegurado['nombre_empleador'] ?>">
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

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoNombrePaciente">Nombre(s)</label>
              <input type="text" class="form-control form-control-sm" name="nuevoNombrePaciente" id="nuevoNombrePaciente" value="<?= $pacienteAsegurado['nombre'] ?>" readonly>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoSexoPaciente">Sexo<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm mayuscula" name="nuevoSexoPaciente" id="nuevoSexoPaciente">
                  <option value="" <?php echo $pacienteAsegurado['sexo']=="" ? 'selected' : ''; ?>>Elegir</option>
                  <option value="F" <?php echo $pacienteAsegurado['sexo']=="F" ? 'selected' : ''; ?>>FEMENINO</option>
                  <option value="M" <?php echo $pacienteAsegurado['sexo']=="M" ? 'selected' : ''; ?>>MASCULINO</option>             
              </select>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoNroDocumentoPaciente">Nro. Documento<span class="text-danger font-weight-bold"> *</span></label>
              <input class="form-control form-control-sm mayuscula" name="nuevoNroDocumentoPaciente" id="nuevoNroDocumentoPaciente" value="<?= $pacienteAsegurado['nro_documento'] ?>">
            </div>
            <div class="form-group" style="padding-top: 26px;">              
              <i class="far fa-question-circle" id="btnInfoCi" style="color: #17a2b8;"></i>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoFechaNacPaciente">Fecha de Nacimiento</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaNacPaciente" id="nuevoFechaNacPaciente" value="<?= $pacienteAsegurado['fecha_nacimiento'] ?>">
            </div>

            <div class="form-group col-md-1">
              <label class="m-0 font-weight-normal" for="nuevoEdadPaciente">Edad</label>
              <input type="text" class="form-control form-control-sm" name="nuevoEdadPaciente" id="nuevoEdadPaciente" value="<?= $pacienteAsegurado['edad'] ?>" readonly>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="identificacionEtnica">Identificado Etnica<span class="text-danger font-weight-bold"> *</span></label> 
              <select class="form-control form-control-sm mayuscula" name="identificacionEtnica" id="identificacionEtnica"> 
                <option value="">Elegir</option>
                    <option value="Afrobolivianos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Afrobolivianos") ? 'selected':'' ?>>Afrobolivianos</option>
                    <option value="Guarasugwe Pauserna" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Guarasugwe Pauserna")? 'selected':'' ?>>Guarasugwe Pauserna</option>
                    <option value="Araonas" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Araonas")? 'selected':'' ?>>Araonas</option>
                    <option value="Aymaras" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Aymaras")? 'selected':'' ?>>Aymaras</option>
                    <option value="Ayoreos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Ayoreos")? 'selected':'' ?>>Ayoreos</option>
                    <option value="Baures" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Baures")? 'selected':'' ?>>Baures</option>
                    <option value="Canichana" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Canichana")? 'selected':'' ?>>Canichana</option>
                    <option value="Cavineños" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Cavineños")? 'selected':'' ?>>Cavineños</option>
                    <option value="Cayubabas" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Cayubabas")? 'selected':'' ?>>Cayubabas</option>
                    <option value="Chimanes" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Chimanes") ? 'selected':'' ?>>Chimanes</option>
                    <option value="Chiquitanos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Chiquitanos") ? 'selected':'' ?>>Chiquitanos</option>
                    <option value="Chacobo" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Chacobo") ? 'selected':'' ?>>Chacobo</option>
                    <option value="Esse Ejja" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Esse Ejja") ? 'selected':'' ?>>Esse Ejja</option>
                    <option value="Guaraníes" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Guaraníes") ? 'selected':'' ?>>Guaraníes</option>
                    <option value="Guarayos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Guarayos") ? 'selected':'' ?>>Guarayos</option>
                    <option value="Itonamas" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Itonamas") ? 'selected':'' ?>>Itonamas</option>
                    <option value="Joaquinianos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Joaquinianos") ? 'selected':'' ?>>Joaquinianos</option>
                    <option value="Lecos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Lecos") ? 'selected':'' ?>>Lecos</option>
                    <option value="Machineri" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Machineri") ? 'selected':'' ?>>Machineri</option>
                    <option value="More" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("More") ? 'selected':'' ?>>More</option>
                    <option value="Moseten" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Moseten") ? 'selected':'' ?>>Moseten</option>
                    <option value="Movima" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Movima") ? 'selected':'' ?>>Movima</option>
                    <option value="Moxeños" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Moxeños") ? 'selected':'' ?>>Moxeños</option>
                    <option value="Nahua" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Nahua") ? 'selected':'' ?>>Nahua</option>
                    <option value="Pacahuara" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Pacahuara") ? 'selected':'' ?>>Pacahuara</option>
                    <option value="Quechuas" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Quechuas") ? 'selected':'' ?>>Quechuas</option>
                    <option value="Reyesanos" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Reyesanos") ? 'selected':'' ?>>Reyesanos</option>
                    <option value="Sirionó" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Sirionó") ? 'selected':'' ?>>Sirionó</option>
                    <option value="Tacana" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Tacana") ? 'selected':'' ?>>Tacana</option>
                    <option value="Tapiete" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Tapiete") ? 'selected':'' ?>>Tapiete</option>
                    <option value="Toromona" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Toromona") ? 'selected':'' ?>>Toromona</option>
                    <option value="Urus" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Urus") ? 'selected':'' ?>>Urus</option>
                    <option value="Weenhayek" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Weenhayek") ? 'selected':'' ?>>Weenhayek</option>
                    <option value="Yaminahua" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Yaminahua") ? 'selected':'' ?>>Yaminahua</option>
                    <option value="Yuquis y Yuracare" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Yuquis y Yuracare") ? 'selected':'' ?>>Yuquis y Yuracare</option>
                    <option value="Yuquis y Yuracare" <?php echo  strtoupper($pacienteAsegurado['identificacion_etnica'])==strtoupper("Yuracare") ? 'selected':'' ?>>Yuracare</option>
              </select>
            </div>

            <div class="form-group col-md-3">
            <label class="m-0 font-weight-normal" for="nuevoDiscapacidad">Tiene Alguna Discapacidad? <span class="text-danger font-weight-bold"> *</span></label> 
              <select class="form-control form-control-sm" name="nuevaDiscapacidad" id="nuevaDiscapacidad">
                  <option value="" <?php echo $pacienteAsegurado["discapacidad"]=="" ? 'selected':''; ?>>Elegir</option>
                  <option value="SI" <?php echo $pacienteAsegurado["discapacidad"]=="SI" ? 'selected':''; ?>>SI</option>
                  <option value="NO" <?php echo $pacienteAsegurado["discapacidad"]=="NO" ? 'selected':''; ?>>NO</option>
              </select>

            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="paisProcedencia">País de procedencia<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="paisProcedencia" id="paisProcedencia">                  
                  <option value="">Elegir</option>
                  <?php
                    $paisProcedencia = ControladorPaises::ctrMostrarPaises(null, null);
                    foreach ($paisProcedencia as $key) {
                      if($key['id']==$pacienteAsegurado["id_pais_paciente"]){
                        ?>
                          <option value="<?= $key['id']?>" selected><?= $key['nombre_pais']?></option>;
                      <?php
                      }else{
                  ?>
                    <option value="<?= $key['id']?>"> <?= $key['nombre_pais']?></option>;                  
                  <?php
                      }
                    }
                  ?> 
              </select>
            </div>

            <div class="form-group col-md-3">                
              <label class="m-0 font-weight-normal" for="residenciaActual">Residencia actual: Departamento<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="residenciaActual" id="residenciaActual"  >
                <option value="">Elegir</option>
                <?php                    
                    $departamentos_paciente = ControladorDepartamentos::ctrMostrarDepartamentos(null, null);
                      foreach ($departamentos_paciente as $key) {
                        if($key['id']==$pacienteAsegurado["id_departamento_paciente"]){
                          ?>
                            <option value="<?= $key['id']?>" selected><?= $key['nombre_depto']?></option>;
                        <?php
                        }else{
                    ?>
                      <option value="<?= $key['id']?>"> <?= $key['nombre_depto']?></option>;                  
                    <?php
                        }
                      }
                ?>                  
              </select>

            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoProvincia">Provincia<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoProvincia" id="nuevoProvincia"  >
                  <?php
                      $provincia_paciente = ControladorProvincia::ctrMostrarProvincia(null, null);
                      foreach ($provincia_paciente as $key) {
                        if($key['id']==$pacienteAsegurado["id_provincia_paciente"]){
                  ?>
                      <option value="<?=$key['id']?>" selected><?=$key['nombre_provincia']?></option>;
                  <?php
                        }else{
                  ?>
                    <option value="<?= $key['id']?>"><?= $key['nombre_provincia']?></option>
                  <?php
                        }
                      }
                  ?>
              </select>

            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoMunicipio">Municipio<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoMunicipio" id="nuevoMunicipio"   >
                  <?php

                      $municipio_paciente = ControladorMunicipio::ctrMostrarMunicipio(null, null);
                      foreach ($municipio_paciente as $key) {
                        if($key['id']==$pacienteAsegurado["id_municipio_paciente"]){
                          ?>
                              <option value="<?=$key['id']?>" selected><?=$key['nombre_municipio']?></option>;
                          <?php
                        }else{
                          ?>
                            <option value="<?= $key['id']?>"><?= $key['nombre_municipio']?></option>
                          <?php
                        }
                      }                    
                  ?>
              </select>

            </div>

          </div>

          <div class="form-row">
            
            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoZonaPaciente">Zona</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoZonaPaciente" id="nuevoZonaPaciente" value="<?= $pacienteAsegurado['zona'] ?>">
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCallePaciente">Calle</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoCallePaciente" id="nuevoCallePaciente" value="<?= $pacienteAsegurado['calle'] ?>">
            </div>

            <div class="form-group col-md-1">
              <label class="m-0 font-weight-normal" for="nuevoNroCallePaciente">Nro. Calle</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoNroCallePaciente" id="nuevoNroCallePaciente" value="<?= $pacienteAsegurado['nro_calle'] ?>">
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoTelefonoPaciente">Teléfono</label>
              <input type="text" class="form-control form-control-sm" name="nuevoTelefonoPaciente" id="nuevoTelefonoPaciente" data-inputmask="'mask': '9{7,8}'" value="<?= $pacienteAsegurado['telefono'] ?>">
            </div>

            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="nuevoEmailPaciente">Email</label>
              <input type="text" class="form-control form-control-sm" name="nuevoEmailPaciente" id="nuevoEmailPaciente" data-inputmask="'alias': 'email'" inputmode="email" value="<?= $pacienteAsegurado['email'] ?>">
            </div>
            
            <div class="form-row col-md-12" id="divDatosApoderado" <?php echo ($pacienteAsegurado['edad']<19 || $pacienteAsegurado['discapacidad']=='SI')? '':'style="display: none;"' ?> >
              <div class="form-group col-md-5">
                <label class="m-0 font-weight-normal" for="nuevoNombreApoderado">Si es menor de edad Nombre del Padre/Madre o apoderado</label>
                <input type="text" class="form-control form-control-sm mayuscula" name="nuevoNombreApoderado" id="nuevoNombreApoderado" value="<?= $pacienteAsegurado['nombre_apoderado'] ?>">
              </div>

              <div class="form-group col-md-5">
              <label class="m-0 font-weight-normal" for="nuevoTelefonoApoderado">Teléfono Apoderado</label>
                <input type="text" class="form-control form-control-sm" name="nuevoTelefonoApoderado" id="nuevoTelefonoApoderado" data-inputmask="'mask': '9{7,8}'" value="<?= $pacienteAsegurado['telefono_apoderado'] ?>">
              </div>
            </div>

          </div>

          <div class="form-row">
            
            

          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 3. ANTECEDENTES EPIDEMIOLOGICOS
      =============================================-->  

      <?php

        $item = "id_ficha";
        $valor = $_GET["idFicha"];

        $ant_epidemiologicos = ControladorAntEpidemiologicos::ctrMostrarAntEpidemiologicos($item, $valor);
        $ant_epidemiologicosBackup = ControladorAntEpidemiologicos::ctrMostrarAntEpidemiologicosMark($item, $valor);
       // var_dump($ant_epidemiologicos);

      ?>

      <div class="card mb-0">
          
          <div class="card-header bg-dark py-1 text-center">

            <span>3. ANTECEDENTES EPIDEMIOLOGICOS</span>
            
          </div>

          <div class="card-body">

            <div class="form-row">

              <div class="form-group col-md-3">
              
                <label class="m-0 font-weight-normal col-md-5" for="nuevoAntOcupacion">Ocupación<span class="text-danger font-weight-bold"> *</span></label> 
                <select class="form-control form-control-sm" name="ocupacion" id="ocupacion">
                  <?php                
                    if($ant_epidemiologicos['ocupacion'] == 'PERSONAL DE SALUD') 
                      echo '<option value="PERSONAL DE SALUD" selected>PERSONAL DE SALUD</option>';
                    else echo '<option value="PERSONAL DE SALUD">PERSONAL DE SALUD</option>';

                    if($ant_epidemiologicos['ocupacion'] == 'PERSONAL DE LABORATORIO') 
                    echo '<option value="PERSONAL DE LABORATORIO" selected>PERSONAL DE LABORATORIO</option>';
                    else echo '<option value="PERSONAL DE LABORATORIO">PERSONAL DE LABORATORIO</option>';

                    if($ant_epidemiologicos['ocupacion'] == 'TRABAJADOR PRENSA') 
                    echo ' <option value="TRABAJADOR PRENSA" selected>TRABAJADOR PRENSA</option>';
                    else echo ' <option value="TRABAJADOR PRENSA">TRABAJADOR PRENSA</option>';

                    if($ant_epidemiologicos['ocupacion'] == 'FF.AA.') 
                    echo ' <option value="FF.AA." selected>FF.AA.</option>';
                    else echo ' <option value="FF.AA.">FF.AA.</option>';

                    if($ant_epidemiologicos['ocupacion'] == 'POLICIA') 
                    echo '<option value="POLICIA" selected>POLICIA</option>';
                    else echo '<option value="POLICIA">POLICIA</option>';

                    if($ant_epidemiologicos['ocupacion'] == 'OTRO') 
                    echo '<option value="OTRO" selected>OTRO</option>';
                    else echo '<option value="OTRO">OTRO</option>';

                  ?>
                    
                </select>  

              </div>

            </div>

            <div class="form-row">
              
              <div class="form-group col-md-4">

                <label class="m-0 font-weight-normal" for="nuevoContactoCovid">¿Tuvo contacto con un caso de COVID-19?<span class="text-danger"> *</span></label>
                <select class="form-control form-control-sm col-md-4" name="nuevoContactoCovid" id="nuevoContactoCovid">
                  <?php 

                    if ($ant_epidemiologicos['contacto_covid'] == "SI") {

                      echo
                      '<option value="'.$ant_epidemiologicos['contacto_covid'].'">'.$ant_epidemiologicos['contacto_covid'].'</option>
                      <option value="NO">NO</option>
                      <option value="0">Elegir...</option>
                      ';
                      
                      
                    } else if ($ant_epidemiologicos['contacto_covid'] == "NO") {
                    
                      echo 
                      '<option value="'.$ant_epidemiologicos['contacto_covid'].'">'.$ant_epidemiologicos['contacto_covid'].'</option>
                      <option value="SI">SI</option>
                      <option value="0">Elegir...</option>
                      ';
                    
                    } else {

                      echo 
                      '<option value="0">Elegir...</option>
                      <option value="SI">SI</option>
                      <option value="NO">NO</option>';

                    }

                  ?>   
                </select>

              </div>

              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="nuevoFechaContactoCovid">Fecha de Contacto</label>
                <?php
                  if($ant_epidemiologicos['contacto_covid'] == "SI")
                    echo '<input type="date" class="form-control form-control-sm" name="nuevoFechaContactoCovid" id="nuevoFechaContactoCovid" '
                          .'value="'.$ant_epidemiologicos['fecha_contacto_covid'].'">';
                  else if($ant_epidemiologicos['contacto_covid'] == "NO" || $ant_epidemiologicos['contacto_covid'] == null)
                    echo '<input type="date" class="form-control form-control-sm" name="nuevoFechaContactoCovid" id="nuevoFechaContactoCovid"'
                          .'value="'.$ant_epidemiologicos['fecha_contacto_covid'].'"readonly>';
                        else 
                    echo '<input type="date" class="form-control form-control-sm" name="nuevoFechaContactoCovid" id="nuevoFechaContactoCovid"'
                        .'value="'.$ant_epidemiologicos['fecha_contacto_covid'].'"readonly>'; 
                ?>   
              
              </div>

            </div>

            <div class="form-row">
              <div class="form-group col-md-5">
                <label class="m-0 font-weight-normal" for="covidPositivoAntes">¿Fue diagnosticado por COVID-19 anteriormente?<span class="text-danger"> *</span></label>
                    <select class="form-control form-control-sm col-md-4" name="covidPositivoAntes" id="covidPositivoAntes">
                    <?php 

                      if ($ant_epidemiologicos['diagnosticado_covid_anteriormente'] == "SI") {

                        echo
                        '<option value="'.$ant_epidemiologicos['diagnosticado_covid_anteriormente'].'">'.$ant_epidemiologicos['diagnosticado_covid_anteriormente'].'</option>
                        <option value="NO">NO</option>
                        <option value="0">Elegir...</option>
                        ';
                        
                          
                        } else if ($ant_epidemiologicos['diagnosticado_covid_anteriormente'] == "NO") {

                          echo 
                          '<option value="'.$ant_epidemiologicos['diagnosticado_covid_anteriormente'].'">'.$ant_epidemiologicos['diagnosticado_covid_anteriormente'].'</option>
                          <option value="SI">SI</option>
                          <option value="0">Elegir...</option>
                          ';

                        } else {

                          echo 
                          '<option value="0">Elegir...</option>
                          <option value="SI">SI</option>
                          <option value="NO">NO</option>';

                        }

                      ?>
                    </select>
              </div>
              <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="covidPositivoAntesFecha">Fecha</label>            
                <?php
                  if($ant_epidemiologicos['diagnosticado_covid_anteriormente'] == "SI")
                    echo '<input type="date" class="form-control form-control-sm" name="covidPositivoAntesFecha" id="covidPositivoAntesFecha" '
                          .'value="'.$ant_epidemiologicos['fecha_covid_anteriormente'].'">';
                  else if($ant_epidemiologicos['diagnosticado_covid_anteriormente'] == "NO")
                    echo '<input type="date" class="form-control form-control-sm" name="covidPositivoAntesFecha" id="covidPositivoAntesFecha"'
                          .'value="'.$ant_epidemiologicos['fecha_covid_anteriormente'].'"readonly>';
                        else 
                    echo '<input type="date" class="form-control form-control-sm" name="covidPositivoAntesFecha" id="covidPositivoAntesFecha"'
                        .'value="'.$ant_epidemiologicos['fecha_covid_anteriormente'].'"readonly>'; 
                ?>  
              </div>


            </div>

            <div class="form-row">

              <div class="form-group col-md-12 m-0">
              
                <label class="m-0 font-weight-normal">Lugar probable de infección:</label>

              </div>

            </div>

            <div class="form-row">
              
              <div class="form-group col-md-2">
              
                <label class="m-0 font-weight-normal" for="nuevoPaisContactoCovid">País</label> 
                <select class="form-control form-control-sm" name="paisInfeccion" id="paisInfeccion"  >
                
                    <?php 
            
                      $item = null;
                      $valor = null;

                      $paises = ControladorPaises::ctrMostrarPaises($item, $valor);
                      foreach ($paises as $key => $value) {
                        if($ant_epidemiologicos['pais_contacto_covid'] == strtoupper($value["nombre_pais"])){
                          echo  '<option value="'.$value["id"].'" selected>'
                                      .$value["nombre_pais"].
                            '</option>';
                        }
                        else{
                          echo  '<option value="'.$value["id"].'" >'
                                      .$value["nombre_pais"].
                            '</option>';
                        }                      
                      } 

                    ?>
                  </select>

              </div>

                          <!--OCULTAMOS LOS CAMPOS SI EL PAIS ES DIFERENTE DE BOLIVIA-->
              <?php
                  $nombrePais = strtoupper($ant_epidemiologicos['pais_contacto_covid']);
                  if($nombrePais == 'BOLIVIA'){
              ?>
              <div class="form-group col-md-10 row" id="ubicacionLugarDeInfeccion">
  
                  <div class="form-group col-md-4">

                    <label class="m-0 font-weight-normal" for="departamentoProbableInfeccion">Departamento/Estado</label>               
                    <select class="form-control form-control-sm" name="departamentoProbableInfeccion" id="departamentoProbableInfeccion"  >
                        <option value="0">Elegir...</option>               
                        <?php 

                          $item = null;
                          $valor = null;

                          $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);
                          $departActual = $ant_epidemiologicos['departamento_contacto_covid'];
                          foreach ($departamentos as $key => $value) {
                            if($departActual ==  strtoupper($value["nombre_depto"]))
                            echo  '<option value="'.$value["id"].'" selected>'
                                          .$value["nombre_depto"].
                                '</option>';
                            else
                            echo  '<option value="'.$value["id"].'">'
                                        .$value["nombre_depto"].
                                  '</option>';     
                            
                          } 

                        ?>
                    </select>

                  </div>

                  <div class="form-group col-md-4">

                    <label class="m-0 font-weight-normal" for="provinciaProbableInfeccion">Provincia</label>
                    <select class="form-control form-control-sm" name="provinciaProbableInfeccion" id="provinciaProbableInfeccion"> 
                      <option value="0">Elegir...</option>
                      <?php 

                        $item = "id_departamento";
                        //$valor = 1;
                        $nombreDepartamento = $ant_epidemiologicosBackup[0]['departamento_contacto_covid'];
                        $provinciaActual = $ant_epidemiologicosBackup[0]['provincia_contacto_covid'];
                        $idDepartamento = ModeloDepartamentos::getIdDepartamentoDadoUnCampo('nombre_depto', $nombreDepartamento)[0]['id'];
        
                        $provincias = ControladorProvincia::mdlMostrarProvinciaMark($item, $idDepartamento);
                                          
                        foreach ($provincias as $key => $value) {
                          if(strtoupper($provinciaActual) ==  strtoupper($value["nombre_provincia"]))
                              echo  '<option value="'.$value["id"].'" selected >'
                                            .$value["nombre_provincia"].
                                  '</option>';

                          else
                              echo  '<option value="'.$value["id"].'" >'
                                            .$value["nombre_provincia"].
                                  '</option>';
                          
                        }  

                      ?>
                    </select>

                  </div>

                  <div class="form-group col-md-4">

                    <label class="m-0 font-weight-normal" for="municipioProbableInfeccion">Ciudad/localidad/Municio</label>
                    <select class="form-control form-control-sm" name="municipioProbableInfeccion" id="municipioProbableInfeccion"   disabled>
                      <option value="0">Elegir...</option>
                        <?php 

                          $item = 'id_provincia';
                          //$valor = 1;

                          $nombreProvincia = $ant_epidemiologicosBackup[0]['provincia_contacto_covid'];
                          $municipioActual = $ant_epidemiologicosBackup[0]['localidad_contacto_covid'];
                          $idProvincia = ModeloProvincia::getIdProvinciaDadoUnItem('nombre_provincia', $nombreProvincia)[0]['id'];
          
                          $municipios = ControladorMunicipio::ctrMostrarMunicipioMark($item, $idProvincia);
                          //var_dump($municipios);
                          foreach ($municipios as $key => $value) {
                            if(strtoupper($municipioActual) ==  strtoupper($value["nombre_municipio"]))
                                echo  '<option value="'.$value["id"].'" selected>'
                                              .$value["nombre_municipio"].
                                    '</option>';
                            else
                                echo  '<option value="'.$value["id"].'" >'
                                                .$value["nombre_municipio"].
                                      '</option>';         
                            
                          } 

                        ?>
                    </select>
                  </div>
            </div>

              <?php }  else { ?>

                <div class="form-group col-md-10 row" id="ubicacionLugarDeInfeccion" style="display:none">
  
                    <div class="form-group col-md-4">

                      <label class="m-0 font-weight-normal" for="departamentoProbableInfeccion">Departamento/Estado</label>               
                      <select class="form-control form-control-sm" name="departamentoProbableInfeccion" id="departamentoProbableInfeccion"   disabled>
                          <!--<option value="0">Elegir...</option>-->                 
                          <?php 

                            $item = null;
                            $valor = null;

                            $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

                            foreach ($departamentos as $key => $value) {
                              
                              echo  '<option value="'.$value["id"].'">'
                                            .$value["nombre_depto"].
                                  '</option>';
                              
                            } 

                          ?>
                      </select>

                    </div>

                    <div class="form-group col-md-4">

                      <label class="m-0 font-weight-normal" for="provinciaProbableInfeccion">Provincia</label>
                      <select class="form-control form-control-sm" name="provinciaProbableInfeccion" id="provinciaProbableInfeccion"  >
                        <option value="0">Elegir...</option>
                        <?php 

                          $item = "id_departamento";
                          $valor = 1;

                          $provincias = ControladorProvincia::mdlMostrarProvinciaMark($item, $valor);
                          foreach ($provincias as $key => $value) {
                            
                            echo  '<option value="'.$value["id"].'" >'
                                          .$value["nombre_provincia"].
                                '</option>';
                            
                          } 

                        ?>
                      </select>

                    </div>

                    <div class="form-group col-md-4">

                      <label class="m-0 font-weight-normal" for="municipioProbableInfeccion">Ciudad/localidad/Municio</label>
                      <select class="form-control form-control-sm" name="municipioProbableInfeccion" id="municipioProbableInfeccion"   disabled>
                        <option value="0">Elegir...</option>
                          <?php 

                            $item = 'id_provincia';
                            $valor = 1;

                            $municipios = ControladorMunicipio::ctrMostrarMunicipioMark($item, $valor);
                            //var_dump($municipios);
                            foreach ($municipios as $key => $value) {
                              
                              echo  '<option value="'.$value["id"].'" >'
                                            .$value["nombre_municipio"].
                                  '</option>';
                              
                            } 

                          ?>
                      </select>
                    </div>
                </div>

          <?php } ?>

                <!--AQUI TERMINA LOS DATOS QUE SE OCULTAN SEGUN PAIS SELECCIONADO-->

                  <?php  if($nombrePais == 'BOLIVIA'){ ?>

                <div class="form-group col-md-9">
                  <label class="m-0 font-weight-normal" for="nuevoLocalidadContactoCovid">Ingrese el lugar donde se infecto</label>
                  <input type="text" class="form-control form-control-sm mayuscula" id="lugaraproximado" name="lugaraproximado" minlength="8" value="<?= $ant_epidemiologicos['lugar_aproximado_infeccion'] ?>" disabled>       
                </div>

                  <?php } else {?>

                <div class="form-group col-md-9">
                  <label class="m-0 font-weight-normal" for="nuevoLocalidadContactoCovid">Ingrese el lugar donde se infecto</label>
                  <input type="text" class="form-control form-control-sm mayuscula" id="lugaraproximado" name="lugaraproximado" minlength="8" value="<?= $ant_epidemiologicos['lugar_aproximado_infeccion'] ?>">       
                </div>

                  <?php } ?>

            </div>
            
          </div>

      </div>

        <!--=============================================
        SECCION 4. DATOS CLINICOS
        =============================================--> 

        <?php

          $item = "id_ficha";
          $valor = $_GET["idFicha"];

          $datos_clinicos = ControladorDatosClinicos::ctrMostrarDatosClinicos($item, $valor);

        ?>  

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>4. DATOS CLINICOS</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">
            <?php
              $id_ficha = $_GET["idFicha"];
              $malestare = ControladorMalestar::ctrMostrarMalestar($id_ficha);
            ?>
            <div class="icheck-silver col-md-4">
              <input type="checkbox" name="nuevoPasienteAsintomatico" value="" id="nuevoPasienteAsintomatico" <?php echo $malestare['sintoma']=="ASINTOMATICO" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoPasienteAsintomatico">Asintomatico</label>
            </div>

            <div class="icheck-silver col-md-4">
              <input type="checkbox" name="nuevoPasienteSintomatico" value=""  id="nuevoPasienteSintomatico" <?php echo $malestare['sintoma']=="SINTOMATICO" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoPasienteSintomatico">Sintomatico</label>
            </div>

            <div class="form-inline col-md-4" id="nuevoFechaInicioSintomasDiv" <?php echo $malestare['sintoma']=="SINTOMATICO" ? '': 'style="display: none;"' ?>>
              <label class="my-0 mr-2 font-weight-normal" for="nuevoFechaInicioSintomas">Fecha de inicio de síntomas</label>
              <input type="date" class="form-control form-control-sm" id="nuevoFechaInicioSintomas" name="nuevoFechaInicioSintomas" value="<?= $malestare['fecha_inicio_sintomas'] ?>"> 
            </div>

          </div>
          </br>

          <div class="form-row" id="divSintomas" <?php echo $malestare['sintoma']=="SINTOMATICO" ? '': 'style="display: none;"' ?> >
            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="TOS SECA" id="nuevoMalestaresTos" <?php echo $malestare['tos_seca']=="TOS SECA" ? 'checked': '' ?> >              
              <label class="font-weight-normal" for="nuevoMalestaresTos">Tos seca</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="FIEBRE" id="nuevoMalestaresFiebre" <?php echo $malestare['fiebre']=="FIEBRE" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoMalestaresFiebre">Fiebre</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="MALESTAR GENERAL" id="nuevoMalestaresGeneral" <?php echo $malestare['malestar_general']=="MALESTAR GENERAL" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoMalestaresGeneral">Malestar General</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="CEFALEA" id="nuevoMalestaresCefalea" <?php echo $malestare['cefalea']=="CEFALEA" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoMalestaresCefalea">Cefalea</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="DIFICULTAD RESPIRATORIA" id="nuevoMalestaresDifRespiratoria" <?php echo $malestare['dificultad_respiratoria']=="DIFICULTAD RESPIRATORIA" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoMalestaresDifRespiratoria">Dificultad Respiratoria</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="MIALGIAS" id="nuevoMalestaresMialgias" <?php echo $malestare['mialgias']=="MIALGIAS" ? 'checked': '' ?> >
              <label class="font-weight-normal" for="nuevoMalestaresMialgias">Mialgias</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoMalestares" value="DOLOR DE GARGANTA" id="nuevoMalestaresDolorGaraganta" <?php echo $malestare['dolor_garganta']=="DOLOR DE GARGANTA" ? 'checked': '' ?> >              
              <label class="font-weight-normal" for="nuevoMalestaresDolorGaraganta">Dolor de garganta</label>
            </div>

            <div class="icheck-silver mr-4">
              <input type="checkbox" name="nuevoMalestares" value="PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO" id="nuevoMalestaresPerdOlfato" <?php echo $malestare['perdida_olfato']=="PERDIDA O DISMINUCIÓN DEL SENTIDO DEL OLFATO" ? 'checked': '' ?> >             
              <label class="font-weight-normal" for="nuevoMalestaresPerdOlfato">Pérdida y/o disminución del sentido del olfato</label>
            </div>

             <div class="form-inline col-md-3">
              <label class="my-0 font-weight-normal" for="nuevoMalestaresOtros">Otros</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoMalestaresOtros" name="nuevoMalestaresOtros" value="<?=$malestare['otros']?>">
            </div>

          </div>
         

          <div class="form-row" id="divSintomasEstado" <?php echo $malestare['sintoma']=="SINTOMATICO" ? '': 'style="display: none;"' ?>>
            
            <div class="form-group col-md-5">
              <label class="m-0 font-weight-normal" for="nuevoEstadoPaciente">Estado actual del paciente (al momento de la notificacion)<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm col-md-5" name="nuevoEstadoPaciente" id="nuevoEstadoPaciente">
                <option value="" <?php echo $datos_clinicos['estado_paciente'] == "" ?'selected':'' ?>>Elegir</option>
                <option value="LEVE" <?php echo $datos_clinicos['estado_paciente'] == "LEVE" ?'selected':'' ?>>LEVE</option>
                <option value="GRAVE" <?php echo $datos_clinicos['estado_paciente'] == "GRAVE" ? 'selected':'' ?>>GRAVE</option>
                <option value="FALLECIDO" <?php echo $datos_clinicos['estado_paciente'] == "FALLECIDO" ? 'selected':'' ?>>FALLECIDO</option>                  
              </select>

            </div>

            <div class="form-inline col-md-4 pt-2">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoFechaDefuncion">Fecha de defunción</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaDefuncion" id="nuevoFechaDefuncion" value="<?= $datos_clinicos['fecha_defuncion'] ?>" readonly>
            </div>

          </div>

          <div class="form-row" id="divSintomasClinico" <?php echo $malestare['sintoma']=="SINTOMATICO" ? '': 'style="display: none;"' ?>>
            
            <div class="form-group col-md-3">
            
              <label class="m-0 mr-2 font-weight-normal" for="nuevoDiagnosticoClinico">Diagnostico clínico<span class="text-danger font-weight-bold"> *</span></label> 
              <input list="diagnosticoClinico" class="form-control form-control-sm mayuscula" id="nuevoDiagnosticoClinico" name="nuevoDiagnosticoClinico" value="<?= $datos_clinicos['diagnostico_clinico'] ?>">
              <datalist id="diagnosticoClinico">
                <option value="GRIPAL/IRA/BRONQUITIS"></option>
                <option value="IRAG/NEUMONIA"></option>
                <option value=""></option>
              </datalist>           

            </div>

          </div>
          
        </div>

      </div>

        <!--=============================================
        SECCION 5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO
        =============================================--> 

        <?php

          $item = "id_ficha";
          $valor = $_GET["idFicha"];

          $hospitalizaciones_aislamientos = ControladorHospitalizacionesAislamientos::ctrMostrarHospitalizacionesAislamientos($item, $valor);
          $metodoHospitalizacion = $hospitalizaciones_aislamientos['metodo_hospitalizacion'];
          $fechaAislamiento = $hospitalizaciones_aislamientos['fecha_aislamiento'];
          $fechaInternacion = $hospitalizaciones_aislamientos['fecha_internacion'];
          $terapia_intensiva = $hospitalizaciones_aislamientos['terapia_intensiva'];
          
        ?>  

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>5. DATOS EN CASO DE HOSPITALIZACIÓN Y/O AISLAMIENTO</span>
          
        </div>

        <div class="card-body">

          <!--begin code M@rk-->
          <div class="form-row">
             <div class="icheck-silver mr-5">
                 <?php
                   if(strtoupper($metodoHospitalizacion) == 'AMBULATORIO')
                       echo '<input type="checkbox" name="ambulatorio" value="0" id="ambulatorio" checked>';
                   else if (strtoupper($metodoHospitalizacion) == 'INTERNADO')
                            echo '<input type="checkbox" name="ambulatorio" value="0" id="ambulatorio" disabled>';
                        else 
                            echo '<input type="checkbox" name="ambulatorio" value="0" id="ambulatorio">';
                 ?>              
                
                <label class="font-weight-normal" for="ambulatorio" >Ambulatorio</label>
              </div>

              <div class="icheck-silver mr-5">

                <?php
                   if(strtoupper($metodoHospitalizacion) == 'INTERNADO')
                       echo '<input type="checkbox" name="internado" value="1" id="internado" checked>';
                   else if (strtoupper($metodoHospitalizacion) == 'AMBULATORIO')
                           echo '<input type="checkbox" name="internado" value="1" id="internado" disabled>';
                        else 
                          echo '<input type="checkbox" name="internado" value="1" id="internado">';
                 ?> 
                  <label class="font-weight-normal" for="internado" >Internado</label>
              </div>

              <div class="form-group col-md-1">
              </div>  

              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="nuevoFechaAislamiento">Fecha de Aislamiento</label>
                <input type="date" class="form-control form-control-sm" name="nuevoFechaAislamiento" id="nuevoFechaAislamiento" value="<?= $fechaAislamiento ?>" <?php echo $metodoHospitalizacion == "AMBULATORIO"? '':'disabled' ?>>

              </div>

              <div class="form-group col-md-3">

                <label class="m-0 font-weight-normal" for="nuevoFechaInternacion">Fecha de Internación</label>
                <input type="date" class="form-control form-control-sm" name="nuevoFechaInternacion" id="nuevoFechaInternacion" value="<?= $fechaInternacion ?>" <?php echo $metodoHospitalizacion == "INTERNADO"? '':'disabled' ?>>

              </div>


            </div>

            <div class ="form-row">
              <div class="form-group col-md-9">

              <label class="m-0 font-weight-normal" for="nuevoLugarAislamiento">Lugar de Aislamiento</label>
              <input type="text" class="form-control form-control-sm mayuscula" minlength="8" name="nuevoLugarAislamiento" id="nuevoLugarAislamiento" value="<?= $hospitalizaciones_aislamientos['lugar_aislamiento'] ?>" <?php echo $metodoHospitalizacion == "AMBULATORIO"? '':'disabled' ?>>

              </div>
            </div>
          <!--end code M@rk-->
          <div class="form-row"  id="paraInternado">
                <div class="form-row col-md-12">

                  <div class="form-group col-md-12">

                    <label class="m-0 font-weight-normal" for="nuevoEstablecimientoInternacion">Establecimiento de salud de Internación</label>
                    <select class="form-control form-control-sm" name="nuevoEstablecimientoInternacion" id="nuevoEstablecimientoInternacion"   disabled>
                      <option value="">Elegir...</option>
                      <?php 

                        $item = null;
                        $valor = null;

                        $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

                        foreach ($establecimientos as $key => $value) {                          
                          if($hospitalizaciones_aislamientos['establecimiento_internacion'] == $value["nombre_establecimiento"]){
                              echo  '<option value="'.$value["id"].'" selected = "selected">'
                                            .$value["nombre_establecimiento"].
                                  '</option>';                                
                          }
                          else{

                              echo  '<option value="'.$value["id"].'" >'
                                            .$value["nombre_establecimiento"].
                                  '</option>';

                          }     
                          
                        } 

                      ?>
                    </select>

                  </div>

                </div>

                <div class="form-row col-md-12">

                    <div class="form-group col-md-4">

                      <label class="m-0" for="nuevoVentilacionMecanica">Ventilación mecánica<span class="text-danger font-weight-bold"> *</span></label>
                      <select class="form-control form-control-sm col-md-6" name="nuevoVentilacionMecanica" id="nuevoVentilacionMecanica" <?php echo $metodoHospitalizacion == "INTERNADO"? '':'disabled' ?>>
                        <?php 

                          if ($hospitalizaciones_aislamientos['ventilacion_mecanica'] == "SI") {

                            echo 
                            '<option value="'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'">'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'</option>
                            <option value="NO">NO</option>
                            <option value="0">Elegir...</option>
                            ';
                            
                          } else if ($hospitalizaciones_aislamientos['ventilacion_mecanica'] == "NO") {
                        
                            echo 
                            '<option value="'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'">'.$hospitalizaciones_aislamientos['ventilacion_mecanica'].'</option>
                            <option value="SI">SI</option>
                            <option value="0">Elegir...</option>
                            ';

                          } else {

                            echo 
                            '<option value="0">Elegir...</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>';

                          }

                        ?>   
                      </select>

                    </div>

                    <div class="form-group col-md-4">

                      <label class="m-0" for="nuevoTerapiaIntensiva">Terapia intensiva<span class="text-danger font-weight-bold"> *</span></label>
                      <select class="form-control form-control-sm col-md-6" name="nuevoTerapiaIntensiva" id="nuevoTerapiaIntensiva" <?php echo $metodoHospitalizacion == "INTERNADO"? '':'disabled' ?>>
                      <?php 

                        if ($hospitalizaciones_aislamientos['terapia_intensiva'] == "SI") {

                          echo 
                          '<option value="'.$hospitalizaciones_aislamientos['terapia_intensiva'].'">'.$hospitalizaciones_aislamientos['terapia_intensiva'].'</option>
                          <option value="NO">NO</option>
                          <option value="0">Elegir...</option>
                          ';
                          
                        } else if ($hospitalizaciones_aislamientos['terapia_intensiva'] == "NO") {
                      
                          echo 
                          '<option value="'.$hospitalizaciones_aislamientos['terapia_intensiva'].'">'.$hospitalizaciones_aislamientos['terapia_intensiva'].'</option>
                          <option value="SI">SI</option>
                          <option value="0">Elegir...</option>
                          ';

                        } else {

                          echo 
                          '<option value="0">Elegir...</option>
                          <option value="SI">SI</option>
                          <option value="NO">NO</option>';

                        }

                      ?>   
                      </select>

                    </div>

                    <div class="form-group col-md-4">

                      <label class="m-0 font-weight-normal" for="nuevoFechaIngresoUTI">Fecha de Ingreso a UTI</label>
                      <input type="date" class="form-control form-control-sm" name="nuevoFechaIngresoUTI" id="nuevoFechaIngresoUTI" value="<?= $hospitalizaciones_aislamientos['fecha_ingreso_UTI'] ?>" <?php echo $metodoHospitalizacion == "INTERNADO" && $terapia_intensiva == "SI"? '':'disabled' ?>>

                    </div>

                </div>

          </div>
          
        </div>

      </div>

        <!--=============================================
        SECCION 6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO
        =============================================--> 

        <?php

          $item = "id";
          $valor = $_GET["idFicha"];

          $enfermedades_bases = ControladorEnfermedadesBases::ctrMostrarEnfermedadesBases($item, $valor);

        ?>  

      <div class="card mb-0">       
        <div class="card-header bg-dark py-1 text-center">
          <span>6. ENFERMEDADES DE BASE O CONDICIONES DE RIESGO</span>          
        </div>

        <div class="card-body">
          
          <?php

            $item = "id_ficha";
            $valor = $_GET["idFicha"];
            $enfermedades_bases = ControladorEnfermedadesBases::ctrMostrarEnfermedadesBases($item, $valor);

          ?> 

          <div class="form-row">
            <div class="col-md-0">
              <label class="font-weight-normal" for="tomoMuestraLaboratorio">Presenta Anguna Enfermedad de Base?<span class="text-danger font-weight-bold"> *</span></label>
            </div> 
                     
            <div class="icheck-silver icheck-inline">
              <input type="checkbox" id="checkPresenta" name="checkPresenta" value="PRESENTA" <?php echo $enfermedades_bases["enf_estado"]=="PRESENTA" ? 'checked':'' ;?> >
              <label class="m-0 font-weight-normal" for="checkPresenta">Presenta</label>
            </div>

            <div class="icheck-silver icheck-inline">
              <input type="checkbox" id="checkNoPresenta" name="checkNoPresenta" value="NO PRESENTA" <?php echo $enfermedades_bases["enf_estado"]=="NO PRESENTA" ? 'checked':'' ;?> >
              <label class="m-0 font-weight-normal" for="checkNoPresenta">No presenta</label>
            </div>

          </div>

          <div class="form-row" id="divEnfermedadBase" <?php echo $enfermedades_bases["enf_estado"]=="PRESENTA" ? '':'style="display: none;"' ;?> >            
            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="HIPERTENSIÓN ARTERIAL" id="nuevoHipertensionArterial" <?php echo $enfermedades_bases["hipertension_arterial"]=="HIPERTENSIÓN ARTERIAL" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoHipertensionArterial">Hipertensión Arterial</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="OBESIDAD" id="nuevoObesidad" <?php echo $enfermedades_bases["obesidad"]=="OBESIDAD" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoObesidad">Obesidad</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="DIABETES GENERAL" id="nuevoDiabetes" <?php echo $enfermedades_bases["diabetes_general"]=="DIABETES GENERAL" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoDiabetes">Diabetes General</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="EMBARAZO" id="nuevoEmbarazo" <?php echo $enfermedades_bases["embarazo"]=="EMBARAZO" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoEmbarazo">Embarazo</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfOnco" value="ENFERMEDADES ONCOLOGICA" id="nuevoEnfOnco" <?php echo $enfermedades_bases["enfermedades_oncologica"]=="ENFERMEDADES ONCOLOGICA" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoEnfOnco">Enfermedades Oncológica</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="ENFERMEDADES CARDIACA" id="nuevoEnfCardiaca" <?php echo $enfermedades_bases["enfermedades_cardiaca"]=="ENFERMEDADES CARDIACA" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoEnfCardiaca">Enfermedades cardiaca</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="ENFERMEDAD RESPIRATORIA" id="nuevoEnfRespiratoria" <?php echo $enfermedades_bases["enfermedad_respiratoria"]=="ENFERMEDAD RESPIRATORIA" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoEnfRespiratoria">Enfermedad respiratoria</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoEnfRiesgo" value="ENFERMEDADES RENAL CRÓNICA" id="nuevoEnfRenalCronica" <?php echo $enfermedades_bases["enfermedades_renal_cronica"]=="ENFERMEDADES RENAL CRÓNICA" ? 'checked':'' ;?>>
              <label class="font-weight-normal" for="nuevoEnfRenalCronica">Enfermedades Renal Crónica</label>
            </div>

            <div class="form-inline col-md-3">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoEnfRiesgoOtros">Otros</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoEnfRiesgoOtros" name="nuevoEnfRiesgoOtros" value="<?=$enfermedades_bases["otros"];?>">
            </div>

          </div>   
                  
        </div>

      </div>

        <!--=============================================
        SECCION 7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO
        =============================================--> 

        <div class="card mb-0">
          
          <div class="card-header bg-dark py-1 text-center">

            <span>7. DATOS DE PERSONAS CON LAS QUE EL CASO SOSPECHOSO ESTUVO EN CONTACTO ESTRECHO</span>
            
          </div>

          <div class="card-body">

            <div class="form-row">
              
              <a class="btn btn-primary mb-2 text-white" id="btnAgregarPersonaContacto" data-toggle="modal" data-target="#modalNuevoPersonaContacto" data-dismiss="modal" value="Agregar">

                <i class="fas fa-plus"></i>
                Agregar

              </a>

            </div>  

            <div class="form-row table-responsive">

              <table class="table table-bordered table-hover" id="tablaPersonasContactos">
                
                <thead>

                  <tr>
                    <th width="400px">NOMBRES Y APELLIDOS</th>
                    <th width="250px">RELACIÓN</th>
                    <th width="100px">EDAD</th>
                    <th width="200px">TELEFÓNO</th>
                    <th width="250px">DIRECCIÓN</th>
                    <th width="200px">FECHA CONTACTO</th>
                    <th width="250px">LUGAR DE CONTACTO</th>
                    <th></th>
                  </tr>

                </thead>

                <tbody>

                  <?php 

                  $item = "id_ficha";
                  $valor = $_GET["idFicha"];

                  $personas_contactos = ControladorPersonasContactos::ctrMostrarPersonasContactos($item, $valor);

                  // var_dump($personas_contactos);

                  foreach ($personas_contactos as $value) {

                    echo '
                    <tr>
                      <td>'.$value["paterno_contacto"].' '.$value["materno_contacto"].'  '.$value["nombre_contacto"].'</td>
                      <td>'.$value["relacion_contacto"].'</td>
                      <td>'.$value["edad_contacto"].'</td>
                      <td>'.$value["telefono_contacto"].'</td>
                      <td>'.$value["direccion_contacto"].'</td>
                      <td>'.date("d-m-Y", strtotime($value["fecha_contacto"])).'</td>
                      <td>'.$value["lugar_contacto"].'</td>
                      <td></td>
                    </tr>

                    ';
                    
                  }

                  ?>

                </tbody>

              </table>

            </div> 
            
          </div>

        </div>


        <!--=============================================
        SECCION 8. LABORATORIO
        =============================================-->  

        <?php

          $item = "id_ficha";
          $valor = $_GET["idFicha"];

          $laboratorios = ControladorLaboratorios::ctrMostrarLaboratorios($item, $valor);
          

          /*=============================================
          TRAEMOS LOS DATOS DE ESTABLECIMIENTO
          =============================================*/

          $item = "id";
          $valor = $laboratorios["id_establecimiento"];

          $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

        ?>  

<?php if($_SESSION["perfilUsuarioCOVID"] == "LABORATORISTA" || $_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM") { ?>
        <div class="card mb-0">
          
          <div class="card-header bg-dark py-1 text-center">

            <span>8. LABORATORIO</span>
            
          </div>

          <div class="card-body">

            <div class="card-container">

              <div class="form-row">
                <div class="col-md-3">
                  <label class="font-weight-normal" for="tomoMuestraLaboratorio">Se tomo la muestra para laboratorio:<span class="text-danger font-weight-bold"> *</span></label>
                </div>

                <div class="checkbox icheck-primary col-md-0">                
                  <input type="checkbox" name="tomoMuestraLaboratorioSi" value="" id="tomoMuestraLaboratorioSi" <?php echo $laboratorios['estado_muestra']=="SI" ? 'checked':'' ?> >
                  <label class="font-weight-normal" for="tomoMuestraLaboratorioSi">Si</label>              
                </div>

                <div class="checkbox icheck-primary col-md-3">                
                  <input type="checkbox" name="tomoMuestraLaboratorioNo" value="" id="tomoMuestraLaboratorioNo" <?php echo $laboratorios['estado_muestra']=="NO" ? 'checked':'' ?> >
                  <label class="font-weight-normal" for="tomoMuestraLaboratorioNo">No</label>
                </div>
                
                  <div class="form-group col-md-4" id="divNoTomaMuestra" <?php echo $laboratorios['estado_muestra']=="SI" ? 'style="display: none;"':'' ?> >
                    <label class="m-0 font-weight-normal" for="rechazoMuestra">Porque no se tomo la muestra</label> 
                    <input list="rechazoMuestraL" class="form-control form-control-sm mayuscula" id="rechazoMuestra" name="rechazoMuestra" value="<?= $laboratorios['des_no_muestra'] ?>" multiple="multiple">
                    <datalist id="rechazoMuestraL">
                      <option value="RECHAZO">
                      <option value="FALTA DE INSUMOS /EPP">
                      <option value="FALLECIDO">               
                    </datalist> 
                  </div>

                  <div class="form-group col-md-4" id="divTipoMuestra" <?php echo $laboratorios['estado_muestra']=="NO" ? 'style="display: none;"':'' ?> >            
                    <label class="m-0 font-weight-normal" for="nuevoTipoMuestra">Tipo de Muestra</label> 
                    <input list="tipoMuestra" class="form-control form-control-sm mayuscula" id="nuevoTipoMuestra" name="nuevoTipoMuestra" value="<?= $laboratorios['tipo_muestra'] ?>" multiple="multiple">
                    <datalist id="tipoMuestra" data-value="1">
                      <option value="ASPIRADO" data-value="2">
                      <option value="ESPUTO" data-value="3">
                      <option value="LAVADO BRONCO ALVELAR" data-value="3">
                      <option value="HISOPADO NASOFARINGEO" data-value="4">
                      <option value="HISOPADO COMBINADO" data-value="5">
                    </datalist>
                  </div>
              </div>

              <div class="form-row">

                <div class="form-group col-md-4" >
                    <label class="my-0 mr-2 font-weight-normal" for="nuevoNombreLaboratorio">Nombre de Lab. que procesara la muestra</label>
                    <input type="text" class="form-control form-control-sm mayuscula" id="nuevoNombreLaboratorio" name="nuevoNombreLaboratorio" value="<?= $laboratorios['nombre_laboratorio'] ?>" readonly>
                </div>

                <div class="form-group col-md-4" id="divFechaMuestra" <?php echo $laboratorios['estado_muestra']=="NO" ? 'style="display: none;"':'' ?>>
                  <label class="m-0 font-weight-normal" for="nuevoFechaMuestra">Fecha de toma de muestra<span class="text-danger font-weight-bold"> *</span></label>
                  <input type="date" class="form-control form-control-sm" name="nuevoFechaMuestra" min="2021-01-01" max="<?php echo date('Y-m-d'); ?>" id="nuevoFechaMuestra" value="<?=$laboratorios['fecha_muestra'] ?>" > 
                </div>
                 
                <div class="form-group col-md-4"  id="divFechaEnvio" <?php echo $laboratorios['estado_muestra']=="NO" ? 'style="display: none;"':'' ?>>
                  <label class="m-0 font-weight-normal" for="nuevoFechaEnvio">Fecha de Envío<span class="text-danger"> *</span></label>
                  <input type="date" class="form-control form-control-sm" name="nuevoFechaEnvio" min="2021-01-01" max="<?php echo date('Y-m-d'); ?>" id="nuevoFechaEnvio" value="<?=$laboratorios['fecha_envio'] ?>" <?php echo $laboratorios['metodo_diagnostico_prueba_antigenica']=="Prueba Antigénica" ? 'disabled':'' ?>>
                </div>

              </div>

              <div class="form-row">

                <div class="form-group col-md-2">
                  <label class="m-0 font-weight-normal" for="nuevoCodLaboratorio">Cod. Laboratorio<span class="text-danger font-weight-bold"> *</span></label>
                  <input type="text" class="form-control form-control-sm" name="nuevoCodLaboratorio" id="nuevoCodLaboratorio" value="<?= $laboratorios['cod_laboratorio'] ?>">
                </div>

                <div class="form-group col-md-4">

                  <label class="my-0 mr-2 font-weight-normal" for="nuevoResponsableMuestra">Responsable de Toma de Muestra<span class="text-danger font-weight-bold"> *</span></label>
                  <input type="text" class="form-control form-control-sm mayuscula" name="nuevoResponsableMuestra" id="nuevoResponsableMuestra" value="<?= $laboratorios['responsable_muestra'] ?>" />

                <!--  
                  <select class="form-control form-control-sm" name="nuevoResponsableMuestra" id="nuevoResponsableMuestra">
                    <option value="0">Elegir...</option>
                    <option value="1">Shirley Viviana Peláez Vargas</option>
                    <option value="2">Ruri Delgadillo Almendras</option>
                    <option value="3">NORKA VASQUEZ CARVAJAL</option>
                    <option value="4">Diego Bonifaz Pérez</option>
                    <option value="5">Erika Quiroz Bustos</option>
                  </select> 
                -->
                </div>

              </div>

              <div class="form-row">            
                <div class="form-group col-md-12" id="divObservaciones">
                  <label class="my-0 mr-2 font-weight-normal" for="nuevoObsMuestra">Observaciones</label>
                  <input type="text" class="form-control form-control-sm" id="nuevoObsMuestra" name="nuevoObsMuestra" value="<?=$laboratorios['observaciones_muestra'] ?>"> 
                </div>
              </div>

            </div>

          </div>      
        </div>

          <!--============================================================
                    9. RESULTADOS  danpinch  tabla(covid_resultados)
          ==============================================================-->

          <div class="card mb-0 fichaEpidemiologicaLaboratorio">            
              <div class="card-header bg-dark py-1 text-center">
                <span> RESULTADOS</span>          
              </div>

              <div class="card-body">

                <?php

                  $item = "id_ficha";
                  $valor = $_GET["idFicha"];
                  $covid_resultado  = ControladorCovidResultados::ctrMostrarCovidResultados($item,$valor);
                  //var_dump($covid_resultado);
                ?>

                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label class="my-0 mr-2 font-weight-normal" >Metodo de Diagnostico<span class="text-danger font-weight-bold"> *</span></label>
                  </div>

                  <div class="icheck-silver mr-5 ">
                    <input type="checkbox" name="pcrTiempoReal" value="RT-PCR en tiempo Real" id="pcrTiempoReal" <?php echo $laboratorios['metodo_diagnostico_pcr_tiempo_real']=="RT-PCR en tiempo Real" ? 'checked':'' ?>> 
                    <label class="font-weight-normal" for="pcrTiempoReal" id="l1pcrTiemporeal" >RT-PCR en tiempo Real</label>
                  </div>     

                  <div class="icheck-silver mr-5">
                    <input type="checkbox" name="pcrGenExpert" value="RT-PCR GENEXPER" id="pcrGenExpert" <?php echo $laboratorios['metodo_diagnostico_pcr_genexpert']=="RT-PCR GENEXPERT" ? 'checked':'' ?> > 
                    <label class="font-weight-normal" for="pcrGenExpert" id="l2pcrGenExpert" >RT-PCR GENEXPERT</label> 
                  </div>

                  <div class="icheck-silver mr-5">
                    <input type="checkbox" name="pruebaAntigenica" value="Prueba Antigenica" id="pruebaAntigenica" <?php echo $laboratorios['metodo_diagnostico_prueba_antigenica']=="Prueba Antigénica" ? 'checked':'' ?>> 
                    <label class="font-weight-normal" for="pruebaAntigenica" id="l3pcrPruebaAntigenica">Prueba Antigénica</label>
                  </div>              

                </div>

                <div class="form-row">

                <?php
                  $resultado =  $laboratorios['resultado_laboratorio'];
                  if($resultado == ''){
                    $resultado =  $covid_resultado['resultado'];
                  }
                ?>

                  <div class="form-group col-md-4">
                    <label class="my-0 mr-2 font-weight-normal" for="nuevoResultadoLaboratorio">Resultados Laboratorio<span class="text-danger font-weight-bold"> *</span></label>                  
                      <div class="icheck-danger icheck">
                        <input type="radio" name="nuevoResultadoLaboratorio" id="positivo" value="POSITIVO" <?php echo $resultado=="POSITIVO" ? 'checked':'' ?> >
                        <label for="positivo" >
                          POSITIVO
                        </label>
                      </div>
                      <div class="icheck-success icheck-inline">
                        <input type="radio" name="nuevoResultadoLaboratorio" id="negativo" value="NEGATIVO" <?php echo $resultado=="NEGATIVO" ? 'checked':'' ?>>
                        <label for="negativo">
                          NEGATIVO
                        </label>
                      </div>               
                  </div>

                  <div class="form-group col-md-3">
                    <label class="my-0 mr-2 font-weight-normal" for="nuevoFechaResultado">Fecha de Resultado<span class="text-danger font-weight-bold"> *</span></label>                  
                    <input type="date" class="form-control form-control-sm" min="2021-01-01" max="<?php echo date('Y-m-d'); ?>" id="nuevoFechaResultado" name="nuevoFechaResultado" value="<?= $laboratorios['fecha_resultado'] ?>" <?php echo $resultado == 'POSITIVO' || $resultado == 'NEGATIVO'? '': 'readonly'  ?>>
                  </div>

                  <div class="form-group col-md-4">

                    <label class="my-0 mr-2 font-weight-normal" for="responsableAnalisis">Responsable de Analisis<span class="text-danger font-weight-bold"> *</span></label>
                    <input list="listaResponsables" class="form-control form-control-sm mayuscula" id="responsableAnalisis" name="responsableAnalisis" value="<?= $covid_resultado['responsable_muestra'] ?>">
                    <datalist id="listaResponsables">
                      <option value="Shirley Viviana Peláez Vargas">Shirley Viviana Peláez Vargas</option>
                      <option value="Ruri Delgadillo Almendras">Ruri Delgadillo Almendras</option>
                      <option value="NORKA VASQUEZ CARVAJAL">NORKA VASQUEZ CARVAJAL</option>
                      <option value="Diego Bonifaz Pérez">Diego Bonifaz Pérez</option>
                      <option value="Erika Quiroz Bustos">Erika Quiroz Bustos</option>
                    </datalist>  
                  </div>

                </div>        

              </div>
          </div>
<?php }?>  
        <!--=============================================
        SECCION PERSONAL QUE NOTIFICA
        =============================================--> 

        <?php

          $item = "id_ficha";
          $valor = $_GET["idFicha"];

          $persona_notificador = ControladorPersonasNotificadores::ctrMostrarPersonasNotificadores($item, $valor);

        ?>

        <div class="card-header bg-dark py-1 text-center">
                <span>9. DATOS DEL PERSONAL QUE NOTIFICA</span>          
       </div>     

        <div class="card mb-0">

          <div class="card-body">

            <div class="form-row">
              
              <label class="my-0 mr-2 font-weight-normal">DATOS DEL PERSONAL QUE NOTIFICA:</label>

            </div>

            <div class="form-row">

              <div class="form-group col-md-2">
              
                <label class="my-0 mr-2 font-weight-normal" for="nuevoPaternoNotif">Ap. Paterno</label>
                <input type="text" class="form-control form-control-sm mayuscula" id="nuevoPaternoNotif" name="nuevoPaternoNotif" value="<?= $persona_notificador['paterno_notificador'] ?>" readonly> 

              </div>

              <div class="form-group col-md-2">
              
                <label class="my-0 mr-2 font-weight-normal" for="nuevoMaternoNotif">Ap. Materno</label>
                <input type="text" class="form-control form-control-sm mayuscula" id="nuevoMaternoNotif" name="nuevoMaternoNotif" value="<?= $persona_notificador['materno_notificador'] ?>" readonly> 

              </div>

              <div class="form-group col-md-3">
              
                <label class="my-0 mr-2 font-weight-normal" for="nuevoNombreNotif">Ap. Nombre(s)<span class="text-danger font-weight-bold"> *</span></label>
                <input type="text" class="form-control form-control-sm mayuscula" id="nuevoNombreNotif" name="nuevoNombreNotif" value="<?= $persona_notificador['nombre_notificador'] ?>" readonly> 

              </div>

              <div class="form-group col-md-2">
              
                <label class="my-0 mr-2 font-weight-normal" for="nuevoTelefonoNotif">Tel. cel</label>
                <input type="text" class="form-control form-control-sm mayuscula" id="nuevoTelefonoNotif" name="nuevoTelefonoNotif" data-inputmask="'mask': '9{7,8}'" value="<?= $persona_notificador['telefono_notificador'] ?>"> 

              </div>

              <div class="form-group col-md-3">
              
                <label class="my-0 mr-2 font-weight-normal" for="nuevoCargoNotif">Cargo</label>
                <input type="text" class="form-control form-control-sm mayuscula" id="nuevoCargoNotif" name="nuevoCargoNotif" value="<?= $persona_notificador['cargo_notificador'] ?>" readonly> 

              </div>

            </div>
            
          </div>

          <div class="card-footer">

            <div class="float-right">

              <input type="hidden" id="idFicha" value="<?= $_GET["idFicha"] ?>">
              <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $_SESSION['idUsuarioCOVID'] ?>">

              <button type="button" class="btn btn-primary btnGuardar">

                <i class="fas fa-save"></i>
                Guardar

              </button>

            </div>

          </div>

          <!-- <div class="card-footer">

            <div class="float-right">

              <input type="hidden" id="idFicha" value="<?= $_GET["idFicha"] ?>">

              <button type="button" class="btn btn-primary btnGuardar">

                <i class="fas fa-save"></i>
                Guardar

              </button>

            </div>
            
          </div> -->

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


<!--=====================================
MODAL AGREGAR NUEVA PERSONA CONTACTO
======================================-->

<div id="modalNuevoPersonaContacto" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="agregarPersonaContacto" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

    <form id="nuevoPersonaContacto"> 

      <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="agregarPersonaContacto">Agrega Nueva Persona</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="form-row">

            Campos Obligatorios<h5 class="text-danger"> *</h5>
            
          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA EL APELLIDO PATERNO -->
            
            <div class="form-group col-md-4">
              
              <label  for="nuevoPaternoContacto">Apellido Paterno</label>
              <input type="text" class="form-control mayuscula" id="nuevoPaternoContacto" name="nuevoPaternoContacto">

            </div>

            <!-- ENTRADA PARA EL APELLIDO MATERNO -->
          
            <div class="form-group col-md-4">
            
              <label for="nuevoMaternoContacto">Apellido Materno</label>
              <input type="text" class="form-control mayuscula" id="nuevoMaternoContacto" name="nuevoMaternoContacto">

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
          
            <div class="form-group col-md-4">
              
              <label for="nuevoNombreContacto">Nombre(s)<span class="text-danger"> *</span></label>
              <input type="text" class="form-control mayuscula" id="nuevoNombreContacto" name="nuevoNombreContacto">

            </div>

          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA LA RELACIÓN -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevoRelacionContacto">Relación<span class="text-danger"> *</span></label>
              <input type="text" class="form-control mayuscula" id="nuevoRelacionContacto" name="nuevoRelacionContacto">

            </div>

            <!-- ENTRADA PARA LA EDAD -->
            
            <div class="form-group col-md-2">
              
              <label for="nuevoEdadContacto">Edad</label>
              <input type="number" class="form-control" id="nuevoEdadContacto" name="nuevoEdadContacto">

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevoTelefonoContacto">Teléfono</label>
              <input type="text" class="form-control" id="nuevoTelefonoContacto" name="nuevoTelefonoContacto" data-inputmask="'mask': '9{7,8}'">

            </div>

          </div>  

          <div class="form-row">

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevaDireccionContacto">Dirección</label>
              <input type="text" class="form-control mayuscula" id="nuevaDireccionContacto" name="nuevaDireccionContacto">

            </div>

            <!-- ENTRADA PARA LA FECHA CONTACTO -->
            
            <div class="form-group col-md-3">
              
              <label for="nuevoFechaContacto">Fecha Contacto<span class="text-danger"> *</span></label>
              <input type="date" class="form-control" id="nuevoFechaContacto" name="nuevoFechaContacto">

            </div>

            <!-- ENTRADA PARA EL LUGAR CONTACTO -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevoLugarContacto">Lugar de Contacto</label>
              <input type="text" class="form-control mayuscula" id="nuevoLugarContacto" name="nuevoLugarContacto">

            </div>

          </div>  

        </div>

       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default float-left" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

          <button type="button" class="btn btn-primary" id="guardarPersonaContacto">

            <i class="fas fa-save"></i>
            Agregar Persona

          </button>

        </div>

      </div>

    </form>

  </div>

</div>

<!--=====================================
MODAL EDITAR  PERSONA CONTACTO
======================================-->

<div id="modalEditarPersonaContacto" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editarPersonaContacto" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

    <form id="guardarEditarPersonaContacto">

      <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="editarPersonaContacto">Editar Persona</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="form-row">

            Campos Obligatorios<h5 class="text-danger"> *</h5>
            
          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA EL APELLIDO PATERNO -->
            
            <div class="form-group col-md-4">
              
              <label  for="editarPaternoContacto">Apellido Paterno</label>
              <input type="text" class="form-control mayuscula" id="editarPaternoContacto" name="editarPaternoContacto">

            </div>

            <!-- ENTRADA PARA EL APELLIDO MATERNO -->
          
            <div class="form-group col-md-4">
            
              <label for="editarMaternoContacto">Apellido Materno</label>
              <input type="text" class="form-control mayuscula" id="editarMaternoContacto" name="editarMaternoContacto">

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
          
            <div class="form-group col-md-4">
              
              <label for="editarNombreContacto">Nombre(s)<span class="text-danger"> *</span></label>
              <input type="text" class="form-control mayuscula" id="editarNombreContacto" name="editarNombreContacto">

            </div>

          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA LA RELACIÓN -->
            
            <div class="form-group col-md-4">
              
              <label for="editarRelacionContacto">Relación<span class="text-danger"> *</span></label>
              <input type="text" class="form-control mayuscula" id="editarRelacionContacto" name="editarRelacionContacto">

            </div>

            <!-- ENTRADA PARA LA EDAD -->
            
            <div class="form-group col-md-2">
              
              <label for="editarEdadContacto">Edad</label>
              <input type="number" class="form-control" id="editarEdadContacto" name="editarEdadContacto">

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group col-md-4">
              
              <label for="editarTelefonoContacto">Teléfono</label>
              <input type="text" class="form-control" id="editarTelefonoContacto" name="editarTelefonoContacto" data-inputmask="'mask': '9{7,8}'">

            </div>

          </div>  

          <div class="form-row">

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group col-md-4">
              
              <label for="editarDireccionContacto">Dirección</label>
              <input type="text" class="form-control mayuscula" id="editarDireccionContacto" name="editarDireccionContacto">

            </div>

            <!-- ENTRADA PARA LA FECHA CONTACTO -->
            
            <div class="form-group col-md-3">
              
              <label for="editarFechaContacto">Fecha Contacto<span class="text-danger"> *</span></label>
              <input type="date" class="form-control" id="editarFechaContacto" name="editarFechaContacto">

            </div>

            <!-- ENTRADA PARA EL LUGAR CONTACTO -->
            
            <div class="form-group col-md-4">
              
              <label for="editarLugarContacto">Lugar de Contacto</label>
              <input type="text" class="form-control mayuscula" id="editarLugarContacto" name="editarLugarContacto">

            </div>

          </div>  

        </div>

       <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <input type="hidden" id="editarIdPersonaContacto" value="">

          <button type="button" class="btn btn-default float-left" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

          <button type="button" class="btn btn-primary" id="btnModificarPersonaContacto">

            <i class="fas fa-save"></i>
            Guardar Cambios

          </button>

        </div>

      </div>

    </form>

  </div>

</div>
<!--================================================
      div para mostrar mensajes
=====================================================-->

<div class="mensaje">
  <center> <strong>Nro. Documentos</strong></center>
  Ejs.<br>
   -  123456789-CB<br>
   -  123456789-1P-CB<br>
   -  NO TIENE<br>
  <center class="mayuscula"><em>Abreviaturas</em></center>
  <center><table>
    <tr>
      <td>Chuquisaca</td>
      <td>= CH</td>
    </tr>
    <tr>
      <td>La Paz</td>
      <td>= LP</td>
    </tr>
    <tr>
      <td>Cochabamba</td>
      <td>= CB</td>
    </tr>
    <tr>
      <td>Oruro</td>
      <td>= OR</td>
    </tr>
    <tr>
      <td>Potosí</td>
      <td>= PT</td>
    </tr>
    <tr>
      <td>Tarija</td>
      <td>= TJ</td>
    </tr>
    <tr>
      <td>Santa Cruz</td>
      <td>= SC</td>
    </tr>
    <tr>
      <td>Beni</td>
      <td>= BE</td>
    </tr>
    <tr>
      <td>Pando</td>
      <td>= PD</td>
    </tr>
  </table></center>
</div>