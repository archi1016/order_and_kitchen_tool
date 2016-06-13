<?php

if (!isset($the_operation_2)) exit();

if (isset($_FILES[POST_PHOTO])) {
	if (is_array($_FILES[POST_PHOTO])) {
		LOAD_DB($the_db_2, $rows, $rows_count);
		$is_inserted = false;
		$nt = date('YmdHis');
	
		$ps = &$_FILES[POST_PHOTO];
		foreach ($ps['error'] as $k => $v) {
			if (UPLOAD_ERR_OK == $ps['error'][$k]) {
				$id = md5(PREFIX_TITLE.$nt.$ps['name'][$k].$the_row[COMMON_ID]);
				$en = explode('.', $ps['name'][$k]);
				$en = $en[count($en)-1];
				$sf = $the_folder.'/'.RET_PHOTO_NAME($the_row[COMMON_ID].'.'.$id, PREFIX_PHOTO_SOURCE, $en);
				if (move_uploaded_file($ps['tmp_name'][$k], $sf)) {
					$rows[$rows_count][AB_MEAL_ID] = $id;
					$row = &$rows[$rows_count];
					$row[AB_MEAL_PHOTO]	= $en;
					$row[AB_MEAL_NU_6]	= '';
					$row[AB_MEAL_NU_5]	= '';
					$row[AB_MEAL_NU_4]	= '';
					$row[AB_MEAL_NU_3]	= '';
					$row[AB_MEAL_NU_2]	= '';
					$row[AB_MEAL_NU_1]	= '';
					++$rows_count;
					$is_inserted = true;
								
					SCALE_ALBUM_PHOTO($the_row[COMMON_ID], $id, $en);
				}
			}
		}
	
		if ($is_inserted) {
			if (!SAVE_DB($the_db_2, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
		}
	}
}

P_TO($THIS_WEB_URL);
