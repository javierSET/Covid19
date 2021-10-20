<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Administrar Asegurados

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Administrar Asegurados</li>

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
        
              <a href="empleadores" id="empleadores">

                <button class="btn btn-primary">

                  <i class="fas fa-plus"></i>
                  Nuevo Asegurado
                
                </button>

              </a>

            </div>
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive" id="tablaAsegurados" width="100%">
                
                <thead>
                  
                  <tr>
                    <th></th>
                    <th>Empleador</th>
                    <th>Tipo Seguro</th>
                    <th>Matricula</th>
                    <th>CI</th>
                    <th>Nombre</th>                    
                    <th>Sexo</th>
                    <th>Fecha Nacimiento</th>
                    <th>Localidad</th>
                    <th>Zona</th>
                    <th>Direcciòn</th>
                    <th>Salario</th>
                    <th>Ocupaciòn</th>
                    <th>Fecha Ingreso</th>
                    <th>Estado</th>
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

