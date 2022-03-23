      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time',  'PM10', 'Norma'],
          ['00:00',      15,      50],
          ['01:00',      14,      50],
          ['02:00',      12,      50],
          ['03:00',      18,      50],
          ['04:00',      19,      50],
          ['05:00',      12,      50],
          ['06:00',      17,      50],
          ['07:00',      28,      50],
          ['08:00',     23,       50],
          ['09:00',      23,      50],
          ['10:00',      27,      50],
          ['11:00',      22,      50],
          ['12:00',       21,     50],
          ['13:00',        26,    50],
          ['14:00',        30,    50],
          ['15:00',       50,     50],
          ['16:00',      41,      50],
          ['17:00',      32,      50],
          ['18:00',      33,      50],
          ['19:00',      31,      50],
          ['20:00',      29,      50],
          ['21:00',      20,      50],
          ['22:00',      19,      50],
          ['23:00',      16,      50],
          ['24:00',      11,      50]
        ]);

        var options = {
          title : 'Wartość PM10',
          vAxis: {title: 'PM10'},
          hAxis: {title: 'Godzina',
           showTextEvery:2 },
          seriesType: 'bars',
          series: {1: {type: 'line'}}        };

        var chart = new google.visualization.ComboChart(document.getElementById('PM10'));
        chart.draw(data, options);
      }