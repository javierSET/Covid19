let global_edadSexoM = new Array()
let global_edadSexoF = new Array()

let global_ocupacionSexoM = new Array()
let global_ocupacionSexoF = new Array()


$("#buscarReportePorFecha").on("click",function(){
    var fechaIni = $("#fechaBusquedaIni").val();
    var fechaFin = $("#fechaBusquedaFin").val();
    var resultadoRadio = $('input:radio[name=radioBusquedaResultado]:checked').val();
    $('#rangoOcupacion').show();
    $('#rangoEdadSexo').show();

    $('#graficoEdades').remove();
    $('#graficoEdadesDiv').append("<canvas id='graficoEdades' width='350' height='255'></canvas>");

    $('#graficoEdadesTorta').remove();
    $('#graficoEdadesTortaDiv').append("<canvas id='graficoEdadesTorta' width='350' height='255'></canvas>");

    $('#rectanguloOcupacion').remove();
    $('#graficoOcupacionDiv').append("<canvas id='rectanguloOcupacion' width='350' height='255'></canvas>");

    $('#circuloOcupacion').remove();
    $('#graficoOcupacionTorta').append("<canvas id='circuloOcupacion' width='350' height='255'></canvas>");

    var datos = new FormData();
    datos.append("busquedaPacientes",'busquedaPacientes');
    datos.append("fechaIni",fechaIni);
    datos.append("fechaFin",fechaFin);
    datos.append("resultadoRadio",resultadoRadio);

    $.ajax({

        url:"ajax/grafico_reporte.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta) {
                cargarDatosVisualizarGraficoEdadesPorSexo(respuesta);
                cargarDatosVisualizarGraficoOcupacion(respuesta);                                                 
            },
            error: function(error) {
                console.log(error);                
            }
    });
});
/*=====================================================
        GRAFICO HORIZONTAL 
=======================================================*/
function garficarPorSexoEdadCaja(sexoEdadM,sexoEdadF){

    totalM = sumaDeArreglo(sexoEdadM);
    totalF = sumaDeArreglo(sexoEdadF);    
    var ctx = document.getElementById('graficoEdades').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['[1]', '[2]', '[3]', '[4]', '[5]', '[6]', '[7]','[8]','[9]','[10]','[11]'],
            datasets: [{
                label: 'HOMBRES',
                data: sexoEdadM,
                backgroundColor: 
                    'rgba(75, 192, 192, 0.2)',
                borderColor: 
                    'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'MUJERES',
                data: sexoEdadF,
                backgroundColor:             
                    'rgba(255, 99, 132, 0.2)',
                borderColor: 
                    'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            },                       
        }
    });
}

/*=====================================================
        GRAFICO HORIZONTAL 
=======================================================*/
function garficarPorSexoOcupacionCaja(sexoEdadM,sexoEdadF){

    totalM = sumaDeArreglo(sexoEdadM);
    totalF = sumaDeArreglo(sexoEdadF);    
    var ctx = document.getElementById('rectanguloOcupacion').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['[1]','[2]','[3]','[4]','[5]','[6]'],
            datasets: [{
                label: 'HOMBRES',
                data: sexoEdadM,
                backgroundColor: 
                    'rgba(75, 192, 192, 0.2)',
                borderColor: 
                    'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'MUJERES',
                data: sexoEdadF,
                backgroundColor:             
                    'rgba(255, 99, 132, 0.2)',
                borderColor: 
                    'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            },                       
        }
    });
}


/*====================================================
        GRAFICO TORTA
======================================================*/
function graficarPorSexoEdadTorta(sexoEdadM,sexoEdadF){

    totalM = sumaDeArreglo(sexoEdadM);
    totalF = sumaDeArreglo(sexoEdadF);    
    var ctx = document.getElementById('graficoEdadesTorta').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['HOMBRES','MUJERES'],
            datasets: [{
                data: [totalM,totalF],
                backgroundColor: ['rgba(75, 192, 192, 0.2)','rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        }
    });
}


/*Grafico de pacientes por Ocupacion */
function graficoPorOcupacionSexoTorta(sexoEdadM,sexoEdadF){
    totalM = sumaDeArreglo(sexoEdadM);
    totalF = sumaDeArreglo(sexoEdadF);    
    var ctx = document.getElementById('circuloOcupacion').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['HOMBRES','MUJERES'],
            datasets: [{
                data: [totalM,totalF],
                backgroundColor: ['rgba(75, 192, 192, 0.2)','rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        }
    });
}

function cargarDatosVisualizarGraficoEdadesPorSexo(respuesta){

    let sexoEdadM = new Array();
    let sexoEdadF = new Array();

    sexoEdadM.push(respuesta[0]);
    sexoEdadM.push(respuesta[1]);
    sexoEdadM.push(respuesta[2]);
    sexoEdadM.push(respuesta[3]);
    sexoEdadM.push(respuesta[4]);
    sexoEdadM.push(respuesta[5]);
    sexoEdadM.push(respuesta[6]);
    sexoEdadM.push(respuesta[7]);
    sexoEdadM.push(respuesta[8]);
    sexoEdadM.push(respuesta[9]);
    sexoEdadM.push(respuesta[10]);
    sexoEdadF.push(respuesta[11]);
    sexoEdadF.push(respuesta[12]);
    sexoEdadF.push(respuesta[13]);
    sexoEdadF.push(respuesta[14]);
    sexoEdadF.push(respuesta[15]);
    sexoEdadF.push(respuesta[16]);
    sexoEdadF.push(respuesta[17]);
    sexoEdadF.push(respuesta[18]);
    sexoEdadF.push(respuesta[19]);
    sexoEdadF.push(respuesta[20]);
    sexoEdadF.push(respuesta[21]);

    global_edadSexoM = sexoEdadM
    global_edadSexoF = sexoEdadF
    
    document.getElementById("graficoTablaSexo").innerHTML = "";
    $("#graficoTablaSexo").append("<div class='card-header bg-info'>CASOS COVID 19 "+$('input:radio[name=radioBusquedaResultado]:checked').val()+" POR GRUPO ETAREO Y SEXO</div>"+
        "<div class='card-body table-responsive-sm'>"+
            "<table class='table table-sm'>"+
                "<thead class='thead-dark'><tr>"+
                "<th>Nº</th>"+
                "<th>Edades</th>"+
                "<th>Hombres</th>"+
                "<th>Mujeres</th></tr></thead>"+                
                "<tr>"+
                    "<td>1</td>"+
                    "<td>0 a 1 años</td>"+
                    "<td>"+sexoEdadM[0]+"</td>"+
                    "<td>"+sexoEdadF[0]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>2</td>"+
                    "<td>1 a 4 años</td>"+
                    "<td>"+sexoEdadM[1]+"</td>"+
                    "<td>"+sexoEdadF[1]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>3</td>"+
                    "<td>5 a 9 años</td>"+
                    "<td>"+sexoEdadM[2]+"</td>"+
                    "<td>"+sexoEdadF[2]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>4</td>"+
                    "<td>10 a 19 años</td>"+
                    "<td>"+sexoEdadM[3]+"</td>"+
                    "<td>"+sexoEdadF[3]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>5</td>"+
                    "<td>20 a 29 años</td>"+
                    "<td>"+sexoEdadM[4]+"</td>"+
                    "<td>"+sexoEdadF[4]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>6</td>"+
                    "<td>30 a 39 años</td>"+
                    "<td>"+sexoEdadM[5]+"</td>"+
                    "<td>"+sexoEdadF[5]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>7</td>"+
                    "<td>40 a 49 años</td>"+
                    "<td>"+sexoEdadM[6]+"</td>"+
                    "<td>"+sexoEdadF[6]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>8</td>"+
                    "<td>50 a 59 años</td>"+
                    "<td>"+sexoEdadM[7]+"</td>"+
                    "<td>"+sexoEdadF[7]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>9</td>"+
                    "<td>60 a 69 años</td>"+
                    "<td>"+sexoEdadM[8]+"</td>"+
                    "<td>"+sexoEdadF[8]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>10</td>"+
                    "<td>70 a 79 años</td>"+
                    "<td>"+sexoEdadM[9]+"</td>"+
                    "<td>"+sexoEdadF[9]+"</td>"+
                "</tr>"+
                "<tr>"+
                    "<td>11</td>"+
                    "<td>mayores a 80 años</td>"+
                    "<td>"+sexoEdadM[10]+"</td>"+
                    "<td>"+sexoEdadF[10]+"</td>"+
                "</tr>"+
                "<tr class='table-active'>"+
                    "<td>TOTAL</td>"+
                    "<td></td>"+
                    "<td>"+sumaDeArreglo(sexoEdadM)+"</td>"+
                    "<td>"+sumaDeArreglo(sexoEdadF)+"</td>"+
                "</tr>"+
            "</table>"+"</di>");
            
            garficarPorSexoEdadCaja(sexoEdadM,sexoEdadF);
            graficarPorSexoEdadTorta(sexoEdadM,sexoEdadF);
}

function cargarDatosVisualizarGraficoOcupacion(respuesta){

    let ocupacionM = new Array();
    let ocupacionF = new Array();

    ocupacionM.push(respuesta[22]);
    ocupacionM.push(respuesta[23]);
    ocupacionM.push(respuesta[24]);
    ocupacionM.push(respuesta[25]);
    ocupacionM.push(respuesta[26]);
    ocupacionM.push(respuesta[27]);

    ocupacionF.push(respuesta[28]);
    ocupacionF.push(respuesta[29]);
    ocupacionF.push(respuesta[30]);
    ocupacionF.push(respuesta[31]);
    ocupacionF.push(respuesta[32]);
    ocupacionF.push(respuesta[33]);

    global_ocupacionSexoM = ocupacionM
    global_ocupacionSexoF = ocupacionF
    document.getElementById("tablaOcupacion").innerHTML = "";
    $("#tablaOcupacion").append("<div class='card'>"+
            "<div class='card-header bg-info'>CASOS COVID 19 "+$('input:radio[name=radioBusquedaResultado]:checked').val()+" POR OCUPACION Y SEXO</div>"+
            "<div class='card-body table-responsive-sm'>"+
                "<table class='table table-sm'>"+
                    "<thead class='thead-dark'><tr>"+
                    "<th>Nº</th>"+
                    "<th>Ocupacion</th>"+
                    "<th>Hombres</th>"+
                    "<th>Mujeres</th></tr></thead>"+
                    "<tr>"+
                        "<td>1</td>"+                    
                        "<td>POLICIA</td>"+
                        "<td>"+ocupacionM[0]+"</td>"+
                        "<td>"+ocupacionF[0]+"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td>2</td>"+
                        "<td>PERSONAL DE SALUD</td>"+
                        "<td>"+ocupacionM[1]+"</td>"+
                        "<td>"+ocupacionF[1]+"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td>3</td>"+
                        "<td>PERSONAL DE LABORATORIO</td>"+
                        "<td>"+ocupacionM[2]+"</td>"+
                        "<td>"+ocupacionF[2]+"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td>4</td>"+
                        "<td>TRABAJADOR PRENSA</td>"+
                        "<td>"+ocupacionM[3]+"</td>"+
                        "<td>"+ocupacionF[3]+"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td>5</td>"+
                        "<td>FF.AA.</td>"+
                        "<td>"+ocupacionM[4]+"</td>"+
                        "<td>"+ocupacionF[4]+"</td>"+
                    "</tr>"+
                    "<tr>"+
                        "<td>6</td>"+
                        "<td>OTROS</td>"+
                        "<td>"+ocupacionM[5]+"</td>"+
                        "<td>"+ocupacionF[5]+"</td>"+
                    "</tr>"+
                    "<tr class='table-active'>"+
                        "<td>TOTAL</td>"+
                        "<td></td>"+
                        "<td>"+sumaDeArreglo(ocupacionM)+"</td>"+
                        "<td>"+sumaDeArreglo(ocupacionF)+"</td>"+
                    "</tr>"+
                "</table>"+
            "</div>"+
        "</div>"
    );
    graficoPorOcupacionSexoTorta(ocupacionM,ocupacionF);
    garficarPorSexoOcupacionCaja(ocupacionM,ocupacionF);
}

/**Exportar PDF */
$("#btnGenerarPDF").on("click",function(){

    var doc = new jsPDF('p', 'pt', 'ledger');
    var contenido = document.getElementById('reporteGraficoPDF');

    var options = {
    };
    
    doc.addHTML(contenido,15,45,options,function(){
        doc.save('REPORTE_ESTADISTICA_'+new Date().toString("yyyy-MM-dd")+'.pdf');
    });
        
});



$("#btnGenerarExcel").on("click",function(){

    //downloadAsExcel(data);

    var wb = XLSX.utils.book_new();
    wb.Props = {
                Title: "REPORTE COVID 19",
                Subject: "SARSCOV-2",
                Author: "CNS@regionalCBBA",
                CreatedDate: new Date()
        };

    wb.SheetNames.push("hoja");
    //const EXCEL_TYPE = 'application/octet-stream';
    const EXCEL_TYPE = 'application/vnd.ms-excel';
    const EXCEL_EXTENSION = '.xlsx';

    
    var ws_edadSexo = [['GRUPO DE EDADES' , 'HOMBRES','MUJERES']];
    ws_edadSexo.push(["0 a 1 años", global_edadSexoM[0], global_edadSexoF[0] ]);
    ws_edadSexo.push(["1 a 4 años",global_edadSexoM[1],global_edadSexoF[1]]);
    ws_edadSexo.push(["5 a 9 años",global_edadSexoM[2],global_edadSexoF[2]]);
    ws_edadSexo.push(["10 a 19 años",global_edadSexoM[3],global_edadSexoF[3]]);
    ws_edadSexo.push(["20 a 29 años",global_edadSexoM[4],global_edadSexoF[4]]);
    ws_edadSexo.push(["30 a 39 años",global_edadSexoM[5],global_edadSexoF[5]]);
    ws_edadSexo.push(["40 a 49 años",global_edadSexoM[6],global_edadSexoF[6]]);
    ws_edadSexo.push(["50 a 59 años",global_edadSexoM[7],global_edadSexoF[7]]);
    ws_edadSexo.push(["60 a 69 años",global_edadSexoM[8],global_edadSexoF[8]]);
    ws_edadSexo.push(["70 a 79 años",global_edadSexoM[9],global_edadSexoF[9]]);
    ws_edadSexo.push(["mayores a 80 años",global_edadSexoM[10],global_edadSexoF[10]]);
    ws_edadSexo.push(["TOTAL",sumaDeArreglo(global_edadSexoM),sumaDeArreglo(global_edadSexoF)]);

    var ws_ocupacionSexo = [['GRUPO DE OCUPACION' , 'HOMBRES','MUJERES']];
    ws_ocupacionSexo.push(["POLICIA",global_ocupacionSexoM[0],global_ocupacionSexoF[0]]);
    ws_ocupacionSexo.push(["PERSONAL DE SALUD",global_ocupacionSexoM[1],global_ocupacionSexoF[1]]);
    ws_ocupacionSexo.push(["PERSONAL DE LABORATORIO",global_ocupacionSexoM[2],global_ocupacionSexoF[2]]);
    ws_ocupacionSexo.push(["TRABAJADOR PRENSA",global_ocupacionSexoM[3],global_ocupacionSexoF[3]]);
    ws_ocupacionSexo.push(["FF.AA.",global_ocupacionSexoM[4],global_ocupacionSexoF[4]]);
    ws_ocupacionSexo.push(["OTROS",global_ocupacionSexoM[5],global_ocupacionSexoF[5]]);
    ws_ocupacionSexo.push(["TOTAL",sumaDeArreglo(global_ocupacionSexoM),sumaDeArreglo(global_ocupacionSexoF)]);
   
    var ws = XLSX.utils.aoa_to_sheet(ws_edadSexo,{origin: "C8"});
    
    XLSX.utils.sheet_add_aoa(ws,ws_ocupacionSexo,{origin: "C22"});

    XLSX.utils.sheet_add_aoa(ws,[[""]],{origin: "A1"});

    XLSX.utils.sheet_add_aoa(ws,[["CAJA NACIONAL DE SALUD REGIONAL COCHABAMBA"]],{origin: "B2"});
    
    XLSX.utils.sheet_add_aoa(ws,[["UNIDAD DE EPIDEMIOLOGIA - ESTADISTICA"]],{origin: "B3"});

    XLSX.utils.sheet_add_aoa(ws,[["REPORTE DIARIO:",$('input:radio[name=radioBusquedaResultado]:checked').val()]],{origin: "B4"});  
    
    XLSX.utils.sheet_add_aoa(ws,[["FECHA:",$("#fechaBusquedaIni").val(),$("#fechaBusquedaFin").val()]],{origin: "J4"});

    wb.Sheets["hoja"] = ws;
 
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});

    saveAs(new Blob([s2ab(wbout)],{type:EXCEL_TYPE}), 'REPORTE_ESTADISTICA_'+$('input:radio[name=radioBusquedaResultado]:checked').val()+EXCEL_EXTENSION);
});

function s2ab(s) { 
    var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
    var view = new Uint8Array(buf);  //create uint8array as viewer
    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
    return buf;    
}

function downloadAsExcel(data){

    const worksheet = XLSX.utils.json_to_sheet(data);
    const workbook = { 
        Sheets: { 
            'data': worksheet 
        }, 
        SheetNames: ['data'] 
    };

    const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
    saveAsExcel(excelBuffer,'REPORTE_ESTADISTICA_');

}

function saveAsExcel(buffer, filename){

    //const EXCEL_TYPE = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
    const EXCEL_TYPE = 'application/vnd.ms-excel';
    const EXCEL_EXTENSION = '.xlsx';
    const data = new Blob([buffer], {type: EXCEL_TYPE});
    saveAs(data,filename+new Date()+EXCEL_EXTENSION);

}


/** Funcion para convertir un objeto JSON en Arreglo */
function crearCadenaLineal(json){

    var parsed = JSON.parse(json);
    var arr = [];
    for(var x in parsed){
        arr.push(parsed[x]);
    }
    return arr;
}
/** funcion para sumar los valores de un arreglo */
function sumaDeArreglo(arreglo){    
    var count=0;
    for(var x in arreglo){
        count +=arreglo[x];
    }
    return count;
}

//para actualizar informacion de Nuevos, Confirmados, Descartados, Sospechosos, Fallecidos, Recuperados
/* window.setInterval(function(){
    console.log("Para Recargar los div de Reporte de casos");
},20000); */