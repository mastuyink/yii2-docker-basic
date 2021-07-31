<?php
namespace app\models\user;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * Signup form
 */
class Signup extends \yii\base\Model
{
    public $name;
    public $username;
    public $email;
    public $password;
    public $retypePassword;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => UserIdentity::className(), 'message' => 'This username Already Use.'],
            [['username','name'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => UserIdentity::className(), 'message' => 'This email address Already Use.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['retypePassword', 'required'],
            ['retypePassword', 'compare', 'compareAttribute' => 'password'],

            ['status','required'],
            ['status','boolean'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user           = new UserIdentity();
            $user->name = $this->name;
            $user->username = $this->username;
            $user->email    = $this->email;
            $user->status   = $this->status;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
