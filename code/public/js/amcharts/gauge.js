AmCharts.GaugeAxis = AmCharts.Class({
    construct: function (a) {
        this.cname = "GaugeAxis";
        this.radius = "95%";
        this.startAngle = -120;
        this.endAngle = 120;
        this.startValue = 0;
        this.endValue = 200;
        this.gridCount = 5;
        this.tickLength = 10;
        this.minorTickLength = 5;
        this.tickColor = "#555555";
        this.labelFrequency = this.tickThickness = this.tickAlpha = 1;
        this.inside = !0;
        this.labelOffset = 10;
        this.showLastLabel = this.showFirstLabel = !0;
        this.axisThickness = 1;
        this.axisColor = "#000000";
        this.axisAlpha = 1;
        this.gridInside = !0;
        this.topTextYOffset = 0;
        this.topTextBold = !0;
        this.bottomTextYOffset = 0;
        this.bottomTextBold = !0;
        this.centerY = this.centerX = "0%";
        this.bandOutlineAlpha = this.bandOutlineThickness = 0;
        this.bandOutlineColor = "#000000";
        this.bandAlpha = 1;
        AmCharts.applyTheme(this, a, "GaugeAxis")
    }, value2angle: function (a) {
        return (a - this.startValue) / (this.endValue - this.startValue) * (this.endAngle - this.startAngle) + this.startAngle
    }, setTopText: function (a) {
        if (void 0 !== a) {
            this.topText = a;
            var b = this.chart;
            if (this.axisCreated) {
                this.topTF && this.topTF.remove();
                var c = this.topTextFontSize;
                c || (c = b.fontSize);
                var d = this.topTextColor;
                d || (d = b.color);
                a = AmCharts.text(b.container, a, d, b.fontFamily, c, void 0, this.topTextBold);
                a.translate(this.centerXReal, this.centerYReal - this.radiusReal / 2 + this.topTextYOffset);
                this.chart.graphsSet.push(a);
                this.topTF = a
            }
        }
    }, setBottomText: function (a) {
        if (void 0 !== a) {
            this.bottomText = a;
            var b = this.chart;
            if (this.axisCreated) {
                this.bottomTF && this.bottomTF.remove();
                var c = this.bottomTextFontSize;
                c || (c = b.fontSize);
                var d = this.bottomTextColor;
                d || (d = b.color);
                a = AmCharts.text(b.container,
                    a, d, b.fontFamily, c, void 0, this.bottomTextBold);
                a.translate(this.centerXReal, this.centerYReal + this.radiusReal / 2 + this.bottomTextYOffset);
                this.bottomTF = a;
                this.chart.graphsSet.push(a)
            }
        }
    }, draw: function () {
        var a = this.chart, b = a.graphsSet, c = this.startValue, d = this.endValue, f = this.valueInterval;
        isNaN(f) && (f = (d - c) / this.gridCount);
        var m = this.minorTickInterval;
        isNaN(m) && (m = f / 5);
        var p = this.startAngle, k = this.endAngle, e = this.tickLength, l = (d - c) / f + 1, g = (k - p) / (l - 1);
        this.singleValueAngle = d = g / f;
        var h = a.container, q = this.tickColor,
            u = this.tickAlpha, C = this.tickThickness, D = f / m, F = g / D, m = this.minorTickLength, I = this.labelFrequency, s = this.radiusReal;
        this.inside || (s -= 15);
        var y = a.centerX + AmCharts.toCoordinate(this.centerX, a.realWidth), z = a.centerY + AmCharts.toCoordinate(this.centerY, a.realHeight);
        this.centerXReal = y;
        this.centerYReal = z;
        var J = {fill: this.axisColor, "fill-opacity": this.axisAlpha, "stroke-width": 0, "stroke-opacity": 0}, n, A;
        this.gridInside ? A = n = s : (n = s - e, A = n + m);
        var r = this.axisThickness / 2, k = AmCharts.wedge(h, y, z, p, k - p, n + r, n + r, n - r, 0,
            J);
        b.push(k);
        k = AmCharts.doNothing;
        AmCharts.isModern || (k = Math.round);
        J = AmCharts.getDecimals(f);
        for (n = 0; n < l; n++) {
            var w = c + n * f, r = p + n * g, v = k(y + s * Math.sin(r / 180 * Math.PI)), B = k(z - s * Math.cos(r / 180 * Math.PI)), x = k(y + (s - e) * Math.sin(r / 180 * Math.PI)), t = k(z - (s - e) * Math.cos(r / 180 * Math.PI)), v = AmCharts.line(h, [v, x], [B, t], q, u, C, 0, !1, !1, !0);
            b.push(v);
            v = -1;
            x = this.labelOffset;
            this.inside || (x = -x - e, v = 1);
            var B = Math.sin(r / 180 * Math.PI), t = Math.cos(r / 180 * Math.PI), B = y + (s - e - x) * B, x = z - (s - e - x) * t, E = this.fontSize;
            isNaN(E) && (E = a.fontSize);
            var t = Math.sin((r - 90) / 180 * Math.PI), K = Math.cos((r - 90) / 180 * Math.PI);
            if (0 < I && n / I == Math.round(n / I) && (this.showLastLabel || n != l - 1) && (this.showFirstLabel || 0 !== n)) {
                var G = AmCharts.formatNumber(w, a.nf, J), H = this.unit;
                H && (G = "left" == this.unitPosition ? H + G : G + H);
                (H = this.labelFunction) && (G = H(w));
                w = AmCharts.text(h, G, a.color, a.fontFamily, E);
                E = w.getBBox();
                w.translate(B + v * E.width / 2 * K, x + v * E.height / 2 * t);
                b.push(w)
            }
            if (n < l - 1)for (w = 1; w < D; w++)t = r + F * w, v = k(y + A * Math.sin(t / 180 * Math.PI)), B = k(z - A * Math.cos(t / 180 * Math.PI)), x = k(y + (A -
            m) * Math.sin(t / 180 * Math.PI)), t = k(z - (A - m) * Math.cos(t / 180 * Math.PI)), v = AmCharts.line(h, [v, x], [B, t], q, u, C, 0, !1, !1, !0), b.push(v)
        }
        if (b = this.bands)for (c = 0; c < b.length; c++)if (f = b[c])q = f.startValue, u = f.endValue, e = AmCharts.toCoordinate(f.radius, s), isNaN(e) && (e = A), l = AmCharts.toCoordinate(f.innerRadius, s), isNaN(l) && (l = e - m), g = p + d * (q - this.startValue), u = d * (u - q), C = f.outlineColor, void 0 == C && (C = this.bandOutlineColor), D = f.outlineThickness, isNaN(D) && (D = this.bandOutlineThickness), F = f.outlineAlpha, isNaN(F) && (F = this.bandOutlineAlpha),
            q = f.alpha, isNaN(q) && (q = this.bandAlpha), e = AmCharts.wedge(h, y, z, g, u, e, e, l, 0, {
            fill: f.color,
            stroke: C,
            "stroke-width": D,
            "stroke-opacity": F
        }), e.setAttr("opacity", q), a.gridSet.push(e), this.addEventListeners(e, f);
        this.axisCreated = !0;
        this.setTopText(this.topText);
        this.setBottomText(this.bottomText);
        a = a.graphsSet.getBBox();
        this.width = a.width;
        this.height = a.height
    }, addEventListeners: function (a, b) {
        var c = this.chart;
        a.mouseover(function (a) {
            c.showBalloon(b.balloonText, b.color, !0)
        }).mouseout(function (a) {
            c.hideBalloon()
        })
    }
});
AmCharts.GaugeArrow = AmCharts.Class({
    construct: function (a) {
        this.cname = "GaugeArrow";
        this.color = "#000000";
        this.nailAlpha = this.alpha = 1;
        this.startWidth = this.nailRadius = 8;
        this.endWidth = 0;
        this.borderAlpha = 1;
        this.radius = "90%";
        this.nailBorderAlpha = this.innerRadius = 0;
        this.nailBorderThickness = 1;
        this.frame = 0;
        AmCharts.applyTheme(this, a, "GaugeArrow")
    }, setValue: function (a) {
        var b = this.chart;
        b ? b.setValue ? b.setValue(this, a) : this.previousValue = this.value = a : this.previousValue = this.value = a
    }
});
AmCharts.GaugeBand = AmCharts.Class({
    construct: function () {
        this.cname = "GaugeBand"
    }
});
AmCharts.AmAngularGauge = AmCharts.Class({
    inherits: AmCharts.AmChart, construct: function (a) {
        this.cname = "AmAngularGauge";
        AmCharts.AmAngularGauge.base.construct.call(this, a);
        this.theme = a;
        this.type = "gauge";
        this.minRadius = this.marginRight = this.marginBottom = this.marginTop = this.marginLeft = 10;
        this.faceColor = "#FAFAFA";
        this.faceAlpha = 0;
        this.faceBorderWidth = 1;
        this.faceBorderColor = "#555555";
        this.faceBorderAlpha = 0;
        this.arrows = [];
        this.axes = [];
        this.startDuration = 1;
        this.startEffect = "easeOutSine";
        this.adjustSize = !0;
        this.extraHeight = this.extraWidth = 0;
        AmCharts.applyTheme(this, a, this.cname)
    }, addAxis: function (a) {
        this.axes.push(a)
    }, formatString: function (a, b) {
        return a = AmCharts.formatValue(a, b, ["value"], this.nf, "", this.usePrefixes, this.prefixesOfSmallNumbers, this.prefixesOfBigNumbers)
    }, initChart: function () {
        AmCharts.AmAngularGauge.base.initChart.call(this);
        var a;
        0 === this.axes.length && (a = new AmCharts.GaugeAxis(this.theme), this.addAxis(a));
        var b;
        for (b = 0; b < this.axes.length; b++)a = this.axes[b], a = AmCharts.processObject(a,
            AmCharts.GaugeAxis, this.theme), a.chart = this, this.axes[b] = a;
        var c = this.arrows;
        for (b = 0; b < c.length; b++) {
            a = c[b];
            a = AmCharts.processObject(a, AmCharts.GaugeArrow, this.theme);
            a.chart = this;
            c[b] = a;
            var d = a.axis;
            AmCharts.isString(d) && (a.axis = AmCharts.getObjById(this.axes, d));
            a.axis || (a.axis = this.axes[0]);
            isNaN(a.value) && a.setValue(a.axis.startValue);
            isNaN(a.previousValue) && (a.previousValue = a.axis.startValue)
        }
        this.setLegendData(c);
        this.drawChart();
        this.totalFrames = 1E3 * this.startDuration / AmCharts.updateRate
    }, drawChart: function () {
        AmCharts.AmAngularGauge.base.drawChart.call(this);
        var a = this.container, b = this.updateWidth();
        this.realWidth = b;
        var c = this.updateHeight();
        this.realHeight = c;
        var d = AmCharts.toCoordinate, f = d(this.marginLeft, b), m = d(this.marginRight, b), p = d(this.marginTop, c) + this.getTitleHeight(), k = d(this.marginBottom, c), e = d(this.radius, b, c), d = b - f - m, l = c - p - k + this.extraHeight;
        e || (e = Math.min(d, l) / 2);
        e < this.minRadius && (e = this.minRadius);
        this.radiusReal = e;
        this.centerX = (b - f - m) / 2 + f;
        this.centerY = (c - p - k) / 2 + p + this.extraHeight / 2;
        isNaN(this.gaugeX) || (this.centerX = this.gaugeX);
        isNaN(this.gaugeY) ||
        (this.centerY = this.gaugeY);
        var b = this.faceAlpha, c = this.faceBorderAlpha, g;
        if (0 < b || 0 < c)g = AmCharts.circle(a, e, this.faceColor, b, this.faceBorderWidth, this.faceBorderColor, c, !1), g.translate(this.centerX, this.centerY), g.toBack(), (a = this.facePattern) && g.pattern(a);
        for (b = e = a = 0; b < this.axes.length; b++) {
            c = this.axes[b];
            f = c.radius;
            c.radiusReal = AmCharts.toCoordinate(f, this.radiusReal);
            c.draw();
            if (-1 !== f.indexOf("%"))var h = 1 + (100 - Number(f.substr(0, f.length - 1))) / 100;
            c.width * h > a && (a = c.width * h);
            c.height * h > e && (e = c.height *
            h)
        }
        (h = this.legend) && h.invalidateSize();
        if (this.adjustSize && !this.chartCreated) {
            g && (g = g.getBBox(), g.width > a && (a = g.width), g.height > e && (e = g.height));
            g = 0;
            if (l > e || d > a)g = Math.min(l - e, d - a);
            0 < g && (this.extraHeight = l - e, this.chartCreated = !0, this.validateNow())
        }
        this.dispDUpd();
        this.chartCreated = !0
    }, validateSize: function () {
        this.extraHeight = this.extraWidth = 0;
        this.chartCreated = !1;
        AmCharts.AmAngularGauge.base.validateSize.call(this)
    }, addArrow: function (a) {
        this.arrows.push(a)
    }, removeArrow: function (a) {
        AmCharts.removeFromArray(this.arrows,
            a);
        this.validateNow()
    }, removeAxis: function (a) {
        AmCharts.removeFromArray(this.axes, a);
        this.validateNow()
    }, drawArrow: function (a, b) {
        a.set && a.set.remove();
        var c = this.container;
        a.set = c.set();
        if (!a.hidden) {
            var d = a.axis, f = d.radiusReal, m = d.centerXReal, p = d.centerYReal, k = a.startWidth, e = a.endWidth, l = AmCharts.toCoordinate(a.innerRadius, d.radiusReal), g = AmCharts.toCoordinate(a.radius, d.radiusReal);
            d.inside || (g -= 15);
            var h = a.nailColor;
            h || (h = a.color);
            var q = a.nailColor;
            q || (q = a.color);
            h = AmCharts.circle(c, a.nailRadius,
                h, a.nailAlpha, a.nailBorderThickness, h, a.nailBorderAlpha);
            a.set.push(h);
            h.translate(m, p);
            isNaN(g) && (g = f - d.tickLength);
            var d = Math.sin(b / 180 * Math.PI), f = Math.cos(b / 180 * Math.PI), h = Math.sin((b + 90) / 180 * Math.PI), u = Math.cos((b + 90) / 180 * Math.PI), c = AmCharts.polygon(c, [m - k / 2 * h + l * d, m + g * d - e / 2 * h, m + g * d + e / 2 * h, m + k / 2 * h + l * d], [p + k / 2 * u - l * f, p - g * f + e / 2 * u, p - g * f - e / 2 * u, p - k / 2 * u - l * f], a.color, a.alpha, 1, q, a.borderAlpha, void 0, !0);
            a.set.push(c);
            this.graphsSet.push(a.set)
        }
    }, setValue: function (a, b) {
        a.axis && a.axis.value2angle && (a.axis.value2angle(b),
            a.frame = 0, a.previousValue = a.value);
        a.value = b;
        var c = this.legend;
        c && c.updateValues()
    }, handleLegendEvent: function (a) {
        var b = a.type;
        a = a.dataItem;
        if (!this.legend.data && a)switch (b) {
            case "hideItem":
                this.hideArrow(a);
                break;
            case "showItem":
                this.showArrow(a)
        }
    }, hideArrow: function (a) {
        a.set.hide();
        a.hidden = !0
    }, showArrow: function (a) {
        a.set.show();
        a.hidden = !1
    }, updateAnimations: function () {
        AmCharts.AmAngularGauge.base.updateAnimations.call(this);
        for (var a = this.arrows.length, b, c = 0; c < a; c++) {
            b = this.arrows[c];
            var d;
            b.frame >=
            this.totalFrames ? d = b.value : (b.frame++, b.clockWiseOnly && b.value < b.previousValue && (d = b.axis, b.previousValue -= d.endValue - d.startValue), d = AmCharts.getEffect(this.startEffect), d = AmCharts[d](0, b.frame, b.previousValue, b.value - b.previousValue, this.totalFrames), isNaN(d) && (d = b.value));
            d = b.axis.value2angle(d);
            this.drawArrow(b, d)
        }
    }
});