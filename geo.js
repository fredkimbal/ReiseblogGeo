var map;
var layerGroup;
var loadedTracks = [];

var colors = [];
colors.push("blue");
colors.push("darkslateblue");
colors.push("red");
colors.push("green");
colors.push("goldenrod");
colors.push("darkcyan");


function showMap (zoom){
    map = L.map('mapid').setView([47.05, 8.1], 13);
    map.setZoom(zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);   
}

/**
 * Lädt einen einzelnen Track auf die Karte. Bereits geladene Tracks werden gelöscht
 * @param {} id 
 */
function LoadSingleTrack(id){

    if (typeof layerGroup !== 'undefined') {
        map.removeLayer(layerGroup);
    }

    layerGroup = L.layerGroup().addTo(map);
    
    loadTrackToMap(id);
    
    centerMapToLastPoint(id)
}

function loadTrackToMap(id){
    var url = "https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Geo/Track/"+id;
    $.get(url, (t)=>{
        
        let arr = [];
        var line;
        $.each(t.geometry.coordinates, function (i, v) {
            
                arr.push(new L.LatLng(v[0], v[1]));                            
                
            });
            line = new L.Polyline(arr, {
                color: colors[t.properties.type],
                weight: 3,
                opacity: 1,
                smoothFactor: 1  
        });
            line.addTo(layerGroup);

            var marker = L.marker(arr[0]);
            marker.addTo(layerGroup);

            marker = L.marker(arr[arr.length - 1]);            
            marker.addTo(layerGroup);

            
    });    
}

/**
 * Fügt einen Track zur Karte. Bestehende Tracks werden nicht gelöscht
 * @param int id ID des Tracks, welcher geladen werden soll. 
 */
function AddTrackToMap(id){
    if (typeof layerGroup === 'undefined') {
        layerGroup = L.layerGroup().addTo(map);
    }
    loadTrackToMap(id);
}

function loadTracksInBound(tourPart){    
    var bounds = map.getBounds();
    $.get("https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Geo/GetTracksInRange/"+tourPart+"/" + bounds.getSouthEast().lat + "/" + bounds.getNorthWest().lat + "/" + bounds.getSouthEast().lng + "/" + bounds.getNorthWest().lng,
        function (data) {
            $.each(data, function (i, v) {  
                if(!loadedTracks.includes(v.ID)){
                    AddTrackToMap(v.ID);
                    loadedTracks.push(v.ID);
                }                      
            });
        });
}

/**
 * Zentriert die Karte auf den letzten Punkt eines Tracks
 * @param int trackID ID des Tracks
 */
function centerMapToLastPoint(trackID){
    
    $.get("https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Geo/LastPointInTrack/"+trackID,
        function (data) {
            map.flyTo(new L.LatLng(data.Lat, data.Long));
        });    
}




