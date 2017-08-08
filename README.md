# think-tests
QQ群：647344518   [立即加群]((http://shang.qq.com/wpa/qunwpa?idkey=83a58116f995c9f83af6dc2b4ea372e38397349c8f1973d8c9827e4ae4d9f50e))
### 1. 简介    
在实际开发中，在开发阶段，其实并不是完全测试，更多的是调试，如果用phpunit进行测试驱动，其实有很多不方便，当然在项目开发完后，也建议大家写测试用例，保证代码的可用性和检查代码的覆盖率，避免垃圾代码   
为了简化开发中调试和测试，开发了此模块，在前后端开发分离的时候节省开发时间和步骤。

![image](https://raw.githubusercontent.com/shulinqian/think-tests/master/common/static/1.jpg)
![image](https://raw.githubusercontent.com/shulinqian/think-tests/master/common/static/2.jpg)
#### 应用场景：
在开发了模型或逻辑代码的时候，可以进行一些测试   
第三方api或sdk测试   
你临时一些测试代码，又需要用到项目模型等文件的测试   
等等...


### 2. 安装
进入项目 application目录
```
git clone git clone https://github.com/shulinqian/think-tests.git tests
```
### 3. 访问地址
http://你的地址/tests/

### 4. 开发
进入tests/cases目录，新建文件，命名规则  *Test.php, 参照 UserTest.php   
run: 每个测试文件的入口，里面定义要测试的方法   
trace: 需要调试的信息，需要打开app_debug， app_trace   
success: 测试通过   
error: 测试错误   
setState: 状态保存，用于保存数据，用于下个测试，例如：新增后保存id，用户后面修改测试，或者删除

### 5.高级
1) 建议尽量在run的最后一个测试方法里面加入个 repaire方法，进行数据数据修复，将测试的数据还原   
2) 测试详细页面$testList的key 设置成1,2,4,8....,   
    二进制为:    
    00000001   
    00000010   
    00000100   
    00001000   
    ...
                
    然后在地址栏加入&mask= 会根据二进制与操作进行测试
    例如： /tests/?case=UserTest&mask=3  会执行key为 1、2的。3的二进制00000011    

