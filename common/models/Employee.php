<?php

namespace common\models;

use common\behaviors\DateTimeBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property int|null $gender
 * @property int|null $birthday
 * @property string|null $address
 * @property string|null $phone
 * @property int|null $work_start_date
 * @property int|null $user_id
 * @property int|null $position_id
 * @property int|null $status
 *
 * @property Group[] $groups
 * @property Position $position
 * @property User $user
 */
class Employee extends \yii\db\ActiveRecord
{

    const MALE = 1;
    const FEMALE = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_InACTIVE = 2;
    const STATUS_DELETE = 0;
    const ROLE_ADMIN = 1;
    const ROLE_TEACHER = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    public $password;
    public $password_confirm;
    public $username;
    public $email;
    public $avatar_id;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'birthday', 'work_start_date', 'user_id', 'position_id', 'status'], 'default', 'value' => null],
            [['gender', 'birthday', 'work_start_date', 'user_id', 'position_id', 'status', 'role'], 'integer'],
            [['password'], 'string', 'min' => 6, 'max' => 15],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            [['first_name', 'last_name', 'middle_name', 'address', 'phone', 'username', 'email'], 'string', 'max' => 255],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'start_date' => [
                'class' => DateTimeBehavior::class,
                'attribute' => 'work_start_date',
                'format' => 'd.m.Y'
            ],
            'birthday' => [
                'class' => DateTimeBehavior::class,
                'attribute' => 'birthday',
                'format' => 'd.m.Y'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'middle_name' => 'Middle Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'address' => 'Address',
            'phone' => 'Phone',
            'work_start_date' => 'Work Start Date',
            'user_id' => 'User ID',
            'position_id' => 'Position ID',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Position]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGenderList()
    {
        return [
            self::MALE => 'Erkak',
            self::FEMALE => 'Ayol',
        ];
    }
    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_InACTIVE => 'InActive',
            self::STATUS_DELETE => 'Delete',
        ];
    }

    public function getRoleList()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_TEACHER => 'Teacher',
        ];
    }

    public function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $user = new User([
                'username' => $this->username,
                'email' => $this->email,
                'status' => User::STATUS_ACTIVE,
                'role' => $this->role,
                'avatar_id' => $this->avatar_id
            ]);

            $user->generateAuthKey();
            $user->setPassword($this->password);
            $user->save();
            $this->user_id = $user->id;
        } else {
            $user = User::findOne($this->user_id);
            if (!$this->avatar_id) {
                $this->avatar_id = $user->avatar_id;
            }
            $user->updateAttributes([
                'username' => $this->username,
                'email' => $this->email,
                'avatar_id' => $this->avatar_id,
                'role' => $this->role,
            ]);

            if ($this->password) {
                $user->setPassword($this->password);
            }
            $user->save();
        }

        return parent::beforeSave($insert);
    }
}
