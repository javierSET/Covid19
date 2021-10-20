<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Lista de Fichas que tienen Seguimiento

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
                  
                  <input type="hidden" value="<?= $_SESSION['paternoUsuarioCOVID']?>" id="paternoNotificador">
                  <input type="hidden" value="<?= $_SESSION['maternoUsuarioCOVID']?>" id="maternoNotificador">
                  <input type="hidden" value="<?= $_SESSION['nombreUsuarioCOVID']?>" id="nombreNotificador">
                  <input type="hidden" value="<?= $_SESSION['cargoUsuarioCOVID']?>" id="cargoNotificador">

                </div>       

              </div>

            <?php } ?>
                     
            </div>

            <!--=====================================
            SE MUESTRA LAS TABLAS GENERADAS
            ======================================-->            

            <div class="card-body" id="fichas">  

              <table class="table table-bordered table-striped dt-responsive table-hover" id="tablaFichas" width="100%">
                
                <thead>
                  
                  <tr>
                    <th>COD. FICHA.</th>
                    <!-- <th>TIPO DE FICHA.</th> -->
                    <th>COD. ASEGURADO</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>CI</th>
                    <!-- <th>SEXO</th> -->
                    <!-- <th>FECHA NACIMIENTO</th>
                    <th>FECHA TOMA DE MUESTRA</th> -->
                    <th>RESULTADO</th>
                    <!-- <th>FECHA RESULTADO</th> -->
                    <th>NRO CONTROL</th>
                    <th>ACCIONES</th>
                  </tr>

                </thead>
                
              </table> 

              <input type="hidden" value="<?= $_SESSION['perfilUsuarioCOVID']; ?>" id="perfilOculto">

              <input type="hidden" value="listarFichasSeguimiento" id="actionFichas">
                      
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
