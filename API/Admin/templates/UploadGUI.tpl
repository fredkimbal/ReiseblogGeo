<html>
<head>
    <title>Upload GPX</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.luanaundandy.ch/ReiseblogGeo/site.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
   
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 
   <script src="https://www.luanaundandy.ch/ReiseblogGeo/admin.js"></script>
</head>
<body>

<div class="w3-container w3-blue">
  <h2>Upload GPX File</h2>
</div>

<form id="uploadForm"
      class="w3-container" 
      action="https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Admin/UploadStarted" 
      method="post" 
      enctype="multipart/form-data" 
      target="upload_target" >
  
<label>GPX File</label>
<div class="w3-row">
<input class="w3-input w3-col s11" type="file" name="myfile">
<button class="w3-button w3-blue w3-col s1" type="button" >...</button>
</div>


<label>Etappenname</label>
<input class="w3-input" name="etappe" type="text">

<label>Datum (YYYY-MM-DD)</label>
<input class="w3-input" name="datum" type="text">


<select class="w3-select" name="tourpart">
<option value="" disabled selected>Tourpart auswählen</option>

{foreach from=$tourparts item=tourpart}
  <option value="  {$tourpart['ID']}" >  {$tourpart['TourPart']}</option>
{/foreach}}

</select> 

<select class="w3-select" name="tracktype">
<option value="0" disabled selected>Tracktype auswählen</option>


  <option value="0">Undefiniert</option>
  <option value="1">Camper</option>
  <option value="2">Flugzeug</option>
  <option value="3">Zu Fuss</option>
  <option value="4">Velo</option>
  <option value="5">Eisenbahn</option>



</select> 

<button type="submit" class="w3-button w3-blue">GPX hochladen</button>

</form> 

<p id="f1_upload_process">Loading...<br/><img src="https://www.luanaundandy.ch/ReiseblogGeo/loader.gif" /></p>
<p id="result"></p>

<iframe id="upload_target" 
        name="upload_target" 
        src="https://www.luanaundandy.ch/ReiseblogGeo/blank.html" 
        style="width:1000;height:500;border:0px solid #fff;">
</iframe>                 

</body>