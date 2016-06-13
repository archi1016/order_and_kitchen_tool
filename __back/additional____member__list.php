<?php

if (!isset($the_operation_2)) exit();

LOAD_TEMPLATE_PAGE('back_page', $the_title);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
INSERT_TEMPLATE_BLOCK($block_toolbar);

if (LOAD_DB($the_db_2, $rows, $rows_count)) {
	$block = RET_TEMPLATE_CONTENT('back_additional_member_list');
	if (MATCH_TEMPLATE_LIST_ITEM('additional', $block, $key, $item, $ra)) {
		$r = 0;
		while ($r < $rows_count) {
			$row = &$rows[$r];
			
			$link_url = $THIS_WEB_URL;
			APEND_URL_ARGUMENT($link_url, POST_ID_2, $row[COMMON_ID]);
			APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION_2, '');
	
			$ra[] = array(
				'row_class'		=> ($r&1)
				,'row_no'		=> ($r+1)
				,'name'			=> STR_TO_HTML($row[MB_ADDITIONAL_NAME].RET_ITEM_EN($row[MB_ADDITIONAL_NAME_EN]))
				,'photo'		=> RET_PHOTO_FILE($the_folder, $row[MB_ADDITIONAL_ID], $row[MB_ADDITIONAL_PHOTO])
				,'price'		=> $row[MB_ADDITIONAL_PRICE]
				,'edit_url'		=> $link_url.OPERATION_EDIT
				,'up_url'		=> $link_url.OPERATION_UP
				,'down_url'		=> $link_url.OPERATION_DOWN
				,'remove_url'		=> $link_url.OPERATION_REMOVE
				,'remove_confirm'	=> STR_TO_JS(sprintf(BACK_ITEM_REMOVE_CONFIRM, STR_TO_HTML($row[MEAL_NAME])))
			);
			++$r;
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	INSERT_TEMPLATE_BLOCK($block);
}

DUMP_TEMPLATE_PAGE();
