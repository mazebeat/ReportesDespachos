'use strict';

/* Api Service */
reportesDespacho.service('apiFactory', [function () {

    this.isEmpty = function (obj) {
        for (var i in obj) if (obj.hasOwnProperty(i)) return false;
        return true;
    };

    this.regexIso8601 = /^(\d{4}|\+\d{6})(?:-(\d{2})(?:-(\d{2})(?:T(\d{2}):(\d{2}):(\d{2})\.(\d{1,})(Z|([\-+])(\d{2}):(\d{2}))?)?)?)?$/;

    this.convertDateStringsToDates = function (input) {
        // Ignore things that aren't objects.
        if (typeof input !== "object") return input;

        for (var key in input) {
            if (!input.hasOwnProperty(key)) continue;

            var value = input[key];
            var match;
            // Check for string properties which look like dates.
            // TODO: Improve this regex to better match ISO 8601 date strings.
            if (typeof value === "string" && (match = value.match(this.regexIso8601))) {
                // Assume that Date.parse can parse ISO 8601 strings, or has been shimmed in older browsers to do so.
                var milliseconds = Date.parse(match[0]);
                if (!isNaN(milliseconds)) {
                    input[key] = new Date(milliseconds);
                }
            } else if (typeof value === "object") {
                // Recurse into object
                convertDateStringsToDates(value);
            }
        }
    };

    this.notify = function (title, message, type) {
        var title = typeof title !== 'undefined' && title.length ? title : '';
        var message = typeof message !== 'undefined' && message.length ? message : 'Error en el servidor, por favor espere.';
        var type = typeof type !== 'undefined' && type.length ? type : 'notice';

        if (message instanceof Array) {
            angular.forEach(message, function (v, k) {
                new PNotify({
                    type: type,
                    title: title,
                    text: v,
                    animate_speed: "fast",
                    desktop: {
                        desktop: true
                    },
                    sticker: false
                });
            });
        } else {
            new PNotify({
                type: type,
                title: title,
                text: message,
                animate_speed: "fast",
                desktop: {
                    desktop: true
                },
                sticker: false
            });
        }
    };

    this.getMonth = function (date) {
        var month = date.getMonth();
        return month < 10 ? '0' + month : month;
        /* ('' + month) for string result */
    };

    this.exportDataToTable = function (id, name) {
        var blob = new Blob([document.getElementById(id).innerHTML], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
        });
        console.log(name + ".xls");
        saveAs(blob, name + ".xls");
    };
}]);

/* Chart Service */
reportesDespacho.service('chartService', ['rootFactory', '$http', '$window', function (rootFactory, $http, $window) {
    this.urlImages = rootFactory.root + '/js/amcharts/images/';

    this.unique = function (origArr) {
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

    this.sort = function (array) {
       var array = array.sort(function (a, b) {
            return a.item.localeCompare(b.item);
        });
        //console.log(array);
    };

    /* 123 || 321 */
    this.sortJSON = function (data, key, way) {
        return data.sort(function (a, b) {
            var x = a[key];
            var y = b[key];
            if (way === '123') {
                return ((x < y) ? -1 : ((x > y) ? 1 : 0));
            }
            if (way === '321') {
                return ((x > y) ? -1 : ((x < y) ? 1 : 0));
            }
        });
    };

    this.donut = function (chart, div, data, ejeX, ejey, title, labelTexto) {
        labelTexto = typeof labelTexto !== 'undefined' || labelTexto != null ? labelTexto : '';
        chart.titleField = title;
        chart.valueField = ejeX;
        chart.outlineColor = "#FFFFFF";
        chart.outlineAlpha = 0.8;
        chart.outlineThickness = 2;
        chart.labelTexto = labelTexto;
        /* <--- titulo de cada parte del gráfico */
        chart.balloonTex = "[[title]]<br><span style='font-size:11px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart.pathToImages = this.urlImages;
        chart.categoryField = ejey;
        chart.language = "es";
        chart.numberFormatter = this.formatNumber();
        /* */
        chart.labelRadius = 5;
        chart.radius = "35%";
        chart.innerRadius = "60%";
        chart.dataDateFormat = "YYYY-MM-DD HH:NN";
        this.animation(chart, true);
        this.legend(chart);

        //chart.exportConfig = this.export();

        chart.dataProvider = data;
        chart.write(div);
    };

    this.semestral = function (chart, div, data, ejeX, ejey, title, labelTexto) {
        labelTexto = typeof labelTexto !== 'undefined' || labelTexto != null ? labelTexto : '';
        chart.pathToImages = this.urlImages;
        chart.categoryField = ejey;
        /* <--- */
        chart.language = "es";
        chart.numberFormatter = this.formatNumber();
        chart.dataDateFormat = "YYYY-MM";

        var chartScrollbar = new AmCharts.ChartScrollbar();
        chartScrollbar.updateOnReleaseOnly = true;
        chartScrollbar.autoGridCount = true;
        chartScrollbar.scrollbarHeight = 20;
        chart.addChartScrollbar(chartScrollbar);

        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.dashLength = 1;
        valueAxis.axisColor = "#DADADA";
        valueAxis.axisAlpha = 1;
        /* valueAxis.unit = "$"; */
        valueAxis.unitPosition = "left";
        chart.addValueAxis(valueAxis);

        var count = 0;
        angular.forEach(data.graphs, function (v, k) {
            var graph = new AmCharts.AmGraph();
            var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
            graph.title = v;
            graph.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]: <b>[[value]]</b></span>";
            graph.type = "line";
            graph.valueField = v;
            /* <--- */
            graph.lineColor = color;
            graph.lineThickness = 3;
            graph.bullet = "round";
            graph.bulletColor = color;
            graph.bulletBorderColor = "#ffffff";
            graph.bulletBorderAlpha = 1;
            graph.bulletBorderThickness = 3;
            graph.bulletSize = 15;
            if (count > 2) {
                graph.hidden = true;
            }
            chart.addGraph(graph);
            count++;
        });

        chart.dataProvider = data.data;

        this.animation(chart, false);
        this.legend(chart);
        this.categoryAxis(chart, true);

        var chartCursor = new AmCharts.ChartCursor();
        chart.addChartCursor(chartCursor);

        //chart.exportConfig = this.export();

        chart.addListener("clickGraphItem", eventClick);
        chart.write(div);
    };

    this.dots = function (chart, div, data, ejeX, ejey, title, labelTexto) {
        labelTexto = typeof labelTexto !== 'undefined' || labelTexto != null ? labelTexto : '';
        chart.pathToImages = this.urlImages;
        chart.categoryField = ejey;
        /* <--- */
        chart.language = "es";
        chart.numberFormatter = this.formatNumber();

        chart.dataDateFormat = "YYYY-MM";

        this.categoryAxis(chart, true);

        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.dashLength = 1;
        valueAxis.axisColor = "#DADADA";
        valueAxis.axisAlpha = 1;
        /* valueAxis.unit = "$"; */
        valueAxis.unitPosition = "left";
        chart.addValueAxis(valueAxis);

        this.animation(chart, false);

        this.legend(chart);

        var graph = new AmCharts.AmGraph();
        graph.title = title;
        graph.balloonText = "<span style='font-size:13px;'>[[title]] en [[category]]: <b>[[value]]</b></span>";
        graph.type = "line";
        graph.valueField = ejeX;
        /* <--- */
        graph.lineColor = "#60c6cf";
        graph.lineThickness = 3;
        graph.bullet = "round";
        graph.bulletColor = "#60c6cf";
        graph.bulletBorderColor = "#ffffff";
        graph.bulletBorderAlpha = 1;
        graph.bulletBorderThickness = 3;
        graph.dashLengthLine = "dashLengthLine";
        graph.bulletSize = 15;
        chart.addGraph(graph);

        //chart.exportConfig = this.export();

        var chartCursor = new AmCharts.ChartCursor();
        chart.addChartCursor(chartCursor);

        chart.dataProvider = data;
        chart.write(div);
    };

    this.animation = function (chart, bool) {
        if (bool) {
            chart.sequencedAnimation = true;
            chart.startDuration = 1;
            chart.startAlpha = 0;
        } else {
            chart.sequencedAnimation = false;
            chart.startDuration = 0;
            chart.startAlpha = 0;
        }
    };

    this.export = function () {
        var exportConfig = {
            menuTop: "-10px",
            menuBottom: "0px",
            menuRight: "0px",
            backgroundColor: "#efefef",
            menuItems: [{
                textAlign: 'center',
                icon: this.urlImages + 'export.png',
                items: [{
                    title: 'JPG',
                    format: 'jpg'
                }, {
                    title: 'PNG',
                    format: 'png'
                }, {
                    title: 'SVG',
                    format: 'svg'
                }, {
                    title: 'PDF',
                    format: 'pdf'
                }]
            }]
        };

        return exportConfig;
    };

    this.legend = function (chart, legenddiv, text) {
        legenddiv = typeof legenddiv !== 'undefined' && legenddiv.length != 0 ? legenddiv : false;
        text = typeof text !== 'undefined' && text.length != 0 ? text : false;

        var legend = new AmCharts.AmLegend();
        legend.align = "center";
        legend.markerType = "circle";
        legend.valueText = "";
        legend.useGraphSettings = false;

        if (!text) {
            legend.labelTexto = "[[title]]";
        } else {
            legend.labelTexto = text;
        }

        if (!legenddiv) {
            chart.addLegend(legend);
        } else {
            chart.addLegend(legend, legenddiv);
        }
    };

    this.margin = function (chart) {
        chart.autoMargins = false;
        chart.marginRight = 10;
        chart.marginLeft = 80;
        chart.marginBottom = 20;
        chart.marginTop = 20;
    };

    this.formatNumber = function () {
        return {
            decimalSeparator: ",",
            thousandsSeparator: ".",
            precision: parseInt(-1)
        };
    };

    this.categoryAxis = function (chart, parse) {
        parse = typeof parse !== 'undefined' && parse.length != 0 ? parse : true;
        var categoryAxis = chart.categoryAxis;
        categoryAxis.inside = false;
        categoryAxis.axisAlpha = 0;
        categoryAxis.gridAlpha = 0;
        categoryAxis.tickLength = 0;
        categoryAxis.minPeriod = "MM";
        categoryAxis.equalSpacing = false;
        categoryAxis.equalSpacing = true;
        categoryAxis.boldPeriodBeginning = true;
        if (parse) {
            categoryAxis.parseDates = true;
            /*
             //categoryAxis.dateFormats = [
             //    {
             //        period: 'fff',
             //        format: 'JJ:NN:SS'
             //    }, {
             //        period: 'ss',
             //        format: 'JJ:NN:SS'
             //    }, {
             //        period: 'mm',
             //        format: 'JJ:NN'
             //    }, {
             //        period: 'hh',
             //        format: 'JJ:NN'
             //    }, {
             //        period: 'DD',
             //        format: 'MMM DD'
             //    }, {
             //        period: 'WW',
             //        format: 'MMM DD'
             //    }, {
             //        period: 'MM',
             //        format: 'MMM YYYY'
             //    }, {
             //        period: 'YYYY',
             //        format: 'MMM YYYY'
             //    }
             //];
             */
        }
    };

    this.exportGraphToFormat = function (chart, format, fileName) {
        var exp = new AmCharts.AmExport(chart);
        exp.init();
        exp.output({
            format: format,
            output: 'save',
            backgroundColor: '#FFFFFF',
            fileName: fileName,
            dpi: 90
        });

        //exp.userCFG = {
        //    menuTop: 'auto',
        //    menuLeft: 'auto',
        //    menuRight: '0px',
        //    menuBottom: '0px',
        //    menuItems: [{
        //        textAlign: 'center',
        //        icon: '../amcharts/images/export.png',
        //        iconTitle: 'Save chart as an image',
        //        onclick: function () {
        //        },
        //        items: [{
        //            title: 'JPG',
        //            format: 'jpg'
        //        }, {
        //            title: 'PNG',
        //            format: 'png'
        //        }, {
        //            title: 'SVG',
        //            format: 'svg'
        //        }]
        //    }],
        //    menuItemStyle: {
        //        backgroundColor: 'transparent',
        //        opacity: 1,
        //        rollOverBackgroundColor: '#EFEFEF',
        //        color: '#000000',
        //        rollOverColor: '#CC0000',
        //        paddingTop: '6px',
        //        paddingRight: '6px',
        //        paddingBottom: '6px',
        //        paddingLeft: '6px',
        //        marginTop: '0px',
        //        marginRight: '0px',
        //        marginBottom: '0px',
        //        marginLeft: '0px',
        //        textAlign: 'left',
        //        textDecoration: 'none',
        //        fontFamily: 'Arial', // Default: charts default
        //        fontSize: '12px', // Default: charts default
        //    },
        //    menuItemOutput: {
        //        backgroundColor: '#FFFFFF',
        //        fileName: 'amCharts',
        //        format: 'png',
        //        output: 'dataurlnewwindow',
        //        render: 'browser',
        //        dpi: 90,
        //        onclick: function (instance, config, event) {
        //            event.preventDefault();
        //            instance.output(config);
        //        }
        //    },
        //    removeImagery: true
        //}
    }
}]);
