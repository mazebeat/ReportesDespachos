reportesDespacho.controller('graphsController', ['$scope', '$http', 'apiFactory', 'chartService', function ($scope, $http, apiFactory, chartService) {
    $scope.date = new Date();
    $scope.error = false;

    $http.get('anual')
        .success(function (data) {
            if (data.ok) {
                $scope.error = true;
                $scope.message = '';
                angular.forEach(data.data, function (value, key) {
                    if (value.negocio == 'FIJA') {
                        $scope.anualfija = value.total;
                    }
                    else {
                        $scope.anualmovil = value.total;
                    }
                });
            }
            else {
                $scope.anualfija = 0;
                $scope.anualmovil = 0;
                $scope.message = data.message;
            }
        });

    $http.get('mensual')
        .success(function (data) {
            if (data.ok) {
                $scope.error = true;
                $scope.mensual = data.data;
                $scope.message = '';
                angular.forEach(data.data, function (value, key) {
                    if (value.negocio == 'FIJA') {
                        $scope.mensualfija = value.total;
                    }
                    else {
                        $scope.mensualmovil = value.total;
                    }
                });

            } else {
                $scope.mensualfija = 0;
                $scope.mensualmovil = 0;
                $scope.message = data.message;
            }
        });

    $scope.serialChart = function (data) {
        var arreglo = [], config = [], campañas = [], temp = [], fecha = '', id = '', negocio = '';
        angular.forEach(data, function (v, k) {
            fecha = v.fecha;
            id = fecha.replace('/', '');

            if (v.hasOwnProperty('fecha')) {
                negocio = v.negocio;
            }

            campañas.push(negocio);

            if (arreglo.hasOwnProperty(id)) {
                arreglo[id][v.negocio] = parseInt(v.total);
            } else {
                var mes = fecha.split('/')[0];
                var ano = fecha.split('/')[1];
                arreglo[id] = {'fecha': AmCharts.formatDate(new Date(ano, parseInt(mes - 1), 1), "DD/MM/YYYY")};
                arreglo[id][v.negocio] = parseInt(v.total);
            }
        });

        arreglo.forEach(function (elemento) {
            if (elemento != null) {
                temp.push(elemento);
            }
        });
        config['data'] = temp;
        config['graphs'] = $scope.unique(campañas);
        return config;
    };

    $scope.unique = function (origArr) {
        var newArr = [],
            origLen = origArr.length,
            found, x, y;

        for (x = 0; x < origLen; x++) {
            found = undefined;
            for (y = 0; y < newArr.length; y++) {
                if (origArr[x] === newArr[y]) {
                    found = true;
                    break;
                }
            }
            if (!found) {
                newArr.push(origArr[x]);
            }
        }
        return newArr;
    };

    $http.get('gAnual')
        .success(function (data) {
            if (data.ok) {
                $scope.error = true;
                $scope.message = '';
                var dataTemp = $scope.serialChart(data.data);
                $scope.gAnual = dataTemp.data;
                var chartAnual = AmCharts.makeChart("gAnual",
                    {
                        "type": "serial",
                        "pathToImages": "/js/amcharts/images/",
                        "categoryField": "fecha",
                        "dataDateFormat": "DD/MM/YYYY",
                        "autoMarginOffset": 0,
                        "marginLeft": 0,
                        "plotAreaBorderColor": "#FFFFFF",
                        "borderColor": "#FFFFFF",
                        "fontFamily": "sans-serif",
                        "fontSize": 10,
                        "theme": "none",
                        "chartCursor": {},
                        "chartScrollbar": {},
                        "trendLines": [],
                        "categoryAxis": {
                            "startOnAxis": true,
                            "minPeriod": "MM",
                            "parseDates": true,
                            "gridPosition": "start",
                            "axisAlpha": 0,
                            "fillAlpha": 0.05,
                            "fillColor": "#000000",
                            "gridAlpha": 0,
                        },
                        "chartCursor": {
                            "categoryBalloonDateFormat": "DD MMMM YYYY"
                        },
                        "numberFormatter": {
                            "precision": -1,
                            "decimalSeparator": ",",
                            "thousandsSeparator": "."
                        },
                        "graphs": [
                            {
                                "balloonText": "<span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                                "bullet": "round",
                                "title": "Fija",
                                "fillAlphas": 0,
                                "lineAlpha": 0.51,
                                "valueField": "FIJA"
                            },
                            {
                                "balloonText": "<span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                                "bullet": "round",
                                "title": "Movil",
                                "fillAlphas": 0,
                                "lineAlpha": 0.51,
                                "valueField": "MOVIL"
                            }
                        ],
                        "colors": [
                            "#424f63",
                            "#e70d2f"
                        ],
                        "valueAxes": [
                            {
                                "id": "Total",
                                "title": "Total",
                                "integersOnly": true,
                                "axisAlpha": 0,
                                "dashLength": 5,
                                "gridCount": 10
                            }
                        ],
                        "exportConfig": {
                            "menuTop": "0px",
                            "menuItems": [{
                                "icon": '/js/amcharts/images/export.png',
                                "format": 'png'
                            }]
                        },
                        "balloon": {
                            "adjustBorderColor": true,
                            "color": "#000000",
                            "cornerRadius": 5,
                            "fillColor": "#FFFFFF"
                        },
                        "chartCursor": {
                            "cursorAlpha": 0,
                            "cursorPosition": "mouse",
                            "zoomable": false
                        },
                        "legend": {
                            "useGraphSettings": false
                        },
                        "titles": [
                            {
                                "color": "#000000",
                                "id": "lead",
                                "size": 15,
                                "text": "Total acumulados (Anual)"
                            }
                        ],
                        "dataProvider": $scope.gAnual
                    });

            } else {
                $scope.gAnual = [];
                $scope.message = data.message;
            }
        });

    $http.get('gMensualFija')
        .success(function (data) {
            if (data.ok) {
                $scope.error = true;
                $scope.gMensualFija = data.data;
                $scope.message = '';
            } else {
                $scope.gMensualFija = [
                    {
                        tipodoc: "BOLETA",
                        total: 529801
                    },
                    {
                        tipodoc: "FACTURA",
                        total: 131410
                    },
                    {
                        tipodoc: "NOTA DE CREDITO",
                        total: 17799
                    }
                ];
                //$scope.gMensualFija = [];
                $scope.message = data.message;
            }

            chartService.donut(chartMensualFija, 'gMensualFija', $scope.gMensualFija, 'total', 'tipdoc', 'tipodoc', null);
        });

    $http.get('gMensualMovil')
        .success(function (data) {
            if (data.ok) {
                $scope.error = true;
                $scope.gMensualMovil = data.data;
                $scope.message = '';
            } else {
                $scope.gMensualMovil = [
                    {
                        tipodoc: "CICLO",
                        total: 110709
                    },
                    {
                        tipodoc: "NO CICLO",
                        total: 1081283
                    }
                ];
                //$scope.gMensualMovil = [];
                $scope.message = data.message;
            }

            chartService.donut(chartMensualMovil, 'gMensualMovil', $scope.gMensualMovil, 'total', 'tipdoc', 'tipodoc', null);
        });
}]);

reportesDespacho.controller('homeController', ['$scope', '$http', function ($scope, $http) {
}]);
