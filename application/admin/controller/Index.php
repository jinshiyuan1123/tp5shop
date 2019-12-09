<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;

/**
 * 系统中心控制器
 * @author  完美°ぜ界丶
 */
class Index extends Common
{
    public function index()
    {

        $user_number = Db::name('Users')->field(true)->select();
 
        $user_num    = count($user_number);
        $jh_num  = Db::name('Users')->where('is_jh',1)->count();
        $wjh_num = Db::name('Users')->where('is_jh',0)->count();
        $zjf_num = Db::name('Users')->sum('score');

        $tixian = Db::name('user_withdrawal')->where('status',0)->count();
        $order_num = Db::name('orders')->where('status','paid')->count();
        $this->assign('order_num',$order_num);
        $this->assign('tixian',$tixian);
        $this->assign('jh_num',$jh_num);
        $this->assign('wjh_num',$wjh_num);
        $this->assign('zjf_num',$zjf_num);
        $this->assign('user_num',$user_num);
        return $this->fetch('index');
    }
 
}
