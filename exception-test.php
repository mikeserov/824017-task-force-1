<?php

declare(strict_types = 1);

use TaskForce\Controllers\Task;
use TaskForce\Exceptions\GivenArgumentException;

require_once 'vendor/autoload.php';

try {
    $task = new Task(5, 4, 'прошлогоднее');
} catch (GivenArgumentException $e) {
    error_log("Передан невалидный аргумент: " . $e->getMessage()); //у меня в логе появляются иероглифы вместо русских букв..
}

try {
    $task = new Task(5, 4, 'failed');
    $task->getAvailableAction(999, 'президент');
} catch (GivenArgumentException $e) {
    error_log("Передан невалидный аргумент: " . $e->getMessage());
}
