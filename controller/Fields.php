<?php
/**
 * +----------------------------------------------------------------------
 * | 成都新数科技有限公司
 * +----------------------------------------------------------------------
 * | Copyright (c) 2017 http://www.xinshukeji.com All rights reserved.
 * +----------------------------------------------------------------------
 * | Author: 钱枪枪 <806115620@qq.com>  2017/8/17 0017 17:54
 * +----------------------------------------------------------------------
 */
namespace app\tests\controller;

class Fields extends Base
{
    public function index(){
        if($_POST){
            $do = input('post.do');
            switch ($do){
                case 'modify':
                    return $this->doModify();
                case 'add';
                    return $this->doAdd();
            }
            return $this->ajaxError('not exist do ' . $do);
        }
        $this->getData();
        return $this->fetch();
    }

    protected function getData(){
        $table = $this->getTable();
        $list = $table->order('id', 'desc')->select();
        $this->assign('fields', $list);
    }

    protected function getTable(){
        return new \app\tests\model\Fields();
    }

    protected function doModify(){
        $id = input('post.id');
        $key = input('post.key');
        $value = input('post.value');
        if(!$id || !$key || !$value){
            return $this->ajaxError('miss args');
        }
        $table = $this->getTable();
        $post = [
            $key => $value
        ];
        $info = $table->find($id);
        if($info && $info->save($post)){
            return $this->ajaxSuccess('ok');
        }
        return $this->ajaxError('update error');
    }


    protected function doAdd(){
        $post = input('post.');
        $need = [
            'name', 'title', 'type', 'value'
        ];
        foreach ($need as $item) {
            if(!isset($post[$item]) || !$post[$item]){
                return $this->ajaxError('miss args:' . $item);
            }
        }
        if($this->getTable()->allowField(true)->save($post)){
            return $this->ajaxSuccess('ok');
        }
        return $this->ajaxError('add error');
    }
}