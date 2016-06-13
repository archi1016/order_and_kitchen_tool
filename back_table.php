<?php

require('func.php');
require('__back/back_func.php');

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_TABLE;
$the_db = RET_DB_FILE(PREFIX_TABLE);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_NEW:
		require('__back/table__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/table__insert.php');
		break;
		
	case OPERATION_EDIT:
		require('__back/table__edit.php');
		break;
		
	case OPERATION_SAVE:
		require('__back/table__save.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/table__remove.php');
		break;

	case OPERATION_UP:
		require('__back/common__up.php');
		break;

	case OPERATION_DOWN:
		require('__back/common__down.php');
		break;
				
	default:
		require('__back/table__list.php');
}
