#!/usr/bin/php
<?php

// Gat $packageJson['config'] and others.
require_once('defines.php');

if (
	isset($argv[1]) && ($folder = trim($argv[1]))
	&& !empty($npm_package_config_project)
	&& !empty($npm_package_config_work)
	&& defined('CREATION_DATE')
){
	$dir = "$npm_package_config_project/$npm_package_config_work/$folder";
	echo 'Write version.txt file in dir ' . mkShortPath($dir) . NL;
	@mkdir($dir, 0755, true);
	file_put_contents($dir . '/version.txt', CREATION_DATE);
}
else
{
	echo 'Error in ' . mkShortPath(__FILE__) . '. Wrong paths. Line ' . __LINE__ . NL . NL;
	exit;
}
