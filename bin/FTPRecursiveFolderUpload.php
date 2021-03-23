#!/usr/bin/php
<?php

// https://gist.github.com/Tchekda/40736c320d3733d9e4522a57bb24c9f7

error_reporting(E_ERROR | E_PARSE);

require_once('defines.php');


if (empty($ftpJson['ftp']))
{
	echo 'Info: No FTP-Credentials in ' . mkShortPath(__FILE__) . '. No FTP upload possible.' . NL . NL;
	return;
}

echo '#################################' . NL
. 'Starting FTP script. ' . $ftpJson['ftp']['connectionName'] . NL
. '#################################' . NL;

$ftp_server = $ftpJson['ftp']['server'];
$ftp_user_name = $ftpJson['ftp']['user'];
$ftp_password = $ftpJson['ftp']['password'];
// As /home/user/ftp/ WITH the last slash!
$remoteDir = $ftpJson['ftp']['remoteDir'];
// Local folder. Absolute path.
$dir = "$npm_package_config_project/$npm_package_config_work/$npm_package_config_dist";

$dir = rtrim($dir, '/ \\');

$ftp_ssl = (boolean) $ftpJson['ftp']['ssl'];
$ftp_passive = (boolean) $ftpJson['ftp']['passive'];

//Create FTP directory if not exists
function make_directory($ftp_stream, $dir)
{
	// if directory already exists or can be immediately created return true
	if (ftp_chdir($ftp_stream, $dir) || @ftp_mkdir($ftp_stream, $dir))
	{
		return true;
	}
	// otherwise recursively try to make the directory
	if (!make_directory($ftp_stream, dirname($dir)))
	{
		return false;
	}
	// final step to create the directory
	return ftp_mkdir($ftp_stream, $dir);
}

if ($ftp_ssl === true)
{
	//echo ' 4654sd48sa7d98sD81s8d71dsa <pre>' . print_r(getenv('port'), true) . '</pre>';exit;
	$conn_id = ftp_ssl_connect($ftp_server);
	echo 'Is a ftp_ssl connection: TRUE.' . NL;
}
else
{
	$conn_id = ftp_connect(
		$ftp_server,
		intval((getenv('port') ? getenv('port') : 21))
	);
	echo 'Is a ftp_ssl connection: FALSE.' . NL;
}

$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_password);

if ((!$conn_id) || (!$login_result))
{
	echo NL . 'FTP Connection failed!' . NL;
	@ftp_close($conn_id);
	return;
}
else
{
	echo 'Connected to FTP-Server.' . NL;
}

if ($ftp_passive === true)
{
	ftp_pasv($conn_id, true);
}

$recursiveFileResearch = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($dir)
);

$files = array();

foreach ($recursiveFileResearch as $file)
{
	if ($file->isDir())
	{
		continue;
	}

	// Filename without backslashes (Windows..) and without the root directory
	$files[] = str_replace($dir . '/', '', str_replace('\\', '/', $file->getPathname()));
}

if ($files)
{
	foreach ($files as $file)
	{
		make_directory($conn_id, $remoteDir . dirname($file));
		ftp_chdir($conn_id, $remoteDir . dirname($file));
		echo 'Transfer ' . mkShortPath($dir) . '/' . $file . ' -> ' . ftp_pwd($conn_id) . ' ' . basename($file) . NL;

		//Upload the file to current FTP directory
		$success = ftp_put($conn_id, basename($file), $dir . "/"  . $file, FTP_BINARY);

		if ($success === false)
		{
			echo 'Error while ftp_put. File: ' . mkShortPath($dir) . "/"  . $file . NL .
				'I stop the whole job and close connection! Please wait.' . NL;
			@ftp_close($conn_id);
			return;
		}

		// echo 'Success!' . NL;
	}
}
else
{
	echo 'No files/folders found in local ' . mkShortPath($dir) . '.' . NL;
}

ftp_close($conn_id);

echo '#################################' . NL
. 'FTP script finished. ' . $ftpJson['ftp']['connectionName'] . NL
. '#################################' . NL;

return;
