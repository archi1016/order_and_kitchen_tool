<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('ipod_page', $the_title);

if (LOAD_DB($the_db, $rows, $rows_count)) {
	$nt = floor(strtotime(date('Y-m-d H:i')) / 60);
	
	$link_url = $THIS_WEB_URL;
	APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, OPERATION_VIEW);
	APEND_URL_ARGUMENT($link_url, POST_ID, '');
	
	$block = RET_TEMPLATE_CONTENT('ipod_kitchen_list');
	if (MATCH_TEMPLATE_LIST_ITEM('form', $block, $key, $item, $ra)) {
		foreach ($rows as &$row) {
			$mins = $nt - (int) $row[ORDER_FORM_TIME_INT];
			
			$ra[] = array(
				'view_url'	=> $link_url.$row[ORDER_FORM_ID]
				,'form_number'	=> $row[ORDER_FORM_NUMBER]
				,'form_table'	=> $row[ORDER_FORM_TARGET]
				,'form_pay'	=> $row[ORDER_FORM_PAY]
				,'form_total'	=> $row[ORDER_FORM_TOTAL]
				,'form_change'	=> $row[ORDER_FORM_CHANGE]
				,'form_time'	=> $row[ORDER_FORM_TIME]
				,'form_mins'	=> $mins
				,'form_memo'	=> STR_TO_HTML($row[ORDER_FORM_MEMO])
			);
		}
		INSERT_TEMPLATE_BLOCK(str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block));
	}
}

DUMP_TEMPLATE_PAGE();
