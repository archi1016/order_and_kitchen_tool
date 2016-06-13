<?php

if (!isset($the_operation)) exit();

if (isset($_POST[POST_ID])) {
	if (is_array($_POST[POST_ID])) {
		foreach ($_POST[POST_ID] as $v) {
			if ($v != '') {
				$ids[] = $v;
			}
		}
		if (isset($ids)) {
			if (!SAVE_TEXT($the_db, implode("\t", $ids))) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
		} else {
			@unlink($the_db);
		}
	}
} else {
	@unlink($the_db);
}

P_TO($THIS_WEB_URL);
