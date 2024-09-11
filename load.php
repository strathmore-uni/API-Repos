<?php
//Class Auto Load
function classAutoLoad($classname){
$directories = ["content", "layouts", "menus"];

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





?>