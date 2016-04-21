<?php
/**
 * 后台管理菜单配置
 * 规则：顶部一级导航-》左侧一级导航-》左侧二级导航
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$config['menu'] = array(
	array('name' => '系统管理', 'list' => array(
			array('name' => '功能', 'class_name' => 'glyphicon-th-large', 'list' => array(
					array('name' => '用户管理', 'd' => 'admin', 'c' => 'member', 'm' => 'index'),
				)
			),
			array('name' => '管理', 'class_name' => 'glyphicon-th-list', 'list' => array(					
					array('name' => '消息管理', 'd' => 'admin', 'c' => 'news', 'm' => 'index'),					
					array('name' => '地区信息', 'd' => 'admin', 'c' => 'area', 'm' => 'index'),
					array('name' => '银行信息', 'd' => 'admin', 'c' => 'bank', 'm' => 'index'),
					array('name' => '店铺类型', 'd' => 'admin', 'c' => 'store_class', 'm' => 'index'),
					array('name' => '经营类目', 'd' => 'admin', 'c' => 'store_category', 'm' => 'index'),
				)
			),
			
			array('name' => '支付', 'class_name' => 'glyphicon glyphicon-yen', 'd' => 'admin', 'c' => 'payment', 'm' => 'index'),
			array('name' => '设置', 'class_name' => 'glyphicon-cog', 'list' => array(
					array('name' => '管理员', 'd' => 'admin', 'c' => 'admin', 'm' => 'index'),					
					array('name' => '系统设置', 'd' => 'admin', 'c' => 'system', 'm' => 'index'),
				)
			),
			array('name' => '日志', 'class_name' => 'glyphicon glyphicon-eye-open', 'list' => array(
					array('name' => '意见反馈', 'd' => 'admin', 'c' => 'feedback', 'm' => 'index'),
					array('name' => '操作日志', 'd' => 'admin', 'c' => 'log', 'm' => 'index'),
				)
			)
		)
	),
	array('name' => '工具服务', 'list' => array(
			array('name' => '工具', 'class_name' => 'glyphicon glyphicon-wrench', 'list' => array(
					array('name' => '长转短地址', 'd' => 'admin', 'c' => 'tools', 'm' => 'short_url'),
				)
			),
			array('name' => '数据库', 'class_name' => 'glyphicon glyphicon-console', 'list' => array(
					array('name' => '表列表', 'd' => 'admin', 'c' => 'db', 'm' => 'table'),
				)
			),
			array('name' => '备份', 'class_name' => 'glyphicon glyphicon-duplicate', 'list' => array(
					array('name' => '备份列表', 'd' => 'admin', 'c' => 'backup', 'm' => 'index'),
				)
			),
		)
	),
);
