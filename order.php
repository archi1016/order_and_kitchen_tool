<?php

require('func.php');
require('__order/order_func.php');

$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_INSERT:
		require('__order/home__insert.php');
		break;
	
	case OPERATION_DONE:
		require('__order/home__done.php');
		break;
	
	default:
		require('__order/home__list.php');
		break;
}
