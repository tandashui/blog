<?php
namespace Home\Controller;
use Think\Controller;
class TagsController extends BaseController {

	public function index(){

		$term_model = M('terms');
		$cats['parent']=array('neq',0);
		$terminfo = $term_model->where($cats)->select();

		// var_dump($terminfo);die;
		$this->assign("terminfo",$terminfo);
        $this->display();
	}

	public function lists(){

		$id=I('get.id');

		 if(!empty($id)){
              
            $list=sp_sql_posts_paged("cid:$id;order:post_date DESC;",5);
            // var_dump($list);die;
        }else{
                 $this->error('非法参数');
        }

		// var_dump($list);die;
		$this->assign("list",$list);
        $this->display("Index/index");
	}

}