<?php

require('func.php');
require('__back/back_func.php');

function SCALE_MEMBER_PHOTO($id, $photo) {
	global $the_folder;
	
	if ('' != $photo) {
		$src = $the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo);
		RESCALE_PHOTO($src, $the_folder.'/'.RET_PHOTO_NAME($id, '', $photo), PHOTO_DEFAULT_WIDTH, PHOTO_DEFAULT_HEIGHT);
	}
}

function REMOVE_MEMBER_PHOTO(&$r) {
	global $the_folder;
	
	$id	= $r[MB_ADDITIONAL_ID];
	$photo	= $r[MB_ADDITIONAL_PHOTO];
	if ('' != $photo) {
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, '', $photo));
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $photo));
	}
}

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_ADDITIONAL;
$the_folder = FOLDER_ADDITIONAL;
$the_db = RET_DB_FILE(PREFIX_ADDITIONAL);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_NEW:
		require('__back/additional__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/additional__insert.php');
		break;
		
	case OPERATION_EDIT:
		require('__back/additional__edit.php');
		break;
		
	case OPERATION_SAVE:
		require('__back/additional__save.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/additional__remove.php');
		break;
		
	case OPERATION_UP:
		require('__back/common__up.php');
		break;
		
	case OPERATION_DOWN:
		require('__back/common__down.php');		
		break;
		
	case OPERATION_MEMBER:
		require('__back/additional____member.php');
		break;
			
	default:
		require('__back/additional__list.php');
}
