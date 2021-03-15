<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Users;

class UsersController extends Controller
{
    public function actionIndex(): string
    {
        $users = Users::find()->select(['users.*', 'AVG(rate) as rating', 'COUNT(rate) as finished_tasks_count', 'COUNT(comment) as comments_count'])->joinWith('reviews0')->with('specializations')->where(['role' => 'executant'])->groupBy('users.id')->orderBy(['signing_up_date' => SORT_DESC])->asArray()->all();

        return $this->render('index', ['users' => $users]);
    }
}