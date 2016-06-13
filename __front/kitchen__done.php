<?php

if (!isset($the_operation)) exit();

$id = RET_STR_GET(POST_ID);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];
		
$the_db_2 = RET_DB_FILE(PREFIX_ORDER_HISTORY);
LOAD_DB($the_db_2, $rows_2, $rows_count_2);
		
$rows_2[$rows_count_2][ORDER_HISTORY_ID] = $row[ORDER_FORM_ID];
$row_2 = &$rows_2[$rows_count_2];
$row_2[ORDER_HISTORY_TIME_IN]		= $row[ORDER_FORM_TIME];
$row_2[ORDER_HISTORY_TIME_OUT]		= date('Y-m-d H:i');
$row_2[ORDER_HISTORY_TIME_EXPEND]	= floor(strtotime($row_2[ORDER_HISTORY_TIME_OUT]) / 60) - $row[ORDER_FORM_TIME_INT];
$row_2[ORDER_HISTORY_NUMBER]		= $row[ORDER_FORM_NUMBER];
$row_2[ORDER_HISTORY_TARGET]		= $row[ORDER_FORM_TARGET];
$row_2[ORDER_HISTORY_PAY]		= $row[ORDER_FORM_PAY];
$row_2[ORDER_HISTORY_TOTAL]		= $row[ORDER_FORM_TOTAL];
$row_2[ORDER_HISTORY_CHANGE]		= $row[ORDER_FORM_CHANGE];
$row_2[ORDER_HISTORY_MEMO]		= $row[ORDER_FORM_MEMO];
$row_2[ORDER_HISTORY_NU_6]		= '';
$row_2[ORDER_HISTORY_NU_5]		= '';
$row_2[ORDER_HISTORY_NU_4]		= '';
$row_2[ORDER_HISTORY_NU_3]		= '';
$row_2[ORDER_HISTORY_NU_2]		= '';
$row_2[ORDER_HISTORY_NU_1]		= '';
++$rows_count_2;
		
$i = 0;
while ($rows_count_2 > CONFIG_HISTORY_KEEP_ROWS) {
	@unlink(RET_DB_FILE_2(PREFIX_ORDER_HISTORY, $rows_2[$i][ORDER_HISTORY_ID]));
	unset($rows_2[$i]);
	++$i;
	--$rows_count_2;
}

if (!SAVE_DB($the_db_2, $rows_2)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

@rename(RET_DB_FILE_2(PREFIX_ORDER_FORM, $row[ORDER_FORM_ID]), RET_DB_FILE_2(PREFIX_ORDER_HISTORY, $row[ORDER_FORM_ID]));
unset($rows[$row_index]);

if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
P_TO($THIS_WEB_URL);
