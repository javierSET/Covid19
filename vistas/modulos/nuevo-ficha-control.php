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

            <li class="breadcrumb-item active">Nueva Ficha Control COVID-19</li>

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
            <?php 
                $item = "id_ficha";
                $valor = $_GET["idFicha"];
                $ficha = ControladorFichas::ctrMostrarDatosFicha($item,$valor);                
                /*===================================
                    busqueda de Establecimineto
                 ===================================*/
                $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos("id", $ficha['id_establecimiento']);
                //var_dump($establecimientos);
                /*============================================
                    busqueda de Consultorio
                ==============================================*/
                $consultorio = ControladorConsultorios::ctrMostrarConsultorios("id",$ficha['id_consultorio']);

                /*=============================================
                    busqueda de Departamentos
                ==============================================*/
                $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos("id", $ficha['id_departamento']);

                /*=============================================
                    busqueda de Municipio
                ===============================================*/
                $municipio = ControladorMunicipio::ctrMostrarMunicipio("id",$ficha['id_municipio']);

                /*=============================================
                    Busqueda De Asegurado
                ===============================================*/
                $paciente_asegurado = ControladorPacientesAsegurados::ctrMostrarPacientesAsegurados('id_ficha',$valor);
                //var_dump($paciente_asegurado);

            ?>

            <div class="form-group col-md-4">
              <label class="m-0 font-weight-normal" for="nuevoEstablecimientoSeguimiento">Establecimiento de Salud / Centro Aislamiento<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoEstablecimientoSeguimiento" id="nuevoEstablecimientoSeguimiento" disabled>
                <option value="<?= $establecimientos['id']?>" selected> <?= $establecimientos['nombre_establecimiento']?> </option>                
              </select>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoConsultorioSeguimiento">Consultorio</label>
              <select class="form-control form-control-sm" name="nuevoConsultorioSeguimiento" id="nuevoConsultorioSeguimiento" disabled>
                <option value="<?= $consultorio['id']?>"><?= $consultorio['nombre_consultorio']?></option>               
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoDepartamentoSeguimiento">Departamento<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoDepartamentoSeguimiento" id="nuevoDepartamentoSeguimiento" disabled>
                <option value="<?= $departamentos['id']?>"><?= $departamentos['nombre_depto']?></option>                
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoLocalidadSeguimiento">Municipio/Localidad<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoLocalidadSeguimiento" id="nuevoLocalidadSeguimiento" disabled>
                <option value="<?= $municipio['id']?>"><?= $municipio['nombre_municipio']?></option>               
              </select>
            </div> 
            
          </div>

          <div class="form-row">
              <div class="form-group col-md-3">
                <label class="m-0 font-weight-normal" for="nuevoFechaNotificacionSeguimiento">Fecha de Notificación<span class="text-danger font-weight-bold"> *</span></label>
                <input type="date" value="<?= $ficha['fecha_notificacion']?>" class="form-control form-control-sm" name="nuevoFechaNotificacionSeguimiento" id="nuevoFechaNotificacionSeguimiento" readonly>
              </div>

              <div class="form-group col-md-2">
                <label class="m-0 font-weight-normal" for="nuevoNroControlSeguimiento">Control<span class="text-danger"> *</span></label>
                <select class="form-control form-control-sm col-md-6" name="nuevoNroControlSeguimiento" id="nuevoNroControlSeguimiento">
                  <option value="">Elegir...</option>
                  <option value="1°">1°</option>
                  <option value="2°">2°</option>
                  <option value="3°">3°</option>
                  <option value="4°">4°</option>
                </select>
              </div>            
          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 2. IDENTIFICACION DEL CASO/PACIENTE
      =============================================--> 

      <div class="card mb-0">
        <div class="card-header bg-dark py-1 text-center">
          <span>2. IDENTIFICACION DEL CASO/PACIENTE</span>          
        </div>
        <div class="card-body">
          <div class="form-row">            
            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodAseguradoSeguimiento">Cod. Asegurado<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" id="nuevoCodAseguradoSeguimiento" name="nuevoCodAseguradoSeguimiento" disabled>
                <option value="<?=$paciente_asegurado['cod_asegurado']?>"><?=$paciente_asegurado['cod_asegurado']?></option>
              </select>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodAfiliadoSeguimiento">Cod. Afiliado</label>
              <input type="text" value="<?=$paciente_asegurado['cod_afiliado']?>" class="form-control form-control-sm" name="nuevoCodAfiliadoSeguimiento" id="nuevoCodAfiliadoSeguimiento" readonly>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodEmpleadorSeguimiento">Cod. Empleador</label>
              <input type="text" value="<?=$paciente_asegurado['cod_empleador']?>" class="form-control form-control-sm" name="nuevoCodEmpleadorSeguimiento" id="nuevoCodEmpleadorSeguimiento" readonly>
            </div>

            <div class="form-group col-md-6">
              <label class="m-0 font-weight-normal" for="nuevoNombreEmpleadorSeguimiento">Nombre Empleador(s)</label>
              <input type="text" value="<?=$paciente_asegurado['nombre_empleador']?>" class="form-control form-control-sm" name="nuevoNombreEmpleadorSeguimiento" id="nuevoNombreEmpleadorSeguimiento" readonly>
            </div>

          </div>

          <div class="form-row">            
            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoPaternoPacienteSeguimiento">Ap. Paterno</label>
              <input type="text" value="<?=$paciente_asegurado['paterno']?>" class="form-control form-control-sm" name="nuevoPaternoPacienteSeguimiento" id="nuevoPaternoPacienteSeguimiento" readonly>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoMaternoPacienteSeguimiento">Ap. Materno</label>
              <input type="text" value="<?=$paciente_asegurado['materno']?>" class="form-control form-control-sm" name="nuevoMaternoPacienteSeguimiento" id="nuevoMaternoPacienteSeguimiento" readonly>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoNombrePacienteSeguimiento">Nombre(s)</label>
              <input type="text" value="<?=$paciente_asegurado['nombre']?>" class="form-control form-control-sm" name="nuevoNombrePacienteSeguimiento" id="nuevoNombrePacienteSeguimiento" readonly>
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoSexoPacienteSeguimiento">Sexo<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm" name="nuevoSexoPacienteSeguimiento" id="nuevoSexoPacienteSeguimiento" disabled>
                <?php
                    if($paciente_asegurado['sexo']=='F'){
                      ?>
                      <option value="<?=$paciente_asegurado['sexo']?>" selected>FEMENINO</option>
                    <?php
                    }
                    else if($paciente_asegurado['sexo']=='M'){
                    ?>
                      <option value="<?=$paciente_asegurado['sexo']?>" selected>MASCULINO</option>
                    <?php
                    }
                  ?>
              </select>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoNroDocumentoPacienteSeguimiento">Nro. Documento<span class="text-danger font-weight-bold"> *</span></label>
              <input class="form-control form-control-sm" value="<?=$paciente_asegurado['nro_documento']?>" name="nuevoNroDocumentoPacienteSeguimiento" id="nuevoNroDocumentoPacienteSeguimiento" readonly>
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoFechaNacPacienteSeguimiento">Fecha de Nacimiento</label>
              <input type="date" value="<?=$paciente_asegurado['fecha_nacimiento']?>" class="form-control form-control-sm" name="nuevoFechaNacPacienteSeguimiento" id="nuevoFechaNacPacienteSeguimiento" readonly>
            </div>

            <div class="form-group col-md-1">
              <label class="m-0 font-weight-normal" for="nuevoEdadPacienteSeguimiento">Edad</label>
              <input type="text" value="<?=$paciente_asegurado['edad']?>" class="form-control form-control-sm" name="nuevoEdadPacienteSeguimiento" id="nuevoEdadPacienteSeguimiento" readonly>
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoTelefonoPacienteSeguimiento">Teléfono</label>
              <input type="text" value="<?=$paciente_asegurado['telefono']?>" class="form-control form-control-sm" name="nuevoTelefonoPacienteSeguimiento" id="nuevoTelefonoPacienteSeguimiento" readonly>
            </div>

          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 3. SEGUIMIENTO
      =============================================-->  

      <div class="card mb-0">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>3. SEGUIMIENTO</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">
            
            <div class="form-group col-md-5">
              <label class="m-0" for="nuevoDiasNotificacionSeguimiento">¿Han pasado 14 días desde la notificación?<span class="text-danger"> *</span></label>
              <select class="form-control form-control-sm col-md-4" name="nuevoDiasNotificacionSeguimiento" id="nuevoDiasNotificacionSeguimiento" required>
                  <option value="">Elegir...</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>
              </select>

            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoDiasSinSintomasSeguimiento">N° de días SIN sintomas</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoDiasSinSintomasSeguimiento" id="nuevoDiasSinSintomasSeguimiento">
            </div>

          </div>

          <div class="form-row">
            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoFechaAislamientoSeguimiento">Fecha de Aislamiento</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaAislamientoSeguimiento" id="nuevoFechaAislamientoSeguimiento">
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoLugarAislamientoSeguimiento">Lugar de Aislamiento</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoLugarAislamientoSeguimiento" id="nuevoLugarAislamientoSeguimiento">
            </div>

            <div class="form-group col-md-2">
              
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoFechaInternacionSeguimiento">Fecha de Internación</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaInternacionSeguimiento" id="nuevoFechaInternacionSeguimiento">
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoEstablecimientoInternacionSeguimiento">Establecimiento de salud de internación</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoEstablecimientoInternacionSeguimiento" id="nuevoEstablecimientoInternacionSeguimiento">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoFechaIngresoUTISeguimiento">Fecha de Ingreso a UTI</label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaIngresoUTISeguimiento" id="nuevoFechaIngresoUTISeguimiento" placeholder="dd-mm-yyyy" value="" max="2030-12-31">
            </div>

            <div class="form-group col-md-3">
              <label class="m-0 font-weight-normal" for="nuevoLugarIngresoUTISeguimiento">Lugar de UTI</label>
              <input type="text" class="form-control form-control-sm mayuscula" name="nuevoLugarIngresoUTISeguimiento" id="nuevoLugarIngresoUTISeguimiento">
            </div>

            <div class="form-group col-md-3">
              <label class="m-0" for="nuevoVentilacionMecanicaSeguimiento">Ventilación mecánica<span class="text-danger font-weight-bold"> *</span></label>
              <select class="form-control form-control-sm col-md-6" name="nuevoVentilacionMecanicaSeguimiento" id="nuevoVentilacionMecanicaSeguimiento">
                  <option value="">Elegir...</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>
              </select>

            </div>

          </div>

          <div class="form-row">

            <div class="icheck-silver mr-5">
              <label class="font-weight-normal">Tratamiento</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoTratamientoSeguimiento" value="ANTIVIRAL" id="nuevoAntiviralSeguimiento">
              <label class="font-weight-normal" for="nuevoAntiviralSeguimiento">Antiviral</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoTratamientoSeguimiento" value="ANTIBIÓTICO" id="nuevoAntibioticoSeguimiento">
              <label class="font-weight-normal" for="nuevoAntibioticoSeguimiento">Antibiótico</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoTratamientoSeguimiento" value="ANTIPARASITARIO" id="nuevoAntiparasitarioSeguimiento">
              <label class="font-weight-normal" for="nuevoAntiparasitarioSeguimiento">Antiparasitario</label>
            </div>

            <div class="icheck-silver mr-5">
              <input type="checkbox" name="nuevoTratamientoSeguimiento" value="ANTIFLAMATORIO" id="nuevoAntiflamatorioSeguimiento">
              <label class="font-weight-normal" for="nuevoAntiflamatorioSeguimiento">Antiflamatorio</label>
            </div>

            <div class="form-inline col-md-3">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoTratamientoOtrosSeguimiento">Otros</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoTratamientoOtrosSeguimiento" name="nuevoTratamientoOtrosSeguimiento"> 
            </div>

          </div>
          
        </div>

      </div>

      <!--=============================================
      SECCION 4. LABORATORIO
      =============================================-->  

      <div class="card mb-0 fichaControlLaboratorio">
        
        <div class="card-header bg-dark py-1 text-center">

          <span>4. LABORATORIO</span>
          
        </div>

        <div class="card-body">

          <div class="form-row">
            <div class="form-group col-md-3">            
              <label class="m-0" for="nuevoTipoMuestraSeguimiento">Tipo de muestra tomada<span class="text-danger font-weight-bold"> *</span></label> 
              <input list="tipoMuestra" class="form-control form-control-sm mayuscula" id="nuevoTipoMuestraSeguimiento" name="nuevoTipoMuestraSeguimiento">
              <datalist id="tipoMuestra">
                <option value="ASPIRADO"></option>
                <option value="LAVADO BRONCO ALVELAR"></option>
                <option value="HISOPADO NASOFARÍNGEO"></option>
                <option value="HISOPADO COMBINADO"></option>
              </datalist>
            </div>

            <div class="form-group col-md-3">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoNombreLaboratorioSeguimiento">Nombre de Lab. que procesara la muestra</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoNombreLaboratorioSeguimiento" name="nuevoNombreLaboratorioSeguimiento"> 
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoFechaMuestraSeguimiento">Fecha de toma de muestra<span class="text-danger font-weight-bold"> *</span></label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaMuestraSeguimiento" id="nuevoFechaMuestraSeguimiento">
            </div>

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoFechaEnvioSeguimiento">Fecha de Envío<span class="text-danger"> *</span></label>
              <input type="date" class="form-control form-control-sm" name="nuevoFechaEnvioSeguimiento" id="nuevoFechaEnvioSeguimiento">
            </div>
            
          </div>

          <div class="form-row">

            <div class="form-group col-md-2">
              <label class="m-0 font-weight-normal" for="nuevoCodLaboratorioSeguimiento">Cod. Laboratorio<span class="text-danger font-weight-bold"> *</span></label>
              <input type="text" class="form-control form-control-sm" name="nuevoCodLaboratorioSeguimiento" id="nuevoCodLaboratorioSeguimiento">
            </div>

            <div class="form-group col-md-4">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoResponsableMuestraSeguimiento">Responsable de Toma de Muestra<span class="text-danger font-weight-bold"> *</span></label>
              <input type="text" class="form-control form-control-sm mayudcula" name="nuevoResponsableMuestraSeguimiento" id="nuevoResponsableMuestraSeguimiento">
            </div>

            <div class="form-group col-md-6">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoObsMuestraSeguimiento">Observaciones</label>
              <input type="text" class="form-control form-control-sm" id="nuevoObsMuestraSeguimiento" name="nuevoObsMuestraSeguimiento">
            </div>

          </div>

          <div class="form-row">

            <div class="form-group col-md-4">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoResultadoLaboratorio">Resultados Laboratorio<span class="text-danger font-weight-bold"> *</span></label>            
              <div class="icheck-danger icheck-inline">
                <input type="radio" name="positivoSeguimiento" id="positivoSeguimiento" value="POSITIVO">
                <label for="positivoSeguimiento">
                  POSITIVO
                </label>
              </div>
              <div class="icheck-success icheck-inline">
                <input type="radio" name="negativoSeguimiento" id="negativoSeguimiento" value="NEGATIVO">
                <label for="negativoSeguimiento">
                  NEGATIVO
                </label>
              </div>        

            </div>

            <div class="form-group col-md-3">
              <label class="my-0 mr-2 font-weight-normal" for="nuevoFechaResultadoSeguimiento">Fecha de Resultado<span class="text-danger font-weight-bold"> *</span></label>
              <input type="date" class="form-control form-control-sm" id="nuevoFechaResultadoSeguimiento" name="nuevoFechaResultadoSeguimiento" >
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
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoTelefonoNotif" name="nuevoTelefonoNotif" data-inputmask="'mask': '9{7,8}'" value="<?= $persona_notificador['telefono_notificador'] ?>" readonly> 
            </div>

            <div class="form-group col-md-3">            
              <label class="my-0 mr-2 font-weight-normal" for="nuevoCargoNotif">Cargo</label>
              <input type="text" class="form-control form-control-sm mayuscula" id="nuevoCargoNotif" name="nuevoCargoNotif" value="<?= $persona_notificador['cargo_notificador'] ?>" readonly>
            </div>

          </div>
          
        </div>

        <div class="card-footer">
          <div class="float-right">
            <input type="hidden" id="idFicha" value="">
            <button type="button" class="btn btn-primary" id="btnGuardarSeguimiento">
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


<!--=====================================
MODAL AGREGAR NUEVA PERSONA CONTACTO
======================================-->

<div id="modalNuevoPersonaContacto" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="agregarPersonaContacto" aria-hidden="true">

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