<?php

require('func.php');
require('__back/back_func.php');

function SCALE_CATEGORY_PHOTO($id, $photo) {
	global $the_folder;
	
	if ('' != $photo) {
		$src = $the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, '', $photo), PHOTO_DEFAULT_WIDTH, PHOTO_DEFAULT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_FRONT_WIDTH, $photo), PHOTO_GROUP_FRONT_WIDTH, PHOTO_GROUP_FRONT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_ORDER_WIDTH, $photo), PHOTO_GROUP_ORDER_WIDTH, PHOTO_GROUP_ORDER_HEIGHT);
	}
}

function REMOVE_CATEGORY_PHOTO(&$r) {
	global $the_folder;
	
	$id	= $r[CATEGORY_ID];
	$photo	= $r[CATEGORY_PHOTO];
	if ('' != $photo) {
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, '', $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_FRONT_WIDTH, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_ORDER_WIDTH, $photo));
	}
}

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_CATEGORY;
$the_folder = FOLDER_CATEGORY;
$the_db = RET_DB_FILE(PREFIX_CATEGORY);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_NEW:
		require('__back/category__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/category__insert.php');
		break;
		
	case OPERATION_EDIT:
		require('__back/category__edit.php');
		break;
		
	case OPERATION_SAVE:
		require('__back/category__save.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/category__remove.php');
		break;
	
	case OPERATION_UP:
		require('__back/common__up.php');
		break;
		
	case OPERATION_DOWN:
		require('__back/common__down.php');
		break;
			
	default:
		require('__back/category__list.php');
}
