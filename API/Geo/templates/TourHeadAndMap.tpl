<html>
<head>
    <title>{$title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.luanaundandy.ch/ReiseblogGeo/site.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <script src="https://www.luanaundandy.ch/ReiseblogGeo/geo.js"></script>
</head>
<body>
    <div class="w3-container w3-margin">
            
    <div id="mapid"></div>

    <div class="w3-row w3-small">
    <div class="l2 w3-col m2 s6"><span class="w3-blue">&nbsp;&nbsp;&nbsp;</span> Undefiniert</div>
    <div class="l2 w3-col m2 s6"><span style="background-color: darkslateblue">&nbsp;&nbsp;&nbsp;</span> Camper</div>
    <div class="l2 w3-col m2 s6"><span style="background-color: red">&nbsp;&nbsp;&nbsp;</span> Flugzeug</div>
    <div class="l2 w3-col m2 s6"><span style="background-color: green">&nbsp;&nbsp;&nbsp;</span> zu Fuss</div>
    <div class="l2 w3-col m2 s6"><span style="background-color: goldenrod">&nbsp;&nbsp;&nbsp;</span> Fahrrad</div>
    <div class="l2 w3-col m2 s6"><span style="background-color: darkcyan">&nbsp;&nbsp;&nbsp;</span> Eisenbahn</div>
</div>

<p>&nbsp;</p>