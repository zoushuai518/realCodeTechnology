<?PHP

class CdnSwitcher{
    public static function image($imagePath){
        if(!empty($imagePath)){
            //get the domain name
            $imagePath = trim($imagePath);



            preg_match("/^(http:\/\/)?([^\/]+)/i", $imagePath, $matches);
            if($matches !== null && count($matches) > 2){
                $host = $matches[2];

                $_host = strtolower($host);

                $cdns = self::cdnMap($_host);
                print_r($cdns);
                if(!empty($cdns)){
                    $n = self::getPathNumber($imagePath);
                    $i = $n % count($cdns);
                    $newHost = $cdns[$i];
                    $imagePath = str_replace($host,$newHost,$imagePath);
                }
            }
            return $imagePath;
        }
    }

    private static function getPathNumber($imagePath){
        $code = md5($imagePath);
        $code = substr($code,0,-4);

        return self::caculateCode($code);
    }

    private static function caculateCode($code){
        $n = 0;
        $l = strlen($code);
        for($i=0;$i < $l;$i++){
            $n += ord($code[$i]);
        }

        return $n;
    }


    private static function cdnMap($host){
        $maps = array(
            'img.b5m.com'=>array(
                'tfs01.b5mcdn.com',
                'tfs02.b5mcdn.com',
                'tfs03.b5mcdn.com',
                'tfs04.b5mcdn.com',
            )
        );

        if(isset($maps[$host])){
            return $maps[$host];
        }

    }
}

echo CdnSwitcher::image("http://img.b5m.com/abcd.jpg");

