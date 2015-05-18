<?php
/*=============================================================================
#     FileName: base64UploadImags.php
#         Desc: base64 位上传图片;简单调试之后可用; data image base64
#       Author: shuai.zou
#        Email: shuai.zou@weimob.com
#     HomePage: http://www.weimob.com
#      Version: 0.0.1
#   LastChange: 2015-05-18 18:06:25
#      History:
=============================================================================*/

function getBase64FlowData()
{
    $imageBase64Data = file_get_contents('php://input', 'r') ? file_get_contents('php://input', 'r') : $_POST['upLoadimage'];

    // zs debug
    //$imageBase64Data = 'data:image/jpeg;base64,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';
    //@file_put_contents('/tmp/nong.txt',$base64Data);
    //$imageBase64Data = str_replace('data:image/jpeg;base64,','',$imageBase64Data);

    $ext = '';
    $base64Data = '';
    if (strpos($imageBase64Data, 'data:image/jpeg;base64,') !== false) {
        // 把图片切割为 Header和数据两部分
        //$base64Data = end(explode(',', $imageBase64Data));
        $base64Data = explode(',', $imageBase64Data);
        // 读取后缀
        $extData = explode(';',$base64Data[0]);
        $extData =  explode(':',$extData[0]);
        $extData = explode('/',$extData[1]);
        $ext = $extData[1];

        $base64Data = $base64Data['1'];
    } else {
        // 把图片切割为 Header和数据两部分
        $base64Data = $imageBase64Data;
    }

    $fileContent = base64_decode($base64Data);

    uploadBuffer($fileContent, $ext);
}

function uploadBuffer($content, $ext)
{
    if (empty($ext)) {
        // 图片写成临时文件
        $temp_file = tempnam(sys_get_temp_dir(), 'buffer_');
        @file_put_contents($temp_file, $content);
        include './FileReadExt.php';
        $FileReadExt = new FileReadExt();
        $ext = $FileReadExt->getExt($temp_file);
    }

    // 文件写入指定目录
    //$uploadPath = '';
    //@file_put_contents($uploadPath, $content);

    //return $uploadPath;

}

