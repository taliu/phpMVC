<?php
class  PageEngine
{

  public static  function invoke($controllerName,$actionName, array $routeData)
  {
  	if (!class_exists($controllerName)) {
		 return self::Error404();
  	} 
  	//获取类反射对象
  	$class = new ReflectionClass($controllerName);
  	if(!$class->hasMethod($actionName)){
  		return self::Error404();
  	} 
  	//获取方法反射对象
  	$method=$class->getMethod($actionName);
  	if (!($method->isPublic()&&!$method->isConstructor())) {
  		 return self::Error404();
  	}
  	//获取方法的参数集合
  	$parameters =$method->getParameters();
  	//从$_REQUEST获取对于参数的值
  	$argsValues=array_map(function($param) use ($routeData){
  		$paramName=$param->name;
  		if(array_key_exists($paramName,$routeData)){
  			return  $routeData[$paramName];
  		}
  		if(array_key_exists($paramName,$_REQUEST)){
  			return  $_REQUEST[$paramName];
  		}else {
  			if ($param->isOptional()) {
  				return  $param->getDefaultValue();
  			}
  			return null;
  		}
  	},$parameters);
  		
  	//创建类对象
  	$controller=new $controllerName();
  	$controller->routeData=$routeData;
  	//反射调用方法
  	$method->invokeArgs($controller, $argsValues);
  	 
  }
  
  public static function  render()
  {
  	$routeData=RouteTable::getRouteData($_SERVER["REDIRECT_URL"]);
  	if(!is_null($routeData)){
  		$controllerName=$routeData["controller"]."Controller";
  		$actionName=$routeData["action"];
  	    self::invoke($controllerName,$actionName,$routeData);
  	}else {
  		self::Error404();
  	}
  }
  
  private  static  function Error404()
  {
  	header('HTTP/1.1 404 Not Found');
  	header("status: 404 Not Found");
  	echo "<h1>404 Not Found</h1>";
  }
	
}