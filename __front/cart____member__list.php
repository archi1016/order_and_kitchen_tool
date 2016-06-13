<?php

if (!isset($page)) exit();

LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_MEAL), $meal_rows, $meal_rows_count, $meal_id_to_index);

LOAD_TEMPLATE_PAGE('front_page_order', $the_page_caption);
INSERT_TEMPLATE_BLOCK($block_section);

$block = RET_TEMPLATE_CONTENT('front_order_cart');

$link_url = $THIS_WEB_URL;
APEND_URL_ARGUMENT($link_url, POST_ID, '-1');
APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, OPERATION_REMOVE);

$ra = array(
	'cart_total'		=> sprintf(FRONT_CART_TOTAL, RET_CART_TOTAL())
	,'remove_all_url'	=> $link_url
);
$block = RET_REPLACED_TEMPLATE($block, $ra);
	
if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
	if ($cart_rows_count > 0) {
		$i = 0;
		$a = 0;
		while ($i < $cart_rows_count) {
			$row = &$cart_rows[$i];

			$p = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$c = (int) $row[LIST_MEAL_COUNT];
			$s = $p * $c;
			$a += $s;
		
			$link_url = $THIS_WEB_URL;
			APEND_URL_ARGUMENT($link_url, POST_ID, $i);
			APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, '');
		
			$ra[] = array(
				'meal_row_index'	=> $i
				,'meal_no'		=> ($i+1)
				,'meal_name'		=> STR_TO_HTML($row[LIST_MEAL_NAME])
				,'meal_barcode'		=> $row[LIST_MEAL_BARCODE]
				,'meal_photo'		=> $row[LIST_MEAL_PHOTO].'?'.RANDOM_STRING
				,'meal_count'		=> $c
				,'meal_price'		=> $p
				,'meal_amount'		=> $s
				,'meal_accumulate'	=> $a
				,'meal_formula'		=> RET_MEAL_FORMULA($row)
				,'meal_flavor'		=> STR_TO_HTML(RET_MEAL_FLAVORS($row))
				,'meal_additional'	=> STR_TO_HTML(RET_MEAL_ADDITIONALS($row))
				,'inc_url'		=> $link_url.OPERATION_INC
				,'dec_url'		=> $link_url.OPERATION_DEC
				,'remove_url'		=> $link_url.OPERATION_REMOVE
				,'remove_confirm'	=> STR_TO_JS(sprintf(FRONT_CART_REMOVE_ITEM_CONFIRM, $row[LIST_MEAL_NAME]))
			);
			++$i;
		}
	}
	$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
}
INSERT_TEMPLATE_BLOCK($block);
DUMP_TEMPLATE_PAGE();
