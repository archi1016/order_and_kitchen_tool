<?php

if (!isset($id_category)) exit();

ORDER_BUILD_GROUP_LINE_IDS();
$title = $row_category[CATEGORY_NAME].RET_ITEM_EN($row_category[CATEGORY_NAME_EN]);

LOAD_TEMPLATE_PAGE('order_page', $title);
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_SECTION_LIST());

if (OPERATION_INSERT == $the_operation) {
	ORDER_MEAL_INSERT(true);
} else {
	INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_NAV_GROUP());
	INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_CATEGORY_MEALS($title));
}
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_GROUPS());

INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_FOOTER());
DUMP_TEMPLATE_PAGE();