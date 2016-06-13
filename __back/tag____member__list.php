<?php

if (!isset($the_operation_2)) exit();

LOAD_TEMPLATE_PAGE('back_page', $the_title);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
INSERT_TEMPLATE_BLOCK($block_toolbar);

if (LOAD_DB($the_db_2, $rows, $rows_count)) {
	$block = RET_TEMPLATE_CONTENT('back_tag_member_list');
	if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
		$i = 0;
		$r = 0;
		while ($i < $rows_count) {
			$row = &$rows[$i];
		
			if (isset($meal_id_to_index[$row[MB_TAG_ID]])) {
				$row = $meal_rows[$meal_id_to_index[$row[MB_TAG_ID]]];
		
				$link_url = $THIS_WEB_URL;
				APEND_URL_ARGUMENT($link_url, POST_ID_2, $row[COMMON_ID]);
				APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION_2, '');
	
				$ra[] = array(
					'row_class'		=> ($r&1)
					,'row_no'		=> ($r+1)
					,'name'			=> STR_TO_HTML($row[MEAL_NAME].RET_ITEM_EN($row[MEAL_NAME_EN]))
					,'photo'		=> RET_PHOTO_FILE(FOLDER_MEAL, $row[MEAL_ID], $row[MEAL_PHOTO])
					,'price'		=> $row[MEAL_PRICE]
					,'category'		=> STR_TO_HTML(RET_CATEGORY_NAME($row[MEAL_CATEGORY]))
					,'flavor'		=> STR_TO_HTML(RET_FLAVOR_NAME($row[MEAL_FLAVOR], 0))
					,'additional'		=> STR_TO_HTML(RET_ADDITIONAL_NAME($row[MEAL_ADDITIONAL]))
					,'hide_class'		=> RET_HIDE_PREFIX($row[MEAL_HIDE])
					,'up_url'		=> $link_url.OPERATION_UP
					,'down_url'		=> $link_url.OPERATION_DOWN
					,'remove_url'		=> $link_url.OPERATION_REMOVE
					,'remove_confirm'	=> STR_TO_JS(sprintf(BACK_ITEM_REMOVE_CONFIRM, STR_TO_HTML($row[MEAL_NAME])))
				);
				++$r;
			}
			++$i;
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	INSERT_TEMPLATE_BLOCK($block);
}

DUMP_TEMPLATE_PAGE();
