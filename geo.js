var map;
var layerGroup;
var loadedTracks = [];


function showMap (){
    map = L.map('mapid').setView([47.05, 8.1], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);   
}

function LoadSingleTrack(id){

    if (typeof layerGroup !== 'undefined') {
        map.removeLayer(layerGroup);
    }

    layerGroup = L.layerGroup().addTo(map);
    
    addTrackToMap(id);
    
    map.flyTo(arr[0]);
}

function loadTrackToMap(id){
    var url = "https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Geo/Track/"+id;
    $.get(url, (t)=>{
        
        let arr = [];
        var line;
        $.each(t.geometry.coordinates, function (i, v) {
            
                arr.push(new L.LatLng(v[0], v[1]));                            
                line = new L.Polyline(arr, {
                color: "goldenrod",
                weight: 3,
                opacity: 1,
                smoothFactor: 1
            });

        });
            line.addTo(layerGroup);

            var marker = L.marker(arr[0]);
            marker.addTo(layerGroup);

            marker = L.marker(arr[arr.length - 1]);            
            marker.addTo(layerGroup);

            
    });    
}

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

function centerMapToLastPoint(trackID){
    
    $.get("https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Geo/LastPointInTrack/"+trackID,
        function (data) {
            map.flyTo(new L.LatLng(data.Lat, data.Long));
        });

    
}


