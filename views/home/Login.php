<?php
if(!is_null($model)){
	if(!$model["isValid"]){
		echo '<b style="color: red">错误:用户名或密码错误</b>';
	}
}
?>
<form method="POST"  action="/home/login">
	<table>
	  <tr>
	    <td>用户名称</td>
	    <td><input type="text"  name="username" /></td>
	  </tr>
	  <tr>
	    <td>用户密码</td>
	    <td><input type="text"  name="password" /></td>
	  </tr>
	  <tr>
	     <td><input type="submit"  name="login"  value="登入"/></td>
	  </tr>
	</table>
</form>