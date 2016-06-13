<?php

if (!isset($the_operation)) exit();

$id = RET_STR_GET(POST_ID);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];

LOAD_TEMPLATE_PAGE('ipod_page', '#'.$row[ORDER_HISTORY_NUMBER].' / '.$row[ORDER_HISTORY_TARGET]);

$block = RET_TEMPLATE_CONTENT('ipod_history_view');
$ra = array(
	'form_number'	=> $row[ORDER_HISTORY_NUMBER]
	,'form_table'	=> $row[ORDER_HISTORY_TARGET]
	,'form_pay'	=> $row[ORDER_HISTORY_PAY]
	,'form_total'	=> $row[ORDER_HISTORY_TOTAL]
	,'form_change'	=> $row[ORDER_HISTORY_CHANGE]
	,'form_time_in'	=> $row[ORDER_HISTORY_TIME_IN]
	,'form_time_out'=> $row[ORDER_HISTORY_TIME_OUT]
	,'form_mins'	=> $row[ORDER_HISTORY_TIME_EXPEND]
	,'form_memo'	=> STR_TO_HTML($row[ORDER_HISTORY_MEMO])
);
$block = RET_REPLACED_TEMPLATE($block, $ra);

if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
	$h = '';
	if (LOAD_DB(RET_DB_FILE_2(PREFIX_ORDER_HISTORY, $row[ORDER_HISTORY_ID]), $rows, $rows_count)) {
		foreach ($rows as &$row) {
			$item_with_flavor = RET_LIST_FLAVOR_AND_ADDITIONAL($item, $row);
			
			$price = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$amount = $price * (int) $row[LIST_MEAL_COUNT];
			$ra = array(
				'meal_name'	=> STR_TO_HTML(RET_NO_EN($row[LIST_MEAL_NAME]))
				,'meal_qty'	=> $row[LIST_MEAL_COUNT]
				,'meal_price'	=> $price
				,'meal_amount'	=> $amount
			);
			$h .= RET_REPLACED_TEMPLATE($item_with_flavor, $ra);
		}
	}
	$block = str_replace($key, $h, $block);
}

INSERT_TEMPLATE_BLOCK($block);

DUMP_TEMPLATE_PAGE();
