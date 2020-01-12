#!/usr/bin/php
<?php
// Gat $packageJson['DIR'] and others.
require_once('defines.php');

// Paranoia.
if (
	empty($npm_package_DIR_project) || empty($npm_package_DIR_work) || empty($npm_package_DIR_raw)
	 || empty($npm_package_DIR_css) || !is_dir($npm_package_DIR_project)
){
	echo 'Error in ' . mkShortPath(__FILE__) . '. Wrong paths. Line ' . __LINE__ . NL . NL;
	exit;
}

$source = "$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css";
$ziel = "$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_raw";

if (!is_dir($source) || !is_dir($ziel))
{
	echo 'Error in ' . mkShortPath(__FILE__) . '. Wrong paths. Line ' . __LINE__ . NL . NL;
	exit;
}

doMinify($source);
doMinify($ziel);

function doMinify($path)
{
	$needle = '.min.css';
	$strlen = -(strlen($needle));

	echo 'Start minify in dir ' . mkShortPath($path) . NL;

	foreach (glob("$path/*.css") as $filename)
	{
		if (substr($filename, $strlen) === $needle)
		{
			continue;
		}

		$path_parts = pathinfo($filename);
		$output = "$path/" . $path_parts['filename'] . '.min.css';
		$command = "cleancss --level 1 --format breakWith=lf --source-map --source-map-inline-sources --output $output $filename";
		exec($command);
		echo 'Minified: ' . $path_parts['basename'] . NL;
	}
}