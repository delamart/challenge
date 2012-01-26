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