<?php

if (!isset($the_operation_2)) exit();

LOAD_TEMPLATE_PAGE('back_page', $the_title);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
INSERT_TEMPLATE_BLOCK($block_toolbar);

if (LOAD_DB($the_db_2, $rows, $rows_count)) {
	$block = RET_TEMPLATE_CONTENT('back_meal_album_list');
	if (MATCH_TEMPLATE_LIST_ITEM('photo', $block, $key, $item, $ra)) {
		$i = 0;
		while ($i < $rows_count) {
			$row = &$rows[$i];
			
			$link_url = $THIS_WEB_URL;
			APEND_URL_ARGUMENT($link_url, POST_ID_2, $row[COMMON_ID]);
			APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION_2, '');
	
			$ra[] = array(
				'album'			=> RET_ALBUM_FILE($the_folder, $the_row[COMMON_ID].'.'.$row[AB_MEAL_ID], $row[AB_MEAL_PHOTO])
				,'forward_url'		=> $link_url.OPERATION_UP
				,'backward_url'		=> $link_url.OPERATION_DOWN
				,'remove_url'		=> $link_url.OPERATION_REMOVE
				,'remove_confirm'	=> STR_TO_JS(sprintf(BACK_ITEM_REMOVE_CONFIRM, '#'.($i+1)))
			);
			++$i;
		}	
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	INSERT_TEMPLATE_BLOCK($block);
}

DUMP_TEMPLATE_PAGE();
