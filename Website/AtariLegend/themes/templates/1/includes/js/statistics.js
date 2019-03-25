/*!
 * statistics.js
 */

window.initChart = function (jsData, jsLabels, jsBGColor, jsBorderWidth, jsBorder) {
    var ctxChangeLine = document.getElementById('changelog_line').getContext('2d');

    var myLineChart = new Chart(ctxChangeLine, {
        responsive: true,
        type: 'bar',
        data: {
            labels: jsLabels,
            datasets: [
                {
                    label: 'Changes per month',
                    backgroundColor: jsBGColor,
                    borderColor: jsBorder,
                    borderWidth: jsBorderWidth,
                    data: jsData
                }
            ]
        },
        options: {
            legend: {
                display: false
            }
        }
    })
}
