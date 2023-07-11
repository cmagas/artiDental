function  obtenerDatosGrafica()
{
  var cadObj1="";

    function funcAjax() {
        var resp1 = peticion_http.responseText;
        arrResp1 = resp1.split("|");
        if (arrResp1[0] == "1") {

          const arreglos1=JSON.parse(arrResp1[1]);

          var fecha_venta=[];
          var total_venta=[];
          var total_venta_ant=[];

          var total_ventas_mes=0;

          arreglos1.forEach(element => {
            //console.log(element);
            fecha_venta.push(element.fechaVenta);
            total_venta.push(element.importeDia);

            total_ventas_mes=parseFloat(total_ventas_mes) + parseFloat(element.importeDia);

          });
          $("#title-header").html('Ventas del Mes: $./ ' + total_ventas_mes.toString().replace(
            /\d(?=(\d{3})+\.)/g, "$&,"));

            var barChartCanvas = $("#barChart").get(0).getContext('2d');

            var areaChartData = {
              labels: fecha_venta,
              datasets: [{
                  label: 'Ventas del Anterior - Octubre',
                  backgroundColor: 'rgb(255, 140, 0,0.9)',
                  data: total_venta_ant
              }, {
                  label: 'Ventas del Mes - Noviembre',
                  backgroundColor: 'rgba(60,141,188,0.9)',
                  data: total_venta
              }]
            }

            var barChartData = $.extend(true, {}, areaChartData);

            var temp0 = areaChartData.datasets[0];

            barChartData.datasets[0] = temp0;

            var barChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                events: false,
                legend: {
                    display: true
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                },
                animation: {
                    duration: 500,
                    easing: "easeOutQuart",
                    onComplete: function() {
                        var ctx = this.chart.ctx;
                        ctx.font = Chart.helpers.fontString(Chart.defaults.global
                            .defaultFontFamily, 'normal',
                            Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function(dataset) {
                            for (var i = 0; i < dataset.data.length; i++) {
                                var model = dataset._meta[Object.keys(dataset
                                        ._meta)[0]].data[i]._model,
                                    scale_max = dataset._meta[Object.keys(dataset
                                        ._meta)[0]].data[i]._yScale.maxHeight;
                                ctx.fillStyle = '#FFF';
                                var y_pos = model.y - 5;
                                // Make sure data value does not get overflown and hidden
                                // when the bar's value is too close to max value of scale
                                // Note: The y value is reverse, it counts from top down
                                if ((scale_max - model.y) / scale_max >= 0.93)
                                    y_pos = model.y + 20;
                                ctx.fillText(dataset.data[i], model.x, y_pos);
                            }
                        });
                    }
                }
            }

            new Chart(barChartCanvas, {
              type: 'bar',
              data: barChartData,
              options: barChartOptions
            })


        } else {
          Swal.fire(
            "Mensaje De Error",
            "Lo sentimos, no se pudo obtener información Graficas",
            "error"
          );
        }
      }
      obtenerDatosWeb("funciones/paginaFunciones.php",funcAjax,"POST","funcion=2&cadObj1=" + cadObj1,true);
}