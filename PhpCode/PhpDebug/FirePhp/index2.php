<?php
require_once('./FirePHPCore/lib/fb.php');

FB::log('Hello World !'); // 常规记录

FB::group('Test Group A'); // 记录分组
// 以下为按照不同类别或者类型进行信息记录
FB::log('Plain Message');
FB::info('Info Message');
FB::warn('Warn Message');
FB::error('Error Message');

FB::log('Message','Optional Label');
FB::groupEnd();

FB::group('Test Group B');
FB::log('Hello World B');
FB::log('Plain Message');
FB::info('Info Message');
FB::warn('Warn Message');
FB::error('Error Message');

FB::log('Message','Optional Label');
FB::groupEnd();

// 将信息作为table输出
$table[] = array('Col 1 Heading','Col 2 Heading','Col 2 Heading');
$table[] = array('Row 1 Col 1','Row 1 Col 2','Row 1 Col 2');
$table[] = array('Row 2 Col 1','Row 2 Col 2');
$table[] = array('Row 3 Col 1','Row 3 Col 2');

FB::table('Table Label', $table);

// 在异常处理中使用FirePHP
class MyException extends Exception{
    public function  __construct($message, $code) {
        parent::__construct($message, $code);
    }
    public function log(){
        FB::log($this->getMessage());
    }
}

try{
    echo 'MoXie';
    throw new MyException('some description',1);
}catch(MyException $e){
    $e->log();
}

?>