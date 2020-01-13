#!/usr/bin/php
<?php
require_once('defines.php');

$output = [];
$realPaths = false;

$options = getopt("r::");

if (isset($options['r']))
{
	$realPaths = true;
	$output[] = '### Output of `npm run g-help-real-paths` (path variables replaced with values from package.json)';
}
else
{
	$output[] = '### Output of `npm run g-help` (path variables not translated)';
}

$scriptsHelp = array(
	'What?' =>
	'A half-assed, scrawly package for domestic use that compiles, minifies, autoprefixes *.scss files to CSS and creates source-maps.' . NL
	. '- Can also upload the files via FTP.' . NL
	. '- Multiple projects/websites can be configured in 1 repository. But only 1 at the same time can be processed!' . NL
	. '- No luxury. You need to know what you\'re doing.',

	'Tested?' => 'Only with WSL (Windows Subsystem for Linux / DEBIAN) + PHP 7.3 + Node + NPM on local machine.',

	'Be aware' => 'These npm scripts are very ungraceful. Always have a look on your console messages if the previous job is finished before you fire a new command.' . NL
	. '- The very first usage of `npm run [SCRIPTKEY]` in a console session is always slow. At least with WSL.' . NL
	. '- Be not so stupid to use it in a productive environment without tests.',

	'How to configure' => 'Create a project folder like `yourOwnProject/` inside main dir of repository.' . NL
	. '- Create and configure a file `yourOwnProject/package.json`. See example file `myProject/package.json`.' . NL
	. '- Optional: Create and configure a file `yourOwnProject/ftp-credentials.json`. See example file `myProject/ftp-credentials.json`.' . NL
	. '- Run `node prepareProject.js yourOwnProject` and confirm to override the **main** `package.json`. Afterwards it\'s changed and configured for the project `yourOwnProject`. These keys are adapted:' . NL
	. '
```
"versionTxt" (just a datetime stamp)
"DIR" > "scss"
"DIR" > "target"
"DIR" > "project"
"DIR" > "projectName"
```', 
	'The `DIR` block (inside **main** `package.json`):' =>
	'Normally you don\'t have to change it yourself if you use `node prepareProject.js [PROCECTFOLDER]` before first `npm` usage.' . NL
	. '- `scss`: Variable `$npm_package_DIR_scss` (absolute path). The source *.scss-directory.' . NL
	. '- `target`: Variable `$npm_package_DIR_target` (absolute path). Dir (normally your template folder) where the whole **content** of folder `$npm_package_DIR_dist` will be transfered to.' . NL
	. '- `project`: Variable `$npm_package_DIR_project` (absolute path). Local dir of the project.' . NL
	. '- `work`: Variable `$npm_package_DIR_work` (relative path). Temporary local work directory inside active/relevant project folder `$npm_package_DIR_project`.' . NL
	. '- `css`: Variable `$npm_package_DIR_css` (relative path). In the beginning a work dir inside folder `$npm_package_DIR_work`. At the end a folder inside `$npm_package_DIR_dist` where all compiled, prefixed, minified CSS/MAP files are located.' . NL
	. '- `raw`: Variable `$npm_package_DIR_raw` (relative path). In the beginning a work dir inside folder `$npm_package_DIR_work`. At the end a folder inside `$npm_package_DIR_dist` where all compiled, minified **BUT NOT PREFIXED** CSS files are located.' . NL
	. '- `dist`:  Variable `$npm_package_DIR_dist` (relative path). Final source folder for transfer to `$npm_package_DIR_target` and for the FTP transfer. The whole **content** of this folder will be transfered. Not the folder itself.',);

$ftpHelp = array(
	'FTP configuration (inside `$npm_package_DIR_project/ftp-credentials.json`)' =>
	'**No guarantees concerning security!**' . NL
	. '- See example file `myProject/ftp-credentials.json`.' . NL
	. '- `place a comment here`: Place one if you want to. No usage.' . NL
	. '- `connectionName`: "Whatever" string. An information displayed in console when the FTP script starts.' . NL
	. '- `server`: The FTP Server/Host.' . NL
	. '- `user`: The FTP username.' . NL
	. '- `password`: The password of user.' . NL
	. '- `remoteDir`: The ftp directory. Starts and ends with a slash (`/`)! If it\'s the ROOT of the current FTP connection just a single slash.' . NL
	. '- `ssl`: **I have never tested with value `false`!**.' . NL
	. '- `passive`: At least `true` on Windows WSL is recommended because of firewall blockades.'
);

$packageJson['scriptsHelp'] = array_merge($scriptsHelp, $ftpHelp, $packageJson['scriptsHelp']);

foreach ($packageJson['scriptsHelp'] as $scriptName => $scriptHelp)
{
	$pre = '';

	if (strpos($scriptName, 'g-') === 0)
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