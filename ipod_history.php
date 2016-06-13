<?php

require('func.php');
require('__ipod/ipod_func.php');

CHECK_MGR_LOGON();

$the_title = IPOD_SECTION_HISTORY;
$the_db = RET_DB_FILE(PREFIX_ORDER_HISTORY);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_VIEW:
		require('__ipod/history__view.php');
		break;
				
	default:
		require('__ipod/history__list.php');
}
