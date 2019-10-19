# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.6.0] - 2019-10-20

### Added
- Added an official changelog.

### Changed
- Fixed the naming of certain files (`config`, and files within `routes`).
- Updated the generation of `API_BASE_PATH` constant, making it more versatile on different systems.
- Moved file and dependency inclusion to `autoload.php`, which is required by `index.php`.
- Updated the visual style of Swagger documentation, and included a new custom favicon .
- Updated double quotation marks to single quotes in most files, in order to keep consistency.
- Renamed `tests/src` to `tests/unit`.
- Updated the sample response model to return an array, rather than a string, and added `example` properties to Swagger models.
- Updated Composer dependencies.
- Updated the `README` file to reflect new changes.

### Removed
- Unused and deprecated `Logger.php` file.

## [<= 0.5.6]

- Initial versions of the project, which did not contain a changelog. Can be considered as the initial release.
