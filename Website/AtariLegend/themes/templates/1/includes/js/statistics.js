/*!
 * statistics.js
 */

window.initChart = function (jsData, jsLabels, jsBGColor, jsBorderWidth, jsBorder) {
    var ctxChangeLine = document.getElementById('changelog_line').getContext('2d');

    // Return is just here to make ESLint happy, as you can't just have a
    // new object without making use of it
    return new Chart(ctxChangeLine, {
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
    });
}
