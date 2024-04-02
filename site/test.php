<?php
$c=json_decode(file_get_contents('crypto.json'));
$c=$c->data->genericSearchAssets->edges;

foreach($c as $k => $node ){
    foreach( $node as $k2 => $v ){
        print_r($v->symbol.':'.$v->latestQuote->price.'<br/>');
    }
   
}