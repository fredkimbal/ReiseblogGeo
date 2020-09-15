<?php
class GeoAPI extends SmartyAPI {

    public function Test(){
        header('Content-Type: application/json');        
        return json_encode("Hello World");
    }


    public function Show($args){
        
        $smarty = $this->createSmarty("Geo");

        $smarty->display("Test.tpl");
    }

    public function Trainings(){
        $smarty = $this->createSmarty("Geo");

        $smarty->display("Trainings.tpl");
    }



}