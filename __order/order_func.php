<?php

require('__order/order_config.php');

INIT_TEMPLATE_PATH_WITH_LANGUAGE('__order');

define('FIRST_PAGE'			,'order.php');

define('ORDER_MODE_HERE'		,'here');
define('ORDER_MODE_TAKEAWAY'		,'takeaway');

define('GROUP_POST'			,0);
define('GROUP_ID'			,1);
define('GROUP_ROW'			,2);

define('ITEM_GROUP_POST'		,0);
define('ITEM_GROUP_ID'			,1);
define('ITEM_ID'			,2);

$the_mode = RET_STR_GET(ARGUMENT_MODE);
switch ($the_mode) {
	case ORDER_MODE_HERE:
		break;
	case ORDER_MODE_TAKEAWAY:
		break;
	default:
		E_TO(ERROR_CODE_UNKNOW_ORDER_MODE);
		break;
}

define('CURRENT_ORDER_MODE', $the_mode);

$THIS_WEB_URL .= '?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);

function ORDER_CHECK_CART_MEALS() {
	global $THIS_WEB_URL;
	global $tmp_id;
	global $cart_db;
	global $cart_rows;
	global $cart_rows_count;
	
	if ('1' == CONFIG_DEMO_MODE) {
	}
	
	if ('1' == CONFIG_DISABLE_CLIENT_ORDER) {
		$link_url = FIRST_PAGE.'?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
		APEND_URL_ARGUMENT($link_url, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
		P_TO($link_url);
	}
	
	if (!CHECK_TMP_ID()) {
		if (30 > RET_TMP_ID_ROWS()) {
			APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_TMP_ID, RET_A_TMP_ID());
			P_TO($THIS_WEB_URL);
		} else {
			E_TO(ERROR_CODE_OVER_TMP_LIMIT);
		}
	}
	LOAD_DB($cart_db, $cart_rows, $cart_rows_count);
	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_TMP_ID, $tmp_id);
	
	define('CART_ROWS'	,$cart_rows_count);
	define('CART_TOTAL'	,RET_CART_TOTAL());
}

function ORDER_BLOCK_SECTION_LIST() {
	global $tmp_id;
	
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
		array('order_notice.php'	,ORDER_SECTION_NOTICE)
		,array('order_meal.php'		,ORDER_SECTION_MEAL)
		,array('order_cart.php'		,sprintf(ORDER_SECTION_CART, $rows))
		,array('order_checkout.php'	,sprintf(ORDER_SECTION_CHECKOUT, $total))
	);
	
	$arguments = '?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
	APEND_URL_ARGUMENT($arguments, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
	APEND_URL_ARGUMENT($arguments, ARGUMENT_TMP_ID, $tmp_id);
	
	$block = RET_TEMPLATE_CONTENT('order_section');
	if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
		foreach ($section_info as &$r) {
			$c = 'link';
			if (THIS_PHP_FILE == $r[COMMON_ID]) $c = 'current';
			
			$ra[] = array(
				'section_url'		=> $r[COMMON_ID].$arguments
				,'section_name'		=> $r[COMMON_NAME]
				,'section_class'	=> $c
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_FOOTER() {
	global $tmp_id;
	
	$cancel_url = 'order_cancel.php?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
	APEND_URL_ARGUMENT($cancel_url, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
	APEND_URL_ARGUMENT($cancel_url, ARGUMENT_TMP_ID, $tmp_id);
	
	$block = RET_TEMPLATE_CONTENT('order_footer');
	$ra = array(
		'cancel_url' => $cancel_url
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function ORDER_BLOCK_LANG_BAR() {
	$block = RET_TEMPLATE_CONTENT('order_home_language_bar');
	if (MATCH_TEMPLATE_LIST_ITEM('language', $block, $key, $item, $ra)) {
		$link_url = FIRST_PAGE.'?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
		APEND_URL_ARGUMENT($link_url, ARGUMENT_LANGUAGE, '');

		if (FIND_FILES_FROM_FOLDER(TEMPLATE_PATH, '.ini', $fs)) {
			foreach ($fs as $f) {
				if (1 == preg_match('/^lang\.(.*)\.ini$/', $f, $ms)) {
					$id = $ms[1];
					$icon = 'lang.'.$id.'.png';
					$name = 'unknow';
				
					$lang_content = file_get_contents(TEMPLATE_PATH.'/'.$f);
					if (1 == preg_match('/([^;]LANGUAGE_NAME)\s*=\s*"(.[^"]*)"/', $lang_content, $ms)) {
						$name = $ms[2];
					}
				
					$c = 'link';
					if (PAGE_LANGUAGE == $id) $c = 'current';
				
					$ra[] = array(
						'language_name'		=> $name
						,'language_icon'	=> TEMPLATE_PATH.'/'.$icon
						,'language_url'		=> $link_url.$id
						,'language_class'	=> $c
					);
				}
			}
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_NAV_BAR() {
	$arguments = '?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
	APEND_URL_ARGUMENT($arguments, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
	
	$block = RET_TEMPLATE_CONTENT('order_home_navigate_bar');
	if (MATCH_TEMPLATE_LIST_ITEM('navigate', $block, $key, $item, $ra)) {
		$ra[] = array(
			'navigate_url'		=> 'order_meal.php'.$arguments
			,'navigate_name'	=> ORDER_HOME_NAVIGATE_MENU
		);
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_NOTICE() {
	$n = RET_DB_FILE(PREFIX_NOTICE);
	if (is_file($n)) {
		$n = STR_TO_HTML(file_get_contents($n));
	} else {
		$n = ORDER_HOME_EMPTY_NOTICE;
	}
	
	$block = RET_TEMPLATE_CONTENT('order_notice');
	$ra = array(
		'notice' => $n
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function ORDER_BLOCK_AUTO_REFRESH() {
	$link_url = FIRST_PAGE.'?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
	APEND_URL_ARGUMENT($link_url, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
	
	$block = RET_TEMPLATE_CONTENT('order_home_refresh');
	$ra = array(
		'refresh_seconds'	=> 300
		,'refresh_url'		=> $link_url
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function ORDER_BUILD_ITEM_LINE_IDS() {
	global $item_rows;
	global $item_rows_count;
	global $item_mixed_id_to_index;
	global $tag_rows;
	global $tag_rows_count;
	global $category_rows;
	global $category_id_to_index;
	global $meal_rows;
	global $meal_id_to_index;
	
	$item_rows_count = 0;
	if ($tag_rows_count > 0) {
		foreach ($tag_rows as &$row) {
			if ('1' != $row[TAG_HIDE]) {
				if ('1' != $row[TAG_HIDE_IN_ORDER]) {
					if (LOAD_DB(RET_DB_FILE_2(PREFIX_TAG, $row[TAG_ID]), $rows_2, $rows_count_2)) {
						foreach ($rows_2 as &$row_2) {
							if (isset($meal_id_to_index[$row_2[MB_TAG_ID]])) {
								$row_3 = &$meal_rows[$meal_id_to_index[$row_2[MB_TAG_ID]]];
								if ('1' != $row_3[MEAL_HIDE]) {
									if ('1' != $row_3[MEAL_HIDE_IN_ORDER]) {
										$item_rows[$item_rows_count][ITEM_GROUP_POST]	= POST_TAG;
										$item_rows[$item_rows_count][ITEM_GROUP_ID]	= $row[TAG_ID];
										$item_rows[$item_rows_count][ITEM_ID]		= $row_3[MEAL_ID];
										$item_mixed_id_to_index[$row[TAG_ID].$row_3[MEAL_ID]] = $item_rows_count;
										++$item_rows_count;
									}
								}
							}
						}
					}
				}
			}
		}
	}
	foreach ($meal_rows as &$row) {
		if ('1' != $row[MEAL_HIDE]) {
			if ('1' != $row[MEAL_HIDE_IN_ORDER]) {
				if (isset($category_id_to_index[$row[MEAL_CATEGORY]])) {
					$row_2 = &$category_rows[$category_id_to_index[$row[MEAL_CATEGORY]]];
					if ('1' != $row_2[CATEGORY_HIDE]) {
						if ('1' != $row_2[CATEGORY_HIDE_IN_ORDER]) {
							$item_rows[$item_rows_count][ITEM_GROUP_POST]	= POST_CATEGORY;
							$item_rows[$item_rows_count][ITEM_GROUP_ID]	= $row_2[CATEGORY_ID];
							$item_rows[$item_rows_count][ITEM_ID]		= $row[MEAL_ID];
							$item_mixed_id_to_index[$row_2[CATEGORY_ID].$row[MEAL_ID]] = $item_rows_count;
							++$item_rows_count;
						}
					}
				}
			}
		}
	}
}

function ORDER_BLOCK_NAV_ITEM() {
	global $item_rows_count;
	global $item_mixed_id_to_index;
	global $id_group;
	global $id;
	
	if (1 >= $item_rows_count) return '';
	if (!isset($item_mixed_id_to_index[$id_group.$id])) return '';
	
	$i = $item_mixed_id_to_index[$id_group.$id];
	$p = $i - 1;
	$n = $i + 1;
	if ($p < 0) $p = $item_rows_count - 1;
	if ($n >= $item_rows_count) $n = 0;
	
	$block = RET_TEMPLATE_CONTENT('order_prev_and_next');
	$ra = array(
		'prev_url'	=> RET_NAV_ITEM_LINK($p)
		,'next_url'	=> RET_NAV_ITEM_LINK($n)
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function RET_NAV_ITEM_LINK($index) {
	global $THIS_WEB_URL;
	global $item_rows;
	
	$row = &$item_rows[$index];
			
	$link_url = $THIS_WEB_URL;
	APEND_URL_ARGUMENT($link_url, $row[ITEM_GROUP_POST], $row[ITEM_GROUP_ID]);
	APEND_URL_ARGUMENT($link_url, POST_ID, $row[ITEM_ID]);

	return $link_url;
}

function ORDER_BUILD_GROUP_LINE_IDS() {
	global $group_rows;
	global $group_rows_count;
	global $group_id_to_index;
	global $tag_rows;
	global $tag_rows_count;
	global $category_rows;
	global $category_rows_count;
	
	$group_rows = null;
	$group_rows_count = 0;
	$group_id_to_index = null;
	
	if ($tag_rows_count > 0) {
		foreach ($tag_rows as &$row) {
			if ('1' != $row[TAG_HIDE]) {
				if ('1' != $row[TAG_HIDE_IN_ORDER]) {
					$group_rows[$group_rows_count][GROUP_POST]	= POST_TAG;
					$group_rows[$group_rows_count][GROUP_ID]	= $row[TAG_ID];
					$group_rows[$group_rows_count][GROUP_ROW]	= $row;
					$group_id_to_index[$row[TAG_ID]] = $group_rows_count;
					++$group_rows_count;
				}
			}
		}
	}
	if ($category_rows_count > 0) {
		foreach ($category_rows as &$row) {
			if ('1' != $row[CATEGORY_HIDE]) {
				if ('1' != $row[CATEGORY_HIDE_IN_ORDER]) {
					$group_rows[$group_rows_count][GROUP_POST]	= POST_CATEGORY;
					$group_rows[$group_rows_count][GROUP_ID]	= $row[CATEGORY_ID];
					$group_rows[$group_rows_count][GROUP_ROW]	= $row;
					$group_id_to_index[$row[CATEGORY_ID]] = $group_rows_count;
					++$group_rows_count;
				}
			}
		}
	}
}

function ORDER_BLOCK_NAV_GROUP() {
	global $group_rows_count;
	global $group_id_to_index;
	global $id_group;
	
	if (1 >= $group_rows_count) return '';
	if (!isset($group_id_to_index[$id_group])) return '';
	
	$i = $group_id_to_index[$id_group];
	$p = $i - 1;
	$n = $i + 1;
	if ($p < 0) $p = $group_rows_count - 1;
	if ($n >= $group_rows_count) $n = 0;
		
	$block = RET_TEMPLATE_CONTENT('order_prev_and_next');
	$ra = array(
		'prev_url'	=> RET_NAV_GROUP_LINK($p)
		,'next_url'	=> RET_NAV_GROUP_LINK($n)
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function RET_NAV_GROUP_LINK($index) {
	global $THIS_WEB_URL;
	global $group_rows;
	
	$row = &$group_rows[$index];
	
	$link_url = $THIS_WEB_URL;
	APEND_URL_ARGUMENT($link_url, $row[GROUP_POST], $row[GROUP_ID]);
	
	return $link_url;
}

function ORDER_BLOCK_LIST_GROUPS() {
	global $THIS_WEB_URL;
	global $group_rows;
	global $group_rows_count;
	global $tag_rows;
	global $category_rows;
	global $id_tag;
	global $id_category;
	
	$block = RET_TEMPLATE_CONTENT('order_list_category');
	if (MATCH_TEMPLATE_LIST_ITEM('category', $block, $key, $item, $ra)) {
		if ($group_rows_count > 0) {
			foreach ($group_rows as &$group_row) {
				$row = &$group_row[GROUP_ROW];
	
				$link_url = $THIS_WEB_URL;
				APEND_URL_ARGUMENT($link_url, $group_row[GROUP_POST], '');
		
				switch ($group_row[GROUP_POST]) {
					case POST_TAG:
						$c = 'link';
						if ($id_tag == $row[TAG_ID]) $c = 'current';
				
						$ra[] = array(
							'category_url'			=> $link_url.$row[TAG_ID]
							,'category_name'		=> STR_TO_HTML($row[TAG_NAME])
							,'category_name_english'	=> STR_TO_HTML($row[TAG_NAME_EN])
							,'category_photo'		=> FOLDER_TAG.'/'.RET_PHOTO_NAME($row[TAG_ID], '', $row[TAG_PHOTO]).'?'.RANDOM_STRING
							,'category_photo_front'		=> FOLDER_TAG.'/'.RET_PHOTO_NAME($row[TAG_ID], PHOTO_GROUP_FRONT_WIDTH, $row[TAG_PHOTO]).'?'.RANDOM_STRING
							,'category_photo_order'		=> FOLDER_TAG.'/'.RET_PHOTO_NAME($row[TAG_ID], PHOTO_GROUP_ORDER_WIDTH, $row[TAG_PHOTO]).'?'.RANDOM_STRING
							,'category_class'		=> $c
						);
						break;

					case POST_CATEGORY:
						$c = 'link';
						if ($id_category == $row[CATEGORY_ID]) $c = 'current';
				
						$ra[] = array(
							'category_url'			=> $link_url.$row[CATEGORY_ID]
							,'category_name'		=> STR_TO_HTML($row[CATEGORY_NAME])
							,'category_name_english'	=> STR_TO_HTML($row[CATEGORY_NAME_EN])
							,'category_photo'		=> FOLDER_CATEGORY.'/'.RET_PHOTO_NAME($row[CATEGORY_ID], '', $row[CATEGORY_PHOTO]).'?'.RANDOM_STRING
							,'category_photo_front'		=> FOLDER_CATEGORY.'/'.RET_PHOTO_NAME($row[CATEGORY_ID], PHOTO_GROUP_FRONT_WIDTH, $row[CATEGORY_PHOTO]).'?'.RANDOM_STRING
							,'category_photo_order'		=> FOLDER_CATEGORY.'/'.RET_PHOTO_NAME($row[CATEGORY_ID], PHOTO_GROUP_ORDER_WIDTH, $row[CATEGORY_PHOTO]).'?'.RANDOM_STRING
							,'category_class'		=> $c
						);
						break;
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
	
	$block = RET_TEMPLATE_CONTENT('order_list_meal');
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
	
	$block = RET_TEMPLATE_CONTENT('order_list_meal');
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

function ORDER_BLOCK_LIST_RANDOM_MEALS() {
	global $meal_rows;
	global $meal_rows_count;
	global $category_rows;
	global $category_id_to_index;
	
	if ('1' == CONFIG_DISABLE_RANDOM_MEALS) return '';
	if (0 >= $meal_rows_count) return '';
	
	$i = 0;
	while ($i < $meal_rows_count) {
		$ri[$i] = $i;
		++$i;
	}
	
	$i = 0;
	while ($i < 1000) {
		$x = rand(0, $meal_rows_count-1);
		$y = rand(0, $meal_rows_count-1);
		$v = $ri[$x];
		$ri[$x] = $ri[$y];
		$ri[$y] = $v;
		++$i;
	}
	
	$block = RET_TEMPLATE_CONTENT('order_list_meal');
	$ra = array(
		'category_name' => STR_TO_HTML(ORDER_MEAL_TITLE_RANDOM)
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	if (MATCH_TEMPLATE_LIST_ITEM('meal', $block, $key, $item, $ra)) {
		$i = 0;
		$c = 0;
		while ($i < $meal_rows_count) {
			$row = &$meal_rows[$ri[$i]];

			if (isset($category_id_to_index[$row[MEAL_CATEGORY]])) {
				$row_category = $category_id_to_index[$row[MEAL_CATEGORY]];
				if ('1' != $category_rows[$row_category][CATEGORY_HIDE]) {
					if ('1' != $category_rows[$row_category][CATEGORY_HIDE_IN_ORDER]) {
						if (ORDER_ITEM_MEAL(POST_CATEGORY, $category_rows[$row_category][CATEGORY_ID], $row, $ra)) {
							++$c;
						}
					}
				}
			}
		
			++$i;
			if ($c >= $meal_rows_count) break;
			if ($c >= 6) break;
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_ITEM_MEAL($pt, $pid, &$r, &$ra) {
	global $tmp_id;
	global $id;
	
	if ('1' == $r[MEAL_HIDE]) return false;
	if ('1' == $r[MEAL_HIDE_IN_ORDER]) return false;
	
	$link_url = 'order_meal.php?'.ARGUMENT_MODE.'='.CURRENT_ORDER_MODE;
	APEND_URL_ARGUMENT($link_url, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);
	APEND_URL_ARGUMENT($link_url, ARGUMENT_TMP_ID, $tmp_id);
	APEND_URL_ARGUMENT($link_url, $pt, $pid);
	APEND_URL_ARGUMENT($link_url, POST_ID, $r[MEAL_ID]);
	
	$c = 'link';
	if ('1' != $r[MEAL_PAUSED]) {
		if ($r[MEAL_ID] == $id) $c = 'current';
	} else {
		$c = 'paused';
	}
		
	$ra[] = array(
		'meal_url'			=> $link_url
		,'meal_name'			=> STR_TO_HTML($r[MEAL_NAME])
		,'meal_name_english'		=> STR_TO_HTML($r[MEAL_NAME_EN])
		,'meal_barcode'			=> $r[MEAL_BARCODE]
		,'meal_photo'			=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], '', $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_front'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_FRONT_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_order'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_ORDER_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_cart'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_CART_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_large'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($r[MEAL_ID], PHOTO_MEAL_LARGE_WIDTH, $r[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_price'			=> $r[MEAL_PRICE]
		,'meal_description'		=> STR_TO_HTML($r[MEAL_DESCRIPTION])
		,'meal_description_english'	=> STR_TO_HTML($r[MEAL_DESCRIPTION_EN])
		,'meal_barcode'			=> $r[MEAL_BARCODE]
		,'meal_class'			=> $c
	);
	return true;
}

function ORDER_BLOCK_MEAL_INFO($t, $action) {
	global $THIS_WEB_URL;
	global $row_meal;
	
	if ('1' == $row_meal[MEAL_PAUSED]) {
		$block = RET_TEMPLATE_CONTENT('order_meal_paused');
	} else {
		$block = RET_TEMPLATE_CONTENT('order_meal');
	}
	APEND_URL_ARGUMENT($action, ARGUMENT_OPERATION, OPERATION_INSERT);
		
	$ra = array(
		'action_url'			=> $action
		,'meal_id'			=> $row_meal[MEAL_ID]
		,'meal_name'			=> STR_TO_HTML($row_meal[MEAL_NAME].RET_ITEM_EN($row_meal[MEAL_NAME_EN])).' $'.$row_meal[MEAL_PRICE]
		,'meal_barcode'			=> $row_meal[MEAL_BARCODE]
		,'meal_photo'			=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], '', $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_front'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_FRONT_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_order'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_ORDER_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_cart'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_CART_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'meal_photo_large'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_LARGE_WIDTH, $row_meal[MEAL_PHOTO]).'?'.RANDOM_STRING
		,'block_description'		=> ORDER_BLOCK_MEAL_DESCRIPTION($row_meal[MEAL_DESCRIPTION], $row_meal[MEAL_DESCRIPTION_EN])
		,'block_album'			=> ORDER_BLOCK_MEAL_ALBUM($row_meal[MEAL_ID], $row_meal[MEAL_PHOTO])
		,'block_flavor'			=> ORDER_BLOCK_LIST_FLAVORS($row_meal[MEAL_FLAVOR])
		,'block_additional'		=> ORDER_BLOCK_LIST_ADDITIONALS($row_meal[MEAL_ADDITIONAL])
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function ORDER_BLOCK_MEAL_DESCRIPTION($description, $description_en) {
	if ('' == $description) {
		if ('' == $description_en) {
			return '';
		} else {
			$description = $description_en;
		}
	} else {
		if ('' != $description_en) {
			$description .= '\\n\\n'.$description_en;
		}
	}
	$block = RET_TEMPLATE_CONTENT('order_meal_description');
	$ra = array(
		'meal_description'	=> STR_TO_HTML($description)
	);
	return RET_REPLACED_TEMPLATE($block, $ra);
}

function ORDER_BLOCK_MEAL_ALBUM($id, $photo) {
	$block = RET_TEMPLATE_CONTENT('order_meal_album');
	if (MATCH_TEMPLATE_LIST_ITEM('photo', $block, $key, $item, $ra)) {
		$ra[] = array(
			'meal_album_photo'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($id, '', $photo).'?'.RANDOM_STRING
			,'meal_album_photo_large'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_LARGE_WIDTH, $photo).'?'.RANDOM_STRING
		);
		if (LOAD_DB(RET_DB_FILE_2(PREFIX_MEAL, $id), $album_rows, $album_rows_count)) {
			foreach ($album_rows as &$album_row) {
				$ra[] = array(
					'meal_album_photo'		=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($id.'.'.$album_row[AB_MEAL_ID], '', $album_row[AB_MEAL_PHOTO]).'?'.RANDOM_STRING
					,'meal_album_photo_large'	=> FOLDER_MEAL.'/'.RET_PHOTO_NAME($id.'.'.$album_row[AB_MEAL_ID], PHOTO_ALBUM_LARGE_WIDTH, $album_row[AB_MEAL_PHOTO]).'?'.RANDOM_STRING
				);
			}
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_LIST_FLAVORS($flavor_id) {
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_FLAVOR), $rows, $rows_count, $id_to_index)) return;
	if (!isset($id_to_index[$flavor_id])) return;
	$row = &$rows[$id_to_index[$flavor_id]];
	if (!LOAD_DB(RET_DB_FILE_2(PREFIX_FLAVOR, $row[FLAVOR_ID]), $rows, $rows_count)) return;
	
	$block = RET_TEMPLATE_CONTENT('order_list_flavor');
	if (MATCH_TEMPLATE_LIST_ITEM('flavor', $block, $key, $item, $ra)) {
		foreach ($rows as &$row) {
			$ra[] = array(
				'flavor_id'		=> $row[MB_FLAVOR_ID]
				,'flavor_name'		=> STR_TO_HTML($row[MB_FLAVOR_NAME])
				,'flavor_name_english'	=> STR_TO_HTML($row[MB_FLAVOR_NAME_EN])
				,'flavor_photo'		=> FOLDER_FLAVOR.'/'.RET_PHOTO_NAME($row[MB_FLAVOR_ID], '', $row[MB_FLAVOR_PHOTO]).'?'.RANDOM_STRING
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_BLOCK_LIST_ADDITIONALS($additional_id) {
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_ADDITIONAL), $rows, $rows_count, $id_to_index)) return;
	if (!isset($id_to_index[$additional_id])) return;
	$row = &$rows[$id_to_index[$additional_id]];
	if (!LOAD_DB(RET_DB_FILE_2(PREFIX_ADDITIONAL, $row[ADDITIONAL_ID]), $rows, $rows_count)) return;
	
	$block = RET_TEMPLATE_CONTENT('order_list_additional');
	if (MATCH_TEMPLATE_LIST_ITEM('additional', $block, $key, $item, $ra)) {
		foreach ($rows as &$row) {
			$ra[] = array(
				'additional_id'				=> $row[MB_ADDITIONAL_ID]
				,'additional_name'			=> STR_TO_HTML($row[MB_ADDITIONAL_NAME])
				,'additional_name_english'		=> STR_TO_HTML($row[MB_ADDITIONAL_NAME_EN])
				,'additional_photo'			=> FOLDER_ADDITIONAL.'/'.RET_PHOTO_NAME($row[MB_ADDITIONAL_ID], '', $row[MB_ADDITIONAL_PHOTO]).'?'.RANDOM_STRING
				,'additional_price'			=> $row[MB_ADDITIONAL_PRICE]
				,'additional_description'		=> STR_TO_HTML($row[MB_ADDITIONAL_DESCRIPTION])
				,'additional_description_english'	=> STR_TO_HTML($row[MB_ADDITIONAL_DESCRIPTION_EN])
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_GET_NAME_FROM_IP($ip) {
	if (!LOAD_DB(RET_DB_FILE(PREFIX_TABLE), $rows, $rows_count)) E_TO(ERROR_CODE_UNKNOW_TABLE);
	
	foreach ($rows as &$row) {
		if ($ip == $row[TABLE_ADDRESS]) {
			return $row[TABLE_NAME];
		}
	}
	E_TO(ERROR_CODE_UNKNOW_TABLE);
}

function RET_LOCAL_TARGET($t) {
	if (ORDER_CHECKOUT_OPTION_TAKEAWAY == $t) {
		$tf = file_get_contents('__front/template/template.ini');
		$tc = file_get_contents('__front/template/'.$tf.'/lang.'.LOCAL_LANGUAGE.'.ini');
		if (1 == preg_match('/([^;]FRONT_CHECKOUT_OPTION_TAKEAWAY)\s*=\s*"(.[^"]*)"/', $tc, $ms)) {
			return $ms[2];
		}
	}
	return $t;
}