<?php
namespace app\tests\controller;

use app\tests\model\Fields;

class Apis extends Base
{
    public function index(){
        $table = $this->getTable();
        $list = $table->order('id', 'desc')->select();
        $this->assign('apis', $list);

        return $this->fetch();
    }

    public function apissave(){

        $id = input('param.id');
        $table = $this->getTable();

        if($_POST){
            $post = input('post.');
            if(isset($post['fields_se']) && $post['fields_se'] && is_array($post['fields_se'])){
                $post['fields_se'] = serialize($post['fields_se']);
            }
            if($id){
                $info = $table->find($id);
                $rs = $info->save($post);
            } else {
                $rs = $table->insert($post);
            }
            if($rs){
                return $this->ajaxSuccess('ok');
            }
            return $this->ajaxError('更新失败');
        }

        $info = [];
        if($id){
            $info = $table->find($id);
        }

        $this->assign('info', $info);
        return $this->fetch();
    }

    protected function getTable(){
        return new \app\tests\model\Apis();
    }

    public function fieldsjson(){
        $table = new Fields();
        $query = input('get.query');
        $where = [];
        if($query){
            $where['name'] = [
                'like', '%' . $query . '%'
            ];
        }
        $list = $table->order('id', 'desc')->where($where)->select();
        $rs = [];
        foreach ($list as $item) {
            $rs[] = [
                'value' => $item['name'],
                'data' => $item['id']
            ];
        }
        return $this->ajaxDataResource(['suggestions' => $rs]);
    }

}