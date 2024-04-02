<?php 
if(isset($_GET['address']) ) {
    header('Content-type: application/json');
    echo file_get_contents('https://api.blockchain.info/haskoin-store/btc/address/'.$_GET['address'].'/balance&token=token=0c90af3735a0454b97d1353fe7dec4f2');
    die();
}
