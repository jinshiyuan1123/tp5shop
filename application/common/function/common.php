<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

use think\Db;

/**
 * 系统公共库文件
 * 主要定义系统公共函数库
 */

/**
 * 系统根目录
 */
function root_path()
{
    return __ROOT__;
}   

/**
 * 创建盐
 * @author tangtanglove <dai_hang_love@126.com>
 */
function create_salt($length=-6)
{
    return $salt = substr(uniqid(rand()), $length);
}

/**
 * 创建uuid,系统内唯一标识符
 * @author tangtanglove <dai_hang_love@126.com>
 */
function create_uuid()
{
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);// "-"
    $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
    return $uuid;
}

/**
 * 获取uuid,系统内唯一标识符
 * @author tangtanglove <dai_hang_love@126.com>
 */
function get_uuid($model,$map)
{
    return Db::name($model)->where($map)->value('uuid');
}

/**
 * minishop md5加密方法
 * @author tangtanglove <dai_hang_love@126.com>
 */
function minishop_md5($string,$salt)
{
	return md5(md5($string).$salt);
}

/**
 * 获取用户信息
 * @author  tangtanglove
 */
function get_userinfo($uid = '',$field = '')
{
    if (empty($uid)) {
        $uid = session('user_auth.uid');
    }
    // 查询用户信息
    $userInfo = Db::name('Users')->where(['id'=>$uid,'status'=>1])->cache(true)->find();
    if ($field) {
        return $userInfo[$field];
    } else {
        return $userInfo;
    }
}

/**
 * 获取分类信息
 * @author  tangtanglove
 */
function get_termsinfo($id = '',$field = 'name')
{
    return Db::name('Terms')->where(['id'=>$id])->cache(true)->value($field);
}

/**
 * 获取文章所属分类或tags
 * @author  tangtanglove
 */
function get_posts_terms($postid = '',$type = 'category')
{
    // 列表数据
    $list = Db::name('TermRelationships')
    ->alias('a')
    ->join('term_taxonomy b','b.id = a.term_taxonomy_id','LEFT')
    ->join('terms c','c.id = b.term_id','LEFT')
    ->where(['a.object_id'=>$postid,'b.taxonomy'=>$type])
    ->field('b.id,c.name')
    ->cache(true)
    ->select();
    $text = '';
    if (!empty($list)) {
        foreach ($list as $key => $value) {
            $text = $text.$value['name'].',';
        }
    } else {
        $text = '—';
    }
    return trim($text,',');
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 获取菜单分类信息
 * @author  tangtanglove
 */
function get_menusinfo($id = '',$field = 'title')
{
    return Db::name('Menu')->where(['id'=>$id])->cache(true)->value($field);
}

/**
 * 获取当前文章状态 'publish','pending','draft','trash'
 * @author  tangtanglove
 */
function get_posts_status($postStatus)
{
    switch ($postStatus) {
        case 'publish':
            $result = '已发布';
            break;
        case 'pending':
            $result = '待审';
            break;
        case 'draft':
            $result = '草稿';
            break;
        case 'trash':
            $result = '回收站';
            break;
        default:
            $result = '无';
            break;
    }
    return $result;
}

/**
 * 获取用户状态 'forbid','start','delete'
 * @author 完美°ぜ界丶
 */
function get_user_status($userStatus)
{
    switch ($userStatus) {
        case '2':
            $result = '禁用';
            break;
        case '1':
            $result = '正常';
            break;
        case '-1':
            $result = '删除';
            break;
        default:
            $result = '无';
            break;
    }
    return $result;
}

/**
 * 获取后台菜单选中状态
 * @author  tangtanglove
 */
function get_menu_navbar_active($menuid)
{
    // 查询信息
    $menuInfo = Db::name('Menu')->where(['id'=>$menuid])->cache(true)->find();
    if (empty($menuInfo['pid'])) {
        // 根节点
        $result = Db::name('Menu')->where(['pid'=>$menuid])->where('instr(\''.$_SERVER['REQUEST_URI'].'\',`url`)>0')->cache(true)->find();
        if ($result) {
            return 'active';
        }
    } else {
        if ($_SERVER['REQUEST_URI'] === url($menuInfo['url'])) {
            return 'active';
        }
    }
}

/**
 * 获取用户组的状态,1正常,-1禁用
 * @param  [int] $status [状态值]
 * @author vaey
 */
function get_group_status($status)
{
    if($status==1){
        return '<span class="label label-success">正常</span>';
    }elseif($status==-1){
        return '<span class="label label-danger">禁用</span>';
    }
}

/**
 * 获取文章单一封面
 * @author tangtanglove
 */
function get_posts_cover($uuid)
{
    // 查询数据
    $map['uuid'] = $uuid;
    $map['name'] = 'cover_path_1';
    $postsCover  = Db::name('KeyValue')->where($map)->value('value');
    if($postsCover){
        return __ROOT__.str_replace('./','/',$postsCover);
    }else{
        $path = config('theme_path').'/index/images/irc_defaut.png';
        return str_replace('./','/',$path);
    }
    
}

//裁剪图片
function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
{
    $pic_width = imagesx($im);
    $pic_height = imagesy($im);
     
    if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
    {
        if($maxwidth && $pic_width>$maxwidth)
        {
            $widthratio = $maxwidth/$pic_width;
            $resizewidth_tag = true;
        }
 
        if($maxheight && $pic_height>$maxheight)
        {
            $heightratio = $maxheight/$pic_height;
            $resizeheight_tag = true;
        }
 
        if($resizewidth_tag && $resizeheight_tag)
        {
            if($widthratio<$heightratio)
            $ratio = $widthratio;
            else
            $ratio = $heightratio;
        }
 
        if($resizewidth_tag && !$resizeheight_tag)
        $ratio = $widthratio;
        if($resizeheight_tag && !$resizewidth_tag)
        $ratio = $heightratio;
 
        $newwidth = $pic_width * $ratio;
        $newheight = $pic_height * $ratio;
 
        if(function_exists("imagecopyresampled"))
        {
            $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
            imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
        }
        else
        {
            $newim = imagecreate($newwidth,$newheight);
            imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
        }
     
        $name = $name.$filetype;
        imagejpeg($newim,$name);
        imagedestroy($newim);
    }
    else
    {
       $name = $name.$filetype;
       imagejpeg($im,$name);
    }
}

//获取缩略封面图
function get_thumb($uuid,$width='600',$height='400'){
    $map['uuid'] = $uuid;
    $map['name'] = 'cover_path_1';
    $img  = Db::name('KeyValue')->where($map)->value('value');  
    $img = ".".$img;     
    //截取
    $imgname = substr($img,27,32);
    
    $path = './uploads/thumb/'.$imgname;
    $filetype = substr($img,-4,4);;//图片类型
    
    if(is_file($path.$filetype)){ //存在
        return $path.$filetype;
    }else{ //不存在
        if($filetype=='.jpg'||$filetype=='.JPG'){
            $im = imagecreatefromjpeg($img);//参数是图片的存方路径
        }else if($filetype=='.png'||$filetype=='.PNG'){
            $im = imagecreatefrompng($img);//参数是图片的存方路径
        }else if($filetype=='.gif'||$filetype=='.GIF'){
            $im = imagecreatefromgif($img);//参数是图片的存方路径
        }   
        
        $maxwidth = $width;//设置图片的最大宽度
        $maxheight = $height;//设置图片的最大高度
        $name = $path;//图片的名称，随便取吧
        
        resizeImage($im,$maxwidth,$maxheight,$name,$filetype);//调用裁剪函数
        return $path.$filetype;
    }
}

/**
 * 权限判断，设置菜单对某个用户是否可见
 * @author vaey
 * @param  [type] $ruleId      [当前菜单id]
 * @param  [type] $rules       [权限id组]
 * @return [type]              [description]
 */
function check_menu_auth($ruleId,$rules)
{   
    //权限判断
    if(is_array($rules)){
        if(!in_array($ruleId,$rules)){
            return false;
        }else{
            return true;
        }
    }else{
        if($rules == 1){ //超级管理员，拥有所有权限
            return true;
        }else{
            return false;
        }
    }

}

/**
 * 获取当前用户权限，控制菜单对某个用户是否显示
 * @author vaey
 * @return [type] [description]
 */
function get_menu_auth()
{
    //查询当前登录用户的uuid
    $uuid           = Db::name('Users')->where('id',UID)->value('uuid');
    $keyValue       = Db::name('KeyValue')->where('uuid',$uuid)->find();
    if($keyValue && $keyValue['value']==1){
        //超级管理员，直接返回
        return 1; //拥有所有权限
    }
    //获取当前登录用户所在的用户组(可以是多组)
    $group          = Db::name('UserGroupAccess')->where('uid',UID)->select();
    if(!$group){
        return 2; //没有任何权限
    }
    //所有权限数组
    $rules_array = [];
    $arr = [];
    foreach ($group as  $v) {
        $rules = Db::name('UserGroup')->where('id',$v['group_id'])->where('status',1)->value('rules');
        if($rules){
            $arr = explode(',',$rules);
        }
        $rules_array = array_merge($rules_array, $arr);  
    }
    //去除重复值
    $rules_array = array_unique($rules_array);
    return $rules_array;
}    
	

/**
 * 手机列表页面适配器
 * @author tangtanglove
 */
function wap_list_adapter($data,$showType = 'one_cover')
{
    foreach ($data as $key => $value) {
        $data[$key]['updatetime'] = date('Y-m-d H:i:s',$value['updatetime']);
        $data[$key]['createtime'] = date('Y-m-d H:i:s',$value['createtime']);
        $data[$key]['nickname']   = get_userinfo($value['uid'],'nickname');
        $coverList = select_key_value('posts.cover',$value['uuid']);
        // 获取封面数量
        $coverNum = count($coverList);
        if($coverNum)
        {
            switch ($showType) {
                case 'one_cover':
                    // 单图模式
                    $data[$key]['cover_path_1'] = create_thumb('.'.$coverList['cover_path_1'],'',200,110,3);
                    $data[$key]['cover_path_1'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_1']);
                    break;
                
                default:
                    // 默认程序自动判断
                    if(3<=$coverNum) {
                        $data[$key]['cover_path_1'] = create_thumb('.'.$coverList['cover_path_1'],'',200,110,3);
                        $data[$key]['cover_path_1'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_1']);

                        $data[$key]['cover_path_2'] = create_thumb('.'.$coverList['cover_path_2'],'',200,110,3);
                        $data[$key]['cover_path_2'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_2']);

                        $data[$key]['cover_path_3'] = create_thumb('.'.$coverList['cover_path_3'],'',200,110,3);
                        $data[$key]['cover_path_3'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_3']);
                    } else {
                        $data[$key]['cover_path_1'] = create_thumb('.'.$coverList['cover_path_1'],'',200,110,3);
                        $data[$key]['cover_path_1'] = str_replace('./', 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/', $data[$key]['cover_path_1']);
                    }
                    break;
            }
        }
    }
    return $data;
}

/**
 * 手机详情页面适配器
 * @author tangtanglove
 */
function wap_detail_adapter($data)
{
    $data['createtime'] = date('Y-m-d H:i:s',$data['createtime']);
    //内容图片生成适应手机图片
    $data['content']    = create_mobile_thumb($data['content'],350,'');
    //内容图片加域名
    $data['content']    = replace_image_url($data['content'],'http://'.$_SERVER['HTTP_HOST'].__ROOT__);
    return $data;
}


/**
 * 生成缩略图
 * @author tangtanglove
 * @param string $image_path 图片路径
 * @param string $thumb_path 缩略图路径
 */
function create_thumb($image_path,$thumb_path,$width,$height,$thumb_type = 1)
{
    if (empty($image_path)) {
        $this->error('图片路径不能为空！');
    }

    if (empty($thumb_path)) {
        //如果不定义缩略图路径，则以thumb_+原图片名命名
        $list = explode('/', $image_path);
        $key = count($list)-1;
        //定义缩略图名称
        $thumb_name = 'thumb_'.$list[$key];
        $thumb_path = str_replace($list[$key],'',$image_path).$thumb_name;
    }

    if (is_file($image_path)) {
        //不存在缩略图则创建
        if (!is_file($thumb_path)) {
            import('org.org.Image');
            $image = \org\Image::open($image_path);
            $image->thumb($width, $height,$thumb_type)->save($thumb_path);
        }
        return $thumb_path;
    }else{
        return $image_path;
    }

}

/**
 * 内容图片生成适应手机图片
 * @author tangtanglove
 * @param string $image_path 图片路径
 * @param string $thumb_path 缩略图路径
 */
function create_mobile_thumb($content,$width,$height)
{
    $preg_str = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($preg_str,$content,$match);
    foreach ($match[1] as $key => $value) {
        $content_mobile_thumb = create_thumb('.'.$value,'',$width,$height,1);
        $content = str_replace($value,trim($content_mobile_thumb,'.'),$content);
    }
    return $content;
}

/** 
 * 替换内容中的图片 添加域名 
 * @param  string $content 要替换的内容 
 * @param  string $strUrl 内容中图片要加的域名 
 * @return string   
 */  
function replace_image_url($content = null, $strUrl = null) {
    if ($strUrl) {  
        //提取图片路径的src的正则表达式 并把结果存入$matches中    
        preg_match_all("/<img(.*)src=\"([^\"]+)\"[^>]+>/isU",$content,$matches);  
        $img = "";    
        if(!empty($matches)) {    
        //注意，上面的正则表达式说明src的值是放在数组的第三个中    
        $img = $matches[2];    
        }else {    
            $img = "";    
        }  
        if (!empty($img)) {    
            $patterns= array();    
            $replacements = array();    
            foreach($img as $imgItem){
                $final_imgUrl = $strUrl.$imgItem;
                //如果不包含http://则认为为远程图片
                if (!(strpos($imgItem, 'http://') !== false)) {
                    $replacements[] = $final_imgUrl;
                    $img_new = "/".preg_replace("/\//i","\/",$imgItem)."/";
                    $patterns[] = $img_new;
                }
            }    

            //让数组按照key来排序
            ksort($patterns);    
            ksort($replacements);    

            //替换内容    
            $vote_content = preg_replace($patterns, $replacements, $content);  
        
            return $vote_content;  
        }else {  
            return $content;  
        }                     
    } else {  
        return $content;  
    }  
}

/**
 * 订单状态
 */
function get_order_status($order_id)
{
    if(empty($order_id)){
        return false;
    }
    $map['id'] = $order_id;
    $status = Db::name('orders')->where($map)->value('status');
  
    return $status;
}

/**
 * 获取用户订单数量
 * @param  $[status]  [string]  [<订单状态，不填则获取全部订单数量>]
 * @return $[number]  [num]     [<返回该状态的订单数量>]
 */
function get_user_order_num($status=null){
    if (!empty($status)) {
        $map['status'] = $status;
    }else{
        $map['status'] = array('not in',['cancel','delete']);
    }
    $map['uid'] = UID;
    $number = Db::name('Orders')->where($map)->count();
    if($number){
        return $number;
    }else{
        return null;
    }
}
 

/**
 * 支付类型
 */
function get_pay_type()
{
    $pay_type = array(
            'alipay' =>'支付宝',
            'wxpay'  =>'微信',
    );
    return $pay_type;
}

/**
 * 获取用户未评价订单数量 
 * @return $[number]  [num]     [<返回该状态的订单数量>]
 */
function get_user_uncomment_order_num(){
    $map['a.uid']        = UID;
    $map['a.status']     = "completed";
    $number = Db::name('Orders')->alias('a')->join('orders_goods b','b.order_id= a.id','LEFT')
                ->where($map)->count();
    if($number){
        return $number;
    }else{
        return null;
    }
}

/** 
 * 加载接口配置
 * @param  string $name   配置接口名称 
 */
 function load_config(){
    
    $list = Db::name('Apiconfig')->select();
         
    foreach ($list as $key => $value) {
        // config('配置参数','配置值');
        config($value['key'],$value['value']);
    }    
} 


/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 根据自己的分类pid，获取所有同级分类
 * @return [type] [description]
 */
function get_self_category($pid){
    $category = 
    Db::name('TermTaxonomy')
    ->alias('a')
    ->join('terms b','b.id= a.term_id','LEFT')
    ->where('pid',$pid)->select();
    return $category;
}

/**
 * 根据自己的分类pid，获取上级分类
 * @return [type] [description]
 */
function get_parent_category($pid,$item){
    $category = 
    Db::name('TermTaxonomy')
    ->alias('a')
    ->join('terms b','b.id= a.term_id','LEFT')
    ->where('a.id',$pid)->find();
    if($item){
        return $category[$item];
    }else{
        return $category;
    }    
}

//获取上一篇
function get_pre($id,$cid){
    $map['term_taxonomy_id'] = $cid;
    $map['object_id'] = array('lt',$id);
    $data = Db::name('TermRelationships')->where($map)->order('object_id desc')->find();
    if($data){
        $info = Db::name('Posts')->where('id',$data['object_id'])->find();
        if($info){
            $url = url('Article/detail?id='.$info['id'].'&category='.$cid);
            return "<a href='".$url."'>".$info['title']."</a>";
        }else{
            return "没有了!";
        }
    }else{
        return "没有了!";
    }
}
//获取下一篇
function get_next($id,$cid){
    $map['term_taxonomy_id'] = $cid;
    $map['object_id'] = array('gt',$id);
    $data = Db::name('TermRelationships')->where($map)->order('object_id asc')->find();
    if($data){
        $info = Db::name('Posts')->where('id',$data['object_id'])->find();
        if($info){
            $url = url('Article/detail?id='.$info['id'].'&category='.$cid);
            return "<a href='".$url."'>".$info['title']."</a>";
        }else{
            return "没有了!";
        }
    }else{
        return "没有了!";
    }
}

/**
 * 根据自身父id ，获取同级所有page
 * @return [type] [description]
 */
function get_self_page($pid){
    $map['type']    = "page";
    $map['pid']     = $pid;
    $data = Db::name('Posts')->where($map)->order('level asc')->select();
    return $data;
}

/**
 * 获取商品收藏总数
 * @return [type] [description]
 */
function get_collection_count($id){
    if($id){
        $count = Db::name('GoodsCollection')->where(['goods_id'=>$id])->count();
        return $count;
    }else{
        return 0;
    }
    
}

/**
 * 获取当前用户是否收藏了该商品，返回图标
 * @return [type] [description]
 */
function get_collection_ico($id){
    if($id){
        $uid = session('index_user_auth.uid');
        if($uid){
            $info = Db::name('GoodsCollection')->where(['goods_id'=>$id,'uid'=>$uid])->find();
            if($info){
                return 'collection_big.png';
            }else{
                return "collectionone.png";
            }
        }
        return "collectionone.png";
    }else{
        return "collectionone.png";
    }
    
}

/**
 * 获取key_value表中的扩展字段的值
 * @param  string   $uuid      uuid
 * @param  string   $name      字段的名称
 * @return $value   该字段的值
 */
function get_key_value($uuid,$name){
    if(empty($uuid)||empty($name)){
        return false;
    }
    $map['uuid'] = $uuid;
    $map['name'] = $name;
    $value = Db::name('key_value')->where($map)->value('value');
    return $value;
}

/**
 * 将时间转换为时间戳
 * @return int 时间戳
 * @author huajie <banhuajie@163.com>
 */
function getFormatTime($time){
    if(empty($time)){
        return 0;
    }
    return strtotime($time);
}

/**
 * 将时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 生成二维码
 * @author tangtanglove
 */
function qrcode($data,$path = '')
{
    import('org.util.phpqrcode.phpqrcode');
    if(empty($data)) {
        return '参数错误';
    }
    if(empty($path)) {
        $path = './uploads/qrcode/qrcode.png';
    }
    \QRcode::png($data, $path ,'L' ,12,0);
    return $path;
}

/**
 * 获取产品生产基地信息
 * @param   int        $id      基地id
 * @param   string     $field   要获取的数据库字段名,默认为name
 * @return  string     $result  相应数据库字段的值
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_goods_base_info($id,$field="name"){
    if(empty($id)){
        return false;
    }
    $model = Db::name('source_goodsbase');
    $map['id'] = $id;
    $result = $model->where($map)->find();
    if($result){
        return $result[$field];
    }else{
        return false;
    }
}

/**
 * 获取产品分类信息
 * @param   int        $id      分类id
 * @param   string     $field   要获取的数据库字段名,默认为name
 * @return  string     $result  相应数据库字段的值
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_goods_cate_info($id,$field="name"){
    if(empty($id)){
        return false;
    }

    $model = Db::name('goods_cate');
    $map['id'] = $id;
    $result = $model->where($map)->find();
    
    if($result){
        return $result[$field];
    }else{
        return false;
    }
}

/**
 * 获取产品加工操作信息
 * @param   int        $id      加工列表id 
 * @return  array      $list    商品的加工操作列表
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_source_goods_form_list($id){
    if(empty($id)){
        return false;
    }

    $model = Db::name('source_goods_form');
    $map['goods_form_cate_id'] = $id;
    $result = $model->where($map)->select();
    
    if($result){
        return $result;
    }else{
        return false;
    }
}

// 乐丫单独定制解析select里value
function string_to_select($value,$select='')
{
    $arr = explode(",",$value);
    $string = '';
    foreach ($arr as $key => $value) {
        $arr1 = explode(":",$value);
        $selectString = '';
        if(!empty($select)) {
            if($select == $arr1[0]) {
                $selectString = 'selected=\"selected\"';
            }
        }
        $string = $string."<option ".$selectString." value='$arr1[0]'>$arr1[1]</option>";
    }
    return $string;
}

// 乐丫单独定制解析select里value
function string_to_select_index($value,$select='')
{
    $arr = explode(",",$value);    
    $selectString = '';  
    foreach ($arr as $key => $value) {
        $arr1 = explode(":",$value);
        
        if(!empty($select)) {
            if($select == $arr1[0]) {
                $selectString = $arr1[1];
            }
        }
    }    
    return $selectString;
}

/**
 * 获取产品信息
 * @param   int        $id      产品id 
 * @return  string     $string    产品信息
 * @author  矢志bu渝   <15176659527@163.com>
 */
function get_goods_info($id,$field="name"){
    if(empty($id)){
        return false;
    }
    $model = Db::name('goods');
    $map['id'] = $id;
    $info = $model->where($map)->find();
    
    if($info){
        return $info[$field];
    }else{
        return false;
    }
}


//生成微信code二维码

function get_wx_code($num){
        
    if($num){
        $appid = config('wechat_appid');
        $appsecret = config('wechat_appsecret');
        $access_token = getAccessToken($appid,$appsecret); //获取token

        //二维码参数
        $qrcode = '{"action_name": "QR_LIMIT_SCENE","action_info":{"scene":{"scene_id":'.$num.'}}}';
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
        $result = https_request($url,$qrcode);
        $jsoninfo = json_decode($result,true);
        $ticket = $jsoninfo['ticket'];

        $code_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;

        return $code_url;

    }else{
        return "参数错误";
    }
}

/**
 * 获取通用accessToken
 * @author vaey
 * @param  [type] $appid     [appid]
 * @param  [type] $appsecret [appsecret]
 * @return [type]            [accessToken]
 */
function getAccessToken($appid,$appsecret)
{
    // access_token 应该全局存储与更新，以下代码以写入到文件中
    
    $data = json_decode(file_get_contents("access_token.json"));
    if($data->expire_time < time()){ //token过期，重获
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
            $res = json_decode(https_request($url));
            $access_token = $res->access_token;
            if($access_token){
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
    }else{
        $access_token = $data->access_token;
    }
    return $access_token;
}

/**
 * 模拟提交数据，获得返回值
 * @author vaey
 * @param  [type] $url  [description]
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function https_request($url,$data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}


function friends_x9($uid,$type=0){//所有九级树
        
        $users = Db::name("Users")->where('reid',$uid)->field('id,last_login,reid,nickname,mobile,is_jh')->select();
        $list=$users;
        foreach ($users as $key1 => &$v1) {
            $v1['xj'] = Db::name("Users")->where('reid',$v1['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
            $v1['zhdl'] = time2Units(time()-$v1['last_login']);
            $user_money_log= Db::name('user_money_log')->where('dfuid',$v1['id'])->where('type',1)->where('uid',$uid)->find();
            $v1['ljfl'] = $user_money_log['amount'];
            $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v1['id'])->where('status',1)->find();
            if(empty($user_scoreorder)){
                $v1['paytime']=0;
            }else{
                $v1['paytime']=$user_scoreorder['paytime'];
            }

            $list=array_merge($list,$v1['xj']); 

            foreach ($v1['xj'] as $key2 => &$v2) {
                $v2['xj'] = Db::name("Users")->where('reid',$v2['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                $v2['zhdl'] = time2Units(time()-$v2['last_login']);
                $user_money_log= Db::name('user_money_log')->where('dfuid',$v2['id'])->where('type',1)->where('uid',$uid)->find();
                $v2['ljfl'] = $user_money_log['amount'];
                $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v2['id'])->where('status',1)->find();
                if(empty($user_scoreorder)){
                    $v2['paytime']=0;
                }else{
                    $v2['paytime']=$user_scoreorder['paytime'];
                }
                $list=array_merge($list,$v2['xj']);
                foreach ($v2['xj'] as $key3 => &$v3) {
                    $v3['xj'] = Db::name("Users")->where('reid',$v3['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                    $v3['zhdl'] = time2Units(time()-$v3['last_login']);
                    $user_money_log= Db::name('user_money_log')->where('dfuid',$v3['id'])->where('type',1)->where('uid',$uid)->find();
                    $v3['ljfl'] = $user_money_log['amount'];
                    $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v3['id'])->where('status',1)->find();
                    if(empty($user_scoreorder)){
                        $v3['paytime']=0;
                    }else{
                        $v3['paytime']=$user_scoreorder['paytime'];
                    }
                    $list=array_merge($list,$v3['xj']);
                    foreach ($v3['xj'] as $key4 => &$v4) {
                        $v4['xj'] = Db::name("Users")->where('reid',$v4['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                        $v4['zhdl'] = time2Units(time()-$v4['last_login']);
                        $user_money_log= Db::name('user_money_log')->where('dfuid',$v4['id'])->where('type',1)->where('uid',$uid)->find();
                        $v4['ljfl'] = $user_money_log['amount'];
                        $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v4['id'])->where('status',1)->find();
                        if(empty($user_scoreorder)){
                            $v4['paytime']=0;
                        }else{
                            $v4['paytime']=$user_scoreorder['paytime'];
                        }
                        $list=array_merge($list,$v4['xj']);
                        foreach ($v4['xj'] as $key5 => &$v5) {
                            $v5['xj'] = Db::name("Users")->where('reid',$v5['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                            $v5['zhdl'] = time2Units(time()-$v5['last_login']);
                            $user_money_log= Db::name('user_money_log')->where('dfuid',$v5['id'])->where('type',1)->where('uid',$uid)->find();
                            $v5['ljfl'] = $user_money_log['amount'];
                            $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v5['id'])->where('status',1)->find();
                            if(empty($user_scoreorder)){
                                $v5['paytime']=0;
                            }else{
                                $v5['paytime']=$user_scoreorder['paytime'];
                            }
                            $list=array_merge($list,$v5['xj']);
                            foreach ($v5['xj'] as $key6 => &$v6) {
                                $v6['xj'] = Db::name("Users")->where('reid',$v6['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                                $v6['zhdl'] = time2Units(time()-$v6['last_login']);
                                $user_money_log= Db::name('user_money_log')->where('dfuid',$v6['id'])->where('type',1)->where('uid',$uid)->find();
                                $v6['ljfl'] = $user_money_log['amount'];
                                $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v6['id'])->where('status',1)->find();
                                if(empty($user_scoreorder)){
                                    $v6['paytime']=0;
                                }else{
                                    $v6['paytime']=$user_scoreorder['paytime'];
                                }
                                $list=array_merge($list,$v6['xj']);
                                foreach ($v6['xj'] as $key7 => &$v7) {
                                    $v7['xj'] = Db::name("Users")->where('reid',$v7['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                                    $v7['zhdl'] = time2Units(time()-$v7['last_login']);
                                    $user_money_log= Db::name('user_money_log')->where('dfuid',$v7['id'])->where('type',1)->where('uid',$uid)->find();
                                    $v7['ljfl'] = $user_money_log['amount'];
                                    $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v7['id'])->where('status',1)->find();
                                    if(empty($user_scoreorder)){
                                        $v7['paytime']=0;
                                    }else{
                                        $v7['paytime']=$user_scoreorder['paytime'];
                                    }
                                    $list=array_merge($list,$v7['xj']);
                                    foreach ($v7['xj'] as $key8 => &$v8) {
                                        $v8['xj'] = Db::name("Users")->where('reid',$v8['id'])->field('id,last_login,reid,nickname,mobile,is_jh')->select();
                                        $v8['zhdl'] = time2Units(time()-$v8['last_login']);
                                        $user_money_log= Db::name('user_money_log')->where('dfuid',$v8['id'])->where('type',1)->where('uid',$uid)->find();
                                        $v8['ljfl'] = $user_money_log['amount'];
                                        $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v8['id'])->where('status',1)->find();
                                        if(empty($user_scoreorder)){
                                            $v8['paytime']=0;
                                        }else{
                                            $v8['paytime']=$user_scoreorder['paytime'];
                                        }
                                        $list=array_merge($list,$v8['xj']);
                                        foreach ($v8['xj'] as $key9 => &$v9) {
                                            $v9['zhdl'] = time2Units(time()-$v9['last_login']);
                                            $user_money_log= Db::name('user_money_log')->where('dfuid',$v9['id'])->where('type',1)->where('uid',$uid)->find();
                                            $v9['ljfl'] = $user_money_log['amount'];
                                            $user_scoreorder= Db::name('user_scoreorder')->where('uid',$v9['id'])->where('status',1)->find();
                                            if(empty($user_scoreorder)){
                                                $v9['paytime']=0;
                                            }else{
                                                $v9['paytime']=$user_scoreorder['paytime'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } 
        if($type==1){
            return $list;
        }else{
            return $users; 
        }
        
}
/**
 * 时间差计算
 *
 */
function time2Units ($time)
{
   $year   = floor($time / 60 / 60 / 24 / 365);
   $time  -= $year * 60 * 60 * 24 * 365;
   $month  = floor($time / 60 / 60 / 24 / 30);
   $time  -= $month * 60 * 60 * 24 * 30;
   $week   = floor($time / 60 / 60 / 24 / 7);
   $time  -= $week * 60 * 60 * 24 * 7;
   $day    = floor($time / 60 / 60 / 24);
   $time  -= $day * 60 * 60 * 24;
   $hour   = floor($time / 60 / 60);
   $time  -= $hour * 60 * 60;
   $minute = floor($time / 60);
   $time  -= $minute * 60;
   $second = $time;
   $elapse = '';

   $unitArr = array('年'  =>'year', '个月'=>'month',  '周'=>'week', '天'=>'day',
                    '小时'=>'hour', '分钟'=>'minute', '秒'=>'second'
                    );

   foreach ( $unitArr as $cn => $u )
   {
       if ( $$u > 0 )
       {
           $elapse = $$u . $cn;
           break;
       }
   }

   return $elapse;
}
/*
 * 返利
 */
function jihuofanli($uid){
    exit;
    config(select_key_value('config.base'));
    $fanli_a=array(config('web_fanli_1'),config('web_fanli_2'),config('web_fanli_3'),config('web_fanli_4'),config('web_fanli_5'),config('web_fanli_6'),config('web_fanli_7'),config('web_fanli_8'),config('web_fanli_9'));
    $buid=$uid;
    for ($i=0; $i < 9; $i++) {
    	$user_info = Db::name('Users')->where(['id'=>$buid])->find();
        $user = Db::name('Users')->where(['id'=>$user_info['reid']])->find();
        if($user){
	    Db::startTrans();
            $user_up=DB::name('Users')->where(['id'=>$user['id']])->update(['amount' => ['exp','amount+'.$fanli_a[$i]]]);//增加余额
            $data['uid']    = $user['id'];
            $data['dfuid']    = $uid;
            $data['amount'] = $fanli_a[$i];
            $data['type']   = 1;
            $data['info']   = '好友激活返利';
            $data['addtime']=time();
            $ordersStatusResult = Db::name('user_money_log')->insert($data);
	    if($user_up && $ordersStatusResult){
                 Db::commit(); // 提交事务
             }else{
                // 回滚事务
                Db::rollback();
             }
            $buid=$user['id'];
        }else{
            break;
        }
    }
}
function jiesuanscore($uid,$zxjs_time){
    exit;
        config(select_key_value('config.base'));
        $userInfo = Db::name("Users")->where('id',$uid)->find();
        if($userInfo['settlement_time']<=time()){
            return true;
        }
        $m_fll=config('web_score_fulilv')/(60*60*24);//每秒复利率%
        $mmzj_score=$userInfo['score']*$m_fll/100;//每秒增涨积分
        $ygtime=(60*60*24)-($userInfo['settlement_time']-time());//今天与上次结算已过多少秒
        $jtjsscore=$ygtime*$mmzj_score;//转赠前应涨积分

        $jiesuan=DB::name('Users')->where(['id'=>$uid])->update(['score' => ['exp','score+'.$jtjsscore],'settlement_time'=>$zxjs_time]);//先结算自己积分

        $data['uid']=$uid;
        $data['dfuid']=0; 
        $data['score']=$jtjsscore;
        $data['type']=1;
        $data['info']='增涨';
        $data['addtime']=time();
        $jiesuan_users_log=DB::name('user_score_log')->insert($data);
        if($jiesuan && $jiesuan_users_log){
            return true;
        }else{
            return false;
        }
 
}
//更新积分
function up_score($uid,$dfuid,$score,$info,$time){

        $jiesuan=DB::name('Users')->where(['id'=>$uid])->update(['score' => ['exp','score+'.$score]]);
        $data['uid']=$uid;
        $data['dfuid']=$dfuid;
        $data['score']=abs($score);
        $data['type']=$score<0 ? 0 : 1;
        $data['info']=$info;
        $data['addtime']=$time;
        $user_score_log=DB::name('user_score_log')->insert($data);
        if($jiesuan && $user_score_log){
            return true;
        }else{
            return false;
        }
            
}
//可用积分
function score_ky($uid)
{
    exit;
    config(select_key_value('config.base'));
    $web_user_bdscore = config('web_user_bdscore'); //保底积分
    $web_score_bkzc   = config('web_score_bkzc'); //不可转出时间
    $time             = time() - 60 * $web_score_bkzc;
    $userInfo         = Db::name("Users")->where('id', $uid)->find();
    $score_bkzsum     = Db::name("user_score_log")->where('uid', $uid)->where('type', 1)->where('addtime', 'gt', $time)->sum('score'); //不可转积分
    if (($userInfo['score'] - $score_bkzsum) > $web_user_bdscore) {
        $kzjf = round($userInfo['score'] - $score_bkzsum - $web_user_bdscore, 2); //共可转积分
    } else {
        $kzjf = 0;
    }
    return $kzjf;
}
/**
 * 统计商城的业绩和全球分红的金额
 * $tz_money 每次复投的金额
 */

function tj_shop_money($tz_money){
    config(select_key_value('config.base'));
    $scyj_money = $tz_money;//计算出进入商城的业绩
    $qqfh_money = $tz_money * config('web_qqfh_bili') / 100; //计算出进入分红的金额
    Db::name("key_value")->where('name = "web_qqfh_money"')->update(['value'=>['exp','value+'.$qqfh_money]]);//插入全球分红字段
    Db::name("key_value")->where('name = "web_scyj_money"')->update(['value'=>['exp','value+'.$scyj_money]]);//插入商城业绩
}
/**
 * 直推奖励发放
 * $uid 会员id
 * $reid 推荐人id
 */
function zt_jiangli($uid,$reid){
    config(select_key_value('config.base'));
    $web_user_ztmoney = config('web_user_ztmoney');//直推奖励金额
    $info = '直推奖励'.$web_user_ztmoney.'元';
    up_score($reid,$uid,$web_user_ztmoney,$info,time());
   
}

/**
 * 进入公排方法 
 * $uid 会员id
 * $reid 会员直推人的id
 * $order_no 订单编号
 * $tz_money 投资金额
 */
function gongpai($uid,$reid,$order_no,$tz_money){

    tj_shop_money($tz_money);//把每次投资的金额计入商城的业绩
    zt_jiangli($uid,$reid);//复投时发放直推奖励
    
    if($reid>0){
        $re_user = Db::name("gongpai")->where(['uid' => $reid,'is_chuju' => 1])->find();        
        $gongpai_count = Db::name("gongpai")->where(1)->count();//统计数据表中数据数量
        if($gongpai_count<15){
            //首轮前15个会员不自动虚拟由系统注册
            switch($gongpai_count){
                case $gongpai_count>=1 && $gongpai_count<3: //第二层A
                    $data = array(
                        'uid' => $uid,
                        'order_no' => $order_no,//会员单号
                        'lunshu' => $re_user['lunshu'],//会员订单所在开盘轮数
                        'panhao' => $re_user['panhao'],//会员订单所在盘号
                        'bianhao' => $gongpai_count+1,//有问题 会员订单在盘中编号
                        'jibie' => 3,//会员订单所在盘层级
                        // 'quyu' => $quyu, //会员订单所在盘的左区和右区1左区2右区
                        'is_chuju' => 1,//会员此单是否已经出局1正常0出局
                        'bcsx' =>$gongpai_count - 1 + 1, //会员在本层的第几个位置 
                        'reid' => $reid //推荐人id号
                    );
                    break;
                case $gongpai_count>=3 && $gongpai_count<7: //第三层B
                    $data = array(
                        'uid' => $uid,
                        'order_no' => $order_no,//会员单号
                        'lunshu' => $re_user['lunshu'],//会员订单所在开盘轮数
                        'panhao' => $re_user['panhao'],//会员订单所在盘号
                        'bianhao' => $gongpai_count+1,//有问题 会员订单在盘中编号
                        'jibie' => 2,//会员订单所在盘层级
                        // 'quyu' => $quyu, //会员订单所在盘的左区和右区1左区2右区
                        'is_chuju' => 1,//会员此单是否已经出局1正常0出局
                        'bcsx' =>$gongpai_count - 3 + 1, //会员在本层的第几个位置 
                        'reid' => $reid //推荐人id号
                    );
                    break;
                case $gongpai_count>=7 && $gongpai_count<15: //第四层C
                    $data = array(
                        'uid' => $uid,
                        'order_no' => $order_no,//会员单号
                        'lunshu' => $re_user['lunshu'],//会员订单所在开盘轮数
                        'panhao' => $re_user['panhao'],//会员订单所在盘号
                        'bianhao' => $gongpai_count+1,//有问题 会员订单在盘中编号
                        'jibie' => 1,//会员订单所在盘层级
                        // 'quyu' => $quyu, //会员订单所在盘的左区和右区1左区2右区
                        'is_chuju' => 1,//会员此单是否已经出局1正常0出局
                        'bcsx' =>$gongpai_count - 7 + 1, //会员在本层的第几个位置 
                        'reid' => $reid //推荐人id号
                    );
                    break;


            }
            Db::name("gongpai")->insert($data);
        }else{
            $re_user = Db::name("gongpai")->where(['uid' => $reid,'is_chuju' => 1])->find();
            $max_banhao = Db::name("gongpai")->where('lunshu', $re_user['lunshu'])->max('bianhao');//查询目前表中同轮数最大编号
            $D_user_sum = Db::name("gongpai")->where(['panhao' => $re_user['panhao'],'jibie'=>0,'lunshu' =>$re_user['lunshu']])->count();//统计推荐人所在盘中最后一次的会员数量
           if($D_user_sum>8){//如果最后一层盘中人数大于8人分配到右区否侧分配到左区
                $quyu = 2;
           }else{
                $quyu = 1;
           }
            $data = array(
                'uid' => $uid,
                'order_no' => $order_no,//会员单号
                'lunshu' => $re_user['lunshu'],//会员订单所在开盘轮数
                'panhao' => $re_user['panhao'],//会员订单所在盘号
                'bianhao' => $max_banhao+1,//有问题 会员订单在盘中编号
                'jibie' => 0,//会员订单所在盘层级
                // 'quyu' => $quyu, //会员订单所在盘的左区和右区1左区2右区
                'is_chuju' => 1,//会员此单是否已经出局1正常0出局
                'bcsx' =>$D_user_sum + 1, //会员在本层的第几个位置 
                'reid' => $reid //推荐人id号
    
            );
            Db::name("gongpai")->insert($data);
            if($D_user_sum+1 == 16){//判断盘是否已经满了
                //盘满开始发奖励,分盘,升级一系列操作
    
                jiangli($re_user['panhao'],$re_user['lunshu']);//传递过去已经满的盘号和所在轮数
                //-----------------------------------------------
            }
        }
     
    }else{
        $is_gongpai = Db::name("gongpai")->where(1)->find();//判断下数据表中是否有数据
        if(empty($is_gongpai)){//表中数据不存在
            //自动虚拟前15个会员
            // $data = array(
            //     'uid' => $uid,
            //     'order_no' => $order_no,//会员单号
            //     'lunshu' => 1,//会员订单所在开盘轮数
            //     'panhao' => 1,//会员订单所在盘号
            //     'bianhao' => 16,//有问题 会员订单在盘中编号
            //     'jibie' => 0,//会员订单所在盘层级
            //     // 'quyu' => 1, //会员订单所在盘的左区和右区1左区2右区
            //     'is_chuju' => 1,//会员此单是否已经出局1正常0出局
            //     'bcsx' => 1, //会员在本层的第几个位置 
            //     'reid' => $reid //推荐人id号
    
            // );

            //首轮前15个会员不自动虚拟由系统注册
            $data = array(
                'uid' => $uid,
                'order_no' => $order_no,//会员单号
                'lunshu' => 1,//会员订单所在开盘轮数
                'panhao' => 1,//会员订单所在盘号
                'bianhao' => 1,//有问题 会员订单在盘中编号
                'jibie' => 4,//会员订单所在盘层级
                // 'quyu' => 1, //会员订单所在盘的左区和右区1左区2右区
                'is_chuju' => 1,//会员此单是否已经出局1正常0出局
                'bcsx' => 1, //会员在本层的第几个位置 
                'reid' => $reid //推荐人id号
    
            );
            Db::name("gongpai")->insert($data);
        }else{
            //系统虚拟会员
            // $old_user = Db::name("gongpai")->where(['uid'=>$uid])->order('id desc')->find();//查询第一个会员上一轮信息
            // $data = array(
            //     'uid' => $uid,
            //     'order_no' => $order_no,//会员单号
            //     'lunshu' => $old_user+1,//会员订单所在开盘轮数
            //     'panhao' => 1,//会员订单所在盘号
            //     'bianhao' => 16,//有问题 会员订单在盘中编号
            //     'jibie' => 0,//会员订单所在盘层级
            //     // 'quyu' => 1, //会员订单所在盘的左区和右区1左区2右区
            //     'is_chuju' => 1,//会员此单是否已经出局1正常0出局
            //     'bcsx' => 1, //会员在本层的第几个位置 本层顺序
            //     'reid' => $reid //推荐人id号
    
            // );

            //第一个会员复投是随机分配进入一个盘
            $two_user = Db::name("users")->where(['reid'=>$uid])->order('id asc')->find();//查询第二个进系统的会员信息
            $old_user = Db::name("gongpai")->where(['uid'=>$two_user['id'],'is_chuju'=>1])->find();//查询会员在公排系统的信息
            $max_banhao = Db::name("gongpai")->where('lunshu', $old_user['lunshu'])->max('bianhao');//查询目前表中同轮数最大编号
            $D_user_sum = Db::name("gongpai")->where(['panhao' => $old_user['panhao'],'jibie'=>0,'lunshu' =>$old_user['lunshu']])->count();//统计推荐人所在盘中最后一次的会员数量            
           
            $data = array(
                'uid' => $uid,
                'order_no' => $order_no,//会员单号
                'lunshu' => $old_user['lunshu'],//会员订单所在开盘轮数
                'panhao' => $old_user['panhao'],//会员订单所在盘号
                'bianhao' =>$max_banhao+1,//有问题 会员订单在盘中编号
                'jibie' => 0,//会员订单所在盘层级
                // 'quyu' => 1, //会员订单所在盘的左区和右区1左区2右区
                'is_chuju' => 1,//会员此单是否已经出局1正常0出局
                'bcsx' => $D_user_sum+1, //会员在本层的第几个位置 本层顺序
                'reid' => $reid //推荐人id号
    
            );
            Db::name("gongpai")->insert($data);
        }
    }
    

}


/**
 * 当达到分盘条件是发放会员奖励\分盘\改变级别等
 * $panhao 达到分盘条件的所在盘编号
 */
function jiangli($panhao,$lunshu){
    config(select_key_value('config.base'));
   $pan_user_list = Db::name("gongpai")->where(['panhao'=>$panhao,'lunshu'=>$lunshu])->select();
   $duizhang_user_list = Db::name("gongpai")->where(['panhao'=>$panhao,'lunshu'=>$lunshu,'jibie'=>3])->select();//查询出分盘后要成为两个队长的会员信息
   if(count($duizhang_user_list)==0){//判断第三层会员是否存在(起始时上四层会员为虚拟会员,查询不到)
       switch($panhao){
           case 1:
                $r_new_panhao = 2;//分盘后左边盘号
                $l_new_panhao = 3;//分盘后右边盘号
                break;
            case 2:
                $r_new_panhao = 4;//分盘后左边盘号
                $l_new_panhao = 5;//分盘后右边盘号
                break;
            case 3:
                $r_new_panhao = 6;//分盘后左边盘号
                $l_new_panhao = 7;//分盘后右边盘号
                break;
            case 4:
                $r_new_panhao = 8;//分盘后左边盘号
                $l_new_panhao = 9;//分盘后右边盘号
                break;
            case 5:
                $r_new_panhao = 10;//分盘后左边盘号
                $l_new_panhao = 11;//分盘后右边盘号
                break;
            case 6:
                $r_new_panhao = 12;//分盘后左边盘号
                $l_new_panhao = 13;//分盘后右边盘号
                break;
            case 7:
                $r_new_panhao = 14;//分盘后左边盘号
                $l_new_panhao = 15;//分盘后右边盘号
                break;
       }
       
   }else{
        foreach($duizhang_user_list as $key=>$value){
            if($value['bcsx'] == 1){
                $r_new_panhao = $value['bianhao'];//分盘后左边盘号
            }else{
                $l_new_panhao = $value['bianhao'];//分盘后右边盘号
            }
    
        }
   }
 

   $benlun_is_futou = 0;
   foreach($pan_user_list as $key=>$value){
        $ft_uid = 0; //初始化
        $sf_money = 0;
        switch($value['jibie']){
            case 4:
                $sf_money = config('web_user_scmoney4');
                $data = array(
                    'is_chuju' => 0,
                    'money' => $value['money'] + config('web_user_scmoney4')
                );
                $ft_uid = $value['uid']; //需要进行复投的会员id
                break;
            case 3: //二进一
                $sf_money = config('web_user_scmoney3');
                $data = array(
                    'jibie' => $value['jibie'] + 1,
                    'money' => $value['money']+config('web_user_scmoney3'), 
                    'bcsx' => 1,  //将要升级的层级会员所在位置(A层升级队长,所以都是第一个位置)
                    'panhao' => $value['bianhao']  //分盘后新的盘号
                );
                break;
            case 2: //四进二
                if($value['bcsx']%2==0){//判断下将要升级的层级会员所在位置
                    $bcsx = 2;
                }else{
                    $bcsx = $value['bcsx']%2;
                }
                if($value['bcsx']>2){
                    $new_panhao = $l_new_panhao; //分配进右盘
                }else{
                    $new_panhao = $r_new_panhao; //分配进左盘
                }

                $sf_money = config('web_user_scmoney2');
                $data = array(
                    'jibie' => $value['jibie'] + 1,
                    'money' => $value['money']+config('web_user_scmoney2'), 
                    'bcsx' => $bcsx,  
                    // 'quyu' => $bcsx,//区域分左右(将要升级的A层只有两个位置所以只有左右两个区域)
                    'panhao' => $new_panhao,  //所在新盘盘号
                );
                break;
            case 1: //八进四
                if($value['bcsx']%4==0){//判断下将要升级的层级会员所在位置
                    $bcsx = 4;
                }else{
                    $bcsx = $value['bcsx']%4;
                }
                if($value['bcsx']>4){
                    $new_panhao = $l_new_panhao; //分配进右盘
                }else{
                    $new_panhao = $r_new_panhao; //分配进左盘
                }

                $sf_money = config('web_user_scmoney1');
                $data = array(
                    'jibie' => $value['jibie'] + 1,
                    'money' => $value['money']+config('web_user_scmoney1'), 
                    'bcsx' => $bcsx,  
                    // 'quyu' => $bcsx,//区域分左右(将要升级的A层只有两个位置所以只有左右两个区域)
                    'panhao' => $new_panhao,  //所在新盘盘号
                );
                break;
            case 0: //十六进8
                if($value['bcsx']%8==0){//判断下将要升级的层级会员所在位置
                    $bcsx = 8;
                }else{
                    $bcsx = $value['bcsx']%8;
                }
                if($value['bcsx']>8){
                    $new_panhao = $l_new_panhao; //分配进右盘
                }else{
                    $new_panhao = $r_new_panhao; //分配进左盘
                }

         
                $data = array(
                    'jibie' => $value['jibie'] + 1,
                    'bcsx' => $bcsx,  
                    // 'quyu' => $bcsx,//区域分左右(将要升级的A层只有两个位置所以只有左右两个区域)
                    'panhao' => $new_panhao,  //所在新盘盘号
                );
                break;

        }
        Db::name("gongpai")->where(['uid'=>$value['uid'],'panhao'=>$panhao,'lunshu'=>$lunshu])->update($data);//修改会员信息
        if($sf_money>0){
            //给会员发放奖励
            $info = '会员层级提升奖励'.$sf_money.'元';
            up_score($value['uid'],0,$sf_money,$info,time());
            //-----------------------------------------------

        }

        if($ft_uid>0){
            $benlun_is_futou =1;
            $benlun_futou_id = $ft_uid;
            $benlun_futou_reid = $value['reid'];
           
        }

   }
   if($benlun_is_futou){
        //给这个会员进行复投
        // 复投单号
        $order_no 	= date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        //扣除会员复投金额
        $ft_money = config('web_user_jhmoney');
        $info2 = '会员出局复投'.$ft_money.'元,复投单号'.$order_no;
        up_score($benlun_futou_id,0,-$ft_money,$info2,time());
        gongpai($benlun_futou_id,$benlun_futou_reid,$order_no,$ft_money ); 
        //-----------------------------------------------
   }
   
  
  

}


  /**
 * 图片上传
 * @param  [type] $file   [description]
 * @param  [type] $folder [description]
 * @return [type]         [description]
 */
   function upload($field = 'file', $domain = false)
    {
       if(empty($field)) {
            $field = 'file';
        }
        if(!$domain) {
            $url_path = url('/');
        } else {
            $url_path = url('/', null, null, true);
        }
        $php_path = 'uploads/' . gsdate('Y') . '/' . gsdate('m') . '/' . gsdate('d') . '/';
        $file = request()->file($field);
        $info = $file->rule('named_upload')->move(_ROOT_ . $php_path);
        if(!$info) {
            return make_return(0, $file->getError());
        } else {
            $res_url = $url_path . $php_path . preg_replace("/[\/\\\\]{1,}/", "/", $info->getSaveName());
            return make_return(1, $res_url);
        }


    }
