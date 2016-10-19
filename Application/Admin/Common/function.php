<?php
/*修复缩略图使用网络地址时，会出现的错误。5iymt 2015年7月10日*/
function sp_asset_relative_url($asset_url){
    if(strpos($asset_url,"http")===0){
    	return $asset_url;
	}else{	
	    return str_replace(C("TMPL_PARSE_STRING.__UPLOAD__"), "", $asset_url);
	}
}

/**
 * 获取当前登录的管事员id
 * @return int
 */
function get_current_admin_id(){
	return $_SESSION['ADMIN_ID'];
}

/**
 * 获取当前登录的管事员id
 * @return int
 */
function sp_get_current_admin_id(){
	return get_current_admin_id();
}
/**
 *  图片上传
 * @return array
 */
function upload(){
	$upload = new \Think\Upload();// 实例化上传类
	$upload->maxSize   =     3145728 ;// 设置附件上传大小
	$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	$upload->rootPath  =     './Public/Uploads/'; // 设置附件上传根目录
	$upload->saveName  =     array('uniqid','');
	// 上传文件
	$info   =   $upload->upload();
	if(!$info) {// 上传错误提示错误信息
		return $upload->getError();
	}else{// 上传成功
		return $info;
	}
}

/**
 * CMF密码加密方法
 * @param string $pw 要加密的字符串
 * @return string
 */
function sp_password($pw){
	$decor=md5(C('DB_PREFIX'));
	$mi=md5($pw);
	return substr($decor,0,12).$mi.substr($decor,-4,4);
}