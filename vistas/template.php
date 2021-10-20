<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>CNS Cochabamba | COVID-19</title>

  <!-- Icono -->
  <link rel="icon" href="vistas/img/cns/cns-logo.png">

  <!--=====================================
  PLUGINS CSS
  ======================================-->

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="vistas/plugins/fontawesome-free/css/all.min.css">

  <!-- Mis style -->
  <link rel="stylesheet" href="vistas/css/style.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/adminlte.css">
  
  <!-- Google Font: Source Sans Pro -->
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->

  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="vistas/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="vistas/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- SweetAlert 2 -->
  <link rel="stylesheet" href="vistas/plugins/sweetalert2/themes/bootstrap-4.css">

  <!-- Toastr -->
  <link rel="stylesheet" href="vistas/plugins/toastr/toastr.min.css">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Daterange picker --> 
  <link rel="stylesheet" href="vistas/plugins/daterangepicker/daterangepicker.css">

  <!--=====================================
  PLUGINS JAVASCRIPT
  ======================================-->

  <!-- jQuery -->
  <script src="vistas/plugins/jquery/jquery.min.js"></script>

  <!-- jQuery Validation -->
  <script src="vistas/plugins/jquery-validation/jquery.validate.min.js"></script>
  
  <!-- Bootstrap 4 -->
  <script src="vistas/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- FastClick -->
  <script src="vistas/plugins/fastclick/fastclick.js"></script>

  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="vistas/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="vistas/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="vistas/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="vistas/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="vistas/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="vistas/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="vistas/plugins/jszip/jszip.min.js"></script>    
  <script src="vistas/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="vistas/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="vistas/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="vistas/plugins/datatables-scroller/js/dataTables.scroller.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.min.js"></script>

  <!-- Toastr -->
  <script src="vistas/plugins/toastr/toastr.min.js"></script>

  <!-- iCheck 1.0.1 -->
  <!-- <script src="vistas/plugins/iCheck/icheck.min.js"></script> -->

  <!-- InputMask -->
  <script src="vistas/plugins/moment/moment.min.js"></script>
  <script src="vistas/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

  <!-- JQueryNumber -->
  <script src="vistas/plugins/jqueryNumber/jqueryNumber.min.js"></script>

  <!-- Daterange picker --> 
  <script src="vistas/plugins/daterangepicker/moment.min.js"></script>
  <script src="vistas/plugins/daterangepicker/daterangepicker.js"></script>

  <!-- MomentJS --> 
  <script src="vistas/plugins/moment/moment.min.js"></script> 

  <!-- Numeral.js 2.0.6 --> 
  <script src="vistas/plugins/numeral.js/numeral.js"></script>
  
  <!-- PDF Objetct --> 
  <script src="vistas/plugins/pdf_object/pdfobject.js"></script> 

  <!-- Importar Chart (para diseñar Graficos)-->
  <script src="vistas/plugins/chart.js/Chart.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  
</head>

<!--=====================================
CUERPO DOCUMENO
======================================-->

<?php 

if (isset($_SESSION["iniciarSesionCOVID"]) && $_SESSION["iniciarSesionCOVID"] == "ok") {
    
  echo '
  <body class="hold-transition sidebar-mini">
    
    <div class="wrapper">';

    /*=====================================
    HEADER
    ======================================*/

    include "modulos/header.php";

    /*=====================================
    MENU
    ======================================*/
    
    include "modulos/menu.php";

    /*=====================================
    CONTENIDO
    ======================================*/

    if (isset($_GET["ruta"])) {
      
      if ($_GET["ruta"] == "inicio" ||
          $_GET["ruta"] == "usuarios" ||
          $_GET["ruta"] == "empleadores" ||
          $_GET["ruta"] == "asegurados" ||
          $_GET["ruta"] == "nuevo-asegurado" ||
          $_GET["ruta"] == "empleadoresSIAIS" ||
          $_GET["ruta"] == "afiliadosEmpleadorSIAIS" ||
          $_GET["ruta"] == "afiliadosSIAIS" ||
          $_GET["ruta"] == "covid-resultados" ||
          $_GET["ruta"] == "covid-resultados-lab" ||
          $_GET["ruta"] == "covid-resultados-laboratorio-ho" ||
          $_GET["ruta"] == "covid-resultados-reportes-ho" ||
          $_GET["ruta"] == "bajas-resultados-reportes-ho" ||
          $_GET["ruta"] == "nuevo-covid-resultado" ||
          $_GET["ruta"] == "nuevo-covid-resultado-no-afiliado" ||
          $_GET["ruta"] == "editar-covid-resultado" ||
          $_GET["ruta"] == "formulario-bajas" ||
          $_GET["ruta"] == "editar-formulario-bajas" ||
          $_GET["ruta"] == "reportes-covid" ||
          $_GET["ruta"] == "reportes-bajas" ||
          $_GET["ruta"] == "ficha-epidemiologica" ||
          $_GET["ruta"] == "ficha-epidemiologica-lab" ||
          $_GET["ruta"] == "nuevo-ficha-epidemiologica" ||
          $_GET["ruta"] == "nuevo-ficha-control" ||
          $_GET["ruta"] == "editar-ficha-epidemiologica" ||
          $_GET["ruta"] == "editar-ficha-epidemiologica-lab" ||
          $_GET["ruta"] == "editar-ficha-control" ||
          $_GET["ruta"] == "editar-ficha-control-lab" ||
          $_GET["ruta"] == "imprimir-ficha-epidemiologica" ||
          $_GET["ruta"] == "ficha-seguimiento" ||
          $_GET["ruta"] == "reportes-ficha" ||
          $_GET["ruta"] == "nuevo-formulario-baja-asegurado" ||
          $_GET["ruta"] == "nuevo-formulario-baja" ||
          $_GET["ruta"] == "ficha-caso-sospechoso-covid19" ||
          $_GET["ruta"] == "info" ||
          $_GET["ruta"] == "fichas-control-seguimiento" ||
          $_GET["ruta"] == "certificado-alta-manual" ||
          $_GET["ruta"] == "formulario-alta-manual" ||
          $_GET["ruta"] == "ficha-control-laboratorio" ||
          $_GET["ruta"] == "graficos" ||
          $_GET["ruta"] == "salir") {

        include "modulos/".$_GET["ruta"].".php";

      } else {

        include "modulos/404.php";

      }

    } else {

      include "modulos/inicio.php";

    }

    /*=====================================
    FOOTER
    ======================================*/

    include "modulos/footer.php";

      echo '</div>';

} else {

  echo '
  <body class="hold-transition login-page">';

  include "modulos/login.php";

}

?>

<script src="vistas/js/template.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/empleadores.js"></script>
<script src="vistas/js/asegurados.js"></script>
<script src="vistas/js/formulario_bajas.js"></script>
<script src="vistas/js/formulario_altas.js"></script>
<script src="vistas/js/reportes_covid.js"></script>
<script src="vistas/js/reportes_bajas.js"></script>
<script src="vistas/js/fichas.js"></script>
<script src="vistas/js/reportes_ficha.js"></script>

<script src="vistas/js/empleadoresSIAIS.js"></script>
<script src="vistas/js/afiliadosSIAIS.js"></script>

<script src="vistas/js/fichas_seguimiento.js"></script>

<!-- Script para el laboratorio del Hopital Obrero Nº2-->
  <script src="vistas/js/covid_resultados_laboratorio.js"></script>
  <script src="vistas/js/covid_resultados_laboratorio_ho.js"></script>

 <!-- Importar graficos.js -->
 <script src="vistas/js/graficos.js"></script>

<!-- LIBRERIA PARA GENERAR PDF -->
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script> -->
<script src="vistas/plugins/jspdf/jspdf.js"></script>

<!-- LIBRERIA PARA GENERAR XLSX-->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.min.js"></script> -->
<script src="vistas/plugins/sheetjs/dist/xlsx.full.min.js"></script>

<!-- LIBRERIA PARA GUARDAR-->
<script src="vistas/plugins/fileSaver/fileSaver.js"></script>

<!-- js para realizar los eventos del  -->

<script src="vistas/js/fichas-control-laboratorio.js"></script>
<script src="vistas/js/covid_resultados.js"></script>
</body>
</html>