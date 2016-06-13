<?php

require('func.php');
require('__ipod/ipod_func.php');

CHECK_MGR_LOGON();

$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_INSERT:
		require('__ipod/home__insert.php');
		break;
	
	case OPERATION_DONE:
		require('__ipod/home__done.php');
		break;
	
	default:
		require('__ipod/home__list.php');
		break;
}

