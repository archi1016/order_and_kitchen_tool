<?php

require('func.php');
require('__front/front_func.php');

CHECK_MGR_LOGON();

$the_title = FRONT_SECTION_HISTORY;
$the_db = RET_DB_FILE(PREFIX_ORDER_HISTORY);
$the_operation = RET_STR_GET(ARGUMENT_OPERATION);

switch ($the_operation) {			
	default:
		require('__front/history__list.php');
}
