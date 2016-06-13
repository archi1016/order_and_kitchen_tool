<?php

if (!isset($page)) exit();

REMOVE_TMP_ID();

P_TO(FIRST_PAGE.'?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN);