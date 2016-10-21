<?php
namespace Home\Controller;
use Think\Controller;
class LinksController extends BaseController {

	public function index(){
		$this->display("links");
	}

}