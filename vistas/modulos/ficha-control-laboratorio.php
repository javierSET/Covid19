<!--
  @Author: Daniel Villegas Veliz
  @version: 1.00
  @description: Interfaz grafica para poder crear vaios laboratorios 
 -->

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            AGREGAR LABORATORIOS A PACIENTES
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item active">Laboratorios</li>
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
                <button class="btn btn-primary" id="btnNuevoBusquedaPaciente">
                  <i class="fas fa-plus"></i>
                    Busqueda de paciente
                </button>
            </div>
          <?php } ?>        
            <div class="card-body">              
              <table class="table table-bordered table-striped dt-responsive" id="tablaFormularioLaboratorios" width="100%">                
                <thead>                  
                  <tr>
                    <th>COD. LAB.</th>
                    <th>COD. ASEGURADO</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>NOMBRE EMPLEADOR</th>
                    <th>NRO. EMPLEADOR</th>                    
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

<!--=====================================
MODAL SELECCIONAR ASEGURADO
======================================-->

<div id="modalFichasControlLab" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="CodAsegurado" aria-hidden="true">  
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      <div class="modal-header bg-gradient-info">
        <h5 class="modal-title" id="modificarUsuarioLaboratorio">Buscar Asegurado Para Agregar mas Laboratorios</h5>        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">
        <div class="form-row">
          <div class="input-group col-md-3">            
          </div>          
          <div class="input-group col-md-9">
            <span class="mt-2 mr-2">Buscar:</span>            
            <input type="text" class="form-control mr-2" id="txtBuscadorAfiliadoSIAISLocal" placeholder="Ingrese Apellidos o Nombre(s) o Codigo Asegurado.">
            <button type="button" class="btn btn-primary px-2 btnBuscadorAfiliadoSIAISLocal">          
              <i class="fas fa-search"></i> Buscar            
            </button>
          </div>
        </div> 
        <!--=====================================
        SE MUESTRA LAS TABLAS GENERADAS
        ======================================-->
        <div id="divTablaAfiliadosSIAISLocal" class="mt-4" style="overflow-y: scroll;">                  
        </div>
      </div>
    </div>
  </div>
</div>