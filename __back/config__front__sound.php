<?php

if (!isset($the_mode)) exit();

$the_db = FOLDER_SOUND.'/'.SOUND_NEW_ORDER_FORM;

if (OPERATION_SAVE == $the_operation) {
	if (isset($_FILES['ORDER_FORM'])) {
		$mp3 = &$_FILES['ORDER_FORM'];
		if (UPLOAD_ERR_OK == $mp3['error']) {
			$en = explode('.', $mp3['name']);
			$en = $en[count($en)-1];
			if ('mp3' != $en) E_TO(ERROR_CODE_NOT_MP3);
			if (move_uploaded_file($mp3['tmp_name'], $the_db)) {
				APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_DONE);
				P_TO($THIS_WEB_URL);
			}
		}
	}
	P_TO($THIS_WEB_URL);
} else {
	require('__front/front_config.php');
	
	LOAD_TEMPLATE_PAGE('back_page', $the_title);
	INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
	INSERT_TEMPLATE_BLOCK($block_section);

	if (OPERATION_DONE == $the_operation) {
		$block = RET_TEMPLATE_CONTENT('back_config_done');
		$ra = array(
			'msg' => BACK_CONFIG_UPLOAD_DONE
		);
		INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	}

	$volopts = '';
	$i = 5;
	while ($i <= 100) {
		$v = $i / 100;
		$volopts .= '<option value="'.$v.'"';
		if (CONFIG_KDS_SOUND_VOLUME == $v) $volopts .= ' selected="selected"';
		$volopts .= '>'.$i.'%</option>';
		$i += 5;
	}

	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);
	
	$block = RET_TEMPLATE_CONTENT('back_config_front_sound');
	$ra = array(
		'options_volume'	=> $volopts
		,'mp3_file'		=> $the_db
		,'action_title'		=> sprintf(BACK_TITLE_MODIFY, BACK_CONFIG_SECTION_FRONT_SOUND)
		,'action_url'		=> $THIS_WEB_URL
		,'mp3_order_form'	=> 'ORDER_FORM'
	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

	DUMP_TEMPLATE_PAGE();
}
