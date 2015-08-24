<?php
class User{
	public  $userName;
	public  $password;
	function __construct($userName,$password){
		$this->password=$password;
		$this->userName=$userName;
	}
}