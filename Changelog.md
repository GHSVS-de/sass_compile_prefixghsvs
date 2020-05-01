# V 2020.05.01
- New file `.nvmrc`: Adapt it if you use `nvm` (Node Version Manager) to switch/install node versions and need another version.  Hint: `Node 14` needs some adaptions in `Debian WSL` via console.

## Updated some dependencies.
- Added `shelljs` explicitely because current `shx` has lots of warnings with `node 14` otherwise.
- Removed `cross-env` because don't need it in Debian WSL environment. Can use `shx` directly.
- Removed `nodemon` and associated `npm` scripts because I don't use it yet and had no time for tests.
- Removed `find-unused-sass-variables`. Never worked for me like needed.

## npm Scripts
- Added several `npm` scripts for possibility to create only vendor prefixed CSS. Ignores `css-raw` routines.

## Others
- Changed `minify.php`, `writeVersion.php`. Need a relative directory parameter/argument now.
- Completed and corrected `scriptsHelp` block in `packege.json` for `npm run g-help` output.
- Moved `function doMinify()` into `defines.php`. At the end of the day nonsense but now to lazy to revert it.



