<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
   @include('backend.partials.head')
</head>
<body>
@include('backend.partials.header')



@yield('content')

@stack('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">

    var bars = document.querySelectorAll('.meter > span');
    console.clear();

    setInterval(function(){
        bars.forEach(function(bar){
            var getWidth = parseFloat(bar.dataset.progress);

            for(var i = 0; i < getWidth; i++) {
                bar.style.width = i + '%';
            }
        });
    }, 300);



    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawCharts);

    function drawCharts() {

        // actual bar chart data
        var barData = google.visualization.arrayToDataTable([
            ['Day', 'Page Views', 'Unique Views'],
            ['Sun',  1050,      600],
            ['Mon',  1370,      910],
            ['Tue',  660,       400],
            ['Wed',  1030,      540],
            ['Thu',  1000,      480],
            ['Fri',  1170,      960],
            ['Sat',  660,       320]
        ]);
        // set bar chart options
        var barOptions = {
            focusTarget: 'category',
            backgroundColor: 'transparent',
            colors: ['#FF5454', '#89CE86'],
            fontName: 'Open Sans',
            chartArea: {
                left: 0,
                top: 0,
                width: '100%',
                height: '100%'
            },
            bar: {
                groupWidth: '100%',
                gap: '10',
            },
            hAxis: {
                textStyle: {
                    fontSize: 11
                }
            },
            vAxis: {
                minValue: 0,
                maxValue: 1500,
                baselineColor: 'transparent',
                gridlines: {
                    color: 'transparent',
                    count: 4
                },
                textStyle: {
                    fontSize: 11
                }
            },
            legend: {
                position: 'bottom',
                textStyle: {
                    fontSize: 12
                }
            },
            animation: {
                duration: 1200,
                easing: 'out',
                startup: true
            }
        };
        // draw bar chart twice so it animates
        var barChart = new google.visualization.ColumnChart(document.getElementById('bar-chart'));
        //barChart.draw(barZeroData, barOptions);
        barChart.draw(barData, barOptions);

        // BEGIN LINE GRAPH

        function randomNumber(base, step) {
            return Math.floor((Math.random()*step)+base);
        }
        function createData(year, start1, start2, step, offset) {
            var ar = [];
            for (var i = 0; i < 12; i++) {
                ar.push([new Date(year, i), randomNumber(start1, step)+offset, randomNumber(start2, step)+offset]);
            }
            return ar;
        }
        var randomLineData = [
            ['Year', 'Page Views', 'Unique Views']
        ];
        for (var x = 0; x < 7; x++) {
            var newYear = createData(2007+x, 10000, 5000, 4000, 800*Math.pow(x,2));
            for (var n = 0; n < 12; n++) {
                randomLineData.push(newYear.shift());
            }
        }
        var lineData = google.visualization.arrayToDataTable(randomLineData);

        var lineOptions = {
            backgroundColor: 'transparent',
            colors: ['cornflowerblue', 'tomato'],
            fontName: 'Open Sans',
            focusTarget: 'category',
            chartArea: {
                left: 50,
                top: 10,
                width: '100%',
                height: '80%'
            },
            hAxis: {
                //showTextEvery: 12,
                textStyle: {
                    fontSize: 11
                },
                baselineColor: 'transparent',
                gridlines: {
                    color: 'transparent'
                }
            },
            vAxis: {
                minValue: 0,
                maxValue: 50000,
                baselineColor: '#DDD',
                gridlines: {
                    color: '#DDD',
                    count: 5
                },
                textStyle: {
                    fontSize: 11
                }
            },
            legend: {
                position: 'bottom',
                textStyle: {
                    fontSize: 1
                }
            },
            animation: {
                duration: 1200,
                easing: 'out',
                startup: true
            }
        };

        var lineChart = new google.visualization.LineChart(document.getElementById('line-chart'));
        //lineChart.draw(zeroLineData, lineOptions);
        lineChart.draw(lineData, lineOptions);

        // BEGIN PIE CHART

        // pie chart data
        var pieData = google.visualization.arrayToDataTable([
            ['Country', 'Page Hits'],
            ['Booked',      430],
            ['Completed',   891],
            ['Empty',   1000],
        ]);
        // pie chart options
        var pieOptions = {
            backgroundColor: 'transparent',
            pieHole: 0.7,
            colors: [ "#FF5454",
                "#102BFE",
                "#B7D2EA",
                "tomato",
                "crimson",
                "purple",
                "turquoise",
                "forestgreen",
                "navy",
                "gray"],
            pieSliceText: 'none',
            tooltip: {
                text: 'percentage'
            },
            fontName: 'Poppins',
            chartArea: {
                width: '100%',
                height: '100%',
            },
            legend: {
                textStyle: {
                    fontSize: 14
                }
            }
        };
        // draw pie chart
        var pieChart = new google.visualization.PieChart(document.getElementById('pie-chart'));
        pieChart.draw(pieData, pieOptions);
    }

</script>

</body>
</html>
