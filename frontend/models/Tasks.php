<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $customer_id
 * @property int|null $executant_id
 * @property int|null $city_id
 * @property int|null $specialization_id
 * @property string $posting_date
 * @property string $status
 * @property string $name
 * @property string $description
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $payment
 * @property string|null $deadline_date
 * @property string|null $address
 *
 * @property ChatMessage[] $chatMessages
 * @property NotificationsHistory[] $notificationsHistories
 * @property Response[] $responses
 * @property Review[] $reviews
 * @property TaskHelpfulFile[] $taskHelpfulFiles
 * @property User $customer
 * @property User $executant
 * @property City $city
 * @property Specialization $specialization
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'status', 'name', 'description'], 'required'],
            [['customer_id', 'executant_id', 'city_id', 'specialization_id'], 'integer'],
            [['posting_date', 'deadline_date'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['status'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 1000],
            [['description'], 'string', 'max' => 3000],
            [['payment', 'address'], 'string', 'max' => 500],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['executant_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executant_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
            [['specialization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Specialization::className(), 'targetAttribute' => ['specialization_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'executant_id' => 'Executant ID',
            'city_id' => 'City ID',
            'specialization_id' => 'Specialization ID',
            'posting_date' => 'Posting Date',
            'status' => 'Status',
            'name' => 'Name',
            'description' => 'Description',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'payment' => 'Payment',
            'deadline_date' => 'Deadline Date',
            'address' => 'Address',
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery|ChatMessageQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[NotificationsHistories]].
     *
     * @return \yii\db\ActiveQuery|NotificationsHistoryQuery
     */
    public function getNotificationsHistories()
    {
        return $this->hasMany(NotificationsHistory::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery|ResponseQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery|ReviewQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[TaskHelpfulFiles]].
     *
     * @return \yii\db\ActiveQuery|TaskHelpfulFileQuery
     */
    public function getTaskHelpfulFiles()
    {
        return $this->hasMany(TaskHelpfulFile::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[Executant]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getExecutant()
    {
        return $this->hasOne(User::className(), ['id' => 'executant_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Specialization]].
     *
     * @return \yii\db\ActiveQuery|SpecializationQuery
     */
    public function getSpecialization()
    {
        return $this->hasOne(Specialization::className(), ['id' => 'specialization_id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }
}
