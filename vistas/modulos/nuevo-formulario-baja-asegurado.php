<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-7">
          <h1 class="m-0 text-dark">
            Nuevo Formulario de Baja con Laboratorio Externo
          </h1>
        </div>
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item active">Nuevo Formulario de Baja</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <section class="formularioBajasExterno">
    <div class="container-fluid">        
      <form role="form" method="post" enctype="multipart/form-data" class="formAgregarFormBaja">
        <div class="row">        
          <!--=============================================
          SECCION PARA BUSCAR AFILIADOS DESDE LA BD Y BUSCAR SU IDFORMULARIO ASIGNADO @DANPINCH
          =============================================-->
            <?php
              if(isset($_GET["idAfiliado"])){ //Paciente encontrado en la BD SIAIS

                $item1 = null;
                $item2 = "idafiliacion";
                $valor = $_GET["idAfiliado"];
                $afiliados = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);
                //$edad = calculaedad(date("d-m-Y",strtotime($afiliados['pac_fecha_nac'])));
                //$valor = $afiliados['pac_codigo'];
                //$item = "cod_afiliado";
                //$id_covid_resultado = ControladorCovidResultados::ctrMostrarCovidResultados($item,$valor);
                //var_dump($afiliados);
                //var_dump($edad);
                //var_dump($id_covid_resultado["id"]);
              }else if(isset($_GET["idPaciente"])){
                $paciente = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id',$_GET["idPaciente"]);
                $afiliados = array();
                $afiliados['pac_primer_apellido'] = $paciente['paterno'];
                $afiliados['pac_segundo_apellido'] = $paciente['materno'];
                $afiliados['pac_nombre'] = $paciente['nombre'];
                $afiliados['pac_numero_historia'] = $paciente['cod_asegurado'];
                $afiliados['emp_nro_empleador'] = $paciente['cod_empleador'];
                $afiliados['emp_nombre'] = $paciente['nombre_empleador'];
                $afiliados['pac_codigo'] = $paciente['cod_afiliado'];
                
                if($paciente['sexo'] == 'M')
                  $afiliados['idsexo'] = 1;
                else $afiliados['idsexo'] = 2;

                $afiliados['pac_documento_id'] = $paciente['nro_documento'];
                $afiliados['pac_fecha_nac'] = $paciente['fecha_nacimiento'];
              }
            ?>
          <!--=============================================
          SECCION PARA LA ENTRADA DE DATOS PERSONALES
          =============================================-->

          <div class="col-md-8 col-xs-12">            
            <div class="card card-outline card-info">
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col" colspan="4">
                        <div class="row">
                          <div class="col-2 text-center">
                            <img src="vistas/img/cns/cns-logo-simple.png" alt="" width="80%">
                          </div>
                          <div class="col-6 text-center">
                            <p class="mb-1">CAJA NACIONAL DE SALUD</p>
                            <p class="mb-1">DEPARTAMENTO DE AFILIACIÓN</p>
                            <p class="mb-1">CERTIFICADO DE INCAPACIDAD TEMPORAL</p>
                          </div>
                          <div class="col-4 text-right text-uppercase">
                            <p>Form AVC-09</p>
                          </div>
                        </div>

                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">AP. PATERNO</th>
                      <th scope="row">AP. MATERNO</th>
                      <th scope="row">NOMBRE</th>
                      <th scope="row">Número Asegurado</th>
                    </tr>

                    <tr>
                      <td>
                       <!--  <span id="paternoFormBaja"><?= $afiliados['pac_primer_apellido']?></span> -->
                        <input type="text" class="form-control form-control-sm mayuscula" name="paternoFormBaja" id="paternoFormBaja" value="<?= trim($afiliados['pac_primer_apellido']) ?>" >
                      </td>
                      <td>
                        <!-- <span id="maternoFormBaja"><?= $afiliados['pac_segundo_apellido']?></span> -->
                        <input type="text" class="form-control form-control-sm mayuscula" name="maternoFormBaja" id="maternoFormBaja" value="<?= trim($afiliados['pac_segundo_apellido']) ?>" >
                      </td>
                      <td>
                        <!-- <span id="nombreFormBaja"><?= $afiliados['pac_nombre']?></span> -->
                        <input type="text" class="form-control form-control-sm mayuscula" name="nombreFormBaja" id="nombreFormBaja" value="<?= trim($afiliados['pac_nombre']) ?>" >
                      </td>
                      <td>
                        <!-- <span id="codAseguradoFormBaja"><?= $afiliados['pac_numero_historia']?></span> -->
                        <input type="text" class="form-control form-control-sm mayuscula" name="codAseguradoFormBaja" id="codAseguradoFormBaja" value="<?= trim($afiliados['pac_numero_historia']) ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3" scope="row">
                        <span>NOMBRE O RAZON SOCIAL DEL EMPLEADOR</span>
                      </th>
                      <th scope="row">
                        <span>Número Empleador</span>
                      </th>
                    </tr>
                    <tr>
                      <td colspan="3">
                        <?php
                          if($afiliados['emp_nro_empleador']==0){
                              echo "<input class='form-control form-control-sm mayuscula' type='text' size='50' id='nombre_empleador' name='nombre_empleador' placeholder='Sin Empleador' required>";
                          }
                          else{
                            ?>                                
                            <input class='form-control form-control-sm mayuscula' type='text' size='50' id='nombre_empleador' name='nombre_empleador' value="<?= trim($afiliados['emp_nombre']);?>" required>                     
                          <?php  
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                            if($afiliados['emp_nro_empleador']==0){
                              echo "<input class='form-control form-control-sm mayuscula' type='text' id='cod_empleador' name='cod_empleador' placeholder='0' required>";
                          }
                          else{
                        ?>
                        <input class='form-control form-control-sm mayuscula' type='text' id='cod_empleador' name='cod_empleador' value="<?= trim($afiliados['emp_nro_empleador'])?>" required>
                      <?php
                          }
                      ?>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <div class="row">
                          <div class="col-md-8 border">
                            <div class="row m-0">
                              <label>RIESGO</label>
                            </div>
                            <div class="form-row m-0">
                              <div class="icheck-primary icheck-inline">
                                  <input type="radio" id="radio1" value="PROFESIONAL" name="riesgoFormBaja" disabled>
                                  <label for="radio1">PROFESIONAL</label>
                                </div>
                                <div class="icheck-primary icheck-inline">
                                  <input type="radio" id="radio2" value="ENFERMEDAD" name="riesgoFormBaja" checked>
                                  <label for="radio2">ENFERMEDAD</label>
                                </div>
                                <div class="icheck-primary icheck-inline">
                                  <input type="radio" id="radio3" value="MATERNIDAD" name="riesgoFormBaja" disabled>
                                  <label for="radio3">MATERNIDAD</label>
                                </div>
                            </div>                                                        
                            <div class="form-group row m-0">
                              <label>INCAPACIDAD</label>
                            </div>

                            <div class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">DESDE</label>
                              <div class="col-md-5">
                                <input type="date" class="form-control form-control-sm" id="fechaIniFormBaja" name="fechaIniFormBaja" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>" required>
                              </div>
                            </div>

                            <div class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">HASTA</label>
                              <div class="col-md-5">
                                <input type="date" class="form-control form-control-sm" id="fechaFinFormBaja" name="fechaFinFormBaja" value="" min="<?php echo date('Y-m-d') ?>" required>
                              </div>
                            </div>

                            <div id="divObservaciones" class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">OBSERVACION</label>
                                <textarea class="form-control mayuscula" id="observacionesBaja" name="observacionesBaja" rows="3" required></textarea> <!--quitamos readonly-->
                            </div>
                           
                            <div class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">DÍAS DE INCAPACIDAD</label>
                              <div class="col-md-5">
                                <input type="text" class="form-control form-control-sm" id="diasIncapacidadFormBaja" name="diasIncapacidadFormBaja" value="" readonly>
                              </div>                              
                            </div>

                            <div class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">ESTABLECIMIENTO</label>
                              <div class="col-md-7">
                                <select class="form-control form-control-sm" id="establFormNuevaBaja" name="establFormNuevaBaja" required>
                                  <option></option>                              
                                  <option value="1">Centro Centinela covid-19 Anexo N32</option>
                                  <option value="2">CIMFA SUR</option>
                                  <option value="3">CIMFA QUILLACOLLO</option>
                                  <option value="4">HOSPITAL OBRERO NRO 2</option>
                                  <option value="13">CIMFA M.A.V.-CLINICA POLICIAL</option>
                                </select>
                              </div>                              
                            </div>

                            <div class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">Lugar y Fecha</label>
                              <div class="col-md-4">
                                <select class="form-control form-control-sm" id="lugarFormNuevaBaja" name="lugarFormNuevaBaja" required>                                  
                                  <option value="COCHABAMBA">COCHABAMBA</option>
                                </select>
                              </div>
                              <div class="col-md-5">
                                <input type="date" class="form-control form-control-sm" id="fechaFormNuevaBaja" name="fechaFormBaja" value="<?php echo date('Y-m-d') ?>" required>
                              </div>
                            </div>

                            <div class="form-group row m-1">
                              <label class="col-form-label col-form-label-sm">CLAVE</label>
                              <div class="col-md-5">
                                <input type="text" class="form-control form-control-sm" id="claveFormNuevaBaja" name="claveFormNuevaBaja" value="<?= $afiliados['pac_numero_historia'];?>" required readonly>
                              </div>
                            </div>

                          </div>

                          <div class="col-md-4 border">
                            <p>Salario Bs.</p>
                            <p>Importe Subsidio</p>
                            <p>SON:</p>
                            <br>
                            <p>CERTIFICO</p>
                            <br>
                            <p class="text-center">Nombre y Firma C.N.S.</p>                          
                          </div>
                        </div>
                      </td>                     
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="card-footer">
                <div class="float-right">
                  <input type="hidden" id="idCovidResultado" name="idCovidResultado" value="-1">
                  <input type="hidden" id="idFormularioBaja" name="idFormularioBaja" value="">
                  <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $_SESSION['idUsuarioCOVID'] ?>">
                  <input type="hidden" id="cod_asegurado" name="cod_asegurado" value="<?= $afiliados['pac_numero_historia'];?>">
                  <input type="hidden" id="cod_afiliado" name="cod_afiliado" value="<?= $afiliados['pac_codigo'];?>">                                    
                  <input type="hidden" id="paterno" name="paterno" value="<?= $afiliados['pac_primer_apellido'];?>">
                  <input type="hidden" id="materno" name="materno" value="<?= $afiliados['pac_segundo_apellido'];?>">
                  <input type="hidden" id="nombre" name="nombre" value="<?= $afiliados['pac_nombre'];?>">
                  <input type="hidden" id="sexo" name="sexo" value="<?= $afiliados['idsexo']=="1"?'M':'F';?>" >
                  <input type="hidden" id="nro_documento" name="nro_documento" value="<?= $afiliados['pac_documento_id'];?>">
                  <input type="hidden" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $afiliados['pac_fecha_nac'];?>">
                  <input type="hidden" id="idPaciente" name="idPaciente" value="<?= isset($_GET['idPaciente'])? $_GET['idPaciente']:'-1' ?>">
                  <input type="hidden" id="edad" name="edad" value="0">                    
                  <button type="submit" class="btn btn-primary" id="btnGuardarFormBaja">
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
        $nuevoFormularioBajas = new ControladorFormularioBajas();
        $nuevoFormularioBajas -> ctrNuevoFormularioBaja();
      ?>
    </div>
  </section>  
</div>