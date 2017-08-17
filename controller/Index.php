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

use think\Exception;
use app\tests\common\libs\File;
use app\tests\common\libs\Ref;

class Index extends Base
{
    protected $testPre = 'test_';
    protected $casesPre = '\\app\\tests\\cases\\';

    public function index($case = null){
        if($case != null){
            config('app_debug', true);
            config('app_trace', true);
            $method = $this->testPre . $case;
            $rs = $this->$method();
            $this->assign('result', $rs);
            return $this->fetch('result');
        }
        $this->getModels();
        return $this->fetch();
    }

    public function __call($name, $arguments)
    {
        if(strpos($name, $this->testPre) !== 0){
            throw new  Exception($name . ' not exist');
        }
        $className = str_replace($this->testPre, '', $name);
        $class = $this->casesPre . $className;
        if(!class_exists($class)){
            throw new  Exception($class . ' not exist');
        }
        $obj = new $class();
        return $obj->run();
        // TODO: Implement __call() method.
    }

    protected function getModels(){
        $rs = [];
        $excludes = ['Base'];
        $files = File::get_dirs(__DIR__ . '/../cases/');
        foreach ($files['file'] as $file) {
            $className = str_replace('.php', '', $file);
            if(in_array($className, $excludes)){
                continue;
            }
            $class = $this->casesPre . $className;
            if(!class_exists($class)){
                continue;
            }
            Ref::setClass($class);
            $tmp = Ref::getAll();
            $tmp['class'] = $className;
            $rs[] = $tmp;
        }

        $this->assign('models', $rs);
    }

    public function layui(){
        header('Content-type: text/css');
        echo file_get_contents(__DIR__ . '/../common/static/layui.css');exit;
    }

}