<?php

if (!isset($the_operation)) exit();

$id = RET_STR_POST(POST_ID);
$name = RET_STR_POST(POST_NAME);

if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);
if ('' == $name) E_TO(ERROR_CODE_EMPTY_TAG_NAME);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];

$photo = RET_UPLOAD_PHOTO($the_folder, $row[TAG_ID]);
if ('' != $photo) {
	SCALE_TAG_PHOTO($id, $photo);
} else {
	$photo = $row[TAG_PHOTO];
}

$row[TAG_NAME]		= $name;
$row[TAG_PHOTO]		= $photo;
$row[TAG_NAME_EN]	= RET_STR_POST(POST_NAME_EN);
$row[TAG_HIDE]		= RET_STR_POST(POST_HIDE);
$row[TAG_HIDE_IN_ORDER]	= RET_STR_POST(POST_HIDE_IN_ORDER);

if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
P_TO($THIS_WEB_URL);
