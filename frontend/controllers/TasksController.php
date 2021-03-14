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
        $tasks = Tasks::find()->innerJoinWith('specialization')->where(['status' => Task::STATUS_NEW])->asArray()->all();

        return $this->render('index', ['tasks' => $tasks]);
    }

    /*public function actionShowAll(): string
    {
        $users = Users::find()->all();

        return $this->render('show-all', ['users' => $users]);
    }

    public function actionShowUserAndHisCity(int $id = 1): string
    {
        $user = Users::find()->where(['id' => $id])->with('city')->asArray()->all();
        
        return $this->render('show-user-and-his-city', ['user' => $user]);
    }*/
}