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
namespace app\tests\common\libs;
use ReflectionClass;

/**
 * 调用PHP反射类获取类信息
 * Date:    2017-05-24
 * Author:  fdipzone
 * Ver:     1.0
 *
 * Func
 * public static setClass       设置反射类
 * public static getBase        读取类基本信息
 * public static getInterfaces  读取类接口
 * public static getProperties  读取类属性
 * public static getMethods     读取类方法
 */
class Ref{

    /**
     * @var ReflectionClass
     */
    private static $refclass = null;

    // 设置反射类
    public static function setClass($className){
        self::$refclass = new ReflectionClass($className);
    }

    public static function getAll(){
        $rs = [
            'base' => static::getBase(),
            'proerties' => static::getProperties(),
            'methods' => static::getMethods(),
            'interfases' => static::getInterfaces(),
        ];
        return $rs;
    }

    // 读取类基本信息
    public static function getBase(){
        $rs = [];
        $rs['comment'] = self::formatComment(self::$refclass->getDocComment());
        $rs['modifier'] = self::$refclass->getModifiers();
        $rs['name'] = self::$refclass->getName();
        $rs['file'] = self::$refclass->getFileName();
        return $rs;
    }

    // 读取类接口
    public static function getInterfaces(){
        $rs = [];
        $interfaces = self::$refclass->getInterfaces();
        if($interfaces){
            foreach($interfaces as $interface){
                $rs[] = $interface->getName();
            }
        }
        return $rs;
    }

    // 读取类属性
    public static function getProperties(){
        $properties = self::$refclass->getProperties();
        $rs = [];
        if($properties){
            foreach($properties as $property){
                $rs[] = [
                    'name' => $property->getName(),
                    'modifier' => self::getModifier($property),
                    'comment' => self::formatComment($property->getDocComment()),
                ];
            }
        }
        return $rs;
    }

    // 读取类方法
    public static function getMethods(){
        $rs = [];
        $methods = self::$refclass->getMethods();
        if($methods){
            foreach($methods as $key => $method){
                $rs[$key] = [
                    'name' => $method->getName(),
                    'modifier' => self::getModifier($method),
                    'comment' => self::formatComment($method->getDocComment()),
                    'params_num' => $method->getNumberOfParameters(),
                    'params' => []
                ];

                $params = $method->getParameters();
                if($params){
                    foreach($params as $param){
                        $rs[$key]['params'][] = $param->getName();
                    }
                }
            }
        }
        return $rs;
    }

    /**
     * 获取修饰符
     * @param \ReflectionProperty $o
     * @return string
     */
    private static function getModifier($o){
        // public
        if($o->isPublic()){
            return 'public';
        }

        // protected
        if($o->isProtected()){
            return 'protected';
        }

        // private
        if($o->isPrivate()){
            return 'private';
        }

        return '';
    }

    // 格式化注释内容
    private static function formatComment($comment){
        $doc = explode(PHP_EOL, $comment);
        return isset($doc[1])? trim(str_replace('*','',$doc[1])) : '';
    }

}