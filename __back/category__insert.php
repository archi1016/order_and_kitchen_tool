<?php

if (!isset($the_operation)) exit();

$name = RET_STR_POST(POST_NAME);

if ('' == $name) E_TO(ERROR_CODE_EMPTY_CATEGORY_NAME);

$id = md5(PREFIX_TITLE.date('YmdHis').$name);

$row[CATEGORY_ID]		= $id;
$row[CATEGORY_NAME]		= $name;
$row[CATEGORY_PHOTO]		= RET_UPLOAD_PHOTO($the_folder, $id);
$row[CATEGORY_NAME_EN]		= RET_STR_POST(POST_NAME_EN);
$row[CATEGORY_HIDE]		= RET_STR_POST(POST_HIDE);
$row[CATEGORY_HIDE_IN_ORDER]	= RET_STR_POST(POST_HIDE_IN_ORDER);
$row[CATEGORY_NU_2]		= '';
$row[CATEGORY_NU_1]		= '';

SCALE_CATEGORY_PHOTO($id, $row[CATEGORY_PHOTO]);

if (!INSERT_DB($the_db, $row)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
