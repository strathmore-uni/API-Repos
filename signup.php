<?php
require "load.php";
$ObjLayouts->heading();
$ObjMenus->main_menu();
$ObjHeading->main_banner();
$ObjForm->sign_up_form($ObjGlob);
$ObjCont->side_bar();
$ObjLayouts->footer();