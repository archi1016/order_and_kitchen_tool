<?php

require('__front/front_config.php');

INIT_TEMPLATE_PATH('__front');

define('LOGON_PAGE'			,'front.php');
define('FIRST_PAGE'			,'front_kitchen.php');

function FRONT_BLOCK_SECTION_LIST() {
	$arguments = '?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN;
	$section_info = array(
		array('front_kitchen.php'	,FRONT_SECTION_KITCHEN)
		,array('front_history.php'	,FRONT_SECTION_HISTORY)
		,array('front_notice.php'	,FRONT_SECTION_NOTICE)
		,array('front_pause.php'	,FRONT_SECTION_PAUSE)
	);
	
	$block = RET_TEMPLATE_CONTENT('front_section');
	if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
		foreach ($section_info as &$r) {
			$c = 'link';
			if (THIS_PHP_FILE == $r[COMMON_ID]) $c = 'current';
			
			$ra[] = array(
				'section_url'		=> $r[COMMON_ID].$arguments
				,'section_name'		=> $r[COMMON_NAME]
				,'section_class'	=> $c
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	$ra = array(
		'order_url'	=> 'front_order.php'.$arguments
		,'logoff_url'	=> 'front_exit.php'.$arguments
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	return $block;
}

function FRONT_BLOCK_AUTO_REFRESH() {
	$block = RET_TEMPLATE_CONTENT('front_kitchen_refresh');
	$ra = array(
		'refresh_seconds'	=> CONFIG_KDS_REFRESH_SECONDS
		,'refresh_url'		=> 'front_kitchen.php?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function FRONT_BLOCK_LIST_PAGE(&$pi) {
	if (1 >= $pi[PAGE_TOTAL]) return '';
	
	$block = RET_TEMPLATE_CONTENT('front_list_page');
	if (MATCH_TEMPLATE_LIST_ITEM('page', $block, $key, $item, $ra)) {
		$i = 1;
		while ($i <= $pi[PAGE_TOTAL]) {
			$c = 'link';
			if ($pi[PAGE_CURRENT] == $i) $c = 'current';
			
			$ra[] = array(
				'page_url'	=> $pi[PAGE_LINK].$i
				,'page_name'	=> $i
				,'page_class'	=> $c
			);
			++$i;
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function RET_KDS_TIMEOUT_BORDER_STYLE($mins) {
	$clr = '';
	if ($mins > CONFIG_KDS_TIMEOUT_MINUTES_0) $clr = CONFIG_KDS_TIMEOUT_COLOR_0;
	if ($mins > CONFIG_KDS_TIMEOUT_MINUTES_1) $clr = CONFIG_KDS_TIMEOUT_COLOR_1;
	if ($mins > CONFIG_KDS_TIMEOUT_MINUTES_2) $clr = CONFIG_KDS_TIMEOUT_COLOR_2;
	if ('' != $clr) {
		$clr = ' style="border-color:'.$clr.';"';
	}
	return $clr;
}

