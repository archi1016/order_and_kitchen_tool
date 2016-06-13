<?php

require('func.php');
require('__order/order_func.php');

ORDER_CHECK_CART_MEALS();

$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_INC:
		require('__order/cart__inc.php');
		break;
		
	case OPERATION_DEC:
		require('__order/cart__dec.php');
		break;
		
	case OPERATION_REMOVE:
		require('__order/cart__remove.php');
		break;
		
	default:
		require('__order/cart__list.php');
		break;
		
}
