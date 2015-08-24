<?php
class ControllerBase
{
	public  $routeData;
	protected  function view($model=null,$viewName=null,$controllerName=null){
		//$GLOBALS['model']=$model;
		if (Tools::isNullOrEmpty($controllerName)) {
			$controllerName= $this->routeData["controller"];
		}
		if (Tools::isNullOrEmpty($viewName)) {
			$viewName=$this->routeData["action"];
		}
		require_once $_SERVER['DOCUMENT_ROOT']."/views/$controllerName/$viewName.php";
	}
	
	protected function redirect($viewName,$controllerName=null){
		if (Tools::isNullOrEmpty($controllerName)) {
			$controllerName= $this->routeData["controller"];
		}
		if (Tools::isNullOrEmpty($viewName)) {
			throw new Exception("参数viewName不能为空");
		}
		header("Location:http://".$_SERVER['HTTP_HOST']."/$controllerName/$viewName",true,302);
		exit;
	}
}