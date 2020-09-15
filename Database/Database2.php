<?php
/**
 * Klasse für den Zugriff auf eine MySQL Datenbank
 *
 * @author Andy
 */
class Database {

    var $database_name;
    var $database_user;
    var $database_pass;
    var $database_host;
    var $database_link;

    function Database() {
        include("Database/DatabaseSpecs.php");
        $this->database_user = $specDatabase_user;
        $this->database_pass = $specDatabase_pass;
        $this->database_host = $specatabase_host;
        $this->database_name = $specatabase_name;
    }

    function changeUser($user) {
        $this->database_user = $user;
    }

    function changePass($pass) {
        $this->database_pass = $pass;
    }

    function changeHost($host) {
        $this->database_host = $host;
    }

    function changeName($name) {
        $this->database_name = $name;
    }

    function changeAll($user, $pass, $host, $name) {
        $this->database_user = $user;
        $this->database_pass = $pass;
        $this->database_host = $host;
        $this->database_name = $name;
    }

    function connect() {
        $this->database_link = mysqli_connect($this->database_host, $this->database_user, $this->database_pass);
        mysqli_select_db($this->database_link, $this->database_name) or die("Could not open database: " . $this->database_name);        
        mysqli_query($this->database_link, "set names 'utf8';");        
    }

    function disconnect() {
        if (isset($this->database_link)) {
            mysqli_close($this->database_link);
        } 
    }

    /**
     * Führt eine DB Operation ohne Rückgabewert durch
     * @param type $qry 
     */
    function iquery($qry) {
        if (!isset($this->database_link))
            $this->connect();
        $temp = mysqli_query($this->database_link, $qry) or die("Error: " . mysqli_error($this->database_link));
    }

    /**
     * Führt eine DB Opertion mit Rückgabewert durch
     * @param type $qry
     * @return type 
     */
    function query($qry) {
        if (!isset($this->database_link))
            $this->connect();
        $result = mysqli_query($this->database_link, $qry) or die("Error: " . mysqli_error($this->database_link));
        $returnArray = array();
        $i = 0;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            if ($row)
                $returnArray[$i++] = $row;
        mysqli_free_result($result);
        return $returnArray;
    }

    
    public function GetLastID(){
       return $this->database_link->insert_id;
    }


    public function GetInsertFieldsAndValues($data){
        $result = array();
        
        $fields = "";
        $values = "";

        foreach ($data as $key => $value){
            if($key != "ID"){
                $fields .=  $fields == "" ? $key : ", $key";
                if($key == "ValidFrom"){                    
                    $values .= $values == "" ? "NOW()" : ", NOW()";
                }
                else if($key == "ValidTo"){                    
                    $values .= $values == "" ? '9999-12-31' : ", '9999-12-31'";
                }
                else{
                    $values .= $values == "" ? $value : ", '$value'";
                }
            }
        }
        

        $result["fields"] = $fields;
        $result["values"] = $values;

        return $result;
    }
}

?>
