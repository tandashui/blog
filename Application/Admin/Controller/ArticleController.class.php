<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends Controller {
	protected $terms_model;
	protected $taxonomys=array("article"=>"文章","picture"=>"图片");

	function _initialize() {

		// parent::_initialize();
		$this->terms_model = D("Admin/Terms");
		$this->assign("taxonomys",$this->taxonomys);
	}


    public function index(){
    	
    	$result = $this->terms_model->order(array("listorder"=>"asc"))->select();

    	// var_dump($result);die;
    	$tree = new \Org\Util\Tree;

    	// var_dump($Tree);die;

    	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		// var_dump($tree->icon);die;

		foreach ($result as $r) {
			// var_dump($r);die;
			$r['str_manage'] = '<a href="' . U("Article/add", array("parent" => $r['term_id'])) . '">'.'添加子类'.'</a> | <a href="' . U("Article/edit", array("id" => $r['term_id'])) . '">'.'编辑'.'</a> | <a class="js-ajax-delete" href="' . U("Article/delete", array("id" => $r['term_id'])) . '">'.'删除'.'</a> ';
			$url=U('portal/list/index',array('id'=>$r['term_id']));
			// echo $url;die;
			$r['url'] = $url;
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			// var_dump($r);die;
			$array[] = $r;
		}
		var_dump($array);die;

		$tree->init($array);
		// var_dump($tree->init($array));die;
		$str = "<tr>
					<td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
					<td>\$id</td>
					<td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
	    			<td>\$taxonomys</td>
					<td>\$str_manage</td>
				</tr>";
				// var_dump($str);die;
		$taxonomys = $tree->get_tree(0, $str);
		// var_dump($taxonomys);die;
        $this->assign("taxonomys", $taxonomys);
        $this->display();
        

    }

    function add(){
	 	$parentid = intval(I("get.parent"));
	 	$tree = new \Org\Util\Tree();
	 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
	 	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
	 	$terms = $this->terms_model->order(array("path"=>"asc"))->select();
	 	
	 	$new_terms=array();
	 	foreach ($terms as $r) {
	 		$r['id']=$r['term_id'];
	 		$r['parentid']=$r['parent'];
	 		$r['selected']= (!empty($parentid) && $r['term_id']==$parentid)? "selected":"";
	 		$new_terms[] = $r;
	 	}
	 	$tree->init($new_terms);
	 	$tree_tpl="<option value='\$id' \$selected>\$spacer\$name</option>";
	 	$tree=$tree->get_tree(0,$tree_tpl);
	 	// var_dump($tree);die;
	 	$this->assign("terms_tree",$tree);
	 	$this->assign("parent",$parentid);
	 	$this->display();
	}

	function add_post(){
		// var_dump($_POST);die;
		if (IS_POST) {
			if ($this->terms_model->create()) {
				if ($this->terms_model->add()!==false) {
				    F('all_terms',null);
					$this->success("添加成功！",U("Article/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->terms_model->getError());
			}
		}
	}

	function edit(){
		$id = intval(I("get.id"));
		$data=$this->terms_model->where(array("term_id" => $id))->find();
		// $tree = new \Tree();
		$tree = new \Org\Util\Tree;
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$terms = $this->terms_model->where(array("term_id" => array("NEQ",$id), "path"=>array("notlike","%-$id-%")))->order(array("path"=>"asc"))->select();
		
		$new_terms=array();
		foreach ($terms as $r) {
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['selected']=$data['parent']==$r['term_id']?"selected":"";
			$new_terms[] = $r;
		}
		
		$tree->init($new_terms);
		$tree_tpl="<option value='\$id' \$selected>\$spacer\$name</option>";
		$tree=$tree->get_tree(0,$tree_tpl);
		// var_dump($data);die;
		$this->assign("terms_tree",$tree);
		$this->assign("data",$data);
		$this->display();
	}

	function edit_post(){
		// var_dump($_POST);die;
		if (IS_POST) {
			if ($this->terms_model->create()) {
				// $this->terms_model->save();
				// echo $this->terms_model->getLastsql();die;
				if ($this->terms_model->save()!==false) {
				    F('all_terms',null);
					$this->success("修改成功！");
				} else {
					$this->error("修改失败！");
				}
			} else {
				$this->error($this->terms_model->getError());
			}
		}
	}

	/**
	 *  删除
	 */
	public function delete() {
		$id = intval(I("get.id"));
		$count = $this->terms_model->where(array("parent" => $id))->count();
		
		if ($count > 0) {
			$this->error("该菜单下还有子类，无法删除！");
		}
		
		if ($this->terms_model->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
}