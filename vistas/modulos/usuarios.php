<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Administrar usuarios

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Administrar usuarios</li>

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
        
              <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">

                <i class="fas fa-plus"></i>
                Agregar Usuario

              </button>

            </div>
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive nowrap" id="tablaUsuarios" width="100%">
                
                <thead>
                  
                 <tr>
                    <th>#</th>
                    <th>Paterno</th>
                    <th>Materno</th>
                    <th>Nombre(s)</th>
                    <th>Cod. Usuario</th>
                    <th>CI</th>
                    <th>Foto</th>
                    <th>Cargo</th>
                    <th>Perfil</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                  </tr>

                </thead>

                <tbody>

                <?php

                $item = null;
                $valor = null; 

                $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);  

                foreach ($usuarios as $key => $value) {
                    
                  echo '
                  <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$value["paterno"].'</td>
                    <td>'.$value["materno"].'</td>
                    <td>'.$value["nombre"].'</td>
                    <td>'.$value["matricula"].'</td>
                    <td>'.$value["documento_ci"].'</td>';

                    if ($value["foto"] != "") {
                              
                      echo '<td><img src="'.$value["foto"].'" class="img-thumbnail" width="40px"></td>';

                    } else {

                      echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';

                    }

                    echo '
                    <td>'.$value["cargo"].'</td>
                    <td>'.$value["perfil"].'</td>';

                    if ($value["estado"] != 'INACTIVO') {

                      echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="INACTIVO">ACTIVO</button></td>';

                    } else {

                      echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="'.$value["id"].'" estadoUsuario="ACTIVO">INACTIVO</button></td>';

                    }

                    echo '
                    <td>'.$value["fecha"].'</td>
                    <td>                
                      <div class="btn-group">                  
                        <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarUsuario" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                      </div>
                    </td>
                  </tr>';

                }

                ?>
                  
                </tbody>

              </table>

            </div>

          </div>
         
        </div>

      </div>
      
    </div>
    
  </section>
  
</div>

<!--=====================================
MODAL AGREGAR USUARIO
======================================-->

<div id="modalAgregarUsuario" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="agregarUsuario" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="agregarUsuario">Agregar usuario</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="form-row">

            Campos Obligatorios<h5 class="text-danger"> *</h5>
            
          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA EL APELLIDO PATERNO -->
            
            <div class="form-group col-md-4">
              
              <label  for="nuevoPaterno">Apellido Paterno</label>
              <input type="text" class="form-control mayuscula" id="nuevoPaterno" name="nuevoPaterno" placeholder="Ingresar Apellido Paterno" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]+" title="Solo deben ir letras en el campo">

            </div>

            <!-- ENTRADA PARA EL APELLIDO MATERNO -->
          
            <div class="form-group col-md-4">
            
              <label for="nuevoMaterno">Apellido Materno</label>
              <input type="text" class="form-control mayuscula" id="nuevoMaterno" name="nuevoMaterno" placeholder="Ingresar Apellido Materno" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]+" title="Solo deben ir letras en el campo">

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
          
            <div class="form-group col-md-4">
              
              <label for="nuevoNombre">Nombre(s)<span class="text-danger"> *</span></label>
              <input type="text" class="form-control mayuscula" id="nuevoNombre" name="nuevoNombre" placeholder="Ingresar Nombre(s)" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]+" title="Solo deben ir letras en el campo">

            </div>

          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA LA MATRICULA USUARIO -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevaMatricula">Matricula o Nick Usuario<span class="text-danger"> *</span></label>
              <input type="text" class="form-control" id="nuevaMatricula" name="nuevaMatricula" placeholder="INGRESAR MATRICULA O NICK DE USUARIO" required pattern="[A-Za-z0-9-]+" title="Solo deben ir letras y números en el campo">

            </div>

            <!-- ENTRADA PARA EL CI -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevoCI">Nro. CI<span class="text-danger"> *</span></label>
              <input type="text" class="form-control" id="nuevoCI" name="nuevoCI" placeholder="INGRESAR NRO. CI" required pattern="[a-zA-Z0-9-]+" title="Solo deben ir letras y números en el campo">

            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevoPassword">Contraseña<span class="text-danger"> *</span></label>
              <input type="password" class="form-control" id="nuevoPassword" name="nuevoPassword" placeholder="INGRESAR CONTRASEÑA" required pattern="[a-zA-Z0-9]+" title="Solo deben ir letras y números en el campo">

            </div>

          </div>  

          <div class="form-row">     

            <!-- ENTRADA PARA EL CARGO DEL USUARIO -->
            
            <div class="form-group col-md-4">
              
              <label for="nuevoCargo">Cargo<span class="text-danger"> *</span></label>
              <input type="text" class="form-control mayuscula" id="nuevoCargo" name="nuevoCargo" placeholder="Ingresar Cargo del Usuario" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">

            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
          
            <div class="form-group col-md-4">
              
              <label for="nuevoPerfil">Perfil de Usuario<span class="text-danger"> *</span></label>
              <select class="custom-select" id="nuevoPerfil" name="nuevoPerfil" required>
                <option value="">SELECCIONAR PERFIL</option>
                <option value="ADMIN_SYSTEM">ADMYN_SYSTEM</option>
                <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                <option value="MEDICO">MEDICO</option>
                <option value="LABORATORISTA">LABORATORISTA</option>
                <option value="ESTADISTICA">ESTADISTICA</option>
              </select>

            </div>
    
            <!-- ENTRADA PARA SUBIR FOTO -->
            
            <div class="form-group col-md-4">

              <div class="input-group mb-3">

                <div class="input-group-prepend">
                  
                  <label class="input-group-text" for="nuevaFoto" id="inputFoto"><i class="fas fa-portrait"></i></label>

                </div>
                
                <div class="custom-file">
                  
                  <input type="file" class="custom-file-input nuevaFoto" name="nuevaFoto" id="nuevaFoto" aria-describedby="inputFoto">

                  <label class="custom-file-label" for="nuevaFoto" data-browse="Elegir">SUBIR FOTO</label>

                </div>

              </div>

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>  

          </div>   

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default float-left" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

          <button type="submit" class="btn btn-primary">

            <i class="fas fa-save"></i>
            Guardar usuario

          </button>

        </div>

        <?php 

        $crearUsuario = new ControladorUsuarios();
        $crearUsuario -> ctrCrearUsuario();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR USUARIO
======================================-->

<div id="modalEditarUsuario" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modificarUsuario" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="modificarUsuario">Editar usuario</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="form-row">

            <!-- ENTRADA PARA EL APELLIDO PATERNO -->
            
            <div class="form-group col-md-4">
              
              <label for="editarPaterno">Apellido Paterno</label>
              <input type="text" class="form-control" id="editarPaterno" name="editarPaterno" placeholder="Ingresar Apellido Paterno" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]+" title="Solo deben ir letras en el campo">

            </div>

            <!-- ENTRADA PARA EL APELLIDO MATERNO -->
            
            <div class="form-group col-md-4">
              
              <label for="editarMaterno">Apellido Materno</label>
              <input type="text" class="form-control" id="editarMaterno" name="editarMaterno" placeholder="Ingresar Apellido Materno" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ]+" title="Solo deben ir letras en el campo">

            </div>

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group col-md-4">
              
              <label for="editarNombre">Nombre</label>
              <input type="text" class="form-control" id="editarNombre" name="editarNombre" value="" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]+" title="Solo deben ir letras en el campo">

            </div>

          </div>
          
          <div class="form-row">

            <!-- ENTRADA PARA LA MATRICULA USUARIO -->
            
            <div class="form-group col-md-4">
              
              <label for="editarMatricula">Matricula o Nick Usuario</label>
              <input type="text" class="form-control" id="editarMatricula" name="editarMatricula" placeholder="Ingresar Matricula o Nick Usuario" readonly>

            </div>

            <!-- ENTRADA PARA EL CI -->
            
            <div class="form-group col-md-4">
              
              <label for="editarCI">Nro. CI</label>
              <input type="text" class="form-control" id="editarCI" name="editarCI" placeholder="Ingresar Nro. CI" required pattern="[A-Za-z0-9-]+" title="Solo deben ir letras y números en el campo">

            </div>

            <!-- ENTRADA PARA LA CONTRASEÑA -->
            
            <div class="form-group col-md-4">
              
              <label for="editarPassword">Contraseña</label>
              <input type="password" class="form-control" id="editarPassword" name="editarPassword" placeholder="Escriba la nueva contraseña" pattern="[a-zA-Z0-9]+" title="Solo deben ir letras y números en el campo">
              <input type="hidden" id="passwordActual" name="passwordActual">

            </div>

          </div>

          <div class="form-row">
          
            <div class="form-group col-md-4">

            <!-- ENTRADA PARA EL CARGO DEL USUARIO -->
              
              <label for="editarCargo">Cargo</label>
              <input type="text" class="form-control" id="editarCargo" name="editarCargo" placeholder="Ingresar Cargo del Usuario" required pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ .-]+" title="Solo deben ir letras y números en el campo">

            </div>

            <!-- ENTRADA PARA SELECCIONAR SU PERFIL -->
            
            <div class="form-group col-md-4">
              
              <label for="editarPerfil">Perfil de Usuario</label>
              <select class="custom-select" name="editarPerfil" required>
                
                <option value="" id="editarPerfil"></option>
                <option value="ADMIN_SYSTEM">ADMIN_SYSTEM</option>
                <option value="ADMINISTRATIVO">ADMINISTRATIVO</option>
                <option value="MEDICO">MEDICO</option>
                <option value="LABORATORISTA">LABORATORISTA</option>
                <option value="ESTADISTICA">ESTADISTICA</option>
                
              </select>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->
            
            <div class="form-group col-md-4">

              <div class="input-group mb-3">

                <div class="input-group-prepend">
                  
                  <label class="input-group-text" for="editarFoto" id="inputEditarFoto"><i class="fas fa-portrait"></i></label>

                </div>
                
                <div class="custom-file">
                  
                  <input type="file" class="custom-file-input nuevaFoto" name="editarFoto" id="editarFoto" aria-describedby="inputEditarFoto">

                  <label class="custom-file-label" for="editarFoto" data-browse="Elegir">SUBIR FOTO</label>

                </div>

              </div>

              <p class="help-block">Peso máximo de la foto 2MB</p>

              <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="fotoActual" id="fotoActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default float-left" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

          <button type="submit" class="btn btn-primary">

            <i class="fas fa-save"></i>
            Guardar cambios

          </button>

        </div>

        <?php

          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();

        ?>

      </form>

    </div>

  </div>

</div>

<?php 

  // $borrarUsuario = new ControladorUsuarios();
  // $borrarUsuario -> ctrBorrarUsuario();

?>