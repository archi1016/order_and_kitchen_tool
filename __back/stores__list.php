<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('back_page', $the_title);
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

$row = &$stores_rows[0];

$block = RET_TEMPLATE_CONTENT('back_stores_list');
INSERT_TEMPLATE_BLOCK($block);


APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

$block = RET_TEMPLATE_CONTENT('back_stores_edit');
$ra = array(
	'action_title'		=> STR_TO_HTML(sprintf(BACK_TITLE_MODIFY, $the_title))
	,'action_url'		=> $THIS_WEB_URL
	,'source_name'		=> STR_TO_INPUT_VALUE($row[STORES_NAME])
	,'source_name_english'	=> STR_TO_INPUT_VALUE($row[STORES_NAME_EN])
	,'source_telephone'	=> STR_TO_INPUT_VALUE($row[STORES_TELEPHONE])
	,'source_address'	=> STR_TO_INPUT_VALUE($row[STORES_ADDRESS])
	,'source_email'		=> STR_TO_INPUT_VALUE($row[STORES_EMAIL])
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
