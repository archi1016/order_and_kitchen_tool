<?php

if (!isset($the_operation)) exit();

$name = RET_STR_POST(POST_NAME);

if ('' == $name) E_TO(ERROR_CODE_EMPTY_TAG_NAME);

$id = md5(PREFIX_TITLE.date('YmdHis').$name);

$row[TAG_ID]		= $id;
$row[TAG_NAME]		= $name;
$row[TAG_PHOTO]		= RET_UPLOAD_PHOTO($the_folder, $id);
$row[TAG_NAME_EN]	= RET_STR_POST(POST_NAME_EN);
$row[TAG_HIDE]		= RET_STR_POST(POST_HIDE);
$row[TAG_HIDE_IN_ORDER]	= RET_STR_POST(POST_HIDE_IN_ORDER);
$row[TAG_NU_2]		= '';
$row[TAG_NU_1]		= '';

SCALE_TAG_PHOTO($id, $row[TAG_PHOTO]);

if (!INSERT_DB($the_db, $row)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
