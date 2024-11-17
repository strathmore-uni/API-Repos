<?php

if(isset($POST['query'])){
    $res = addslashes($_POST['query']);
}else{
    $res = '';
}
print ucwords($res);