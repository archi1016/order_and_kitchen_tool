<?php

if (!isset($the_operation)) exit();

$id = RET_STR_GET(POST_ID);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);
$row = &$rows[$row_index];
$the_title = $row[COMMON_NAME].' @ '.$the_title;

LOAD_TEMPLATE_PAGE('back_page', sprintf(BACK_TITLE_MODIFY, $the_title));
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_PAGE, RET_INT_GET(ARGUMENT_PAGE));
APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION, OPERATION_SAVE);

$block = RET_TEMPLATE_CONTENT('back_tag_edit');
$ra = array(
	'action_title'			=> STR_TO_HTML(sprintf(BACK_TITLE_MODIFY, $the_title))
	,'action_url'			=> $THIS_WEB_URL
	,'source_id'			=> $row[TAG_ID]
	,'source_photo'			=> RET_PHOTO_FILE($the_folder, $row[TAG_ID], $row[TAG_PHOTO])
	,'source_name'			=> STR_TO_INPUT_VALUE($row[TAG_NAME])
	,'source_name_english'		=> STR_TO_INPUT_VALUE($row[TAG_NAME_EN])
	,'options_hide'			=> RET_OPTIONS_BOOLEAN($row[TAG_HIDE])
	,'options_hide_in_order'	=> RET_OPTIONS_BOOLEAN($row[TAG_HIDE_IN_ORDER])
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
