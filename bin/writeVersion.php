#!/usr/bin/php
<?php
/**
 * Creates folders __Prefixed-CSS and __NOT-Prefixed-CSS in workdir -w and version.txt with date of creation (=versionTxt).
 */
// Gat $packageJson['DIR'] and others.
require_once('defines.php');

// Paranoia.
if (
	empty($npm_package_DIR_project) || empty($npm_package_DIR_work) || empty($npm_package_DIR_raw)
	 || empty($npm_package_DIR_css)
	|| !is_dir($npm_package_DIR_project)
){
	echo 'Error in ' . mkShortPath(__FILE__) . '. Wrong paths. Line ' . __LINE__ . NL . NL;
	exit;
}

$css = "$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css";
$raw = "$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_raw";

$thisDirs = array($css . '/__Prefixed-CSS', $raw . '/__NOT-Prefixed-CSS');

foreach ($thisDirs as $dir)
{
	echo 'Write version.txt file in dir ' . mkShortPath($dir) . NL;
	
	@mkdir($dir, 0755, true);
	file_put_contents($dir . '/version.txt', CREATION_DATE);
}


