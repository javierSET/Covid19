<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Ficha Epidemiológica

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio"><i class="fas fa-tachometer-alt"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Centro COVID</li>

          </ol>

        </div>

      </div>

    </div>

  </div>
 
  <section class="content">

    <div class="container-fluid">

      <div class="row">

        <div class="col-md-12">

          <div class="card">

            <div class="card-header">

            <?php 

              if ($_SESSION['perfilUsuarioCOVID'] == "MEDICO" OR $_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM") {

            ?>

              <div class="form-row mb-3">
                <button class="btn btn-primary btnNuevaFichaEpidemiologica">
                  <i class="fas fa-plus"></i>
                  Nueva Ficha Epidemiológica                
                </button>             

                <?php 

                if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM") {
                ?>
                <button class="btn btn-primary btnNuevaFichaControl ml-3" disabled>
                  <i class="fas fa-plus"></i>
                  Nueva Ficha Seguimiento                
                </button>
                
                <button class="btn btn-outline-danger ml-3" id="btnGenerarPDFS" disabled>
                  <i class="fas fa-plus"></i>
                  Generar Todos los PDFS 
                </button>

                <button class="btn btn-outline-danger ml-3" id="btnCompararLabCovidResultados">
                  <i class="fas fa-plus"></i>
                  Comparar Lab-Covid
                </button>

                <button class="btn btn-outline-danger ml-3" id="btnBorrarFichasMalasAll" >
                  <i class="fas fa-plus"></i>
                  Borrar Fichas Incompletas
                </button>

              <?php  } ?>  

              </div>

            <?php 

              }

            ?> 


            <?php 

            if ($_SESSION['perfilUsuarioCOVID'] == "ADMIN_SYSTEM") {
            ?>

              <div class="form-row">
                
                <div class="input-group col-md-4">

                  <label class="px-2 mt-1 font-weight-normal">Fecha de Toma de Muestra: </label>
                  
                  <input type="date" class="form-control" id="fechaMuestra" min="2020-01-01" max="<?= date("Y-m-d") ?>">

                </div>

                <div class="form-group col-md-2">
                  
                  <button type="button" class="btn btn-primary px-2 btnBuscarFichaFecha" perfilOculto="<?= $_SESSION['perfilUsuarioCOVID']; ?>" actionBuscarFichaFecha="fecha_muestra">
                
                    <i class="fas fa-search"></i> Buscar
                  
                  </button>  
                </div>       

              </div>

            <?php } ?>

               <div>           
                  <input type="hidden" value="<?= $_SESSION['paternoUsuarioCOVID']?>" id="paternoNotificador">
                  <input type="hidden" value="<?= $_SESSION['maternoUsuarioCOVID']?>" id="maternoNotificador">
                  <input type="hidden" value="<?= $_SESSION['nombreUsuarioCOVID']?>" id="nombreNotificador">
                  <input type="hidden" value="<?= $_SESSION['cargoUsuarioCOVID']?>" id="cargoNotificador">
               </div>
                     
            </div>

            <!--=====================================
            SE MUESTRA LAS TABLAS GENERADAS
            ======================================-->            

            <div class="card-body" id="fichas">  

              <table class="table table-bordered table-striped dt-responsive table-hover" id="tablaFichas" width="100%">
                
                <thead>
                  
                  <tr>
                    <th>COD. FICHA.</th>
                    <th>TIPO DE FICHA.</th>
                    <th>COD. ASEGURADO</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>CI</th>
                    <th>SEXO</th>
                    <th>FECHA NACIMIENTO</th>
                    <th>FECHA TOMA DE MUESTRA</th>
                    <th>RESULTADO</th>
                    <th>FECHA RESULTADO</th>
                    <th>ACCIONES</th>
                  </tr>

                </thead>
                
              </table> 

              <input type="hidden" value="<?= $_SESSION['perfilUsuarioCOVID']; ?>" id="perfilOculto">

              <input type="hidden" value="centro" id="actionFichas">
                      
            </div>

          </div>

        </div>

      </div>

    </div>

  </section>
  
</div>

<!--=====================================
VENTANA MODAL PARA MOSTRAR REPORTE PDF
======================================-->

<div id="ver-pdf" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="fichaPDF" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="fichaPDF">Formulario de Impresiones</h5>
        
          <button type="button" class="close btnCerrarReporte" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div id="view_pdf">
       

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default float-left btnCerrarReporte" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

        </div>

    </div>

  </div>

</div>


<!--=====================================
VENTANA MODAL PARA MOSTRAR EL FORMULARIO DE BAJA
======================================-->

<div id="modalFormBaja" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormBajaLabel" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" id="formAgregarFormBaja">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="modalFormBajaLabel">Formulario de Baja</h5>
        
          <button type="button" class="close btnCerrarReporte" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
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
                  <!-- <span id="paternoFormBaja"></span> -->
                  <input type="text" class="form-control form-control-sm mayuscula" name="paternoFormBaja" id="paternoFormBaja" >
                </td>
                <td>
                 <!--  <span id="maternoFormBaja"></span> -->
                  <input type="text" class="form-control form-control-sm mayuscula" name="maternoFormBaja" id="maternoFormBaja" >
                </td>
                <td>
                  <!-- <span id="nombreFormBaja"></span> -->
                  <input type="text" class="form-control form-control-sm mayuscula" name="nombreFormBaja" id="nombreFormBaja" >
                </td>
                <td>
                  <!-- <span id="codAseguradoFormBaja"></span> -->
                  <input type="text" class="form-control form-control-sm mayuscula" name="codAseguradoFormBaja" id="codAseguradoFormBaja" readonly>
                  <input type="hidden" id="codAsegurado" value="">
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
                  <input class="form-control form-control-sm mayuscula" type="text" id="nombreEmpleadorFormBaja" name="nombreEmpleadorFormBaja" required >
                </td>
                <td>
                  <input class="form-control form-control-sm mayuscula" type="text" id="codEmpleadorFormBaja" name="codEmpleadorFormBaja" required >
                </td>
              </tr>

              <tr>
                <td colspan="4">

                  <div class="row">

                    <div class="col-md-8 border">

                      <div class="row m-0">
                        <label>RIESGO</label>
                      </div>

                      <div class="row align-content-center m-0">

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
                          <input type="date" class="form-control form-control-sm" id="fechaIniFormBaja" name="fechaIniFormBaja" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>" max="<?php echo date('Y-m-d') ?>">
                        </div>
                      </div>

                      <div class="form-group row m-1">
                        <label class="col-form-label col-form-label-sm">HASTA</label>
                        <div class="col-md-5">
                          <input type="date" class="form-control form-control-sm" id="fechaFinFormBaja" name="fechaFinFormBaja" min="<?php echo date('Y-m-d') ?>" max='<?php echo date("Y-m-d",strtotime(date('Y-m-d')."+ 2 days")) ?>' required>
                        </div>
                      </div>

                      <div id="divObservaciones" class="form-group row m-1">
                          <label class="col-form-label col-form-label-sm" for="observacionesBaja">OBSERVACIONES<span class="text-danger font-weight-bold"> *</span></label>
                          <textarea class="form-control mayuscula" id="observacionesBaja" rows="3" minlength="6" readonly></textarea>
                      </div>

                      <div class="form-group row m-1">
                        <label class="col-form-label col-form-label-sm">DÍAS DE INCAPACIDAD</label>
                        <div class="col-md-5">
                          <input type="text" class="form-control form-control-sm" id="diasIncapacidadFormBaja" readonly>
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
                        <label class="col-form-label col-form-label-sm">Lugar Y Fecha</label>
                        <div class="col-md-4">
                          <select class="form-control form-control-sm" id="lugarFormBaja" name="lugarFormBaja" required>
                            <!--<option value="">Elegir...</option>-->
                            <option value="COCHABAMBA">COCHABAMBA</option>
                          </select>
                        </div>
                        <div class="col-md-5">
                          <input type="date" class="form-control form-control-sm" id="fechaFormBaja" value="<?php echo date('Y-m-d') ?>">
                        </div>
                      </div>

                      <div class="form-group row m-1">
                        <label class="col-form-label col-form-label-sm">CLAVE</label>
                        <div class="col-md-5">
                          <input type="text" class="form-control form-control-sm" id="claveFormBaja" readonly>
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

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <input type="hidden" id="idCovidResultadoFormBaja">
          <input type="hidden" id="idFichaFormBaja">

          <button type="button" class="btn btn-default float-left btnCerrarFormBaja" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

          <button type="button" class="btn btn-primary btnAgregarFormBaja">

            <i class="fas fa-save"></i>
            Guardar

          </button>

        </div>

      </form>

    </div>

  </div>

</div>


<!--==============================================================================================================
VENTANA MODAL PARA MOSTRAR A QUE PACIENTE SE LE CREARA UNA FICHA EPIDEMIOLOGICA PARA EVITAR LA DUPLICIDAD DE FICHAS
==================================================================================================================-->

<!--=====================================
MODAL SELECCIONAR ASEGURADO
======================================-->

<div id="modalEvitarDuplicados" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="CodAsegurado" aria-hidden="true">
  
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

        <div id="tblAfiliadosSIAISFichas" class="mt-4" style="overflow-y: scroll;">  

                  
        </div>

      </div>

    </div>

  </div>

</div>

<!--=========================================
VENTANA MODAL PARA MOSTRAR FICHAS DUPLICADAS
=============================================-->

<div id="ver-duplicado" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="fichaDuplicada" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="fichaPDF">Vista de Ficha Duplicada</h5>
        
          <button type="button" class="close btnCerrarDuplicado" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div id="view_duplicado">
       

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default float-left btnCerrarReporte btnCerrarDuplicado" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Cerrar
          </button>
        </div>

    </div>

  </div>

</div>
