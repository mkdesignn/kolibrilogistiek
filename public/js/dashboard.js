const year = new Date();
const START_DATE = year.getFullYear()+"-01-01";
const END_DATE = year.getFullYear() + "-"+ ('0' + year.getMonth()).slice(-2) + "-" + year.getDate();

$('input[name="dates"]').daterangepicker(
    {
        startDate: START_DATE,
        endDate: END_DATE,
        locale: {
            format: 'YYYY-MM-DD'
        }
    },
    function(start, end) {
        refreshChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
    }
);

function refreshChart(startDate, endDate){

    axios.get(window.location.origin + "/orders/shipped?start_date="+startDate+"&end_date="+endDate).then(function(response){

        let labels = [],
            dataSet = [];
        response.data.forEach(function(obj){
            labels.push(obj.shipped_at);
            dataSet.push(obj.count);
        })

        new Chart(document.getElementById("myChart"), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: dataSet,
                        label: "Shipped products",
                        borderColor: "#3e95cd",
                        fill: false
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Products which has been shipped'
                },
                scales: {
                    xAxes: [{
                        type: 'time'
                    }]
                }
            }
        });
    });


}

refreshChart(START_DATE, END_DATE);

