<?php

declare(strict_types = 1);

namespace frontend\controllers;

use TaskForce\Controllers\Task;
use yii\web\Controller;
use frontend\models\Tasks;

class TasksController extends Controller
{
    public function actionIndex(): string
    {
        $tasks = Tasks::find()->with('specialization')->where(['status' => Task::STATUS_NEW])->asArray()->all();

        return $this->render('index', ['tasks' => $tasks]);
    }
}
