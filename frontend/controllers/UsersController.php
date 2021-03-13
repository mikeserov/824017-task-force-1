<?php

declare(strict_types = 1);

namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Users;


class UsersController extends Controller
{
	public function actionShowAll()
	{
		$users = Users::find()->all();
		return $this->render('show-all', ['users' => $users]);
	}

	public function actionShowUserAndHisCity($id = 5)
	{

		
		$user = Users::find()->where(['id' => $id])->with('city')->asArray()->all();
		return $this->render('show-user-and-his-city', ['user' => $user]);
	}
}