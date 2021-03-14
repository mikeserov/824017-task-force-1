<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "specializations".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 *
 * @property Tasks[] $tasks
 * @property UserSpecialization[] $userSpecializations
 * @property Users[] $users
 */
class Specializations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specializations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'icon'], 'required'],
            [['name'], 'string', 'max' => 500],
            [['icon'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'icon' => 'Icon',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['specialization_id' => 'id']);
    }

    /**
     * Gets query for [[UserSpecializations]].
     *
     * @return \yii\db\ActiveQuery|UserSpecializationQuery
     */
    public function getUserSpecializations()
    {
        return $this->hasMany(UserSpecialization::className(), ['specialization_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('user_specialization', ['specialization_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return SpecializationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecializationsQuery(get_called_class());
    }
}
