<?php

require('func.php');
require('__front/front_func.php');

CHECK_MGR_LOGON();

$the_title = FRONT_SECTION_KITCHEN;
$the_db = RET_DB_FILE(PREFIX_ORDER_FORM);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_PRINT:
		require('__front/kitchen__print.php');
		break;
		
	case OPERATION_DONE:
		require('__front/kitchen__done.php');
		break;
		
	case OPERATION_REMOVE:
		require('__front/kitchen__remove.php');
		break;

	case OPERATION_MEMBER:
		require('__front/kitchen____member.php');
		break;
					
	default:
		require('__front/kitchen__list.php');
}
