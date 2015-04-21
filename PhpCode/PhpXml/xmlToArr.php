<?php

    /**
     * xml转换成数组,支持多层级xml结构
     * Convert a SimpleXML object into an array (last resort).
     * @param object $xml
     * @param bool   $root    Should we append the root node into the array
     * @return array|string
     */
    function xmlToArr($xml, $root = true)
    {

        if(!$xml->children())
        {
            return (string)$xml;
        }
        $array = array();
        foreach($xml->children() as $element => $node)
        {
            $totalElement = count($xml->{$element});
            if(!isset($array[$element]))
            {
                $array[$element] = "";
            }
            // Has attributes
            if($attributes = $node->attributes())
            {
                $data = array('attributes' => array(), 'value' => (count($node) > 0) ? $this->xmlToArr($node, false) : (string)$node);
                foreach($attributes as $attr => $value)
                {
                    $data['attributes'][$attr] = (string)$value;
                }
                if($totalElement > 1)
                {
                    $array[$element][] = $data;
                }
                else
                {
                    $array[$element] = $data;
                }
                // Just a value
            }
            else
            {
                if($totalElement > 1)
                {
                    $array[$element][] = $this->xmlToArr($node, false);
                }
                else
                {
                    $array[$element] = $this->xmlToArr($node, false);
                }
            }
        }
        if($root)
        {
            return array($xml->getName() => $array);
        }
        else
        {
            return $array;
        }

    }
