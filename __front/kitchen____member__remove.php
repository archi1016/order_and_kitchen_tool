<?php

if (!isset($the_operation_2)) exit();

$r = RET_INT_GET(POST_ID_2);

if (!LOAD_DB($the_db_2, $rows, $rows_count)) E_TO(ERROR_CODE_UNKNOW_ID);

$r &= 0x1FF;
if ($r < $rows_count) {
	unset($rows[$r]);
				
	if (!SAVE_DB($the_db_2, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	
	require('__front/front_func_order.php');
	
	LOAD_DB($the_db_2, $cart_rows, $cart_rows_count);
	$t = RET_CART_TOTAL();
	
	LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $the_id, $the_row_index);
	$row = &$rows[$the_row_index];
	$row[ORDER_FORM_TOTAL] = $t;
	$row[ORDER_FORM_CHANGE] = (int) $row[ORDER_FORM_PAY] - $t;
	
	if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	
}
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
P_TO($THIS_WEB_URL);
