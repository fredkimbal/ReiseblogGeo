<?php
class GeoAPI extends SmartyAPI {

    public function Trainings(){
        $smarty = $this->createSmarty("Geo");
        $tourPart = 0;

        $provider = new GeoProvider();
        $stages = $provider->GetTourStageLocation($tourPart);
        
        $smarty->assign("stages", $stages);
        $smarty->assign("title", $provider->GetTourPartName($tourPart));

        $smarty->display("Trainings.tpl");
    }

    public function Tour($args){
        
        $tourPart = array_shift($args);

        $smarty = $this->createSmarty("Geo");
        
        $provider = new GeoProvider();
        $stages = $provider->GetTourStageLocation($tourPart);
        
        $smarty->assign("stages", $stages);   
        $smarty->assign("tourPart", $tourPart);        
        $smarty->assign("title", $provider->GetTourPartName($tourPart));

        $smarty->display("Tour.tpl");
    }

    public function Track($args){
        $id = array_shift($args);

        header('Content-Type: application/json');
        
        $provider = new GeoProvider();

        $data = $provider->GetTrackPoints($id);

        $jsonObject = new GeoJsonLine();
        
        foreach($data as $point){
            
            $jsonObject->addPoint($point['Lat'], $point['Long']);
            
        }

        return $jsonObject->GetJson();
        

    }


    public function GetTracksInRange($args) {

        header('Content-Type: application/json');
        $tourPart = array_shift($args);
        $latMin = array_shift($args);
        $latMax = array_shift($args);
        $longMin = array_shift($args);
        $longMax = array_shift($args);

        $prov = new GeoProvider();
        $data = $prov->GetTracksInRange($latMin, $latMax, $longMin, $longMax, $tourPart);
       
        return json_encode($data);
    }

    public function LastPointInTrack($args){
        header('Content-Type: application/json');
        
        $id = array_shift($args);

        $provider = new GeoProvider();
        $data = $provider->GetLastPointFromTrack($id);

        return json_encode($data);
    }
}  


    




