<?php

require('func.php');
require('__back/back_func.php');

function SCALE_TAG_PHOTO($id, $photo) {
	global $the_folder;
	
	if ('' != $photo) {
		$src = $the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, '', $photo), PHOTO_DEFAULT_WIDTH, PHOTO_DEFAULT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_FRONT_WIDTH, $photo), PHOTO_GROUP_FRONT_WIDTH, PHOTO_GROUP_FRONT_HEIGHT);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_ORDER_WIDTH, $photo), PHOTO_GROUP_ORDER_WIDTH, PHOTO_GROUP_ORDER_HEIGHT);
	}
}

function REMOVE_TAG_PHOTO(&$r) {
	global $the_folder;
	
	$id	= $r[TAG_ID];
	$photo	= $r[TAG_PHOTO];
	if ('' != $photo) {
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, '', $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_FRONT_WIDTH, $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PHOTO_GROUP_ORDER_WIDTH, $photo));
	}
}

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_TAG;
$the_folder = FOLDER_TAG;
$the_db = RET_DB_FILE(PREFIX_TAG);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_NEW:
		require('__back/tag__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/tag__insert.php');
		break;
		
	case OPERATION_EDIT:
		require('__back/tag__edit.php');
		break;
		
	case OPERATION_SAVE:
		require('__back/tag__save.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/tag__remove.php');
		break;
	
	case OPERATION_UP:
		require('__back/common__up.php');
		break;
		
	case OPERATION_DOWN:
		require('__back/common__down.php');
		break;
	
	case OPERATION_MEMBER:
		require('__back/tag____member.php');
		break;
				
	default:
		require('__back/tag__list.php');
}
