<?php

define('FOLDER_MEAL'			,'_meal');
define('FOLDER_CATEGORY'		,'_category');
define('FOLDER_FLAVOR'			,'_flavor');
define('FOLDER_ADDITIONAL'		,'_additional');
define('FOLDER_TAG'			,'_tag');
define('FOLDER_SOUND'			,'_sound');

define('PREFIX_STORES'			,'stores');
define('PREFIX_NOTICE'			,'notice');
define('PREFIX_MEAL'			,'meal');
define('PREFIX_CATEGORY'		,'category');
define('PREFIX_FLAVOR'			,'flavor');
define('PREFIX_ADDITIONAL'		,'additional');
define('PREFIX_TAG'			,'tag');
define('PREFIX_TABLE'			,'table');
define('PREFIX_TMP'			,'tmp');
define('PREFIX_PAUSE'			,'pause');
define('PREFIX_ORDER_FORM'		,'order_form');
define('PREFIX_ORDER_FORM_COUNTER'	,'order_form_counter');
define('PREFIX_ORDER_HISTORY'		,'order_history');

define('PREFIX_TITLE'			,'OKT_BY_FONGCHI_');

define('ARGUMENT_ERROR'			,'err');
define('ARGUMENT_ACCOUNT'		,'acc');
define('ARGUMENT_PASSWORD'		,'pwd');
define('ARGUMENT_SESSION_TOKEN'		,'stk');
define('ARGUMENT_SESSION_IP'		,'sip');
define('ARGUMENT_SESSION_TIMEOUT'	,'sto');
define('ARGUMENT_SESSION_TYPE'		,'stp');
define('ARGUMENT_OPERATION'		,'opr');
define('ARGUMENT_OPERATION_2'		,'op2');
define('ARGUMENT_PAGE'			,'p');
define('ARGUMENT_MODE'			,'m');
define('ARGUMENT_LANGUAGE'		,'lng');
define('ARGUMENT_TMP_ID'		,'tmpid');

define('OPERATION_NEW'			,'nw');
define('OPERATION_INSERT'		,'is');
define('OPERATION_EDIT'			,'ed');
define('OPERATION_SAVE'			,'sv');
define('OPERATION_REMOVE'		,'rm');
define('OPERATION_UP'			,'up');
define('OPERATION_DOWN'			,'dn');
define('OPERATION_MEMBER'		,'mb');
define('OPERATION_ALBUM'		,'ab');
define('OPERATION_DONE'			,'dn');
define('OPERATION_STATUS'		,'ss');
define('OPERATION_PRINT'		,'pr');
define('OPERATION_INC'			,'ic');
define('OPERATION_DEC'			,'dc');
define('OPERATION_VIEW'			,'vw');
define('OPERATION_CANCEL'		,'cn');

define('PAGE_ITEMS'			,0);
define('PAGE_STEP'			,1);
define('PAGE_TOTAL'			,2);
define('PAGE_CURRENT'			,3);
define('PAGE_OFFSET'			,4);
define('PAGE_LAST'			,5);
define('PAGE_LINK'			,6);

define('POST_SEARCH_KEYWORD'		,'ptskw');
define('POST_ID'			,'ptid');
define('POST_ID_2'			,'ptid2');
define('POST_NAME'			,'ptnm');
define('POST_NAME_EN'			,'ptnme');
define('POST_TELEPHONE'			,'pttel');
define('POST_ADDRESS'			,'ptadr');
define('POST_EMAIL'			,'pteml');
define('POST_PHOTO'			,'ptpht');
define('POST_PRICE'			,'ptprc');
define('POST_DESCRIPTION'		,'ptdcp');
define('POST_DESCRIPTION_EN'		,'ptdcpe');
define('POST_BARCODE'			,'ptbrd');
define('POST_CATEGORY'			,'ptctg');
define('POST_FLAVOR'			,'ptfvr');
define('POST_ADDITIONAL'		,'ptadt');
define('POST_FLAVOR_LIMIT'		,'ptfrl');
define('POST_HIDE'			,'pthid');
define('POST_HIDE_IN_ORDER'		,'pthio');
define('POST_NOTICE'			,'ptnot');
define('POST_TAG'			,'pttag');
define('POST_COUNT'			,'ptcnt');

define('ERROR_CODE_UNKNOW'		,0);
define('ERROR_CODE_LOAD_STORES'		,1);
define('ERROR_CODE_UNKNOW_ORDER_MODE'	,2);
define('ERROR_CODE_NOT_SAME_ADDRESS'	,3);
define('ERROR_CODE_EMPTY_ID'		,4);
define('ERROR_CODE_UNKNOW_ID'		,5);
define('ERROR_CODE_WRITE_FILE_FAIL'	,6);
define('ERROR_CODE_EMPTY_TABLE_NAME'	,7);
define('ERROR_CODE_EMPTY_TABLE_ADDRESS'	,8);
define('ERROR_CODE_EMPTY_CATEGORY_NAME'	,9);
define('ERROR_CODE_EMPTY_FLAVOR_NAME'	,10);
define('ERROR_CODE_EMPTY_MEMBER_NAME'	,11);
define('ERROR_CODE_EMPTY_ADDITIONAL_NAME',12);
define('ERROR_CODE_EMPTY_MEAL_NAME'	,13);
define('ERROR_CODE_EMPTY_TAG_NAME'	,14);
define('ERROR_CODE_UNKNOW_TAG'		,15);
define('ERROR_CODE_UNKNOW_CATEGORY'	,16);
define('ERROR_CODE_UNKNOW_MEAL'		,17);
define('ERROR_CODE_UNKNOW_TABLE'	,18);
define('ERROR_CODE_ZERO_PAY'		,19);
define('ERROR_CODE_ZERO_TOTAL'		,20);
define('ERROR_CODE_PAY_UNDER_TOTAL'	,21);
define('ERROR_CODE_NOT_MP3'		,22);
define('ERROR_CODE_ID_IS_TIMEOUT'	,23);
define('ERROR_CODE_EMPTY_ACCOUNT'	,24);
define('ERROR_CODE_EMPTY_PASSWORD'	,25);
define('ERROR_CODE_NOT_SAME_PASSWORD'	,26);
define('ERROR_CODE_NOT_SAME_MODULE'	,27);
define('ERROR_CODE_TEMPLATE_CONFIG'	,28);
define('ERROR_CODE_EMPTY_TEMPLATE_PATH'	,29);
define('ERROR_CODE_OVER_TMP_LIMIT'	,30);
define('ERROR_CODE_NOT_ZIP'		,31);

define('SESSION_ID_TIMEOUT'		,1200);
define('TMP_ID_TIMEOUT'			,600);

define('COMMON_ID'			,0);
define('COMMON_NAME'			,1);

define('STORES_ID'			,0);
define('STORES_NAME'			,1);
define('STORES_TELEPHONE'		,2);
define('STORES_ADDRESS'			,3);
define('STORES_EMAIL'			,4);
define('STORES_NAME_EN'			,5);
define('STORES_NU_2'			,6);
define('STORES_NU_1'			,7);

define('TMP_ID'				,0);
define('TMP_TIMEOUT'			,1);
define('TMP_NUMBER'			,2);
define('TMP_ADDRESS'			,3);
define('TMP_NU_4'			,4);
define('TMP_NU_3'			,5);
define('TMP_NU_2'			,6);
define('TMP_NU_1'			,7);

define('TABLE_ID'			,0);
define('TABLE_NAME'			,1);
define('TABLE_ADDRESS'			,2);
define('TABLE_NU_5'			,3);
define('TABLE_NU_4'			,4);
define('TABLE_NU_3'			,5);
define('TABLE_NU_2'			,6);
define('TABLE_NU_1'			,7);

define('CATEGORY_ID'			,0);
define('CATEGORY_NAME'			,1);
define('CATEGORY_PHOTO'			,2);
define('CATEGORY_NAME_EN'		,3);
define('CATEGORY_HIDE'			,4);
define('CATEGORY_HIDE_IN_ORDER'		,5);
define('CATEGORY_NU_2'			,6);
define('CATEGORY_NU_1'			,7);

define('TAG_ID'				,0);
define('TAG_NAME'			,1);
define('TAG_PHOTO'			,2);
define('TAG_NAME_EN'			,3);
define('TAG_HIDE'			,4);
define('TAG_HIDE_IN_ORDER'		,5);
define('TAG_NU_2'			,6);
define('TAG_NU_1'			,7);

define('FLAVOR_ID'			,0);
define('FLAVOR_NAME'			,1);
define('FLAVOR_NU_6'			,2);
define('FLAVOR_NU_5'			,3);
define('FLAVOR_NU_4'			,4);
define('FLAVOR_NU_3'			,5);
define('FLAVOR_NU_2'			,6);
define('FLAVOR_NU_1'			,7);

define('ADDITIONAL_ID'			,0);
define('ADDITIONAL_NAME'		,1);
define('ADDITIONAL_NU_6'		,2);
define('ADDITIONAL_NU_5'		,3);
define('ADDITIONAL_NU_4'		,4);
define('ADDITIONAL_NU_3'		,5);
define('ADDITIONAL_NU_2'		,6);
define('ADDITIONAL_NU_1'		,7);

define('MEAL_ID'			,0);
define('MEAL_NAME'			,1);
define('MEAL_PHOTO'			,2);
define('MEAL_PRICE'			,3);
define('MEAL_DESCRIPTION'		,4);
define('MEAL_CATEGORY'			,5);
define('MEAL_FLAVOR'			,6);
define('MEAL_ADDITIONAL'		,7);
define('MEAL_BARCODE'			,8);
define('MEAL_NAME_EN'			,9);
define('MEAL_DESCRIPTION_EN'		,10);
define('MEAL_HIDE'			,11);
define('MEAL_HIDE_IN_ORDER'		,12);
define('MEAL_PAUSED'			,13);
define('MEAL_NU_2'			,14);
define('MEAL_NU_1'			,15);

define('AB_MEAL_ID'			,0);
define('AB_MEAL_PHOTO'			,1);
define('AB_MEAL_NU_6'			,2);
define('AB_MEAL_NU_5'			,3);
define('AB_MEAL_NU_4'			,4);
define('AB_MEAL_NU_3'			,5);
define('AB_MEAL_NU_2'			,6);
define('AB_MEAL_NU_1'			,7);

define('MB_FLAVOR_ID'			,0);
define('MB_FLAVOR_NAME'			,1);
define('MB_FLAVOR_PHOTO'		,2);
define('MB_FLAVOR_NAME_EN'		,3);
define('MB_FLAVOR_NU_4'			,4);
define('MB_FLAVOR_NU_3'			,5);
define('MB_FLAVOR_NU_2'			,6);
define('MB_FLAVOR_NU_1'			,7);

define('MB_ADDITIONAL_ID'		,0);
define('MB_ADDITIONAL_NAME'		,1);
define('MB_ADDITIONAL_PHOTO'		,2);
define('MB_ADDITIONAL_PRICE'		,3);
define('MB_ADDITIONAL_DESCRIPTION'	,4);
define('MB_ADDITIONAL_NAME_EN'		,5);
define('MB_ADDITIONAL_DESCRIPTION_EN'	,6);
define('MB_ADDITIONAL_NU_1'		,7);

define('MB_TAG_ID'			,0);
define('MB_TAG_NU_7'			,1);
define('MB_TAG_NU_6'			,2);
define('MB_TAG_NU_5'			,3);
define('MB_TAG_NU_4'			,4);
define('MB_TAG_NU_3'			,5);
define('MB_TAG_NU_2'			,6);
define('MB_TAG_NU_1'			,7);



define('PREFIX_PHOTO_SOURCE'		,'source');

define('PHOTO_DEFAULT_WIDTH'		,100);
define('PHOTO_DEFAULT_HEIGHT'		,75);

define('PHOTO_GROUP_FRONT_WIDTH'	,160);
define('PHOTO_GROUP_FRONT_HEIGHT'	,120);
define('PHOTO_GROUP_ORDER_WIDTH'	,235);
define('PHOTO_GROUP_ORDER_HEIGHT'	,235);

define('PHOTO_MEAL_FRONT_WIDTH'		,192);
define('PHOTO_MEAL_FRONT_HEIGHT'	,192);
define('PHOTO_MEAL_ORDER_WIDTH'		,316);
define('PHOTO_MEAL_ORDER_HEIGHT'	,316);
define('PHOTO_MEAL_CART_WIDTH'		,160);
define('PHOTO_MEAL_CART_HEIGHT'		,160);
define('PHOTO_MEAL_LARGE_WIDTH'		,940);
define('PHOTO_MEAL_LARGE_HEIGHT'	,0);

define('PHOTO_ALBUM_BACK_WIDTH'		,200);
define('PHOTO_ALBUM_BACK_HEIGHT'	,150);
define('PHOTO_ALBUM_LARGE_WIDTH'	,940);
define('PHOTO_ALBUM_LARGE_HEIGHT'	,0);

define('POST_ORDER_TARGET'		,'otarget');
define('POST_ORDER_PAY'			,'opay');
define('POST_ORDER_TOTAL'		,'ototal');
define('POST_ORDER_CHANGE'		,'ochange');
define('POST_ORDER_MEMO'		,'omemo');
define('POST_ORDER_MEALS'		,'omeals');

define('SOUND_NEW_ORDER_FORM'		,'new_order_form.mp3');

define('ORDER_FORM_ID'			,0);
define('ORDER_FORM_TARGET'		,1);
define('ORDER_FORM_TIME'		,2);
define('ORDER_FORM_TIME_INT'		,3);
define('ORDER_FORM_PAY'			,4);
define('ORDER_FORM_TOTAL'		,5);
define('ORDER_FORM_CHANGE'		,6);
define('ORDER_FORM_NUMBER'		,7);
define('ORDER_FORM_MEMO'		,8);
define('ORDER_FORM_NO_SOUND'		,9);
define('ORDER_FORM_NU_5'		,10);
define('ORDER_FORM_NU_4'		,11);
define('ORDER_FORM_NU_3'		,12);
define('ORDER_FORM_NU_2'		,13);
define('ORDER_FORM_NU_1'		,14);

define('ORDER_HISTORY_ID'		,0);
define('ORDER_HISTORY_TIME_IN'		,1);
define('ORDER_HISTORY_TIME_OUT'		,2);
define('ORDER_HISTORY_TIME_EXPEND'	,3);
define('ORDER_HISTORY_NUMBER'		,4);
define('ORDER_HISTORY_TARGET'		,5);
define('ORDER_HISTORY_PAY'		,6);
define('ORDER_HISTORY_TOTAL'		,7);
define('ORDER_HISTORY_CHANGE'		,8);
define('ORDER_HISTORY_MEMO'		,9);
define('ORDER_HISTORY_NU_6'		,10);
define('ORDER_HISTORY_NU_5'		,11);
define('ORDER_HISTORY_NU_4'		,12);
define('ORDER_HISTORY_NU_3'		,13);
define('ORDER_HISTORY_NU_2'		,14);
define('ORDER_HISTORY_NU_1'		,15);

define('LIST_MEAL_SPLIT'		,'<|>');
define('ARRAY_ITEM_SPLIT'		,'||');

define('LIST_MEAL_ID'			,0);
define('LIST_MEAL_NAME'			,1);
define('LIST_MEAL_BARCODE'		,2);
define('LIST_MEAL_PHOTO'		,3);
define('LIST_MEAL_PRICE'		,4);
define('LIST_MEAL_COUNT'		,5);
define('LIST_MEAL_FLAVOR_IDS'		,6);
define('LIST_MEAL_FLAVOR_NAMES'		,7);
define('LIST_MEAL_ADDITIONAL_IDS'	,8);
define('LIST_MEAL_ADDITIONAL_NAMES'	,9);
define('LIST_MEAL_ADDITIONAL_PRICES'	,10);
define('LIST_MEAL_ADDITIONAL_TOTAL'	,11);
define('LIST_MEAL_STATUS'		,12);
