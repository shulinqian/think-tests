<?php
namespace app\tests\cases;
use think\Debug;
use app\tests\common\libs\Ref;

abstract class Base{

    abstract function run();
    /**
     * 结果
     * @var array
     */
    protected $result = [
        'info' => [],
        'data' => [],
    ];

    /**
     * 成功
     * @param $msg
     * @param array $data
     */
    protected function success($msg, $data = [])
    {
        $called = $this->get_called_method();
        $this->result['data'][$called] = [
            'type' => 'success',
            'comment' => $this->getComment($called),
            'msg' => $msg,
            'data' => $data
        ];
    }

    /**
     * 状态保存
     * @var array
     */
    protected $state = [];

    /**
     * @return array
     */
    protected function getState()
    {
        return $this->state;
    }

    /**
     * @param array $state
     */
    protected function setState($state)
    {
        $called = $this->get_called_method();
        $this->state[$called] = $state;
    }

    /**
     * 失败
     * @param $msg
     * @param array $data
     */
    protected function error($msg, $data = [])
    {
        $called = $this->get_called_method();
        $this->result['data'][$called] = [
            'type' => 'error',
            'comment' => $this->getComment($called),
            'msg' => $msg,
            'data' => $data
        ];
    }

    /**
     * 获取调用栈
     * @param string $return
     * @param int $level
     * @return array
     */
    protected function get_called_method($return = 'function', $level = 1)
    {
        $backtrace = debug_backtrace();
        array_shift($backtrace);
        if($return == 'all'){
            return $backtrace;
        }
        return $backtrace[$level][$return];
    }

    protected $ref;

    /**
     * 获取注释
     * @param null $method
     * @return null
     */
    protected function getComment($method = null){
        if(!$this->ref){
            Ref::setClass($this);
            $this->ref = Ref::getAll();
            $this->result['info'] = $this->ref;
        }
        if(!$method){
            return null;
        }
        foreach ($this->ref['methods'] as $item) {
            if($item['name'] == $method){
                return $item['comment'];
            }
        }
        return null;
    }

    /**
     * 执行
     * @param $list
     */
    protected function doRun($list){
        $mask = input('get.mask', 0, 'intval');
        foreach ($list as $key => $item) {
            if($mask && (($mask & $key) != $key)){
                continue;
            }
            Debug::remark('test_begin');
            $this->$item();
            Debug::remark('test_end');
            $range = Debug::getRangeTime('test_begin','test_end') .'s';
            if(isset($this->result['data'][$item])){
                $this->result['data'][$item]['time'] = $range;
            }
        }
    }

    /**
     * 调试
     * @param $data
     * @param null $msg
     * @param string $level
     */
    protected function trace($data, $msg = null, $level = 'debug'){
        $called = $this->get_called_method('all');
        $class = $called[1]['class'];
        $function = $called[1]['function'];
        $line = $called[0]['line'];

        $calledMsg = "#-- 调试点: {$class}::{$function}() line:" . $line . '。 ' . $msg;
        trace($calledMsg, $level);
        trace($data, $level);
    }

}