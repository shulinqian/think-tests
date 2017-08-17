<?php
namespace app\tests\controller;

use think\Controller;

class Base extends Controller{

    protected $beforeActionList = [
        'initEnv'
    ];

    protected function menus(){
        $menu = [
            'index' => [
                'title' => '开发测试',
                'url' => url('index/index')
            ],
            'apis' => [
                'title' => 'apis',
                'url' => url('apis/index'),
            ],
            'fields' => [
                'title' => '字段',
                'url' => url('fields/index'),
            ],
        ];
        $this->assign('menus', $menu);
        $this->assign('currentMenu', strtolower($this->request->controller()));
    }

    protected function initEnv(){
        $this->menus();
    }

    protected function ajaxSuccess($msg, $status = 200){
        return json(['code' => 200, 'message' => $msg], $status);
    }

    protected function ajaxError($msg, $code = 5001, $status = 501){
        return json(['code' => $code, 'message' => $msg], $status);
    }

    protected function ajaxData($data = []){
        return json(['code' => 200, 'data' => $data], 200);
    }

    protected function ajaxDataResource($data = []){
        return json($data, 200);
    }

}