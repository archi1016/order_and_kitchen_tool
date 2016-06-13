<?php

if (!isset($the_mode)) exit();

if (OPERATION_SAVE == $the_operation) {
	$order = RET_STR_POST('TEMPLATE_ORDER');
	$ipod = RET_STR_POST('TEMPLATE_IPOD');
	$front = RET_STR_POST('TEMPLATE_FRONT');
	$back = RET_STR_POST('TEMPLATE_BACK');
	$error = RET_STR_POST('TEMPLATE_ERROR');
	
	if (!SAVE_TEXT('__order/template/template.ini', $order, LOCK_EX)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	if (!SAVE_TEXT('__ipod/template/template.ini', $ipod, LOCK_EX)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	if (!SAVE_TEXT('__front/template/template.ini', $front, LOCK_EX)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	if (!SAVE_TEXT('__back/template/template.ini', $back, LOCK_EX)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	if (!SAVE_TEXT('__error/template/template.ini', $error, LOCK_EX)) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	
	P_TO($THIS_WEB_URL);
} else {
	LOAD_TEMPLATE_PAGE('back_page', $the_title);
	INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());
	INSERT_TEMPLATE_BLOCK($block_section);

	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

	$order = file_get_contents('__order/template/template.ini');
	$ipod = file_get_contents('__ipod/template/template.ini');
	$front = file_get_contents('__front/template/template.ini');
	$back = file_get_contents('__back/template/template.ini');
	$error = file_get_contents('__error/template/template.ini');
	
	LIST_TEMPLATE_INFO('__order', $order_info);
	LIST_TEMPLATE_INFO('__ipod', $ipod_info);
	LIST_TEMPLATE_INFO('__front', $front_info);
	LIST_TEMPLATE_INFO('__back', $back_info);
	LIST_TEMPLATE_INFO('__error', $error_info);

	$block = RET_TEMPLATE_CONTENT('back_config_template');
	$ra = array(
		'action_title'		=> sprintf(BACK_TITLE_MODIFY, BACK_CONFIG_SECTION_TEMPLATE)
		,'action_url'		=> $THIS_WEB_URL
		,'post_order'		=> 'TEMPLATE_ORDER'
		,'post_ipod'		=> 'TEMPLATE_IPOD'
		,'post_front'		=> 'TEMPLATE_FRONT'
		,'post_back'		=> 'TEMPLATE_BACK'
		,'post_error'		=> 'TEMPLATE_ERROR'
		,'options_order'	=> RET_OPTIONS_ROWS($order, $order_info, false)
		,'options_ipod'		=> RET_OPTIONS_ROWS($ipod, $ipod_info, false)
		,'options_front'	=> RET_OPTIONS_ROWS($front, $front_info, false)
		,'options_back'		=> RET_OPTIONS_ROWS($back, $back_info, false)
		,'options_error'	=> RET_OPTIONS_ROWS($error, $error_info, false)

	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	
	DUMP_TEMPLATE_PAGE();
}
