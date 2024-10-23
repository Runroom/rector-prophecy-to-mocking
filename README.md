# Rector Rules for Prophecy to Mocking migration

## Install

```bash
composer require runroom/rector-prophecy-to-mocking --dev
```

## Usage

1. Register set

```php
$rectorConfig->sets([
    MigratePhpUnitSetList::PHPUNIT,
]);
```

2. Run on specific spec directory

```bash
vendor/bin/rector process tests
```

<br>

This package handles a lot of changes. Explore these resources to handle edge-cases manually:

* https://johannespichler.com/writing-custom-phpspec-matchers/
