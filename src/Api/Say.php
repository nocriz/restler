<?php namespace Api;
class Say {
	function hello($to='world') {
		return "Hello $to!";
	}
}