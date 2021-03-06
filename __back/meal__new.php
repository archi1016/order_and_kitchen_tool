<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('back_page', sprintf(BACK_TITLE_NEW, $the_title));
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_INSERT);

$block = RET_TEMPLATE_CONTENT('back_meal_new');
$ra = array(
	'action_title'			=> STR_TO_HTML(sprintf(BACK_TITLE_NEW, $the_title))
	,'action_url'			=> $THIS_WEB_URL
	,'options_category'		=> RET_OPTIONS_ROWS('', $category_rows, false)
	,'options_flavor'		=> RET_OPTIONS_ROWS('', $flavor_rows, true)
	,'options_additional'		=> RET_OPTIONS_ROWS('', $additional_rows, true)
	,'options_hide'			=> RET_OPTIONS_BOOLEAN('')
	,'options_hide_in_order'	=> RET_OPTIONS_BOOLEAN('')
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
