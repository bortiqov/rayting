<?php

namespace common\modules\transaction\models;

use common\models\Course;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $transaction_id
 * @property int|null $time
 * @property int|null $created_at
 * @property int|null $perform_at
 * @property int|null $cancel_at
 * @property int|null $amount
 * @property int|null $state
 * @property int|null $reason
 * @property int|null $user_id
 *
 * @property PaymentHistory[] $paymentHistories
 * @property User $user
 * @property UserTariff[] $userTariffs
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time', 'created_at', 'perform_at', 'cancel_at', 'amount', 'state', 'reason', 'user_id'], 'default', 'value' => null],
            [['time', 'created_at', 'perform_at', 'cancel_at', 'amount', 'state', 'reason', 'user_id', 'course_id'], 'integer'],
            [['transaction_id'], 'string', 'max' => 25],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'time' => 'Time',
            'created_at' => 'Created At',
            'perform_at' => 'Perform At',
            'cancel_at' => 'Cancel At',
            'amount' => 'Amount',
            'state' => 'State',
            'reason' => 'Reason',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[PaymentHistories]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\transaction\models\query\PaymentHistoryQuery
     */
    public function getPaymentHistories()
    {
        return $this->hasMany(PaymentHistory::className(), ['transaction_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\transaction\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[UserTariffs]].
     *
     * @return \yii\db\ActiveQuery|\common\modules\transaction\models\query\UserTariffQuery
     */
    public function getUserTariffs()
    {
        return $this->hasMany(UserTariff::className(), ['transaction_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\modules\transaction\models\query\TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\modules\transaction\models\query\TransactionQuery(get_called_class());
    }

    public static function getDropDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'id');
    }

    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }
}
