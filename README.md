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

and run `composer install` or `composer update` afterwards. If you're not using Composer, then... (really, please just use it).

## Usage

Create instance by passing strategy and register array of types:

```php
use Thunder\Monotype\Strategy\AllStrategy;
use Thunder\Monotype\Type\IntegerType;
use Thunder\Monotype\Type\IntegerValueType;
use Thunder\Monotype\Type\StringType;
use Thunder\Monotype\Type\StringValueType;

$monotype = new new Thunder\Monotype\Monotype(new AllStrategy(), array(
    // ...
    new IntegerType(),
    new IntegerValueType(),
    new StringType(),
    new StringValueType(),
    // ...
    ));
```

No further steps required, please just use it:

```php
$monotype->isValid(12, array('integer')); // true
$monotype->isValid(12, array('string')); // false
$monotype->isValid('12', array('integer')); // false
$monotype->isValid('12', array('@integer')); // true
$monotype->isValid('x', array('string')); // true
$monotype->isValid(null, array('string')); // false
```

## Reference

There are several types and strategies built right into the codebase of this library:

* Strategies:

  * **All**: requires all specified tests to pass,
  * **Single**: requires only one test to pass and returns true immediately,
  * **AtLeast**: requires as many tests to pass as configured in contructor.
  
* Types (strict):
 
  * **integer**: checks `is_int()`,
  * **float**: checks `is_float()` and `is_double()`,
  * **string**: checks `is_string()`,
  * **array**: checks `is_array()`,
  * **boolean**: checks `is_bool()`,
  * **class**: compares `get_class()` result,
  * **interface**: checks whether `class_implements()` results contain given interface,
  * **callable**: checks `is_callable()`,
  * **object**: checks `is_object()`,
  * **null**: checks `is_null()`,
  * **scalar**: checks `is_scalar()`,
  * **callback**: expects callable argument to determine validation result,
  
* Types (loose)
  
  * **@integer**: runs `ctype_digit()` on variable casted to string, 
  * **@float**: matches regexp over variable casted to string,
  * **@string**: casts to string or search for `__toString()` method in objects,
  * **@array**: casts to array, checks `ArrayAccess` or converts from iterator,
  * **@boolean**: casts to bool.
  * **@class**: uses `instanceof` operator,
  
* Special Types:

  * class **AliasType**: requires instance of other type and alias in constructor, allows to register same type multiple times with custom aliases,
  * class **ArrayOfType**: requires instance of other type in constructor, its alias is inherited and postfixed with `[]`, checks for array of values matching given type.

## License

See LICENSE file in the main directory of this library.
