<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Reportes Resultados Covid-19

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio"><i class="fas fa-tachometer-alt"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Reportes</li>

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

              <div class="form-row">
                
                <div class="input-group col-md-3">

                  <label class="px-2 mt-1 font-weight-normal">Desde: </label>
                  
                  <input type="date" class="form-control" id="reporteFechaInicio" value="<?= date('Y-m-d'); ?>" min="2020-01-01" max="<?= date("Y-m-d") ?>">

                </div>

                <div class="input-group col-md-3">

                  <label class="px-2 mt-1 font-weight-normal">Hasta: </label>
                  
                  <input type="date" class="form-control" id="reporteFechaFin" value="<?= date('Y-m-d'); ?>" min="2020-01-01" max="<?= date("Y-m-d") ?>">

                </div>

              </div>

              <div class="form row mt-3">

                <div class="input-group col-md-4">

                  <div class="icheck-danger icheck-inline">

                    <input type="radio" name="reporteResultado" id="radio1" value="POSITIVO">
                    <label for="radio1" class="text-danger">
                      POSITIVOS
                    </label>

                  </div>

                  <div class="icheck-success icheck-inline">

                    <input type="radio" name="reporteResultado" id="radio2" value="NEGATIVO">
                    <label for="radio2" class="text-success">
                      NEGATIVOS
                    </label>

                  </div>

                  <div class="icheck-primary icheck-inline">

                    <input type="radio" name="reporteResultado" checked id="redio3" value="TODO">
                    <label for="redio3" class="text-primary">
                      TODOS
                    </label>

                  </div>

                </div> 

                <div class="form-group col-md-3">
                  
                  <button type="button" class="btn btn-primary px-2 btnCovidResultadosReporte">
                
                    <i class="fas fa-search"></i> Buscar
                  
                  </button>  

<!--                   <button type="button" class="btn btn-danger px-2 btnCovidResultadosPDF" id="daterange-btn2" disabled>
                
                    <i class="fas fa-file-pdf"></i></i> Exportar PDF
                  
                  </button>  -->

                  <span><img src="vistas/img/cargando.gif" class="cargando hide"></span>

                  <input type="hidden" value="<?= $_SESSION['paternoUsuarioCOVID'].' '.$_SESSION['maternoUsuarioCOVID'].' '.$_SESSION['nombreUsuarioCOVID']; ?>" id="nombreUsuarioOculto">

                </div>           

              </div>
                     
            </div>

            <!--=====================================
            SE MUESTRA LAS TABLAS GENERADAS
            ======================================-->            

            <div class="card-body" id="reporteCovid">   

                      
            </div>

          </div>

        </div>

      </div>

      <div class="row">

        <div class="col-md-6 col-xs-12">

   
          
        </div>

        <div class="col-md-6 col-xs-12">


          
        </div>

      </div>

    </div>

  </section>
  
</div>

<!--=====================================
VENTANA MODAL PARA MOSTRAR REPORTE PDF
======================================-->

<div id="ver-pdf" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="repoteResultadosCovid" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="repoteResultadosCovid">Reporte Generado</h5>
        
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