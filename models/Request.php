<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string|null $description
 * @property int $service_id
 * @property int $user_id
 * @property string|null $accept_date
 * @property int|null $status
 *
 * @property Service $service
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'service_id'], 'required'],
            [['description'], 'string'],
            [['service_id', 'user_id', 'status'], 'integer'],
            [['accept_date'], 'safe'],
            [['name', 'surname', 'patronymic'], 'string', 'max' => 255],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'description' => 'Описание изделия',
            'service_id' => 'Услуга',
            'user_id' => 'Пользователь',
            'accept_date' => 'Дата приема заказа',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return 'Принят';
            case 1:
                return 'В процессе';
            case 2:
                return 'Выполнен';
        }
    }

    public function getPrice()
    {
        return $this->service->price;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user_id = Yii::$app->user->getId();
            }
            return true;
        }
        return false;
    }
}
