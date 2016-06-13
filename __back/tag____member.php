<?php

if (!isset($the_operation)) exit();

$the_id = RET_STR_GET(POST_ID);
if ('' == $the_id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $the_id, $the_row_index)) E_TO(ERROR_CODE_UNKNOW_ID);
$the_row = $rows[$the_row_index];

$the_title = BACK_ITEM_MEMBER.' @ '.$the_title;
$the_operation_2 = RET_STR_GET(ARGUMENT_OPERATION_2);
$the_db_2 = RET_DB_FILE_2(PREFIX_TAG, $the_row[COMMON_ID]);

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_STR_GET(ARGUMENT_PAGE));
$prev_url = $THIS_WEB_URL;
APEND_URL_ARGUMENT($THIS_WEB_URL, POST_ID, $the_id);
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, $the_operation);

$block_toolbar = BACK_BLOCK_TOOLBAR_MEMBER($prev_url, $the_title);

LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_CATEGORY), $category_rows, $category_rows_count, $category_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_MEAL), $meal_rows, $meal_rows_count, $meal_id_to_index);
			
switch ($the_operation_2) {
	case OPERATION_NEW:
		require('__back/tag____member__new.php');
		break;
		
	case OPERATION_INSERT:
		require('__back/tag____member__insert.php');
		break;
		
	case OPERATION_REMOVE:
		require('__back/tag____member__remove.php');
		break;

	case OPERATION_UP:
		require('__back/common____member__up.php');
		break;

	case OPERATION_DOWN:
		require('__back/common____member__down.php');
		break;
		
	default:
		require('__back/tag____member__list.php');
		break;
}
