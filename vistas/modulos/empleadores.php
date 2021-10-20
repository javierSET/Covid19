<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Administrar Empleadores

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Administrar Empleadores</li>

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
        
              <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEmpresa">
                
                <i class="fas fa-plus"></i>
                Agregar Empleador

              </button>

            </div>
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive nowrap" id="tablaEmpleadores" width="100%">
                
                <thead>
                  
                  <tr>
                    <th></th>
                    <th>NRO. PATRONAL</th>
                    <th>NIT</th>
                    <th>RAZON SOCIAL</th>
                    <th>FECHA</th>
                    <th>ESTADO</th>
                    <th></th>
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