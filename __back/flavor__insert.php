<?php

if (!isset($the_operation)) exit();

$name = RET_STR_POST(POST_NAME);

if ('' == $name) E_TO(ERROR_CODE_EMPTY_FLAVOR_NAME);

$id = md5(PREFIX_TITLE.date('YmdHis').$name);

$row[FLAVOR_ID]		= $id;
$row[FLAVOR_NAME]	= $name;
$row[FLAVOR_NU_6]	= '';
$row[FLAVOR_NU_5]	= '';
$row[FLAVOR_NU_4]	= '';
$row[FLAVOR_NU_3]	= '';
$row[FLAVOR_NU_2]	= '';
$row[FLAVOR_NU_1]	= '';

if (!INSERT_DB($the_db, $row)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
