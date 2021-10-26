var map;
var layerGroup;
var loadedTracks = [];

var isPicking; 


function showMap (zoom){
    map = L.map('mapid').setView([47.05, 8.1], 13);
    map.setZoom(zoom);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);   

    line = new L.Polyline({}, {
        color: "blue",
        weight: 3,
        opacity: 1,
        smoothFactor: 1  
    }).addTo(map);


    map.on("click",(m)=>{
        if(isPicking){
            var l = m.latlng; 
            $("#pointlist").append("<li data-lat='"+l.lat+"' data-lng='"+l.lng+"'>"+l.lat+"|"+l.lng+"</li>");
            line.addLatLng([l.lat, l.lng]);
        }
    });
}


function startPicking(){
    if($("#startPicking").html() === 'Start Picking'){  
        L.DomUtil.addClass(map._container,'crosshair-cursor-enabled');
        $("#startPicking").html('Stop Picking');
        isPicking = true;
    }
    else{
        L.DomUtil.removeClass(map._container,'crosshair-cursor-enabled');
        $("#startPicking").html('Start Picking');
        isPicking = false; 
    }
}


function saveTrack(){
    var url = "https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Admin/SaveTrack/";

    var trackarray = line.toGeoJSON();

    trackarray.destination = $("#destination").val();
    trackarray.tourpart = $("#tourpart").val();
    trackarray.tracktype = $("#tracktype").val();
    // var points = [];

    // $.each(trackarray, (i,c)=>{
    //     points.push({
    //         lat:c.lat,
    //         lng:c.lng
    //     });
    // });

    // let data = {
    //     destination:$("#destination").val(), 
    //     tourpart:$("#tourpart").val(), 
    //     tracktype:$("#tracktype").val(),
    //     track:points
    //   };

    $.post(url,trackarray, ()=>{
        alert(trackarray);
    }); 
}
