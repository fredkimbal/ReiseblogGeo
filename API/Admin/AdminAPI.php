<?php


class AdminAPI extends SmartyAPI {
    
    const EARTHRADIUS=     6371000;


    public function UploadGpx(){

        $smarty = $this->createSmarty("Admin");

        $geoProvider = new GeoProvider();
        $smarty->assign("tourparts", $geoProvider->GetTourParts());

        
        $smarty->display("UploadGUI.tpl");
    }



    public function UploadStarted(){
        $destination_path = getcwd().DIRECTORY_SEPARATOR . "GpxTemp" . DIRECTORY_SEPARATOR;
        
        $result = 0;
        $target_path = $destination_path . basename( $_FILES['myfile']['name']);
        
 
        if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
            $result = 1;
        }

        $reader = new XMLReader();
        
        $reader->open($target_path);
           
        $gpxProvider = new GeoProvider();
        $trackID = 0;
        $trackDate = 0;
        $maxLat = '';
        $maxLong = '';
        $minLat = '';
        $minLong = '';
        $tourPart = filter_input(INPUT_POST, 'tourpart');
        $location = filter_input(INPUT_POST, 'etappe');
        $distance = 0;
        $ascent = 0;
        $trackDate = filter_input(INPUT_POST, 'datum');
        $time = time();
        $tracktype = filter_input(INPUT_POST, 'tracktype');
        
        $longfrom = 0;
        $latfrom = 0;
        
        
        while ($reader->read()) {               
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'time' && $trackDate == 0) {
                $trackDate = $reader->readInnerXML();                    
            }
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'gpxtrkx:Distance') {
                $distance = $reader->readInnerXML();                                        
            }
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'gpxtrkx:Ascent') {
                $ascent = $reader->readInnerXML();                                        
            }
            
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'trkpt') {
                if($trackID === 0){
                    $trackID = $gpxProvider->InsertTrack($trackDate, $distance, $ascent, $tourPart, $location, $tracktype);
                }                    
                
                $lat = $reader->getAttribute("lat");
                $long = $reader->getAttribute("lon");  
                
                if($lat < $minLat || $minLat === ''){
                    $minLat = $lat;
                }
                if($lat > $maxLat){
                    $maxLat = $lat;
                }
                if($long < $minLong || $minLong === ''){
                    $minLong = $long;
                }
                if($long > $maxLong){
                    $maxLong = $long;
                }
                
                while ($reader->read()) {                        
                    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'ele') {                        
                        $ele = $reader->readInnerXML();
                        break;
                    }
                    
                }     
                
                if($longfrom != 0){
                    $distance += AdminAPI::vincentyGreatCircleDistance($latfrom, $longfrom, $lat, $long);
                    
                    
                }
                    $longfrom = $long;
                    $latfrom = $lat;
                
                $gpxProvider->InsertTrackPoint(
                        $lat, 
                        $long,
                        $ele,
                        $time,
                        $trackID);
                $gpxProvider->UpdateMaxCoords($minLat, $maxLat, $minLong, $maxLong, $trackID);

            }
        }

        $gpxProvider->UpdateDistance($trackID, $distance);


echo $distance;
        
 
        // sleep(1);
echo "
        <script language='javascript' type='text/javascript'>
        window.top.window.stopUpload(". $result. ");
     </script>   ";

    }


    /**
 * Calculates the great-circle distance between two points, with
 * the Vincenty formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
public static function vincentyGreatCircleDistance(
    $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
  {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);
  
    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
      pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
  
    $angle = atan2(sqrt($a), $b);
    return $angle * AdminAPI::EARTHRADIUS;
  }
}

?>