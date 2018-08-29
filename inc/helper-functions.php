<?php

/**
 * Checks to see if string contains a given word
 * @param  [string] $str  : the string to check (haystack)
 * @param  [string] $word : the word to search for (needle)
 * @return [bool] : True if $str contains $word - False otherwise
 */
function containsWord($str, $word) {
	// (?<!^)\b(vs\.*)|(versus)\b(?!$) - possible improved regexp
	return !!preg_match('/\\b' . $word . '\\W/i', $str);
}

/**
 * Makes string SEO friendly
 * @param  [string] $string : str to be converted
 * @return [string]
 */
function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

/**
 * Echos number of days until the event
 */
function time_until_event($date) {
    $dateOfEvent = strtotime($date);
    $secs = $dateOfEvent - time();
    $days = ceil($secs / 86400);
    $str = '';

    if ($days == 1) {
        $str = $days . ' day until event';
    } else if ($days <= 0) {
        $str = 'Event happens today';
    } else {
        $str = $days . ' days until event';
    }

    echo $str;
}