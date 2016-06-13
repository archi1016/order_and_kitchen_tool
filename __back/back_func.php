<?php

define('LOGON_PAGE'			,'back.php');
define('FIRST_PAGE'			,'back_stores.php');

INIT_TEMPLATE_PATH('__back');

define('CONFIG_FRONT_MISC'		,'front_misc');
define('CONFIG_FRONT_SOUND'		,'front_sound');
define('CONFIG_ORDER_MISC'		,'order_misc');
define('CONFIG_FRONT_USER'		,'front_user');
define('CONFIG_BACK_USER'		,'back_user');
define('CONFIG_TEMPLATE'		,'template');
define('CONFIG_UPDATE'			,'update');

function BACK_BLOCK_SECTION_LIST() {
	$arguments = '?'.ARGUMENT_SESSION_TOKEN.'='.SESSION_TOKEN;
	$section_info = array(
		array('back_notice.php'		,BACK_SECTION_NOTICE)
		,array('back_pause.php'		,BACK_SECTION_PAUSE)
		,array('back_meal.php'		,BACK_SECTION_MEAL)
		,array('back_category.php'	,BACK_SECTION_CATEGORY)
		,array('back_tag.php'		,BACK_SECTION_TAG)
		,array('back_flavor.php'	,BACK_SECTION_FLAVOR)
		,array('back_additional.php'	,BACK_SECTION_ADDITIONAL)
		,array('back_table.php'		,BACK_SECTION_TABLE)
		,array('back_stores.php'	,BACK_SECTION_STORES)
		,array('back_config.php'	,BACK_SECTION_CONFIG)
		,array('back_about.php'		,BACK_SECTION_ABOUT)
	);
	
	$block = RET_TEMPLATE_CONTENT('back_section');
	if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
		foreach ($section_info as &$r) {
			$c = 'link';
			if (THIS_PHP_FILE == $r[COMMON_ID]) $c = 'current';
			$ra[] = array(
				'section_url'		=> $r[COMMON_ID].$arguments
				,'section_name'		=> $r[COMMON_NAME]
				,'section_class'	=> $c
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	$ra = array(
		'logoff_url' => 'back_exit.php'.$arguments
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	return $block;
}

function BACK_BLOCK_CONFIG_SECTION_LIST($prev_url) {
	global $the_mode;
	global $the_title;
	
	$section_info = array(
		array(CONFIG_FRONT_SOUND, BACK_CONFIG_SECTION_FRONT_SOUND)
		,array(CONFIG_FRONT_MISC, BACK_CONFIG_SECTION_FRONT_MISC)
		,array(CONFIG_ORDER_MISC, BACK_CONFIG_SECTION_ORDER_MISC)
		,array(CONFIG_FRONT_USER, BACK_CONFIG_SECTION_FRONT_USER)
		,array(CONFIG_BACK_USER, BACK_CONFIG_SECTION_BACK_USER)
		,array(CONFIG_TEMPLATE, BACK_CONFIG_SECTION_TEMPLATE)
		,array(CONFIG_UPDATE, BACK_CONFIG_SECTION_UPDATE)
	);
	
	$block = RET_TEMPLATE_CONTENT('back_config_section');
	if (MATCH_TEMPLATE_LIST_ITEM('section', $block, $key, $item, $ra)) {
		foreach ($section_info as &$r) {
			$link_url = $prev_url;
			APEND_URL_ARGUMENT($link_url, ARGUMENT_MODE, $r[COMMON_ID]);
		
			$c = 'link';
			if ($the_mode == $r[COMMON_ID]) {
				$c = 'current';
				$the_title = $r[COMMON_NAME].' @ '.$the_title;
			}
			
			$ra[] = array(
				'section_url'		=> $link_url
				,'section_name'		=> $r[COMMON_NAME]
				,'section_class'	=> $c
			);
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}

function BACK_BLOCK_TOOLBAR_SEARCH($kw) {
	global $THIS_WEB_URL;
	
	$block = RET_TEMPLATE_CONTENT('back_toolbar_search');
	$ra = array(
		'action_url'	=> $THIS_WEB_URL
		,'keyword'	=> STR_TO_INPUT_VALUE($kw)
		,'new_url'	=> $THIS_WEB_URL.'&amp;'.ARGUMENT_OPERATION.'='.OPERATION_NEW
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	return $block;
}

function BACK_BLOCK_TOOLBAR_MEMBER($prev_url, $t) {
	global $THIS_WEB_URL;
	
	$block = RET_TEMPLATE_CONTENT('back_toolbar_member');
	$ra = array(
		'parent_url'	=> $prev_url
		,'title'	=> STR_TO_HTML($t)
		,'new_url'	=> $THIS_WEB_URL.'&amp;'.ARGUMENT_OPERATION_2.'='.OPERATION_NEW
	);
	$block = RET_REPLACED_TEMPLATE($block, $ra);
	return $block;
}

function BACK_BLOCK_LIST_PAGE(&$pi) {
	if (1 >= $pi[PAGE_TOTAL]) return '';
	
	$block = RET_TEMPLATE_CONTENT('back_list_page');
	if (MATCH_TEMPLATE_LIST_ITEM('page', $block, $key, $item, $ra)) {
		$i = 1;
		while ($i <= $pi[PAGE_TOTAL]) {
			$c = 'link';
			if ($pi[PAGE_CURRENT] == $i) $c = 'current';
			
			$ra[] = array(
				'page_url'	=> $pi[PAGE_LINK].$i
				,'page_name'	=> $i
				,'page_class'	=> $c
			);
			++$i;
		}
		$block = str_replace($key, RET_TEMPLATE_ITEMS($item, $ra), $block);
	}
	return $block;
}


function SEARCH_ROWS_TITLE($kw, &$a, &$ac) {
	if ('' != $kw) {
		$i = 0;
		while ($i < $ac) {
			if (false !== strripos($a[$i][COMMON_NAME], $kw)) {
				$na[] = $a[$i];
			}
			++$i;
		}
		if (isset($na)) {
			$a = $na;
			$ac = count($a);
		} else {
			$ac = 0;
		}
	}
}


function RET_OPTIONS_BOOLEAN($v) {
	if ('1' == $v) {
		return '<option value="">'.BACK_OPTION_FALSE.'</option><option value="1" selected>'.BACK_OPTION_TRUE.'</option>';
	} else {
		return '<option value="">'.BACK_OPTION_FALSE.'</option><option value="1">'.BACK_OPTION_TRUE.'</option>';
	}
}

function RET_OPTIONS_ROWS($v, &$a, $is_has_null) {
	$h = '';
	if ($is_has_null) $h .= '<option value="">'.BACK_OPTION_NONE.'</option>';
	
	$c = count($a);
	if ($c > 0) {
		$i = 0;
		while ($i < $c) {
			$r = '<option value="'.$a[$i][COMMON_ID].'"';
			if ($v == $a[$i][COMMON_ID]) $r .= ' selected';
			$r .= '>'.STR_TO_HTML($a[$i][COMMON_NAME]).'</option>';
			$h .= $r;
			++$i;
		}
	}
	return $h;
}

function RET_DEFINE_STRING($n, $v) {
	return 'define(\''.$n.'\', \''.STR_TO_JS($v).'\');';
}

function RET_DEFINE_NUMBER($n, $v) {
	return 'define(\''.$n.'\', '.$v.');';
}




function RET_UPLOAD_ICON($fp, $id) {
	if (!isset($_FILES[POST_PHOTO])) return '';
	$p = &$_FILES[POST_PHOTO];
	if (UPLOAD_ERR_OK != $p['error']) return '';
	$en = explode('.', $p['name']);
	$en = $en[count($en)-1];
	$f = $fp.'/'.RET_PHOTO_NAME($id, '', $en);
	if (move_uploaded_file($p['tmp_name'], $f)) {
		return $en;
	}
	return '';
}

function RET_UPLOAD_PHOTO($fp, $id) {
	if (!isset($_FILES[POST_PHOTO])) return '';
	$p = &$_FILES[POST_PHOTO];
	if (UPLOAD_ERR_OK != $p['error']) return '';
	$en = explode('.', $p['name']);
	$en = $en[count($en)-1];
	$f = $fp.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $en);
	if (move_uploaded_file($p['tmp_name'], $f)) {
		return $en;
	}
	return '';
}

function CHECK_PHOTO_ORIENTATION($sfile, &$si) {
	$exif = exif_read_data($sfile, 'IFD0');			
	if (false === $exif) return;
	if (!isset($exif['Orientation'])) return;
	switch ($exif['Orientation']) {
		case 2:
			break;
		case 3:
			$new_si = imagerotate($si, 180, 0);
			if ($new_si !== false) {
				imagedestroy($si);
				$si = $new_si;
			}
			break;
		case 4:
			$new_si = imagerotate($si, 180, 0);
			if ($new_si !== false) {
				imagedestroy($si);
				$si = $new_si;
			}
			break;
		case 5:
			$new_si = imagerotate($si, 270, 0);
			if ($new_si !== false) {
				imagedestroy($si);
				$si = $new_si;
			}
			break;
		case 6:
			$new_si = imagerotate($si, 270, 0);
			if ($new_si !== false) {
				imagedestroy($si);
				$si = $new_si;
			}
			break;
		case 7:
			$new_si = imagerotate($si, 90, 0);
			if ($new_si !== false) {
				imagedestroy($si);
				$si = $new_si;
			}
			break;
		case 8:
			$new_si = imagerotate($si, 90, 0);
			if ($new_si !== false) {
				imagedestroy($si);
				$si = $new_si;
			}
			break;
	}
}

function RESCALE_PHOTO($sfile, $tfile, $tow, $toh) {
	$shandle = imagecreatefromjpeg($sfile);
	if ($shandle === false) return;
	CHECK_PHOTO_ORIENTATION($sfile, $shandle);
	$sw = imagesx($shandle);
	$sh = imagesy($shandle);
	$sr = (float) $sh / (float) $sw;
	$tor = (float) $toh / (float) $tow;
	if (($tow != $sw) || ($toh != $sh)) {
		if ($toh > 0) {
			if ($sr > $tor) {
				$w = $sw;
				$h = ($w * $toh) / $tow;
				$l = 0;
				$t = ($sh - $h) >> 2;
			} else {
				$h = $sh;
				$w = ($h * $tow) / $toh;
				$t = 0;
				$l = ($sw - $w) >> 2;
			}
		} else {
			$w = $sw;
			$h = $sh;
			$l = 0;
			$t = 0;
			$toh = ($tow * $sh) / $sw;
		}
		$thandle = imagecreatetruecolor($tow, $toh);
		if (imagecopyresampled($thandle, $shandle, 0, 0, $l, $t, $tow, $toh, $w, $h)) {
			SHARPEN_PHOTO($thandle);
			imagejpeg($thandle, $tfile, 90);
		}
		imagedestroy($thandle);
	}
	imagedestroy($shandle);
}

function SHARPEN_PHOTO($h) {
	$matrix = array(
		array( -1.0, -1.0, -1.0)
		,array(-1.0, 17.0, -1.0)
		,array(-1.0, -1.0, -1.0)
	);
	$divisor = array_sum(array_map('array_sum', $matrix));
	imageconvolution($h, $matrix, $divisor, 0);
}

function RET_ICON_FILE($f, $id, $en) {
	return '<img src="'.$f.'/'.RET_PHOTO_NAME($id, '', $en).'?'.RANDOM_STRING.'">';
}

function RET_PHOTO_FILE($f, $id, $en) {
	if ('' != $en) {
		return '<a title="'.BACK_TITLE_SOURCE_PHOTO.'" href="'.$f.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $en).'" target="_blank"><img src="'.$f.'/'.RET_PHOTO_NAME($id, '', $en).'?'.RANDOM_STRING.'"></a>';
	} else {
		return '<img src="'.$f.'/'.RET_PHOTO_NAME($id, '', $en).'?'.RANDOM_STRING.'">';
	}
}

function RET_ALBUM_FILE($f, $id, $en) {
	if ('' != $en) {
		return '<a title="'.BACK_TITLE_SOURCE_PHOTO.'" href="'.$f.'/'.RET_PHOTO_NAME($id, PREFIX_PHOTO_SOURCE, $en).'" target="_blank"><img src="'.$f.'/'.RET_PHOTO_NAME($id, PHOTO_ALBUM_BACK_WIDTH, $en).'?'.RANDOM_STRING.'"></a>';
	} else {
		return '<img src="'.$f.'/'.RET_PHOTO_NAME($id, '', $en).'?'.RANDOM_STRING.'">';
	}
}

function RET_HIDE_PREFIX($h) {
	if ('' != $h) {
		return 'hide';
	} else {
		return '';
	}
}

function RET_ML_TO_SL($s) {
	$s = str_replace("\r", '' ,$s);
	$s = str_replace("\t", '\t' ,$s);
	$s = str_replace("\n", '\n' ,$s);
	return $s;
}

function RET_SL_TO_ML($s) {
	$s = str_replace('\n', "\n" ,$s);
	$s = str_replace('\t', "\t" ,$s);
	return $s;
}

function RET_CATEGORY_NAME($id) {
	global $category_rows;
	global $category_rows_count;
	global $category_id_to_index;
	
	$h = '<span class="key">??????</span>';
	if ($category_rows_count > 0) {
		if (isset($category_id_to_index[$id])) {
			$h = STR_TO_HTML($category_rows[$category_id_to_index[$id]][CATEGORY_NAME]);
		}
	}
	return $h;
}

function RET_FLAVOR_NAME($id, $limit) {
	global $flavor_rows;
	global $flavor_rows_count;
	global $flavor_id_to_index;
	
	$h = '------';
	if ($flavor_rows_count > 0) {
		if (isset($flavor_id_to_index[$id])) {
			$h = STR_TO_HTML($flavor_rows[$flavor_id_to_index[$id]][FLAVOR_NAME]);
			if ($limit > 0) {
				$h .= ' {'.$limit.'}';
			}
		}
	}
	return $h;
}

function RET_ADDITIONAL_NAME($id) {
	global $additional_rows;
	global $additional_rows_count;
	global $additional_id_to_index;
	
	$h = '------';
	if ($additional_rows_count > 0) {
		if (isset($additional_id_to_index[$id])) {
			$h = STR_TO_HTML($additional_rows[$additional_id_to_index[$id]][ADDITIONAL_NAME]);
		}
	}
	return $h;
}

function LIST_TEMPLATE_INFO($fp, &$a) {
	$a = null;
	if (FIND_FOLDERS_FROM_FOLDER($fp.'/template', $fs)) {
		foreach ($fs as $f) {
			$tf = $fp.'/template/'.$f.'/lang.'.LOCAL_LANGUAGE.'.ini';
			if (is_file($tf)) {
				$tc = file_get_contents($tf);
				if (1 == preg_match('/([^;]TEMPLATE_NAME)\s*=\s*"(.[^"]*)"/', $tc, $ms)) {
					$a[] = array($f, $ms[2]);
				} else {
					$a[] = array($f, 'unknow');
				}
			} else {
				$a[] = array($f, 'unknow');
			}
		}
	}
}