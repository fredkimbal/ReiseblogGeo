<?php

class GeoJsonLine{

    
    public $type = "Feature";
    public $properties;
    public $geometry;

    public function __construct(){
        $this->properties = new GeoJsonProperties();
        $this->geometry = new GeoJsonLineGeometry();
    }



    public function addPoint($x, $y){
        array_push($this->geometry->coordinates, [$x, $y]);
    }

    public function GetJson(){
        return json_encode($this);
    }
}

class GeoJsonProperties{
    public $name = "";
}

class GeoJsonLineGeometry{
    public $type = "LineString";
    public $coordinates = array();

}



?>