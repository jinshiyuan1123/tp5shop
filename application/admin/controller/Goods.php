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
use think\Loader;
use think\Request;
use common\builder\Form;

/**
 * 商品管理控制器
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Goods extends Common
{
    /**
     * 商品列表
     * @author tangtanglove
     */
    public function index()
    {
        // 搜索词
        $q = input('q');
        if (!empty($q)) {
            $map['a.name'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
        }
        // 筛选文章状态
        $status = input('status');
        if (!empty($status)) {
            $map['a.status'] = $status;
        }
        // 为空赋值
        if(empty($map)) {
            $map = 1;
        }
        // 商品列表
        $goodsList = Db::name('Goods')
        ->where($map)
        ->distinct(true)
        ->order('createtime desc')
        ->paginate(10);

        $this->assign('status',$status);

        $this->assign('goodsList',$goodsList);

        return $this->fetch();
    }

    /**
     * 添加商品
     * @author tangtanglove
     */
    public function goodsadd()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $name           = input('post.name');// 文章名称
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');
            $photo_path_1   = input('post.photo_path_1');
            $num            = input('post.num');// 库存数量
            $sellNum        = input('post.sell_num');// 已经出售的数量
            $price          = input('post.price');// 是否为热销
            $standard       = input('post.standard');// 规格型号
            $categoryIds       = input('post.categoryIds');// 商品分类
  
            if($price<=0) {
                return $this->error('请输入正确的价格！');
            }
 
            $data['name']           = $name;
            $data['uid']            = UID;
            $data['uuid']           = create_uuid();

            $data['content']        = $content;
            $data['cover_path']     = $coverPath;
            $data['photo_path_1']   = $photo_path_1;

            $data['num']            = $num;
            $data['sell_num']       = $sellNum;
            $data['price']          = $price;
            $data['standard']       = $standard;
            $data['categoryIds']    = $categoryIds;

            $data['createtime']     = time();
 
            // 添加数据
            $goodsid = $this->update($data);
            if ($goodsid) {
 
                return $this->success('发布成功！',url('index'));
            } else {
                return $this->error('发布失败！');
            }
        } else {
 
            return $this->fetch();
        }
    }

    /**
     * 编辑商品
     * @author tangtanglove
     */
    public function goodsedit()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $id             = input('post.id');
            $name           = input('post.name');// 文章名称
            $content        = input('post.content');// 文章内容
            $coverPath      = input('post.cover_path');
            $photo_path_1   = input('post.photo_path_1');
            $num            = input('post.num');// 库存数量
            $sellNum        = input('post.sell_num');// 已经出售的数量
            $price          = input('post.price');// 是否为热销
            $standard       = input('post.standard');// 规格型号
            $categoryIds       = input('post.categoryIds');// 商品分类
            if($price<=0) {
                return $this->error('请输入正确的价格！');
            }

            $data['name']           = $name;
            $data['uid']            = UID;
            $data['uuid']           = create_uuid();
            $data['content']        = $content;
            $data['cover_path']     = $coverPath;
            $data['photo_path_1']   = $photo_path_1;
            $data['num']            = $num;
            $data['sell_num']       = $sellNum;
            $data['price']          = $price;
            $data['standard']       = $standard;
            $data['categoryIds']    = $categoryIds;
            $data['createtime']     = time();
            // 添加数据
            $goodsid = $this->update($data,['id'=>$id]);
            if ($goodsid){
                return $this->success('编辑成功！',url('index'));
            } else {
                return $this->error('编辑失败！');
            }
        } else {
            // 更新数据
            $id = input('id');
            if (empty($id)) {
                return $this->error('请选择数据！');
            }
            // 文章信息
            $goodsInfo        = Db::name('Goods')->where('id',$id)->find();
            // 输出赋值
            $this->assign('goodsInfo',$goodsInfo);

            return $this->fetch();
        }
    }

    /**
     * 更新文章
     * @author tangtanglove
     */
    private function update($data,$map = '')
    {
        if (empty($map)) {
            // 新增数据
            $goodsStatus = Db::name('Goods')->insert($data);
            // 执行成功，返回文章id
            return $goodsStatus ? Db::getLastInsID() : false;
        } else {
            // 更新数据
            $goodsStatus = Db::name('Goods')->where($map)->update($data);
            // 执行成功，返回文章id
            return $goodsStatus ? $map['id'] : false;
        }
    }

    /**
     * 设置文章状态
     * @author tangtanglove
     */
    public function setstatus()
    {
        $status  = input('status');
        $goodsids = input('ids/a');
        if ($status == 'delete') {
            // 清空Goods表
            $goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->delete();
        } else {
            $goodsResult = Db::name('Goods')->where('id','in',implode(',', $goodsids))->update(['status' => $status]);
        }

        if ($goodsResult) {
            return $this->success('操作成功！');
        } else {
            return $this->error('操作失败！');
        }
    }

}
