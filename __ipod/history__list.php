<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('ipod_page', $the_title);

if (LOAD_DB($the_db, $rows, $rows_count)) {
	REVERSE_ROWS($rows, $rows_count);
	
	$link_url = $THIS_WEB_URL;
	APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, OPERATION_VIEW);
	APEND_URL_ARGUMENT($link_url, POST_ID, '');
	
	$block = RET_TEMPLATE_CONTENT('ipod_history_list');
	if (MATCH_TEMPLATE_LIST_ITEM('form', $block, $key, $item, $ra)) {
		foreach ($rows as &$row) {
			$ra[] = array(
				'view_url'	=> $link_url.$row[ORDER_HISTORY_ID]
				,'form_number'	=> $row[ORDER_HISTORY_NUMBER]
				,'form_table'	=> $row[ORDER_HISTORY_TARGET]
				,'form_pay'	=> $row[ORDER_HISTORY_PAY]
				,'form_total'	=> $row[ORDER_HISTORY_TOTAL]
				,'form_change'	=> $row[ORDER_HISTORY_CHANGE]
				,'form_time_in'	=> $row[ORDER_HISTORY_TIME_IN]
				,'form_time_out'=> $row[ORDER_HISTORY_TIME_OUT]
				,'form_mins'	=> $row[ORDER_HISTORY_TIME_EXPEND]
				,'form_memo'	=> STR_TO_HTML($row[ORDER_HISTORY_MEMO])
			);
		}
		INSERT_TEMPLATE_BLOCK(str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block));
	}
}

DUMP_TEMPLATE_PAGE();
