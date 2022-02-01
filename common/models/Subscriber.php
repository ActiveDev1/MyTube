<?php

namespace common\models;

use common\models\query\SubscriberQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%subscriber}}".
 *
 * @property int $id
 * @property int $channel_id
 * @property int|null $user_id
 * @property int|null $created_at
 *
 * @property User $channel
 * @property User $user
 */
class Subscriber extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscriber}}';
    }

    /**
     * {@inheritdoc}
     * @return SubscriberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubscriberQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel_id'], 'required'],
            [['channel_id', 'user_id', 'created_at'], 'integer'],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['channel_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Channel]].
     *
     * @return ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(User::class, ['id' => 'channel_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
