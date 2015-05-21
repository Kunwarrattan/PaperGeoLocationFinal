<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.js"></script>
    <script language="javascript" type="text/javascript" src="connectFile.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <title>Reverse Geocoding</title>
    <style>
        html, body, #map-canvas {
            height:70%;
            margin: 0px;
            padding: 0px
        }
        #panel {
            position: absolute;
            top: 5px;
            left: 50%;
            margin-left: -180px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>
        var geocoder;
        var map;
        var infowindow = new google.maps.InfoWindow();
        var marker;
        function initialize() {
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(40.730885,-73.997383);
            var mapOptions = {
                zoom: 8,
                center: latlng,
                mapTypeId: 'roadmap'
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        }



        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    <style>
        #panel {
            position: absolute;
            top: 5px;
            left: 50%;
            margin-left: -180px;
            width: 350px;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
        }
        #latlng {
            width: 225px;
        }
    </style>
</head>
<body>
<div id="panel">
    <input id="latlng" type="text" value="40.714224,-73.961452">
    <input type="button" value="Reverse Geocode" onclick="ajaxFunction()">
</div>
<div id="map-canvas"></div>
</body>
</html>