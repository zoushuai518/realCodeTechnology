<?php
/**
 * 文件真实扩展名工具类.
 */
namespace common;

class FileReadExt
{
    /**
     * 常用扩展名配置
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string $response
     */
    private $exts = array(
        '7790' => 'exe',
        '7784' => 'midi',
        '8075' => 'zip',
        '8297' => 'rar',
        '225216' => 'jpeg',
        '255216'=>'jpg',
        '7173' => 'gif',
        '6677' => 'bmp',
        '13780' => 'png',
    );

    /**
     *  获取真实扩展名
     * @param string $filepath 文件路径
     */
    public function getExt($filepath)
    {
        //打文件
        $fp= fopen($filepath, "rb");
        $bin = fread($fp, 2); //只读2字节
        fclose($fp);
        $str_info  = @unpack("C2chars", $bin);
        $type_code = intval($str_info['chars1'].$str_info['chars2']);
        $ext = isset($this->exts[$type_code]) ? $this->exts[$type_code] : 'jpg';
        if (empty($ext)) {
            $ext = 'rar';
        }

        return $ext;
    }


}
