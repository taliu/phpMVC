# phpMVC
一个简单的php mvc框架（模拟asp.net mvc）。
在controllers中添加控制器类： xxxController.class.php ,如HomeController.class
```
class HomeController extends ControllerBase
{
  public  function index(){ //一定要为public的方法
	    $user=$this->getUserInfo();
	    if($user){
	    	$this->view($user);
	    }else{
	    	$this->redirect("Login");
	    }
	}	
}
```
在视图中添加views\xxx\actionName.php,如添加\views\home\index.php
```
<?php
echo "<h1>welcome!</h1>";
var_dump($model);
var_dump($viewName);
var_dump($this->routeData);
echo '<a href="/home/Logout">退出</a>';
?>
```
在RouteConfig.php中配置路由：
```
<?php
RouteTable::register("default",
new Route("/{controller}/{action}/{id}",//路由模板
["controller"=>"home",//默认值
"action"=>"index",
 "id"=>6
]));
```
