<?php

function getTile()
{
	global $pageTitle;

	if(isset($pageTitle))
	{
		echo $pageTitle;
	}
	else
	{
		echo "default"
	}
}