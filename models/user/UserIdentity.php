<?php

namespace app\models\user;

use Yii;

class UserIdentity extends \app\models\base\User implements \yii\web\IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        // return static::findOne([static::tableName().'.username'=>$username,static::tableName().'.status'=>static::ACTIVE]);
        return static::find()
                ->where(static::tableName().".username=:username or ".static::tableName().".email=:username", ['username' => $username])
                ->andWhere([static::tableName().'.status' => static::ACTIVE])
                ->one();
    }

    /**
     * Finds user by token
     *
     * @param string $token
     * @return static|null
     */
    public static function findByToken($token)
    {
        return static::findOne([static::tableName().'.password_reset_token'=>$token,static::tableName().'.status'=>static::ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }



    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        return $this->auth_key = Yii::$app->security->generateRandomString(50);
    }

    public function changePassword()
    {
        if ($this->validate()) {
            if(isset($this->password) && $this->password != ''){
                $this->setPassword($this->password);
                $this->generateAuthKey();
            }
            $this->save(false);
            
            return true;
        }else{
            return false;
        }
    }
}
