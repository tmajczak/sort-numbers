## INSTALLATION
1. Clone repository: `git clone https://github.com/tmajczak/sort-numbers.git`
2. Go to project dir: `cd sort-numbers`
3. Run Composer: `composer install`

## USAGE

#### Generate File
Run `php bin/generate-file` from main project dir.

Script will prompt for:
- maximum number allowed (integer greater than 0)
- minimum number allowed (integer greater than 0)
- number of decimals places (integer greater or equal 0, if 0 than integers will be generated)
- file size (should be in format like '5kb', '5MB', etc.)
- file path (absolute path with filename)

#### Sort file
Run `php bin/sort-file` from main project dir.

Script will prompt for:
- input file path (absolute path with filename)
- output file path (absolute path with filename)
