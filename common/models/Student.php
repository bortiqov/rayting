<?php

namespace common\models;

use common\behaviors\DateTimeBehavior;
use Yii;

/**
 * This is the model class for table "student".
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
 * @property string|null $position
 * @property int|null $status
 *
 * @property StudentGroup[] $studentGroups
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    public $password;
    public $password_confirm;
    public $username;
    public $email;
    public $avatar_id;


    const MALE = 1;
    const FEMALE = 2;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'birthday', 'work_start_date', 'user_id', 'status'], 'default', 'value' => null],
            [['gender', 'birthday', 'work_start_date', 'user_id', 'status', 'avatar_id'], 'integer'],
            [['password'], 'string', 'min' => 6, 'max' => 15],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password'],
            [['first_name', 'last_name', 'middle_name', 'address', 'phone', 'position', 'password', 'password_confirm', 'username', 'email'], 'string', 'max' => 255],
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
            'position' => 'Position',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[StudentGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentGroups()
    {
        return $this->hasMany(StudentGroup::className(), ['student_id' => 'id']);
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


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $user = new User([
                'username' => $this->username,
                'email' => $this->email,
                'status' => User::STATUS_ACTIVE,
                'role' => User::ROLE_STUDENT,
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
                'role' => User::ROLE_STUDENT
            ]);

            if ($this->password) {
                $user->setPassword($this->password);
            }
            $user->save();
        }

        return parent::beforeSave($insert);
    }
}
