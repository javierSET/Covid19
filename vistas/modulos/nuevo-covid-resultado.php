<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Nuevo Registro COVID-19

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Nuevo Registro COVID-19</li>

          </ol>

        </div>

      </div>

    </div>

  </div>
  
  <section class="content">

    <div class="container-fluid">

      <form role="form" method="post" enctype="multipart/form-data" class="formularioNuevoRegCovid19">

        <div class="row">     

          <!--=============================================
          SECCION PARA LA ENTRADA DE DATOS PERSONALES
          =============================================-->

          <div class="col-md-12 col-xs-12">
            
            <div class="card card-outline card-info">

              <div class="card-header">

              <?php 
               
                $item1 = null;
                $item2 = "idafiliacion";
                $valor = $_GET["idAfiliado"];

                $afiliados = ControladorAfiliadosSIAIS::ctrMostrarAfiliadosSIAIS($item1, $item2, $valor);
                
              ?>  
                
                <p><b>Matricula: </b><?= $afiliados['pac_numero_historia'] ?></p>
                <p><b>Nombre o Razón Social del Empleador: </b><?= $afiliados['emp_nombre'] ?></p>
                <p><b>Nro. Empleador: </b><?= $afiliados['emp_nro_empleador'] ?></p>

              </div>

              <div class="card-body">

                <div class="form-row">

                  Campos Obligatorios<h5 class="text-danger"> *</h5>
                  
                </div>

                <div class="form-row">

                  <div class="form-group col-md-3">
                    <label for="nuevaFechaMuestra">Fecha Toma de Muestra<span class="text-danger"> *</span></label>
                    <input type="date" class="form-control" id="nuevaFechaMuestra" name="nuevaFechaMuestra" required>
                  </div>
                  
                  <div class="form-group col-md-3">
                    <label for="nuevaMuestraControl">Muestra de Control<span class="text-danger"> *</span></label>
                    <select class="form-control" id="nuevaMuestraControl" name="nuevaMuestraControl" required>
                      <option value="">Elegir...</option>
                      <option value="SI">SI</option>
                      <option value="NO">NO</option>
                    </select>
                  </div>

                  <div class="form-group col-md-3">
                    <label for="nuevaMuestraControl">Tipo de Muestra<span class="text-danger"> *</span></label>
                    <input list="tipoMuestra" class="form-control mayuscula" id="nuevoTipoMuestra" name="nuevoTipoMuestra" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">
                    <datalist id="tipoMuestra">
                      <option value="ELISA">
                      <option value="ASPIRADO">
                      <option value="LAVADO BRONCO ALVEOLAR">
                      <option value="HISOPADO NASOFARÍNGEO">
                      <option value="HISOPADO COMBINADO">
                    </datalist>
                  </div>         

                  <div class="form-group col-md-3">
                    <label for="nuevaFechaRecepcion">Fecha Recepción<span class="text-danger"> *</span></label>
                    <input type="date" class="form-control" id="nuevaFechaRecepcion" name="nuevaFechaRecepcion" required>
                  </div>         

                </div>

                <div class="form-row">

                  <div class="form-group col-md-2">
                    <label for="nuevoCodLab">Cód. Lab.<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control mayuscula" id="nuevoCodLab" name="nuevoCodLab" required pattern="[a-zA-Z0-9]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="nuevoNombreLab">Nombre Lab.</label>
                    <input type="text" class="form-control mayuscula" id="nuevoNombreLab" name="nuevoNombreLab" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="nuevoDepartamento">Departamento<span class="text-danger"> *</span></label>
                    <select class="form-control" id="nuevoDepartamento" name="nuevoDepartamento" required>
                      <option value="">Elegir...</option>
                      <?php 

                        $item = null;
                        $valor = null;

                        $departamentos = ControladorDepartamentos::ctrMostrarDepartamentos($item, $valor);

                        foreach ($departamentos as $key => $value) {
                          
                          echo '<option value="'.$value["id"].'">'.$value["nombre_depto"].'</option>';
                        }

                      ?>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-4">
                    <label for="nuevoEstablecimiento">Establecimiento<span class="text-danger"> *</span></label>
                    <select class="form-control" id="nuevoEstablecimiento" name="nuevoEstablecimiento" required>
                      <option value="">Elegir...</option>
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

                </div>
               
                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoPaterno">Apellido Paterno</label>
                    <input type="text" class="form-control mayuscula" id="nuevoPaterno" name="nuevoPaterno" value="<?= rtrim($afiliados['pac_primer_apellido']) ?>" readonly required>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoMaterno">Apellido Materno</label>
                    <input type="text" class="form-control mayuscula" id="nuevoMaterno" name="nuevoMaterno" value="<?= rtrim($afiliados['pac_segundo_apellido']) ?>" readonly required>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoNombre">Nombre</label>
                    <input type="text" class="form-control mayuscula" id="nuevoNombre" name="nuevoNombre" value="<?= rtrim($afiliados['pac_nombre']) ?>" readonly required>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoDocumentoCI">Nro. CI<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" id="nuevoDocumentoCI" name="nuevoDocumentoCI" required pattern="[A-Za-z0-9-]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevoSexo">Sexo<span class="text-danger"> *</span></label>
                    <select class="form-control" id="nuevoSexo" name="nuevoSexo" required>
                      <option value="">Elegir...</option>
                      <option value="F">FEMENINO</option>
                      <option value="M">MASCULINO</option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="nuevaFechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="nuevaFechaNacimiento" name="nuevaFechaNacimiento" value="<?= $afiliados['pac_fecha_nac'] ?>" readonly>
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevoTelefono">Teléfono o Celular</label>
                    <input type="text" class="form-control" id="nuevoTelefono" name="nuevoTelefono" data-inputmask="'mask': '9{7,8}'" pattern="[0-9]{7,8}+" title="Solo deben ir números en el campo">
                  </div>

                  <div class="form-group col-md-8">
                    <label for="nuevoEmail">Em@il</label>
                     <input type="text" class="form-control" id="nuevoEmail" name="nuevoEmail" data-inputmask="'alias': 'email'" inputmode="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Introduzca formato de email válido">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="nuevaLocalidad">Localidad<span class="text-danger"> *</span></label>
                    <select class="form-control" id="nuevaLocalidad" name="nuevaLocalidad" required>
                      <option value="">Elegir...</option>
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
                    <label for="nuevaZona">Zona<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control mayuscula" id="nuevaZona" name="nuevaZona" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-3">
                    <label for="nuevaCalle">Calle<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control mayuscula" id="nuevaCalle" name="nuevaCalle" required pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">
                  </div>

                  <div class="form-group col-md-2">
                    <label for="nuevoNroCalle">Nro</label>
                    <input type="text" class="form-control" id="nuevoNroCalle" name="nuevoNroCalle" pattern="[a-zA-Z0-9 .-/]+" title="Caracteres no admitidos">
                  </div>

                </div>

                <div class="form-row">

                  <div class="form-group col-md-3 text-center clearfix">

                    <label>Resultados Laboratorio<br>Covid-19</label>
          
                    <div class="icheck-danger">
                      <input type="radio" name="nuevoResultado" id="radio1" value="POSITIVO">
                      <label for="radio1">
                        POSITIVO
                      </label>
                    </div>
                    <div class="icheck-success">
                      <input type="radio" name="nuevoResultado" checked id="radio2" value="NEGATIVO">
                      <label for="radio2">
                        NEGATIVO
                      </label>
                    </div>                   

                  </div>

            
                  <div class="form-group col-md-3">
                    <label for="nuevaFechaResultado">Fecha del Resultado<span class="text-danger"> *</span></label>
                    <input type="date" class="form-control" id="nuevaFechaResultado" name="nuevaFechaResultado" required>
                  </div>

                  <div class="form-group col-md-6 observacion">
                    <label for="nuevaObservacion">Observaciones</label>
                    <textarea class="form-control mayuscula" id="nuevaObservacion" name="nuevaObservacion" placeholder="Ingresar observaciones (Opcional)" rows="3" pattern="[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ .-(),/#]+" title="Caracteres no admitidos"></textarea>
                  </div>

                </div>

              </div> 

              <div class="card-footer">

                <div class="float-right">

                  <input type="hidden" id="codAfiliado" name="codAfiliado" value="<?= rtrim($afiliados['pac_codigo']) ?>">

                  <input type="hidden" id="codAsegurado" name="codAsegurado" value="<?= rtrim($afiliados['pac_numero_historia']) ?>">

                  <input type="hidden" id="codEmpleador" name="codEmpleador" value="<?= $afiliados['emp_nro_empleador'] ?>">

                  <input type="hidden" id="idAfiliado" name="idAfiliado" value="<?= $_GET['idAfiliado'] ?>">

                  <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $_SESSION['idUsuarioCOVID'] ?>">
                    
                  <button type="submit" class="btn btn-primary btnGuardar">

                    <i class="fas fa-save"></i>
                    Guardar Resultado

                  </button>

                </div>

              </div> 

            </div> 

          </div>
 
        </div>

      </form>

      <?php

        $guardarCovidResultado = new ControladorCovidResultados();
        $guardarCovidResultado -> ctrCrearCovidResultado();

      ?>    

    </div> 

  </section>
  
</div>