<?php
    echo'
        <script>
        window.onload = function() {
 
        var chartUscite = new CanvasJS.Chart("chartContainerUscite", {
	        animationEnabled: true,
            backgroundColor: "#DAD7CD",
	        title: {
		        text: "Uscite Anno ';echo $anno_riferimento["AnnoRiferimento"]; echo'"
	        },
            
	        data: [{
		        type: "pie",
		        yValueFormatString: "#,##0.00\"%\"",
		        indexLabel: "{label} ({y})",
		        dataPoints: ';echo json_encode($uscite_data, JSON_NUMERIC_CHECK); echo'
	        }]
        });

        var chartEntrate = new CanvasJS.Chart("chartContainerEntrate", {
	        animationEnabled: true,
            backgroundColor: "#DAD7CD",
	        title: {
		        text: "Entrate Anno '; echo $anno_riferimento["AnnoRiferimento"] ; echo'"
	        },
            
	        data: [{
		        type: "pie",
		        yValueFormatString: "#,##0.00\"%\"",
		        indexLabel: "{label} ({y})",
		        dataPoints: '; echo json_encode($entrate_data, JSON_NUMERIC_CHECK); ; echo'
	        }]
        });
        chartUscite.render();
        chartEntrate.render();

        }
    </script>';
?>