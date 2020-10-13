<?php 

error_reporting(0);
set_time_limit(0);

/* define database credentials*/
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','sudhanshu');

/* Connection to Database*/
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if(!$connection){
    die('Can not connect to server.');
}

/* sanitise input from user to avoid geting hacked */

function sanitise($string){
    $string = mysqli_real_escape_string($GLOBALS['connection'],$string);
    $string = htmlentities($string);
    return $string;
}



?>
