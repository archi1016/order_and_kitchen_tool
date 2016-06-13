<?php

if (!isset($the_operation)) exit();

function LIST_FORM_MEALS(&$block, $id) {
	if (!MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) return;
	$h = '';
	if (LOAD_DB(RET_DB_FILE_2(PREFIX_ORDER_FORM, $id), $rows, $rows_count)) {
		foreach ($rows as &$row) {
			$item_with_flavor = RET_LIST_FLAVOR_AND_ADDITIONAL($item, $row);
			
			$price = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$amount = $price * (int) $row[LIST_MEAL_COUNT];
			$ra = array(
				'meal_name'		=> STR_TO_HTML(RET_NO_EN($row[LIST_MEAL_NAME]))
				,'meal_barcode'		=> $row[LIST_MEAL_BARCODE]
				,'meal_qty'		=> $row[LIST_MEAL_COUNT]
				,'meal_price'		=> $price
				,'meal_amount'		=> $amount
			);
			$h .= RET_REPLACED_TEMPLATE($item_with_flavor, $ra);
		}
	}
	$block = str_replace($key, $h, $block);
}




$id = RET_STR_GET(POST_ID);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];

LOAD_TEMPLATE_PAGE('front_page_print', '#'.$row[ORDER_FORM_NUMBER].'-'.$row[ORDER_FORM_TARGET].'-'.date('His'));

$block = RET_TEMPLATE_CONTENT('front_print');
LIST_FORM_MEALS($block, $row[ORDER_FORM_ID]);

$ra = array(
	'form_number'		=> $row[ORDER_FORM_NUMBER]
	,'form_table'		=> $row[ORDER_FORM_TARGET]
	,'form_pay'		=> $row[ORDER_FORM_PAY]
	,'form_total'		=> $row[ORDER_FORM_TOTAL]
	,'form_change'		=> $row[ORDER_FORM_CHANGE]
	,'form_time'		=> $row[ORDER_FORM_TIME]
	,'print_label'		=> STR_TO_JS(FRONT_PRINT_BUTTON)
	,'auto_print'		=> CONFIG_KDS_AUTO_PRINT
);
$block = RET_REPLACED_TEMPLATE($block, $ra);
INSERT_TEMPLATE_BLOCK($block);
		
DUMP_TEMPLATE_PAGE();
