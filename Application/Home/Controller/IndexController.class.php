<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$term_model = M('terms');
    	//查出所有的分类
    	$term_id = $term_model->getField('term_id',true);
    	$term_ids=implode(",",$term_id);

    	// var_dump($term_ids);die;
        $list=sp_sql_posts_paged("cid:$term_ids;order:post_date DESC;",5);
        // dump($list);
        $this->assign('list', $list);
        $this->display();

    }
}