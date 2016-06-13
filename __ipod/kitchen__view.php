<?php

if (!isset($the_operation)) exit();

$id = RET_STR_GET(POST_ID);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];

LOAD_TEMPLATE_PAGE('ipod_page', '#'.$row[ORDER_FORM_NUMBER].' / '.$row[ORDER_FORM_TARGET]);
		
$mins = floor(strtotime(date('Y-m-d H:i')) / 60) - (int) $row[ORDER_FORM_TIME_INT];

$block = RET_TEMPLATE_CONTENT('ipod_kitchen_view');
$ra = array(
	'form_number'	=> $row[ORDER_FORM_NUMBER]
	,'form_table'	=> $row[ORDER_FORM_TARGET]
	,'form_pay'	=> $row[ORDER_FORM_PAY]
	,'form_total'	=> $row[ORDER_FORM_TOTAL]
	,'form_change'	=> $row[ORDER_FORM_CHANGE]
	,'form_time'	=> $row[ORDER_FORM_TIME]
	,'form_mins'	=> $mins
	,'form_memo'	=> STR_TO_HTML($row[ORDER_FORM_MEMO])
);
$block = RET_REPLACED_TEMPLATE($block, $ra);

if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
	$h = '';
	if (LOAD_DB(RET_DB_FILE_2(PREFIX_ORDER_FORM, $row[ORDER_FORM_ID]), $rows, $rows_count)) {
		foreach ($rows as &$row) {
			$item_with_flavor = RET_LIST_FLAVOR_AND_ADDITIONAL($item, $row);
			
			RET_MEAL_STATUS($row[LIST_MEAL_STATUS], $mc, $mt);
			$price = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$amount = $price * (int) $row[LIST_MEAL_COUNT];
			$ra = array(
				'meal_name'		=> STR_TO_HTML(RET_NO_EN($row[LIST_MEAL_NAME]))
				,'meal_qty'		=> $row[LIST_MEAL_COUNT]
				,'meal_price'		=> $price
				,'meal_amount'		=> $amount
				,'meal_status'		=> $mt
				,'meal_status_class'	=> $mc
			);
			$h .= RET_REPLACED_TEMPLATE($item_with_flavor, $ra);
		}
	}
	$block = str_replace($key, $h, $block);
}

INSERT_TEMPLATE_BLOCK($block);
		
DUMP_TEMPLATE_PAGE();
