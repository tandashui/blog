<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends AdminbaseController {
     function _initialize() {}
    
    //后台登陆界面
    public function login() {
        // echo 1;die;
        // var_dump($_SESSION['ADMIN_ID']);die;
        if(isset($_SESSION['ADMIN_ID'])){//已经登录
            
            // $this->success(L('LOGIN_SUCCESS'),U("Index/index"));
        }else{
            // echo 2;die;
            // var_dump($_SESSION['adminlogin']);die;
            if(empty($_SESSION['adminlogin'])){
                // echo 3;die;
                redirect(__ROOT__."/");
            }else{
                // echo 2;die;
                $this->display();
            }
            
        }
    }
    
    public function logout(){
        session('ADMIN_ID',null); 
        $this->redirect("public/login");
    }

    public function dologin(){
        // var_dump($_POST);die;
        $name = I("post.username");
        if(empty($name)){
            $this->error('用户名不能为空');
        }
        $pass = I("post.password");
        if(empty($pass)){
            $this->error('密码不能为空');
        }
        // $verrify = I("post.verify");
        // if(empty($verrify)){
        //     $this->error(L('CAPTCHA_REQUIRED'));
        // }
        //验证码
        // if(!sp_check_verify_code()){
        $as = 1;
        if(!$as){
            $this->error(L('CAPTCHA_NOT_RIGHT'));
        }else{

            $user = D("Common/Users");
            if(strpos($name,"@")>0){//邮箱登陆
                $where['user_email']=$name;
            }else{
                $where['user_login']=$name;
            }
            
            $result = $user->where($where)->find();
            // var_dump($result);die;
            if(!empty($result) && $result['user_type']==1){
                // var_dump(sp_password($pass));die;
                if($result['user_pass'] == sp_password($pass)){
                    
                    // $role_user_model=M("RoleUser");
                    
                    // $role_user_join = C('DB_PREFIX').'role as b on a.role_id =b.id';
                    
                    // $groups=$role_user_model->alias("a")->join($role_user_join)->where(array("user_id"=>$result["id"],"status"=>1))->getField("role_id",true);
                    
                    // if( $result["id"]!=1 && ( empty($groups) || empty($result['user_status']) ) ){
                    //     $this->error(L('USE_DISABLED'));
                    // }
                    //登入成功页面跳转
                    $_SESSION["ADMIN_ID"]=$result["id"];
                    $_SESSION['name']=$result["user_login"];
                    $result['last_login_ip']=get_client_ip();
                    $result['last_login_time']=date("Y-m-d H:i:s");
                    $user->save($result);
                    setcookie("admin_username",$name,time()+30*24*3600,"/");
                    $this->success('登录成功',U("Index/index"));
                }else{
                    $this->error('密码错误');
                }
            }else{
                $this->error('用户不存在');
            }
        }
    }
}