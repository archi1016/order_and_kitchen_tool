<?php

require('func.php');
require('__back/back_func.php');

function REMOVE_MEMBER_ICON(&$r) {
	global $the_folder;
	
	$id	= $r[MB_FLAVOR_ID];
	$photo	= $r[MB_FLAVOR_PHOTO];
	if ('' != $photo) {
		@unlink($the_folder.'/'.RET_PHOTO_NAME($id, '', $photo));
	}
}

CHECK_MGR_LOGON();

$the_title = BACK_SECTION_FLAVOR;
$the_folder = FOLDER_FLAVOR;
$the_db = RET_DB_FILE(PREFIX_FLAVOR);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {
	case OPERATION_NEW:
		require('__back/flavor__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/flavor__insert.php');
		break;
		
	case OPERATION_EDIT:
		require('__back/flavor__edit.php');
		break;
		
	case OPERATION_SAVE:
		require('__back/flavor__save.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/flavor__remove.php');
		break;
		
	case OPERATION_UP:
		require('__back/common__up.php');
		break;
		
	case OPERATION_DOWN:
		require('__back/common__down.php');		
		break;
			
	case OPERATION_MEMBER:
		require('__back/flavor____member.php');
		break;
			
	default:
		require('__back/flavor__list.php');
}
