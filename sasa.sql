-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 10 月 16 日 13:50
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `root`
--

-- --------------------------------------------------------

--
-- 表的结构 `mini_apiconfig`
--

CREATE TABLE IF NOT EXISTS `mini_apiconfig` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `key` varchar(255) NOT NULL COMMENT '配置项名称',
  `value` varchar(255) NOT NULL COMMENT '配置项值',
  `description` varchar(255) DEFAULT NULL COMMENT '配置描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `mini_apiconfig`
--

INSERT INTO `mini_apiconfig` (`id`, `key`, `value`, `description`) VALUES
(8, 'sms_appkey', '50dff1c817ae9d94f0ee31bf32766eba', 'Key值'),
(9, 'sms_signname', '睿胜科技工作室', '签名名称'),
(12, 'alipay_partner', '2088612610697091', '合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串'),
(13, 'alipay_appkey', 'tpouduazntw5emhajwe8gktyxabbvcvc', 'MD5密钥，安全检验码，由数字和字母组成的32位字符串'),
(14, 'wechat_appid', '', '微信公众号身份的唯一标识'),
(15, 'wechat_mchid', '', '受理商ID，身份标识'),
(16, 'wechat_appkey', '', '商户支付密钥Key'),
(17, 'wechat_appsecret', '', 'JSAPI接口中获取openid');

-- --------------------------------------------------------

--
-- 表的结构 `mini_cart`
--

CREATE TABLE IF NOT EXISTS `mini_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '购买数量',
  `createtime` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1：正常，2：已购买',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_code`
--

CREATE TABLE IF NOT EXISTS `mini_code` (
  `id` int(60) NOT NULL AUTO_INCREMENT,
  `mobile` char(128) DEFAULT NULL,
  `code` char(30) DEFAULT NULL,
  `yzm_time` int(60) DEFAULT NULL,
  `num` int(60) NOT NULL DEFAULT '0',
  `captcha` char(30) NOT NULL,
  `date` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_gongpai`
--

CREATE TABLE IF NOT EXISTS `mini_gongpai` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '订单号',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `lunshu` int(11) NOT NULL COMMENT '会员订单所在开盘轮数',
  `panhao` int(11) NOT NULL COMMENT '会员订单所在盘号',
  `bianhao` int(11) NOT NULL COMMENT '会员订单在盘中编号',
  `jibie` int(11) NOT NULL DEFAULT '0' COMMENT '会员订单所在盘层级0是最底层,依次升高',
  `quyu` tinyint(2) DEFAULT NULL COMMENT '会员订单所在盘的左区和右区',
  `is_chuju` tinyint(2) NOT NULL DEFAULT '1' COMMENT '会员此单是否已经出局1正常0出局',
  `reid` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人id号',
  `money` decimal(11,2) DEFAULT '0.00' COMMENT '已发放的钱数',
  `bcsx` int(11) NOT NULL COMMENT '会员在本层的第几个位置',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods`
--

CREATE TABLE IF NOT EXISTS `mini_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `num` int(11) NOT NULL COMMENT '商品库存数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `standard` varchar(255) NOT NULL COMMENT '规格型号',
  `cover_path` varchar(255) DEFAULT NULL COMMENT '封面图',
  `photo_path_1` varchar(255) DEFAULT NULL,
  `content` text NOT NULL COMMENT '商品详情',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1:上架，2：下架',
  `sell_num` int(11) NOT NULL DEFAULT '0' COMMENT '已经出售的数量',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  `categoryIds` int(11) NOT NULL DEFAULT '1' COMMENT '商品类型1是普通商品 2是公排商品',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_goods_collection`
--

CREATE TABLE IF NOT EXISTS `mini_goods_collection` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `goods_id` int(10) DEFAULT NULL COMMENT '商品id',
  `createtime` varchar(11) DEFAULT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_key_value`
--

CREATE TABLE IF NOT EXISTS `mini_key_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection` varchar(128) NOT NULL COMMENT '命名集合键和值对',
  `uuid` varchar(128) NOT NULL DEFAULT 'default' COMMENT '系统唯一标识',
  `name` varchar(128) NOT NULL COMMENT '键名',
  `value` longtext NOT NULL COMMENT 'The value.',
  PRIMARY KEY (`id`,`collection`,`uuid`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=166 ;

--
-- 转存表中的数据 `mini_key_value`
--

INSERT INTO `mini_key_value` (`id`, `collection`, `uuid`, `name`, `value`) VALUES
(1, 'config.base', 'default', 'web_score_fulilv', '2'),
(2, 'config.base', 'default', 'web_user_bdscore', '600'),
(3, 'config.base', 'default', 'web_score_zdzr', '600'),
(4, 'config.base', 'default', 'web_score_name', '金币'),
(5, 'config.base', 'default', 'web_score_bkzc', '0'),
(6, 'config.base', 'default', 'web_site_title', '测试测试'),
(7, 'config.base', 'default', 'web_user_jhmoney', '178'),
(8, 'indextheme', 'default', 'name', 'default'),
(8, 'users', '1d2b4420-5fe8-c5f0-27bf-ebd7ea9cb553', 'is_root', '1'),
(9, 'posts.form', '9db99141-65a4-2393-bfa8-d4d100e1a1f4', 'page_tpl', 'page'),
(10, 'posts.form', '1d3fa553-6e07-eed6-f459-4694de378122', 'page_tpl', 'page'),
(11, 'term.taxonomy', '1caad667-985e-4b91-ef4a-fbbac872fbce', 'page_num', '20'),
(12, 'term.taxonomy', '1caad667-985e-4b91-ef4a-fbbac872fbce', 'lists_tpl', 'news_list'),
(13, 'term.taxonomy', '1caad667-985e-4b91-ef4a-fbbac872fbce', 'detail_tpl', 'news_detail'),
(14, 'term.taxonomy', '1caad667-985e-4b91-ef4a-fbbac872fbce', 'bind_form', 'article'),
(15, 'term.taxonomy', '75d26c72-c68f-6c2b-3f5d-da6b85915a1c', 'page_num', '20'),
(16, 'term.taxonomy', '75d26c72-c68f-6c2b-3f5d-da6b85915a1c', 'lists_tpl', 'news_list'),
(17, 'term.taxonomy', '75d26c72-c68f-6c2b-3f5d-da6b85915a1c', 'detail_tpl', 'news_detail'),
(18, 'term.taxonomy', '75d26c72-c68f-6c2b-3f5d-da6b85915a1c', 'bind_form', 'article'),
(19, 'term.taxonomy', '8e830d6a-2be3-ad99-08b5-de279d877937', 'page_num', '20'),
(20, 'term.taxonomy', '8e830d6a-2be3-ad99-08b5-de279d877937', 'lists_tpl', 'news_list'),
(21, 'term.taxonomy', '8e830d6a-2be3-ad99-08b5-de279d877937', 'detail_tpl', 'news_detail'),
(22, 'term.taxonomy', '8e830d6a-2be3-ad99-08b5-de279d877937', 'bind_form', 'article'),
(29, 'posts.form', '085b628d-d8ae-d04c-dfa0-61992ca70f29', 'page_tpl', 'page'),
(30, 'posts.form', '3cf4069c-80d0-ac82-fcfe-e7e378569c12', 'page_tpl', 'page'),
(31, 'posts.form', '7df6d672-48ef-b8ed-1d18-74c3770dcbc3', 'page_tpl', 'page'),
(32, 'posts.form', '7faa2c91-b173-6bd2-4b69-c0234c7c1a57', 'page_tpl', 'page'),
(33, 'posts.form', 'b64c7e04-b8a0-eeda-0314-35eabe258111', 'page_tpl', 'page'),
(34, 'posts.form', '8bc618f8-c8a4-2219-fee2-2da0a71ca8ff', 'page_tpl', 'page'),
(35, 'posts.form', '8cfc3471-3754-30cb-b030-a11dba360e0c', 'page_tpl', 'page'),
(36, 'posts.form', '9bb4e644-482b-c2cd-68c7-9a1a2f290435', 'page_tpl', 'page'),
(37, 'posts.form', '1c6e5535-86e8-6e0b-548b-02e631b85b20', 'page_tpl', 'page'),
(38, 'posts.form', '879bda21-07f8-df3c-9270-7789515157ed', 'page_tpl', 'page'),
(39, 'posts.form', '74610495-ab86-d787-fa50-8ba3987b680b', 'page_tpl', 'page'),
(40, 'posts.form', '76ce6961-894e-8d13-59c4-49881ddf6748', 'page_tpl', 'page'),
(41, 'posts.form', '94714551-683d-aa79-6fb4-60dd70201473', 'page_tpl', 'page'),
(42, 'posts.form', '11646a6e-cd35-bcdd-4136-c5b392b63a6f', 'page_tpl', 'page'),
(43, 'posts.form', 'd27eea5e-e553-d2d5-b05b-9574af56ce3f', 'page_tpl', 'page'),
(44, 'posts.form', '60e38eeb-97a5-61ac-be60-425f9f8eb1c5', 'page_tpl', 'page'),
(45, 'posts.form', 'f569d8f0-0510-8c55-2cbf-f29a4ffea591', 'page_tpl', 'page'),
(46, 'posts.form', 'e4ec7532-1686-71f3-f57e-e19cc49a81bf', 'page_tpl', 'page'),
(47, 'posts.form', 'fabe0485-4f82-643a-6a46-cd8defc7f6d4', 'page_tpl', 'page'),
(48, 'posts.form', '88de9d39-21e8-d00f-c8ff-2b56791ea559', 'page_tpl', 'page'),
(49, 'users', '9fe83c25-864e-7fe8-370d-d97799be1d7e', 'is_root', '1'),
(50, 'posts.form', 'f4d643a2-8507-fd72-c5af-e12a7e77b13a', 'page_tpl', 'page'),
(51, 'posts.form', '6571e5b9-cf41-5e25-0cb9-9e7d07e62173', 'page_tpl', 'page'),
(52, 'posts.form', '442721ec-7a93-0baa-cd58-a469fae43c13', 'page_tpl', 'page'),
(53, 'posts.form', '6f4c8587-03e6-9d31-4325-c97384457543', 'page_tpl', 'page'),
(54, 'posts.form', '9d348e6e-db9d-0ec9-4a36-666787af9a74', 'page_tpl', 'page'),
(55, 'posts.form', 'b30eeb11-1ca4-e771-562f-644b56c66a7e', 'page_tpl', 'page'),
(56, 'posts.form', 'fdd989d9-d0f4-64f8-6981-5e3945d089c0', 'page_tpl', 'page'),
(66, 'posts.form', 'd5f45d6b-f40c-b798-c9ef-7d690078a166', 'page_tpl', 'page'),
(67, 'posts.form', '5df49b2a-c711-301d-8320-af500ceb40c6', 'page_tpl', 'page'),
(68, 'posts.form', '896d0d4d-cc3b-f43b-2000-e9604769eea0', 'page_tpl', 'page'),
(69, 'posts.form', 'd842871c-3840-f944-efb2-caefedcf926e', 'page_tpl', 'page'),
(70, 'posts.form', '3d57ca49-c45e-2266-067c-67cb2bde8603', 'page_tpl', 'page'),
(71, 'posts.form', 'a3fc44c5-5731-114c-d576-cebcb6767ff7', 'page_tpl', 'page'),
(72, 'posts.form', '591f72fc-def5-dc1d-1471-8bcb50b7d60d', 'page_tpl', 'page'),
(73, 'posts.form', '0e05d041-23de-e42b-c88f-d3eb6c4dc365', 'page_tpl', 'page'),
(74, 'config.base', 'default', 'web_fanli_1', '10'),
(75, 'config.base', 'default', 'web_fanli_2', '10'),
(76, 'config.base', 'default', 'web_fanli_3', '10'),
(77, 'config.base', 'default', 'web_fanli_4', '10'),
(78, 'config.base', 'default', 'web_fanli_5', '10'),
(79, 'config.base', 'default', 'web_fanli_6', '2'),
(80, 'config.base', 'default', 'web_fanli_7', '20'),
(81, 'config.base', 'default', 'web_fanli_8', '20'),
(82, 'config.base', 'default', 'web_fanli_9', '20'),
(83, 'config.base', 'default', 'web_gonggao', '测试测试测试测试测试测试测试测试测试测试!'),
(84, 'config.base', 'default', 'web_score_danwei', '币'),
(85, 'config.base', 'default', 'web_lucky_cs', '10'),
(86, 'config.base', 'default', 'web_lucky_score', '100'),
(87, 'config.base', 'default', 'web_lucky_jxsz', '<p>一等奖：多功能电饭煲。</p><p>二等奖：化妆品护肤套装。</p><p>三等奖：天然A货羊脂白玉石 。</p>'),
(88, 'config.base', 'default', 'web_lucky_hdsm', '<p>我们的中奖率高！！每次转盘消耗100金币！<br/></p>'),
(89, 'config.base', 'default', 'web_tixian_zx', '1'),
(90, 'config.base', 'default', 'web_jihuo_df', '10'),
(151, 'posts.form', '224ac0b6-a569-3d4d-aad4-f96d5cf4869d', 'description', '打造迁安农产品的名、特、优品牌'),
(152, 'posts.cover', '224ac0b6-a569-3d4d-aad4-f96d5cf4869d', 'cover_path_1', '/uploads/picture/20161206/fe70c72e47a91eb25ac27d80760a71b6.png'),
(153, 'config.base', 'default', 'web_user_ztmoney', '35'),
(154, 'config.base', 'default', 'web_user_scmoney1', '20'),
(155, 'config.base', 'default', 'web_user_scmoney2', '40'),
(156, 'config.base', 'default', 'web_user_scmoney3', '80'),
(157, 'config.base', 'default', 'web_user_scmoney4', '320'),
(158, 'config.base', 'default', 'web_qqfh_bili', '50'),
(159, 'config.base', 'default', 'web_qqfh_money', '0'),
(160, 'config.base', 'default', 'web_scyj_money', '0'),
(161, 'config.base', 'default', 'web_fenhong_num', '2'),
(162, 'config.base', 'default', 'web_tixian_zt', '1'),
(163, 'config.base', 'default', 'web_tixian_sf', '0'),
(164, 'config.base', 'default', 'web_logo_cover_path', '/uploads/picture/20180428/eee1efff1a9025926ccda78c77ea74a1.jpg'),
(165, 'config.base', 'default', 'web_sy_tzurl', 'http://www.baidu.com');

-- --------------------------------------------------------

--
-- 表的结构 `mini_lucky_prize`
--

CREATE TABLE IF NOT EXISTS `mini_lucky_prize` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `prize` varchar(50) DEFAULT NULL COMMENT '奖品',
  `odds` decimal(4,2) DEFAULT NULL COMMENT '中奖几率，为整数',
  `number` int(4) DEFAULT NULL COMMENT '奖品数量',
  `remain_num` int(4) DEFAULT NULL COMMENT '剩余奖品数量',
  `add_time` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_lucky_results`
--

CREATE TABLE IF NOT EXISTS `mini_lucky_results` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `member_id` int(8) DEFAULT NULL COMMENT '会员ID',
  `result_described` varchar(60) DEFAULT NULL COMMENT '描述记录',
  `is_win` int(4) DEFAULT '0' COMMENT '是否中奖,奖品ID，未中为0',
  `is_sure` tinyint(1) DEFAULT '0' COMMENT '是否已发奖',
  `add_time` int(10) DEFAULT NULL COMMENT '抽奖时间',
  `bj_time` int(10) DEFAULT NULL COMMENT '发奖时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_menu`
--

CREATE TABLE IF NOT EXISTS `mini_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- 转存表中的数据 `mini_menu`
--

INSERT INTO `mini_menu` (`id`, `name`, `icon`, `pid`, `sort`, `url`, `hide`, `status`) VALUES
(2, '订单', 'fa fa-fw fa-exchange', 0, 3, '#', 0, 0),
(3, '会员', 'fa fa-fw fa-users', 0, 4, '#', 0, 0),
(4, '设置', 'fa fa-gears', 0, 5, '#', 0, 0),
(5, '管理资料', 'fa fa-fw fa-user', 0, 6, '#', 0, 0),
(38, '订单列表', 'fa fa-money', 2, 0, 'order/index', 0, 0),
(39, '会员列表', 'fa fa-fw fa-user', 3, 0, 'member/index', 0, 0),
(41, '基本设置', 'fa  fa-wrench', 4, 0, 'config/edit', 0, 0),
(43, '个人资料', 'fa fa-user-times', 5, 0, 'user/edit', 0, 0),
(44, '修改密码', 'fa fa-fw fa-key', 5, 1, 'user/password', 0, 0),
(53, '提现列表', 'fa fa-edit (alias)', 3, 0, 'member/withdrawal', 0, 0),
(80, '公排信息', 'fa fa-fw fa-user', 3, 0, 'member/gongpai_xinxi', 0, 0),
(71, '商品', 'fa fa-shopping-cart', 0, 2, '#', 0, 0),
(72, '所有商品', ' fa fa-shopping-cart', 71, 0, 'goods/index', 0, 0),
(73, '添加商品', 'fa  fa-plus-square', 71, 1, 'goods/goodsAdd', 0, 0),
(79, '接口设置', 'fa fa-support', 4, 0, 'apiconfig/edit', 0, 0),
(81, '资金明细', 'fa fa-money', 3, 0, 'member/turnadd', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders`
--

CREATE TABLE IF NOT EXISTS `mini_orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(128) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `order_no` varchar(20) NOT NULL COMMENT '订单号',
  `express_type` varchar(100) DEFAULT NULL COMMENT '快递方式',
  `express_no` varchar(100) DEFAULT NULL COMMENT '快递编号',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `createtime` int(11) NOT NULL,
  `is_pay` int(11) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL COMMENT '支付状态',
  `memo` varchar(255) DEFAULT NULL COMMENT '订单备注',
  `consignee_name` varchar(100) NOT NULL COMMENT '收货人',
  `address` text NOT NULL COMMENT '收货地址',
  `mobile` varchar(11) NOT NULL COMMENT '收货人电话',
  `categoryIds` int(11) NOT NULL COMMENT '商品类型1是普通商品 2是公排商品',
  `pay_type` varchar(10) NOT NULL COMMENT '支付方式',
  PRIMARY KEY (`id`,`uuid`,`order_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders_goods`
--

CREATE TABLE IF NOT EXISTS `mini_orders_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(11) NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `name` varchar(255) NOT NULL,
  `num` int(10) NOT NULL COMMENT '购买数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `standard` varchar(255) NOT NULL,
  `cover_path` varchar(255) NOT NULL,
  `categoryIds` int(11) NOT NULL DEFAULT '1' COMMENT '商品类型1是普通商品 2是公排商品',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_orders_status`
--

CREATE TABLE IF NOT EXISTS `mini_orders_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) NOT NULL COMMENT '订单号',
  `approve_uid` int(50) DEFAULT NULL COMMENT '审核人',
  `status` varchar(30) NOT NULL COMMENT 'nopaid-未支付 paid-已支付,待发货  shipped-已发货  completed-收货已完成',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_users`
--

CREATE TABLE IF NOT EXISTS `mini_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(128) NOT NULL COMMENT '系统唯一标识符',
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `zsname` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `mobile` varchar(11) NOT NULL,
  `regdate` int(10) NOT NULL DEFAULT '0',
  `regip` char(15) NOT NULL DEFAULT '0',
  `salt` varchar(6) NOT NULL DEFAULT '0' COMMENT '加密盐',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1正常，2禁用，-1删除',
  `last_login` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `wechat_openid` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `score` decimal(14,2) NOT NULL DEFAULT '0.00' COMMENT '积分',
  `is_jh` int(11) NOT NULL DEFAULT '0' COMMENT '1为激活',
  `settlement_time` int(10) NOT NULL DEFAULT '0' COMMENT '结算时间',
  `reid` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人',
  `zhifubao` varchar(255) DEFAULT NULL,
  `weixinhao` varchar(255) DEFAULT NULL,
  `timg` varchar(255) DEFAULT NULL,
  `amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `address` varchar(255) DEFAULT NULL,
  `jhtime` int(10) NOT NULL,
  `zt_num` int(10) NOT NULL DEFAULT '0' COMMENT '会员直推人数',
  `is_shop` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0未消费过，1是已消费过',
  `fenhong1` int(11) NOT NULL DEFAULT '0' COMMENT '钻石区分红次数',
  `fenhong2` int(11) NOT NULL DEFAULT '0' COMMENT '金钻区分红次数',
  `fenhong3` int(11) NOT NULL DEFAULT '0' COMMENT '银冠区分红次数',
  `fenhong4` int(11) NOT NULL DEFAULT '0' COMMENT '金冠区分红次数',
  `fenhong5` int(11) NOT NULL DEFAULT '0' COMMENT '皇冠区分红次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `mini_users`
--

INSERT INTO `mini_users` (`id`, `uuid`, `username`, `password`, `zsname`, `nickname`, `mobile`, `regdate`, `regip`, `salt`, `status`, `last_login`, `wechat_openid`, `score`, `is_jh`, `settlement_time`, `reid`, `zhifubao`, `weixinhao`, `timg`, `amount`, `address`, `jhtime`, `zt_num`, `is_shop`, `fenhong1`, `fenhong2`, `fenhong3`, `fenhong4`, `fenhong5`) VALUES
(1, '1d2b4420-5fe8-c5f0-27bf-ebd7ea9cb553', 'admin', 'd6dd3e9d52e6e4d40171d1537e3b95a7', '张哈哈', 'admin', '15666666666', 1500630838, '2', '6d4670', 1, 1539668048, '', '10000.00', 0, 0, 0, '1562166666', 'gggg', '', '0.00', NULL, 1505459629, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_money_log`
--

CREATE TABLE IF NOT EXISTS `mini_user_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dfuid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `type` int(11) NOT NULL COMMENT '0为支出 1为收入 2为激活',
  `info` varchar(255) NOT NULL,
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_rule`
--

CREATE TABLE IF NOT EXISTS `mini_user_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  KEY `module` (`module`,`status`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_scoreorder`
--

CREATE TABLE IF NOT EXISTS `mini_user_scoreorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(52) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `paytime` varchar(10) NOT NULL DEFAULT '0',
  `addtime` varchar(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `uuid` varchar(128) NOT NULL,
  `wxsn` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`uuid`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_score_log`
--

CREATE TABLE IF NOT EXISTS `mini_user_score_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `dfuid` int(11) NOT NULL DEFAULT '0',
  `score` decimal(11,2) NOT NULL DEFAULT '0.00',
  `type` int(11) NOT NULL COMMENT '0为支出 1为收入 2为增涨',
  `info` varchar(255) NOT NULL,
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `mini_user_withdrawal`
--

CREATE TABLE IF NOT EXISTS `mini_user_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `amount` decimal(11,2) NOT NULL DEFAULT '0.00',
  `addtime` int(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0等待审核 1为通过 2为不通过',
  `true_amount` decimal(14,2) NOT NULL DEFAULT '0.00' COMMENT '实际发放金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
