<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Listado de Empleadores

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Empleadores SIAIS</li>

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
        

            </div>
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive" id="tablaEmpleadoresSIAIS" width="100%">
                
                <thead>
                  
                  <tr>
                    <th>#</th>
                    <th>NRO. PATRONAL</th>
                    <th>NIT</th>
                    <th>RAZON SOCIAL</th>
                    <th>TELÉFONO</th>
                    <th>ACTIVIDAD</th>
                    <th>FECHA</th>
                    <th>ACCIONES</th>
                  </tr>

                </thead>
                
              </table>

              <input type="hidden" value="<?php echo $_SESSION['perfilUsuarioCOVID']; ?>" id="perfilOculto">

            </div>
            
          </div>

        </div>

      </div>

    </div>
   
  </section>
  
</div>