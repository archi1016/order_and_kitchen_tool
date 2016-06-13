<?php

require('func.php');
require('__order/order_func.php');

ORDER_CHECK_CART_MEALS();

$the_operation = RET_STR_GET(ARGUMENT_OPERATION);
$id = RET_STR_GET(POST_ID);
$id_tag = RET_STR_GET(POST_TAG);
$id_category = RET_STR_GET(POST_CATEGORY);
$id_group = '';

LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_MEAL), $meal_rows, $meal_rows_count, $meal_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_TAG), $tag_rows, $tag_rows_count, $tag_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_CATEGORY), $category_rows, $category_rows_count, $category_id_to_index);

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

if ('' != $id_tag) {
	if (!isset($tag_id_to_index[$id_tag])) E_TO(ERROR_CODE_UNKNOW_TAG);
	$row_tag = &$tag_rows[$tag_id_to_index[$id_tag]];
	if ('1' == $row_tag[TAG_HIDE]) E_TO(ERROR_CODE_UNKNOW_TAG);
	$id_group = $id_tag;
	
	if ('' != $id) {
		if (!isset($meal_id_to_index[$id])) E_TO(ERROR_CODE_UNKNOW_MEAL);
		$row_meal = &$meal_rows[$meal_id_to_index[$id]];
		if (LOAD_DB_TO_CACHE(RET_DB_FILE_2(PREFIX_TAG, $id_tag), $rows, $rows_count, $id_to_index)) {
			if (!isset($id_to_index[$id])) E_TO(ERROR_CODE_UNKNOW_MEAL);
		} else {
			E_TO(ERROR_CODE_UNKNOW_MEAL);
		}
		
		require('__order/meal__info__tag.php');
	} else {
		require('__order/meal__tag.php');
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
			
			require('__order/meal__info__category.php');
		} else {
			require('__order/meal__category.php');
		}
	} else {
		require('__order/meal__all.php');
	}
}
