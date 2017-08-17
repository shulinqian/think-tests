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
use app\tests\model\Fields;

class MockConfig{

    static $mocks = [];
    public static function get($key = null, $def = null)
    {
        if(!static::$mocks){
            $data = static::getDataFromDb();
            static::$mocks = static::toArray($data, 'name', 'value');
        }

        $mocks = static::$mocks;
        if($key === null){
            return $mocks;
        }
        return isset($mocks[$key]) ? $mocks[$key] : $def;
    }

    public static function toArray($data, $name, $value = null){
        $rs = [];
        foreach ($data as $key => $item) {
            if($value === null){
                $rs[$item[$name]] = $item;
            } else {
                $rs[$item[$name]] = $item[$value];
            }
        }
        return $rs;
    }

    static $map = [];
    public static function map($key = null, $def = []){
        if(!static::$map){
            $data = static::getDataFromDb();
            static::$map = static::toArray($data, 'name');
        }

        $map = static::$map;
        if($key === null){
            return $map;
        }
        return isset($map[$key]) ? $map[$key] : $def;
    }

    static $fields_data = [];
    public static function getDataFromDb(){
        if(static::$fields_data){
            return static::$fields_data;
        }
        $table = new Fields();
        return static::$fields_data = $table->order('id', 'desc')->select();
    }

    public static function getMapHtml($param = null, $def = []){
        $maps = static::map();
        foreach ($maps as $key => $map) {
            if(is_callable($map)){
                $map = $map();
            } else {
                if(isset($map['value'])){
                    continue;
                }
                if(is_string($map)){
                    $map = [
                        'title' => $map,
                        'type' => 'text',
                        'value' => '',
                    ];
                }
                if(is_array($map)){
                    $map['value'] = static::get($key);
                }
            }
            $maps[$key] = $map;
        }
        if($param === null){
            return $maps;
        }
        return isset($maps[$param]) ? $maps[$param] : $def;
    }
}