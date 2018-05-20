<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\User;
class Index extends Base
{
    public function index()
    {
    	$bigAd = model('Featured')->getNormalFeatureds(0);
    	$rightAd = model('Featured')->getNormalFeatureds(1);
        $meishi_datas = model('Deal')->getNormalDealByCategoryCityId(1, $this->city->id);
        $xiuxian_datas = model('Deal')->getNormalDealByCategoryCityId(3, $this->city->id);
        // 获取4个子分类
        $meishicates = model('Category')->getNormalReCategoryByParentId(1, 4);
        $xiuxiancates = model('Category')->getNormalReCategoryByParentId(3, 4);
        $datas = [
            'meishi_datas'=>[
                'h3'=>'美食推荐',
                'data'=>$meishi_datas,
                'cates'=>$meishicates,
            ],
            'xiuxian_datas'=>[
                'h3'=>'休闲生活',
                'data'=>$xiuxian_datas,
                'cates'=>$xiuxiancates,
            ],
        ];
        return $this->fetch('',[
            'datas' => $datas,
            'controller' => 'ms',
            'bigAd'=>$bigAd,
            'rightAd'=>$rightAd
        ]);
    }
    public function a () {
        $userM = new User;
        $user = $userM->where(array('id'=>1))->find();
        session('user', $user, 'nuomi');
        //var_dump($new->username);die();
    }

    public function b() {
         $user = session('user','', 'nuomi');
         //$user = unserialize($user);
         var_dump($user);die();
         var_dump($user->username);
    }
}
