<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return [
    'app_debug' => true,
    // 模块设置
    'default_module'        => 'index',  // 默认模块名
    'deny_module_list'      => ['runtime'],  // 禁止访问模块
    'default_controller'    => 'Index',  // 默认控制器名
    'default_action'        => 'index',  // 默认操作名
    // 多语言设置
    'lang_switch_on'        => true,   // 开启语言包功能
    'lang_list'             => ['zh-cn,zh-tw,en-us'], // 支持的语言列表
    // 模板设置
    'view_replace_str'=>[
        'STATIC_PATH'=> __ROOT__.'/static', // 模板变量替换
        'UPLOAD_PATH'=> __ROOT__.'/uploads', // 模板变量替换
    ],
    // 日志设置
    'log'                   => [
        'type' => 'file', // 支持 socket trace file
        'path' => LOG_PATH,
    ],
    'root_namespace'        => [
        'common'  => ROOT_PATH.'/application/common/',
    ],
     // 扩展配置文件

    // 标签设置
    'template'              => [
        'taglib_begin'      => '{', // 标签库标签开始标记
        'taglib_end'        => '}', // 标签库标签结束标记
        'taglib_load'       => true, // 是否使用内置标签库之外的其它标签库，默认自动检测
        'taglib_build_in'   => 'cx,common\taglib\MiniShop', // 内置标签库名称(标签使用不必指定标签库名称),以逗号分隔 注意解析顺序
        'taglib_pre_load'   => '', // 需要额外加载的标签库(须指定标签库名称)，多个以逗号分隔
    ],
    // 主题目录设置
    'theme_dir'             => 'themes',
        // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => ROOT_PATH.'themes/default/index/dispatch_jump.html',
    'dispatch_error_tmpl'    => ROOT_PATH.'themes/default/index/dispatch_jump.html',
    // 入口访问url
    'enter_url'				=> 'http://www.wap1.com',
    // URL伪静态后缀
    'url_html_suffix'        => 'html|xml|json|jsonp',
	// 短信发送
    // 一天之内不能超过15次，发送间隔不能低于一分钟，超过15分钟验证码过期，尝试输入次数不能多余六次
    'sms_num'               =>5,
    'sms_interval'          =>60,
    'sms_expiry'            =>60*15,
    
    'data_backup_puth' => 'data/',
];

