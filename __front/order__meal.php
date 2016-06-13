<?php

if (!isset($page)) exit();

$operation = RET_STR_GET(ARGUMENT_OPERATION);
$id = RET_STR_GET(POST_ID);
$id_tag = RET_STR_GET(POST_TAG);
$id_category = RET_STR_GET(POST_CATEGORY);
$id_group = '';

LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_MEAL), $meal_rows, $meal_rows_count, $meal_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_TAG), $tag_rows, $tag_rows_count, $tag_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_CATEGORY), $category_rows, $category_rows_count, $category_id_to_index);

ORDER_SEARCH_BARCODE();

if ($meal_rows_count > 0) {
	$fp = RET_DB_FILE(PREFIX_PAUSE);
	if (is_file($fp)) {
		$paused_ids = file_get_contents($fp);
		foreach ($meal_rows as &$row) {
			if (false !== strpos($paused_ids, $row[MEAL_ID])) {
				$row[MEAL_PAUSED] = '1';
			}
		}
	}
}

LOAD_TEMPLATE_PAGE('front_page_order', $the_page_caption);
INSERT_TEMPLATE_BLOCK($block_section);

if ('' != $id_tag) {
	if (!isset($tag_id_to_index[$id_tag])) E_TO(ERROR_CODE_UNKNOW_TAG);
	$row_tag = &$tag_rows[$tag_id_to_index[$id_tag]];
	if ('1' == $row_tag[TAG_HIDE]) E_TO(ERROR_CODE_UNKNOW_TAG);
	$id_group = $id_tag;
	
	if ('' != $id) {
		if (!isset($meal_id_to_index[$id])) E_TO(ERROR_CODE_UNKNOW_MEAL);
		$row_meal = &$meal_rows[$meal_id_to_index[$id]];
		if (!LOAD_DB_TO_CACHE(RET_DB_FILE_2(PREFIX_TAG, $id_tag), $rows, $rows_count, $id_to_index)) E_TO(ERROR_CODE_UNKNOW_MEAL);
		if (!isset($id_to_index[$id])) E_TO(ERROR_CODE_UNKNOW_MEAL);

		$action = $THIS_WEB_URL;
		APEND_URL_ARGUMENT($action, POST_TAG, $id_tag);
		INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_MEAL_INFO($action));
		INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_TAG_MEALS($row_tag[TAG_NAME]));
	} else {
		if (OPERATION_INSERT == $operation) {
			ORDER_MEAL_INSERT(false);
		} else {
			INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_TAG_MEALS($row_tag[TAG_NAME]));
		}
	}
} else {
	if ('' != $id_category) {
		if (!isset($category_id_to_index[$id_category])) E_TO(ERROR_CODE_UNKNOW_CATEGORY);
		$row_category = &$category_rows[$category_id_to_index[$id_category]];
		if ('1' == $row_category[CATEGORY_HIDE]) E_TO(ERROR_CODE_UNKNOW_CATEGORY);
		$id_group = $id_category;
		
		if ('' != $id) {
			if (!isset($meal_id_to_index[$id])) E_TO(ERROR_CODE_UNKNOW_MEAL);
			$row_meal = &$meal_rows[$meal_id_to_index[$id]];
			if ($id_category != $row_meal[MEAL_CATEGORY]) E_TO(ERROR_CODE_UNKNOW_MEAL);
			
			$action = $THIS_WEB_URL;
			APEND_URL_ARGUMENT($action, POST_CATEGORY, $id_category);
			INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_MEAL_INFO($action));
			INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_CATEGORY_MEALS($row_category[CATEGORY_NAME]));
		} else {
			if (OPERATION_INSERT == $operation) {
				ORDER_MEAL_INSERT(false);
			} else {
				INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_CATEGORY_MEALS($row_category[CATEGORY_NAME]));
			}
		}
	}
}
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_SEARCH_MEAL());
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_GROUPS());

DUMP_TEMPLATE_PAGE();
