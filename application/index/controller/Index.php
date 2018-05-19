<?php
namespace app\index\controller;
use think\Controller;
class Index extends Base
{
    public function index()
    {
    	$bigAd = model('Featured')->getNormalFeatureds(0);
    	$rightAd = model('Featured')->getNormalFeatureds(1);
    	$datas = model('Deal')->getNormalDealByCategoryCityId(1, $this->city->id);
        // 获取4个子分类
        $meishicates = model('Category')->getNormalReCategoryByParentId(1, 4);
        return $this->fetch('',[
            'datas' => $datas,
            'meishicates' => $meishicates,
            'controller' => 'ms',
            'bigAd'=>$bigAd,
            'rightAd'=>$rightAd
        ]);
    }
}
