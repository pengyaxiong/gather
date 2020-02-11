$.get('/api/statistics_flow').done(function (data) {

    // console.log(data);
    var myChart = echarts.init(document.getElementById('statistics_flow'), 'macarons');
    myChart.setOption({

        backgroundColor: new echarts.graphic.RadialGradient(0.3, 0.3, 0.8, [{
            offset: 0,
            color: '#f7f8fa'
        }, {
            offset: 1,
            color: '#f7f8fa'
        }]),
        title: {
            text: '借款情况'
        },
        legend: {
            right: 10,
            data: []
        },
        xAxis: {
            splitLine: {
                lineStyle: {
                    type: 'dashed'
                }
            },
            type: 'time',
        },
        yAxis: {
            splitLine: {
                lineStyle: {
                    type: 'dashed'
                }
            },
            scale: true
        },
        series: [{
            data: data[0],
            type: 'scatter',
            symbolSize: function (data) {
                return 15;
            },
            markLine: {
                data: [
                    {type: 'average', name: '平均值'}
                ]
            },
            label: {
                emphasis: {
                    show: true,
                    formatter: function (param) {
                        return param.data[3];
                    },
                    position: 'top'
                }
            },
            itemStyle: {
                normal: {
                    shadowBlur: 10,
                    shadowColor: 'rgba(120, 36, 50, 0.5)',
                    shadowOffsetY: 5,
                    color: new echarts.graphic.RadialGradient(0.4, 0.3, 1, [{
                        offset: 0,
                        color: 'rgb(251, 118, 123)'
                    }, {
                        offset: 1,
                        color: 'rgb(204, 46, 72)'
                    }])
                }
            }
        }]

    });
});