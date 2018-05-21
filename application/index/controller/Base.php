<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    public $city = '';
    public function _initialize() {
        // 城市数据
        $citys = model('City')->getNormalCitys();
        //用户数据
        $this->getCity($citys);
        // 获取首页分类的数据
        $cats = $this->getReCategorys();
        $this->assign('citys', $citys);
        $this->assign('city', $this->city);
        $this->assign('cats', $cats);
        //获取控制器名 加载相应css
        $this->assign('controler', strtolower(request()->controller()));
        $this->assign('user', $this->getLoginUser());
        $this->assign('title', 'o2o团购网');
    }

    public function getCity($citys) {
        foreach($citys as $city) {
            $city = $city->toArray();
            if($city['is_default'] == 1) {
                $defaultuname = $city['uname'];
                break;
            }
        }
        $defaultuname = $defaultuname ? $defaultuname : 'nanchang';
        if(session('cityuname', '', 'nuomi') && !input('get.city')) {
            $cityuname = session('cityuname', '', 'nuomi');
        }else {
            $cityuname = input('get.city', $defaultuname, 'trim');
            session('cityuname', $cityuname, 'nuomi');
        }

        $this->city = model('City')->where(['uname'=>$cityuname])->find();
    }

    public function getLoginUser() {
        $user = session('user', '', 'nuomi');
        return $user;
    }

    /**
     * 获取首页推荐当中中的商品分类数据
     */
    public function getReCategorys() {
        $parentIds = $sedcatArr = $recomCats = [];
        $cats = model('Category')->getNormalReCategoryByParentId(0,5);
        foreach($cats as $cat) {
            $parentIds[] = $cat->id;
        }
        // 获取二级分类的数据
        foreach ($parentIds as $pid) {
            $sedCats[] = model('Category')->getCategorysByParentId($pid);
        }
        foreach($sedCats as $sedcat) {
            foreach ($sedcat as $value) {
                    $sedcatArr[$value->parent_id][] = [
                        'id' => $value->id,
                        'name' => $value->name,
                    ];
            }
        }
        foreach($cats as $cat) {
            // recomCats 代表是一级 和 二级数据，  []第一个参数是 一级分类的name, 第二个参数 是 此一级分类下面的所有二级分类数据
            $recomCats[$cat->id] = [
                'name'=>$cat->name, 
                'se'=>empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id],
            ];
        }
        return $recomCats;
    }
}
