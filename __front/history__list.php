<?php

if (!isset($the_operation)) exit();

function LIST_FORM_MEALS(&$block, $id) {
	if (!MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) return;
	$h = '';
	if (LOAD_DB(RET_DB_FILE_2(PREFIX_ORDER_HISTORY, $id), $rows, $rows_count)) {
		$i = 0;
		while ($i < $rows_count) {
			$row = &$rows[$i];
			$item_with_flavor = RET_LIST_FLAVOR_AND_ADDITIONAL($item, $row);
			
			$price = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$amount = $price * (int) $row[LIST_MEAL_COUNT];
			$ra = array(
				'meal_name'		=> STR_TO_HTML(RET_NO_EN($row[LIST_MEAL_NAME]))
				,'meal_qty'		=> $row[LIST_MEAL_COUNT]
				,'meal_price'		=> $price
				,'meal_amount'		=> $amount
			);
			$h .= RET_REPLACED_TEMPLATE($item_with_flavor, $ra);
			++$i;
		}
	}	
	$block = str_replace($key, $h, $block);
}




LOAD_TEMPLATE_PAGE('front_page', $the_title);
INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_SECTION_LIST());

if (LOAD_DB($the_db, $rows, $rows_count)) {
	REVERSE_ROWS($rows, $rows_count);
	
	$block = RET_TEMPLATE_CONTENT('front_history_list');
	if (MATCH_TEMPLATE_LIST_ITEM('form', $block, $key, $item, $ra)) {
		$h = '';
		foreach ($rows as &$row) {
			$item_form = $item;

			LIST_FORM_MEALS($item_form, $row[ORDER_FORM_ID]);
			
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
			$h .= RET_REPLACED_TEMPLATE($item_form, $ra);
		}
		$block = str_replace($key, $h, $block);
	}
	INSERT_TEMPLATE_BLOCK($block);
}

INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_AUTO_REFRESH());
DUMP_TEMPLATE_PAGE();
