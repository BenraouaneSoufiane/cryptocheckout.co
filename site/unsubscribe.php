<?php
$previous=json_decode(file_get_contents('ulist.json'), true);
if(empty($previous)) {
    $empty=array();
}
$previous[]=$_GET['address'];
$f=fopen('ulist.json', 'w');
fwrite($f, json_encode($previous));
fclose($f);
echo $_GET['address'].' successfully unsubscribed, thank you!';