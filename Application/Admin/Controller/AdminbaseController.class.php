<?php
namespace Admin\Controller;
use Think\Controller;
class AdminbaseController extends Controller {
    function _initialize(){
       // parent::_initialize();
    	if(isset($_SESSION['ADMIN_ID'])){
    		$users_obj= M("Users");
    		$id=$_SESSION['ADMIN_ID'];
    		$user=$users_obj->where("id=$id")->find();
    		// if(!$this->check_access($id)){
    		// 	$this->error("您没有访问权限！");
    		// 	exit();
    		// }
    		$this->assign("admin",$user);
    	}else{
    		// echo 2;die;
    		//$this->error("您还没有登录！",U("admin/public/login"));
    		if(IS_AJAX){
    			$this->error("您还没有登录！",U("Public/login"));
    		}else{
    			header("Location:".U("Public/login"));
    			exit();
    		}
    		
    	}
    }
}