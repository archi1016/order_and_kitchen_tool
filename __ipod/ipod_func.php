<?php

require('__front/front_config.php');

INIT_TEMPLATE_PATH('__ipod');

define('LOGON_PAGE'			,'ipod.php');
define('FIRST_PAGE'			,'ipod_home.php');


function IPOD_BLOCK_SECTION_LIST() {
	$arguments = '?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN;
	$section_info = array(
		array('ipod_order.php'		,IPOD_SECTION_ORDER)
		,array('ipod_kitchen.php'	,IPOD_SECTION_KITCHEN)
		,array('ipod_history.php'	,IPOD_SECTION_HISTORY)
		,array('ipod_exit.php'		,IPOD_SECTION_LOGOFF)
	);
	
	$block = RET_TEMPLATE_CONTENT('ipod_home_section');
	if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
		foreach ($section_info as &$r) {
			$ra[] = array(
				'section_url'	=> $r[COMMON_ID].$arguments
				,'section_name'	=> $r[COMMON_NAME]
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function IPOD_BLOCK_NOTICE() {
	$n = RET_DB_FILE(PREFIX_NOTICE);
	if (is_file($n)) {
		$n = STR_TO_HTML(file_get_contents($n));
	} else {
		$n = IPOD_HOME_EMPTY_NOTICE;
	}
	
	$block = RET_TEMPLATE_CONTENT('ipod_home_notice');
	$ra = array(
		'notice' => $n
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	return $block;
}

function IPOD_BLOCK_AUTO_REFRESH() {
	$block = RET_TEMPLATE_CONTENT('ipod_home_refresh');
	$ra = array(
		'refresh_seconds'	=> 300
		,'refresh_url'		=> FIRST_PAGE.'?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function RET_MEAL_STATUS($s, &$c, &$t) {
	switch ($s) {
		case '1':
			$c = 'cooking';
			$t = IPOD_MEAL_STATUS_COOKING;
			break;
			
		case '2':
			$c = 'done';
			$t = IPOD_MEAL_STATUS_DONE;
			break;
			
		default:
			$c = 'queue';
			$t = IPOD_MEAL_STATUS_QUEUE;
			break;
	}
}


