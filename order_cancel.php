<?php

require('func.php');
require('__order/order_func.php');

ORDER_CHECK_CART_MEALS();

REMOVE_TMP_ID();

$link_url = FIRST_PAGE.'?'.ARGUMENT_MODE.'='.$the_mode;
APEND_URL_ARGUMENT($link_url, ARGUMENT_LANGUAGE, PAGE_LANGUAGE);

P_TO($link_url);
