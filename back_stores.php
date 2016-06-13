<?php

require('func.php');
require('__back/back_func.php');

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_STORES;
$the_db = RET_DB_FILE(PREFIX_STORES);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_SAVE:
		require('__back/stores__save.php');
		break;
		
	default:
		require('__back/stores__list.php');
}
