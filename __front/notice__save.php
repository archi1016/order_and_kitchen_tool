<?php

if (!isset($the_operation)) exit();

if (!SAVE_TEXT($the_db, RET_STR_POST(POST_NOTICE))) E_TO(ERROR_CODE_WRITE_FILE_FAIL);

P_TO($THIS_WEB_URL);
