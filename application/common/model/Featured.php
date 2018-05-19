<?php
namespace app\common\model;
use think\Model;
class Featured extends Base
{
    public function getFeaturedsByType($type) {
        $data = [
            'type' => $type,
            'status' => ['neq', -1],
        ];
        $order = ['id'=>'desc'];

        $result = $this->where($data)
            ->order($order)
            ->paginate();
        return $result;
    }
    public function getNormalFeatureds($type) {
        $data = [
            'type' => $type,
            'status' => 1,
        ];
        $order = ['id'=>'desc'];
        $result = $this->where($data)->order($order)->select();
        return $result;
    }
}