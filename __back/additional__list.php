<?php

if (!isset($the_operation)) exit();

$kw = RET_STR_POST(POST_SEARCH_KEYWORD);

LOAD_TEMPLATE_PAGE('back_page', $the_title);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_TOOLBAR_SEARCH($kw));

if (LOAD_DB($the_db, $rows, $rows_count)) {
	SEARCH_ROWS_TITLE($kw, $rows, $rows_count);
	if (COUNT_PAGES_INFO($rows_count, 20, $THIS_WEB_URL, $pi)) {
		APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, $pi[PAGE_CURRENT]);
		$block = RET_TEMPLATE_CONTENT('back_additional_list');
		if (MATCH_TEMPLATE_LIST_ITEM('additional', $block, $key, $item, $ra)) {
			$i = $pi[PAGE_OFFSET];
			$r = 0;
			while ($i <= $pi[PAGE_LAST]) {
				$row = &$rows[$i];
			
				$link_url = $THIS_WEB_URL;
				APEND_URL_ARGUMENT($link_url, POST_ID, $row[COMMON_ID]);
				APEND_URL_ARGUMENT($link_url, ARGUMENT_OPERATION, '');
			
				$ra[] = array(
					'row_class'		=> ($r&1)
					,'row_no'		=> ($i+1)
					,'name'			=> STR_TO_HTML($row[ADDITIONAL_NAME])
					,'edit_url'		=> $link_url.OPERATION_EDIT
					,'up_url'		=> $link_url.OPERATION_UP
					,'down_url'		=> $link_url.OPERATION_DOWN
					,'remove_url'		=> $link_url.OPERATION_REMOVE
					,'member_url'		=> $link_url.OPERATION_MEMBER
					,'remove_confirm'	=> STR_TO_JS(sprintf(BACK_ITEM_REMOVE_CONFIRM, STR_TO_HTML($row[ADDITIONAL_NAME])))
				);
				++$i;
				++$r;
			}
			$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
		}
		$ra = array(
			'page_current'	=> $pi[PAGE_CURRENT]
			,'page_total'	=> $pi[PAGE_TOTAL]
		);
		INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
		INSERT_TEMPLATE_BLOCK(BACK_BLOCK_LIST_PAGE($pi));
	}
}

DUMP_TEMPLATE_PAGE();
