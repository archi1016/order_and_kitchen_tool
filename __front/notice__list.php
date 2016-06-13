<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('front_page', $the_title);
INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_SECTION_LIST());

if (is_file($the_db)) {
	$n = file_get_contents($the_db);
} else {
	$n = '';
}
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

$block = RET_TEMPLATE_CONTENT('front_notice_list');
$ra = array(
	'notice'		=> STR_TO_HTML($n)
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

$block = RET_TEMPLATE_CONTENT('front_notice_edit');
$ra = array(
	'action_title'		=> STR_TO_HTML(sprintf(FRONT_TITLE_MODIFY, $the_title))
	,'action_url'		=> $THIS_WEB_URL
	,'text_notice'		=> $n
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

INSERT_TEMPLATE_BLOCK(FRONT_BLOCK_AUTO_REFRESH());
DUMP_TEMPLATE_PAGE();
