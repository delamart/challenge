<?php

function __autoload($class_name) {
     $parts = preg_split('/(?<=\\w)(?=[A-Z])/', $class_name, null, PREG_SPLIT_NO_EMPTY);
     $dirs = array_reverse($parts);
     $dirs = array_map('strtolower', $dirs);
     $path = ConfigLib::g('directory/base') . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $dirs) . '.class.php';
     if(file_exists($path)) { include_once($path); }
     else { throw new Exception("Could not load $class_name, looking in $path."); }
}

function ufix($url = '', $append_mtime = false) {
     $full_url = dirname($_SERVER['SCRIPT_NAME']);
     $url = '/' . ltrim($url,'/');
     $full_url = $full_url == '/' ? $url : $full_url . $url;
     if($append_mtime) {
        $mtime = filemtime(ConfigLib::g('directory/web') . $url);
        $full_url .= '?' . $mtime;
     }
     return $full_url;
}
function eUfix($url = '', $append_mtime = false) { echo ufix($url,$append_mtime); }

function url($controller = null, $view = null, $params = array(), $url_params = array()) {
     $url = ufix(basename($_SERVER['SCRIPT_NAME']) . '/');
     if($controller) { $url .= $controller . '/'; }
     if($view) { $url .= $view . '/'; }
     if(is_array($params)) { $url .= implode('/', $params); }
     else { $url .= $params; }
     $url = rtrim($url,'/');
     
     $url_params = http_build_query($url_params);
     if($url_params) { $url .= '?' . $url_params; }     
     return $url;
}
function eUrl($controller = null, $view = null, $params = array(), $url_params = array()) { echo url($controller, $view, $params, $url_params); }

function img($src, $class = '') {
     return sprintf(' <img src="%s" class="%s" alt="%s" /> ', ufix('img/' . $src), $class, basename($src));
}
function eImg($src, $class = '') { echo img($src, $class); }

function icon($icon) {
     return img('icons/' . $icon . '.png');
}
function eIcon($icon) { echo icon($icon); }

function isError($fieldname, $errors) {
    if(isset($errors[$fieldname])) return true;
    return false;
}
function eIsError($fieldname, $errors) { echo isError($fieldname, $errors) ? 'error' : ''; }

function ePost($key, $default = '') { echo isset($_POST[$key]) ? $_POST[$key] : $default; }

//------------------------------------------ 
// This function returns the necessary 
// size to show some string in display 
// For example: 
// $a = strlen_layout("WWW"); // 49 
// $a = strlen_layout("..."); // 16 
// $a = strlen_layout("Hello World"); // 99 
// 
// http://www.php.net/manual/en/function.strlen.php#76043
//------------------------------------------ 
function strlen_pixels($text) { 

	$text = iconv("UTF-8", "ASCII//IGNORE", $text);

    /* 
        Pixels utilized by each char (Verdana, 10px, non-bold) 
        04: j 
        05: I\il,-./:; <espace> 
        06: J[]f() 
        07: t 
        08: _rz* 
        09: ?csvxy 
        10: Saeko0123456789$ 
        11: FKLPTXYZbdghnpqu 
        12: AÇBCERV 
        13: <=DGHNOQU^+ 
        14: w 
        15: m 
        16: @MW 
    */ 

    // CREATING ARRAY $ps ('pixel size') 
    // Note 1: each key of array $ps is the ascii code of the char. 
    // Note 2: using $ps as GLOBAL can be a good idea, increase speed 
    // keys:    ascii-code 
    // values:  pixel size 

    // $t: array of arrays, temporary 
    $t[] = array_combine(array(106), array_fill(0, 1, 4)); 

    $t[] = array_combine(array(73,92,105,108,44), array_fill(0, 5, 5)); 
    $t[] = array_combine(array(45,46,47,58,59,32), array_fill(0, 6, 5)); 
    $t[] = array_combine(array(74,91,93,102,40,41), array_fill(0, 6, 6)); 
    $t[] = array_combine(array(116), array_fill(0, 1, 7)); 
    $t[] = array_combine(array(95,114,122,42), array_fill(0, 4, 8)); 
    $t[] = array_combine(array(63,99,115,118,120,121), array_fill(0, 6, 9)); 
    $t[] = array_combine(array(83,97,101,107), array_fill(0, 4, 10)); 
    $t[] = array_combine(array(111,48,49,50), array_fill(0, 4, 10)); 
    $t[] = array_combine(array(51,52,53,54,55,56,57,36), array_fill(0, 8, 10)); 
    $t[] = array_combine(array(70,75,76,80), array_fill(0, 4, 11)); 
    $t[] = array_combine(array(84,88,89,90,98), array_fill(0, 5, 11)); 
    $t[] = array_combine(array(100,103,104), array_fill(0, 3, 11)); 
    $t[] = array_combine(array(110,112,113,117), array_fill(0, 4, 11)); 
    $t[] = array_combine(array(65,195,135,66), array_fill(0, 4, 12)); 
    $t[] = array_combine(array(67,69,82,86), array_fill(0, 4, 12)); 
    $t[] = array_combine(array(78,79,81,85,94,43), array_fill(0, 6, 13)); 
    $t[] = array_combine(array(60,61,68,71,72), array_fill(0, 5, 13)); 
    $t[] = array_combine(array(119), array_fill(0, 1, 14)); 
    $t[] = array_combine(array(109), array_fill(0, 1, 15)); 
    $t[] = array_combine(array(64,77,87), array_fill(0, 3, 16));   
   
    // merge all temp arrays into $ps 
    $ps = array(); 
    foreach($t as $sub) $ps = $ps + $sub; 
   
    // USING ARRAY $ps 
    $total = 1; 
    for($i=0; $i<mb_strlen($text); $i++) { 
    	$j = ord(mb_strcut($text,$i,1));
        $temp = isset($ps[$j]) ? $ps[$j] : false;
        if (!$temp) $temp = 10.5; // default size for 10px 
        $total += $temp; 
    } 
    return $total; 
} 

// http://www.php.net/manual/en/function.date-diff.php#101771
function dateDifference($startDate, $endDate = null) 
{ 
    if($endDate === null) { $endDate = time(); }

    if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) 
        return false; 

    $years = date('Y', $endDate) - date('Y', $startDate); 

    $endMonth = date('n', $endDate); 
    $startMonth = date('n', $startDate); 
    
    // Calculate months 
    $months = $endMonth - $startMonth; 
    
    if ($months < 0)  { 
        $months += 12; 
        $years--; 
    } 
    if ($years < 0) 
        return false; 
    
    // Calculate the days 
    $offsets = array(); 
    if ($years > 0) 
        $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
    if ($months > 0) 
        $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
    $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

    $days = $endDate - strtotime($offsets, $startDate); 
    $days = date('z', $days);    

    return array($years, $months, $days); 
}

function eDateDifference($startDate, $endDate = null)
{
    $split = dateDifference($startDate, $endDate);
    if($split === false) { echo 'invalid dates'; return; }
    $out = '';
    $out .= $split[0] ? $split[0] . ($split[0] > 1 ? ' years ' : ' year ') : '';
    $out .= $split[1] ? $split[1] . ($split[1] > 1 ? ' months ' : ' month ') : '';
    $out .= $split[2] ? $split[2] . ($split[2] > 1 ? ' days ' : ' day ') : ' 0 days ';
    echo trim($out);
}

function password_hash($password, $salt = null, $bool = false) {
    if($salt === null) { $salt = '$2a$08$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22); }
    if($bool)
    {
        return strcmp(crypt($password,$salt),$salt) === 0;
    }    
    return crypt($password,$salt);    
}