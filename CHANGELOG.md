# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
