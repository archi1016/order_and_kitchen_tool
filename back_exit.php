<?php

require('func.php');
require('__back/back_func.php');

CHECK_MGR_LOGON();

session_unset();
session_destroy();

P_TO(LOGON_PAGE);
