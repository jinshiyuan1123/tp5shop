<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\db;
/**
 * 网站首页控制器
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Index extends Base
{
    public function index()
    {
        $where['status'] = 1;
        $where['categoryIds'] = 1;
    	$goodslist = Db::name('Goods')->where($where)->order('createtime desc')->select();
        $this->assign('goodslist',$goodslist);
        
        $where['status'] = 1;
        $where['categoryIds'] = 2;
    	$gp_goodslist = Db::name('Goods')->where($where)->order('createtime desc')->select();
    	$this->assign('gp_goodslist',$gp_goodslist);
    	// 输出主题
        return $this->themeFetch('index');
    }
}
