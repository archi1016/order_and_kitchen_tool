<?php

if (!isset($the_operation)) exit();

$name = RET_STR_POST(POST_NAME);

if ('' == $name) E_TO(ERROR_CODE_EMPTY_ADDITIONAL_NAME);

$id = md5(PREFIX_TITLE.date('YmdHis').$name);

$row[ADDITIONAL_ID]	= $id;
$row[ADDITIONAL_NAME]	= $name;
$row[ADDITIONAL_NU_6]	= '';
$row[ADDITIONAL_NU_5]	= '';
$row[ADDITIONAL_NU_4]	= '';
$row[ADDITIONAL_NU_3]	= '';
$row[ADDITIONAL_NU_2]	= '';
$row[ADDITIONAL_NU_1]	= '';

if (!INSERT_DB($the_db, $row)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
