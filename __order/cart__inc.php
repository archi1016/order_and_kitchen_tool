<?php

if (!isset($the_operation)) exit();

$r = RET_INT_GET(POST_ID);

if ($cart_rows_count > 0) {
	$r &= 0x1FF;
	if ($r < $cart_rows_count) {
		++$cart_rows[$r][LIST_MEAL_COUNT];
		if (!SAVE_DB($cart_db, $cart_rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

P_TO($THIS_WEB_URL.'#item'.$r);
