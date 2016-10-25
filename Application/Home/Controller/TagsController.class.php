<?php
namespace Home\Controller;
use Think\Controller;
class TagsController extends BaseController {

	public function index(){
		$this->assign("article_id",$article_id);
        $this->display();
	}

}