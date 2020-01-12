<?php

$jsonAsArray = true;

// the main dir where e.g. package.json is located.
if (!defined('JPATH_MAIN'))
{
	define('JPATH_MAIN', dirname(__DIR__) . '/');
}

// newline shortcut
if (!defined('NL'))
{
	define('NL', PHP_EOL);
}

if (empty($packageJson))
{
	$packageJson = json_decode(
		file_get_contents(JPATH_MAIN . 'package.json'),
		$jsonAsArray
	);
	
	$replaceMe = $replaceWith = array();

	foreach ($packageJson['DIR'] as $key => $value)
	{
		$Variable = 'npm_package_DIR_' . $key;
		$$Variable = trim($value);
		
		$replaceMe[] = '$' . $Variable;
		$replaceWith[] = $value;
	}
}

if (!defined('CREATION_DATE'))
{
	define('CREATION_DATE', $packageJson['versionTxt']);
}

if (empty($ftpJson) && file_exists($npm_package_DIR_project . '/ftp-credentials.json'))
{
	$ftpJson = json_decode(
		file_get_contents($npm_package_DIR_project . '/ftp-credentials.json'),
		$jsonAsArray
	);
}

function mkShortPath($path)
{
	return str_replace(JPATH_MAIN, '', $path);
}