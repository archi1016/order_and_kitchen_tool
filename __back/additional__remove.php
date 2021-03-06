<?php

if (!isset($the_operation)) exit();

$id = RET_STR_GET(POST_ID);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);
$row = &$rows[$row_index];
		
$the_db_2 = RET_DB_FILE_2(PREFIX_ADDITIONAL, $row[ADDITIONAL_ID]);
if (is_file($the_db_2)) {
	if (LOAD_DB($the_db_2, $rows_2, $rows_count_2)) {
		foreach ($rows_2 as $row_2) {
			REMOVE_MEMBER_PHOTO($row_2);
		}
	}
	@unlink($the_db_2);
}
	
unset($rows[$row_index]);

if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
P_TO($THIS_WEB_URL);
