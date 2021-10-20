<!--
  @Author: Daniel Villegas Veliz
  @date: 15/09/2021
-->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h5 class="m-0 text-dark">
            Reporte del Bajas Hospital Obreo Nº 
          </h5>
        </div>
        <div class="col-sm-4">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>
            <li class="breadcrumb-item active">Reporte Laboratorio</li>
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
              <div class="form-row">
                    <div class="form-group col-md-3">                    
                      <div class="input-group">
                        <?php
                            $establecimientos = ControladorEstablecimientos::ctrMostrarEstablecimientos(null,null);
                        ?>
                        <label class="px-2 mt-1 font-weight-normal">Establecimiento: </label>
                        <select id="cbEstablecimientosHo" class="form-control form-control-md">
                          <option value="todo">Todos</option>
                          <?php
                              foreach($establecimientos as $key=>$establecimineto){//$establecimineto["nombre_establecimiento"]
                                echo "<option value='".$establecimineto["nombre_establecimiento"]."'>".$establecimineto["nombre_establecimiento"]."</option>";
                              }
                          ?>                   
                        </select>
                      </div>
                    </div>

                    <div class="form-group col-md-5">
                      <div class="input-group">

                        
                        
                        <label class="px-2 mt-1 font-weight-normal">Fecha Resultado: </label>                  
                        <input type="date" class="form-control col-4" id="fechaResultadoHo" value="<?php echo date("Y-m-d") ?>">                      
                        <button type="button" class="btn btn-primary px-2 ml-2" id="btnBuscarEstableFechaHo" perfilOculto="<?php echo $_SESSION['perfilUsuarioCOVID']; ?>">
                          <i class="fas fa-search"></i> Buscar                  
                        </button>
                      </div>
                    </div>                    
                </div>

                <div>           
                  <input type="hidden" value="<?=$_SESSION['paternoUsuarioCOVID'].' '.$_SESSION['maternoUsuarioCOVID'].' '.$_SESSION['nombreUsuarioCOVID']; ?>" id="nombreUsuarioOcultoHo">
                </div>

              </div>        
              <div class="card-body" id="resultadosCovidLaboratorioHo">                           
                <table class="table table-bordered table-striped dt-responsive table-hover" id="tablaCovidResultadosLaboratorioHo" width="100%">                
                  <thead>                  
                    <tr>
                      <th>COD. LAB.</th>
                      <th>COD. ASEGURADO</th>
                      <th>COD. AFILIADO</th>
                      <th>APELLIDOS Y NOMBRES</th>
                      <th>CI</th>
                      <th>FECHA RECEPCIÓN</th>
                      <th>FECHA MUESTRA</th>
                      <th>TIPO DE MUESTRA</th>
                      <th>METODO DE DIAGNOSTICO</th>
                      <th>MUESTRA DE CONTROL</th>
                      <th>DEPARTAMENTO</th>
                      <th>RESULTADO</th>
                      <th>ESTABLECIMIENTO</th>
                      <th>SEXO</th>
                      <th>FECHA NACIMIENTO</th>
                      <th>TELÉFONO</th>
                      <th>EMAIL</th>
                      <th>LOCALIDAD</th>
                      <th>ZONA</th>
                      <th>DIRECCION</th>                
                      <th>FECHA RESULTADO</th>
                      <th>OBSERVACIONES</th>
                      <th>MEDICO</th>
                      <th>RESPONSABLE RESULTADO</th>
                      <!--<th>ACCIONES</th>-->
                    </tr>
                  </thead>                
                </table>
                <input type="hidden" value="<?= $_SESSION['perfilUsuarioCOVID']; ?>" id="txtHideRolHo">
                <input type="hidden" value="reportes" id="txtreportesHo">
              </div>            
            </div>
        </div>
      </div>
    </div>   
  </section>  
</div>