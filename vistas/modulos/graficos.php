<?php
    require_once('graficos-arreglos.php');  
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">                         
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="inicio"><i class="fas fa-home"></i> Inicio</a></li>
                        <li class="breadcrumb-item active">Graficos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <!-- begin-->
            <div class="row">
                <div class="col-md-7 offset-md-3 mb-4">
                    <!-- <span class="badge badge-secondary"><h6>REPORTES GENERADOS</h6></span> -->
                </div>
            </div>
                <div class="row situacionalInfo" id="situacionalInfo">
                    <?php
                        include("recarga_campos_datos.php");
                    ?>
                </div>
            <!-- aqui -->
        </div>
        <div class="card-body">
            <div class="row">    
                <div class="input-group col-md-3">
                    <label class="px-2 mt-1 font-weight-normal">Desde: </label>    
                    <input type="date" class="form-control" id="fechaBusquedaIni" min="2020-01-01" max="<?= date("Y-m-d") ?>" value="<?= date("2021-02-16")?>">
                </div>
                <div class="input-group col-md-3">
                    <label class="px-2 mt-1 font-weight-normal">Hasta: </label>        
                    <input type="date" class="form-control" id="fechaBusquedaFin" min="2020-01-01" max="<?= date("Y-m-d") ?>" value="<?= date("Y-m-d")?>">
                </div>
            </div>

            <div class="row mt-3">
                <div class="input-group col-md-12">
                    <div class="icheck-danger icheck-inline">
                        <input type="radio" name="radioBusquedaResultado" id="radioBusquedaPositivo" value="POSITIVO">
                        <label for="radioBusquedaPositivo" class="text-danger">
                        POSITIVOS
                        </label>
                    </div>
                    
                    <div class="icheck-success icheck-inline">
                        <input type="radio" name="radioBusquedaResultado" id="radioBusquedaNegativo" value="NEGATIVO">
                        <label for="radioBusquedaNegativo" class="text-success">
                        NEGATIVOS
                        </label>
                    </div>

                    <div class="icheck-primary icheck-inline">
                        <input type="radio" name="radioBusquedaResultado" checked id="radioBusquedaTodos" value="TODO">
                        <label for="radioBusquedaTodos" class="text-primary">
                        TODOS
                        </label>
                    </div>
                </div> 
            </div>

            <div class="col-md-12" id="seccionBtn">
                <div class="row mt-2">
                    <button type="button" class="btn btn-primary mx-1" id="buscarReportePorFecha">
                        <i class="fas fa-search"></i> Buscar    
                    </button>
                    <button type="button" class="btn btn-danger mx-1" id="btnGenerarPDF">
                        <i class="fas fa-file-pdf"></i></i> Generar PDF
                    </button>
                    <button type="button" class="btn btn-success mx-1" id="btnGenerarExcel">
                        <i class="fas fa-file-excel"></i></i> Generar EXCEL
                    </button>
                    
                    <span><img src="vistas/img/cargando.gif" class="cargando hide"></span>
                    <input type="hidden" value="<?= $_SESSION['paternoUsuarioCOVID'].' '.$_SESSION['maternoUsuarioCOVID'].' '.$_SESSION['nombreUsuarioCOVID']; ?>" id="nombreUsuarioOculto">
                </div>
            </div>
        </div>        
    </div>

    <div class="content" id="reporteGraficoPDF">

        

        <!-- <div class="row situacionalInfo" id="situacionalInfo">
            <?php
                //include("recarga_campos_datos.php");
            ?>
        </div> -->
        <hr>
        <div class="row col-md-12" id="rangoEdadSexo" style="display: none;">
            <div class="form-group col-lg-4">
                <div class="card" id="graficoTablaSexo">
                    <!-- Aqui se muestra la tabla  -->                    
                </div>                
            </div>

            <div class="col-lg-4">
                <div class="card" id="cardGrafico">
                    <div class="card-header bg-info">GRAFICO POR EDADES</div>
                    <div class="card-body" id="graficoEdadesDiv">
                        <!-- <canvas id='graficoEdades' width='350' height='274'></canvas> -->
                    </div>
                </div>                
            </div>

            <div class="col-lg-4">
                <div class="card" id="cardGraficoTorta">
                    <div class="card-header bg-info">GRAFICO TOTALES POR EDADES</div>
                    <div class="card-body" id="graficoEdadesTortaDiv">
                        <!-- <canvas id="graficoEdadesTorta" width="350" height="274"></canvas> -->
                    </div>
                </div>                
            </div>

        </div>

        <div class="row col-md-12" id="rangoOcupacion" style="display: none;">
            <div class="form-group col-lg-4" id="tablaOcupacion">
                <!-- Aqui se muestra la tabla -->                    
            </div>

            <div class="col-lg-4" id="graficoRectanguloOcupacion">
                <div class="card">
                    <div class="card-header bg-info">GRAFICOS POR OCUPACION</div>
                    <div class="card-body" id="graficoOcupacionDiv">
                        <!-- <canvas id="rectanguloOcupacion" width="350" height="274"></canvas> -->
                    </div>
                </div>
                
            </div>

            <div class="col-lg-4" id="graficoTortaOcupacion">
                <div class="card">
                    <div class="card-header bg-info"> GRAFICOS  </div>
                    <div class="card-body" id="graficoOcupacionTorta">
                        <!-- <canvas id="circuloOcupacion"  width="350" height="274"></canvas> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>