<?php

if (!isset($the_operation_2)) exit();

if (isset($_POST[POST_ID])) {
	if (is_array($_POST[POST_ID])) {
		LOAD_DB($the_db_2, $rows, $rows_count);
		foreach ($_POST[POST_ID] as $v) {
			$rows[$rows_count][MB_TAG_ID] = $v;
			$row = &$rows[$rows_count];
			$row[MB_TAG_NU_7]	= '';
			$row[MB_TAG_NU_6]	= '';
			$row[MB_TAG_NU_5]	= '';
			$row[MB_TAG_NU_4]	= '';
			$row[MB_TAG_NU_3]	= '';
			$row[MB_TAG_NU_2]	= '';
			$row[MB_TAG_NU_1]	= '';
			++$rows_count;
		}
		if (!SAVE_DB($the_db_2, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

P_TO($THIS_WEB_URL);
