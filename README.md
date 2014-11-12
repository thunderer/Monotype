# Monotype

Monotype is a small utility library to check if given variable matches specific type requirements. PHP is known for its issues with [variable type comparison mechanics](http://php.net/manual/en/types.comparisons.php) so why don't reduce the pain of developers with some useful code?

## Requirements

PHP 5.3 (for namespaces), nothing fancy.

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
