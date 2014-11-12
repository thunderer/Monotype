# Monotype

[![Build Status](https://travis-ci.org/thunderer/Monotype.png?branch=master)](https://travis-ci.org/thunderer/Monotype)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1cd1abab-c172-4da1-a465-c26794f42eee/mini.png)](https://insight.sensiolabs.com/projects/1cd1abab-c172-4da1-a465-c26794f42eee)
[![License](https://poser.pugx.org/thunderer/monotype/license.svg)](https://packagist.org/packages/thunderer/monotype)
[![Latest Stable Version](https://poser.pugx.org/thunderer/monotype/v/stable.svg)](https://packagist.org/packages/thunderer/monotype)
[![Dependency Status](https://www.versioneye.com/user/projects/5463ca0ea345411321000098/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5463ca0ea345411321000098)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thunderer/Monotype/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thunderer/Monotype/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/thunderer/Monotype/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thunderer/Monotype/?branch=master)
[![Code Climate](https://codeclimate.com/github/thunderer/Monotype/badges/gpa.svg)](https://codeclimate.com/github/thunderer/Monotype)

Monotype is a small utility library to check if given variable matches specific type requirements. PHP is known for its issues with [variable type comparison mechanics](http://php.net/manual/en/types.comparisons.php) so why don't reduce the pain of developers with some useful code?

## Requirements

No required dependencies, only PHP >=5.4

> PHP 5.3 will work too most of the time. It does not support using `$this` in closures (which are used in array checking methods), so since it has [already reached its EOL](http://php.net/supported-versions.php) I'm not fixing these errors. It is possible, but you need to make manual fixes yourself where applicable.

## Installation

This library is registered on Packagist, so you can just execute

```
composer require thunderer/monotype
```

in your terminal or manually update your `composer.json` with

```
(...)
"require": {
    "thunderer/monotype": "dev-master"
}
(...)
```

and run `composer install` or `composer update` afterwards.

## Usage

After creating `Thunder\Monotype\Monotype` instance just use the class API, it's easy to understand because all methods names are self-documenting and have literally no side-effects. See the listing below:

```php
$mt = new Thunder\Monotype\Monotype();

if($mt->isInteger(12) && $mt->isIntegerLikeArray(array('12', 24)))
    {
    echo "yep, it works!";
    }
if($mt->isString(null))
    {
    echo "how about... no?";
    }
```

## Internals

This library consists of only one class and its API is divided into three parts:

- strict checks for primitive types using native functions,
- loose checks taking into consideration the implicit type conversion such as numeric strings or classes with `__toString()`,
- complex checks for complex types such as strict or loose typed arrays.

## License

See LICENSE file in the main directory of this library.
