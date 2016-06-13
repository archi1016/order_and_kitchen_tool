<?php

require('func.php');
require('__back/back_func.php');

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_CONFIG;
$the_db = '';
$the_mode = RET_STR_GET(ARGUMENT_MODE);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

if ('' == $the_mode) $the_mode = CONFIG_FRONT_SOUND;

$prev_url = $THIS_WEB_URL;
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_MODE, $the_mode);

$block_section = BACK_BLOCK_CONFIG_SECTION_LIST($prev_url);

switch ($the_mode) {
	case CONFIG_FRONT_SOUND:
		require('__back/config__front__sound.php');
		break;
		
	case CONFIG_FRONT_MISC:
		require('__back/config__front__misc.php');
		break;
			
	case CONFIG_ORDER_MISC:
		require('__back/config__order__misc.php');
		break;
		
	case CONFIG_FRONT_USER:
		require('__back/config__front__user.php');
		break;
		
	case CONFIG_BACK_USER:
		require('__back/config__back__user.php');
		break;
	
	case CONFIG_TEMPLATE:
		require('__back/config__template.php');
		break;
			
	case CONFIG_UPDATE:
		require('__back/config__update.php');
		break;
			
	default:
		E_TO(ERROR_CODE_UNKNOW);
		break;
		
}
