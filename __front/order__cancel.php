<?php

if (!isset($page)) exit();

REMOVE_TMP_ID();

LOAD_TEMPLATE_PAGE('front_page_order', $the_page_caption);
INSERT_TEMPLATE_BLOCK('<script>self.close();</script>');
DUMP_TEMPLATE_PAGE();
