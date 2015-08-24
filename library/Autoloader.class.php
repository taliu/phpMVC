<?php
class  Autoloader
{
	public static $loader;
	
	public static function init()
	{
		if (self::$loader == NULL)
			self::$loader = new self();
	
		return self::$loader;
	}
	
	public function __construct()
    {
        spl_autoload_register(array($this,'autoload'));
    }
    
	public  function autoload($classname)
	{
		$root=$_SERVER['DOCUMENT_ROOT'];
		//class directories
		$directorys = array(
				"$root/library/", 
				"$root/models/",
				"$root/controllers/"
		);
		 
		//for each directory
		foreach($directorys as $directory)
		{
			$classPath=$directory.$classname . '.class.php';
			//see if the file exsists
			if(file_exists($classPath))
			{
				require_once($classPath);
				return;
			}
		}
	}
}
Autoloader::init();