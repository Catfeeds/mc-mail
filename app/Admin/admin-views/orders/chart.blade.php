@extends('admin::layouts.main')

@section('content')

    <div>
        <div class="box box-default" id="general_trend" style="width: 100%;height:400px;">

        </div>
    </div>
<div class="col-md-6">
    <div class="box box-default" id="seven_trend">

    </div>
</div>

@endsection
@section('script')
<script>
    var chart_1 = null;
    Highcharts.setOptions({
        lang:{
            contextButtonTitle:"图表导出菜单",
            decimalPoint:".",
            downloadJPEG:"下载JPEG图片",
            downloadPDF:"下载PDF文件",
            downloadPNG:"下载PNG文件",
            downloadSVG:"下载SVG文件",
            drillUpText:"返回 {series.name}",
            loading:"加载中",
            months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
            noData:"没有数据",
            numericSymbols: [ "千" , "兆" , "G" , "T" , "P" , "E"],
            printChart:"打印图表",
            resetZoom:"恢复缩放",
            resetZoomTitle:"恢复图表",
            shortMonths: [ "Jan" , "Feb" , "Mar" , "Apr" , "May" , "Jun" , "Jul" , "Aug" , "Sep" , "Oct" , "Nov" , "Dec"],
            thousandsSep:",",
            weekdays: ["星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期天"]
        },
        global: {
            useUTC: false
        }
    });

    $.getJSON("/admin/general_trend", function (data) {
        chart_1 = Highcharts.chart('general_trend', {
            chart: {
                zoomType: 'x'
            },
            title: {
                text: '总交易量走势图'
            },
            subtitle: {
                text: '鼠标拖动可以进行缩放'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    millisecond: '%H:%M:%S.%L',
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%Y-%m',
                    year: '%Y'
                }
            },
            tooltip: {
                dateTimeLabelFormats: {
                    millisecond: '%H:%M:%S.%L',
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%Y-%m-%d',
                    week: '%m-%d',
                    month: '%Y-%m',
                    year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '交易量(笔)'
                },
                min:0
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    line: {
                        dataLabels: {
                            // 开启数据标签
                            enabled: true
                        },
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                },

            },
            series: [{
                type: 'area',
                name: '当日成交笔数',
                data: data
            }],

        });
    });

    var chart_2 = null;
    // 获取 CSV 数据并初始化图表
    $.getJSON('https://data.jianshukeji.com/jsonp?filename=csv/analytics.csv&callback=?', function (csv) {
        chart_2  = Highcharts.chart('seven_trend', {
            data: {
                csv: csv
            },
            title: {
                text: '某网站日常访问量'
            },
            subtitle: {
                text: '数据来源: Google Analytics'
            },
            xAxis: {
                tickInterval: 7 * 24 * 3600 * 1000, // 坐标轴刻度间隔为一星期
                tickWidth: 0,
                gridLineWidth: 1,
                labels: {
                    align: 'left',
                    x: 3,
                    y: -3
                },
                // 时间格式化字符
                // 默认会根据当前的刻度间隔取对应的值，即当刻度间隔为一周时，取 week 值
                dateTimeLabelFormats: {
                    week: '%Y-%m-%d'
                }
            },
            yAxis: [{ // 第一个 Y 轴，放置在左边（默认在坐标）
                title: {
                    text: null
                },
                labels: {
                    align: 'left',
                    x: 3,
                    y: 16,
                    format: '{value:.,0f}'
                },
                showFirstLabel: false
            }, {    // 第二个坐标轴，放置在右边
                linkedTo: 0,
                gridLineWidth: 0,
                opposite: true,  // 通过此参数设置坐标轴显示在对立面
                title: {
                    text: null
                },
                labels: {
                    align: 'right',
                    x: -3,
                    y: 16,
                    format: '{value:.,0f}'
                },
                showFirstLabel: false
            }],
            legend: {
                align: 'left',
                verticalAlign: 'top',
                y: 20,
                floating: true,
                borderWidth: 0
            },
            tooltip: {
                shared: true,
                crosshairs: true,
                // 时间格式化字符
                // 默认会根据当前的数据点间隔取对应的值
                // 当前图表中数据点间隔为 1天，所以配置 day 值即可
                dateTimeLabelFormats: {
                    day: '%Y-%m-%d'
                }
            },
            plotOptions: {
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            // 数据点点击事件
                            // 其中 e 变量为事件对象，this 为当前数据点对象
                            click: function (e) {
                                $('.message').html( Highcharts.dateFormat('%Y-%m-%d', this.x) + ':<br/>  访问量：' +this.y );
                            }
                        }
                    },
                    marker: {
                        lineWidth: 1
                    }
                }
            }
        });
    });

</script>
@endsection