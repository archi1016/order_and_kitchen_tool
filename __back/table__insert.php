<?php

if (!isset($the_operation)) exit();

if (isset($_POST[POST_NAME]) && isset($_POST[POST_ADDRESS])) {
if (is_array($_POST[POST_NAME]) && is_array($_POST[POST_ADDRESS])) {
	LOAD_DB($the_db, $rows, $rows_count);
	$is_inserted = false;
		
	foreach ($_POST[POST_NAME] as $k => $v) {
		$name = strtoupper(trim($_POST[POST_NAME][$k]));
		$addr = trim($_POST[POST_ADDRESS][$k]);
		if (('' != $name) && ('' != $addr)) {
			$rows[$rows_count][TABLE_ID] = md5(PREFIX_TITLE.date('YmdHis').$name);
			$row = &$rows[$rows_count];
			$row[TABLE_NAME]	= $name;
			$row[TABLE_ADDRESS]	= $addr;
			$row[TABLE_NU_5]	= '';
			$row[TABLE_NU_4]	= '';
			$row[TABLE_NU_3]	= '';
			$row[TABLE_NU_2]	= '';
			$row[TABLE_NU_1]	= '';
			++$rows_count;
			$is_inserted = true;
		}
	}
		
	if ($is_inserted) {
		if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}
}


P_TO($THIS_WEB_URL);
