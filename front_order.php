<?php

require('func.php');
require('__front/front_func.php');
require('__front/front_func_order.php');

CHECK_MGR_LOGON();

FRONT_CHECK_CART_MEALS();
			
$page = RET_STR_GET(ARGUMENT_PAGE);
$prev_url = $THIS_WEB_URL;
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, $page);

$the_page_caption = sprintf(FRONT_ORDER_CAPTION, $tmp_row[TMP_NUMBER]);
$block_section = FRONT_BLOCK_ORDER_SECTION($prev_url);

switch ($page) {
	case PAGE_CART:
		require('__front/order__cart.php');
		break;
						
	case PAGE_CHECKOUT:
		require('__front/order__checkout.php');
		break;
		
	case PAGE_CANCEL:
		require('__front/order__cancel.php');
		break;
						
	default:
		require('__front/order__meal.php');
		break;
}

