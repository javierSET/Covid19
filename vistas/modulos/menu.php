<aside class="main-sidebar elevation-4 sidebar-dark-info">

	<a href="inicio" class="brand-link menu" id="inicio">

  	<img onmouseout="this.src='vistas/img/cns/cns-logo.png';" onmouseover="this.src='vistas/img/cns/cns-logo.png';" src="vistas/img/cns/cns-logo.png" alt="SISVECOM Logo" class="brand-image elevation-3" style="opacity: .8">

  	<!-- <div class="brand-text">

  		<img src="vistas/img/template/nombre-linear.png" class="brand-image">

  	</div> -->

  	<span class="brand-text font-weight-bold text-white">CNS</span>
  	<span class="brand-text font-weight-bold text-info ml-0"> Regional Cbba.</span>

  </a>
	
	<div class="sidebar">

		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			
			<div class="image">

			<?php 

			if ($_SESSION["fotoUsuarioCOVID"] != "") {
				
				echo '<img src="'.$_SESSION["fotoUsuarioCOVID"].'" class="img-circle elevation-2">';

			} else {

				echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle elevation-2">';
			}

			?>
			
      </div>

      <div class="info">

        <a href="#" class="d-block"><?php echo $_SESSION["nombreUsuarioCOVID"] ?></a>

      </div>

    </div>

    <nav class="mt-2">
		
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	
			 	<li class="nav-item">
					
					<a href="inicio" class="nav-link menu active" id="inicio">
						
						<i class="nav-icon fas fa-home"></i>
						<p>Inicio</p>

					</a>

				</li>

				<?php 

				if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM") {

				?>

				<li class="nav-item has-treeview">
			
					<a href="" class="nav-link menu" id="acceso">
						
						<i class="nav-icon fas fa-user-cog"></i>
						<p>
							Administrador Acceso
							<i class="right fas fa-angle-left"></i>
						</p>

					</a>

					<ul class="nav nav-treeview">
						
						<li class="nav-item">
							
							<a href="usuarios" class="nav-link menu" id="usuarios">
								
								<i class="nav-icon far fa-user"></i>
								<p>Usuarios</p>
							
							</a>
						
						</li>

					</ul>

				</li>

				<?php
					
				}

				if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM" || $_SESSION["perfilUsuarioCOVID"] == "LABORATORISTA" || $_SESSION["perfilUsuarioCOVID"] == "SECRETARIO") {

				?>

                <?php
				 if($_SESSION["perfilUsuarioCOVID"] != "LABORATORISTA"){
				?>
					<li class="nav-item has-treeview">
						
					<a href="" class="nav-link menu" id="afiliacion">
							
							<i class="nav-icon fas fa-user-cog"></i>
							<p>
								Datos Afiliación SIAIS
								<i class="right fas fa-angle-left"></i>
							</p>

						</a> 

						<ul class="nav nav-treeview">

							<!-- <li class="nav-item">
								
								<a href="empleadoresSIAIS" class="nav-link menu" id="empleadoresSIAIS">
									
									<i class="nav-icon fas fa-building"></i>
									<p>Empleadores SIAIS</p>
								
								</a>
							
							</li> -->

							<li class="nav-item">
								
								<a href="afiliadosSIAIS" class="nav-link menu" id="afiliadosSIAIS">
									
									<i class="nav-icon fas fa-user-friends"></i>
									<p>Poblacion Afiliada SIAIS</p>
								
								</a>
							
							</li>

						</ul>

					</li>
				<?php } ?>

				<li class="nav-item has-treeview">
					
					<a href="" class="nav-link menu" id="laboratorio">
						
						<i class="nav-icon fas fa-vial"></i>
						<p>
							Laboratorio
							<i class="right fas fa-angle-left"></i>
						</p>

					</a>

					<ul class="nav nav-treeview">
						
						<li class="nav-item">
							
							<a href="ficha-epidemiologica-lab" class="nav-link menu" id="ficha-epidemiologica-lab">
								
								<i class="nav-icon far fa-list-alt"></i>
								<p>Ficha Epidemiologica</p>
							
							</a>
						
						</li>

						<li class="nav-item">
							
							<a href="covid-resultados-lab" class="nav-link menu" id="covid-resultados-lab">
								
								<i class="nav-icon fas fa-list-ul"></i>
								<p>Resultados Covid-19</p>
							
							</a>
						
						</li>

						<!-- Menu para agregar resultados en bloque del hospital obrero nº 2 @dan -->
						<li class="nav-item">
							<a href="covid-resultados-laboratorio-ho" class="nav-link menu" id="covid-resultados-laboratorio-ho">
								<i class="nav-icon fas fa-indent"></i>
								<p>Resultados Covid-19HO</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="covid-resultados-reportes-ho" class="nav-link menu" id="report-covid-resultados-laboratorio-ho">
								<i class="nav-icon fas fa-hospital"></i>
								<p>Reportes Covid-19 HO</p>
							</a>
						</li>

					</ul>

				</li>

				<?php
					
				}

				if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM" || $_SESSION["perfilUsuarioCOVID"] == "MEDICO") {

				?>

				<li class="nav-item has-treeview">
					
					<a href="" class="nav-link menu" id="centroCovid">
						
						<i class="nav-icon fas fa-hospital-user"></i>
						<p>
							Centro COVID
							<i class="right fas fa-angle-left"></i>
						</p>

					</a>

					<ul class="nav nav-treeview">
						
						<li class="nav-item">
							
							<a href="ficha-epidemiologica" class="nav-link menu" id="ficha-epidemiologica">
								
								<i class="nav-icon far fa-list-alt"></i>
								<p>Ficha Epidemiologica</p>
							
							</a>
						
						</li>

						<li class="nav-item">
							
							<a href="covid-resultados" class="nav-link menu" id="covid-resultados">
								
								<i class="nav-icon fas fa-list-ul"></i>
								<p>Resultados Laboratorio Covid-19</p>
							
							</a>
						
						</li>

						<li class="nav-item">
							
							<a href="formulario-bajas" class="nav-link menu" id="formulario-bajas">
								
								<i class="nav-icon fab fa-wpforms"></i>
								<p>Formulario Incapacidad</p>
							
							</a>
						
						</li>

					<?php	if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM"){ ?>

						<li class="nav-item">
							
							<a href="ficha-seguimiento" class="nav-link menu" id="ficha-seguimiento">
								
								<!-- <i class="nav-icon far fa-list-alt"></i> -->
								<i class="nav-icon far fa-file-alt"></i>
								<p>Crear Ficha Control</p>
							
							</a>
						
						</li>

						<li class="nav-item">
							
							<a href="fichas-control-seguimiento" class="nav-link menu" id="fichas-control-seguimiento">
								
								<i class="nav-icon far fa-list-alt"></i>
								<p>Listar Fichas Control</p>
							
							</a>
						
						</li>
						
					<?php }  if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM" || $_SESSION["perfilUsuarioCOVID"] == "MEDICO"){ ?>

						<li class="nav-item">							
							<a href="ficha-control-laboratorio" class="nav-link menu" id="ficha-seguimiento-laboratorios">
								<i class="nav-icon far fa-file-alt"></i>
								<p>Ficha Control Laboratorio</p>
							</a>						
						</li>

						<li class="nav-item">
							<a href="certificado-alta-manual" class="nav-link menu" id="alta-manual">
								
								<!-- <i class="nav-icon far fa-list-alt"></i> -->
								<i class="nav-icon far fa-file-alt"></i>
								<p>Certificado Alta Manual</p>
							
							</a>
						</li>
					
					<?php }?>
					</ul>

				</li>

				<?php
					
				}

				if ($_SESSION["perfilUsuarioCOVID"] == "ADMIN_SYSTEM" ||
					/*$_SESSION["perfilUsuarioCOVID"] == "ADMINISTRATIVO" || 
					$_SESSION["perfilUsuarioCOVID"] == "LABORATORISTA" || 
					$_SESSION["perfilUsuarioCOVID"] == "MEDICO" ||  */
					/*$_SESSION["perfilUsuarioCOVID"] == "SECRETARIO" ||*/
					$_SESSION["perfilUsuarioCOVID"] == "ESTADISTICA")
					{

				?>
                
					<li class="nav-item has-treeview">						
						<a href="" class="nav-link menu" id="reportes">							
							<i class="nav-icon fas fa-chart-bar"></i>
							<p>
								Reportes
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>

						<ul class="nav nav-treeview">							
							<li class="nav-item">								
								<a href="reportes-covid" class="nav-link menu" id="reportes-covid">									
									<i class="nav-icon far fa-circle"></i>
									<p>Reporte Covid-19</p>								
								</a>							
							</li>

							<li class="nav-item">								
								<a href="reportes-ficha" class="nav-link menu" id="reporte-ficha">									
									<i class="nav-icon far fa-circle"></i>
									<p>Reporte Ficha Epidemiológica</p>
								
								</a>							
							</li>

							<li class="nav-item">								
								<a href="reportes-bajas" class="nav-link menu" id="reportes-bajas">									
									<i class="nav-icon far fa-circle"></i>
									<p>Reportes Bajas</p>								
								</a>							
							</li>

						</ul>

					</li>

					<!-- MENU PARA MOSTRAR GRAFICOS  | @begin	-->
					<li class="nav-item has-treeview">						
						<a href="" class="nav-link menu" id="graficos">
							<i class="nav-icon fas fa-chart-pie"></i> 
							<p>
								Graficos
								<i class="right fas fa-angle-left"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">							
							<li class="nav-item">								
								<a href="graficos" class="nav-link menu" id="graficos-covid">
									<i class="nav-icon fab fa-pied-piper-alt"></i>
									<p>Graficos Covid-19</p>								
								</a>							
							</li>							
						</ul>
					</li>
					<!-- @End menu para graficos-->

				<?php
					
				}

				?>

			</ul>

		</nav>

	</div>

</aside>