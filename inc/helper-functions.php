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