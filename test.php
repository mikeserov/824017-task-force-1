<?php
declare(strict_types = 1);
use TaskForce\controllers\Task;

require_once 'vendor/autoload.php';

$task = new Task(4, 5); //id исполнителя = 4, id заказчика = 5
echo 'текущий статус new <br><br>'; 

function myAssertHandler($file, $line, $code, $desc = null)
{
    echo "Неудачная проверка утверждения в $file, строка $line";
    if ($desc) {
        echo ": $desc <br>";
    }
    echo "<br>";
}

assert_options(ASSERT_CALLBACK, 'myAssertHandler');
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);

// перед началом использования assert установил zend.assertions = 1

// проверка метода для возврата «карты» статусов и действий
assert($task->getMappingElementValue(Task::TO_FAIL) === 'Отказаться', 'Корректное название действия на русском не получено');
assert($task->getMappingElementValue(Task::STATUS_CANCELED) === 'Отменено', 'Корректное название статуса на русском не получено');


/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'new'  */
//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert($task->getStatusCausedByAction(Task::TO_CANCEL) === Task::STATUS_CANCELED, 'корректный статус canceled не получен');
assert($task->getStatusCausedByAction(Task::TO_EXECUTE) === Task::STATUS_EXECUTING, 'корректный статус executing не получен');

//проверка получения доступного действия
assert($task->getAvailableAction(4) === Task::TO_EXECUTE, 'корректный доступное действие to execute не получено');
assert($task->getAvailableAction(1) === Task::TO_CANCEL, 'корректный доступное действие to cancel не получено');


/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Отменено'  */
echo $task->setStatus(Task::STATUS_CANCELED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is_null($task->getStatusCausedByAction(Task::TO_CANCEL)), 'корректное возвращаемое значение null не получено');
assert(is_null($task->getStatusCausedByAction(Task::TO_ACCOMPLISH)), 'корректное возвращаемое значение null не получено');

//проверка получения доступного действия
assert(is_null($task->getAvailableAction(4)), 'корректное возвращаемое значение null не получено');
assert(is_null($task->getAvailableAction(5)), 'корректное возвращаемое значение null не получено');


/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'В работе'  */
echo $task->setStatus(Task::STATUS_EXECUTING);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert($task->getStatusCausedByAction(Task::TO_ACCOMPLISH) === Task::STATUS_ACCOMPLISHED, 'корректный статус accomplished не получен');
assert($task->getStatusCausedByAction(Task::TO_FAIL) === Task::STATUS_FAILED, 'корректный статус failed не получен');

//проверка получения доступного действия
assert($task->getAvailableAction(4) === Task::TO_FAIL, 'корректный доступное действие to fail не получено');
assert($task->getAvailableAction(5) === Task::TO_ACCOMPLISH, 'корректный доступное действие to accomplish не получено');


/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Провалено'  */
echo $task->setStatus(Task::STATUS_FAILED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is_null($task->getStatusCausedByAction(Task::TO_EXECUTE)), 'корректное возвращаемое значение null не получено');
assert(is_null($task->getStatusCausedByAction(Task::TO_FAIL)), 'корректное возвращаемое значение null не получено');

//проверка получения доступного действия
assert(is_null($task->getAvailableAction(4)), 'корректное возвращаемое значение null не получено');
assert(is_null($task->getAvailableAction(5)), 'корректное возвращаемое значение null не получено');


/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Выполнено'  */
echo $task->setStatus(Task::STATUS_ACCOMPLISHED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is_null($task->getStatusCausedByAction('to eat ice-cream')), 'корректное возвращаемое значение null не получено');
assert(is_null($task->getStatusCausedByAction('to fly to the Moon')), 'корректное возвращаемое значение null не получено');

//проверка получения доступного действия
assert(is_null($task->getAvailableAction(4)), 'корректное возвращаемое значение null не получено');
assert(is_null($task->getAvailableAction(5)), 'корректное возвращаемое значение null не получено');