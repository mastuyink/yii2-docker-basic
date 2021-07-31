<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string|null $image
 * @property string $auth_key
 * @property string $email
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int|null $expired_reset_token
 * @property int $status
 * @property int $create_at
 * @property int $update_at
 */
class User extends \app\models\base\ActiveRecordBase
{
    const ACTIVE    = 1;
    const INACTIVE  = 0;
    const DELETED   = 10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'email', 'password_hash', 'status'], 'required'],
            [['expired_reset_token', 'status'], 'integer'],
            [['username', 'image', 'auth_key', 'email', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'username'             => 'Username',
            'name'                 => 'Name',
            'image'                => 'Image',
            'auth_key'             => 'Auth Key',
            'email'                => 'Email',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'expired_reset_token'  => 'Expired Reset Token',
            'status'               => 'Status',
            'create_at'            => 'Create At',
            'update_at'            => 'Update At',
        ];
    }
}
