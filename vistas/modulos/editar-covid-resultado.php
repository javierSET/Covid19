<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Editar Registro COVID-19

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item"><a href="covid-resultados" class="menu" id="covid-resultados"> Resultados Covid-19</a></li>

            <li class="breadcrumb-item active">Editar Registro COVID-19</li>

          </ol>

        </div>

      </div>

    </div>

  </div>
  
  <section class="content">

    <div class="container-fluid">

      <form role="form" method="post" enctype="multipart/form-data" class="formularioEditarRegCovid19">

        <div class="row">

          <!--=============================================
          SECCION PARA LA ENTRADA DE DATOS PERSONALES
          =============================================-->

          <div class="col-md-12 col-xs-12">
            
            <div class="card card-outline card-info">

              <div class="card-header">

              <?php 
               
                $item = "id";
                $valor = $_GET["idCovidResultado"];

                $covidResultado = ControladorCovidResultados::ctrMostrarCovidResultados($item, $valor);

                $laboratorio = ControladorLaboratorios::ctrMostrarLaboratorios('id_ficha',$covidResultado['id_ficha']);
                
                /*=============================================
                TRAEMOS LOS DATOS DE DEPARTAMENTO
                =============================================*/
                
                $valor = $covidResultado["id_departamento"];

                $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

                /*=============================================
                TRAEMOS LOS DATOS DE ESTABLECIMIENTO
                =============================================*/

                $valor = $covidResultado["id_establecimiento"];

                $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

                /*=============================================
                TRAEMOS LOS DATOS DE LOCALIDAD
                =============================================*/

                $valor = $covidResultado["id_localidad"];

                $localidades = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);


              ?>
                
                <p><b>Matricula: </b><?= $covidResultado['cod_asegurado'] ?></p>
                <p><b>Nombre o Razón Social del Empleador: </b><?= $covidResultado['nombre_empleador'] ?></p>
                <p><b>Nro. Empleador: </b><?= $covidResultado['cod_empleador'] ?></p>

              </div>

              <div class="card-body">

                <div class="form-row">

                   <div class="form-group col-md-4">
                    <label for="editarFechaMuestra">Fecha Toma de Muestra</label>
                    <input type="date" class="form-control" id="editarFechaMuestra" name="editarFechaMuestra" value="<?= $covidResultado['fecha_muestra'] ?>" readonly>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="editarMuestraControl">Muestra de Control</label>
                    <select class="form-control" id="editarMuestraControl" name="editarMuestraControl" readonly>
                      <option value="<?= $covidResultado['muestra_control'] ?>"><?= $covidResultado['muestra_control'] ?></option>
                      <?php 

                        if ($covidResultado['muestra_control'] == "SI") {

                          echo '<option value="NO">NO</option>';
                          
                        } else {
                          
                          echo '<option value="SI">SI</option>';

                        }

                      ?>                      
                      
                    </select>
                  </div>

<!--                   <div class="form-group col-md-3">
                    <label for="nuevaMuestraControl">Tipo de Muestra</label>
                    <input list="tipoMuestra" class="form-control" id="editarTipoMuestra" name="editarTipoMuestra" value="<?= $covidResultado['tipo_muestra'] ?>" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">
                    <datalist id="tipoMuestra">
                      <option value="ELISA">
                      <option value="ASPIRADO">
                      <option value="LAVADO BRONCO ALVEOLAR">
                      <option value="HISOPADO NASOFARÍNGEO">
                      <option value="HISOPADO COMBINADO">
                    </datalist>
                  </div>   -->    

                  <div class="form-group col-md-4">
                    <label for="editarFechaRecepcion">Fecha Recepción</label>
                    <input type="date" class="form-control" id="editarFechaRecepcion" name="editarFechaRecepcion" value="<?= $covidResultado['fecha_recepcion'] ?>" readonly>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-2">
                    <label for="editarCodLab">Cód. Lab.</label>
                    <input type="text" class="form-control mayuscula" id="editarCodLab" name="editarCodLab" value="<?= $covidResultado['cod_laboratorio'] ?>" required>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="editarNombreLab">Nombre Lab.</label>
                    <input type="text" class="form-control mayuscula" id="editarNombreLab" name="editarNombreLab" value="<?= $covidResultado['nombre_laboratorio'] ?>" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="editarDepartamento">Departamento</label>
                    <select class="form-control" id="editarDepartamento" name="editarDepartamento" readonly>
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
                  
                  <div class="form-group col-md-4">
                    <label for="editarEstablecimiento">Establecimiento</label>
                    <select class="form-control" id="editarEstablecimiento" name="editarEstablecimiento" readonly>
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

                </div>
               
                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="editarPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control mayuscula" id="editarPaterno" name="editarPaterno" value="<?= $covidResultado['paterno'] ?>" readonly>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="editarMaterno">Apellido Materno</label>
                    <input type="text" class="form-control mayuscula" id="editarMaterno" name="editarMaterno" value="<?= $covidResultado['materno'] ?>" readonly>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="editarNombre">Nombre</label>
                    <input type="text" class="form-control mayuscula" id="editarNombre" name="editarNombre" value="<?= $covidResultado['nombre'] ?>" readonly>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="editarDocumentoCI">Nro. CI</label>
                    <input type="text" class="form-control" id="editarDocumentoCI" name="editarDocumentoCI" value="<?= $covidResultado['documento_ci'] ?>" readonly pattern="[A-Za-z0-9-]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="editarSexo">Sexo</label>
                    <select class="form-control" id="editarSexo" name="editarSexo" readonly>
                      <?php 

                      if ($covidResultado['sexo'] == "F") {

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

                  <div class="form-group col-md-4">
                    <label for="nuevaFechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="editarFechaNacimiento" name="editarFechaNacimiento" value="<?= $covidResultado['fecha_nacimiento'] ?>" readonly>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="editarTelefono">Teléfono o Celular</label>
                    <input type="text" class="form-control" id="editarTelefono" name="editarTelefono" data-inputmask="'mask': '9{7,8}'" pattern="[0-9]{7,8}+" title="Solo deben ir números en el campo" value="<?= $covidResultado['telefono'] ?>" readonly>
                  </div>

                  <div class="form-group col-md-8">
                    <label for="editarEmail">Em@il</label>
                     <input type="text" class="form-control" id="editarEmail" name="editarEmail" data-inputmask="'alias': 'email'" inputmode="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Introduzca formato de email válido" value="<?= $covidResultado['email'] ?>" readonly>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="editarLocalidad">Localidad</label>
                    <select class="form-control" id="editarLocalidad" name="editarLocalidad" readonly>
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
                    <label for="editarZona">Zona</label>
                    <input type="text" class="form-control mayuscula" id="editarZona" name="editarZona" value="<?= $covidResultado['zona'] ?>" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo" readonly>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="editarCalle">Calle</label>
                    <input type="text" class="form-control mayuscula" id="editarCalle" name="editarCalle" value="<?= $covidResultado['calle'] ?>" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo" readonly>
                  </div>

                  <div class="form-group col-md-2">
                    <label for="editarNroCalle">Nro</label>
                    <input type="text" class="form-control" id="editarNroCalle" name="editarNroCalle" value="<?= $covidResultado['nro_calle'] ?>" pattern="[a-zA-Z0-9 .-/]+" title="Caracteres no admitidos" readonly>
                  </div>

                </div>

                </br>

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
                          <input type="checkbox" name="tomoMuestraLaboratorioSi" value="" id="tomoMuestraLaboratorioSi" <?php echo $laboratorio['estado_muestra']=="SI" ? 'checked':'' ?> >
                          <label class="font-weight-normal" for="tomoMuestraLaboratorioSi">Si</label>              
                        </div>

                        <div class="checkbox icheck-primary col-md-3">                
                          <input type="checkbox" name="tomoMuestraLaboratorioNo" value="" id="tomoMuestraLaboratorioNo" <?php echo $laboratorio['estado_muestra']=="NO" ? 'checked':'' ?> >
                          <label class="font-weight-normal" for="tomoMuestraLaboratorioNo">No</label>
                        </div>
                        
                          <div class="form-group col-md-4" id="divNoTomaMuestra" <?php echo $laboratorio['estado_muestra']=="SI" ? 'style="display: none;"':'' ?> >
                            <label class="m-0 font-weight-normal" for="rechazoMuestra">Porque no se tomo la muestra</label> 
                            <input list="rechazoMuestraL" class="form-control form-control-sm mayuscula" id="rechazoMuestra" name="rechazoMuestra" value="<?= $laboratorio['des_no_muestra'] ?>" multiple="multiple">
                            <datalist id="rechazoMuestraL">
                              <option value="RECHAZO">
                              <option value="FALTA DE INSUMOS /EPP">
                              <option value="FALLECIDO">               
                            </datalist> 
                          </div>

                          <div class="form-group col-md-4" id="divTipoMuestra" <?php echo $laboratorio['estado_muestra']=="NO" ? 'style="display: none;"':'' ?> >            
                            <label class="m-0 font-weight-normal" for="nuevoTipoMuestra">Tipo de Muestra</label> 
                            <input list="tipoMuestra" class="form-control form-control-sm mayuscula" id="nuevoTipoMuestra" name="nuevoTipoMuestra" value="<?= $laboratorio['tipo_muestra'] ?>" multiple="multiple">
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
                            <input type="text" class="form-control form-control-sm mayuscula" id="nuevoNombreLaboratorio" name="nuevoNombreLaboratorio" value="<?= $laboratorio['nombre_laboratorio'] ?>" readonly>
                        </div>

                        <div class="form-group col-md-4" id="divFechaMuestra" <?php echo $laboratorio['estado_muestra']=="NO" ? 'style="display: none;"':'' ?>>
                          <label class="m-0 font-weight-normal" for="nuevoFechaMuestra">Fecha de toma de muestra<span class="text-danger font-weight-bold"> *</span></label>
                          <input type="date" class="form-control form-control-sm" name="nuevoFechaMuestra" min="2021-01-01" max="<?php echo date('Y-m-d'); ?>" id="nuevoFechaMuestra" value="<?=$laboratorio['fecha_muestra'] ?>" > 
                        </div>

                        <div class="form-group col-md-4"  id="divFechaEnvio" <?php echo $laboratorio['estado_muestra']=="NO" ? 'style="display: none;"':'' ?>>
                          <label class="m-0 font-weight-normal" for="nuevoFechaEnvio">Fecha de Envío<span class="text-danger"> *</span></label>                        
                          <input type="date" class="form-control form-control-sm" name="nuevoFechaEnvio" min="2021-01-01" max="<?php echo date('Y-m-d'); ?>" id="nuevoFechaEnvio" value="<?=$laboratorio['fecha_envio'] ?>" <?php echo $laboratorio['metodo_diagnostico_prueba_antigenica']=="Prueba Antigénica" ? 'disabled':'' ?>>
                        </div>

                      </div>

                      <div class="form-row">

                        <div class="form-group col-md-4">

                          <label class="my-0 mr-2 font-weight-normal" for="nuevoResponsableMuestra">Responsable de Toma de Muestra<span class="text-danger font-weight-bold"> *</span></label>
                          <input type="text" class="form-control form-control-sm mayuscula" name="nuevoResponsableMuestra" id="nuevoResponsableMuestra" value="<?= $laboratorio['responsable_muestra'] ?>" />

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
                          <input type="text" class="form-control form-control-sm" id="nuevoObsMuestra" name="nuevoObsMuestra" value="<?=$laboratorio['observaciones_muestra'] ?>"> 
                        </div>
                      </div>

                    </div>

                  </div>      
                </div>

                </br>

                <div class="card-header bg-dark py-1 text-center">
                  <span>AGREGAR RESULTADOS</span>          
                </div>

                </br>

                <div class="form-row">
                  <div class="form-group col-md-3">
                  <label class="my-0 mr-2 font-weight-normal" >Metodo de Diagnostico<span class="text-danger font-weight-bold"> *</span></label>
                  </div>

                  <?php 
                    $metodo_diagnostico_pcr_tiempo_real = $laboratorio['metodo_diagnostico_pcr_tiempo_real'];
                    if($covidResultado['metodo_diagnostico_pcr_tiempo_real'] == 'RT-PCR en tiempo Real')
                        $metodo_diagnostico_pcr_tiempo_real = $covidResultado['metodo_diagnostico_pcr_tiempo_real'];

                    $metodo_diagnostico_pcr_genexpert = $laboratorio['metodo_diagnostico_pcr_genexpert'];
                    if($covidResultado['metodo_diagnostico_pcr_genexpert'] == 'RT-PCR GENEXPERT')
                        $metodo_diagnostico_pcr_genexpert = $covidResultado['metodo_diagnostico_pcr_genexpert'];

                    $metodo_diagnostico_prueba_antigenica = $laboratorio['metodo_diagnostico_prueba_antigenica'];
                    if($covidResultado['metodo_diagnostico_prueba_antigenica'] == 'Prueba Antigénica')
                        $metodo_diagnostico_prueba_antigenica = $covidResultado['metodo_diagnostico_prueba_antigenica'];
                  
                  ?>
                    <div class="icheck-silver mr-5 ">
                      <!-- <input type="checkbox" name="pcrTiempoReal" value="RT-PCR en tiempo Real" id="pcrTiempoReal" checked>  -->
                      <input type="checkbox" name="pcrTiempoReal" value="RT-PCR en tiempo Real" id="pcrTiempoReal" <?php echo $metodo_diagnostico_pcr_tiempo_real=="RT-PCR en tiempo Real" ? 'checked':'' ?>>
                      <label class="font-weight-normal" for="pcrTiempoReal" id="l1pcrTiemporeal" >RT-PCR en tiempo Real</label>
                    </div>     

                    <div class="icheck-silver mr-5">
                      <input type="checkbox" name="pcrGenExpert" value="RT-PCR GENEXPER" id="pcrGenExpert" <?php echo $metodo_diagnostico_pcr_genexpert=="RT-PCR GENEXPERT" ? 'checked':'' ?>> 
                      <label class="font-weight-normal" for="pcrGenExpert" id="l2pcrGenExpert" >RT-PCR GENEXPERT</label> 
                    </div>

                    <div class="icheck-silver mr-5">
                      <input type="checkbox" name="pruebaAntigenica" value="Prueba Antigenica" id="pruebaAntigenica" <?php echo $metodo_diagnostico_prueba_antigenica=="Prueba Antigénica" ? 'checked':'' ?>> 
                      <label class="font-weight-normal" for="pruebaAntigenica" id="l3pcrPruebaAntigenica">Prueba Antigénica</label>
                    </div>       
                </div>

                </br>

                <div class="form-row">

                  <div class="form-group col-md-3 text-center clearfix">

                    <label>Resultados Laboratorio<br>Covid-19</label>
                    
                    <?php

                    if ($covidResultado['resultado'] == "POSITIVO") {

                      echo '
                      <div class="icheck-danger">
                        <input type="radio" name="editarResultado" id="radio1" checked value="POSITIVO">
                        <label for="radio1" class="text-danger">
                          POSITIVO
                        </label>
                      </div>

                      <div class="icheck-success">
                        <input type="radio" name="editarResultado" id="radio2" value="NEGATIVO">
                        <label for="radio2" class="text-success">
                          NEGATIVO
                        </label>
                      </div>';
                       
                     } else {

                        if ($covidResultado['resultado'] == "NEGATIVO") {

                          echo '
                          <div class="icheck-danger">
                            <input type="radio" name="editarResultado" id="radio1" value="POSITIVO">
                            <label for="radio1" class="text-danger">
                              POSITIVO
                            </label>
                          </div>

                          <div class="icheck-success">
                            <input type="radio" name="editarResultado" id="radio2" checked value="NEGATIVO">
                            <label for="radio2" class="text-success">
                              NEGATIVO
                            </label>
                          </div>';

                        }
                        else {
                            echo '
                            <div class="icheck-danger">
                              <input type="radio" name="editarResultado" id="radio1" value="POSITIVO" required>
                              <label for="radio1" class="text-danger">
                                POSITIVO
                              </label>
                            </div>

                            <div class="icheck-success">
                              <input type="radio" name="editarResultado" id="radio2" value="NEGATIVO" required>
                              <label for="radio2" class="text-success">
                                NEGATIVO
                              </label>
                            </div>';

                        }
                       
                     }

                    ?>                               

                  </div>

                  <div class="form-group col-md-3">
                    <label for="editarFechaResultado">Fecha del Resultado<span class="text-danger font-weight-bold"> *</span></label>
                    <input type="date" class="form-control" id="editarFechaResultado" name="editarFechaResultado" value="<?= $covidResultado['fecha_resultado'] ?>" required>
                  </div>

                  <div class="form-group col-md-6 observacion">
                    <label for="editarObservacion">Observaciones</label>

                    <?php 

                      //if ($covidResultado['tipo_muestra'] != "ELISA") {   ==> lo comente por si necesitamos algun rato
                      if ($covidResultado['tipo_muestra'] != "NADA") {

                        echo 
                        '<textarea class="form-control mayuscula" id="editarObservacion" name="editarObservacion" placeholder="Ingresar observaciones (*Opcional)" rows="3" value="'.$covidResultado['observaciones'].'" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-(),/#]+" title="Caracteres no admitidos">'
                        .
                          $covidResultado['observaciones']
                        .'</textarea>';
                        
                      } else {

                        echo 
                        '<div class="form-group col-md-2">
                          <label for="lgM">lgM</label>
                          <input type="text" class="form-control" id="lgM" name="lgM" pattern="[0-9 ,]+" title="Solo se admiten números y ," required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="lgG">lgG</label>
                          <input type="text" class="form-control" id="lgG" name="lgG" pattern="[0-9 ,]+" title="Solo se admiten números y ," required>
                        </div>';
                      }

                    ?>
                    
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label class="my-0 mr-2 font-weight-normal" for="responsableAnalisis">Responsable de Analisis<span class="text-danger font-weight-bold"> *</span></label>
                    <input list="listaResponsables" class="form-control form-control-sm mayuscula" id="responsableAnalisis" name="responsableAnalisis" value="<?= $covidResultado['responsable_muestra'] ?>" required>
                        <?php
/*                             $analistas = array('Elegir','Shirley Viviana Peláez Vargas','Ruri Delgadillo Almendras','NORKA VASQUEZ CARVAJAL','Diego Bonifaz Pérez','Erika Quiroz Bustos');

                            for($i=0; $i < count($analistas); $i++){
                               if($covidResultado['responsable_muestra'] == $analistas[$i] ){
                                  echo '<option value="' . $analistas[$i]. '">'.$analistas[$i].'</option>';
                               }
                               else{
                                echo '<option value="' . $analistas[$i]. '">'.$analistas[$i].'</option>';
                               }
                            } */
                        ?>
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

              <div class="card-footer">

                <div class="float-right">

                  <input type="hidden" id="codAsegurado" name="codAsegurado" value="<?= rtrim($covidResultado['cod_asegurado']) ?>">

                  <input type="hidden" id="codAfiliado" name="codAfiliado" value="<?= rtrim($covidResultado['cod_afiliado']) ?>">

                  <input type="hidden" id="codEmpleador" name="codEmpleador" value="<?= $covidResultado['cod_empleador'] ?>">

                  <input type="hidden" id="idCovidResultado" name="idCovidResultado" value="<?= $_GET['idCovidResultado'] ?>">

                  <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $_SESSION['idUsuarioCOVID'] ?>">

                  <input type="hidden" id="idFicha" name="idFicha" value="<?= $covidResultado['id_ficha'] ?>">
                    
                  <button type="submit" class="btn btn-primary btnGuardar">

                    <i class="fas fa-save"></i>
                    Guardar Cambios

                  </button>

                </div>

              </div> 

            </div> 

          </div>
 
        </div>

      </form>

      <?php

        $editarCovidResultado = new ControladorCovidResultados();
        $editarCovidResultado -> ctrEditarCovidResultado();

      ?>    

    </div> 

  </section>
  
</div>