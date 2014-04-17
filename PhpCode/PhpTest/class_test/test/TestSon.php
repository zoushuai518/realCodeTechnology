<?php

	error_reporting(E_ALL);

	include './TestParent.php';

	/**
	* TestSon.php
	*/
	class TestSon extends TestParent
	{
		
		function __construct()
		{
			parent::testEchoParent();
		}

		public function testEcho(){

			print_r($this->val);
		}

		public function testVal(){

			// echo $this->val = 'son modify parent val value';
			echo $this->val_son = 'son modify parent val value';
		}

	}


	$test_object = new TestSon();
	echo '<br />';
	$test_object->testEcho();
	echo '<br />';
	$test_object->testVal();
	echo '<br />';

	// $test_object2 = new TestParent();

	// print_r($test_object2->val);


?>
