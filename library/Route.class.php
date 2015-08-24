<?php
/*
 * 路由对象
 */
class Route
{
    private  $defaultValues;
	private  $url_pattern;//url模版 /{controller}/{action}--{id}
	private $constraints;//对url模版 的约束
	private $url_match_pattern;//$url_pattern和$constraints结合生成的匹配请求地址的正则表达式
	function __construct($url_pattern,array $defaultValues=null, array $constraints=null)
	{
		$this->constraints=$constraints;
		$this->url_pattern=trim($url_pattern);
		$this->defaultValues=$defaultValues;
		
		
		if(!Tools::isNullOrEmpty($this->url_pattern)){
		   $this->url_match_pattern=$this->getPattern($this->url_pattern);
		}else {
			$this->url_match_pattern=null;
		}
	}
	
	public function getRouteData($url)
	{
		 
		$url_match_pattern=$this->url_match_pattern;
		if(  !Tools::isNullOrEmpty($url)
		   &&!Tools::isNullOrEmpty($url_match_pattern)){
			$routeData=$this->match("#^$url_match_pattern$#", $url);
			if($routeData!=null){
				 return $routeData;
			}else{
				
				$url=rtrim($url,"/");
				//匹配不成功，使用默认值后再匹配
				$defaultValues=$this->defaultValues;
				if($defaultValues!=null){
					$defaults=[];
					$url_pattern=$this->url_pattern;
					$defaultValues=$this->sort($defaultValues);	
					foreach ($defaultValues as $key=>$value) {
					 	$next_url_pattern=preg_replace("#\{$key\}#", "", $url_pattern);
					 	if($next_url_pattern!==$this->url_pattern){
					 		$url_pattern=$next_url_pattern;
					 		$defaults[$key]=$value;
					 		$url_pattern=preg_replace("#//#", "/", $url_pattern);
					 		$url_pattern=preg_replace("#/\.#", ".", $url_pattern);
					 		$url_pattern=rtrim($url_pattern,"/");
					 		if($url_pattern===$url){
					 			$routeData=[];
					 		}else{
						 		//Tools::var_dump($url_pattern);
						 		$url_match_pattern=$this->getPattern($url_pattern);
						 		$routeData=$this->match("#^$url_match_pattern$#", $url);
					 		}
					 		if($routeData!==null){
					 			$routeData=array_merge($defaults,$routeData);
					 			 if( key_exists("action", $routeData)
					 			  && key_exists("controller", $routeData)){
					 			         return $routeData;
					 			 }
					 		}
					 	}
					}
				}
			}
		}
		return null;
	}
	
	private  function  sort($defaultValues){
	  $result=[];
	  $count=preg_match_all("#{(\w+)}#",$this->url_pattern,$out, PREG_PATTERN_ORDER);
	  if($count){
	  	 $out=$out[1];
	  	 for ($i =count($out)-1; $i >= 0; $i--) {
	  	 	$key=$out[$i];
	  	 	if(key_exists($key, $defaultValues)){
	  	 		$result[$key]=$defaultValues[$key];
	  	 	}
	  	 }
	  }
	  return $result;
	}
	
	private function  match($pattern,$url){
		$routeData=[];
		if(preg_match($pattern, $url, $matches)){
			foreach ($matches as $key=>$value) {
				if (!is_int($key)) {
					$routeData[$key]=$value;
				};
			}
			return $routeData;
		}
		return null;
	}
	
	private function getPattern($url_pattern)
	{
	 $pattern=preg_replace_callback('#{([a-zA-Z0-9_]+)}#',
		function($matches){
			$name=$matches[1];
			$constraint=$this->getConstraint($name);
			if($constraint==null){
				$constraint="[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*";
			}
			return "(?<$name>$constraint)";
		},$url_pattern);
	  return $pattern;
	}
	
	private  function getConstraint($key){
		$constraints=$this->constraints;
		if (!is_null($constraints))
		{
			if(array_key_exists($key,$constraints)){
				return $constraints[$key];
			}
		}
		return null;
	}
	
}

