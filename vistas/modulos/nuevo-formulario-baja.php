<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Nuevo Asegurado

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item"><a href="empleadores" class="menu" id="empleadores"> Empleadores</a></li>

            <li class="breadcrumb-item active">Nuevo Asegurado</li>

          </ol>

        </div>

      </div>

    </div>

  </div>
  
  <section class="content">

    <div class="container-fluid">

      <form role="form" method="post" class="formularioAsegurado">

        <div class="row">
        
          <!--=============================================
          SECCION PARA SUBIR LA FOTO DEL ASEGURADO
          =============================================-->       
         
          <div class="col-md-4 col-xs-12">

            <div class="card card-outline card-info">

              <div class="card-body">

              <?php 
               
                $item = "id";
                $valor = $_GET["idEmpleador"];

                $empleador = ControladorEmpleadores::ctrMostrarEmpleadores($item, $valor);
                
              ?>  

                <!-- ENTRADA PARA SUBIR FOTO -->
          
                <div class="form-group">

                  <img src="vistas/img/asegurados/default/anonymous.png" class="img-thumbnail previsualizar" width="400px">

                  <p class="help-block">Peso máximo de la foto 2MB</p>

                </div>      
                                 
              </div>
            
              <div class="card-footer">
                
                <div class="input-group mb-3">

                  <div class="input-group-prepend">
                    
                    <label class="input-group-text" for="nuevaFotoAsegurado" id="inputFoto"><i class="fas fa-portrait"></i></label>

                  </div>
                  
                  <div class="custom-file">
                    
                    <input type="file" class="custom-file-input nuevaFotoAsegurado" name="nuevaFotoAsegurado" id="nuevaFotoAsegurado" aria-describedby="inputFoto">

                    <label class="custom-file-label" for="nuevaFotoAsegurado" data-browse="Elegir">SUBIR FOTO</label>

                  </div>

                </div>

              </div> 

            </div>       

          </div>

          <!--=============================================
          SECCION PARA LA ENTRADA DE DATOS DEL ASEGURADO
          =============================================-->

          <div class="col-md-8 col-xs-12">
            
            <div class="card card-outline card-info">

              <div class="card-header">
                
                <h5 class="card-title">Form. AVC - 04</h5>

              </div>

              <div class="card-body">
               
                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control" id="nuevoPaterno" name="nuevoPaterno">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control" id="nuevoMaterno" name="nuevoMaterno">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoNombre">Nombre</label>
                    <input type="text" class="form-control" id="nuevoNombre" name="nuevoNombre">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoSexo">Sexo</label>
                    <select class="form-control" id="nuevoSexo" name="nuevoSexo">
                      <option selected>Elegir...</option>
                      <option value="VARON">VARON</option>
                      <option value="MUJER">MUJER</option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevaFechaNacimiento">Fecha de Nacimiento</label>
                    <input type="text" class="form-control calendarioAsegurado" id="nuevaFechaNacimiento" name="nuevaFechaNacimiento">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoDocumentoCI">Nro. CI</label>
                    <input type="text" class="form-control" id="nuevoDocumentoCI" name="nuevoDocumentoCI">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoTelefono">Teléfono o Celular</label>
                    <input type="text" class="form-control" id="nuevoTelefono" name="nuevoTelefono" data-inputmask="'mask': '99-999999'" required pattern="[-0-9]+" title="Solo deben ir números en el campo">
                  </div>

                  <div class="form-group col-md-8">
                    <label for="nuevoEmail">Em@il</label>
                     <input type="text" class="form-control" id="nuevoEmail" name="nuevoEmail" data-inputmask="'alias': 'email'" inputmode="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Introduzca formato de email válido">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevaLocalidad">Localidad</label>
                    <select class="form-control" id="nuevaLocalidad" name="nuevaLocalidad">
                      <option selected>Elegir...</option>
                       <?php 

                        $item = null;
                        $valor = null;

                        $localidades = ControladorLocalidades::ctrMostrarLocalidades($item, $valor);

                        foreach ($localidades as $key => $value) {
                          
                          echo '<option value="'.$value["id"].'">'.$value["nombre_localidad"].'</option>';
                        } 
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="nuevaZona">Zona</label>
                    <input type="text" class="form-control" id="nuevaZona" name="nuevaZona">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="nuevaCalle">Calle</label>
                    <input type="text" class="form-control" id="nuevaCalle" name="nuevaCalle">
                  </div>

                  <div class="form-group col-md-2">
                    <label for="nuevoNroCalle">Nro</label>
                    <input type="text" class="form-control" id="nuevoNroCalle" name="nuevoNroCalle">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoSalario">Salario</label>
                    <input type="text" class="form-control" id="nuevoSalario" name="nuevoSalario">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevaOcupacion">Ocupación</label>
                    <select class="form-control" id="nuevaOcupacion" name="nuevaOcupacion">
                      <option selected>Elegir...</option>
                      <?php 

                        $item = null;
                        $valor = null;

                        $ocupaciones = ControladorOcupaciones::ctrMostrarOcupaciones($item, $valor);

                        foreach ($ocupaciones as $key => $value) {
                          
                          echo '<option value="'.$value["id"].'">'.$value["nombre_ocupacion"].'</option>';
                        } 
                      ?>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-4">
                    <label for="nuevaFechaIngreso">Fecha Ingreso</label>
                    <input type="text" class="form-control calendarioAsegurado" id="nuevaFechaIngreso" name="nuevaFechaIngreso">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-8">
                    <label for="nuevaEmpresa">Nombre o Razón Social del Empleador</label>
                    <input type="text" class="form-control" id="nuevaEmpresa" name="nuevaEmpresa" value="<?php echo $empleador['razon_social']?>" readonly>                  
                  </div>
                  
                  <div class="form-group col-md-4">
                    <label for="nuevoNroPatronal">Nro. Empleador</label>
                    <input type="text" class="form-control" id="nuevoNroPatronal" name="nuevoNroPatronal" value="<?php echo $empleador['nro_patronal']?>" readonly>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoTipoSeguro">Cobertura</label>
                    <select class="form-control" id="nuevoTipoSeguro" name="nuevoTipoSeguro">
                      <option selected>Elegir...</option>
                      <?php 

                        $item = null;
                        $valor = null;

                        $seguros = ControladorSeguros::ctrMostrarSeguros($item, $valor);

                        foreach ($seguros as $key => $value) {
                          
                          echo '<option value="'.$value["id"].'">'.$value["tipo_seguro"].'</option>';
                        } 
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoEstablecimiento">Establecimiento</label>
                    <select class="form-control" id="nuevoEstablecimiento" name="nuevoEstablecimiento">
                      <option selected>Elegir...</option>
                      <?php 

                        $item = null;
                        $valor = null;

                        $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos($item, $valor);

                        foreach ($establecimientos as $key => $value) {
                          
                          echo '<option value="'.$value["id"].'">'.$value["nombre_establecimiento"].'</option>';
                        } 
                      ?>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-4">
                    <label for="nuevoConsultorio">Consultorio</label>
                    <select class="form-control" id="nuevoConsultorio" name="nuevoConsultorio">
                      <option selected>Elegir...</option>
                      <?php 

                        $item = null;
                        $valor = null;

                        $consultorios = ControladorConsultorios::ctrMostrarConsultorios($item, $valor);

                        foreach ($consultorios as $key => $value) {
                          
                          echo '<option value="'.$value["id"].'">'.$value["nombre_consultorio"].'</option>';
                        } 
                      ?>
                    </select>
                  </div>

                </div>

              </div> 

              <div class="card-footer">

                <div class="float-right">

                  <input type="hidden" id="idEmpleador" name="idEmpleador" value="<?php echo $_GET["idEmpleador"]?>">
                    
                  <button type="submit" class="btn btn-primary btnGuardar">

                    <i class="fas fa-save"></i>
                    Guardar Asegurado

                  </button>

                  <button type="button" class="btn btn-danger btnCerrar">

                    <i class="fas fa-window-close"></i>
                    Cerrar

                  </button>

                </div>

              </div> 

            </div> 

          </div>
 
        </div>

      </form>

      <?php

        $guardarAsegurado = new ControladorAsegurados();
        $guardarAsegurado -> ctrCrearAsegurado();

      ?>    

    </div> 

  </section>
  
</div>