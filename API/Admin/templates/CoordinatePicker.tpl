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
   <script src="https://www.luanaundandy.ch/ReiseblogGeo/CoordinatePicker.js"></script>
</head>
<body>
    <div class="w3-container w3-margin">
            
    <div id="mapid"></div>
    <div class="w3-row">
        <label class="w3-quarter">Zielort:</label>
        <input id="destination" class="w3-quarter"/>  
    </div>
    <div class="w3-row">
        <div class="w3-quarter">                
            <button  id="startPicking">Start Picking</button>
        </div>
        <div class="w3-quarter">
            <select class="w3-select" name="tourpart" id = "tourpart">
                <option value="" disabled selected>Tourpart auswählen</option>
        
                {foreach from=$tourparts item=tourpart}
                    <option value="{$tourpart['ID']}" >  {$tourpart['TourPart']}</option>
                {/foreach}}
        
            </select> 
        </div>
        <div class="w3-quarter">
            
            <select class="w3-select" name="tracktype" id="tracktype">
                <option value="0" disabled selected>Tracktype auswählen</option>
                <option value="0">Undefiniert</option>
                <option value="1">Camper</option>
                <option value="2">Flugzeug</option>
                <option value="3">Zu Fuss</option>
                <option value="4">Velo</option>
                <option value="5">Eisenbahn</option>
            </select> 
        </div> 
        <div class="w3-quarter">    
        
            <button id="saveTrack">Speichern</button>
        </div>
    </div>

    
    </div>

    <ul class="w3-ul" id="pointlist">
        
    </ul>


    <p>&nbsp;</p>

    <script>
        $( document ).ready(function() {
            showMap(15);
            $("#startPicking").click(()=>{
                startPicking();    
            });

            $("#saveTrack").click(()=>{
                saveTrack();
            });
        });




    </script>