<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        $id=I('get.id');

        // echo $id;die;
    	$term_model = M('terms');
        if(!empty($id)){
                //查出所有的分类
            // $term_id = $term_model->getField('term_id',true);
            // $term_ids=implode(",",$term_id);
            // echo $id;die;

            // var_dump($term_ids);die;
            $list=sp_sql_posts_paged("cid:$id;order:post_date DESC;",5);
            // var_dump($list);die;
        }else{
                    //查出所有的分类
                $term_id = $term_model->getField('term_id',true);
                $term_ids=implode(",",$term_id);

                // var_dump($term_ids);die;
                $list=sp_sql_posts_paged("cid:$term_ids;order:post_date DESC;",5);
        }
        // var_dump($list);die;
        //查出文章所属分类
         foreach ($list['posts'] as $kss => $vss) {
          
            $cats['parent']=array('eq',$vss['term_id']);

            $cat=$term_model->where($cats)->find();
           
            $list['posts'][$kss]["name"]=$cat['name'];

        }
    	
        // dump($list);

        $result = $term_model->order(array("listorder"=>"asc"))->select();

        $where['parent'] = array('eq',0);
        $result1 = $term_model->order(array("listorder"=>"asc"))->where($where)->select();

        foreach ($result1 as $ks => $vs) {
            # code...
            $url=U('Home/Index/index',array('id'=>$vs['term_id']));
            // echo $url;die;
            $result1[$ks]["url"] = $url;
        }
        // var_dump($result1);die;
        
        foreach ($result1 as $key => $value) {

            foreach ($result as $k => $v) {
                # code...
                if($v['parent'] == $value['term_id']){
                    $result1[$key]['children'][]=$v;
                }
            }
            
        }

         //查出所有的分类
                $term_id = $term_model->getField('term_id',true);
                $term_ids=implode(",",$term_id);

                // var_dump($term_ids);die;
                $hot=sp_sql_posts_paged("cid:$term_ids;order:post_hits DESC;",5);
        //热门文章
        // var_dump($hot);die;
        
        $this->assign('list', $list);
        $this->display();

    }
}