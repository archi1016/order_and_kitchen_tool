<?php

if (!isset($the_operation)) exit();

$the_id = RET_STR_GET(POST_ID);
if ('' == $the_id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $the_id, $the_row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

APEND_URL_ARGUMENT($THIS_WEB_URL, POST_ID, $the_id);
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_STR_GET(ARGUMENT_PAGE));
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, $the_operation);
		
$the_row = &$rows[$the_row_index];
$the_operation_2 = RET_STR_GET(ARGUMENT_OPERATION_2);
$the_db_2 = RET_DB_FILE_2(PREFIX_ORDER_FORM, $the_row[COMMON_ID]);
		
switch ($the_operation_2) {
	case OPERATION_STATUS:
		require('__front/kitchen____member__status.php');
		break;
		
	case OPERATION_REMOVE:
		require('__front/kitchen____member__remove.php');
		break;
				
	default:
		require('__front/kitchen__list.php');
		break;
}
