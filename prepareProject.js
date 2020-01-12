/*
Reads parameters from packege.json inside project folders.
Replaces these variables in main packege.json.

Call via
node prepareProject.js <PROJECTNAME>

PROJECTNAME: Directory inside current cwd.

See https://stackoverflow.com/questions/52174249/set-node-environment-variable-to-dynamic-value-in-npm-script
*/

const Fs = require('fs');
// const FsExtra = require('fs-extra');
const dateFormat = require('dateformat');
const RootPath = process.cwd();

console.log(`Start prepareProject.js in ${RootPath}.`);

const projectName = process.argv[2];

if (!projectName)
{
	console.log(`Error: Not a project: ${projectName}`);
	process.exit(1);
}

console.log(`OK, projectName: ${projectName}`);

const projectPath = `${RootPath}/${projectName}`;

if (!(Fs.existsSync(projectPath) && Fs.lstatSync(projectPath).isDirectory()))
{
	console.log(`Error: Not an existing project path: ${projectPath}`);
	process.exit(1);
}

console.log(`OK, projectPath: ${projectPath}`);

const file = 'package.json';
const thisFile = `${projectPath}/${file}`;
const thatFile = `${RootPath}/${file}`;

[thisFile, thatFile].forEach((file) => {
	if (!(Fs.existsSync(file) && Fs.lstatSync(file).isFile()))
	{
		console.log(`Error: Not a file: ${file}`);
		process.exit(1);
	}
	else
	{
		console.log(`OK: File exists: ${file}`);
	}
});

const thisJson = JSON.parse(Fs.readFileSync(thisFile).toString());
console.log('Found parameters for current project:');
console.log(thisJson);

[thisJson.scss, thisJson.target].forEach((folder) => {
	if (!folder || !(Fs.existsSync(folder) && Fs.lstatSync(folder).isDirectory()))
	{
		console.log(`Error: Not a folder or missing: ${folder}`);
		process.exit(1);
	}
	else
	{
		console.log(`OK: Folder exists: ${folder}`);
	}
});

const thatJson = JSON.parse(Fs.readFileSync(thatFile).toString());
console.log(`OK, read main ${file}`);
thatJson.DIR.scss = thisJson.scss;
thatJson.DIR.target = thisJson.target;
thatJson.DIR.project = projectPath;
thatJson.DIR.projectName = projectName;
thatJson.versionTxt = dateFormat(new Date(), "isoDateTime");

console.log(`New parameters to write:`);
console.log(thatJson.DIR);

const readline = require('readline').createInterface({
  input: process.stdin,
  output: process.stdout
})

readline.question('Continue and override ' + file + '? [y|n]: ', yesNo => {
	console.log(`You entered: ${yesNo}`);
	
	if (yesNo !== 'y')
	{
		console.log(`Exiting programm!`);
		readline.close();
		process.exit(1);
	}
	else
	{
		Fs.writeFileSync(thatFile, JSON.stringify(thatJson, null, 2));
		console.log(`Ready. ${thatFile} written`);
		readline.close();
		process.exit(0);
	}
});

