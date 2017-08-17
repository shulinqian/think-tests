# think-tests
QQ群：647344518   [立即加群](http://shang.qq.com/wpa/qunwpa?idkey=83a58116f995c9f83af6dc2b4ea372e38397349c8f1973d8c9827e4ae4d9f50e)   
体验地址： [http://www.must.pw/tests/](http://www.must.pw/tests/) 

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


### 6.前端api快速生成
上面几项是给后端开发者开发测试用的，实际开发中，前端其实需要后端提供接口才能进行开发，为了解决此需求，增加api和字段管理，当然你也可以用rap，阿里团队出的。   
![image](https://raw.githubusercontent.com/shulinqian/think-tests/master/common/static/3.jpg)
![image](https://raw.githubusercontent.com/shulinqian/think-tests/master/common/static/4.jpg)

#### 实现功能:
后端将字段定义好，当然也可以和前端一起商量定义好字段规范   
前端进行开发的时候，进行api创建，当然也可以由后端创建，系统会提供mock数据给前端进行并行开发，后端可根据此api开发后端，联调时切换到正式接口，达到同步开发   
操作都比较简单，后期增加更多功能，比如后端开发的api接口和定义的接口 进行对比，对有差异的进行报警提示，以防前后端接口不一致等，当然有时间可以开发自动生成程序，根据定义的接口，自动生成代码

因为要保存接口和字段数据，所以需要添加2个表，如下：
```
CREATE TABLE `dev_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL COMMENT 'mcok值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='字段表';

CREATE TABLE `dev_apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `method` varchar(30) NOT NULL COMMENT '请求类型',
  `desc` varchar(255) DEFAULT NULL COMMENT '接口描述',
  `args_se` mediumtext COMMENT '参数',
  `fields_se` mediumtext COMMENT '返回字段',
  `return_type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='api开发表';
```
