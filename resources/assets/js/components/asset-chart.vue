<template>
    <div>
        <div v-show="loading">
            <div :class="['ui active dimmer', inverted ? 'inverted' : '']">
                <div class="ui text loader">{{ loadingText }}</div>
            </div>
        </div>
        <div v-show="display" id="asset-chart-container">
            <div class="chart-buttons">
                <button v-for="(periodName, periodId) in periods" :key="periodId" :class="['ui mini button', periodId != period ? 'basic' : '', color]" @click="getChartData(periodId,symbol)">{{ periodName }}</button>
            </div>
            <canvas id="asset-chart"></canvas>
        </div>
    </div>
</template>
<script type="text/babel">
    import Chart from 'chart.js'
    import colors from '../colors.json'
    import UtilsMixin from './mixins/utils.vue'

    export default {
        mixins: [UtilsMixin],
        props: ['asset', 'color', 'currency', 'inverted'],
        data() {
            return {
                loading: true,
                display: true,
                period: '365day', // default chart period
                chart: null,
                chartData: {},
                periods: {
                    '1day': this.__('app.period_1day'),
                    '7day': this.__('app.period_7day'),
                    '30day': this.__('app.period_30day'),
                    '90day': this.__('app.period_90day'),
                    '180day': this.__('app.period_180day'),
                    '365day': this.__('app.period_365day'),
                    'all': this.__('app.period_all')
                }
            }
        },
        computed: {
            symbol() {
                return this.asset.external_id;
            },
            loadingText() {
                return this.__('app.chart_loading');
            },
            lineColor() {
                return typeof colors[this.color] != undefined ? colors[this.color] : '#d4d4d5';
            },
            xValues() {
                return this.chartData[this.period] ? this.chartData[this.period].map(item => item['time']) : [];
            },
            yValues() {
                var rate = parseFloat(this.currency.rate);
                if (isNaN(rate) || rate == 0)
                    rate = 1;
                return this.chartData[this.period] ? this.chartData[this.period].map(item => item['priceUsd'] / rate) : [];
            }
        },
        methods: {
            getRequestUrl(period, symbol) {
                const URL = 'https://api.coincap.io/v2/assets/' + symbol + '/history';
                var params;
                var now = new Date().getTime();

                if (period == '1day') {
                    params = 'interval=m15&start='+(now-1000*60*60*24)+'&end='+now;
                } else if (period == '7day') {
                    params = 'interval=h1&start='+(now-1000*60*60*24*7)+'&end='+now;
                } else if (period == '30day') {
                    params = 'interval=h12&start='+(now-1000*60*60*24*30)+'&end='+now;
                } else if (period == '90day') {
                    params = 'interval=d1&start='+(now-1000*60*60*24*90)+'&end='+now;
                } else if (period == '180day') {
                    params = 'interval=d1&start='+(now-1000*60*60*24*180)+'&end='+now;
                } else if (period == '365day') {
                    params = 'interval=d1&start='+(now-1000*60*60*24*365)+'&end='+now;
                } else {
                    params = 'interval=d1';
                }

                return URL + '?' + params;
            },
            getChartData(period, symbol) {
                this.loading = true;
                this.display = true;
                this.period = period;

                // take data from cache if it's already loaded
                if (typeof this.chartData[this.period] != 'undefined') {
                    this.loading = false;
                    this.displayChart();
                // otherwise pull data from API
                } else {
                    // Laravel adds X-CSRF-TOKEN to all HTTP requests, which causes an error response from the API (Request header field x-csrf-token is not allowed by Access-Control-Allow-Headers in preflight response).
                    // So this header needs to be deleted to avoid the error.
                    var axiosInstance = axios.create();
                    delete axiosInstance.defaults.headers.common['X-CSRF-TOKEN'];

                    axiosInstance.get(this.getRequestUrl(period, symbol))
                        .then(response => {
                            this.loading = false;
                            if (response.status == 200 && response.data != null && typeof response.data.data != 'undefined' && response.data.data.length > 2) {
                                // important to use Vue.set() otherwise computed properties based on this object will not be updated
                                this.$set(this.chartData, period, response.data.data);
                                this.displayChart();
                            } else {
                                this.display = false;
                            }
                        });
                }
            },
            displayChart() {
                if (this.chart != null) {
                    this.chart.clear();
                    this.chart.destroy();
                }

                // cursor for line chart
                // https://stackoverflow.com/a/45172506/2767324
                Chart.defaults.lineWithCursor = Chart.defaults.line;
                Chart.controllers.lineWithCursor = Chart.controllers.line.extend({
                    draw: function(ease) {
                        Chart.controllers.line.prototype.draw.call(this, ease);

                        if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
                            var activePoint = this.chart.tooltip._active[0],
                                    ctx = this.chart.ctx,
                                    x = activePoint.tooltipPosition().x,
                                    topY = this.chart.scales['y-axis-0'].top,
                                    bottomY = this.chart.scales['y-axis-0'].bottom;

                            // draw line
                            ctx.save();
                            ctx.beginPath();
                            ctx.moveTo(x, topY);
                            ctx.lineTo(x, bottomY);
                            ctx.lineWidth = 1;
                            ctx.strokeStyle = this.lineColor;
                            ctx.stroke();
                            ctx.restore();
                        }
                    }
                });

                var chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        enabled: false, // Disable default on-canvas tooltip
                        mode: 'index',
                        intersect: false, // display tooltip at all times
                        displayColors: false,
                        bodyFontColor: this.lineColor,
                        backgroundColor: '#fff',
                        borderColor: this.lineColor,
                        callbacks: {
                            label: (tooltipItem, data) => {
                                return tooltipItem.yLabel.variableDecimal() + ' ' + this.currency.code;
                            }
                            // title: (tooltipItem, data) => {} // hide label title, otherwise it's displayed automatically based on formatted xValues
                        },
                        custom: tooltipModel => {
                            // Tooltip Element
                            var tooltipId = 'asset-chart-tooltip';
                            var tooltip = document.getElementById(tooltipId);

                            // Create tooltip element on first render
                            if (!tooltip) {
                                tooltip = document.createElement('div');
                                tooltip.id = tooltipId;
                                tooltip.innerHTML = '';
                                tooltip.className = ['asset-chart-tooltip', 'no-transform'].join(' ');
                                document.body.appendChild(tooltip);
                            }

                            // Hide if no tooltip
                            if (tooltipModel.opacity === 0) {
                                tooltip.style.opacity = 0;
                                return;
                            }

                            function getBody(bodyItem) {
                                return bodyItem.lines;
                            }

                            // Set Text
                            if (tooltipModel.body) {
                                var innerHtml = '';
                                var titleLines = tooltipModel.title || [];
                                var bodyLines = tooltipModel.body.map(getBody);

                                titleLines.forEach(title => {
                                    innerHtml += '<div>' + title + '</div>';
                            });

                                bodyLines.forEach((body, i) => {
                                    innerHtml += '<div>' + body + '</div>';
                            });

                                tooltip.innerHTML = innerHtml;
                            }

                            var position = this.chart.canvas.getBoundingClientRect();

                            // tooltip styles
                            tooltip.style.opacity = 1; // important to set opacity dynamically
                            tooltip.style.position = 'absolute';
                            tooltip.style.backgroundColor = tooltipModel.backgroundColor;
                            tooltip.style.left = position.left + window.pageXOffset + tooltipModel.caretX + 'px';
                            tooltip.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                            tooltip.style.color = tooltipModel.bodyFontColor;
                            tooltip.style.borderColor = tooltipModel.borderColor;
                            tooltip.style.pointerEvents = 'none';
                        }
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            display: false,
                            ticks: {
                                callback: (value, index, values) => {
                                    return new Date(value).toLocaleDateString('en-US', { minute: 'numeric', hour: 'numeric', day: 'numeric', month: 'numeric', year: 'numeric' });
                                }
                            }
                        }],
                        yAxes: [{
                            display: false,
                            ticks: {
                                callback: (value, index, values) => {
                                    return value.variableDecimal();
                                }
                            }
                        }]
                    }
                };

                var chartContainer = document.getElementById('asset-chart');
                var chartContainerContext = chartContainer.getContext('2d');
                var gradient = chartContainerContext.createLinearGradient(0,0,0,chartContainer.offsetHeight);
                gradient.addColorStop(0, this.lineColor);
                gradient.addColorStop(1, 'rgba(255,255,255,0)');

                this.chart = new Chart(chartContainerContext, {
                    type: 'lineWithCursor',
                    data: {
                        labels: this.xValues,
                        datasets: [{
                            data: this.yValues,
                            borderColor: this.lineColor, // line color
                            borderWidth: 2,
                            backgroundColor: gradient,
                            radius: 0,
                            hoverRadius: 0,
                            hitRadius: 0
                        }]
                    },
                    options: chartOptions
                });
            }
        },
        created() {
            this.$watch('symbol', () => {
                this.chartData = {}; // delete all previously stored data when symbol changes
                this.getChartData(this.period, this.symbol);
            });
        },
        mounted() {
            // important to build chart on mounted event, because on created the canvas HTML element is not yet available
            this.getChartData(this.period, this.symbol);
        }
    }
</script>