<?php

if (!isset($the_operation_2)) exit();

$r = RET_INT_GET(POST_ID_2);

if (!LOAD_DB($the_db_2, $rows, $rows_count)) E_TO(ERROR_CODE_UNKNOW_ID);

$r &= 0x1FF;
if ($r < $rows_count) {
	$row = &$rows[$r];
		
	$row[LIST_MEAL_STATUS]++;
	if ($row[LIST_MEAL_STATUS] > 2) $row[LIST_MEAL_STATUS] = 0;
			
	if (!SAVE_DB($the_db_2, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
}
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
P_TO($THIS_WEB_URL);
