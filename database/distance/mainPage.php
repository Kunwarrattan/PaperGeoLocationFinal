<!DOCTYPE html>
<html>
<head>
    <title>Distance Matrix service</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script src="distance.js" type="text/javascript"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #content-pane {
            float:left;
            width:48%;
            padding-left: 2%;
        }
        #outputDiv {
            font-size: 11px;
        }
    </style>
    <script>


    </script>
</head>
<body>
<div id="content-pane">
    <div id="inputs">
        <p><button type="button" onclick="calculateDistances();">Calculate distances</button></p>
    </div>
    <div id="outputDiv"></div>
</div>
<div id="map-canvas"></div>
</body>
</html>