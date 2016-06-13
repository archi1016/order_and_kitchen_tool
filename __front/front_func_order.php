<?php

define('PAGE_CART'			,'cart');
define('PAGE_CHECKOUT'			,'checkout');
define('PAGE_CANCEL'			,'cancel');

function FRONT_CHECK_CART_MEALS() {
	global $THIS_WEB_URL;
	global $tmp_id;
	global $cart_db;
	global $cart_rows;
	global $cart_rows_count;
	
	if (!CHECK_TMP_ID()) {
		APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_TMP_ID, RET_A_TMP_ID());
		P_TO($THIS_WEB_URL);
	}
	LOAD_DB($cart_db, $cart_rows, $cart_rows_count);
	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_TMP_ID, $tmp_id);
	
	define('CART_ROWS'	,$cart_rows_count);
	define('CART_TOTAL'	,RET_CART_TOTAL());
}

function FRONT_BLOCK_ORDER_SECTION($prev_url) {
	global $THIS_WEB_URL;
	global $page;
	global $tmp_row;
	
	if (CART_ROWS > 0) {
		$rows = ' ('.CART_ROWS.')';
	} else {
		$rows = '';
	}
	if (CART_TOTAL > 0) {
		$total = ' ('.CART_TOTAL.')';
	} else {
		$total = '';
	}

	$section_info = array(
		array('',		FRONT_ORDER_SECTION_MENU)
		,array(PAGE_CART,	sprintf(FRONT_ORDER_SECTION_CART, $rows))
		,array(PAGE_CHECKOUT,	sprintf(FRONT_ORDER_SECTION_CHECKOUT, $total))
	);
	
	$block = RET_TEMPLATE_CONTENT('front_order_section');
	if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
		foreach ($section_info as &$r) {
			$link_url = $prev_url;
			APEND_URL_ARGUMENT($link_url, ARGUMENT_PAGE, $r[COMMON_ID]);
			
			$c = 'link';
			if ($page == $r[COMMON_ID]) $c = 'current';
			
			$ra[] = array(
				'section_url'		=> $link_url
				,'section_name'		=> $r[COMMON_NAME]
				,'section_class'	=> $c
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	
	$search_action = 'front_order.php?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN;
	APEND_URL_ARGUMENT($search_action, ARGUMENT_TMP_ID, $tmp_row[TMP_ID]);
	$cancel_url = $prev_url;
	APEND_URL_ARGUMENT($cancel_url, ARGUMENT_PAGE, PAGE_CANCEL);
	
	$ra = array(
		'form_number'		=> $tmp_row[TMP_NUMBER]
		,'cancel_url'		=> $cancel_url
		,'cancel_confirm'	=> STR_TO_JS(FRONT_ORDER_CANCEL_CONFIRM)
		,'action_url'		=> $search_action
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	return $block;
}

function ORDER_BLOCK_LIST_GROUPS() {
	global $THIS_WEB_URL;
	global $tag_rows;
	global $tag_rows_count;
	global $category_rows;
	global $category_rows_count;
	global $id_tag;
	global $id_category;
	
	$block = RET_TEMPLATE_CONTENT('front_order_list_category');
	if (MATCH_TEMPLATE_LIST_ITEM('category', $block, $key, $item, $ra)) {
		if ($tag_rows_count > 0) {
			foreach ($tag_rows as &$row) {
				if ('1' != $row[TAG_HIDE]) {
					$link_url = $THIS_WEB_URL;
					APEND_URL_ARGUMENT($link_url, POST_TAG, '');
			
					$c = 'link';
					if ($id_tag == $row[TAG_ID]) $c = 'current';
				
					$ra[] = array(
						'category_url'		=> $link_url.$row[TAG_ID]
						,'category_name'	=> STR_TO_HTML($row[TAG_NAME])
						,'category_photo'	=> FOLDER_TAG.'/'.RET_PHOTO_NAME($row[TAG_ID], '', $row[TAG_PHOTO]).'?'.RANDOM_STRING
						,'category_photo_front'	=> FOLDER_TAG.'/'.RET_PHOTO_NAME($row[TAG_ID], PHOTO_GROUP_FRONT_WIDTH, $row[TAG_PHOTO]).'?'.RANDOM_STRING
						,'category_photo_order'	=> FOLDER_TAG.'/'.RET_PHOTO_NAME($row[TAG_ID], PHOTO_GROUP_ORDER_WIDTH, $row[TAG_PHOTO]).'?'.RANDOM_STRING
						,'category_class'	=> $c
					);
				}
			}
		}
		if ($category_rows_count > 0) {
			foreach ($category_rows as &$row) {
				if ('1' != $row[CATEGORY_HIDE]) {
					$link_url = $THIS_WEB_URL;
					APEND_URL_ARGUMENT($link_url, POST_CATEGORY, '');
				
					$c = 'link';
					if ($id_category == $row[CATEGORY_ID]) $c = 'current';
				
					$ra[] = array(
						'category_url'		=> $link_url.$row[CATEGORY_ID]
						,'category_name'	=> STR_TO_HTML($row[CATEGORY_NAME])
						,'category_photo'	=> FOLDER_CATEGORY.'/'.RET_PHOTO_NAME($row[CATEGORY_ID], '', $row[CATEGORY_PHOTO]).'?'.RANDOM_STRING
						,'category_photo_front'	=> FOLDER_CATEGORY.'/'.RET_PHOTO_NAME($row[CATEGORY_ID], PHOTO_GROUP_FRONT_WIDTH, $row[CATEGORY_PHOTO]).'?'.RANDOM_STRING
						,'category_photo_order'	=> FOLDER_CATEGORY.'/'.RET_PHOTO_NAME($row[CATEGORY_ID], PHOTO_GROUP_ORDER_WIDTH, $row[CATEGORY_PHOTO]).'?'.RANDOM_STRING
						,'category_class'	=> $c
					);
				}
			}
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_LIST_CATEGORY_MEALS($t) {
	global $meal_rows;
	global $meal_rows_count;
	global $id_category;
	
	$block = RET_TEMPLATE_CONTENT('front_order_list_meal');
	$ra = array(
		'category_name' => STR_TO_HTML($t)
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
		if ($meal_rows_count > 0) {
			foreach ($meal_rows as &$row) {
				if ($id_category == $row[MEAL_CATEGORY]) {
					if (ORDER_ITEM_MEAL(POST_CATEGORY, $id_category, $row, $ra)) {
					}
				}
			}
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_LIST_TAG_MEALS($t) {
	global $id_tag;
	global $meal_rows;
	global $meal_id_to_index;
	
	$block = RET_TEMPLATE_CONTENT('front_order_list_meal');
	$ra = array(
		'category_name' => STR_TO_HTML($t)
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
		if (LOAD_DB(RET_DB_FILE_2(PREFIX_TAG, $id_tag), $rows, $rows_count)) {
			foreach ($rows as &$row) {
				if (isset($meal_id_to_index[$row[MB_TAG_ID]])) {
					$row = &$meal_rows[$meal_id_to_index[$row[MB_TAG_ID]]];
					if (ORDER_ITEM_MEAL(POST_TAG, $id_tag, $row, $ra)) {
					}
				}
			}
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_ITEM_MEAL($pt, $pid, &$r, &$ra) {
	global $THIS_WEB_URL;
	global $id;
	
	if ('1' == $r[MEAL_HIDE]) return false;
	
	$link_url = $THIS_WEB_URL;
	APEND_URL_ARGUMENT($link_url, $pt, $pid);
	APEND_URL_ARGUMENT($link_url, POST_ID, $r[MEAL_ID]);
	
	$c = 'link';
	if ('1' != $r[MEAL_PAUSED]) {
		if ($r[MEAL_ID] == $id) $c = 'current';
	} else {
		$c = 'paused';
	}
	
	$ra[] = array(
		'meal_url'		=> $link_url
		,'meal_name'		=> STR_TO_HTML($r[MEAL_NAME])
		,'meal_barcode'		=> $r[MEAL_BARCODE]
		,'meal_photo'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], '', $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_front'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_FRONT_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_order'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_ORDER_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_cart'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_CART_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_large'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_LARGE_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_price'		=> $r[MEAL_PRICE]
		,'meal_description'	=> STR_TO_HTML($r[MEAL_DESCRIPTION])
		,'meal_barcode'		=> $r[MEAL_BARCODE]
		,'meal_class'		=> $c
	);
	return true;
}

function ORDER_BLOCK_MEAL_INFO($action) {
	global $THIS_WEB_URL;
	global $row_meal;
	
	if ('1' == $row_meal[MEAL_PAUSED]) {
		$block = RET_TEMPLATE_CONTENT('front_order_meal_paused');
		$ra = array(
			'meal_name' 		=> STR_TO_HTML($row_meal[MEAL_NAME]).' $'.$row_meal[MEAL_PRICE]
		);
		return RET_REPLACED_TEMPLATE($block, $ra);
	}
	
	APEND_URL_ARGUMENT($action, ARGUMENT_OPERATION, OPERATION_INSERT);
			
	$block = RET_TEMPLATE_CONTENT('front_order_meal');
	$ra = array(
		'action_url'		=> $action
		,'meal_id'		=> $row_meal[MEAL_ID]
		,'meal_name'		=> STR_TO_HTML($row_meal[MEAL_NAME]).' $'.$row_meal[MEAL_PRICE]
		,'meal_barcode'		=> $row_meal[MEAL_BARCODE]
		,'meal_photo'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], '', $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_front'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_FRONT_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_order'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_ORDER_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_cart'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_CART_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_large'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_LARGE_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'block_flavor'		=> ORDER_BLOCK_LIST_FLAVORS($row_meal[MEAL_FLAVOR])
		,'block_additional'	=> ORDER_BLOCK_LIST_ADDITIONALS($row_meal[MEAL_ADDITIONAL])
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function ORDER_BLOCK_LIST_FLAVORS($flavor_id) {
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_FLAVOR), $rows, $rows_count, $id_to_index)) return;
	if (!isset($id_to_index[$flavor_id])) return;
	$row = &$rows[$id_to_index[$flavor_id]];
	if (!LOAD_DB(RET_DB_FILE_2(PREFIX_FLAVOR, $row[FLAVOR_ID]), $rows, $rows_count)) return;
	
	$block = RET_TEMPLATE_CONTENT('front_order_list_flavor');
	if (MATCH_TEMPLATE_LIST_ITEM('flavor', $block, $key, $item, $ra)) {
		foreach ($rows as &$row) {
			$ra[] = array(
				'flavor_id'	=> $row[MB_FLAVOR_ID]
				,'flavor_name'	=> STR_TO_HTML($row[MB_FLAVOR_NAME])
				,'flavor_photo'	=> FOLDER_FLAVOR.'/'.RET_PHOTO_NAME($row[MB_FLAVOR_ID], '', $row[MB_FLAVOR_PHOTO]).'?'.RANDOM_STRING
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_LIST_ADDITIONALS($additional_id) {
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_ADDITIONAL), $rows, $rows_count, $id_to_index)) return false;
	if (!isset($id_to_index[$additional_id])) return;
	$row = &$rows[$id_to_index[$additional_id]];
	if (!LOAD_DB(RET_DB_FILE_2(PREFIX_ADDITIONAL, $row[ADDITIONAL_ID]), $rows, $rows_count)) return;
	
	$block = RET_TEMPLATE_CONTENT('front_order_list_additional');
	if (MATCH_TEMPLATE_LIST_ITEM('additional', $block, $key, $item, $ra)) {
		foreach ($rows as &$row) {
			$ra[] = array(
				'additional_id'		=> $row[MB_ADDITIONAL_ID]
				,'additional_name'	=> STR_TO_HTML($row[MB_ADDITIONAL_NAME])
				,'additional_photo'	=> FOLDER_ADDITIONAL.'/'.RET_PHOTO_NAME($row[MB_ADDITIONAL_ID], '', $row[MB_ADDITIONAL_PHOTO]).'?'.RANDOM_STRING
				,'additional_price'	=> $row[MB_ADDITIONAL_PRICE]
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_SEARCH_BARCODE() {
	global $THIS_WEB_URL;
	global $meal_rows;
	global $meal_rows_count;
	global $category_rows;
	global $category_id_to_index;
	
	if (0 >= $meal_rows_count) return;
	
	$kw = RET_STR_POST(POST_SEARCH_KEYWORD);
	if ('' == $kw) return;

	foreach ($meal_rows as &$row) {
		if ($kw == $row[MEAL_BARCODE]) {
			if ('1' != $row[MEAL_HIDE]) {
				if (isset($category_id_to_index[$row[MEAL_CATEGORY]])) {
					$row_category = $category_id_to_index[$row[MEAL_CATEGORY]];
					if ('1' != $category_rows[$row_category][CATEGORY_HIDE]) {
						$link_url = $THIS_WEB_URL;
						APEND_URL_ARGUMENT($link_url, POST_CATEGORY, $row[MEAL_CATEGORY]);
						APEND_URL_ARGUMENT($link_url, POST_ID, $row[MEAL_ID]);
						P_TO($link_url);
					}
				}
			}
			break;
		}
	}
}

function ORDER_BLOCK_SEARCH_MEAL() {
	global $THIS_WEB_URL;
	global $meal_rows;
	global $meal_rows_count;
	global $category_rows;
	global $category_id_to_index;
	
	if (0 >= $meal_rows_count) return;
	
	$kw = RET_STR_POST(POST_SEARCH_KEYWORD);
	if ('' == $kw) return;

	foreach ($meal_rows as $index => &$row) {
		if (false !== strpos($row[MEAL_NAME], $kw)) {
			if ('1' != $row[MEAL_HIDE]) {
				if (isset($category_id_to_index[$row[MEAL_CATEGORY]])) {
					$row_category = $category_id_to_index[$row[MEAL_CATEGORY]];
					if ('1' != $category_rows[$row_category][CATEGORY_HIDE]) {
						$category_indexs[] = $row_category;
						$meal_indexs[] = $index;
					}
				}
			}
		}
	}
	if (!isset($meal_indexs)) return;

	$block = RET_TEMPLATE_CONTENT('front_order_list_meal');
	$ra = array(
		'category_name' => FRONT_MEAL_TITLE_SEARCH
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
		foreach ($meal_indexs as $i => $r) {
			$row = &$meal_rows[$meal_indexs[$i]];
			if (ORDER_ITEM_MEAL(POST_CATEGORY, $category_rows[$category_indexs[$i]][CATEGORY_ID], $row, $ra)) {
			}
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}
