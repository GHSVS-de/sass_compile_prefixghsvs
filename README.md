# sass_compile_prefixghsvs

### You are yourself responsible to keep the dependencies in `package.json` secure and up-to-date! I refresh this repository seldomly. See `npm run g-npm-update-check` and `npm run g-ncu-override-json` below.

`cd /mnt/z/git-kram/sass_compile_prefixghsvs`

Once: `npm install`

`node prepareProject.js <PROJECTFFOLDER (relative)>`

`npm run g-all-local` (no transfer to target or via FTP)

or

`npm run g-all` (no transfer via FTP)

or

`npm run g-all-upload`

### Output of `npm run g-help` (path variables not translated)
#### What?
- A half-assed, scrawly package for domestic use that compiles, minifies, autoprefixes *.scss files to CSS and creates source-maps.
- Can also upload the files via FTP.
- Multiple projects/websites can be configured in 1 repository. But only 1 at the same time can be processed!
- No luxury. You need to know what you're doing.
- See example for config (`*.json`) and output example (folder `ghs/`) in directory `myProject/`.

#### Tested?
- Only with WSL (Windows Subsystem for Linux / DEBIAN) + PHP 7.3 + Node + NPM on local machine.

#### Be aware
- These npm scripts are very ungraceful. Always have a look on your console messages if the previous job is finished before you fire a new command.
- The very first usage of `npm run [SCRIPTKEY]` in a console session is always slow. At least with WSL.
- Be not so stupid to use it in a productive environment without tests.

#### How to configure
- Create a project folder like `yourOwnProject/` inside main dir of repository.
- Create and configure a file `yourOwnProject/package.json`. See example file `myProject/package.json`.
- Optional: Create and configure a file `yourOwnProject/ftp-credentials.json`. See example file `myProject/ftp-credentials.json`.
- Run `node prepareProject.js yourOwnProject` and confirm to override the **main** `package.json`. Afterwards it's changed and configured for the project `yourOwnProject`. These keys are adapted:

```
"versionTxt" (just a datetime stamp)
"DIR" > "scss"
"DIR" > "target"
"DIR" > "project"
"DIR" > "projectName"
```

#### The `DIR` block (inside **main** `package.json`):
- Normally you don't have to change it yourself if you use `node prepareProject.js [PROCECTFOLDER]` before first `npm` usage.
- `scss`: Variable `$npm_package_DIR_scss` (absolute path). The source *.scss-directory.
- `target`: Variable `$npm_package_DIR_target` (absolute path). Dir (normally your template folder) where the whole **content** of folder `$npm_package_DIR_dist` will be transfered to.
- `project`: Variable `$npm_package_DIR_project` (absolute path). Local dir of the project.
- `work`: Variable `$npm_package_DIR_work` (relative path). Temporary local work directory inside active/relevant project folder `$npm_package_DIR_project`.
- `css`: Variable `$npm_package_DIR_css` (relative path). In the beginning a work dir inside folder `$npm_package_DIR_work`. At the end a folder inside `$npm_package_DIR_dist` where all compiled, prefixed, minified CSS/MAP files are located.
- `raw`: Variable `$npm_package_DIR_raw` (relative path). In the beginning a work dir inside folder `$npm_package_DIR_work`. At the end a folder inside `$npm_package_DIR_dist` where all compiled, minified **BUT NOT PREFIXED** CSS files are located.
- `dist`:  Variable `$npm_package_DIR_dist` (relative path). Final source folder for transfer to `$npm_package_DIR_target` and for the FTP transfer. The whole **content** of this folder will be transfered. Not the folder itself.

#### FTP configuration (inside `$npm_package_DIR_project/ftp-credentials.json`)
- **No guarantees concerning security!**
- See example file `myProject/ftp-credentials.json`.
- `place a comment here`: Place one if you want to. No usage.
- `connectionName`: "Whatever" string. An information displayed in console when the FTP script starts.
- `server`: The FTP Server/Host.
- `user`: The FTP username.
- `password`: The password of user.
- `remoteDir`: The ftp directory. Starts and ends with a slash (`/`)! If it's the ROOT of the current FTP connection just a single slash.
- `ssl`: **I have never tested with value `false`!**.
- `passive`: At least `true` on Windows WSL is recommended because of firewall blockades.

#### npm run g-help
- Displays an overview of (nearly all) possible `npm run [SCRIPTKEY]` commands.

#### npm run g-help-real-paths
- Like `g-help` but replaces path variables with values like configured in `DIR` block in `package.json`. Perhaps good to check the current path configuration.

#### npm run g-all-local
- Runs a complete job but **only inside local work dir** `$npm_package_DIR_project/$npm_package_DIR_work`. No transfer to `$npm_package_DIR_target`. No FTP upload. First deletes local work directory `$npm_package_DIR_work` of current project.
(`npm-run-all g-rm g-mkdirs g-compile g-copyRaw g-prefix g-minify g-version g-copyDist`)

#### npm run g-all
- Runs a complete job inclusive final transfer from `$npm_package_DIR_dist` to `$npm_package_DIR_target`. **No FTP upload**. First deletes local work directory `$npm_package_DIR_work` of current project.
(`npm-run-all g-all-local g-copyTarget`)

#### npm run g-all-upload
- Like `g-all` **plus FTP upload**. NEEDS A CORRECTLY CONFIGURED `$npm_package_DIR_project/ftp-credentials.json`! Check twice and test before using it. First deletes local work directory `$npm_package_DIR_work` of current project.
(`npm-run-all g-all g-upload`)

#### npm run g-css-local
- Like `g-all-local` but without unprefixed files in folder `$npm_package_DIR_raw`. Creates only vendor prefixed files in dir $npm_package_DIR_css.
(`npm-run-all g-rm g-mk-css g-compile g-prefix g-minify-css g-version-css g-mk-dist g-copyDist-css`)

#### npm run g-css
- Like `g-all` but without unprefixed files in folder `$npm_package_DIR_raw`. Only vendor prefixed files in dir `$npm_package_DIR_css`.
(`npm-run-all g-css-local g-copyTarget`)

#### npm run g-css-upload
- Like `g-all-upload` but without unprefixed files in folder $npm_package_DIR_raw. Only vendor prefixed files in dir `$npm_package_DIR_css`.
(`npm-run-all g-css g-upload`)

#### npm run g-rm
- Deletes **local** work directory `$npm_package_DIR_work` of current project.

#### npm run g-mkdirs
- Runs all jobs that match `g-mk-*`. Creates basic work folder structure of current project in `$npm_package_DIR_project`.
(`npm-run-all g-mk-*`)

#### npm run g-mk-css
- Creates folder `$npm_package_DIR_work/$npm_package_DIR_css` (vendor prefixed files).

#### npm run g-mk-raw
- Creates folder `$npm_package_DIR_work/$npm_package_DIR_raw` (unprefixed files).

#### npm run g-mk-dist
- Creates folder `$npm_package_DIR_work/$npm_package_DIR_dist`. The content of this folder is the source for transfers to `$npm_package_DIR_target` and/or for FTP upload.

#### npm run g-compile
- Compiles `*.scss` files from `$npm_package_DIR_scss` to `*.css` and `*.css.map` files in local work dir `$npm_package_DIR_work/$npm_package_DIR_css` of current project. Not vendor prefixed yet.

#### npm run g-copyRaw
- Copies unprefixed `*.css` and `*.css.map` to local dir `$npm_package_DIR_work/$npm_package_DIR_raw` inside current project folder.

#### npm run g-prefix
- Runs `Autoprefixer` (See file `.browserslistrc`). 
- Source: All `*.css` files in **local** work dir `$npm_package_DIR_work/$npm_package_DIR_css` inside current project folder. 
- Target: Replaces `*.css` files in same dir.

#### npm run g-minify
- Runs all jobs that match `g-minify-*`. Minifies `*.css` files and creates additional `*.min.css` and `*.css.min.map` files.
(`npm-run-all g-minify-*`)

#### npm run g-minify-css
- See `g-minify`. Folder `$npm_package_DIR_work/$npm_package_DIR_css`.

#### npm run g-minify-raw
- See `g-minify`. Folder `$npm_package_DIR_work/$npm_package_DIR_raw`.

#### npm run g-version
- Runs all jobs that match `g-version-*`. Creates datetime stamp files `version.txt`. Source is `versionTxt` in `package.json`.
(`npm-run-all g-version-*`)

#### npm run g-version-css
- See `g-version`. Folder `$npm_package_DIR_work/$npm_package_DIR_css/__Prefixed-CSS`.

#### npm run g-version-raw
- See `g-version`. Folder `$npm_package_DIR_work/$npm_package_DIR_raw/__NOT-Prefixed-CSS`.

#### npm run g-copyDist
- Runs all jobs that match `g-copyDist-*`. Copies folders with results of finished jobs to local folder `$npm_package_DIR_work/$npm_package_DIR_dist`.
(`npm-run-all g-copyDist-*`)

#### npm run g-copyDist-css
- See `g-copyDist`. Folder `$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css` to `$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_dist`.

#### npm run g-copyDist-raw
- See `g-copyDist`. Folder `$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_raw` to `$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_dist`.

#### npm run g-copyTarget
- Copies **content** of `$npm_package_DIR_work/$npm_package_DIR_dist` to target folder `$npm_package_DIR_target`. More precisely: copies folders `$npm_package_DIR_css` and `$npm_package_DIR_raw`. No harm if they already exist. Existing folders and files stay alive. Only relevant files will be replaced.

#### npm run g-upload
- Runs the upload via FTP of all files/dirs inside dir `$npm_package_DIR_work/$npm_package_DIR_dist` inside current project folder. NEEDS A CORRECTLY CONFIGURED `$npm_package_DIR_project/ftp-credentials.json`! Check twice and test before using it. No harm if folders/files already exist. Existing folders and files stay alive. Only relevant files will be replaced.

#### npm run g-npm-update-check
- Check for updates of packages in `package.json`. Prints a list, not more.

#### npm run g-ncu-override-json
- Check for updates for packages in `package.json`. AND override `package.json` file (newest stable versions). Don't forget to run `npm install` afterwards!

#### npm run g-browsers
- Output of complete browser list that are used for `Autoprefixer`. See file `.browserslistrc`.

##### package.json. `scripts` block.
 ```Array
(
    [g-help] => bin/help.php
    [g-help-real-paths] => bin/help.php -r
    [g-npm-update-check] => ncu
    [g-ncu-override-json] => ncu -u
    [g-browsers] => npx browserslist
    [g-all-local] => npm-run-all g-rm g-mkdirs g-compile g-copyRaw g-prefix g-minify g-version g-copyDist
    [g-all] => npm-run-all g-all-local g-copyTarget
    [g-all-upload] => npm-run-all g-all g-upload
    [g-css-local] => npm-run-all g-rm g-mk-css g-compile g-prefix g-minify-css g-version-css g-mk-dist g-copyDist-css
    [g-css] => npm-run-all g-css-local g-copyTarget
    [g-css-upload] => npm-run-all g-css g-upload
    [g-rm] => shx rm -rf $npm_package_DIR_project/$npm_package_DIR_work
    [g-mkdirs] => npm-run-all g-mk-*
    [g-mk-css] => shx mkdir -p $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css
    [g-mk-raw] => shx mkdir -p $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_raw
    [g-mk-dist] => shx mkdir -p $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_dist
    [g-compile] => node-sass --output-style expanded --source-map true --source-map-contents true --precision 6 $npm_package_DIR_scss/ -o $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css
    [g-copyRaw] => shx cp $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css/*.{css,map} $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_raw
    [g-prefix] => postcss --config build/postcss.config.js --replace "$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css/*.css" "!$npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css/*.min.css"
    [g-minify] => npm-run-all g-minify-*
    [g-minify-css] => bin/minify.php $npm_package_DIR_css
    [g-minify-raw] => bin/minify.php $npm_package_DIR_raw
    [g-version] => npm-run-all g-version-*
    [g-version-css] => bin/writeVersion.php $npm_package_DIR_css/__Prefixed-CSS
    [g-version-raw] => bin/writeVersion.php $npm_package_DIR_raw/__NOT-Prefixed-CSS
    [g-copyDist] => npm-run-all g-copyDist-*
    [g-copyDist-css] => shx cp -rf $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_css $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_dist
    [g-copyDist-raw] => shx cp -rf $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_raw $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_dist
    [g-copyTarget] => shx cp -rf $npm_package_DIR_project/$npm_package_DIR_work/$npm_package_DIR_dist/* $npm_package_DIR_target
    [g-upload] => bin/FTPRecursiveFolderUpload.php
)
```