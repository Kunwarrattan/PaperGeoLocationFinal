<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Reverse Geocoding</title>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script type="text/javascript" src="hitlat.js"></script>
</head>
<body>
<div id="panel">
    <input id="latlng" type="text" value="40.714224,-73.961452">
    <input type="button" value="Reverse Geocode" onclick="codeLatLng()">
</div>
<div id="map-canvas"></div>
</body>
</html>