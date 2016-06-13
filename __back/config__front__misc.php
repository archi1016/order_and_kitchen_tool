<?php

if (!isset($the_mode)) exit();

$the_db = '__front/front_config.php';

if (OPERATION_SAVE == $the_operation) {
	$ls[] = '<'.'?php';
	$ls[] = '';
	$ls[] = RET_DEFINE_STRING('CONFIG_ORDER_TO_KDS_SOUND', $_POST['ORDER_TO_KDS_SOUND']);
	$ls[] = '';
	$ls[] = RET_DEFINE_STRING('CONFIG_KDS_AUTO_PRINT', $_POST['KDS_AUTO_PRINT']);
	$ls[] = RET_DEFINE_NUMBER('CONFIG_KDS_REFRESH_SECONDS', $_POST['KDS_REFRESH_SECONDS']);
	$ls[] = RET_DEFINE_NUMBER('CONFIG_KDS_ROWS_EACH_PAGE', $_POST['KDS_ROWS_EACH_PAGE']);
	$ls[] = RET_DEFINE_STRING('CONFIG_KDS_DISABLE_SOUND', $_POST['KDS_DISABLE_SOUND']);
	$ls[] = RET_DEFINE_NUMBER('CONFIG_KDS_SOUND_VOLUME', $_POST['KDS_SOUND_VOLUME']);
	$ls[] = RET_DEFINE_NUMBER('CONFIG_KDS_TIMEOUT_MINUTES_0', $_POST['KDS_TIMEOUT_MINUTES_0']);
	$ls[] = RET_DEFINE_STRING('CONFIG_KDS_TIMEOUT_COLOR_0', $_POST['KDS_TIMEOUT_COLOR_0']);
	$ls[] = RET_DEFINE_NUMBER('CONFIG_KDS_TIMEOUT_MINUTES_1', $_POST['KDS_TIMEOUT_MINUTES_1']);
	$ls[] = RET_DEFINE_STRING('CONFIG_KDS_TIMEOUT_COLOR_1', $_POST['KDS_TIMEOUT_COLOR_1']);
	$ls[] = RET_DEFINE_NUMBER('CONFIG_KDS_TIMEOUT_MINUTES_2', $_POST['KDS_TIMEOUT_MINUTES_2']);
	$ls[] = RET_DEFINE_STRING('CONFIG_KDS_TIMEOUT_COLOR_2', $_POST['KDS_TIMEOUT_COLOR_2']);
	$ls[] = '';
	$ls[] = RET_DEFINE_STRING('CONFIG_HISTORY_KEEP_ROWS', $_POST['HISTORY_KEEP_ROWS']);
	
	if (!SAVE_TEXT($the_db, implode("\r\n", $ls), LOCK_EX)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	
	P_TO($THIS_WEB_URL);
} else {
	require($the_db);
	
	LOAD_TEMPLATE_PAGE('back_page', $the_title);
	INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
	INSERT_TEMPLATE_BLOCK($block_section);

	$i = 5;
	while ($i <= 100) {
		$volumes[] = array(($i/100), $i.'%');
		$i += 5;
	}

	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

	$block = RET_TEMPLATE_CONTENT('back_config_front_misc');
	$ra = array(
		'action_title'			=> sprintf(BACK_TITLE_MODIFY, BACK_CONFIG_SECTION_FRONT_MISC)
		,'action_url'			=> $THIS_WEB_URL
		,'post_order_to_kds_sound'	=> 'ORDER_TO_KDS_SOUND'
		,'post_kds_auto_print'		=> 'KDS_AUTO_PRINT'
		,'post_kds_refresh_seconds'	=> 'KDS_REFRESH_SECONDS'
		,'post_kds_rows_each_page'	=> 'KDS_ROWS_EACH_PAGE'
		,'post_kds_disable_sound'	=> 'KDS_DISABLE_SOUND'
		,'post_kds_sound_volume'	=> 'KDS_SOUND_VOLUME'
		,'post_kds_timeout_minutes_0'	=> 'KDS_TIMEOUT_MINUTES_0'
		,'post_kds_timeout_color_0'	=> 'KDS_TIMEOUT_COLOR_0'
		,'post_kds_timeout_minutes_1'	=> 'KDS_TIMEOUT_MINUTES_1'
		,'post_kds_timeout_color_1'	=> 'KDS_TIMEOUT_COLOR_1'
		,'post_kds_timeout_minutes_2'	=> 'KDS_TIMEOUT_MINUTES_2'
		,'post_kds_timeout_color_2'	=> 'KDS_TIMEOUT_COLOR_2'
		,'post_history_keep_rows'	=> 'HISTORY_KEEP_ROWS'
		,'options_order_to_kds_sound'	=> RET_OPTIONS_BOOLEAN(CONFIG_ORDER_TO_KDS_SOUND)
		,'options_kds_auto_print'	=> RET_OPTIONS_BOOLEAN(CONFIG_KDS_AUTO_PRINT)
		,'source_kds_refresh_seconds'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_REFRESH_SECONDS)
		,'source_kds_rows_each_page'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_ROWS_EACH_PAGE)
		,'options_kds_disable_sound'	=> RET_OPTIONS_BOOLEAN(CONFIG_KDS_DISABLE_SOUND)
		,'options_kds_sound_volume'	=> RET_OPTIONS_ROWS(CONFIG_KDS_SOUND_VOLUME, $volumes, false)
		,'source_kds_timeout_minutes_0'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_TIMEOUT_MINUTES_0)
		,'source_kds_timeout_color_0'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_TIMEOUT_COLOR_0)
		,'source_kds_timeout_minutes_1'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_TIMEOUT_MINUTES_1)
		,'source_kds_timeout_color_1'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_TIMEOUT_COLOR_1)
		,'source_kds_timeout_minutes_2'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_TIMEOUT_MINUTES_2)
		,'source_kds_timeout_color_2'	=> STR_TO_INPUT_VALUE(CONFIG_KDS_TIMEOUT_COLOR_2)
		,'source_history_keep_rows'	=> STR_TO_INPUT_VALUE(CONFIG_HISTORY_KEEP_ROWS)
	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	
	DUMP_TEMPLATE_PAGE();
}
