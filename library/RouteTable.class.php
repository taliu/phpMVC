<?php
class RouteTable{
	public static  $Routes=[];
	public static function getRouteData($url)
	{
		foreach (self::$Routes as $key=>$value) {
			if($value instanceof Route){
				$routeData=$value->getRouteData($url);
				if($routeData!=null){
					return $routeData;
				}
			}
		}
		return  null;
	}
	
	public static function register($routeName,Route $route){
		if($route instanceof Route){
		   self::$Routes[$routeName]=$route;
		}
	}
	/*
	public  static function register($routeName,$url_pattern,array $constraints=null){
		$route=new Route($url_pattern,$constraints);
		self::register($routeName, $route);
	}
	*/
}