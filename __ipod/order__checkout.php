<?php

if (!isset($page)) exit();

LOAD_TEMPLATE_PAGE('ipod_page_order', $the_page_caption);
INSERT_TEMPLATE_BLOCK($block_section);

$t = RET_CART_TOTAL();

$link_url = FIRST_PAGE.'?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN;
APEND_URL_ARGUMENT($link_url, ARGUMENT_TMP_ID, $tmp_id);
APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, OPERATION_INSERT);

$opts = '<option value="'.IPOD_CHECKOUT_OPTION_TAKEAWAY.'">'.IPOD_CHECKOUT_OPTION_TAKEAWAY.'</option>';
if (LOAD_DB(RET_DB_FILE(PREFIX_TABLE), $rows, $rows_count)) {
	foreach ($rows as $row) {
		$opts .= '<option value="'.$row[TABLE_NAME].'">'.$row[TABLE_NAME].'</option>';
	}
}

$block = RET_TEMPLATE_CONTENT('ipod_order_checkout');
$ra = array(
	'action_url'		=> $link_url
	,'options_table'	=> $opts
	,'form_total'		=> $t
	,'form_change'		=> (0-$t)
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_ORDER_FOOTER());

DUMP_TEMPLATE_PAGE();
