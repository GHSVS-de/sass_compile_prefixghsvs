#!/usr/bin/php
<?php
require_once('defines.php');

$output = [];
$realPaths = false;

$options = getopt("r::");

if (isset($options['r']))
{
	$realPaths = true;
	$output[] = '### Output of `npm run ghs-help-real-paths` (path variables replaced with values from package.json)';
}
else
{
	$output[] = '### Output of `npm run ghs-help` (path variables not translated)';
}

$scriptsHelp = array(
	'What?' => 'Compiles, minifies, autoprefixes *.scss files to CSS and creates source-maps.',
	'Tested?' => 'Only with WSL (Windows Subsystem for Linux / DEBIAN) + PHP 7.3 + Node + NPM on local machine.',
	'Be aware' => 'These npm scripts are very ungraceful. Always have a look on your console messages if the previous job is finished before you fire a new command or save your scss when `nodemon` watchers are active or this or that. Or optmize yourself the scripts for your needs ;-)' . NL .
	'- The very first usage of `npm run` after opening the WSL console is always slow.', 
	'How to start a script' =>  '`npm run [SCRIPTKEY]`',
	'The DIR block (inside package.json)' =>
	'scss: Variable `$npm_package_DIR_scss` (absolute path). The source *.scss-directory.' . NL
	. '- target: Variable `$npm_package_DIR_target` (absolute path). Dir (normally a template folder) where all the compiled, prefixed, minified CSS files (inside subfolders) are copied to after all these steps are finished.' . NL
	. '- work: Variable `$npm_package_DIR_work` (relative path). Temporary local work directory inside same folder where `package.json` is located.' . NL
	. '- css: Variable `$npm_package_DIR_css` (relative path). Dir where all compiled, prefixed, minified CSS files are copied to.' . NL
	. '- raw:  Variable `$npm_package_DIR_raw` (relative path). Dir where all compiled, minified **BUT NOT PREFIXED** CSS files are copied to.' . NL
	. '- dist:  Variable `$npm_package_DIR_dist` (relative path). Dir where all compiled, prefixed, minified CSS files are copied to. Source folder for transfer to target and FTP transfer.' .NL
	. NL . '##### package.json. Current `DIR` config.' . NL . ' ```' . print_r($packageJson['DIR'], true) . '```'
);

$ftpHelp = array(
	'FTP configuration (inside ftp-credentials.json)' =>
	'**No guarantees concerning security!**' . NL
	. '- See also file `ftp-credentials-example.json`.' . NL
	. '- place a comment here: Place one if you want to. No usage.' . NL
	. '- connectionName: "Whatever" string. An information displayed in console when the FTP script starts.' . NL
	. '- server: The FTP Server/Host.' . NL
	. '- user: The FTP username.' . NL
	. '- password: The password of user.' . NL
	. '- remoteDir: The ftp directory. Starts and ends with a slash (`/`)! If it\'s the FTP ROOT just a single slash.' . NL
	. '- dir: The local directory No slash (`/`) before and after! All **contents** of this dir will be transfered to `remoteDir`.' . NL
	. '- ssl: **I have never tested with value `false`!**.' . NL
	. '- passive: At least `true` on Windows is recommended because of firewall blockades.'
);

$packageJson['scriptsHelp'] = array_merge($scriptsHelp, $packageJson['scriptsHelp'], $ftpHelp);

foreach ($packageJson['scriptsHelp'] as $scriptName => $scriptHelp)
{
	$pre = '';

	if (strpos($scriptName, 'ghs-') === 0)
	{
		$pre = 'npm run ';
		
		if ($realPaths)
		{
			$scriptHelp = str_replace($replaceMe, $replaceWith, $scriptHelp);
		}
		
		$output[] = "#### $pre$scriptName" . NL . '- ' . $scriptHelp . NL;
	}
	else
	{
		$output[] = "#### $pre$scriptName" . NL . '- ' . $scriptHelp . NL;
	}
}


$output[] = '##### package.json. `scripts` block.' . NL . ' ```' . print_r($packageJson['scripts'], true) . '```' . NL;

echo implode(NL, $output) . NL;