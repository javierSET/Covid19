<div class="content-wrapper">

  <div class="content-header">

    <div class="container-fluid">

      <div class="row mb-2">

        <div class="col-sm-6">

          <h1 class="m-0 text-dark">

            Listado de Certificado de Altas Emitidos Manualmente

          </h1>

        </div>

        <div class="col-sm-6">

          <ol class="breadcrumb float-sm-right">

            <li class="breadcrumb-item"><a href="inicio" class="menu" id="inicio"><i class="fas fa-home"></i> Inicio</a></li>

            <li class="breadcrumb-item active">Certificado Alta Manual</li>

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

                <button class="btn btn-primary" id="btnNuevoCertificadoAlta">
                  <i class="fas fa-plus"></i>
                  Nuevo Certificado Alta            
                </button>

            </div>
          <?php } ?>  
        
            <div class="card-body">
              
              <table class="table table-bordered table-striped dt-responsive" id="tablaCertificadosAtaManual" width="100%">
                
                <thead>
                  
                  <tr>
                    <th>COD. ASEGURADO</th>
                    <th>NOMBRES Y APELLIDOS</th>
                    <th>NOMBRE EMPLEADOR</th>
                    <th>NRO. EMPLEADOR</th>
                    <th>RESULTADO</th>
                    <th>FECHA RESULTADO</th>
                    <th>ESTABLECIMIENTO RESULTADO</th>
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

<!--====================================================
MODAL SELECCIONAR ASEGURADO NUEVO FORMULARIO 
========================================================-->

<div id="modalCertificadoAlta" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="CodAsegurado" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->

      <div class="modal-header bg-gradient-info">

        <h5 class="modal-title" id="modificarUsuario">Buscar Asegurado Para Darle un Certificado de Alta</h5>
        
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

      </div>

      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->

        <div class="">
        
          <section class="content">

            <div class="container-fluid">

              <div class="row">

                <div class="col-md-12">

                  <div class="card">

                    <div class="card-header"> 

                      <div class="form-row">

                        <div class="input-group col-md-3"></div>
                        
                        <div class="input-group col-md-9">

                          <span class="mt-2 mr-2">Buscar:</span>
                          
                          <input type="text" class="form-control mr-2" id="buscardorAfiliadosAlta" placeholder="Ingrese Apellidos o Nombre(s) o Codigo Asegurado para la Búsqueda.">

                          <button type="button" class="btn btn-primary px-2 btnBuscarAfiliadosParaAltaManual">
                        
                            <i class="fas fa-search"></i> Buscar
                          
                          </button>  

                        </div>                     

                      </div>
                            
                    </div>

                    <!--=====================================
                    SE MUESTRA LAS TABLAS GENERADAS
                    ======================================-->            

                    <div class="" id="tblAfiliadosSIAIS">  

                              
                    </div>

                  </div>

                </div>

              </div>

              <div class="row" style="background-color: red;">

                <div class="col-md-6 col-xs-12">   
                  
                </div>

                <div class="col-md-6 col-xs-12">
                  
                </div>

              </div>

            </div>

          </section>
          
        </div>
      </div>

    </div>

  </div>

</div>


<!--=========================================================
VENTANA MODAL PARA MOSTRAR EL CERTIFICADO DE ALTA MANUAL
=============================================================-->

<div id="modalFormularioAltaManual" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormBajaLabel" aria-hidden="true" style="overflow-y: scroll;">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data" id="formAgregarFormBaja">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header bg-gradient-info">

          <h5 class="modal-title" id="modalFormBajaLabel">Formulario de Baja</h5>
        
          <button type="button" class="close btnCerrarReporte"  data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body" id="cuerpoCertificadoAltaManual">
          

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <input type="hidden" id="idCovidResultadoFormBaja">

          <button type="button" class="btn btn-default float-left btnCerrarFormBaja" data-dismiss="modal">

            <i class="fas fa-times"></i>
            Cerrar

          </button>

          <button type="button" class="btn btn-outline-success generarAltaManualPDF"> <!-- btn btn-outline-danger  btn btn-primary-->

            <i class="fas fa-file-pdf"></i>
            Generar PDF

          </button>

        </div>

      </form>

    </div>

  </div>

</div>

<!--==========================================================================
VENTANA MODAL PARA MOSTRAR IMPRIMIR EL FORMULARIO DE ALTA MANUAL
===========================================================================-->

<div id="ver-pdf" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="fichaResultadoPDF" aria-hidden="true">  
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header bg-gradient-info">
          <h5 class="modal-title" id="fichaResultadoPDF">ALTA MAUNAL</h5>        
          <button type="button" class="close btnCerrarReporte" id="btnCerrarModal" data-dismiss="modal" aria-label="Close">
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
          <button type="button" class="btn btn-default float-left btnCerrarReporte" id="btnCerrarImpreAlta" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Cerrar
          </button>
        </div>
    </div>
  </div>
</div>

<!--==========================================================================
VENTANA MODAL PARA MOSTRAR IMPRIMIR EL FORMULARIO DE ALTA MANUAL
===========================================================================-->

<div id="alta_manual-pdf" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="fichaResultadoPDF" aria-hidden="true">  
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header bg-gradient-info">
          <h5 class="modal-title" id="altaManual">IMPRESION DE ALTA MANUAL</h5>        
          <button type="button" class="close btnCerrarReporte" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">          
          <div id="mostrar_pdf">


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

<!--==========================================================================
VENTANA MODAL PARA EDITAR EL FORMULARIO DE ALTA MANUAL
===========================================================================-->

<div id="editar_alta_manual" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">  
        <head>
					<style>
						.contenido{
							font-size: 14px;
							font-family: Arial, Helvetica, sans-serif;
						}
						.negrita{
							font-weight: bold;
						}
						.parrafo{
							text-align:justify; 
						}
						.cuerpo{
							padding-left: 50px;
							padding-right: 50px;
							border: 2px solid #17a2b8;
							border-radius: 50px 10px;
						}
						.form-control-p{
							height:30px;
							border: 1px solid #3C807C;
						}
						textarea:focus, input:focus, input[type]:focus {
							border-color: rgb(60, 128, 124);
							box-shadow: 0 1px 1px rgba(80, 199, 193, 0.075)inset, 0 0 8px rgba(80, 199, 193,0.6);
							outline: 0 none;
						}
            .separacion{
              line-height: 28pt;
            }
            .mayuscula{
              text-transform:uppercase;
            }							
					</style>					
				</head>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        <div class="modal-header bg-gradient-info">
          <h5 class="modal-title" id="altaManual">EDITAR ALTA MANUAL</h5>        
          <button type="button" class="close btnCerrarReporte" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
        <div class="cuerpo">
						<header>
							<center><h3>CERTIFICADO DE ALTA DE PACIENTE DESCARTADO COVID-19</h3></center>
							<hr>
						</header>					
						<div class="contenido">
							<form action="" method="post" id="">
								<table border="0" cellpadding="3">
									<tr>
										<td>
											<div class="">A solicitud de la Sr/Sra.
												Ingrese sus datos personales del paciente.
														<div class="form-row">
															<div class="form-group col-md-4">
																<label for="txtapellidopaterno">Apellido Paterno</label>
																<input class="form-control-p mayuscula" type="text" name="txtapellidopaterno"  id="txtapellidopaterno" placeholder="Apellido Paterno">
															</div>
															<div class="form-group col-md-4">
																<label for="txtapellidomaterno">Apellido Materno</label>
																<input class="form-control-p mayuscula" type="text" name="txtapellidomaterno"  id="txtapellidomaterno"  placeholder="Apellido Materno">
															</div>
															<div class="form-group col-md-4">																																
																<label for="txtnombre">Nombres</label>
																<input class="form-control-p mayuscula" type="text" name="txtnombre"  id="txtnombre"  placeholder="Ingrese su snombre">
															</div>
														</div>
                            <div class="separacion">                            
                            con CI:  
                            <input class="form-control-p mayuscula" type="text" name="txtCi"  id="txtCi"  placeholder="Ingrese nro documento" style="width:140px;">
                            , con domicilio en Zona: 
                            <input class="form-control-p mayuscula" type="text" name="zona"  id="zona" placeholder="Ingrese la zona" style="width:300px;">												
                            Calle:  
                            <span class="negrita">

                            <input class="form-control-p mayuscula" type="text" name="calle" id="calle" placeholder="Ingrese la calle" style="width:240px;">
                        
                            </span>  Nº:  
                            <span class="negrita">
                            <input class="form-control-p mayuscula" type="text" name="nro" id="nro" placeholder="Ingrese el nro o SN" style="width:60px;">
                            
                            <span class="negrita" id="matriculaAsegurado"> 
                            <?echo "MARICULA"?>													
                            </span>, Por la empresa
                            <span class="negrita">
                            <input class="form-control-p mayuscula" type="text" name="codEmpleador" id="codEmpleador" style="width:140px;" placeholder="Cod Empleador">
                            <input class="form-control-p mayuscula" type="text" name="nombreempleador" id="nombreempleador" style="width:400px;" placeholder="Ingrese el nombre Empleador">                            
                            </span> fue diagnosticado de COVID-19 por la prueba diagnóstica

                            <select class="form-control-p" name="tipoMuestra" id="tipoMuestra">
                              <option value="Antigeno SARS COV-2"><span class="negrita">Antigeno SARS COV-2</span></option>
                              <option value="Prueba Antigénica"><span class="negrita">PRUEBA ANTIGENICA</span></option>
                              <option value="RT-PCR GENEXPERT"><span class="negrita">RT-PCR GENEXPERT</span></option>
                              <option value="RT-PCR en tiempo Real"><span class="negrita">RT-PCR en tiempo Real</span></option>
                            </select> con Resultado:

                            <select class="form-control-p" name="selectResultado" id="selectResultado">
                              <option value="NEGATIVO"><span class="negrita">NEGATIVO</span></option>
                            </select>

                            , en fecha: <input class="form-control-p" type="date" name="fechaAlta" id="fechaAlta" style="width:130px;" readonly>
                            en el Laboratorio del establecimiento
                            <input class="form-control-p mayuscula" list="listacentros"  id="centros" name="centros" style="width:220px;" placeholder="Seleccione un centro">
                            <datalist id="listacentros">
                              <option value="Centro Centinela covid-19 Anexo N32">Centro Centinela covid-19 Anexo N32</option>
                              <option value="CIMFA SUR">CIMFA SUR</option>
                              <option value="CIMFA QUILLACOLLO">CIMFA QUILLACOLLO</option>
                              <option value="HOSPITAL OBRERO NRO 2">HOSPITAL OBRERO NRO 2</option>
                              <option value="CIMFA M.A.V.-CLINICA POLICIAL">CIMFA M.A.V.-CLINICA POLICIAL</option>
                            </datalist>

                          </div>
											</div>
										</td>
									</tr>																		
									<tr>
										<td>
											<!-- <p class="parrafo">El paciente cumplió con el compromiso de aislamiento domiciliario según el protocolo entregado <br>
												durante:
												<input class="form-control-p" name="diasBaja" id="diasBaja" value="1" style="width:30px;" readonly> dias 
												del <input class="form-control-p"type="date" name="fechaAltaini" value="<?=date('Y-m-d')?>" id="fechaAltaini" onchange="verificarFechaIni()">
												al  <input class="form-control-p"type="date" name="fechaAltafin" value="<?=date('Y-m-d')?>" id="fechaAltafin" min="<?=date('Y-m-d')?>" max="<?=date("Y-m-d",strtotime(date('Y-m-d')))?>" onchange="verificarFechaFin()">
											</p> -->
										</td>
									</tr>
									<tr>
										<td height="10">
										</td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: justify;">
											<p class="parrafo">
												El que certifica, es el personal de salud de la Caja Nacional de Salud
												del
												<select class="form-control-p mayuscula" name="establecimientoNotificador" id="establecimientoNotificador">
													<option value="1"><span class="negrita">Centro Centinela covid-19 Anexo N32</span></option>
													<option value="2"><span class="negrita">CIMFA SUR</span></option>
													<option value="3"><span class="negrita">CIMFA QUILLACOLLO</span></option>
													<option value="4"><span class="negrita">HOSPITAL OBRERO NRO 2</span></option>
                          <option value="13"><span class="negrita">CIMFA M.A.V.-CLINICA POLICIAL</span></option>
												</select>
                        , que realizo el control del paciente, según expediente clínico que acredita y constituye un conjunto de documentos escritos de orden médico legal. 
											</p>
										</td>
									</tr>
									<tr>
										<td>
										</td>
									</tr>
									<tr>
										<td colspan="3" style="text-align: justify;">
											<p class="parrafo">
                      En base y al instructivo del SEDES Cochabamba <strong> N° CITE/UR/DN-B-E. SP/89/2020, del 26 de junio de 2020 y recomendaciones de la OMS y OPS se procede a dar el Alta médica</strong>.
											</p>
										</td>
									</tr>
							
									<tr>
										<td>
										</td>
									</tr>
									<tr>
                    <td> <input type="hidden" id="idAltaManual"> </td>
                    <td> <input type="hidden" id="idPacienteAsegurado"> </td>
									</tr>
								</table>
								<hr>
							</form>						
						</div>
					</div>
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-default float-left" id = "btnGuardarAltManual" data-dismiss="">
            <i class="fas fa-save"></i>
            Guardar
          </button>
          <button type="button" class="btn btn-default float-left btnCerrarReporte" data-dismiss="modal">
            <i class="fas fa-times"></i>
            Cerrar
          </button>
        </div>
    </div>
  </div>
</div>