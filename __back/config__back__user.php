<?php

if (!isset($the_mode)) exit();

$the_db = '__back/back_password.php';
require($the_db);

if (OPERATION_SAVE == $the_operation) {
	if (BACK_ACCOUNT == RET_STR_POST('OLD_ACCOUNT')) {
		if (BACK_PASSWORD == RET_STR_POST('OLD_PASSWORD')) {
			$new_acc = RET_STR_POST('NEW_ACCOUNT');
			$new_pwd = RET_STR_POST('NEW_PASSWORD');
			$new_pwd_2 = RET_STR_POST('NEW_PASSWORD_AGAIN');
		
			if ('' == $new_acc) E_TO(ERROR_CODE_EMPTY_ACCOUNT);
			if ('' == $new_pwd) E_TO(ERROR_CODE_EMPTY_PASSWORD);
			if ($new_pwd_2 != $new_pwd) E_TO(ERROR_CODE_NOT_SAME_PASSWORD);

			$ls[] = '<'.'?php';
			$ls[] = '';
			$ls[] = RET_DEFINE_STRING('BACK_ACCOUNT', $new_acc);
			$ls[] = RET_DEFINE_STRING('BACK_PASSWORD', $new_pwd);
	
			if (!SAVE_TEXT($the_db, implode("\r\n", $ls))) E_TO(ERROR_CODE_WRITE_FILE_FAIL);
			
			APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_DONE);
			P_TO($THIS_WEB_URL);
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
			'msg' => BACK_CONFIG_BACK_USER_MODIFY_DONE
		);
		INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	}

	APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

	$block = RET_TEMPLATE_CONTENT('back_config_back_user');
	$ra = array(
		'action_title'			=> sprintf(BACK_TITLE_MODIFY, BACK_CONFIG_SECTION_BACK_USER)
		,'action_url'			=> $THIS_WEB_URL
		,'post_old_account'		=> 'OLD_ACCOUNT'
		,'post_old_password'		=> 'OLD_PASSWORD'
		,'post_new_account'		=> 'NEW_ACCOUNT'
		,'post_new_password'		=> 'NEW_PASSWORD'
		,'post_new_password_again'	=> 'NEW_PASSWORD_AGAIN'
	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

	DUMP_TEMPLATE_PAGE();
}
