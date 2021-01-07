<?php

class GeoProvider{

    public function GetTourStageLocation($tourPart){
        $sql = "SELECT ID, 
                       DATE_FORMAT (TrackDate, '%d.%m.%Y') as TrackDate, 
                       Distance, 
                       CONCAT(DATE_FORMAT (TrackDate, '%d.%m.%Y'), ' - ' , Location) AS Caption
                FROM onTour_GPX WHERE TourPart = $tourPart";

        $db = new Database();
        return $db->query($sql);
    }

    public function GetTrackPoints($track){
        $sql = "SELECT * FROM onTour_GPXTrackPoints WHERE TrackID = $track";

        $db = new Database();
        return $db->query($sql);
    }

    public function GetTracksInRange($latMin, $latMax, $longMin, $longMax, $tourpart){
        
        $sql = "SELECT * FROM onTour_GPX 
                WHERE 
                        (LatMin > $latMin AND LatMin < $latMax 
                        OR LatMax > $latMin AND LatMax < $latMax
                        OR LatMin < $latMin AND LatMax > $latMax)
                    AND 
                        (LongMin > $longMin AND LongMin < $longMax 
                        OR LongMax > $longMin AND LongMax < $longMax
                        OR LongMin < $longMin AND LongMax > $longMax) "
                . "AND TourPart = $tourpart ";
        
        $db = new Database();
            
        
        return $db->query($sql);
    }

    public function GetTourPartName($id){
        $sql = "SELECT TourPart FROM onTour_TourParts WHERE ID = $id";

        $db = new Database();
        return $db->query($sql)[0]['TourPart'];
    }

    public function GetLastPointFromTrack($trackID){
        $sql = "SELECT * 
        FROM onTour_GPXTrackPoints 
        WHERE TrackID = $trackID AND ID = 
                (SELECT MAX(ID) 
                FROM onTour_GPXTrackPoints 
                WHERE TrackID = $trackID)";

        $db = new Database();
        return $db->query($sql)[0];   
    }

    public function GetTrackType($id){
        $sql = "SELECT TrackType FROM onTour_GPX WHERE ID = $id";
        $db = new Database();
        return $db->query($sql)[0]['TrackType'];   
    }

    public function GetTourParts(){
        $sql = "SELECT ID, TourPart FROM onTour_TourParts";

        $db = new Database();
        return $db->query($sql);      
    }


    public function InsertTrack($time, $distance, $ascent, $tourPart, $location, $trackType = 0){
        $sql = "INSERT INTO onTour_GPX (TrackDate, `Distance`, Ascent, TourPart, Location, TrackType) VALUES ('$time', '$distance', '$ascent', '$tourPart', '$location', $trackType)";
        $db = new Database();        
        $db->iquery($sql);
        return $db->GetLastID();
     }

     public function InsertTrackPoint($lat, $long, $ele, $time, $trackID){
        $sql = "INSERT INTO onTour_GPXTrackPoints (Lat, `Long`, Ele, `Time`, TrackID) VALUES ('$lat', '$long', '$ele', '$time', '$trackID')";
        $db = new Database();        
        $db->iquery($sql);
    }

    public function UpdateMaxCoords($minLat, $maxLat, $minLong, $maxLong, $trackID){
        $sql = "UPDATE onTour_GPX SET LatMin = '$minLat', LatMax = '$maxLat', LongMin = '$minLong', LongMax = '$maxLong' WHERE ID = $trackID";
        $db = new Database();
        $db->iquery($sql);
    }
    

    public function UpdateDistance( $trackID, $distance){
                $sql = "UPDATE onTour_GPX SET distance = $distance WHERE ID = $trackID";
        $db = new Database();
        $db->iquery($sql);
    }


}

?>