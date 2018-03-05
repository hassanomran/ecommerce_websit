<?php 
function lang($phress)
{
	static $lang = array(
		"MESSAGE" => "welcome",
		"ADMIN"   => "administrator"
	);
	return $lang[$phress];
}

