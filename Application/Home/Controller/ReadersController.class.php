<?php
namespace Home\Controller;
use Think\Controller;
class ReadersController extends BaseController {
	public function index(){

		$this->assign("terminfo",$terminfo);
        $this->display();
	}
}