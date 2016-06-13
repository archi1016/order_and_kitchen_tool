<?php

if (!isset($the_operation)) exit();

$id = RET_STR_POST(POST_ID);
$name = RET_STR_POST(POST_NAME);

if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);
if ('' == $name) E_TO(ERROR_CODE_EMPTY_MEAL_NAME);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);

$row = &$rows[$row_index];

$photo = RET_UPLOAD_PHOTO($the_folder, $row[MEAL_ID]);
if ('' != $photo) {
	SCALE_MEAL_PHOTO($id, $photo);
} else {
	$photo = $row[MEAL_PHOTO];
}

$row[MEAL_NAME]			= $name;
$row[MEAL_PHOTO]		= $photo;
$row[MEAL_NAME_EN]		= RET_STR_POST(POST_NAME_EN);
$row[MEAL_PRICE]		= RET_INT_POST(POST_PRICE);
$row[MEAL_DESCRIPTION]		= RET_ML_TO_SL(RET_STR_POST(POST_DESCRIPTION));
$row[MEAL_CATEGORY]		= RET_STR_POST(POST_CATEGORY);
$row[MEAL_FLAVOR]		= RET_STR_POST(POST_FLAVOR);
$row[MEAL_ADDITIONAL]		= RET_STR_POST(POST_ADDITIONAL);
$row[MEAL_BARCODE]		= RET_STR_POST(POST_BARCODE);
$row[MEAL_NAME_EN]		= RET_STR_POST(POST_NAME_EN);
$row[MEAL_DESCRIPTION_EN]	= RET_ML_TO_SL(RET_STR_POST(POST_DESCRIPTION_EN));
$row[MEAL_HIDE]			= RET_STR_POST(POST_HIDE);
$row[MEAL_HIDE_IN_ORDER]	= RET_STR_POST(POST_HIDE_IN_ORDER);

RESORT_MEAL_BY_CATEGORY($rows, $rows_count);

if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
P_TO($THIS_WEB_URL);
