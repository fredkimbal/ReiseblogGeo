<?PHP


require_once 'Libs/smarty-3.1.35/libs/Smarty.class.php';

// JPGraph für Höhenprofile
require_once ('Libs/jpgraph-4.3.2/src/jpgraph.php');
require_once ('Libs/jpgraph-4.3.2/src/jpgraph_line.php');

// Data Provider 
require_once "Database/Database2.php";
require_once "DataProvider/GeoProvider.php";


// DTOs
require_once "API/Geo/GeoJsonLine.php";



// API Basisklassen
require_once 'API/API.php';
require_once 'API/SmartyAPI.php';
require_once 'API/APIFactory.php';

// API Klassen
require_once 'API/Geo/GeoAPI.php';
require_once 'API/Admin/AdminAPI.php';


error_reporting(E_ALL);
//error_reporting(E_NONE);





//header('Content-Type: application/json');
// * wont work in FF w/ Allow-Credentials
//if you dont need Allow-Credentials, * seems to work
header('Access-Control-Allow-Origin: *');
//if you need cookies or login etc
header('Access-Control-Allow-Credentials: true');



if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Max-Age: 604800');
  //if you need special headers
  header('Access-Control-Allow-Headers: x-requested-with');
  exit(0);
}
// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}
try {
    $args = explode('/', rtrim($_REQUEST['request'], '/'));    
    $endpoint = array_shift($args);
    
    $API = APIFactory::GetAPI($endpoint, $_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    if (!isset($API)) {
        echo json_encode(Array('error' => 'Unknown Endpoint'));
    }
    else {
        $data = $API->processAPI();
        echo $data;
    }
}
catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
?>