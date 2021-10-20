<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Listado de Asegurados 

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Asegurados SIAIS</li>

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
        
            <div class="card-header">

              <?php 


              $item = "idempleador";
              $valor = $_GET['idEmpleador'];

              $empleador = ControladorEmpleadoresSIAIS::ctrMostrarEmpleadoresSIAIS($item, $valor);

              ?>
        
              <h5>AFILIADOS POR PARTE DEL EMPLEADOR [<?= $empleador["emp_nombre"] ?>]</h5>

            </div>
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive" id="tablaAfiliadosEmpleadorSIAIS" width="100%">
                
                <thead>
                  
                  <tr>
                    <th>#</th>
                    <th>COD. ASEGURADO</th>
                    <th>COD. AFILIADO</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>FECHA NACIMIENTO</th>
                    <th>COD. EMPLEADOR</th>
                    <th>ACCIONES</th>
                  </tr>

                </thead>
                
              </table>

              <input type="hidden" value="<?= $_SESSION['perfilUsuarioCOVID']; ?>" id="perfilOculto">

              <input type="hidden" value="<?= $_GET['idEmpleador']; ?>" id="idEmpleador">

            </div>
            
          </div>

        </div>

      </div>

    </div>
   
  </section>
  
</div>