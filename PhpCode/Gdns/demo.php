<?php

	include('gDNS.php');

	$baHost = new gDNS();
    $baHost->query('bps.b5m.com','*','true','IN','10.10.109.3');
    $bangRecords = $baHost->getResponse('bps.b5m.com');
    
    echo '<pre>';
    var_dump($bangRecords);
    die;

?>