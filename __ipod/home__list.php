<?php

if (!isset($the_operation)) exit();

LOAD_TEMPLATE_PAGE('ipod_page_home', '');

INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_SECTION_LIST());
INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_NOTICE());

INSERT_TEMPLATE_BLOCK(IPOD_BLOCK_AUTO_REFRESH());
DUMP_TEMPLATE_PAGE();