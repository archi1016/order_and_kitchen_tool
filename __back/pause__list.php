<?php

if (!isset($the_operation)) exit();

define('CHILDS_COUNT',		'count');
define('CHILDS_TITLE',		'title');

define('CHILD_INDEX',		'index');
define('CHILD_USED',		'used');

function LIST_FORM_CHILDS(&$block, &$ch) {
	global $meal_rows;
	
	if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
		$i = 0;
		while ($i < $ch[CHILDS_COUNT]) {
			$row = &$meal_rows[$ch[$i][CHILD_INDEX]];
	
			if (false !== $ch[$i][CHILD_USED]) {
				$class	= 'checked';
				$check	= ' checked';
			} else {
				$class	= '';
				$check	= '';
			}
			
			$ra[] = array(
				'meal_id'	=> $row[MEAL_ID]
				,'meal_name'	=> STR_TO_HTML($row[MEAL_NAME])
				,'meal_photo'	=> RET_PHOTO_FILE(FOLDER_MEAL, $row[MEAL_ID], $row[MEAL_PHOTO])
				,'meal_price'	=> $row[MEAL_PRICE]
				,'meal_class'	=> $class
				,'meal_checked'	=> $check
			);
			++$i;
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
}


LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_CATEGORY), $category_rows, $category_rows_count, $category_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_MEAL), $meal_rows, $meal_rows_count, $meal_id_to_index);

LOAD_TEMPLATE_PAGE('back_page', $the_title);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

if (is_file($the_db)) {
	$used_ids = file_get_contents($the_db);
} else {
	$used_ids = '';
}
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

$block = RET_TEMPLATE_CONTENT('back_pause_edit');	
if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
	$h = '';
	if (($category_rows_count > 0) && ($meal_rows_count > 0)) {
		$i = 0;
		while ($i < $category_rows_count) {
			$category_childs[$i][CHILDS_COUNT] = 0;
			$category_childs[$i][CHILDS_TITLE] = $category_rows[$i][CATEGORY_NAME];
			++$i;
		}
		$category_childs[$category_rows_count][CHILDS_COUNT] = 0;
		$category_childs[$category_rows_count][CHILDS_TITLE] = BACK_PAUSE_UNKNOW_CATEGORY;
		
		$i = 0;
		while ($i < $meal_rows_count) {
			$id = $meal_rows[$i][MEAL_CATEGORY];
			if (isset($category_id_to_index[$id])) {
				$row = &$category_childs[$category_id_to_index[$id]];
				$c = &$row[CHILDS_COUNT];
				$row[$c][CHILD_INDEX]	= $i;
				$row[$c][CHILD_USED]	= strpos($used_ids, $meal_rows[$i][MEAL_ID]);
				++$c;
			} else {
				$row = &$category_childs[$category_rows_count];
				$c = &$row[CHILDS_COUNT];
				$row[$c][CHILD_INDEX]	= $i;
				$row[$c][CHILD_USED]	= strpos($used_ids, $meal_rows[$i][MEAL_ID]);
				++$c;
			}
			++$i;
		}

		$i = 0;
		while ($i <= $category_rows_count) {
			$ch = &$category_childs[$i];
		
			if ($ch[CHILDS_COUNT] > 0) {
				$item_with_child = $item;
				
				LIST_FORM_CHILDS($item_with_child, $ch);
			
				$ra = array(
					'category_name' => STR_TO_HTML($ch[CHILDS_TITLE])
				);
				$h .= RET_REPLACED_TEMPLATE($item_with_child, $ra);
			}
			++$i;
		}
	}
	$block = str_replace($key, $h, $block);
}
$ra = array(
	'action_title'		=> sprintf(BACK_TITLE_MODIFY, $the_title)
	,'action_url'		=> $THIS_WEB_URL
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
