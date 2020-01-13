# sass_compile_prefixghsvs

`cd /mnt/z/git-kram/sass_compile_prefixghsvs`

Once: `npm install`

`node prepareProject.js <PROJECTFFOLDER (relative)>`

`npm run g-all-upload`

### Output of `npm run g-help` (path variables not translated)
#### What?
- A half-assed, scrawly package for domestic use that compiles, minifies, autoprefixes *.scss files to CSS and creates source-maps.
- Can also upload the files via FTP.
- Multiple projects/websites can be configured in 1 repository. But only 1 at the same time can be processed!
- No luxury. You need to know what you're doing.

#### Tested?
- Only with WSL (Windows Subsystem for Linux / DEBIAN) + PHP 7.3 + Node + NPM on local machine.

#### Be aware
- These npm scripts are very ungraceful. Always have a look on your console messages if the previous job is finished before you fire a new command.
- The very first usage of `npm run [SCRIPTKEY]` in a console session is always slow. At least with WSL.
- Be not so stupid to use it in a productive environment without tests.

#### How to configure
- Create a project folder like `yourOwnProject/` inside main dir of repository.
- Create and configure a file `yourOwnProject/package.json`. See example file `myProject/package.json`.
- Optional: Create and configure a file `yourOwnProject/ftp-credentials.json` inside project folder. See example file `myProject/ftp-credentials.json`.- Run `node prepareProject.js yourOwnProject` and confirm to override the **main** `package.json`. Afterwards it's changed and configured for the project `yourOwnProject`. These keys are adapted:
```
	"versionTxt" (just a datetime stamp)
	"DIR" > "scss"
	"DIR" > "target"
	"DIR" > "project"
	"DIR" > "projectName"
	```

#### How to start a script
- `npm run [SCRIPTKEY]`

#### The `DIR` block (inside **main** `package.json`):
- Normally you don't have to change it yourself if you use `prepareProject.js [PROCECTFOLDER]` before first `npm` usage.
- scss: Variable `$npm_package_DIR_scss` (absolute path). The source *.scss-directory.
- target: Variable `$npm_package_DIR_target` (absolute path). Dir (normally your template folder) where the whole **content** of folder `$npm_package_DIR_dist` will be transfered to.
- project: Variable `$npm_package_DIR_project` (absolute path). Local dir of the project.
- work: Variable `$npm_package_DIR_work` (relative path). Temporary local work directory inside active/relevant project folder `$npm_package_DIR_project`.
- css: Variable `$npm_package_DIR_css` (relative path). In the beginning a work dir inside folder `$npm_package_DIR_work`. At the end a folder inside `$npm_package_DIR_dist` where all compiled, prefixed, minified CSS/MAP files are located.
- raw: Variable `$npm_package_DIR_raw` (relative path). In the beginning a work dir inside folder `$npm_package_DIR_work`. At the end a folder inside `$npm_package_DIR_dist` where all compiled, minified **BUT NOT PREFIXED** CSS files are located.
- dist:  Variable `$npm_package_DIR_dist` (relative path). Final source folder for transfer to `$npm_package_DIR_target` and for the FTP transfer. The whole **content** of this folder will be transfered. Not the folder itself.