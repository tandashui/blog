<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function _initialize(){

    	$term_model = M('terms');
        
    	
       $id=I('get.id');

        // echo $id;die;
    	$term_model = M('terms');
        if(!empty($id)){
                //查出所有的分类
            $term_id = $term_model->getField('term_id',true);
            $term_ids=implode(",",$term_id);

            // var_dump($term_ids);die;
            $list=sp_sql_posts_paged("cid:$id;order:post_date DESC;",5);
        }else{
                    //查出所有的分类
                $term_id = $term_model->getField('term_id',true);
                $term_ids=implode(",",$term_id);

                // var_dump($term_ids);die;
                $list=sp_sql_posts_paged("cid:$term_ids;order:post_date DESC;",5);
        }
    	
        // dump($list);

        $result = $term_model->order(array("listorder"=>"asc"))->select();
         foreach ($result as $kss => $vss) {
            # code...
            $url=U('Home/Index/index',array('id'=>$vss['term_id']));
            // echo $url;die;
            $result[$kss]["url"] = $url;
            $cats['id']=array('eq',$vss['parent']);
            $cat=$term_model->where($cats)->find();
            // var_dump($cat);die;
            $result[$kss]["url"]=$cat['name'];

        }
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

        // var_dump($result1);die;

         //查出所有的分类
                $term_id = $term_model->getField('term_id',true);
                $term_ids=implode(",",$term_id);

                // var_dump($term_ids);die;
                $hot=sp_sql_posts_paged("cid:$term_ids;order:post_hits DESC;",5);
        $this->assign('hot', $hot);
        $this->assign('result1', $result1);
    }

}