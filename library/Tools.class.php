<?php
class Tools
{
	public static  function  var_dump($var)
	{
		echo  "<p><pre>";
		var_dump($var);
		echo  "</pre></p>";
	}
	
	public static function isNullOrEmpty($str)
	{
	   if(!isset($str)){
	   	 return  true;
	   }
		if($str===null){
			return true;
		}
		$str=trim($str);
		if($str===""){
			return true;
		}
		return false;
	}
}