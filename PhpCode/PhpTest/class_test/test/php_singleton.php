<?php


	/*
	 * PHP 单例模式 DEMO
	 * Author:shuai zou <zoushuai518@126.com>
	 * ID:php_singleton.php 2013-09-05
	 */

/**
*
* 单例模式（职责模式）：
* 简单的说，一个对象（在学习设计模式之前，需要比较了解面向对象思想）只负责一个特定的任务；
* 单例类：
* 1、构造函数需要标记为private（访问控制：防止外部代码使用new操作符创建对象），单例类不能在其他类中实例化，只能被其自身实例化；
* 2、拥有一个保存类的实例的静态成员变量
* 3、拥有一个访问这个实例的公共的静态方法（常用getInstance()方法进行实例化单例类，通过instanceof操作符可以检测到类是否已经被实例化）
* 另外，需要创建__clone()方法防止对象被复制（克隆）
* 为什么要使用PHP单例模式？
* 1、php的应用主要在于数据库应用, 所以一个应用中会存在大量的数据库操作, 使用单例模式, 则可以避免大量的new 操作消耗的资源。
* 2、如果系统中需要有一个类来全局控制某些配置信息, 那么使用单例模式可以很方便的实现. 这个可以参看ZF的FrontController部分。
* 3、在一次页面请求中, 便于进行调试, 因为所有的代码(例如数据库操作类db)都集中在一个类中, 我们可以在类中设置钩子, 输出日志，从而避免到处var_dump, echo。
*
* 设计模式之单例模式
* $_instance必须声明为静态的私有变量
* 构造函数和析构函数必须声明为私有,防止外部程序new
* 类从而失去单例模式的意义
* getInstance()方法必须设置为公有的,必须调用此方法
* 以返回实例的一个引用
* ::操作符只能访问静态变量和静态函数
* new对象都会消耗内存
* 使用场景:最常用的地方是数据库连接。 
* 使用单例模式生成一个对象后，
* 该对象可以被其它众多对象所使用。 
*/
class Example
{
	//保存例实例在此属性中
	private static $_instance;

	//构造函数声明为private,防止直接创建对象
	private function __construct()
	{
		echo 'I am Construceted';
	}

	//单例方法
	public static function singleton()
	{
		if(!isset(self::$_instance))
		{
			$c=__CLASS__;	// 返回当前类的名称
			// echo $c.'--';
			self::$_instance=new $c;
		}
		return self::$_instance;
	} 

	//阻止用户复制对象实例
	public function __clone()
	{
		trigger_error('Clone is not allow' ,E_USER_ERROR);
	}

	function test()
	{
		echo("-test");

	}
}

// 这个写法会出错，因为构造方法被声明为private
// $test = new Example;

// 下面将得到Example类的单例对象
$test = Example::singleton();
$test->test();

// 复制对象将导致一个E_USER_ERROR.
// $test_clone = clone $test;

?>
