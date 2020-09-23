<?php

class GeoProvider{

    public function GetTourStageLocation($tourPart){
        $sql = "SELECT ID, 
                       DATE_FORMAT (TrackDate, '%d.%m.%Y') as TrackDate, 
                       Distance
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

}

?>