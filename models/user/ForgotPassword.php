<?php

namespace app\models\user;

use app\components\email\Mailing;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * ForgotPassword is the model behind the forgot password form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ForgotPassword extends Model
{
    public $email;
    public $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email Address',
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function sendEmailForgot()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if(isset($user)){
                //SNED EMAIL HERE
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserIdentity::findByUsername($this->email);
        }
        
        return $this->_user;
    }
}
