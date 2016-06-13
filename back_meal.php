<?php

require('func.php');
require('__back/back_func.php');

function SCALE_MEAL_PHOTO($id, $photo) {
	global $the_folder;
	
	if ('' != $photo) {
		$src = $the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, '', $photo), PHOTO_DEFAULT_WIDTH, PHOTO_DEFAULT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_CART_WIDTH, $photo), PHOTO_MEAL_CART_WIDTH, PHOTO_MEAL_CART_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_FRONT_WIDTH, $photo), PHOTO_MEAL_FRONT_WIDTH, PHOTO_MEAL_FRONT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_ORDER_WIDTH, $photo), PHOTO_MEAL_ORDER_WIDTH, PHOTO_MEAL_ORDER_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_LARGE_WIDTH, $photo), PHOTO_MEAL_LARGE_WIDTH, PHOTO_MEAL_LARGE_HEIGHT);
	}
}

function REMOVE_MEAL_PHOTO(&$r) {
	global $the_folder;
	
	$id	= $r[MEAL_ID];
	$photo	= $r[MEAL_PHOTO];
	if ('' != $photo) {
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, '', $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_CART_WIDTH, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_FRONT_WIDTH, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_ORDER_WIDTH, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_MEAL_LARGE_WIDTH, $photo));
	}
}

function SCALE_ALBUM_PHOTO($mid, $id, $photo) {
	global $the_folder;
	
	$id = $mid.'.'.$id;
	if ('' != $photo) {
		$src = $the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, '', $photo), PHOTO_DEFAULT_WIDTH, PHOTO_DEFAULT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_ALBUM_BACK_WIDTH, $photo), PHOTO_ALBUM_BACK_WIDTH, PHOTO_ALBUM_BACK_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_ALBUM_LARGE_WIDTH, $photo), PHOTO_ALBUM_LARGE_WIDTH, PHOTO_ALBUM_LARGE_HEIGHT);
	}
}

function REMOVE_ALBUM_PHOTO($mid, &$r) {
	global $the_folder;

	$id	= $mid.'.'.$r[AB_MEAL_ID];
	$photo	= $r[AB_MEAL_PHOTO];
	if ('' != $photo) {
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, '', $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_ALBUM_BACK_WIDTH, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_ALBUM_LARGE_WIDTH, $photo));
	}
}

function RESORT_MEAL_BY_CATEGORY(&$rows, $rows_count) {
	global $category_rows;
	global $category_rows_count;
	global $category_id_to_index;
	define('CHILDS_COUNT', 'count');
	
	if (1 >= $category_rows_count) return;
	if (1 >= $rows_count) return;

	$i = 0;
	$category_childs[0][CHILDS_COUNT] = 0;
	while ($i < $category_rows_count) {
		$category_childs[$i+1][CHILDS_COUNT] = 0;
		++$i;
	}
	
	$i = 0;
	while ($i < $rows_count) {
		$id = $rows[$i][MEAL_CATEGORY];
		if (isset($category_id_to_index[$id])) {
			$row = &$category_childs[$category_id_to_index[$id]+1];
			$c = &$row[CHILDS_COUNT];
			$row[$c] = $i;
			++$c;
		} else {
			$row = &$category_childs[0];
			$c = &$row[CHILDS_COUNT];
			$row[$c] = $i;
			++$c;
		}
		++$i;
	}
	
	$i = 0;
	while ($i <= $category_rows_count) {
		$ch = &$category_childs[$i];
		if ($ch[CHILDS_COUNT] > 0) {
			$j = 0;
			while ($j < $ch[CHILDS_COUNT]) {
				$new_rows[] = $rows[$ch[$j]];
				++$j;
			}
		}
		++$i;
	}
	
	$rows = $new_rows;
}


CHECK_MGR_LOGON();

LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_CATEGORY), $category_rows, $category_rows_count, $category_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_FLAVOR), $flavor_rows, $flavor_rows_count, $flavor_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_ADDITIONAL), $additional_rows, $additional_rows_count, $additional_id_to_index);

$the_title = BACK_SECTION_MEAL;
$the_folder = FOLDER_MEAL;
$the_db = RET_DB_FILE(PREFIX_MEAL);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_NEW:
		require('__back/meal__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/meal__insert.php');
		break;
		
	case OPERATION_EDIT:
		require('__back/meal__edit.php');
		break;
		
	case OPERATION_SAVE:
		require('__back/meal__save.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/meal__remove.php');
		break;
	
	case OPERATION_UP:
		require('__back/common__up.php');
		break;
		
	case OPERATION_DOWN:
		require('__back/common__down.php');
		break;
	
	case OPERATION_ALBUM:
		require('__back/meal____album.php');
		break;
				
	default:
		require('__back/meal__list.php');
}
