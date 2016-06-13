<?php

if (!isset($the_mode)) exit();

function UPDATE_FROM_ZIP_FILE($zip_file) {
	$zh = zip_open($zip_file);
	if (is_resource($zh)) {
		while (true) {
			$e = zip_read($zh);
			if (false === $e) break;
			$n = zip_entry_name($e);
			if ('/' != substr($n, -1)) {
				$b = zip_entry_read($e, zip_entry_filesize($e));
				SAVE_TEXT($n, $b);
			} else {
				if (!is_dir($n)) mkdir($n);
			}
		}
		zip_close($zh);
	}
	@unlink($zip_file);
}

if (OPERATION_SAVE == $the_operation) {

	if (isset($_FILES['UPDATE_FILE'])) {
		$zfile = &$_FILES['UPDATE_FILE'];
		if (UPLOAD_ERR_OK == $zfile['error']) {
			$en = explode('.', $zfile['name']);
			$en = $en[count($en)-1];
			if ('zip' != $en) E_TO(ERROR_CODE_NOT_ZIP);
			$zip_file = date('YmdHis_').RET_RANDOM_STRING(8).'.zip';
			if (move_uploaded_file($zfile['tmp_name'], $zip_file)) {
				UPDATE_FROM_ZIP_FILE($zip_file);
				APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_DONE);
				P_TO($THIS_WEB_URL);
			}
		}
	}
	P_TO($THIS_WEB_URL);

} else {
	LOAD_TEMPLATE_PAGE('back_page', $the_title);
	INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
	INSERT_TEMPLATE_BLOCK($block_section);

	if (OPERATION_DONE == $the_operation) {
		$block = RET_TEMPLATE_CONTENT('back_config_done');
		$ra = array(
			'msg' => BACK_CONFIG_UPDATE_DONE
		);
		INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	}

	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);
	
	$block = RET_TEMPLATE_CONTENT('back_config_update');
	$ra = array(
		'action_title'		=> BACK_CONFIG_SECTION_UPDATE
		,'action_url'		=> $THIS_WEB_URL
		,'zip_file'		=> 'UPDATE_FILE'
	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

	DUMP_TEMPLATE_PAGE();
}
