<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('back_page', sprintf(BACK_TITLE_NEW, $the_title));
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_INSERT);

$block = RET_TEMPLATE_CONTENT('back_flavor_new');
$ra = array(
	'action_title'			=> STR_TO_HTML(sprintf(BACK_TITLE_NEW, $the_title))
	,'action_url'			=> $THIS_WEB_URL
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
