<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('ipod_page_home', '');

$id = RET_STR_GET(POST_ID);
if (LOAD_DB_WITH_ROW_INDEX(RET_DB_FILE(PREFIX_ORDER_FORM), $rows, $rows_count, $id, $row_index)) {
	$row = &$rows[$row_index];

	$block = RET_TEMPLATE_CONTENT('ipod_home_done');
	$ra = array(
		'form_number'	=> $row[ORDER_FORM_NUMBER]
		,'form_table'	=> $row[ORDER_FORM_TARGET]
		,'form_total'	=> $row[ORDER_FORM_TOTAL]
		,'form_pay'	=> $row[ORDER_FORM_PAY]
		,'form_change'	=> $row[ORDER_FORM_CHANGE]
		,'form_time'	=> $row[ORDER_FORM_TIME]
		,'form_memo'	=> STR_TO_HTML($row[ORDER_FORM_MEMO])
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	
	if (LOAD_DB(RET_DB_FILE_2(PREFIX_ORDER_FORM, $row[ORDER_FORM_ID]), $rows, $rows_count)) {
		if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
			$i = 0;
			$a = 0;
			while ($i < $rows_count) {
				$row = &$rows[$i];
						
				$p = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
				$c = (int) $row[LIST_MEAL_COUNT];
				$s = $p * $c;
				$a += $s;
					
				$ra[] = array(
					'row_class'		=> ($i&1)
					,'row_no'		=> ($i+1)
					,'meal_name'		=> STR_TO_HTML($row[LIST_MEAL_NAME])
					,'meal_count'		=> $c
					,'meal_price'		=> $p
					,'meal_amount'		=> $s
					,'meal_accumulate'	=> $a
					,'meal_formula'		=> RET_MEAL_FORMULA($row)
					,'meal_flavor'		=> STR_TO_HTML(RET_MEAL_FLAVORS($row))
					,'meal_additional'	=> STR_TO_HTML(RET_MEAL_ADDITIONALS($row))
				);
				++$i;
			}
			$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
		}
	}
	INSERT_TEMPLATE_BLOCK($block);
}


INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_SECTION_LIST());
INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_NOTICE());

INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_AUTO_REFRESH());
DUMP_TEMPLATE_PAGE();
