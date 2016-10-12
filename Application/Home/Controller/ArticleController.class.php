<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends BaseController {
    public function index(){
        $term_model = M('terms');
    	$id=intval($_GET['id']);
        // var_dump($id);die;
        $article=sp_sql_post($id,'');
        // var_dump($article);die;
        // if(empty($article)){
        //     header('HTTP/1.1 404 Not Found');
        //     header('Status:404 Not Found');
        //     // if(sp_template_file_exists(MODULE_NAME."/404")){
        //     //     $this->display(":404");
        //     // }
            
        //     return ;
        // }
        $termid=$article['term_id'];
        $term_obj= M("Terms");
        $term=$term_obj->where("term_id='$termid'")->find();
        
        $article_id=$article['object_id'];
        
        $posts_model=M("Posts");
        $posts_model->save(array("id"=>$article_id,"post_hits"=>array("exp","post_hits+1")));
        // echo $posts_model->getLastSql();die;
        
        $article_date=$article['post_modified'];
        
        $join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
        $join2= "".C('DB_PREFIX').'users as c on b.post_author = c.id';
        $rs= M("TermRelationships");
        
        $next=$rs->alias("a")->join($join)->join($join2)->where(array("post_modified"=>array("egt",$article_date), "tid"=>array('neq',$id), "status"=>1,'term_id'=>$termid))->order("post_modified asc")->find();
        $prev=$rs->alias("a")->join($join)->join($join2)->where(array("post_modified"=>array("elt",$article_date), "tid"=>array('neq',$id), "status"=>1,'term_id'=>$termid))->order("post_modified desc")->find();
        
         
        $this->assign("next",$next);
        $this->assign("prev",$prev);
        
        $smeta=json_decode($article['smeta'],true);
        $content_data=sp_content_page($article['post_content']);
        $article['post_content']=$content_data['content'];

            $cats['parent']=array('eq',$article['term_id']);

            $cat=$term_model->where($cats)->find();
           
            $article["name"]=$cat['name'];
        // var_dump($article);die;
        $this->assign("page",$content_data['page']);
        $this->assign($article);
        $this->assign("smeta",$smeta);
        $this->assign("term",$term);
        $this->assign("article_id",$article_id);
        
        // $tplname=$term["one_tpl"];
        // $tplname=sp_get_apphome_tpl($tplname, "article");
        // $this->display(":$tplname");
        $this->display("article");

    }
}