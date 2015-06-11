<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">

    <title>Reverse Geocoding</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&sensor=true&language=en&key=AIzaSyCNWi7ox_0KV9lrVojv4SteoYESUxNdK8k"></script>
    <script type="text/javascript" src="hitlat.js"></script>

<!--    <script type="text/javascript">-->
<!---->
<!--        google.load("maps", "2",{language: "en",base_domain: 'google.en'});-->
<!---->
<!--        function OnLoad(){-->
<!--            alert("Loaded!");-->
<!--        }-->
<!---->
<!--        google.setOnLoadCallback(OnLoad);-->
<!---->
<!---->
<!--    </script>-->
</head>
<body>
<div id="panel">

    <input type="button" value="Reverse Geocode" onclick="getData()">
</div>
<div id="map-canvas"></div>
</body>
</html>