<?php
//Class Auto Load
function classAutoLoad($classname){
$directories = ["content", "layouts", "menus", "forms","processes", "global"];

foreach($directories AS $dir){
    $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $classname . ".php";
    if(file_exists($filename) AND is_readable($filename)){
        require_once $filename;
    }

}
}

spl_autoload_register('classAutoLoad');

//Create instance of all classes
$ObjLayouts = new layout();
$ObjMenus = new menus();
$ObjHeading = new headings();
$ObjCont = new contents();
$ObjForm = new user_forms();



require "includes/constants.php";
require "includes/dbConnection.php";

$conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

// Create process instances

$ObjAuth = new auth();
$ObjAuth->signup($conn);



?>
<!-- print date("1");
if(date("1")== "Friday"){
    print "Yes";
}else{
    print "No";
}

print "<br>";
switch (date("1")){
    case 'Friday': print "Yes";
    break;
    case 'Monday': print "No";
    break;
} -->