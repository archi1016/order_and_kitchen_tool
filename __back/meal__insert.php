<?php

if (!isset($the_operation)) exit();

$name = RET_STR_POST(POST_NAME);

if ('' == $name) E_TO(ERROR_CODE_EMPTY_MEAL_NAME);

$id = md5(PREFIX_TITLE.date('YmdHis').$name);

LOAD_DB($the_db, $rows, $rows_count);

$rows[$rows_count][MEAL_ID]	= $id;
$row = &$rows[$rows_count];
$row[MEAL_NAME]			= $name;
$row[MEAL_PHOTO]		= RET_UPLOAD_PHOTO($the_folder, $id);
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
$row[MEAL_PAUSED]		= '';
$row[MEAL_NU_2]			= '';
$row[MEAL_NU_1]			= '';
++$rows_count;

SCALE_MEAL_PHOTO($id, $row[MEAL_PHOTO]);

RESORT_MEAL_BY_CATEGORY($rows, $rows_count);

if (!SAVE_DB($the_db, $rows)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
