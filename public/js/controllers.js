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
                angular.forEach($scope.anual, function (value, key) {
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

    $http.get('gAnual')
        .success(function (data) {
            if (data.ok) {
                $scope.error = true;
                $scope.message = '';

                var dataTemp = [];
                var keyTemp = '';
                var tempDate = '';
                angular.forEach(data.data, function (value, key) {
                    var array = [];
                    if (value.fecha == tempDate && keyTemp != '') {
                        dataTemp[(dataTemp.length - 1)][value.negocio] = parseInt(value.total);
                        keyTemp = '';
                    } else {
                        keyTemp = key;
                        tempDate = value.fecha;
                        array[value.negocio] = parseInt(value.total);
                        array['fecha'] = apiFactory.convertDateStringsToDates('1/' + value.fecha);
                        dataTemp.push(array)
                    }
                });

                $scope.gAnual = dataTemp;

                var chartAnual = AmCharts.makeChart("gAnual",
                    {
                        "type": "serial",
                        "pathToImages": "/js/amcharts/images/",
                        "categoryField": "fecha",
                        "dataDateFormat": "D/M/YYYY",
                        "autoMarginOffset": 0,
                        "marginLeft": 19,
                        "plotAreaBorderColor": "#FFFFFF",
                        "borderColor": "#FFFFFF",
                        "fontFamily": "sans-serif",
                        "fontSize": 10,
                        "theme": "none",
                        "categoryAxis": {
                            "minPeriod": "MM",
                            "parseDates": true
                        },
                        "chartCursor": {
                            "categoryBalloonDateFormat": "DD MMM YYYY"
                        },
                        "graphs": [
                            {
                                "bullet": "round",
                                "columnWidth": 0,
                                "id": "AmGraph-1",
                                "title": "Fija",
                                "valueAxis": "ValueAxis-1",
                                "valueField": "FIJA"
                            },
                            {
                                "bullet": "round",
                                "columnWidth": 0,
                                "id": "AmGraph-2",
                                "title": "Movil",
                                "valueAxis": "ValueAxis-1",
                                "valueField": "MOVIL"
                            }
                        ],
                        "colors": [
                            "#424f63",
                            "#e70d2f"
                        ],
                        "valueAxes": [
                            {
                                "id": "ValueAxis-1",
                                "title": "Total"
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
                        "legend": {
                            "useGraphSettings": true
                        },
                        "titles": [
                            {
                                "color": "#000000",
                                "id": "lead",
                                "size": 15,
                                "text": "Totales por mes (Anual)"
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
                        tipodoc: "BO",
                        total: 529801
                    },
                    {
                        tipodoc: "FA",
                        total: 131410
                    },
                    {
                        tipodoc: "NC",
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
                        tipodoc: "23",
                        total: 110709
                    },
                    {
                        tipodoc: "53",
                        total: 1
                    },
                    {
                        tipodoc: "54",
                        total: 1081283
                    },
                    {
                        tipodoc: "72",
                        total: 35119
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
