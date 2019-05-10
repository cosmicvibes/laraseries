[![Total Downloads](https://poser.pugx.org/cosmicvibes/laraseries/downloads)](https://packagist.org/packages/cosmicvibes/laraseries)
[![License](https://poser.pugx.org/cosmicvibes/laraseries/license)](https://packagist.org/packages/cosmicvibes/laraseries)
[![Build Status](https://travis-ci.org/cosmicvibes/laraseries.svg?branch=master)](https://travis-ci.org/cosmicvibes/laraseries)

# Laraseries: Laravel Number Series Package

I had a business requirement to create an incrementing part number for products, that cannot be reused. E.g: first item: IN00001, next item IN00002 etc.

This package simplifies the creation of multiple number series and allows you to easily retrieve the next available number, saving the incremented value to the number series. It uses database transactions to ensure the next number is always atomic. 

## Requirements

* PHP 7.1.3+
* Laravel 5.8+

Will likely work on other versions, but is untested.

## Installation

1) Install the package by running this command in your terminal/cmd:
```
composer require cosmicvibes/laraseries dev-master
```

## Usage

Implements Laravel Eloquent models. A demo application with tests can be found at: https://github.com/cosmicvibes/laraseries-demo

First create a number series:

```
$numberSeries = new Cosmicvibes\Laraseries\NumberSeries();

$numberSeries->fill([
            'code'              => 'TEST',
            'name'              => 'Test Number Series',
            'prefix'            => 'TEST',
            'suffix'            => 'Y',
            'length'            => 10,
            'increment_by'      => 1,
            'padding_character' => 0, // Can be anything
            'start_date'        => Carbon::createFromFormat('d/m/Y', '01/01/2001'), // Can be left blank, implement checks in your own code
            'end_date'          => null, // Can be left blank, implement checks in your own code
            'active'            => true, // For your reference, implement checks in your own code
            'starting_number'   => 1, // Defaults to 0
            'ending_number'     => null, // Defaults to max possible number based on length        
]);

$numberSeries->save();
```
Or find an existing model (any eloquent commands will work, see the [Laravel documentation](https://laravel.com/docs/5.8/eloquent) for more details):
```
$numberSeries = NumberSeries::whereCode('TEST')->get()->first();
```

Retrieve the current number:
```
echo $numberSeries->current;
TEST0000000001Y
```

Advance to the next number (the function will return the new current number):
```
$currentNumber = $numberSeries->advance():
TEST0000000002Y
```
Advance by a set amount:
```
$currentNumber = $numberSeries->advance(15):
TEST00000000017Y
```

Note that if you advance past the ending number then advancing further will return null. It is recommended that you implement checking for this situation.
## Authors

* [**Charlie Pearce**](https://github.com/cosmicvibes) - *Initial work*

See also the list of [contributors](https://github.com/cosmicvibes/laraseries/graphs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Special Thanks to

* [Laravel](https://laravel.com) Community
