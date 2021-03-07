<?php

declare(strict_types = 1);

use TaskForce\utils\CsvToSqlConverter;

require_once 'vendor/autoload.php';

$converter = new CsvToSqlConverter('users_optional_settings.csv');

$converter->convert();