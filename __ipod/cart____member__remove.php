<?php

if (!isset($page)) exit();

$r = RET_INT_GET(POST_ID);

if ($cart_rows_count > 0) {
	if (-1 != $r) {
		$r &= 0x1FF;
		if ($r < $cart_rows_count) {
			unset($cart_rows[$r]);
			if (!SAVE_DB($cart_db, $cart_rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
		}
	} else {
		@unlink($cart_db);
	}
}

P_TO($THIS_WEB_URL);
