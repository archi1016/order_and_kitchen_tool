<?php

require('func.php');
require('__ipod/ipod_func.php');

CHECK_MGR_LOGON();

$the_title = IPOD_SECTION_KITCHEN;
$the_db = RET_DB_FILE(PREFIX_ORDER_FORM);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_VIEW:
		require('__ipod/kitchen__view.php');
		break;
				
	default:
		require('__ipod/kitchen__list.php');
}
