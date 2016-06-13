<?php

if (!isset($the_operation_2)) exit();

$id = RET_STR_POST(POST_ID_2);
$name = RET_STR_POST(POST_NAME);

if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);
if ('' == $name) E_TO(ERROR_CODE_EMPTY_MEMBER_NAME);

if (!LOAD_DB_WITH_ROW_INDEX($the_db_2, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];
		
$photo = RET_UPLOAD_ICON($the_folder, $row[MB_FLAVOR_ID]);
if ('' == $photo) {
	$photo = $row[MB_FLAVOR_PHOTO];
}
		
$row[MB_FLAVOR_NAME]	= $name;
$row[MB_FLAVOR_PHOTO]	= $photo;
$row[MB_FLAVOR_NAME_EN]	= RET_STR_POST(POST_NAME_EN);

if (!SAVE_DB($the_db_2, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
