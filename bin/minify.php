#!/usr/bin/php
<?php
// Minify CSS files in provided folder, e.g. $npm_package_DIR_css.
// bin/minify.php $npm_package_DIR_css

// Gat $packageJson['DIR'] and others.
require_once('defines.php');

if (
	isset($argv[1]) && ($folder = trim($argv[1]))
	&& !empty($npm_package_DIR_project)
	&& !empty($npm_package_DIR_work)
	&& is_dir("$npm_package_DIR_project/$npm_package_DIR_work/$folder")
){
	doMinify("$npm_package_DIR_project/$npm_package_DIR_work/$folder");
}
else
{
	echo 'Error in ' . mkShortPath(__FILE__) . '. Wrong paths. Line ' . __LINE__ . NL . NL;
	exit;
}



