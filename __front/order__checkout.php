<?php

if (!isset($page)) exit();

$operation = RET_STR_GET(ARGUMENT_OPERATION);

LOAD_TEMPLATE_PAGE('front_page_order', $the_page_caption);
INSERT_TEMPLATE_BLOCK($block_section);

if (OPERATION_INSERT == $operation) {
	$target = RET_STR_POST(POST_ORDER_TARGET);
	if ('' == $target) E_TO(ERROR_CODE_UNKNOW_TABLE);
	
	CHANGE_TMP_TO_ORDER_FORM($target, true);

	INSERT_TEMPLATE_BLOCK('<script>self.close();</script>');
	DUMP_TEMPLATE_PAGE();
}

$t = RET_CART_TOTAL();
	
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_INSERT);

$opts = '<option value="'.FRONT_CHECKOUT_OPTION_TAKEAWAY.'">'.FRONT_CHECKOUT_OPTION_TAKEAWAY.'</option>';
if (LOAD_DB(RET_DB_FILE(PREFIX_TABLE), $rows, $rows_count)) {
	foreach ($rows as $row) {
		$opts .= '<option value="'.$row[TABLE_NAME].'">'.$row[TABLE_NAME].'</option>';
	}
}

$block = RET_TEMPLATE_CONTENT('front_order_checkout');
$ra = array(
	'action_url'		=> $THIS_WEB_URL
	,'options_table'	=> $opts
	,'form_total'		=> $t
	,'form_change'		=> (0-$t)
);

INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
