<?php

declare(strict_types = 1);

use TaskForce\utils\CsvToSqlConverter;
//use \SplFileObject;

require_once 'vendor/autoload.php';

$converter = new CsvToSqlConverter('cats_test.csv', 'catsTable');

$converter->convert();