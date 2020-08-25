// Imports
import Chart from 'chart.js';
import $ from 'jquery';
import moment from 'moment';

$(document).ready(function() {
    // Dynamic endpoint
    var url = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/' + 'api' + window.location.pathname;

    getViews(url);

}); // <--- End Ready

function getViews(url) {
    fetch(url)
        .then( res => {
            return res.json();
        })
        .then( data => {
            var totalViews = data.response.views.length;
            var views = setViews(data);
            printGraph(views, totalViews);
        })
}

function setViews(data) {
    var months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    var viewsArray = data.response.views;

    viewsArray.forEach( function(e) {
        
        var m = moment(e.created_at).format('M');

        if (m == 1) {
            months[0] += 1;
        } else if (m == 2) {
            months[1] += 1;
        } else if (m == 3) {
            months[2] += 1;
        } else if (m == 4) {
            months[3] += 1;
        } else if (m == 5) {
            months[4] += 1;
        } else if (m == 6) {
            months[5] += 1;
        } else if (m == 7) {
            months[6] += 1;
        } else if (m == 8) {
            months[7] += 1;
        } else if (m == 9) {
            months[8] += 1;
        } else if (m == 10) {
            months[9] += 1;
        } else if (m == 11) {
            months[10] += 1;
        } else if (m == 12) {
            months[11] += 1;
        }
    })

    return months;
}

function printGraph(views, totalViews) {
    // Setup chart.js
    var ctx = $('#viewsPerMonth');
    var currentMonth = moment().format('M') - 1;
    var yOffset = Math.max(...views) * 1.1;
        
    // Instancing new Chart
    var viewsPerMonth = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Novembre', 'Dicembre'],
            datasets: [
                {
                    data: [views[0], views[1], views[2], views[3], views[4], views[5], views[6], views[7], views[8], views[9], views[10], views[11]],
                    label: 'Visite/mese',
                    borderColor: '#f4af32',
                    backgroundColor: 'rgba(0, 0, 0, .03)',
                    lineTension: 0
                }
            ]
        },
        options: {
            showLines: true,
            scales: {
                yAxes: [{
                    ticks: {
                        max: yOffset
                    }
                }]
            }
        }
    });

    var pie = $('#pieChart');

    var pieChart = new Chart(pie, {
        type: 'doughnut',
        data: {
            labels: ['Visite mese corrente', 'Visite totali'],
            datasets: [
                {
                    data: [views[currentMonth], totalViews],
                    label: 'Visite',
                    backgroundColor: ["#f4af32", "#87abcb"],
                }
            ]
        }
    });

    $('#total-views span').append(totalViews);
}