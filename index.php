<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hello</h1>
    <h2>This is my first page</h2>
    <h2>This is my first page</h2> -->
    <?php
    require "load.php";
    $ObjLayouts -> heading();
    $ObjMenus -> main_menu();
    $ObjHeading -> main_banner();
    $ObjCont -> main_content();
    $ObjCont -> side_bar();
    $ObjLayouts -> footer();
 
    ?>


    <?php
    // require_once "load.php";
    // print $Obj ->user_age("Sasha", 2004);?>
</body>
</html>