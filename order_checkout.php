<?php

require('func.php');
require('__order/order_func.php');

ORDER_CHECK_CART_MEALS();

switch ($the_mode) {
	case ORDER_MODE_HERE:
		$target = ORDER_GET_NAME_FROM_IP($_SERVER['REMOTE_ADDR']);
		$opts = '<option value="'.$target.'">'.$target.'</option>';
		break;
		
	case ORDER_MODE_TAKEAWAY:
		$opts = '<option value="'.ORDER_CHECKOUT_OPTION_TAKEAWAY.'">'.ORDER_CHECKOUT_OPTION_TAKEAWAY.'</option>';
		if (LOAD_DB(RET_DB_FILE(PREFIX_TABLE), $rows, $rows_count)) {
			foreach ($rows as $row) {
				$opts .= '<option value="'.$row[TABLE_NAME].'">'.$row[TABLE_NAME].'</option>';
			}
		}
		break;
		
	default:
		$opts = '';
		break;
}

LOAD_TEMPLATE_PAGE('order_page', ORDER_CAPTION_CHECKOUT);
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_SECTION_LIST());

$t = RET_CART_TOTAL();

$link_url = FIRST_PAGE.'?'.ARGUMENT_MODE.'='.$the_mode;
APEND_URL_ARGUMENT($link_url, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
APEND_URL_ARGUMENT($link_url, ARGUMENT_TMP_ID, $tmp_id);
APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, OPERATION_INSERT);

$block = RET_TEMPLATE_CONTENT('order_checkout');
$ra = array(
	'action_url'		=> $link_url
	,'options_table'	=> $opts
	,'form_total'		=> $t
	,'form_change'		=> (0-$t)
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_FOOTER());
DUMP_TEMPLATE_PAGE();
