<?php
	@include("./funciones/funcionesAuxiliares.php");
	$hoy = obtenerFechaEnLetra(date('d-m-Y'));
?>
<footer class="main-footer">

	<div class="float-right d-none d-sm-block">

    	<b>Version</b> 3.1

	</div>

  	&copy; Copyright <strong class="text-info">CNS Regional Cochabamba <?= $hoy?></strong>. Todos los Derechos Reservados.

</footer>

<aside class="control-sidebar control-sidebar-red">

    <!-- Control sidebar content goes here -->

</aside>