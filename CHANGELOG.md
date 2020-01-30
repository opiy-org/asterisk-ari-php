# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.4] - 2020-01-30

### Fixed
* Default error handler in AbstractWebSocketClient is now non-static

### Removed
* composer.lock from the project, because it must not bind to a specific version

## [1.0.3] - 2020-01-27

### Fixed
* [DialplanCEP](https://wiki.asterisk.org/wiki/display/AST/Asterisk+16+REST+Data+Models#Asterisk16RESTDataModels-DialplanCEP)
properties 'app_data' and 'app_name' are not required although the official
documentation said so
* Unspecific variables names and log information
error handlers must use 'context' as a first parameter in order to
make it reusable throughout the ARI client components (Breaking change!)

## [1.0.2] - 2020-01-24

### Fixed
* Grammar and misleading language in README.md
* Method names and comments in AbstractWebSocketClient and Client\WebSocket\Settings
* Public method names (in classes implementing the StasisApplicationInterface) with
correct ARI event handler prefix but invalid suffix now lead to an
InvalidArgumentException on web socket client connection
* Missing types for method arguments in `Applications::filter()` method
* Missing nullable types for method arguments throughout the project

## [1.0.1] - 2020-01-24

### Fixed
* Grammar and misleading language in README.md

### Added
* Contributors to README

## [1.0.0] - 2020-01-23
**Initial Release**
