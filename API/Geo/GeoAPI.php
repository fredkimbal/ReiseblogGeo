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
        $this->ShowTour($args, false);
    }

    public function TourVelo($args){
        $this->ShowTour($args, true);
    }

    public function ShowTour($args, $velo){

        $tourPart = array_shift($args);

        if(count($args) > 0 && is_numeric($args[0])){
            $zoom = array_shift($args);
        }
        else{
            $zoom = 10;
        }



        $smarty = $this->createSmarty("Geo");
        
        $provider = new GeoProvider();
        $stages = $provider->GetTourStageLocation($tourPart);
        
        $smarty->assign("stages", $stages);   
        $smarty->assign("tourPart", $tourPart);        
        $smarty->assign("title", $provider->GetTourPartName($tourPart));
        $smarty->assign("velo", $velo);
        $smarty->assign("zoom", $zoom);

        $smarty->display("Tour.tpl");
    }

    public function Track($args){
        $id = array_shift($args);

        header('Content-Type: application/json');
        
        $provider = new GeoProvider();

        $data = $provider->GetTrackPoints($id);

        $jsonObject = new GeoJsonLine();
        
        $jsonObject->properties->type = $provider->GetTrackType($id);
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

    public function ElevationChart($args){
        $trackID = array_shift($args);

        //header("Content-Type: text/html");    
        error_reporting(E_ALL);
        $geoProvider = new GeoProvider();
        $trackPoints = $geoProvider->GetTrackPoints($trackID);


        $coollastLat = 0;
        $coollastLong = 0;       
        $cooldistanceSum = 0;
        $d = 0;

        $elevations = [];
        $steps = [];

        $maxEle = 0;

        $distanceSteps = 1000;
        $R = 6371000; // metres
        foreach ($trackPoints as $points) {
            if ($coollastLat != 0 && $coollastLong != 0) {
                $rad1 = deg2rad($coollastLat);
                $rad2 = deg2rad($points['Lat']);
                $rad3 = deg2rad(abs($coollastLat - $points['Lat']));
                $deltaLon = deg2rad(abs($points['Long'] - $coollastLong));

                $a = sin($deltaLon / 2) * sin($deltaLon / 2) +
                        cos($rad1) * cos($rad2) *
                        sin($rad3 / 2) * sin($rad3 / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                $d = $R * $c;

                if ($maxEle < $points['Ele']) {
                    $maxEle = $points['Ele'];
                }

                if ($d + $cooldistanceSum > max($steps) + $distanceSteps) {
                    array_push($elevations, $maxEle);
                    array_push($steps, max($steps) + $distanceSteps);
                    $maxEle = 0;
                }
            } else {
                $maxEle = $points['Ele'];
                array_push($elevations, $points['Ele']);
                array_push($steps, 0);
            }

            $coollastLat = $points['Lat'];
            $coollastLong = $points['Long'];
            //echo "Distanz: $d. Höhe " . $points['Ele'] . "<br/>";
            $cooldistanceSum = $cooldistanceSum + $d;
        }
        array_push($elevations, $points['Ele']);
        array_push($steps, max($steps) + $distanceSteps);

        //echo $cooldistanceSum;

        $scaleSteps = [];
        for ($i = 0; $i < count($steps); $i++) {
            if ($i % 10 == 0) {
                array_push($scaleSteps, $steps[$i] / 1000);
            } else {
                array_push($scaleSteps, 0.123456789);
            }
        }
        /* CAT:Line chart */

        // Size of the overall graph
        $width=500;
        $height=250;
 
        // Create the graph and set a scale.
        // These two calls are always required
        $graph = new Graph($width,$height);
        $graph->SetScale('intlin');
        
        // Create the linear plot
        $lineplot=new LinePlot($elevations);
        
        // Add the plot to the graph
        $graph->Add($lineplot);
        
        // Setup margin and titles
        $graph->SetMargin(40,20,20,40);
        $graph->xaxis->title->Set('Distanz (km)');
        $graph->xaxis->SetLabelAlign('center','center');

        $graph->yaxis->title->Set('Meter über Meer');
        $graph->yaxis->SetLabelMargin(0); 

        // Display the graph
        $graph->Stroke();   

    }
}


    




