<?php
namespace app\tests\cases;

/**
 * 会员
 * Class UserTest
 * @package tests
 */
class UserTest extends Base
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
            2=> 'edit',
            4=> 'delete',
        ];
        $this->doRun($testList);
        return $this->result;
    }

    /**
     * 新增用户
     */
    public function add()
    {
        $this->trace(['test' => 34234], '会员信息');

        $this->trace(['test' => 5555], '标题');
        $this->success('add');
        return null;
    }

    /**
     * 修改用户
     */
    public function edit()
    {
        $this->success('edit');
    }

    /**
     * 删除用户
     */
    public function delete()
    {
        $this->error('delete user');
    }

}