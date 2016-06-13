<?php

if (!isset($the_operation_2)) exit();

$id = RET_STR_GET(POST_ID_2);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db_2, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

if ($rows_count > 1) {
	if ($row_index > 0) {
		$row = $rows[$row_index];
		$rows[$row_index] = $rows[$row_index-1];
		$rows[$row_index-1] = $row;
		if (!SAVE_DB($the_db_2, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

P_TO($THIS_WEB_URL);
