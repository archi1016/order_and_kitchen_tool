<?php

require('func.php');
require('__order/order_func.php');

ORDER_CHECK_CART_MEALS();

LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_MEAL), $meal_rows, $meal_rows_count, $meal_id_to_index);
LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_CATEGORY), $category_rows, $category_rows_count, $category_id_to_index);

LOAD_TEMPLATE_PAGE('order_page', ORDER_CAPTION_NOTICE);
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_SECTION_LIST());

INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_NOTICE());
INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_LIST_RANDOM_MEALS());

INSERT_TEMPLATE_BLOCK(ORDER_BLOCK_FOOTER());
DUMP_TEMPLATE_PAGE();
