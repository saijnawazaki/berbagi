<?php
function parsedate($string)
{
	$exp_string = explode('-',$string);
	$ut = mktime(0, 0, 0, $exp_string[1], $exp_string[2], $exp_string[0]);

	return $ut;
}