<?php

require('func.php');
require('__back/back_func.php');

CHECK_MGR_LOGON();

LOAD_TEMPLATE_PAGE('back_page', BACK_SECTION_ABOUT);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

$block = RET_TEMPLATE_CONTENT('back_about');
INSERT_TEMPLATE_BLOCK($block);

DUMP_TEMPLATE_PAGE();
