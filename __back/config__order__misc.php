<?php

if (!isset($the_mode)) exit();

$the_db = '__order/order_config.php';

if (OPERATION_SAVE == $the_operation) {
	$ls[] = '<'.'?php';
	$ls[] = '';
	$ls[] = RET_DEFINE_STRING('CONFIG_DEMO_MODE', $_POST['DEMO_MODE']);
	$ls[] = RET_DEFINE_STRING('CONFIG_DISABLE_CLIENT_ORDER', $_POST['DISABLE_CLIENT_ORDER']);
	$ls[] = RET_DEFINE_STRING('CONFIG_DISABLE_RANDOM_MEALS', $_POST['DISABLE_RANDOM_MEALS']);
	
	if (!SAVE_TEXT($the_db, implode("\r\n", $ls))) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	
	P_TO($THIS_WEB_URL);
} else {
	require($the_db);
	
	LOAD_TEMPLATE_PAGE('back_page', $the_title);
	INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
	INSERT_TEMPLATE_BLOCK($block_section);

	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

	$block = RET_TEMPLATE_CONTENT('back_config_order_misc');
	$ra = array(
		'action_title'			=> sprintf(BACK_TITLE_MODIFY, BACK_CONFIG_SECTION_ORDER_MISC)
		,'action_url'			=> $THIS_WEB_URL
		,'post_demo_mode'		=> 'DEMO_MODE'
		,'post_disable_client_order'	=> 'DISABLE_CLIENT_ORDER'
		,'post_disable_random_meals'	=> 'DISABLE_RANDOM_MEALS'
		,'options_demo_mode'		=> RET_OPTIONS_BOOLEAN(CONFIG_DEMO_MODE)
		,'options_disable_client_order'	=> RET_OPTIONS_BOOLEAN(CONFIG_DISABLE_CLIENT_ORDER)
		,'options_disable_random_meals'	=> RET_OPTIONS_BOOLEAN(CONFIG_DISABLE_RANDOM_MEALS)
	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

	DUMP_TEMPLATE_PAGE();
}
