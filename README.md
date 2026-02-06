# Name Sorter

A CLI tool that sorts names by last name, then by given names. Built with PHP and Laravel components.

## Requirements

- PHP 8.1 or higher
- Composer

## Installation

1. Clone the repository:

```bash
git clone https://github.com/jesephan/name-sorter.git
cd name-sorter
```

2. Install dependencies:

```bash
composer install
```

3. Make the script executable (optional):

```bash
chmod +x name-sorter
```

## Usage

1. Add your input file to the root directory of the project:

```
name-sorter/
├── unsorted-names-list.txt   # Your input file goes here
├── name-sorter
├── composer.json
└── ...
```

2. Run the sorter:

```bash
php name-sorter ./unsorted-names-list.txt
```

### Input File Format

- Place the file in the project root directory
- One name per line
- Each name must have at least 1 given name and 1 last name
- Names can have up to 3 given names
- File must be a `.txt` file

Example `unsorted-names-list.txt`:

```
Janet Parsons
Vaughn Lewis
Adonis Julius Archer
Shelby Nathan Yoder
Marin Alvarez
```

### Output

The sorted names will be:

1. Printed to the console
2. Saved to `sorted-names-list.txt` in the project root directory

Example output:

```
Marin Alvarez
Adonis Julius Archer
Janet Parsons
Vaughn Lewis
Shelby Nathan Yoder
```

## Testing

Run all tests:

```bash
composer test
```

Or using PHPUnit directly:

```bash
./vendor/bin/phpunit
```

## Code Style

Check code style:

```bash
composer lint-check
```

Fix code style:

```bash
composer lint
```

## Project Structure

```
name-sorter/
├── name-sorter                  # CLI entry point
├── composer.json
├── phpunit.xml
├── pint.json
├── src/
│   ├── NameSorter.php           # Sorting logic
│   ├── FileValidator.php        # File validation
│   ├── FileContentExtractor.php # File reading
│   ├── Interfaces/
│   │   ├── FileValidationInterface.php
│   │   ├── FileContentExtractionInterface.php
│   │   └── OutputInterface.php
│   └── Output/
│       ├── FileOutput.php       # Write to file
│       └── PrintToConsole.php   # Print to console
└── tests/
    ├── NameSorterTest.php
    ├── FileValidatorTest.php
    ├── FileContentExtractorTest.php
    └── Output/
        ├── FileOutputTest.php
        └── PrintToConsoleTest.php
```

## Dependencies

### Production

- `illuminate/support` - Laravel Collection and String helpers
- `illuminate/filesystem` - Laravel File helper

### Development

- `phpunit/phpunit` - Testing framework
- `laravel/pint` - Code style fixer

## Sorting Rules

Names are sorted by:

1. **Last name** (alphabetically, case-insensitive)
2. **Given names** (alphabetically, case-insensitive) when last names match

Example:

```
Adam Smith
John Smith
Zoe Smith
```

All have the same last name "Smith", so they are sorted by given name.
