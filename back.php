<?php

require('func.php');
require('__back/back_func.php');
require('__back/back_password.php');

$acc = RET_STR_POST(ARGUMENT_ACCOUNT);
$pwd = RET_STR_POST(ARGUMENT_PASSWORD);

if ((BACK_ACCOUNT == $acc) && (BACK_PASSWORD == $pwd)) {
	session_start();
	$_SESSION[ARGUMENT_SESSION_TIMEOUT]	= strtotime('now');
	$_SESSION[ARGUMENT_SESSION_TYPE]	= LOGON_PAGE;
	$_SESSION[ARGUMENT_SESSION_IP]		= $_SERVER['REMOTE_ADDR'];
	P_TO(FIRST_PAGE.'?'.ARGUMENT_SESSION_TOKEN.'='.session_id());
} else {
	LOAD_TEMPLATE_PAGE('back_page_logon', '');
	
	$block = RET_TEMPLATE_CONTENT('back_logon');
	$ra = array(
		'action_url' => THIS_PHP_FILE
	);
	INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
	
	DUMP_TEMPLATE_PAGE();
}