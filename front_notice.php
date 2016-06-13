<?php

require('func.php');
require('__front/front_func.php');

CHECK_MGR_LOGON();

$the_title = FRONT_SECTION_NOTICE;
$the_db = RET_DB_FILE(PREFIX_NOTICE);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_SAVE:
		require('__front/notice__save.php');
		break;
			
	default:
		require('__front/notice__list.php');
}

