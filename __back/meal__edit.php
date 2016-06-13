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

$block = RET_TEMPLATE_CONTENT('back_meal_edit');
$ra = array(
	'action_title'			=> STR_TO_HTML(sprintf(BACK_TITLE_MODIFY, $the_title))
	,'action_url'			=> $THIS_WEB_URL
	,'source_id'			=> $row[MEAL_ID]
	,'source_photo'			=> RET_PHOTO_FILE($the_folder, $row[MEAL_ID], $row[MEAL_PHOTO])
	,'source_name'			=> STR_TO_INPUT_VALUE($row[MEAL_NAME])
	,'source_name_english'		=> STR_TO_INPUT_VALUE($row[MEAL_NAME_EN])
	,'source_price'			=> STR_TO_INPUT_VALUE($row[MEAL_PRICE])
	,'options_category'		=> RET_OPTIONS_ROWS($row[MEAL_CATEGORY], $category_rows, false)
	,'options_flavor'		=> RET_OPTIONS_ROWS($row[MEAL_FLAVOR], $flavor_rows, true)
	,'options_additional'		=> RET_OPTIONS_ROWS($row[MEAL_ADDITIONAL], $additional_rows, true)
	,'source_barcode'		=> STR_TO_INPUT_VALUE($row[MEAL_BARCODE])
	,'text_description'		=> RET_SL_TO_ML($row[MEAL_DESCRIPTION])
	,'text_description_english'	=> RET_SL_TO_ML($row[MEAL_DESCRIPTION_EN])
	,'options_hide'			=> RET_OPTIONS_BOOLEAN($row[MEAL_HIDE])
	,'options_hide_in_order'	=> RET_OPTIONS_BOOLEAN($row[MEAL_HIDE_IN_ORDER])
);
INSERT_TEMPLATE_BLOCK(RET_REPLACED_TEMPLATE($block, $ra));

DUMP_TEMPLATE_PAGE();
