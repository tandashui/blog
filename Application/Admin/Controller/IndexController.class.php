<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        // //实例化用户表

        //  $user = M('user');

        //  $user_list = $user->select();

        //  var_dump($user_list);
        $this->display();
        

    }
}