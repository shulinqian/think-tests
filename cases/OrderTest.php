<?php
namespace app\tests\cases;

/**
 * 订单
 * Class UserTest
 * @package tests
 */
class OrderTest extends Base
{

    /**
     * 测试入口
     * @return array
     */
    public function run()
    {
        $this->getComment();
        $testList = [
            1 => 'add',
            2 => 'edit',
            4 => 'delete',
            8 => 'step1',
            16 => 'step2',
        ];
        $this->doRun($testList);
        return $this->result;
    }

    /**
     * 创建订单
     */
    public function add(){
        $id = 'order_sn_' . rand(999, 999999);
        $this->setState($id, 'order_id');
        $this->trace($id, '新增的订单的id');
        $this->success('增加成功');
    }
    /**
     * 修改订单
     */
    public function edit(){
        $id = $this->getState('order_id');
        $this->trace($id, '修改的订单的id');
        $this->error('修改失败');
    }
    /**
     * 删除订单
     */
    public function delete(){
        $id = $this->getState('order_id');
        $this->trace($id, '删除的订单的id');
    }
    /**
     * 订单第一步
     */
    public function step1(){
        $this->success('增加成功');
    }
    /**
     * 订单第二步
     */
    public function step2(){
        $this->success('增加成功');
    }

}