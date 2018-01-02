<?php

function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

function str_random($length = 10) {
    $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= $base[rand(0, strlen($base) - 1)];
    }
    return $result;
}

function ensure_numb($str) {
    $str = str_replace(',', '', $str);
    return (int) str_replace('.', '', $str);
}

/**
 * Options submit
 * @return string
 */
function dp_option_submit() {
    return '<div class="submit-options"><button class="button save">Save Changes</button><button class="button reset">Reset to Default</button></div>';
}

/**
 * Custom excerpt
 * @param int $limit
 * @return string
 */
function dp_excerpt($limit) {
    $short = "";
    $contents = strip_tags(get_the_content());
    if (strlen($contents) >= $limit) {
        $text = explode(" ", substr($contents, 0, $limit));
        for ($i = 0; $i < count($text) - 1; $i++) {
            if($i == count($text) - 2){
                $short .= $text[$i];
            }else{
                $short .= $text[$i] . " ";
            }
        }
        $short .= "...";
    } else {
        $short = $contents;
    }
    return $short;
}

/**
 * Display with <pre> tag on browser
 * @param All format $value
 */
function preTag($value) {
    if (is_string($value)) {
        echo "<pre>";
        echo($value);
        echo "</pre>";
    } else {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }
}
/**
 * Init display error messages
 */
function myDebug(){
    ini_set('display_errors', 'On');
    error_reporting(E_ALL | E_STRICT);
}