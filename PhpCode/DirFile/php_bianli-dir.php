<?php

     // demo1
    function myscandir($pathname){

        foreach( glob($pathname) as $filename ){

            if(is_dir($filename)){
                myscandir($filename.'/*');
            }else{
                echo $filename.'<br/>';
            }
        }
    }
   
    myscandir('D:/wamp/www/exe1/*');




    // demo2
    function myscandir($path){

        $mydir=dir($path);

        while($file=$mydir->read()){
            $p=$path.'/'.$file;
       
            if(($file!=".") AND ($file!="..")){
            echo $p.'<br>';
            }
       
            if((is_dir($p)) AND ($file!=".") AND ($file!="..")){
                myscandir($p);
            }
        }   
    }

    myscandir(dirname(dirname(__FILE__)));
   
?>
