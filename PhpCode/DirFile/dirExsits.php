<?php

function dirExsits($dir){
    if(file_exists($dir)){
        if (is_dir($dir)) {
           if ($dh = @opendir($dir)) {
                $s='';
                while (($file = readdir($dh))) {
                    if($file!='.' && $file!='..'){
                       $s.=$file;
                    }
                }
                if($s==''){
                    return true;
                }else{
                    return false;
                }
               closedir($dh);
           }
        }
    }else{
        if(mkdir($dir,0700)){
            return true;
        }else{
            echo '<script>alert(\'亲!您没有创建目录的权限\')</script>';
        }
    }
}

?>
