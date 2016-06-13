<?php

require('config.php');
require('define.php');
require('version.php');

date_default_timezone_set(LOCAL_TIME_ZONE);

define('RANDOM_STRING', RET_RANDOM_STRING(12));
define('THIS_PHP_FILE', basename($_SERVER['SCRIPT_NAME']));
$THIS_WEB_URL = THIS_PHP_FILE;
$THIS_HTML = '';
$THIS_BLOCKS = '';

function P_TO($u) {
	$h = '<html><head><meta http-equiv="refresh" content="0; url='.$u.'"></head></html>';
	header('Content-Length: '.strlen($h));
	echo $h;
	exit();
}

function E_TO($err) {
	P_TO('error.php?'.ARGUMENT_ERROR.'='.$err);
}

function RET_VIEWPORT() {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$vp = '';
	if (false !== strpos('iPad', $ua)) {
		$vp = '1024';
	} else {
		if (false !== strpos('iPod', $ua)) {
			$vp = '960';
		} else {
			if (false !== strpos('iPhone', $ua)) {
				$vp = '960';
			} else {
				if (false !== strpos('Android', $ua)) {
					$vp = '1280';
				}
			}
		}
	}
	return $vp;
}

function RET_STR_POST($key) {
	if (isset($_POST[$key])) {
		if (get_magic_quotes_gpc()) {
			$s = stripcslashes($_POST[$key]);
		} else {
			$s = $_POST[$key];
		}
		return RET_SAFE_FILE_NAME($s);
	} else {
		return '';
	}
}

function RET_INT_POST($key) {
	if (isset($_POST[$key])) {
		return (int) $_POST[$key];
	} else {
		return 0;
	}
}

function RET_STR_GET($key) {
	if (isset($_GET[$key])) {
		if (get_magic_quotes_gpc()) {
			$s = stripcslashes($_GET[$key]);
		} else {
			$s = $_GET[$key];
		}
		return RET_SAFE_FILE_NAME($s);
	} else {
		return '';
	}
}

function RET_INT_GET($key) {
	if (isset($_GET[$key])) {
		return (int) $_GET[$key];
	} else {
		return 0;
	}
}

function FIND_FILES_FROM_FOLDER($fp, $fxn, &$fs) {
	$fs = null;
	$l = 0 - strlen($fxn);
	$dh = @opendir($fp);
	if ($dh) {
		while (true) {
			$fn = readdir($dh);
			if (false === $fn) break;
			if (substr($fn, $l) == $fxn) {
				if (is_file($fp.'/'.$fn)) {
					$fs[] = $fn;
				}
			}
		}
		closedir($dh);
		if (is_array($fs)) {
			array_multisort($fs, SORT_ASC, SORT_STRING);
			return true;
		}
	}
	return false;
}

function FIND_FOLDERS_FROM_FOLDER($fp, &$fs) {
	$fs = null;
	$dh = @opendir($fp);
	if ($dh) {
		while (true) {
			$fn = readdir($dh);
			if (false === $fn) break;
			if ('.' != $fn) {
				if ('..' != $fn) {
					if (is_dir($fp.'/'.$fn)) {
						$fs[] = $fn;
					}
				}
			}
		}
		closedir($dh);
		if (is_array($fs)) {
			array_multisort($fs, SORT_ASC, SORT_STRING);
			return true;
		}
	}
	return false;
}

function STR_TO_INPUT_VALUE($s) {
	$s = str_replace('"', '&quot;', $s);
	return $s;
}

function STR_TO_HTML($s) {
	if ('' == $s) return '';
	$s = str_replace('&', '&amp;', $s);
	$s = str_replace('<', '&lt;', $s);
	$s = str_replace('>', '&gt;', $s);
	$s = str_replace("\r", '', $s);
	$s = str_replace("\n", '<br>', $s);
	$s = str_replace('\\n', '<br>', $s);
	return $s;
}

function STR_TO_JS($s) {
	if ('' == $s) return '';
	$s = str_replace('\\', '\\\\', $s);
	$s = str_replace('\'', '\\\'', $s);
	return $s;
}

function RET_SAFE_FILE_NAME($fn) {
	$fn = str_replace('../', '', $fn);
	$fn = str_replace('..\\', '', $fn);
	return $fn;
}

function APEND_URL_ARGUMENT(&$url, $key, $val) {
	$url .= '&amp;'.$key.'='.rawurlencode($val);
}

function RET_RANDOM_STRING($c) {
	$r = '';
	while ($c > 1) {
		$r .= rand(0, 9);
		--$c;
	}
	return $r;
}

function RET_DB_FILE($pf) {
	return '_db/'.PREFIX_DB_NAME.$pf.'.tsv';
}

function RET_DB_FILE_2($pf, $id) {
	return '_db/'.PREFIX_DB_NAME.$pf.'.'.$id.'.tsv';
}

function RET_PHOTO_NAME($id, $tp, $ph) {
	if ('' == $ph) return '__default.png';
	if ('' == $tp) {
		return $id.'.'.$ph;
	} else {
		return $id.'.'.$tp.'.'.$ph;
	}
}

function LOAD_DB($fp, &$ary, &$aryc) {
	$ary = null;
	$aryc = 0;
	if (is_file($fp)) {
		$t = file_get_contents($fp);
		$t = str_replace("\r", '', $t);
		$r = explode("\n", $t);
		foreach ($r as $row) {
			if ('' != $row) {
				$ary[$aryc] = explode("\t", $row);
				++$aryc;
			}
		}
		return is_array($ary);
	}
	return false;
}

function SAVE_DB($fp, &$ary) {
	$r = null;
	foreach ($ary as $row) {
		$r[] .= implode("\t", $row);
	}
	if (is_array($r)) {
		if (false === file_put_contents($fp, implode("\r\n", $r), LOCK_EX)) {
			return false;
		}
	} else {
		@unlink($fp);
	}
	return true;
}

function INSERT_DB($fp, &$ary) {
	$r = implode("\t", $ary);
	if (LOAD_DB($fp, $rows, $rows_count)) {
		$rows[$rows_count] = explode("\t", $r);
	} else {
		$rows[0] = explode("\t", $r);
	}
	return SAVE_DB($fp, $rows);
}

function FIND_ID_ROW_INDEX($id, &$ary, $aryc) {
	if ($aryc > 0) {
		$i = 0;
		while ($i < $aryc) {
			if ($id == $ary[$i][COMMON_ID]) {
				return $i;
			}
			++$i;
		}
	}
	return -1;
}

function LOAD_DB_WITH_ROW_INDEX($fp, &$ary, &$aryc, $id, &$row_index) {
	if (!LOAD_DB($fp, $ary, $aryc)) return false;
	$row_index = FIND_ID_ROW_INDEX($id, $ary, $aryc);
	return (-1 != $row_index);
}

function SAVE_TEXT($fp, $t) {
	return (false !== file_put_contents($fp, $t, LOCK_EX));
}

function COUNT_PAGES_INFO($items, $step, $url, &$pi) {
	if (($items > 0) && ($step > 0)) {
		$pi[PAGE_ITEMS] = $items;
		$pi[PAGE_STEP] = $step;
		$pi[PAGE_TOTAL] = floor($pi[PAGE_ITEMS] / $pi[PAGE_STEP]);
		if (($pi[PAGE_ITEMS] % $pi[PAGE_STEP]) > 0) ++$pi[PAGE_TOTAL];
		$pi[PAGE_CURRENT] = RET_INT_GET(ARGUMENT_PAGE);
		if ($pi[PAGE_CURRENT] > 0) {
			if ($pi[PAGE_CURRENT] > $pi[PAGE_TOTAL]) $pi[PAGE_CURRENT] = $pi[PAGE_TOTAL];
		} else {
			$pi[PAGE_CURRENT] = 1;
		}
		$pi[PAGE_OFFSET] = ($pi[PAGE_CURRENT] - 1) * $pi[PAGE_STEP];
		$pi[PAGE_LAST] = $pi[PAGE_OFFSET] + $pi[PAGE_STEP] - 1;
		if ($pi[PAGE_LAST] >= $pi[PAGE_ITEMS]) $pi[PAGE_LAST] = $pi[PAGE_ITEMS] - 1;
		$pi[PAGE_LINK] = $url.'&amp;'.ARGUMENT_PAGE.'=';
		return true;
	} else {
		return false;
	}
}

function LOAD_DB_TO_CACHE($fp, &$rows, &$rows_count, &$id_to_index) {
	$id_to_index = null;
	if (LOAD_DB($fp, $rows, $rows_count)) {
		$i = 0;
		while ($i < $rows_count) {
			$id_to_index[$rows[$i][COMMON_ID]] = $i;
			++$i;
		}
		return true;
	}
	return false;
}

function REVERSE_ROWS(&$a, $ac) {
	if ($ac > 0) {
		$i = $ac - 1;
		while ($i >= 0) {
			$b[] = $a[$i];
			--$i;
		}
		$a = $b;
	}
}

function CHECK_MGR_LOGON() {
	global $THIS_WEB_URL;
	
	$stk = RET_STR_GET(ARGUMENT_SESSION_TOKEN);
	if ('' != $stk) {
		session_id($stk);
		session_start();
		$err = ERROR_CODE_ID_IS_TIMEOUT;
		if (isset($_SESSION[ARGUMENT_SESSION_TIMEOUT])) {
			$t = strtotime('now');
			$tl = $t - $_SESSION[ARGUMENT_SESSION_TIMEOUT];
			if (SESSION_ID_TIMEOUT > $tl) {
				$err = ERROR_CODE_NOT_SAME_MODULE;
				if (isset($_SESSION[ARGUMENT_SESSION_TYPE])) {
					if (LOGON_PAGE == $_SESSION[ARGUMENT_SESSION_TYPE]) {
						$err = ERROR_CODE_NOT_SAME_ADDRESS;				
						if (isset($_SESSION[ARGUMENT_SESSION_IP])) {
							if ($_SESSION[ARGUMENT_SESSION_IP] == $_SERVER['REMOTE_ADDR']) {
								$_SESSION[ARGUMENT_SESSION_TIMEOUT] = $t;
								define('SESSION_TOKEN', session_id());
								$THIS_WEB_URL .= '?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN;
								return;
							}
						}
					}
				}
			}
		}
		session_unset();
		session_destroy();
		E_TO($err);
	} else {
		P_TO(LOGON_PAGE);
	}
}

function RET_NEXT_ORDER_FORM_NUMBER() {
	$the_db = RET_DB_FILE(PREFIX_ORDER_FORM_COUNTER);
	$n = 0;
	if (is_file($the_db)) {
		$n = (int) file_get_contents($the_db);
	}
	if (0 >= $n) $n = 1;
	$r = $n;
	++$n;
	if ($n >= 1000) $n = 1;
	if (false !== file_put_contents($the_db, $n, LOCK_EX)) {
		return $r;
	} else {
		E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

function RET_A_TMP_ID() {
	$id = md5(PREFIX_TITLE.date('siHdmY'));
	$row[TMP_ID] 		= $id;
	$row[TMP_TIMEOUT]	= strtotime('now');
	$row[TMP_NUMBER]	= RET_NEXT_ORDER_FORM_NUMBER();
	$row[TMP_ADDRESS]	= $_SERVER['REMOTE_ADDR'];
	$row[TMP_NU_4]		= '';
	$row[TMP_NU_3]		= '';
	$row[TMP_NU_2]		= '';
	$row[TMP_NU_1]		= '';
	
	if (INSERT_DB(RET_DB_FILE(PREFIX_TMP), $row)) {
		return $id;
	} else {
		E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

function RET_TMP_ID_ROWS() {
	$tmp_db = RET_DB_FILE(PREFIX_TMP);
	LOAD_DB($tmp_db, $tmp_rows, $tmp_rows_count);
	return $tmp_rows_count;
}

function CHECK_TMP_ID() {
	global $tmp_id;
	global $tmp_db;
	global $tmp_rows;
	global $tmp_rows_count;
	global $tmp_row_index;
	global $tmp_row;
	global $cart_db;

	$tmp_id = RET_STR_GET(ARGUMENT_TMP_ID);
	if ('' == $tmp_id) return false;
	$tmp_db = RET_DB_FILE(PREFIX_TMP);
	if (!LOAD_DB_WITH_ROW_INDEX($tmp_db, $tmp_rows, $tmp_rows_count, $tmp_id, $tmp_row_index)) E_TO(ERROR_CODE_UNKNOW_ID);
	
	//$tmp_row = &$tmp_rows[$tmp_row_index]; 
	//exit funtion $tmp_row is null
	
	$tmp_row = $tmp_rows[$tmp_row_index];
	$cart_db = RET_DB_FILE_2(PREFIX_TMP, $tmp_row[TMP_ID]);
	
	if ($tmp_row[TMP_ADDRESS] != $_SERVER['REMOTE_ADDR']) E_TO(ERROR_CODE_NOT_SAME_ADDRESS);
	
	$nt = strtotime('now');
	$tl = $nt - (int) $tmp_row[TMP_TIMEOUT];
	if (TMP_ID_TIMEOUT > $tl) {
		$tmp_rows[$tmp_row_index][TMP_TIMEOUT] = $nt;
		
		if (SAVE_DB($tmp_db, $tmp_rows)) {
			return true;
		} else {
			E_TO(ERROR_CODE_WRITE_FILE_FAIL);
		}
	} else {
		@unlink($cart_db);
		unset($tmp_rows[$tmp_row_index]);
		if (SAVE_DB($tmp_db, $tmp_rows)) {
			E_TO(ERROR_CODE_ID_IS_TIMEOUT);
		} else {
			E_TO(ERROR_CODE_WRITE_FILE_FAIL);
		}
	}
}

function REMOVE_TMP_ID() {
	global $tmp_db;
	global $tmp_rows;
	global $tmp_row_index;
	
	unset($tmp_rows[$tmp_row_index]);

	$nt = strtotime('now');
	foreach ($tmp_rows as $key => $row) {
		$tl = $nt - (int) $row[TMP_TIMEOUT];
		if (TMP_ID_TIMEOUT < $tl) {
			@unlink(RET_DB_FILE_2(PREFIX_TMP, $row[TMP_ID]));
			unset($tmp_rows[$key]);
		}
	}
			
	if (SAVE_DB($tmp_db, $tmp_rows)) {
		return;
	} else {
		E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

function CHANGE_TMP_TO_ORDER_FORM($target, $is_kds_sound) {
	global $tmp_row;
	global $cart_db;
	
	$pay = RET_INT_POST(POST_ORDER_PAY);
	$total = RET_INT_POST(POST_ORDER_TOTAL);
	$memo = RET_STR_POST(POST_ORDER_MEMO);
	
	//if (0 >= $pay) E_TO(ERROR_CODE_ZERO_PAY);
	//if (0 >= $total) E_TO(ERROR_CODE_ZERO_TOTAL);
	if ($pay < $total) E_TO(ERROR_CODE_PAY_UNDER_TOTAL);
	$change = $pay - $total;
		
	$time = date('Y-m-d H:i');
	$row[ORDER_FORM_ID]		= $tmp_row[TMP_ID];
	$row[ORDER_FORM_TARGET]		= $target;
	$row[ORDER_FORM_TIME]		= $time;
	$row[ORDER_FORM_TIME_INT]	= floor(strtotime($time) / 60);
	$row[ORDER_FORM_PAY]		= $pay;
	$row[ORDER_FORM_TOTAL]		= $total;
	$row[ORDER_FORM_CHANGE]		= $change;
	$row[ORDER_FORM_NUMBER]		= $tmp_row[TMP_NUMBER];
	$row[ORDER_FORM_MEMO]		= $memo;
	$row[ORDER_FORM_NO_SOUND]	= '';
	$row[ORDER_FORM_NU_5]		= '';
	$row[ORDER_FORM_NU_4]		= '';
	$row[ORDER_FORM_NU_3]		= '';
	$row[ORDER_FORM_NU_2]		= '';
	$row[ORDER_FORM_NU_1]		= '';
		
	if ($is_kds_sound) {
		if ('1' != CONFIG_ORDER_TO_KDS_SOUND) {
			$row[ORDER_FORM_NO_SOUND] = '1';
		}
	}
		
	if (INSERT_DB(RET_DB_FILE(PREFIX_ORDER_FORM), $row)) {
		@rename($cart_db, RET_DB_FILE_2(PREFIX_ORDER_FORM, $tmp_row[TMP_ID]));
		REMOVE_TMP_ID();
		
		return;
	} else {
		E_TO(ERROR_CODE_WRITE_FILE_FAIL);
	}
}

function RET_ITEM_EN($n) {
	if ('' == $n) return '';
	return ' ('.$n.')';
}

function RET_NO_EN($n) {
	if ('' == $n) return '';
	return preg_replace('/ \(.*\)$/', '', $n);
	
}

function RET_NAMES_TO_SL($n) {
	return str_replace(ARRAY_ITEM_SPLIT, ', ', RET_NO_EN($n));
}

function RET_CART_TOTAL() {
	global $cart_rows;
	global $cart_rows_count;
	
	$t = 0;
	if ($cart_rows_count > 0) {
		foreach ($cart_rows as $row) {
			$p = (int) $row[LIST_MEAL_PRICE] + (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
			$c = (int) $row[LIST_MEAL_COUNT];
			$t += $p * $c;
		}
	}
	return $t;
}

function RET_MEAL_FORMULA(&$row) {
	$p = (int) $row[LIST_MEAL_PRICE];
	$c = (int) $row[LIST_MEAL_COUNT];
	$a = (int) $row[LIST_MEAL_ADDITIONAL_TOTAL];
	if ($a > 0) {
		$t = ($p + $a) * $c;
		return '($'.$p.' + $'.$a.') x '.$c.' = '.$t;
	} else {
		$t = $p * $c;
		return '$'.$p.' x '.$c.' = '.$t;
	}
}

function RET_MEAL_FLAVORS(&$row) {
	$r = '';
	if ('' != $row[LIST_MEAL_FLAVOR_NAMES]) {
		$r = str_replace(ARRAY_ITEM_SPLIT, ', ', STR_TO_HTML($row[LIST_MEAL_FLAVOR_NAMES])).'\\n';
	}
	return $r;
}

function RET_MEAL_ADDITIONALS(&$row) {
	$r = '';
	if (('' != $row[LIST_MEAL_ADDITIONAL_NAMES]) && ('' != $row[LIST_MEAL_ADDITIONAL_PRICES])) {
		$n = explode(ARRAY_ITEM_SPLIT, STR_TO_HTML($row[LIST_MEAL_ADDITIONAL_NAMES]));
		$p = explode(ARRAY_ITEM_SPLIT, $row[LIST_MEAL_ADDITIONAL_PRICES]);
		$c = count($n);
		$i = 0;
		while ($i < $c) {
			$r .= '+'.STR_TO_HTML($n[$i]).' $'.$p[$i].'\\n';
			++$i;
		}
	}
	return $r;
}

function RET_LIST_FLAVOR_AND_ADDITIONAL($block, &$row) {
	if (MATCH_TEMPLATE_LIST_ITEM('flavor', $block, $key, $item, $ra)) {
		if ('' != $row[LIST_MEAL_FLAVOR_NAMES]) {
			$ra[] = array(
				'meal_flavor'	=> STR_TO_HTML(RET_NAMES_TO_SL($row[LIST_MEAL_FLAVOR_NAMES]))
			);
		}
		if ('' != $row[LIST_MEAL_ADDITIONAL_NAMES]) {
			$ra[] = array(
				'meal_flavor'	=> '+'.STR_TO_HTML(RET_NAMES_TO_SL($row[LIST_MEAL_ADDITIONAL_NAMES]))
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function ORDER_MEAL_INSERT($is_append_en) {
	global $THIS_WEB_URL;
	global $meal_rows;
	global $meal_id_to_index;
	global $cart_db;
	
	$id = RET_STR_POST(POST_ID);
	$count = RET_INT_POST(POST_COUNT);
	if (0 >= $count) return false;
	if ('' == $id) E_TO(ERROR_CODE_EMPTY_ID);
	if (!isset($meal_id_to_index[$id])) E_TO(ERROR_CODE_UNKNOW_ID);
	
	$row_meal = &$meal_rows[$meal_id_to_index[$id]];
	$row[LIST_MEAL_ID]			= $row_meal[MEAL_ID];
	$row[LIST_MEAL_NAME]			= $row_meal[MEAL_NAME];
	$row[LIST_MEAL_BARCODE]			= $row_meal[MEAL_BARCODE];
	$row[LIST_MEAL_PHOTO]			= FOLDER_MEAL.'/'.RET_PHOTO_NAME($row_meal[MEAL_ID], PHOTO_MEAL_CART_WIDTH, $row_meal[MEAL_PHOTO]);
	$row[LIST_MEAL_PRICE]			= $row_meal[MEAL_PRICE];
	$row[LIST_MEAL_COUNT]			= $count;
	$row[LIST_MEAL_FLAVOR_IDS]		= '';
	$row[LIST_MEAL_FLAVOR_NAMES]		= '';
	$row[LIST_MEAL_ADDITIONAL_IDS]		= '';
	$row[LIST_MEAL_ADDITIONAL_NAMES]	= '';
	$row[LIST_MEAL_ADDITIONAL_PRICES]	= '';
	$row[LIST_MEAL_ADDITIONAL_TOTAL]	= 0;
	$row[LIST_MEAL_STATUS]			= 0;
		
	if ($is_append_en) $row[LIST_MEAL_NAME] .= RET_ITEM_EN($row_meal[MEAL_NAME_EN]);
	
	ORDER_MEAL_INSERT_FLAVOR($is_append_en, $row_meal[MEAL_FLAVOR], $row[LIST_MEAL_FLAVOR_IDS], $row[LIST_MEAL_FLAVOR_NAMES]);
	ORDER_MEAL_INSERT_ADDITIONAL($is_append_en, $row_meal[MEAL_ADDITIONAL], $row[LIST_MEAL_ADDITIONAL_IDS], $row[LIST_MEAL_ADDITIONAL_NAMES], $row[LIST_MEAL_ADDITIONAL_PRICES], $row[LIST_MEAL_ADDITIONAL_TOTAL]);
				
	if (INSERT_DB($cart_db, $row)) {
		P_TO($THIS_WEB_URL);
	} else {
		return false;
	}
}

function ORDER_MEAL_INSERT_FLAVOR($is_append_en, $flavor_id, &$ids, &$names) {
	if (!isset($_POST[POST_FLAVOR])) return;
	if (!is_array($_POST[POST_FLAVOR])) return;
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_FLAVOR), $rows, $rows_count, $id_to_index)) return;
	if (!isset($id_to_index[$flavor_id])) return;
	
	$row = &$rows[$id_to_index[$flavor_id]];
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE_2(PREFIX_FLAVOR, $row[FLAVOR_ID]), $rows, $rows_count, $id_to_index)) return;
	foreach ($_POST[POST_FLAVOR] as $id) {
		if (isset($id_to_index[$id])) {
			$row = &$rows[$id_to_index[$id]];
								
			$name = $row[MB_FLAVOR_NAME];
			if ($is_append_en) $name .= RET_ITEM_EN($row[MB_FLAVOR_NAME_EN]);
								
			$tmp_id[]	= $row[MB_FLAVOR_ID];
			$tmp_name[]	= $name;
		}
	}
	if (isset($tmp_id)) {
		$ids = implode(ARRAY_ITEM_SPLIT, $tmp_id);
		$names = implode(ARRAY_ITEM_SPLIT, $tmp_name);
	}
}

function ORDER_MEAL_INSERT_ADDITIONAL($is_append_en, $additional_id, &$ids, &$names, &$prices, &$total) {
	if (!isset($_POST[POST_ADDITIONAL])) return;
	if (!is_array($_POST[POST_ADDITIONAL])) return;
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE(PREFIX_ADDITIONAL), $rows, $rows_count, $id_to_index)) return;
	if (!isset($id_to_index[$additional_id])) return;
	
	$row = &$rows[$id_to_index[$additional_id]];
	if (!LOAD_DB_TO_CACHE(RET_DB_FILE_2(PREFIX_ADDITIONAL, $row[ADDITIONAL_ID]), $rows, $rows_count, $id_to_index)) return;
	$tmp_total = 0;
	foreach ($_POST[POST_ADDITIONAL] as $id) {
		if (isset($id_to_index[$id])) {
			$row = &$rows[$id_to_index[$id]];
								
			$name = $row[MB_ADDITIONAL_NAME];
			if ($is_append_en) $name .= RET_ITEM_EN($row[MB_ADDITIONAL_NAME_EN]);
								
			$tmp_id[]	= $row[MB_ADDITIONAL_ID];
			$tmp_name[]	= $name;
			$tmp_price[]	= $row[MB_ADDITIONAL_PRICE];
			$tmp_total += (int) $row[MB_ADDITIONAL_PRICE];
		}
	}
	if (isset($tmp_id)) {
		$ids = implode(ARRAY_ITEM_SPLIT, $tmp_id);
		$names = implode(ARRAY_ITEM_SPLIT, $tmp_name);
		$prices = implode(ARRAY_ITEM_SPLIT, $tmp_price);
		$total = $tmp_total;
	}
}



/*
function LOAD_STRING($fp) {
	define('PAGE_LANGUAGE', LOCAL_LANGUAGE);
	LOAD_STRING_CORE($fp.'/language/'.LOCAL_LANGUAGE.'.ini');
}

function LOAD_STRING_WITH_LANGUAGE($fp) {
	$lang = RET_STR_GET(ARGUMENT_LANGUAGE);
	if ('' != $lang) {
		if (is_file($fp.'/language/'.$lang.'.ini')) {
			define('PAGE_LANGUAGE', $lang);
			LOAD_STRING_CORE($fp.'/language/'.PAGE_LANGUAGE.'.ini');
			return;
		}
	}
	LOAD_STRING($fp);
}
*/

function LOAD_STRING_CORE($fp) {
	if (!is_file($fp)) return false;
	$t = file_get_contents($fp);
	$t = str_replace("\r", '', $t);
	$r = explode("\n", $t);
	foreach ($r as $row) {
		if ('' != $row) {
			if (1 == preg_match('/^([^;][A-Z_0-9]+)\s*=\s*"(.[^"]*)"\s*$/', $row, $ms)) {
				define($ms[1], $ms[2]);
			}
		}
	}
	return true;
}




function INIT_TEMPLATE_PATH($fp) {
	INIT_TEMPLATE_PATH_CORE($fp);
	
	define('PAGE_LANGUAGE', LOCAL_LANGUAGE);
	LOAD_STRING_CORE(TEMPLATE_PATH.'/lang.'.PAGE_LANGUAGE.'.ini');
}

function INIT_TEMPLATE_PATH_WITH_LANGUAGE($fp) {
	INIT_TEMPLATE_PATH_CORE($fp);
	
	$page_lang = LOCAL_LANGUAGE;
	$lang = RET_STR_GET(ARGUMENT_LANGUAGE);
	if ('' != $lang) {
		if (is_file(TEMPLATE_PATH.'/lang.'.$lang.'.ini')) {
			$page_lang = $lang;
		}
	}
	define('PAGE_LANGUAGE', $page_lang);
	LOAD_STRING_CORE(TEMPLATE_PATH.'/lang.'.PAGE_LANGUAGE.'.ini');
}

function INIT_TEMPLATE_PATH_CORE($fp) {
	$tf = $fp.'/template/template.ini';
	$t = file_get_contents($tf);
	if (false === $t) E_TO(ERROR_CODE_TEMPLATE_CONFIG);
	
	$tp = $fp.'/template/'.$t;
	if (!is_dir($tp)) E_TO(ERROR_CODE_EMPTY_TEMPLATE_PATH);
	
	define('TEMPLATE_PATH', $tp);
}

function RET_REPLACED_TEMPLATE($h, &$a) {
	foreach ($a as $k => $v) {
		$h = str_replace('$${'.$k.'}', $v, $h);
	}
	return $h;
}

function RET_TEMPLATE_CONTENT($f) {
	$h = file_get_contents(TEMPLATE_PATH.'/'.$f.'.html');
	if (false === $h) return '';
	
	$msc = preg_match_all('/\#\#\{([^\}][A-Z_0-9]+)\}/', $h, $ms, PREG_PATTERN_ORDER);
	if (false !== $msc) {
		if (0 < $msc) {
			foreach ($ms[0] as $k => $v) {
				$h = str_replace($ms[0][$k], constant($ms[1][$k]), $h);
			}
		}
	}
	return $h;
}

function RET_TEMPLATE_ITEMS($i, &$aa) {
	if (!is_array($aa)) return '';
	$h = '';
	foreach ($aa as &$a) {
		$h .= RET_REPLACED_TEMPLATE($i, $a);
	}
	return $h;
}

function LOAD_TEMPLATE_PAGE($f, $t) {
	global $THIS_HTML;
	global $THIS_BLOCKS;
	
	define('PAGE_CAPTION', STR_TO_HTML($t));
	
	$THIS_HTML = RET_TEMPLATE_CONTENT($f);
	$THIS_BLOCKS = '';
}

function INSERT_TEMPLATE_BLOCK($b) {
	global $THIS_BLOCKS;
	
	$THIS_BLOCKS .= $b."\n";
}

function DUMP_TEMPLATE_PAGE() {
	global $THIS_HTML;
	global $THIS_BLOCKS;
	
	$THIS_HTML = str_replace('<OKT:content></OKT:content>', $THIS_BLOCKS, $THIS_HTML);
	header('Content-Length: '.strlen($THIS_HTML));
	echo $THIS_HTML;
	exit();
}

function MATCH_TEMPLATE_LIST_ITEM($id, &$h, &$key, &$item, &$ra) {
	$ra = null;
	if (1 != preg_match('/<OKT:list id="'.$id.'">([\s\S]+)<\/OKT:list>/', $h, $ms)) return false;
	$key = $ms[0];
	$item = $ms[1];
	return true; 
}



if (!LOAD_DB(RET_DB_FILE(PREFIX_STORES), $stores_rows, $stores_rows_count)) E_TO(ERROR_CODE_LOAD_STORES);

if ('' != $stores_rows[0][STORES_NAME_EN]) {
	$name_en = RET_ITEM_EN(STR_TO_HTML($stores_rows[0][STORES_NAME_EN]));
} else {
	$name_en = '';
}

define('THE_STORES_NAME',		STR_TO_HTML($stores_rows[0][STORES_NAME]));
define('THE_STORES_TELEPHONE',		STR_TO_HTML($stores_rows[0][STORES_TELEPHONE]));
define('THE_STORES_ADDRESS',		STR_TO_HTML($stores_rows[0][STORES_ADDRESS]));
define('THE_STORES_EMAIL',		STR_TO_HTML($stores_rows[0][STORES_EMAIL]));
define('THE_STORES_NAME_ENGLISH',	$name_en);
