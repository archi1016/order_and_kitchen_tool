<?php

if (!isset($the_operation)) exit();

function RET_MEAL_STATUS($s, &$c, &$t) {
	global $is_sound;
	
	switch ($s) {
		case '1':
			$c = 'cooking';
			$t = FRONT_MEAL_STATUS_COOKING;
			if ($is_sound) {
				$is_sound = false;
			}
			break;
			
		case '2':
			$c = 'done';
			$t = FRONT_MEAL_STATUS_DONE;
			if ($is_sound) {
				$is_sound = false;
			}
			break;
			
		default:
			$c = 'queue';
			$t = FRONT_MEAL_STATUS_QUEUE;
			break;
	}
}

function LIST_FORM_MEALS(&$block, $id, $url) {
	if (!MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) return;
	$h = '';
	if (LOAD_DB(RET_DB_FILE_2(PREFIX_ORDER_FORM, $id), $rows, $rows_count)) {
		$i = 0;
		while ($i < $rows_count) {
			$row = &$rows[$i];
			$item_with_flavor = RET_LIST_FLAVOR_AND_ADDITIONAL($item, $row);
			
			$link_url = $url.OPERATION_MEMBER;
			APEND_URL_ARGUMENT($link_url, POST_ID_2, $i);
			APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION_2, '');
			
			RET_MEAL_STATUS($row[LIST_MEAL_STATUS], $mc, $mt);
			$name = STR_TO_HTML(RET_NO_EN($row[LIST_MEAL_NAME]));
			$price = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$amount = $price * (int) $row[LIST_MEAL_COUNT];
			$ra = array(
				'meal_name'		=> $name
				,'meal_qty'		=> $row[LIST_MEAL_COUNT]
				,'meal_price'		=> $price
				,'meal_amount'		=> $amount
				,'meal_status'		=> $mt
				,'meal_status_class'	=> $mc
				,'status_url'		=> $link_url.OPERATION_STATUS
				,'remove_url'		=> $link_url.OPERATION_REMOVE
				,'remove_confirm'	=> STR_TO_JS(sprintf(FRONT_KITCHEN_ITEM_REMOVE_CONFIRM, $name))
			);
			$h .= RET_REPLACED_TEMPLATE($item_with_flavor, $ra);
			++$i;
		}
	}	
	$block = str_replace($key, $h, $block);
}




LOAD_TEMPLATE_PAGE('front_page', $the_title);
INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_SECTION_LIST());

$is_sound = false;

if (LOAD_DB($the_db, $rows, $rows_count)) {
	if (COUNT_PAGES_INFO($rows_count, CONFIG_KDS_ROWS_EACH_PAGE, $THIS_WEB_URL, $pi)) {
		$block = RET_TEMPLATE_CONTENT('front_kitchen_list');
		if (MATCH_TEMPLATE_LIST_ITEM('form', $block, $key, $item, $ra)) {
			$h = '';
			$nt = floor(strtotime(date('Y-m-d H:i')) / 60);
			$i = $pi[PAGE_OFFSET];
			while ($i <= $pi[PAGE_LAST]) {
				$item_form = $item;
				$row = &$rows[$i];
			
				$mins = $nt - (int) $row[ORDER_FORM_TIME_INT];
				if (3 >= $mins) {
					$is_sound = true;
					if ('1' == $row[ORDER_FORM_NO_SOUND]) {
						$is_sound = false;
					}
				}
			
				$link_url = $THIS_WEB_URL;
				APEND_URL_ARGUMENT($link_url, POST_ID, $row[COMMON_ID]);
				APEND_URL_ARGUMENT($link_url, ARGUMENT_PAGE, $pi[PAGE_CURRENT]);
				APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, '');
			
				LIST_FORM_MEALS($item_form, $row[ORDER_FORM_ID], $link_url);
				
				$ra = array(
					'form_timeout_style'	=> RET_KDS_TIMEOUT_BORDER_STYLE($mins)
					,'form_number'		=> $row[ORDER_FORM_NUMBER]
					,'form_table'		=> $row[ORDER_FORM_TARGET]
					,'form_pay'		=> $row[ORDER_FORM_PAY]
					,'form_total'		=> $row[ORDER_FORM_TOTAL]
					,'form_change'		=> $row[ORDER_FORM_CHANGE]
					,'form_time'		=> $row[ORDER_FORM_TIME]
					,'form_mins'		=> $mins
					,'form_memo'		=> STR_TO_HTML($row[ORDER_FORM_MEMO])
					,'print_url'		=> $link_url.OPERATION_PRINT
					,'done_url'		=> $link_url.OPERATION_DONE
					,'remove_url'		=> $link_url.OPERATION_REMOVE
					,'done_confirm'		=> STR_TO_JS(sprintf(FRONT_KITCHEN_FORM_DONE_CONFIRM, $row[ORDER_FORM_NUMBER], $row[ORDER_FORM_TARGET]))
					,'remove_confirm'	=> STR_TO_JS(sprintf(FRONT_KITCHEN_FORM_REMOVE_CONFIRM, $row[ORDER_FORM_NUMBER], $row[ORDER_FORM_TARGET]))
				);
				$h .= RET_REPLACED_TEMPLATE($item_form, $ra);
				++$i;
			}
			$block = str_replace($key, $h, $block);
		}
		INSERT_TEMPLATE_BLOCK($block);
		INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_LIST_PAGE($pi));
	}
}


if ('1' != CONFIG_KDS_DISABLE_SOUND) {
	if ($is_sound) {
		$block = RET_TEMPLATE_CONTENT('front_kitchen_sound');
		$ra = array(
			'sound_file'	=> FOLDER_SOUND.'/'.SOUND_NEW_ORDER_FORM
			,'sound_volume'	=> CONFIG_KDS_SOUND_VOLUME
		);
		INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	}
}

INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_AUTO_REFRESH());
DUMP_TEMPLATE_PAGE();
