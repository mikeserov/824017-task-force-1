<?php

declare(strict_types = 1);

use TaskForce\utils\CsvToSqlConverter;

require_once 'vendor/autoload.php';

$converter = new CsvToSqlConverter('cities.csv');

$converter->convert();