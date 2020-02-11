var user_id = $("#user_id").val();
var created_at = $("#created_at").val();
start_date = created_at.split(" ~ ")[0];
end_date = created_at.split(" ~ ")[1];
$.get('/api/supermarket_pv/' + user_id + '/' + start_date + '/' + end_date).done(function (data) {
    console.log(data);
    var supermarket = [];      //贷超
    var num = [];             //浏览量

    $.each(data, function (k, v) {
        supermarket.push(v.name);
        num.push(v.pvs_count)
    })
    var myChart = echarts.init(document.getElementById('supermarket_pv'), 'macarons');
    myChart.setOption(
        {
            title: {
                text: '贷超',
                subtext: '点击量'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['点击量']
            },
            toolbox: {
                show: true,
                feature: {
                    dataView: {show: true, readOnly: false},
                    magicType: {show: true, type: ['line', 'bar']},
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            xAxis: [
                {
                    type: 'category',
                    data: supermarket
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '点击量',
                    type: 'bar',
                    data: num,
                    markPoint: {
                        data: [
                            {type: 'max', name: '最大值'},
                            {type: 'min', name: '最小值'}
                        ]
                    },
                    markLine: {
                        data: [
                            {type: 'average', name: '平均值'}
                        ]
                    }
                }
            ]
        }
    );
});