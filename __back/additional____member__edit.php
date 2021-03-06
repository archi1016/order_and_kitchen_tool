<?php

if (!isset($the_operation_2)) exit();

$id = RET_STR_GET(POST_ID_2);
if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);

if (!LOAD_DB_WITH_ROW_INDEX($the_db_2, $rows, $rows_count, $id, $row_index)) E_TO(ERROR_CODE_UNKNOW_ID);
$row = &$rows[$row_index];
$the_title = $row[MB_ADDITIONAL_NAME].' @ '.$the_title;

LOAD_TEMPLATE_PAGE('back_page', sprintf(BACK_TITLE_MODIFY, $the_title));
INSERT_TEMPLATE_BLOCK(BACK_BLOCK_SECTION_LIST());

APEND_URL_ARGUMENT($THIS_WEB_URL, ARGUMENT_OPERATION_2, OPERATION_SAVE);

$block = RET_TEMPLATE_CONTENT('back_additional_member_edit');
$ra = array(
	'action_title'			=> STR_TO_HTML(sprintf(BACK_TITLE_MODIFY, $the_title))
	,'action_url'			=> $THIS_WEB_URL
	,'source_id'			=> $row[MB_ADDITIONAL_ID]
	,'source_photo'			=> RET_PHOTO_FILE($the_folder, $row[MB_ADDITIONAL_ID], $row[MB_ADDITIONAL_PHOTO])
	,'source_name'			=> STR_TO_INPUT_VALUE($row[MB_ADDITIONAL_NAME])
	,'source_name_english'		=> STR_TO_INPUT_VALUE($row[MB_ADDITIONAL_NAME_EN])
	,'source_price'			=> STR_TO_INPUT_VALUE($row[MB_ADDITIONAL_PRICE])
	,'source_description'		=> STR_TO_INPUT_VALUE($row[MB_ADDITIONAL_DESCRIPTION])
	,'source_description_english'	=> STR_TO_INPUT_VALUE($row[MB_ADDITIONAL_DESCRIPTION_EN])
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));
		
DUMP_TEMPLATE_PAGE();
