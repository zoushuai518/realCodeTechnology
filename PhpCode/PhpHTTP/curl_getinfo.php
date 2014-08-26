<?php

	//curl_init('http://www.example.com/');
    //if(curl_getinfo($c, CURLINFO_HTTP_CODE) === '200') echo "CURLINFO_HTTP_CODE returns a string.";
    //if(curl_getinfo($c, CURLINFO_HTTP_CODE) === 200) echo "CURLINFO_HTTP_CODE returns an integer.";
    //curl_close($c);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://cart.b5m.com");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	var_dump(curl_getinfo($ch));
	//var_dump(curl_getinfo($ch, CURLINFO_HTTP_CODE));
	curl_close($ch);
?>
