<?php

if (!isset($page)) exit();

$operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($operation) {
	case OPERATION_INC:
		require('__ipod/cart____member__inc.php');
		break;
		
	case OPERATION_DEC:
		require('__ipod/cart____member__dec.php');
		break;
		
	case OPERATION_REMOVE:
		require('__ipod/cart____member__remove.php');
		break;
		
	default:
		require('__ipod/cart____member__list.php');
		break;
		
}
