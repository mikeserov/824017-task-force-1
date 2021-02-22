<?php
require_once('Task.php');

$task = new Task(4, 5); //id исполнителя = 4, id заказчика = 5


// перед началом использования assert установил zend.assertions = 1
function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Неудачная проверка утверждения в $file, строка $line";
    if ($desc) {
        echo ": $desc <br>";
    }
    echo "<br>";
}

assert_options(ASSERT_CALLBACK, 'my_assert_handler');
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);

// проверка метода для возврата «карты» статусов и действий
assert($task->getMapping()['to fail'] == 'Отказаться', 'Корректное название действия на русском не получено');
assert($task->getMapping()['canceled'] == 'Отменено', 'Корректное название статуса на русском не получено');

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert($task->getStatusCausedByAction('to cancel') == Task::STATUS_CANCELED, 'корректный статус canceled не получен');
assert($task->getStatusCausedByAction('to execute') == Task::STATUS_EXECUTING, 'корректный статус executing не получен');

//проверка получения доступного действия
assert($task->getAvailableAction(4) == Task::TO_EXECUTE, 'корректный доступное действие to execute не получено');
assert($task->getAvailableAction(5) == Task::TO_CANCEL, 'корректный доступное действие to cancel не получено');

/*----------------------------------------------------------------------------------------------------------------------*/
/*  проверка методов при статусе 'Отменено'  */
$task->setStatus(Task::STATUS_CANCELED);

//проверка получения статуса, в которой перейдёт задание после выполнения указанного действия
assert(is$task->getStatusCausedByAction('to cancel') == Task::STATUS_CANCELED, 'корректный статус canceled не получен');
assert($task->getStatusCausedByAction('to execute') == Task::STATUS_EXECUTING, 'корректный статус executing не получен');

//проверка получения доступного действия
assert($task->getAvailableAction(4) == Task::TO_EXECUTE, 'корректный доступное действие to execute не получено');
assert($task->getAvailableAction(5) == Task::TO_CANCEL, 'корректный доступное действие to cancel не получено');
