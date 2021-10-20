<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Listado de Afiliados con Formulario de Incapacidad COVID-19

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Formulario Incapacidad</li>

          </ol>

        </div>

      </div>

    </div>

  </div>

  <section class="content">

    <div class="container-fluid">
      
      <div class="row">
        
        <div class="col-12">
           
          <div class="card">
        
          <?php	if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM" || $_SESSION["perfilUsuarioCOVID"] == "MEDICO"){ ?>
            <div class="card-header">        

                <button class="btn btn-primary" id="btnNuevoFormularioBaja">
                  <i class="fas fa-plus"></i>
                  Nuevo Formulario Baja                
                </button>

            </div>
          <?php } ?>  
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive" id="tablaFormularioBajas" width="100%">
                
                <thead>
                  
                  <tr>
                    <th>COD. LAB.</th>
                    <th>COD. ASEGURADO</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>NOMBRE EMPLEADOR</th>
                    <th>NRO. EMPLEADOR</th>
                    <th>RIESGO</th>
                    <th>INCAPACIDAD DESDE</th>
                    <th>INCAPACIDAD HASTA</th>
                    <th>DIAS INCAPACIDAD</th>
                    <th>LUGAR Y FECHA</th> 
                    <th>CLAVE</th>
                    <th>CÓDIGO</th>
                    <th>ESTABLECIMIENTO</th>
                    <th>OBSERVACIONES</th>                         
                    <th>ACCIONES</th>
                  </tr>

                </thead>
                
              </table>

              <input type="hidden" value="<?php echo $_SESSION['perfilUsuarioCOVID']; ?>" id="perfilOculto">

              <input type="hidden" value="<?= $_SESSION['paternoUsuarioCOVID'].' '.$_SESSION['maternoUsuarioCOVID'].' '.$_SESSION['nombreUsuarioCOVID']; ?>" id="nombreUsuarioOculto">

            </div>
            
          </div>

        </div>

      </div>

    </div>
   
  </section>
  
</div>

<?php
   
  $eliminarFormularioBaja = new ControladorFormularioBajas();
  $eliminarFormularioBaja->ctrEliminarFormularioBaja();

?>

<!--=====================================
VENTANA MODAL PARA MOSTRAR EL FORMULARIO DE BAJA EN PDF
======================================-->

<div id="ver-pdf" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="formularioBajasPDF" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="formularioBajasPDF">Formulario de Incapacidad Generado</h5>
        
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
MODAL SELECCIONAR ASEGURADO NUEVO FORMULARIO @DANPINCH
======================================-->

<div id="modalCodAseguradoFormularioBaja" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="CodAsegurado" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->

      <div class="modal-header bg-gradient-info">

        <h5 class="modal-title" id="modificarUsuario">Buscar Asegurado Para Realizar Su Baja</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

      </div>

      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->

        <div class="">
        
          <section class="content">

            <div class="container-fluid">

              <div class="row">

                <div class="col-md-12">

                  <div class="card">

                    <div class="card-header"> 

                      <div class="form-row">

                        <div class="input-group col-md-3"></div>
                        
                        <div class="input-group col-md-9">

                          <span class="mt-2 mr-2">Buscar:</span>
                          
                          <input type="text" class="form-control mr-2 mayuscula" id="buscardorAfiliadosBaja" placeholder="Ingrese Apellidos o Nombre(s) o Codigo Asegurado para la Búsqueda.">

                          <button type="button" class="btn btn-primary px-2 btnBuscarAfiliadoBajas">
                        
                            <i class="fas fa-search"></i> Buscar
                          
                          </button>  

                        </div>                     

                      </div>
                            
                    </div>

                    <!--=====================================
                    SE MUESTRA LAS TABLAS GENERADAS
                    ======================================-->            

                    <div class="" id="tblAfiliadosSIAIS">  

                              
                    </div>

                  </div>

                </div>

              </div>

              <div class="row" style="background-color: red;">

                <div class="col-md-6 col-xs-12">   
                  
                </div>

                <div class="col-md-6 col-xs-12">
                  
                </div>

              </div>

            </div>

          </section>
          
        </div>
      </div>

    </div>

  </div>

</div>


<!--=====================================
  MODAL BUSCAR BAJAS ACTIVAS  @DANPINCH
======================================-->

<div class="modal fade" id="modalBajasActivas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Baja Activa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="" style="border: 1px solid #17a2b8; border-radius: 50px 50px; padding-left: 30px;">
          <div id="detalleBajas">            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
