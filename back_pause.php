<?php

require('func.php');
require('__back/back_func.php');

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_PAUSE;
$the_db = RET_DB_FILE(PREFIX_PAUSE);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_SAVE:
		require('__back/pause__save.php');
		break;
		
	default:
		require('__back/pause__list.php');
}
