<?php
    echo'
        <script>
        window.onload = function() {
 
        var chart = new CanvasJS.Chart("chartContainerAnniEconomici", {
	        animationEnabled: true,
            backgroundColor: "#DAD7CD",
	        title: {
		        text: "Entrate/Uscite"
	        },
            toolTip: {
                shared: true
            },
	        data: [{
		        type: "spline",
		        yValueFormatString: "$#,##0",
                showInLegend: true,
                name: "Entrate",
		        dataPoints: ';echo json_encode(array_reverse($entrate_data), JSON_NUMERIC_CHECK); echo'},
                {type: "spline",
		        yValueFormatString: "$#,##0",
                showInLegend: true,
                name: "Uscite",
		        dataPoints: ';echo json_encode(array_reverse($uscite_data), JSON_NUMERIC_CHECK); echo'
	        }]
        });

        chart.render();

        }
    </script>';
?>