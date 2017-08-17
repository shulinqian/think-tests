<?php
namespace app\tests\model;

use think\Model;
use app\tests\common\libs\MockConfig;

class Apis extends Model {

    protected $table = 'dev_apis';

    public function offsetGet($name)
    {
        return $this->$name;
    }

    public function __get($key){
        switch ($key){
            case 'args_show':
                return $this->args_se ? unserialize($this->args_se) : [];
                break;
            case 'fields_array':
                return $this->fields_se ? unserialize($this->fields_se) : ['title'];
            case 'fields_show':
                $fields = $this->fields_array;
                if(!$fields){
                    return [];
                }
                $rs = [];
                foreach ($fields as $key => $field) {
                    $rs[$key] = [
                        'field' => $field,
                        'config' => MockConfig::getMapHtml($field)
                    ];
                }
                return $rs;
                break;
            case 'args_se_br':
                return str_replace("\n", '<br />', $this->args_se);
            case 'result_show':
                $fields = $this->fields_array;
                if(!$fields){
                    return [];
                }
                $rs = [];
                foreach ($fields as $key => $field) {
                    $rs[$field] = MockConfig::get($field);
                }

                switch ($this->return_type){
                    case 'do':
                        return [
                            'status' => 'success',
                            'message' => '操作成功',
                            'data' => $rs
                        ];
                    case 'search':
                        $rsMiti = [];
                        for ($i=0; $i<2; $i++){
                            $rsMiti[] = $rs;
                        }
                        return [
                            'total' => count($rsMiti),
                            'data' => $rsMiti
                        ];
                    case 'list':
                        $rsMiti = [];
                        for ($i=0; $i<2; $i++){
                            $rsMiti[] = $rs;
                        }
                        return $rsMiti;
                    default:
                        return $rs;
                }
                break;
        }

        return parent::__get($key);
    }

    public function isMuti(){
        $keys = ['search', 'list'];
        if(in_array($this->return_type, $keys)){
            return true;
        }
    }
}