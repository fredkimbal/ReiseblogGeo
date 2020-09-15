<?php



/**
 * Factory Klasse, welche die API anhand des Request Types zurückgibt.
 *
 * @author Andy
 */
class APIFactory {
    public static function GetAPI($endpoint, $request, $origin){ 
        if($endpoint === "Geo"){
            return new GeoAPI($request, $origin);
        }           
        return null;
    }
}
