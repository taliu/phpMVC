<?php
class HomeController extends ControllerBase
{
	private  $users;
    public function __construct(){
		$this->users=array(new User("taliu", '123'));
	}
	
	private function FindUser($userName){
		foreach ($this->users as $value) {
			if ($value->userName===$userName) {
				return $value;
			}
		}
		return null;
	}
	
	private  function getUserInfo(){
		if(isset($_COOKIE['mvc_user'])){
			$str=$_COOKIE['mvc_user'];
			$str=base64_decode($str);
		    $user= json_decode($str);
		    if(json_last_error()===JSON_ERROR_NONE){
		    	return $user;
		    }
		}
		return null;
	}
	private  function setUserInfo(User $userInfo){
		$str= json_encode($userInfo);
		if(json_last_error()===JSON_ERROR_NONE){
			$str=base64_encode($str);
			setcookie('mvc_user',$str);
		}
	}
	
	public  function index(){
	    $user=$this->getUserInfo();
	    if($user){
	    	$this->view($user);
	    }else{
	    	$this->redirect("Login");
	    }
	}	

	public function Login($username,$password){
		if($_SERVER["REQUEST_METHOD"]=='GET'){
			return $this->view();
		}
		
		$isValid=false;
		$user=$this->FindUser($username);
		if (!is_null($user)) {
			if ($user->password===$password) {
				$isValid=true;
			}
		}
		
		if($isValid){
		 $this->setUserInfo($user);
		  $this->redirect("index");
		}else {
			$this->view(array("isValid"=>$isValid));
		}
	}
	
	public function Logout(){
		setcookie ("mvc_user", "", time() - 3600);
		$this->redirect("login");
	}
	
	public function info(){
		$this->view(array("我是模型"));
	}
}
