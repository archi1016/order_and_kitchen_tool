<?php

if (!isset($the_operation_2)) exit();

$name = RET_STR_POST(POST_NAME);

if ('' == $name) E_TO(ERROR_CODE_EMPTY_MEMBER_NAME);

$id = md5(PREFIX_TITLE.date('YmdHis').$name);

$row[MB_FLAVOR_ID]	= $id;
$row[MB_FLAVOR_NAME]	= $name;
$row[MB_FLAVOR_PHOTO]	= RET_UPLOAD_ICON($the_folder, $id);
$row[MB_FLAVOR_NAME_EN]	= RET_STR_POST(POST_NAME_EN);
$row[MB_FLAVOR_NU_4]	= '';
$row[MB_FLAVOR_NU_3]	= '';
$row[MB_FLAVOR_NU_2]	= '';
$row[MB_FLAVOR_NU_1]	= '';

if (!INSERT_DB($the_db_2, $row)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
