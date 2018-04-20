var chartBarHor, chartRadar, chartLine;

$(document).ready( function () {

    $(".selectTwo").select2();

    initBar();
    initPie();
    initPolar();
    initLine();
    initRadar();

});

$("#lineDate").change(function () {
    chartLine.destroy();
    initLine();
});

$("#lineGame").change(function () {
    chartLine.destroy();
    initLine();
});

$("#radarGame").change(function () {
    chartBarHor.destroy();
    chartRadar.destroy();
    initRadar();
});

function initLine() {
    //Inicializando gráfica lineal
    $.ajax({
        method: "POST",
        data: {'method' : 'getLinePage', 'year' : $("#lineDate").val(), 'game' : $("#lineGame").val()},
        url: "../http/controllers/StorePageController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //Generando datasets para la grafica
            var lineDatasets = [];
            for (var i = 0; i < $data.length; i++) {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256); 

                //Dataset de gráfica lineal
                var dataset = {
                    label: $data[i].release_date == "Total" ? "Total" : 'Versión No. ' + (i + 1) + ' (' + $data[i].release_date + ')',
                    data: [$data[i].jan, $data[i].feb, $data[i].mar, $data[i].apr, $data[i].may, $data[i].jun, 
                           $data[i].jul, $data[i].aug, $data[i].sep, $data[i].oct, $data[i].nov, $data[i].dec ],
                    borderColor: [
                        'rgba('+r+','+g+','+b+',1)'
                    ],
                    borderWidth: 3,
                    fill: false
                }
                lineDatasets.push(dataset);

            }

            
            var ctx = document.getElementById("ChartLine").getContext('2d');
            chartLine = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    datasets: lineDatasets
                },
                options: {
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

        }
    });
}

function initBar() {
    //Inicializando gráfica de barras
    $.ajax({
        method: "POST",
        data: {'method' : 'getChartPublisher'},
        url: "../http/controllers/PublisherController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            var backColor = [], bordColor = [];
            //Creando un color aleatorio por cada item de la grafica y añadiendo dicho color a 
            //unos arrays que serviran de parametros para el chart
            for ($i = 0; $i < $data.publisher.length; $i++) {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256); 

                backColor.push('rgba('+r+','+g+','+b+',0.2)');
                bordColor.push('rgba('+r+','+g+','+b+',1)');
            }

            //Inicializando gráfica con valores obtenidos
            var ctx = document.getElementById("ChartBar").getContext('2d');
            var chartBar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: $data.publisher,
                    datasets: [{
                        label: 'Cantidad de juegos vendidos',
                        data: $data.count,
                        backgroundColor: backColor,
                        borderColor: bordColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

            if ($data.publisher.length > 10) {
                chartBar.canvas.parentNode.style.width = ($data.publisher.length * 100) + 'px';
            }
            else {
                
            }
        }
    });
}

function initPie() {
    //Inicializando gráfica de pastel
    
    var ctx = document.getElementById("ChartPie").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
}

function initPolar() {
    //Inicializando gráfica de área polar
    $.ajax({
        method: "POST",
        data: {'method' : 'getChartEsrb'},
        url: "../http/controllers/EsrbController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            var backColor = [], bordColor = [];
            //Creando un color aleatorio por cada item de la grafica y añadiendo dicho color a 
            //unos arrays que serviran de parametros para el chart
            for ($i = 0; $i < $data.esrb.length; $i++) {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256); 

                backColor.push('rgba('+r+','+g+','+b+',0.2)');
                bordColor.push('rgba('+r+','+g+','+b+',1)');
            }

            //Inicializando gráfica con valores obtenidos
            var ctx = document.getElementById("ChartPolar").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: $data.esrb,
                    datasets: [{
                        data: $data.count,
                        backgroundColor: backColor,
                        borderColor: bordColor,
                        borderWidth: 1
                    }]
                }
            });
        }
    });
}

function initRadar() {
    //Inicializando gráfica vergona
    $.ajax({
        method: "POST",
        data: {'method' : 'getRadarPage', 'game' : $('#radarGame').val()},
        url: "../http/controllers/StorePageController.php",
        success: function(result) {
            //parseamos el resultado a json
            var $data = jQuery.parseJSON(result);

            //Generando datasets para la grafica
            var radarDataset = [], barLabels = [], barSold = [], barRecommended = [], barSoldColor = [], barRecommendedColor = [];
            for (var i = 0; i < $data.length; i++) {
                var r = Math.floor(Math.random() * 256);
                var g = Math.floor(Math.random() * 256);
                var b = Math.floor(Math.random() * 256); 

                var labelName = 'Versión No. ' + (i + 1) + ' (' + $data[i].date + ')'
                var backColor = 'rgba('+r+','+g+','+b+',0.2)';
                var bordColor = 'rgba('+r+','+g+','+b+',1)';

                //Atributos de dataset de gráfica de barras
                barLabels.push(labelName);
                barSold.push($data[i].sold);
                barRecommended.push($data[i].recommended);
                barSoldColor.push(backColor);
                barRecommendedColor.push(bordColor);

                var recommendedPercent = ($data[i].recommended / $data[i].reviews * 100).toFixed(2);

                //Dataset de gráfica de radar
                var dataset = {
                    label: labelName,
                    data: [$data[i].price, $data[i].discount, recommendedPercent],
                    backgroundColor: [
                        backColor
                    ],
                    borderColor: [
                        bordColor
                    ],
                    borderWidth: 1
                }
                radarDataset.push(dataset);

            }

            //Gráfico de barras
            var ctx = document.getElementById("ChartBarHor").getContext('2d');
            chartBarHor = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Unidades vendidas',
                        data: barSold,
                        backgroundColor: barSoldColor,
                        borderColor: barRecommendedColor,
                        borderWidth: 1
                    },
                    {
                        label: 'Reviews positivas',
                        data: barRecommended,
                        backgroundColor: barRecommendedColor,
                        borderColor: barRecommendedColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });

            //Gráfico de radar
            var ctx = document.getElementById("ChartRadar").getContext('2d');
            chartRadar = new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: ["Precio", "Descuento", "Porcentaje de recomendación"],
                    datasets: radarDataset
                },
                options: {
                    scale: {
                        ticks: {
                            max: 100
                        }
                    }
                }
            });
        }
    });
}