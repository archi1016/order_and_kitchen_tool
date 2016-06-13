<?php

if (!isset($the_operation)) exit();

$row[STORES_ID]		= md5(PREFIX_TITLE.date('siHdmY'));
$row[STORES_NAME]	= RET_STR_POST(POST_NAME);
$row[STORES_TELEPHONE]	= RET_STR_POST(POST_TELEPHONE);
$row[STORES_ADDRESS]	= RET_STR_POST(POST_ADDRESS);
$row[STORES_EMAIL]	= RET_STR_POST(POST_EMAIL);
$row[STORES_NAME_EN]	= RET_STR_POST(POST_NAME_EN);
$row[STORES_NU_2]	= '';
$row[STORES_NU_1]	= '';

if (isset($_FILES[POST_PHOTO])) {
	$p = &$_FILES[POST_PHOTO];
	if (UPLOAD_ERR_OK == $p['error']) {
		$en = explode('.', $p['name']);
		$en = $en[count($en)-1];
		if ('png' == $en) move_uploaded_file($p['tmp_name'], 'logo.png');
	}
}

@unlink($the_db);

if (!INSERT_DB($the_db, $row)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
